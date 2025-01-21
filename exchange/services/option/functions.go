package main

import (
	"github.com/huobirdcenter/huobi_golang/pkg/client"
	"gorm.io/gorm"
	"log"
	"math"
	"option/database"
	"strings"
	"time"
)

func GeneratePeriods() {

	db := database.DB

	var supportedCurrencyMatches []database.CurrencyMatches

	err := db.Where("open_option = ?", 1).Find(&supportedCurrencyMatches).Error

	if err != nil && err != gorm.ErrRecordNotFound {

		return
	}

	for _, currencyInfo := range supportedCurrencyMatches {

		var seconds []database.OptionSecond

		err = db.Where("status = ?", 1).Find(&seconds).Error

		if err != nil && err != gorm.ErrRecordNotFound {

			return
		}

		for _, val := range seconds {

			//查看有没有状态为未开始的期数，如果没有则创建一条
			ex := db.
				Where("status = ? and seconds_id = ? and currency_match_id = ?", database.PeriodsNotRun, val.Id, currencyInfo.Id).
				First(&database.OptionPeriods{}).
				RowsAffected

			if ex == 0 {

				lastPeriods := database.OptionPeriods{}

				lastObj := db.Where("seconds_id  = ? and currency_match_id = ?", val.Id, currencyInfo.Id).Last(&lastPeriods)

				var Period int64

				if lastObj.RowsAffected == 0 {

					Period = 1
				} else {

					Period = lastPeriods.Period + 1
				}

				createPeriod := database.OptionPeriods{}
				createPeriod.SecondsId = val.Id
				createPeriod.Status = database.PeriodsNotRun
				createPeriod.Result = 0
				createPeriod.CreatedTime = time.Now()
				createPeriod.Period = Period
				createPeriod.CurrencyMatchId = currencyInfo.Id
				err := db.Create(&createPeriod)

				if err != nil {

					log.Println(err)
					break
				}
			}

		}
	}

}

func RunningPeriod(periodRoutine chan database.OptionPeriods) {

	//找到未开始的期数，条件是无其他期数在进行中

	db := database.DB

	var supportedCurrencyMatches []database.CurrencyMatches

	err := db.Where("open_option = ?", 1).Find(&supportedCurrencyMatches).Error

	if err != nil && err != gorm.ErrRecordNotFound {

		return
	}

	for _, currencyInfo := range supportedCurrencyMatches {

		var seconds []database.OptionSecond

		err = db.Where("status = ?", 1).Find(&seconds).Error

		if err != nil && err != gorm.ErrRecordNotFound {

			return
		}

		for _, val := range seconds {

			//找出是否还有期数在运行
			if 0 == db.Where("status = ? and seconds_id = ? and currency_match_id = ?", database.PeriodsRunning, val.Id, currencyInfo.Id).
				First(&database.OptionPeriods{}).RowsAffected {

				//找出一条未运行的期数
				exec := database.OptionPeriods{}
				if err != db.Where("status = ? and seconds_id = ? and currency_match_id = ?", database.PeriodsNotRun, val.Id, currencyInfo.Id).
					First(&exec).Error {

					log.Println(err)
					break
				}

				currencyMatch := database.CurrencyMatches{}

				if err != db.Where("id = ?", exec.CurrencyMatchId).First(&currencyMatch).Error {

					log.Println("获取货币对失败")
					break
				}

				baseCurrencyName := database.Currencies{}
				quoteCurrencyName := database.Currencies{}
				if err != db.Where("id = ?", currencyMatch.QuoteCurrencyId).First(&quoteCurrencyName).Error {

					log.Println("获取货币失败")
					break
				}
				if err != db.Where("id = ?", currencyMatch.BaseCurrencyId).First(&baseCurrencyName).Error {

					log.Println("获取货币失败")
					break
				}
				//修改期数使其运行
				nowTime := time.Now()
				periodRunSecond := val.Seconds
				exec.Status = database.PeriodsRunning
				exec.StartTime = nowTime
				exec.CapStartTimestamp = nowTime.Unix()
				exec.CapEndTimestamp = nowTime.Unix() + periodRunSecond
				exec.OpenPrice, _ = getPrice(baseCurrencyName.Code + quoteCurrencyName.Code)

				err = db.UpdateColumns(&exec).Error

				if err != nil {

					log.Println(err)
					break
				}
				periodRoutine <- exec
			}
			//还有则不做处理

		}
	}

}

