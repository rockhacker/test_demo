package forex

import (
	"bufio"
	"encoding/json"
	"fmt"
	"forex/commands/mtQuote"
	"forex/commands/mtserver"
	"forex/conf"
	apiws "forex/services/api/ws"
	"forex/services/logic"
	"forex/services/market"
	"forex/services/model"
	changeAccount "forex/services/model/changeaccountmodel"
	accountmodel "forex/services/model/forexaccountmodel"
	"forex/services/tools"
	ginI18n "github.com/gin-contrib/i18n"
	"github.com/gin-gonic/gin"
	"github.com/golang-module/carbon/v2"
	"gorm.io/gorm"
	"gorm.io/gorm/clause"
	"math"
	"net"
	"strconv"
	"strings"
	"time"
)

func GetMtKlineV2(c *gin.Context) {

	getConf := conf.Config.Get("MT4Server").(map[string]interface{})

	if conf.Config.GetString("MT4Server.version") != "2.0.0" {

		tools.Response(c, 0, "该接口只支持MT5连接时可用", nil)
		c.Abort()
		return
	}

	//获取的天数
	getDayNum, _ := strconv.ParseInt(c.DefaultQuery("getDayNum", "1"), 10, 64)
	symbol := c.DefaultQuery("symbol", "")

	if getDayNum > 60 {

		tools.Response(c, 0, "最多获取60天的数据", nil)
		c.Abort()
		return
	}

	if symbol == "" {
		tools.Response(c, 0, "币种不能为空", nil)
		c.Abort()
		return
	}

	tcpAddr, _ := net.ResolveTCPAddr(getConf["network"].(string), getConf["network_addr"].(string))

	conn, err := net.DialTCP(getConf["network"].(string), nil, tcpAddr)

	if err != nil {
		tools.Response(c, 0, "连接MT出错", nil)
		c.Abort()
		return

	}

	requestData := map[string]interface{}{
		"Cmd":             "symbolsKprice_get",
		"TradeSymbol":     symbol,
		"ChartPeriodType": 1,
		//"ChartStart":      carbon.Now(carbon.PRC).Timestamp() - (86400 * 60),
		"ChartStart": carbon.Now(carbon.PRC).Timestamp() - (86400 * getDayNum),
		//"ChartEnd":   carbon.Now(carbon.PRC).Timestamp() + market.TimeOffset,
		"ChartEnd": 0,
	}

	s := mtserver.BuildData(requestData)
	fmt.Println(string(s))
	_, _ = conn.Write(s)

	scanner := bufio.NewScanner(conn)
	scanner.Buffer(make([]byte, 1024*1024*30), 1024*1024*30)

	type Quote struct {
		Quote []market.KLine `json:"Quote"`
	}

	type MtMsg struct {
		RspStatus  int                    `json:"Rsp_status"`
		RspData    map[string]interface{} `json:"Rsp_Data"`
		RspTime    int                    `json:"Rsp_Time"`
		RspDesc    string                 `json:"Rsp_Desc"`
		RspInfo    Quote                  `json:"Rsp_Info"`
		RspVersion string                 `json:"Rsp_Version"`
	}

	var data MtMsg

	for scanner.Scan() {

		msg := scanner.Text()

		if len(msg) > 10 {

			// Remove "and" from the string
			str := strings.ReplaceAll(msg, "and", "")
			str = strings.ReplaceAll(str, "\n", "")
			str = strings.ReplaceAll(str, "\r", "")
			fmt.Println(str)
			_ = json.Unmarshal([]byte(str), &data)
			_ = conn.Close()
			break
		}

	}

	kLines := data.RspInfo

	rep := map[int64][]market.KLine{}

	for _, min := range mtQuote.PeriodsMin {

		rep[min] = market.MergeKLinesV2(kLines.Quote, time.Duration(min)*time.Minute)
	}

	tools.Response(c, 1, "获取成功", rep)
	c.Abort()
	return
}

