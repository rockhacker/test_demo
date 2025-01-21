package apiws

import (
	"encoding/json"
	"forex/conf"
	"forex/services/model"
	accountmodel "forex/services/model/forexaccountmodel"
	"forex/services/tools"
	"forex/services/websocket"
	log "github.com/sirupsen/logrus"
	"math/rand"
	"strconv"
	"time"
)

type QuoteData struct {
	Id      int64
	Close   float64
	Open    float64
	High    float64
	Low     float64
	Volume  float64
	Amount  float64
	Change  float64
	Period  string
	Code    string
	ForexId int
	Time    int64
}

var DayMarketDataChan = make(chan DayMarketData, 1)
var MarketDepthDataChan = make(chan MarketDepthData, 1)
var KlineChan = make(chan KlineData, 1)
var GlobalTxChan = make(chan GlobalTxData, 1)
var SubTradeDetailChan = make(chan SubTradeDetail, 1)

//var SubTradeClosedOrderChan = make(chan SubTradeClosedOrder, 1)

type SubTradeDetail struct {
	ConnId string
}

type SubTradeClosedOrder struct {
	Type string  `json:"type"`
	Id   []int64 `json:"id"`
}

type DayMarketData struct {
	Type      string    `json:"type"`
	Symbol    string    `json:"symbol"`
	Quotation Quotation `json:"quotation"`
}

type GlobalTxData struct {
	Type      string              `json:"type"`
	Symbol    string              `json:"symbol"`
	ForexId   int                 `json:"forex_id"`
	Completes []GlobalTxCompletes `json:"completes"`
}

type GlobalTxCompletes struct {
	Way       int     `json:"way"`
	Timestamp int64   `json:"timestamp"`
	Price     float64 `json:"price"`
	InUserId  int     `json:"in_user_id"`
	OutUserId int     `json:"out_user_id"`
	ForexId   int     `json:"forex_id"`
	Amount    float64 `json:"amount"`
}

type MarketDepthData struct {
	ForexId int    `json:"forex_id"`
	Type    string `json:"type"`
	Symbol  string `json:"symbol"`
	Depth   Depth  `json:"depth"`
}

type KlineData struct {
	ForexId int       `json:"forex_id"`
	Type    string    `json:"type"`
	Symbol  string    `json:"symbol"`
	Kline   QuoteData `json:"kline"`
}

func JobPushForexTradeDetail() {

	for i := 0; i < conf.Config.GetInt("basic.quote_handlers_num"); i++ {
		log.Debug("FOREX_TRADE推送程序" + strconv.Itoa(i) + "启动")
		go func() {
			for {

				data, ok := <-SubTradeDetailChan

				if ok {
					conn := Ws.GetConnection(data.ConnId)

					go func(conn websocket.Connection) {
						for {
							if conn == nil {

								return
							}
							//如果客户离开关闭协程
							if conn.GetValue("is_leave") == true {

								return
							}

							userId := conn.GetValue("user_id")
							if userId != nil {
								type RepT struct {
									Type                    string `json:"type"`
									To                      int64
									HazardRate              float64
									CautionMoneyAll         float64
									ProfitsTotal            float64
									OriginCautionMoneyTotal float64
									TransOrder              []model.ForexTransactions
								}

								//查找结算账户和剩余可用金额
								account, err := accountmodel.NewForexAccount(model.DB).GetAccount(userId.(int64))
								if err != nil {
									account.Balance = 0
								}
								//取盈亏总额
								userProfit := model.GetUserProfit(userId.(int64), 0)

								hazardRate := model.GetAccountHazardRate(userProfit, account.Balance)

								var TradeSlice []model.ForexTransactions

								model.DB.Model(model.ForexTransactions{}).Where(
									"user_id = ? and status = ?",
									userId,
									model.ForexStatusTransaction,
								).Preload("ForexTradeLists").Find(&TradeSlice)

								Rep := RepT{
									Type:                    "FOREX_TRADE",
									To:                      userId.(int64),
									HazardRate:              hazardRate,                         //风险率
									CautionMoneyAll:         userProfit.CautionMoneyTotal,       //总保证金
									OriginCautionMoneyTotal: userProfit.OriginCautionMoneyTotal, //原始总保证金
									ProfitsTotal:            userProfit.ProfitsTotal,            //总盈亏
									TransOrder:              TradeSlice,                         //在场订单
								}
								db, _ := json.Marshal(Rep)
								err = conn.Write(1, db)
								if err != nil {
									return
								}

							}

							time.Sleep(1 * time.Second)
						}
					}(conn)

				}

			}

		}()
	}

}

func JobPushKlineInGlobalTx() {

	for i := 0; i < conf.Config.GetInt("basic.quote_handlers_num"); i++ {
		log.Debug("GLOBAL_TX推送程序" + strconv.Itoa(i) + "启动")
		go func() {
			for {

				data, ok := <-GlobalTxChan
				if ok {
					conn := Ws.GetConnectionsByRoom("GLOBAL_TX." + data.Symbol)
					for _, v := range conn {

						db, _ := json.Marshal(data)

						v.Write(1, db)
					}
				}

			}

		}()
	}
}

func JobPushDayMarket() {

	for i := 0; i < conf.Config.GetInt("basic.quote_handlers_num"); i++ {
		log.Debug("DAY_MARKET推送程序" + strconv.Itoa(i) + "启动")
		go func() {
			for {

				data, ok := <-DayMarketDataChan

				if ok {
					conn := Ws.GetConnectionsByRoom("DAY_MARKET")
					for _, v := range conn {

						db, _ := json.Marshal(data)
						//fmt.Println(data)
						v.Write(1, db)
					}
				}

			}

		}()
	}

}

