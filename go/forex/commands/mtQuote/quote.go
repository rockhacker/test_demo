package mtQuote

import (
	"encoding/json"
	apiws "forex/services/api/ws"
	"forex/services/logic"
	"forex/services/market"
	"forex/services/model"
	"forex/services/redisDB"
	"forex/services/tools"
	"github.com/go-redis/redis"
	log "github.com/sirupsen/logrus"
	"reflect"
	"strconv"
	"sync"
	"time"
)

var Periods = []string{
	"1min",
	"5min",
	"15min",
	"30min",
	"60min",
	"1day",
	"1week",
	"1mon",
}

var PeriodsMin = []int64{
	1,
	5,
	15,
	30,
	60,
	1440,
}

// ForexCurrency 获取支持的币种
// 只执行一次
var ForexCurrency *ForexCurrencyMap

type ForexCurrencyMap struct {
	Mp map[string]model.ForexQuotationRobots
	sync.RWMutex
}

var syncGO sync.Once

//var CurrencyNewPrice *CurrencyNewPriceMap
//
//type CurrencyNewPriceMap struct {
//	CurrencyNewPrice map[int]apiws.QuoteData
//	sync.RWMutex
//}

func init() {

	ForexCurrency = &ForexCurrencyMap{
		Mp: make(map[string]model.ForexQuotationRobots),
	}

	//CurrencyNewPrice = &CurrencyNewPriceMap{
	//	CurrencyNewPrice: make(map[int]apiws.QuoteData),
	//}
}

func Init() {
	syncGO.Do(func() {

		var robot []model.ForexQuotationRobots

		model.DB.Where("status = ?", 1).Preload("ForexTradeLists").Find(&robot)

		for _, v := range robot {

			ForexCurrency.Set(v.ForexTradeLists.Code, v)

			tableQuote := model.ForexQuotations{}
			model.DB.Where("forex_id", v.ForexId).First(&tableQuote)

			if tableQuote.ForexId == 0 {

				tableQuote.ForexId = v.ForexId

				model.DB.Create(&tableQuote)
			}
		}

		go apiws.InitKlineListener()

	})

	////1000毫秒
	//ticker := time.NewTicker(1000 * time.Millisecond)
	//每秒把最新价格更新到数据库
	saveOrPushToDb()

}

// NewPrice 获取到K线最新价格，开始处理
func NewPrice(code string, nowPrice apiws.QuoteData) {

	robot := ForexCurrency.Get(code)

	if robot.ForexId != 0 {
		//fmt.Println(nowPrice)
		//处理所有k线
		handleKline(robot.ForexId, code, nowPrice)

	}

}

func handleKline(forexId int, code string, quote apiws.QuoteData) {

	for _, v := range Periods {

		data, err := market.ComputePeriodKline(v, forexId, code, quote)
		if err == nil {
			data.Change = (data.Close - data.Open) / data.Open * 100
			data.Change = tools.Decimal(data.Change, "%.2f")

			//处理一天涨跌幅
			if data.Period == "1day" {

				//保存最新价格
				key := "NewPrice:forex_id:" + strconv.Itoa(forexId)
				QuoteBytes, err := json.Marshal(data)
				if err != nil {
					return
				}
				redisDB.Set(key, string(QuoteBytes), 0)
				//CurrencyNewPrice.Set(forexId, data)
			}
			apiws.KlineEvent <- data
		}
	}
}

func (m *ForexCurrencyMap) Get(key string) model.ForexQuotationRobots {

	m.RLock()
	r := m.Mp[key]
	m.RUnlock()

	return r
}

func (m *ForexCurrencyMap) All() map[string]model.ForexQuotationRobots {

	m.RLock()
	r := m.Mp
	m.RUnlock()
	return r
}

func (m *ForexCurrencyMap) Set(key string, value model.ForexQuotationRobots) {

	m.Lock()
	m.Mp[key] = value
	m.Unlock()

}

func saveOrPushToDb() {
	//恐慌后继续调用
	defer func() {
		if err := recover(); err != nil {
			time.Sleep(10 * time.Second)
			log.Warn("保存k线到数据库失败，已重启")
			saveOrPushToDb()
		}
	}()

	for {
		//<-ticker.C
		time.Sleep(1 * time.Second)

		for _, v := range ForexCurrency.All() {

			key := "NewPrice:forex_id:" + strconv.Itoa(v.ForexId)
			newPrice := apiws.QuoteData{}

			bytesQuote, err := redisDB.Get(key).Bytes()
			if err != nil && err != redis.Nil {
				log.Warn("Redis返回失败:" + err.Error())
				time.Sleep(5 * time.Second)
				continue
			}
			err = json.Unmarshal(bytesQuote, &newPrice)
			if err != nil {
				//log.Warn("解析redis数据失败")
				continue
			}
			//发送深度
			go func(v model.ForexQuotationRobots) {
				//newPrice := CurrencyNewPrice.Get(v.ForexId)
				apiws.SendDepth(newPrice.Code, newPrice.Close, v.ForexId)
				return
			}(v)
			//newPrice := CurrencyNewPrice.Get(v.ForexId)

			if !reflect.DeepEqual(newPrice, apiws.QuoteData{}) {

				quotation := model.ForexQuotations{}
				quotation.High = newPrice.High
				quotation.Change = newPrice.Change
				//quotation.ForexId = v.ForexId
				quotation.Volume = newPrice.Volume
				quotation.Close = newPrice.Close
				quotation.Open = newPrice.Open
				quotation.Amount = newPrice.Amount
				quotation.Low = newPrice.Low
				quotation.NowTime = time.Now()
				//model.DB.Clauses(clause.OnConflict{
				//	Columns: []clause.Column{{Name: "forex_id"}}, //  这里的列必须是唯一的，比如主键或是唯一索引
				//	DoUpdates: clause.AssignmentColumns([]string{
				//		"high",
				//		"change",
				//		"volume",
				//		"close",
				//		"open",
				//		"amount",
				//		"low",
				//		"now_time",
				//	}), // 更新哪些字段
				//}).Create(&quotation)
				model.DB.Model(quotation).Where("forex_id = ?", v.ForexId).Updates(quotation)
			}

		}
		//委托激活
		go logic.EntrustActivate()

		//触发止盈止损
		go logic.CheckNeedStopPriceTrade()

	}

}

//func (m *CurrencyNewPriceMap) Get(key int) apiws.QuoteData {
//
//	m.RLock()
//	r := m.CurrencyNewPrice[key]
//	m.RUnlock()
//
//	return r
//}
//
//func (m *CurrencyNewPriceMap) All() map[int]apiws.QuoteData {
//
//	m.RLock()
//	r := m.CurrencyNewPrice
//	m.RUnlock()
//	return r
//}
//
//func (m *CurrencyNewPriceMap) Set(key int, value apiws.QuoteData) {
//
//	m.Lock()
//	m.CurrencyNewPrice[key] = value
//	m.Unlock()
//
//}