// TradeList 获取支持的外汇币种
func TradeList(c *gin.Context) {

	var lists []model.ForexTradeLists

	model.DB.Where("trade_status = ?", model.ForexTradeOn).Preload("HasForexMultiple", func(db *gorm.DB) *gorm.DB {

		return db.Order("forex_multiples.value ASC")
	}).Preload("ForexQuotations").Order("sort desc").Find(&lists)

	for k, v := range lists {

		lists[k].MarketStatus = v.CheckMarketStatus()
		lists[k].LastPrice = strconv.FormatFloat(v.ForexQuotations.Close, 'f', -1, 64)
	}

	tools.Response(c, 1, "获取成功", lists)

	c.Abort()
}

func Kline(c *gin.Context) {

	forexId := c.DefaultQuery("forex_id", "0")
	period := c.DefaultQuery("period", mtQuote.Periods[0])
	//size := c.DefaultQuery("size", strconv.Itoa(apiws.KlineSize))

	forex := model.ForexTradeLists{}
	model.DB.First(&forex, forexId)

	if forex.Id == 0 {
		tools.Response(c, 0, "交易对不存在", nil)
		c.Abort()
		return
	}
	//parseSize, _ := strconv.ParseInt(size, 10, 64)
	data := market.GetKline(period, forex.Code)

	tools.Response(c, 1, "获取成功", data)

	c.Abort()
}

