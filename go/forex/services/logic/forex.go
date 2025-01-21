package logic

import (
	"errors"
	"forex/conf"
	apiws "forex/services/api/ws"
	"forex/services/model"
	accountmodel "forex/services/model/forexaccountmodel"
	"forex/services/tools"
	log "github.com/sirupsen/logrus"
	"gorm.io/gorm"
	"gorm.io/gorm/clause"
	"sync"
	"time"
)

// ForexClose 平仓 建议使用DB传入，DB状态是开启事物状态，否则可能导致数据不一致
func ForexClose(db *gorm.DB, order *model.ForexTransactions, closedType int) error {

	quotation := model.ForexQuotations{}
	//获取行情不使用上锁db
	model.DB.Where("forex_id = ?", order.ForexId).First(&quotation)
	if quotation.Close == 0 {

		return errors.New("暂时无法获取到报价")
	}
	nowTime := time.Now().Unix()
	order.UpdatePrice = quotation.Close
	order.UpdateTime = nowTime
	order.Status = model.ForexStatusClosing
	order.HandleTime = nowTime

	//锁仓时的最终盈亏
	order.FactProfits = model.GetProfitByOne(*order)

	result := db.Where("id = ?", order.Id).Updates(model.ForexTransactions{
		UpdatePrice: quotation.Close,
		UpdateTime:  nowTime,
		Status:      model.ForexStatusClosing,
		HandleTime:  nowTime,
		FactProfits: order.FactProfits,
	}).RowsAffected

	if result == 0 {

		return errors.New("平仓失败:锁定交易状态失败")
	}

	//查找结算账户和剩余可用金额
	account, err := accountmodel.NewForexAccount(db).GetAccount(order.UserId)
	if err != nil {

		return errors.New("当前状态无法获取到钱包")
	}

	//算上本金
	change := tools.Decimal(order.CautionMoney+order.FactProfits, "%.8f")

	//从钱包处理资金
	preResult := account.Balance + change

	logType := accountmodel.ForexTransAdd

	if preResult < 0 {
		logType = accountmodel.ForexTransFrozen
	}
	err = account.ChangeBalance(logType, change)

	if err != nil {
		return err
	}
	order.Status = model.ForexStatusClosed
	order.CompleteTime = time.Now().Unix()
	order.ClosedType = closedType
	result = db.Where("id = ?", order.Id).Updates(model.ForexTransactions{
		Status:       model.ForexStatusClosed,
		CompleteTime: time.Now().Unix(),
		ClosedType:   closedType,
	}).RowsAffected

	if result == 0 {

		return errors.New("平仓失败:更新处理状态失败")
	}

	return nil
}

// EntrustActivate 激活委托
func EntrustActivate() {
	/*
	   逻辑:分析师认为当价格走到某个区间后会停止,然后逆向走,在停止时期进行反向投资来赚取利润
	   例如:
	   (1)用户认为某个币在指定周期内跌到5元已跌到谷底不可能再跌了,预测接下来行情会上涨,那应该设定在跌到5元时进行买入,等行情上涨赚钱
	   (2)用户认为某个币在指定周期内涨到1000元已经达到顶峰,预测接下来行情会下跌,那应该设定在涨到1000元时进行卖出,等行情下跌赚钱
	   程序逻辑:
	   (1)卖出:当前价格 [大于等于] 设置价格时触发(等涨到指定价格时卖出坐等下跌)
	   (2)买入:当前价格 [小于等于] 设置价格时触发(等跌到指定价格时买入坐等上涨)
	*/
	whereSql := "status = ? and ((order_type = ? and `update_price` <= `origin_price`)or (order_type = ? and `update_price` >= `origin_price`))"
	var ids []int

	transModel := model.DB.Model(model.ForexTransactions{})
	transModel.Where(whereSql, model.ForexStatusEntrust, model.ForexWayBuy, model.ForexWaySell).Pluck("id", &ids)

	if len(ids) > 0 {

		transModel.Where("id in ?", ids).Updates(model.ForexTransactions{
			TransactionTime: time.Now().Unix(),
			Status:          model.ForexStatusTransaction,
		})
	}

}

// CheckNeedStopPriceTrade 止盈止损处理
func CheckNeedStopPriceTrade() {

	/**
	 * 关于止盈止亏：
	 * 1.买入:当前行情价格【大于等于】“止盈价”时，触发止盈;当前行情价格【小于等于】“止亏价”时，触发止亏;
	 * 2.买入:当前行情价格【小于等于】“止盈价”时，触发止盈;当前行情价格【大于等于】“止亏价”时，触发止亏;
	 */

	checkBuySql := "(`order_type` = ? and ((`update_price` >= `target_profit_price` and `target_profit_price` > 0) or (`update_price` <= `target_loss_price` and `target_loss_price` > 0)))"

	checkSellSql := " or (`order_type` = ? and ((`update_price` <= `target_profit_price` and `target_profit_price` > 0) or (`update_price` >= `target_loss_price` and `target_loss_price` > 0)))"

	var results []model.ForexTransactions

	model.DB.Select([]string{
		"id",
		"quantity",
		"update_price",
		"target_profit_price",
		"target_loss_price",
		"price",
		"origin_price",
		"forex_cont_num",
		"order_type",
	}).Where("status = ?", model.ForexStatusTransaction).Where(checkBuySql+checkSellSql, model.ForexWayBuy, model.ForexWaySell).Find(&results)

	for _, result := range results {
		update := make(map[string]interface{})
		//锁仓时的最终盈亏
		result.FactProfits = model.GetProfitByOne(result)
		if result.FactProfits > 0 {

			update["closed_type"] = model.ForexCloseByTargetProfit
			update["update_price"] = result.TargetProfitPrice
		} else {

			update["closed_type"] = model.ForexCloseByStopLoss
			update["update_price"] = result.TargetLossPrice
		}
		//fmt.Println(result.Id)
		//result.Status = model.ForexStatusClosing
		//result.HandleTime = time.Now().Unix()
		update["status"] = model.ForexStatusClosing
		update["handle_time"] = time.Now().Unix()
		//model.DB.Model(model.ForexTransactions{}).Where("id = ?", result.Id).Updates(&update)

		model.DB.Model(model.ForexTransactions{}).Where("id = ?", result.Id).Updates(update)
	}

}

