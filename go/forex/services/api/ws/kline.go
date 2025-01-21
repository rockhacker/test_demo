package apiws

import (
	"encoding/json"
	"forex/conf"
	"forex/services/redisDB"
	log "github.com/sirupsen/logrus"
	"sort"
	"strconv"
)

const KlineSize = 60 * 6

type Quotation struct {
	Amount  float64 `json:"amount"`
	Change  float64 `json:"change"`
	Close   float64 `json:"close"`
	ForexId int     `json:"forex_id"`
	High    float64 `json:"high"`
	Id      int64   `json:"id"`
	Low     float64 `json:"low"`
	Open    float64 `json:"open"`
	Volume  float64 `json:"volume"`
}

type Depth struct {
	ForexId int                      `json:"forex_id"`
	Symbol  string                   `json:"symbol"`
	In      []map[string]interface{} `json:"in"`
	Out     []map[string]interface{} `json:"out"`
}

var KlineEvent = make(chan QuoteData)

func InitKlineListener() {

	for i := 0; i < conf.Config.GetInt("basic.quote_handlers_num"); i++ {

		go func() {
			for {

				data, ok := <-KlineEvent

				if ok {

					//推送天概要行情
					SendDayMarket(data)
					//推送k线行情
					SendKline(data)
					//把k线放入缓存
					writeKline(data)

					//衍生品交易订单价格更新
					ForexOrderUpdate(data)

				}
			}
		}()
	}

}

func writeKline(quote QuoteData) {

	//forex:BTCUSD:1min
	key := "kline:" + quote.Code + ":" + quote.Period

	klineList, err := redisDB.Get(key).Bytes()
	var structKline = make(map[int64]QuoteData)
	if err == nil {

		err = json.Unmarshal(klineList, &structKline)

		if err != nil {
			log.Debug("Redis k线数据格式错误：" + err.Error())
			return
		}

	}

	structKline[quote.Id] = quote
	if len(structKline) > KlineSize {

		var keys []string
		for k, _ := range structKline {
			keys = append(keys, strconv.FormatInt(k, 10))
		}
		sort.Strings(keys)
		//lastKey := keys[len(keys)-1]
		lastKey := keys[0]
		deleteKey, _ := strconv.ParseInt(lastKey, 10, 64)

		delete(structKline, deleteKey)
	}
	marshal, err := json.Marshal(structKline)
	if err != nil {
		return
	}
	redisDB.Set(key, marshal, 0)
}