func Submit(c *gin.Context) {

	forexId := c.DefaultQuery("forex_id", "0")                                            //品种id
	orderType, _ := strconv.Atoi(c.DefaultQuery("type", strconv.Itoa(model.ForexWayBuy))) //方向
	multiple := c.DefaultQuery("multiple", "0")                                           //倍数
	cont, _ := strconv.ParseFloat(c.DefaultQuery("cont", "0"), 64)                        //张数
	targetPrice, _ := strconv.ParseFloat(c.DefaultQuery("target_price", "0"), 64)         //目标价格
	status, _ := strconv.Atoi(c.DefaultQuery("status", strconv.Itoa(model.ForexStatusTransaction)))
	forex := model.ForexTradeLists{}
	user := model.Users{}

	nowTime := time.Now()
	model.DB.First(&forex, forexId)

	if forex.Id == 0 {
		tools.Response(c, 0, "指定交易对不存在", nil)
		c.Abort()
		return
	}
	if forex.TradeStatus == model.ForexTradeOff {

		tools.Response(c, 0, "该交易兑暂时无法交易", nil)
		c.Abort()
		return
	}

	if forex.CheckMarketStatus() == 2 {

		tools.Response(c, 0, "休市状态无法操作", nil)
		c.Abort()
		return
	}

	userId := model.GetUserId(c)

	if userId == 0 {
		tools.Response(c, 0, "用户不存在", nil)
		c.Abort()
		return
	}
	model.DB.First(&user, userId)

	if user.TxStatus == model.UserLock {

		tools.Response(c, 0, "禁止交易", nil)
		c.Abort()
		return
	}

	//判断每张数量是不是整数或大于等于0
	if cont <= 0 || math.Trunc(cont) != cont {
		tools.Response(c, 0, "订单数量必须是整数且大于等于0", nil)
		c.Abort()
		return
	}

	if forex.ForexMinCont > cont {

		tools.Response(c, 0, "订单数量不能低于:"+strconv.FormatFloat(cont, 'f', -1, 32), nil)
		c.Abort()
		return
	}
	if forex.ForexMaxCont < cont {

		tools.Response(c, 0, "订单数量不能高于:"+strconv.FormatFloat(cont, 'f', -1, 32), nil)
		c.Abort()
		return
	}

	//倍数判断
	mut := model.ForexMultiple{}
	model.DB.Where("value = ?", multiple).First(&mut)

	if mut.Id == 0 {

		tools.Response(c, 0, "不支持该倍数", nil)
		c.Abort()
		return
	}
	checkTrans := model.ForexTransactions{}
	model.DB.Where("user_id = ?", userId).Where("status = ?", model.ForexStatusClosing).First(&checkTrans)

	if checkTrans.Id != 0 {

		tools.Response(c, 0, "您当前有正在平仓中的交易,暂不能进行买卖", nil)
		c.Abort()
		return
	}

	if status != model.ForexStatusTransaction && status != model.ForexStatusEntrust {
		tools.Response(c, 0, "交易类型错误", nil)
		c.Abort()
		return
	}

	//判断是否委托交易 (限价交易)
	if status == model.ForexStatusEntrust && targetPrice <= 0 {

		tools.Response(c, 0, "限价交易价格必须大于0", nil)
		c.Abort()
		return
	}
	//获取价格
	quote := new(model.ForexQuotations).GetOne(forex.Id)
	lastPrice := quote.Close
	if lastPrice == 0 {
		tools.Response(c, 0, "暂无最新价格,请稍后重试", nil)
		c.Abort()
		return
	}

	if quote.NowTime.Unix() >= nowTime.Add(time.Second*60).Unix() {
		tools.Response(c, 0, "报价已过期请等待最新报价", nil)
		c.Abort()
		return
	}

	if orderType != model.ForexWayBuy && orderType != model.ForexWaySell {

		tools.Response(c, 0, "订单方向错误", nil)
		c.Abort()
		return
	}

	//原始价格
	var originPrice float64
	//最终成交价格
	var factPrice float64
	//手续费
	var transFee float64
	//保证金
	var cautionMoney float64

	if status == model.ForexStatusEntrust {
		if orderType == model.ForexWaySell && targetPrice <= lastPrice {

			tools.Response(c, 0, "限价交易卖出不能低于当前价", nil)
			c.Abort()
			return
		} else if orderType == model.ForexWayBuy && targetPrice >= lastPrice {

			tools.Response(c, 0, "限价交易买入价格不能高于当前价", nil)
			c.Abort()
			return
		}
		originPrice = targetPrice
	} else {

		originPrice = lastPrice
	}

	//计算点差率
	spread := forex.ForexPointRate
	spreadPrice := originPrice * spread

	fmt.Println(forex.ForexPointRate, spreadPrice)
	//买入应加上点差,卖出就减去点差
	if orderType == model.ForexWaySell {

		spreadPrice *= -1
	}
	factPrice = originPrice + spreadPrice

	fmt.Println(factPrice)
	//计算保证金
	allMoney := float64(forex.ForexContNum) * factPrice * cont
	cautionMoney = allMoney / float64(mut.Value)

	//计算手续费
	forexTransFeeRate := forex.ForexFeeRate
	transFee = tools.Decimal(cautionMoney*forexTransFeeRate, "%.6f")

	//应扣金额
	deductMoney := tools.Decimal(cautionMoney+transFee, "%.6f")

	if deductMoney <= 0 {

		tools.Response(c, 0, "交易金额过小被拒绝", nil)
		c.Abort()
		return
	}

	settleCurrency := model.ForexSettleCurrency{}

	model.DB.Where("settle_status = 1").First(&settleCurrency)
	if settleCurrency.Id == 0 {

		tools.Response(c, 0, "结算货币获取失败", nil)
		c.Abort()
		return
	}

	{
		//开启事物
		tx := model.DB.Begin()

		//扣款并下单
		account, err := accountmodel.NewForexAccount(tx).GetAccount(userId)
		if err != nil {
			tools.Response(c, 0, err.Error(), nil)
			c.Abort()
			tx.Rollback()
			return
		}

		if account.Balance < deductMoney {
			tools.Response(c, 0, "下单余额不足", map[string]interface{}{
				"should_deduct": deductMoney,
				"trade_fee":     transFee,
			})
			c.Abort()
			tx.Rollback()
			return
		}

		//下单
		forexData := model.ForexTransactions{}
		forexData.UserId = userId
		forexData.ForexId = forex.Id
		forexData.OrderType = orderType
		forexData.CreateTime = nowTime.Unix()
		forexData.TransactionTime = nowTime.Unix()
		forexData.AgentPath = user.AgentPath
		forexData.CautionMoney = cautionMoney
		forexData.OriginCautionMoney = cautionMoney
		forexData.FactProfits = 0
		forexData.Multiple = mut.Value
		forexData.OriginPrice = originPrice
		forexData.Price = factPrice
		forexData.TargetLossPrice = 0
		forexData.TargetProfitPrice = 0
		forexData.TradeFee = transFee
		forexData.UpdatePrice = lastPrice
		forexData.SettleCurrencyId = settleCurrency.Id
		forexData.Quantity = cont
		forexData.ForexContNum = forex.ForexContNum
		forexData.Status = status

		tx.Create(&forexData)

		//扣除保证金
		err = account.ChangeBalance(accountmodel.ForexCaution, -cautionMoney)
		if err != nil {
			tools.Response(c, 0, err.Error(), nil)
			c.Abort()
			tx.Rollback()
			return
		}

		//扣除手续费
		err = account.ChangeBalance(accountmodel.ForexTransFee, -transFee)
		if err != nil {
			tools.Response(c, 0, err.Error(), nil)
			c.Abort()
			tx.Rollback()
			return
		}

		tx.Commit()

		tools.Response(c, 1, "已提交下单请求", forexData)
		c.Abort()
		return
	}

}