func GoroutinePeriod(periodRoutine chan database.OptionPeriods) {
	db := database.DB
	var err error
	for {
		select {

		case data := <-periodRoutine:

			go func(data database.OptionPeriods) {

				surplusTime := data.CapEndTimestamp - time.Now().Unix()

				currencyMatch := database.CurrencyMatches{}

				if err != db.Where("id = ?", data.CurrencyMatchId).First(&currencyMatch).Error {

					log.Println("获取货币对失败")
					return
				}

				baseCurrencyName := database.Currencies{}
				quoteCurrencyName := database.Currencies{}
				if err != db.Where("id = ?", currencyMatch.QuoteCurrencyId).First(&quoteCurrencyName).Error {

					log.Println("获取货币失败")
					return
				}
				if err != db.Where("id = ?", currencyMatch.BaseCurrencyId).First(&baseCurrencyName).Error {

					log.Println("获取货币失败")
					return
				}

				//如果剩余时间少于0,则意味着产品需要结算
				if surplusTime <= 0 {
					SettlementPeriod(data, baseCurrencyName.Code+quoteCurrencyName.Code)
					return
				}

				//等待剩余时间结束后结算产品
				<-time.NewTicker(time.Duration(surplusTime) * time.Second).C
				SettlementPeriod(data, baseCurrencyName.Code+quoteCurrencyName.Code)
				return
			}(data)

		}

	}
}

//SettlementPeriod 期数结束
func SettlementPeriod(data database.OptionPeriods, symbol string) {

	closePrice, _ := getPrice(symbol)

	var result int
	if data.OpenPrice <= closePrice {

		result = 1
	} else {

		result = 2
	}
	data.ResultTime = time.Now()
	data.Status = database.PeriodsSettlement
	data.ClosePrice = closePrice
	data.Result = result
	_ = database.DB.Transaction(func(tx *gorm.DB) error {

		err := tx.UpdateColumns(&data).Error
		if err != nil {

			return err
		}

		err = tx.Where("period_id = ? and status = ?", data.Id, database.PeriodsOrderTrading).
			Updates(database.OptionOrders{Status: database.PeriodsOrderSettlement}).Error

		if err != nil {

			return err
		}
		return nil
	})

	//结算订单
	go SettlementOrder(data)

}

func SettlementOrder(period database.OptionPeriods) {

	_ = database.DB.Transaction(func(tx *gorm.DB) error {

		var order []database.OptionOrders

		err := tx.Where("period_id = ? and status = ?", period.Id, database.PeriodsOrderSettlement).Find(&order).Error
		if err != nil {

			return err
		}

		var second database.OptionSecond

		err = tx.Where("id = ?", period.SecondsId).First(&second).Error

		if err != nil {

			return err
		}

		for _, val := range order {
			//标记结束状态
			val.Status = database.PeriodsOrderFinish
			val.HandleTime = time.Now()
			val.Result = period.Result

			//盈利
			if period.Result == val.Type {

				profit := val.Number + (val.Number * second.ProfitRatio)

				account, err := database.NewOptionAccount(tx).GetAccount(val.CurrencyId, val.UserId)

				if err != nil {

					return err
				}

				err = account.ChangeBalance(database.OptionTradeOrderClose, profit)

				if err != nil {

					return err
				}
				val.ResultAmount = profit
			} else {

				val.ResultAmount = -val.Number
			}

			tx.Where("id = ?", val.Id).Updates(val)

		}

		period.Status = database.PeriodsFinish
		err = tx.UpdateColumns(&period).Error
		if err != nil {

			return err
		}

		return nil
	})
}

func ReviewOrder() {

	var periods []database.OptionPeriods

	err := database.DB.Where("status = ?", database.PeriodsSettlement).Find(&periods).Error

	if err != nil {

		return
	}

	for _, v := range periods {

		SettlementOrder(v)
	}

}

func FixRunningPeriods(periodRoutine chan database.OptionPeriods) {

	var exec []database.OptionPeriods
	database.DB.Where("status = ?", database.PeriodsRunning).Find(&exec)
	for _, v := range exec {

		periodRoutine <- v
	}
}

func getPrice(symbol string) (float64, error) {

	getPriceResp, err := new(client.MarketClient).Init("api.huobi.de.com").GetLast24hCandlestick(strings.ToLower(symbol))

	if err != nil {

		return 0, err
	}
	price, _ := getPriceResp.Close.Float64()
	return price + math.Round(20.2), nil
}