func JobPushDepth() {

	for i := 0; i < conf.Config.GetInt("basic.quote_handlers_num"); i++ {
		log.Debug("MARKET_DEPTH推送程序" + strconv.Itoa(i) + "启动")
		go func() {
			for {

				data, ok := <-MarketDepthDataChan
				if ok {
					conn := Ws.GetConnectionsByRoom("MARKET_DEPTH." + data.Symbol)
					for _, v := range conn {

						db, _ := json.Marshal(data)

						v.Write(1, db)
					}
				}

			}

		}()
	}

}

func JobPushKline() {

	for i := 0; i < conf.Config.GetInt("basic.quote_handlers_num"); i++ {
		log.Debug("KLINE推送程序" + strconv.Itoa(i) + "启动")
		go func() {
			for {

				data, ok := <-KlineChan
				if ok {
					conn := Ws.GetConnectionsByRoom("KLINE." + data.Symbol)
					for _, v := range conn {

						db, _ := json.Marshal(data)

						v.Write(1, db)
					}
				}

			}

		}()
	}
}

func SendDayMarket(data QuoteData) {

	if data.Period == "1day" {
		//发送到客户端
		DayMarketDataChan <- DayMarketData{
			Type:   "DAY_MARKET",
			Symbol: data.Code,
			Quotation: Quotation{
				Amount:  data.Amount,
				Change:  data.Change,
				Close:   tools.Decimal(data.Close, "%.8f"),
				ForexId: data.ForexId,
				High:    data.High,
				Id:      data.Id,
				Low:     data.Low,
				Open:    data.Open,
				Volume:  data.Volume,
			},
		}
	}

}

func SendKline(data QuoteData) {

	//if data.Period == "1min" {
	//发送到客户端
	KlineChan <- KlineData{
		Type:   "KLINE",
		Symbol: data.Code,
		Kline:  data,
	}

	if data.Period == "1min" {

		//发送全站交易到客户端
		timeNow := time.Now().Unix() + int64(data.Close)
		rand.Seed(timeNow)

		cmp := GlobalTxCompletes{
			Way:       rand.Intn(2) + 1,
			Timestamp: timeNow,
			Price:     data.Close,
			ForexId:   data.ForexId,
			InUserId:  1,
			OutUserId: 1,
			Amount:    float64(rand.Intn(20)),
		}

		GlobalTxChan <- GlobalTxData{
			Type:    "GLOBAL_TX",
			Symbol:  data.Code,
			ForexId: data.ForexId,
			Completes: []GlobalTxCompletes{
				cmp,
			},
		}
	}

}

func SendDepth(code string, price float64, forexId int) {

	MarketDepthDataChan <- MarketDepthData{
		Type:   "MARKET_DEPTH",
		Symbol: code,
		Depth: Depth{
			In:      DepthBuys(10, price),
			Out:     DepthSells(10, price),
			ForexId: forexId,
			Symbol:  code,
		},
	}

}

func DepthBuys(limit int, price float64) (in []map[string]interface{}) {

	for i := limit; i >= 1; i-- {
		rand.Seed(time.Now().UnixMilli() + int64(i))
		pi := rand.Intn(1000)
		price = tools.Decimal(price+price*0.0001, "%.8f")

		ins := make(map[string]interface{})
		//ins["amount"] = pi / i
		ins["amount"] = pi
		ins["index"] = "buy" + strconv.Itoa(i)
		ins["price"] = price
		//ins["sum"] = pi / i
		ins["sum"] = pi
		in = append(in, ins)
	}
	return in
}

func DepthSells(limit int, price float64) (out []map[string]interface{}) {

	for i := 1; i <= limit; i++ {
		rand.Seed(time.Now().UnixMilli() + int64(i))
		pi := rand.Intn(1300)

		price = tools.Decimal(price-price*0.0001, "%.8f")

		ins := make(map[string]interface{})
		//ins["amount"] = pi / i
		ins["amount"] = pi
		ins["index"] = "sell" + strconv.Itoa(i)
		ins["price"] = price
		//ins["sum"] = pi / i
		ins["sum"] = pi
		out = append(out, ins)
	}
	return out
}

func ForexOrderUpdate(data QuoteData) {
	if data.Period == "1min" && data.Close > 0 {
		//
		////查找结算账户和剩余可用金额
		//account, err := accountmodel.NewForexAccount(model.DB).GetAccount(userId.(int64))
		//if err != nil {
		//	account.Balance = 0
		//}
		////取盈亏总额
		//userProfit := model.GetUserProfit(userId.(int64), 0)
		//
		//model.GetAccountHazardRate()

		model.DB.Model(
			model.ForexTransactions{},
		).Where(
			"forex_id = ? and status <= ?",
			data.ForexId,
			model.ForexStatusTransaction,
		).Updates(model.ForexTransactions{
			UpdatePrice: data.Close,
			UpdateTime:  time.Now().Unix(),
		})
	}
}

// PushClosedTrade 推送平仓订单id
func PushClosedTrade(userId int64, ids []int64) {

	NewUserBindWs.Lock()
	wsId := NewUserBindWs.UserBindId[userId]
	NewUserBindWs.Unlock()

	if wsId != "" {
		sendData := SubTradeClosedOrder{
			Type: "FOREX_CLOSED",
			Id:   ids,
		}
		db, _ := json.Marshal(sendData)
		conn := Ws.GetConnection(wsId)
		if conn != nil {

			if conn.IsJoined("FOREX_CLOSED") {

				_ = conn.Write(1, db)
			}

		}

	}
}