func SetStopPrice(c *gin.Context) {
	id, _ := strconv.Atoi(c.DefaultQuery("id", "0"))
	targetProfitPrice, _ := strconv.ParseFloat(c.DefaultQuery("target_profit_price", "0"), 64) //止盈价格
	stopLossPrice, _ := strconv.ParseFloat(c.DefaultQuery("stop_loss_price", "0"), 64)         //止损价格

	if targetProfitPrice <= 0 || stopLossPrice <= 0 {

		tools.Response(c, 0, "设置止盈止损价格不能小于或等于0", nil)
		c.Abort()
		return
	}

	userId := model.GetUserId(c)
	trans := model.ForexTransactions{}
	model.DB.Where(
		"user_id = ?", userId,
	).Where(
		"status = ? and id = ?",
		model.ForexStatusTransaction,
		id,
	).First(&trans)

	if trans.Id == 0 {

		tools.Response(c, 0, "找不到该笔交易", nil)
		c.Abort()
		return
	}

	if trans.OrderType == model.ForexWayBuy {
		//买入/买涨方向
		if targetProfitPrice <= trans.Price || targetProfitPrice <= trans.UpdatePrice {
			tools.Response(c, 0, "买入(做多)止盈价不能低于开仓价和当前价", nil)
			c.Abort()
			return
		}
		if stopLossPrice >= trans.Price || stopLossPrice >= trans.UpdatePrice {
			tools.Response(c, 0, "买入(做多)止损价不能高于开仓价和当前价", nil)
			c.Abort()
			return
		}
	} else {
		//卖出/做空方向
		if targetProfitPrice >= trans.Price || targetProfitPrice >= trans.UpdatePrice {
			tools.Response(c, 0, "卖出(做空)止盈价不能高于开仓价和当前价", nil)
			c.Abort()
			return
		}
		if stopLossPrice <= trans.Price || stopLossPrice <= trans.UpdatePrice {
			tools.Response(c, 0, "卖出(做空)止损价不能低于开仓价和当前价", nil)
			c.Abort()
			return
		}
	}
	data := map[string]interface{}{
		"target_profit_price": targetProfitPrice,
		"target_loss_price":   stopLossPrice,
	}
	model.DB.Model(trans).Where("id = ? and user_id = ?", id, userId).Updates(data)
	tools.Response(c, 1, "设置成功", data)
	c.Abort()
	return
}