// RunCheckNeedBurst 查找爆仓用户
func RunCheckNeedBurst() {
	hr := new(model.Settings).ForexBurstHazardRate()
	//循环处理，避免出现sync锁竞争
	for {

		time.Sleep(1 * time.Second)

		//查找需要平仓的订单
		CheckBurst(hr)
		//
		//log.Debug("根据订单查找爆仓用户")
	}
}

// RunCheckNeedClosingOrder 查找需要平仓的订单
func RunCheckNeedClosingOrder() {

	//循环处理，避免出现sync锁竞争
	for {

		time.Sleep(1 * time.Second)
		//log.Debug("查找等待平仓订单")
		//查找需要平仓的订单
		CheckNeedClosingOrder()

	}
}

// CheckNeedClosingOrder 查找需要平仓的订单 , 每次处理10条订单
func CheckNeedClosingOrder() {

	var results []model.ForexTransactions

	//上锁查询
	model.DB.Clauses(clause.Locking{Strength: "UPDATE"}).Where("status = ?", model.ForexStatusClosing).Limit(10).Find(&results)

	//等待全部执行完成，再结束
	var wg sync.WaitGroup

	for _, order := range results {

		go func(order model.ForexTransactions) {
			wg.Add(1)

			defer wg.Done()

			tx := model.DB.Begin()

			defer func(db *gorm.DB) {
				db.Rollback()
			}(tx)
			order.FactProfits = model.GetProfitByOne(order)
			//查找结算账户和剩余可用金额
			account, err := accountmodel.NewForexAccount(tx).GetAccount(order.UserId)
			if err != nil {

				log.Error("当前状态无法获取到钱包")
				tx.Rollback()
				return
			}

			//算上本金
			change := tools.Decimal(order.CautionMoney+order.FactProfits, "%.8f")

			//从钱包处理资金
			preResult := account.Balance + change

			var logType [2]interface{}
			switch order.OrderType {

			case model.ForexCloseByOutOfMoney:
				logType = accountmodel.ForexTransFrozen
				break
			default:
				logType = accountmodel.ForexTransAdd

			}

			if preResult < 0 {
				logType = accountmodel.ForexTransFrozen
			}

			if conf.Config.GetInt("basic.whether_settle_negative") == 1 && preResult <= 0 {

				change = account.Balance * -1
			}

			err = account.CloseOrderChangeBalance(logType, change)

			if err != nil {
				log.Error(err.Error())
				tx.Rollback()
				return
			}

			row := tx.Where("id = ?", order.Id).Updates(model.ForexTransactions{
				FactProfits:  order.FactProfits,
				Status:       model.ForexStatusClosed,
				CompleteTime: time.Now().Unix(),
			}).RowsAffected

			if row < 0 {
				log.Error("平仓失败,请看代码详细debug")
				tx.Rollback()
				return
			}
			tx.Commit()

			//推送平仓订单id
			apiws.PushClosedTrade(order.UserId, []int64{
				order.Id,
			})

		}(order)

	}

	wg.Wait()
}

// CheckBurst 检查是否爆仓
func CheckBurst(setHazardRate float64) {

	var userIds []int64
	db := model.DB

	db.Model(model.ForexTransactions{}).Where("status = ?", model.ForexStatusTransaction).Group("user_id").Pluck("user_id", &userIds)

	//等待全部执行完成，再结束
	var wg sync.WaitGroup

	for _, userId := range userIds {

		go func(userId int64) {

			wg.Add(1)

			defer wg.Done()

			//取盈亏总额
			userProfit := model.GetUserProfit(userId, 0)

			//查找结算账户和剩余可用金额
			account, err := accountmodel.NewForexAccount(db).GetAccount(userId)
			if err != nil {
				account.Balance = 0
			}

			//取风险率
			hazardRate := model.GetAccountHazardRate(userProfit, account.Balance)
			if hazardRate <= setHazardRate {

				update := make(map[string]interface{})

				update["closed_type"] = model.ForexCloseByOutOfMoney
				update["status"] = model.ForexStatusClosing
				update["handle_time"] = time.Now().Unix()

				model.DB.Model(model.ForexTransactions{}).Where("status = ?", model.ForexStatusTransaction).Where("user_id = ?", userId).Updates(update)

			}

		}(userId)

	}
	wg.Wait()
}