// Deal 取交易信息
func Deal(c *gin.Context) {
	forexId, ok := c.GetQuery("forex_id")

	if !ok {
		tools.Response(c, 0, "参数错误", nil)
		c.Abort()
		return
	}
	userId := model.GetUserId(c)

	forex := model.ForexTradeLists{}

	model.DB.First(&forex, forexId)

	if forex.Id == 0 {
		tools.Response(c, 0, "指定交易对不存在", nil)
		c.Abort()
		return
	}

	//最大最小张数
	forexContLimit := map[string]interface{}{
		"min": forex.ForexMinCont,
		"max": forex.ForexMaxCont,
	}

	quotation := model.ForexQuotations{}
	model.DB.Where("forex_id = ?", forexId).First(&quotation)

	var myTrans []model.ForexTransactions
	model.DB.Where(
		"forex_id = ? and user_id = ? and status = ?",
		forexId,
		userId,
		model.ForexStatusTransaction,
	).Limit(10).Order("id DESC").Find(&myTrans)

	account := new(accountmodel.Accounts)
	account, err := accountmodel.NewForexAccount(model.DB).GetAccount(userId)
	if err != nil {
		account.Balance = 0
	}

	settleCurrency := model.ForexSettleCurrency{}

	model.DB.Where("settle_status = 1").First(&settleCurrency)
	if settleCurrency.Id == 0 {

		tools.Response(c, 0, "结算货币获取失败", nil)
		c.Abort()
		return
	}

	tools.Response(c, 1, "获取成功", map[string]interface{}{
		"forex_cont_limit":     forexContLimit,              //最大最小张数
		"quotation":            quotation,                   //行情数据
		"my_transaction":       myTrans,                     //订单
		"last_price":           quotation.Close,             //最新价格
		"forex_user_balance":   account.Balance,             //余额
		"settle_currency_code": settleCurrency.CurrencyName, //结算货币
	})
	c.Abort()
	return
}

func DealAll(c *gin.Context) {

	forexId, ok := c.GetQuery("forex_id")
	limit, _ := strconv.Atoi(c.DefaultQuery("limit", "10"))
	page, _ := strconv.Atoi(c.DefaultQuery("page", "1"))

	if !ok {
		tools.Response(c, 0, "参数错误", nil)
		c.Abort()
		return
	}
	userId := model.GetUserId(c)

	forex := model.ForexTradeLists{}

	model.DB.First(&forex, forexId)

	if forex.Id == 0 {
		tools.Response(c, 0, "指定交易对不存在", nil)
		c.Abort()
		return
	}
	//分页
	offset := (page - 1) * limit

	var myTrans []model.ForexTransactions
	model.DB.Where(
		"forex_id = ? and user_id = ? and status = ?",
		forexId,
		userId,
		model.ForexStatusTransaction,
	).Preload("ForexTradeLists").Offset(offset).Limit(limit).Order("id DESC").Find(&myTrans)

	//订单总数
	var total int64
	model.DB.Model(model.ForexTransactions{}).Where(
		"forex_id = ? and user_id = ? and status = ?",
		forexId,
		userId,
		model.ForexStatusTransaction,
	).Count(&total)

	//取盈亏总额
	userProfit := model.GetUserProfit(userId, 0)

	//取该交易对盈亏总额
	userAllProfit := model.GetUserProfit(userId, forex.Id)

	//查找结算账户和剩余可用金额
	account, err := accountmodel.NewForexAccount(model.DB).GetAccount(userId)

	if err != nil {
		account.Balance = 0
	}

	//取风险率
	hazardRate := model.GetAccountHazardRate(userProfit, account.Balance)

	tools.Response(c, 1, "获取成功", map[string]interface{}{
		"caution_money_total":        userProfit.CautionMoneyTotal,          //保证金总数
		"origin_caution_money_total": userProfit.OriginCautionMoneyTotal,    //
		"profits_total":              userProfit.ProfitsTotal,               //盈亏总数
		"caution_money":              userAllProfit.CautionMoneyTotal,       //该交易对保证金
		"origin_caution_money":       userAllProfit.OriginCautionMoneyTotal, //该交易对保证金
		"profits":                    userAllProfit.ProfitsTotal,            //该交易对盈亏
		"hazard_rate":                hazardRate,                            //风险率
		"balance":                    account.Balance,                       //可用金额
		"order": map[string]interface{}{
			"data":          myTrans,
			"currency_page": page,
			"total":         total,
		}, //当前交易对在场订单
	})
	c.Abort()
	return
}

func MyDeal(c *gin.Context) {

	forexId := c.DefaultQuery("forex_id", "-1")

	status := c.DefaultQuery("status", "-1")

	limit, _ := strconv.Atoi(c.DefaultQuery("limit", "10"))
	page, _ := strconv.Atoi(c.DefaultQuery("page", "1"))

	userId := model.GetUserId(c)

	//分页
	offset := (page - 1) * limit

	var myTrans []model.ForexTransactions

	w := map[string]interface{}{
		"user_id": userId,
	}
	if forexId != "-1" {

		w["forex_id"] = forexId
	}
	if status != "-1" {

		w["status"] = status
	}
	model.DB.Where(w).Preload("ForexTradeLists").Offset(offset).Limit(limit).Order("id DESC").Find(&myTrans)

	//查找结算账户和剩余可用金额
	account, err := accountmodel.NewForexAccount(model.DB).GetAccount(userId)
	if err != nil {
		account.Balance = 0
	}

	//订单总数
	var total int64
	model.DB.Model(model.ForexTransactions{}).Where(w).Count(&total)

	tools.Response(c, 1, "获取成功", map[string]interface{}{
		"data":          myTrans,
		"balance":       account.Balance,
		"currency_page": page,
		"total":         total,
	})
	c.Abort()
	return
}

func Close(c *gin.Context) {
	id, _ := strconv.Atoi(c.DefaultQuery("id", "0"))

	if id <= 0 {
		tools.Response(c, 0, "参数错误", nil)
		c.Abort()
		return
	}
	userId := model.GetUserId(c)
	order := model.ForexTransactions{}
	//forex := model.ForexTradeLists{}

	tx := model.DB.Begin()

	//model.DB.Where("id = ?", order.ForexId).First(&forex)
	//
	//if forex.Id == 0 {
	//
	//	tools.Response(c, 0, "交易对已关闭", nil)
	//	tx.Rollback()
	//	c.Abort()
	//	return
	//}
	//if forex.CheckMarketStatus() == 2 {
	//
	//	tools.Response(c, 0, "休市状态无法操作", nil)
	//	tx.Rollback()
	//	c.Abort()
	//	return
	//}
	//上锁查询
	tx.Clauses(clause.Locking{Strength: "UPDATE"}).Where("user_id = ?", userId).First(&order, id)

	if order.Id == 0 {

		tools.Response(c, 0, "数据未找到", nil)
		c.Abort()
		tx.Rollback()
		return
	}

	if order.Status != model.ForexStatusTransaction {

		tools.Response(c, 0, "交易状态异常,请勿重复提交", nil)
		c.Abort()
		tx.Rollback()
		return
	}

	err := logic.ForexClose(tx, &order, model.ForexCloseByUserSelf)
	if err != nil {

		tools.Response(c, 0, err.Error(), nil)
		c.Abort()
		tx.Rollback()
		return
	}

	//推送平仓订单id
	apiws.PushClosedTrade(order.UserId, []int64{
		order.Id,
	})

	tx.Commit()
	tools.Response(c, 1, "操作成功", order)
	c.Abort()
	return

}

func BatchCloseByType(c *gin.Context) {

	forexId := c.DefaultQuery("forex_id", "-1")

	//0.所有,1.买入(做多),2.卖出(做空)
	t, _ := strconv.Atoi(c.DefaultQuery("type", "0"))
	if t != 0 && t != model.ForexWayBuy && t != model.ForexWaySell {

		tools.Response(c, 0, "买入方向传参错误", nil)
		c.Abort()
		return
	}
	userId := model.GetUserId(c)
	var ids []int

	where := map[string]interface{}{
		"status":  model.ForexStatusTransaction,
		"user_id": userId,
	}

	if t != 0 {
		where["order_type"] = t
	}

	if forexId != "-1" {
		where["forex_id"] = forexId
	}

	model.DB.Model(&model.ForexTransactions{}).Where(where).Pluck("id", &ids)

	taskAff := model.DB.Model(&model.ForexTransactions{}).Where("status = ?", model.ForexStatusTransaction).
		Where("id IN ?", ids).Updates(map[string]interface{}{
		"status":      model.ForexStatusClosing,
		"closed_type": 1,
		"handle_time": time.Now().Unix(),
	}).RowsAffected

	if taskAff > 0 {
		tools.Response(c, 1, "提交成功,请等待系统处理", ids)
		c.Abort()
		return
	} else {

		tools.Response(c, 0, "未找到需要平仓的交易", ids)
		c.Abort()
		return
	}
}

func CancelTrade(c *gin.Context) {
	id, _ := strconv.Atoi(c.DefaultQuery("id", "0"))

	if id <= 0 {
		tools.Response(c, 0, "参数错误", nil)
		c.Abort()
		return
	}
	userId := model.GetUserId(c)

	tx := model.DB.Begin()
	order := model.ForexTransactions{}
	//上锁查询
	tx.Clauses(clause.Locking{Strength: "UPDATE"}).Where("user_id = ? and status = ?", userId, model.ForexStatusEntrust).First(&order, id)

	if order.Id == 0 {

		tools.Response(c, 0, "交易不存在或已撤单,请刷新后重试", nil)
		c.Abort()
		tx.Rollback()
		return
	}

	//查找结算账户和剩余可用金额
	account, err := accountmodel.NewForexAccount(tx).GetAccount(userId)
	if err != nil {
		account.Balance = 0
	}
	//退回手续费
	err = account.ChangeBalance(accountmodel.ForexTransFeeCancel, order.TradeFee)
	if err != nil {
		tools.Response(c, 0, err.Error(), nil)
		c.Abort()
		tx.Rollback()
		return
	}
	//退回保证金
	err = account.ChangeBalance(accountmodel.ForexTransCancel, order.CautionMoney)
	if err != nil {
		tools.Response(c, 0, err.Error(), nil)
		c.Abort()
		tx.Rollback()
		return
	}
	result := tx.Where("id = ?", order.Id).Updates(model.ForexTransactions{
		CompleteTime: time.Now().Unix(),
		Status:       model.ForexStatusCancel,
	}).RowsAffected

	if result == 0 {
		tools.Response(c, 0, "撤单失败:变更状态失败", nil)
		c.Abort()
		tx.Rollback()
		return
	}

	tx.Commit()
	tools.Response(c, 1, "已撤单", order)
	c.Abort()
	return
}

// RechargeToForex 兑换详情
func RechargeToForex(c *gin.Context) {

	userId := model.GetUserId(c)

	settleCurrency := model.ForexSettleCurrency{}

	model.DB.Where("settle_status = 1").First(&settleCurrency)

	if settleCurrency.Id == 0 {
		tools.Response(c, 0, "无法找到兑换账户", nil)
		c.Abort()
		return
	}

	currency := model.Currencies{}

	model.DB.Where("id = ?", settleCurrency.RechargeCurrencyId).First(&currency)

	if currency.Id == 0 {
		tools.Response(c, 0, "无法找到承兑账户", nil)
		c.Abort()
		return
	}

	//查找账户
	account, err := changeAccount.NewChangeAccount(model.DB).GetAccount(userId, settleCurrency.RechargeCurrencyId)
	if err != nil {
		account.Balance = 0
	}
	forexAccount, err := accountmodel.NewForexAccount(model.DB).GetAccount(userId)
	if err != nil {
		account.Balance = 0
	}

	tools.Response(c, 1, "获取成功", map[string]interface{}{
		"recharge_account_balance": account.Balance,                                           //当前可兑换余额
		"recharge_account":         currency,                                                  //承兑币种信息
		"settle_account":           settleCurrency,                                            //要兑换的币种
		"recharge_bili":            settleCurrency.RechargeBili,                               //兑换比例
		"recharge_name":            ginI18n.MustGetMessage(account.AccountsName),              //兑换账户名字
		"settle_name":              ginI18n.MustGetMessage(settleCurrency.TransAccountName()), //兑换账户名字
		"settle_account_balance":   forexAccount.Balance,                                      //当前衍生品结算币种可兑换余额
	})
	c.Abort()
	return
}

// RechargeSubmit 兑换提交，前端先 RechargeToForex 获取信息后，提交
func RechargeSubmit(c *gin.Context) {

	var err error
	//1兑进 ，2兑出
	t, _ := strconv.Atoi(c.DefaultQuery("type", "1"))

	if t != 1 && t != 2 {

		tools.Response(c, 0, "参数错误", nil)
		c.Abort()
		return
	}

	//兑换数量
	number, _ := strconv.ParseFloat(c.DefaultQuery("number", "0"), 64)

	if number <= 0 {

		tools.Response(c, 0, "兑换数量无法少于等于0", nil)
		c.Abort()
		return
	}

	settleId := c.DefaultQuery("settle_id", "0")
	currencyId, _ := strconv.Atoi(c.DefaultQuery("currency_id", "0"))

	currency := model.Currencies{}

	model.DB.Where("id = ?", currencyId).First(&currency)

	if currency.Id == 0 {

		tools.Response(c, 0, "无法找到承兑账户", nil)
		c.Abort()
		return
	}

	userId := model.GetUserId(c)

	settleCurrency := model.ForexSettleCurrency{}

	model.DB.Where("id = ?", settleId).First(&settleCurrency)

	if settleCurrency.Id == 0 {

		tools.Response(c, 0, "无法找到兑换账户", nil)
		c.Abort()
		return
	}
	if settleCurrency.RechargeBili <= 0 {

		tools.Response(c, 0, "兑换比例失效，请等待最新汇率", nil)
		c.Abort()
		return
	}

	tx := model.DB.Begin()

	rechargeAccount, err := changeAccount.NewChangeAccount(tx).GetAccount(userId, currencyId)
	if err != nil {

		rechargeAccount.Balance = 0
	}

	settleAccount, err := accountmodel.NewForexAccount(tx).GetAccount(userId)
	if err != nil {

		settleAccount.Balance = 0
	}

	var cashNumber float64
	if t == 1 {
		//兑入

		//账户兑出扣款
		err = rechargeAccount.ChangeBalance(changeAccount.ForexCashOut, -number)
		if err != nil {

			tools.Response(c, 0, "e1:"+err.Error(), nil)
			tx.Rollback()
			c.Abort()
			return
		}

		//兑换后数量
		cashNumber = tools.Decimal(number*settleCurrency.RechargeBili, "%.6f")

		err = settleAccount.ChangeBalance(accountmodel.ForexCashIn, cashNumber)

		if err != nil {

			tools.Response(c, 0, "e2:"+err.Error(), nil)
			tx.Rollback()
			c.Abort()
			return
		}

	} else {
		//兑出

		err = settleAccount.ChangeBalance(accountmodel.ForexCashOut, -number)

		if err != nil {

			tools.Response(c, 0, "e3:"+err.Error(), nil)
			tx.Rollback()
			c.Abort()
			return
		}
		cashNumber = tools.Decimal(number*(1/settleCurrency.RechargeBili), "%.6f")
		err = rechargeAccount.ChangeBalance(changeAccount.ForexCashIn, cashNumber)
		if err != nil {

			tools.Response(c, 0, "e4:"+err.Error(), nil)
			tx.Rollback()
			c.Abort()
			return
		}
	}

	tx.Commit()

	tools.Response(c, 1, "兑换成功", nil)
	c.Abort()
	return

}
