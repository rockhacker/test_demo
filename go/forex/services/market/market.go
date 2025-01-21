package market

import (
	"encoding/json"
	apiws "forex/services/api/ws"
	"forex/services/redisDB"
	"github.com/golang-module/carbon/v2"
	log "github.com/sirupsen/logrus"
	"reflect"
	"sort"
	"strconv"
	"time"
)

func GetKline(period string, code string) (rep []apiws.QuoteData) {
	key := "kline:" + code + ":" + period
	cmder, err := redisDB.Get(key).Bytes()
	var data = make(map[int64]apiws.QuoteData)

	if err != nil {

		return []apiws.QuoteData{}
	}
	err = json.Unmarshal(cmder, &data)
	if err != nil {

		return []apiws.QuoteData{}
	}

	var keys []string
	for k, _ := range data {
		keys = append(keys, strconv.FormatInt(k, 10))
	}
	//排序
	sort.Strings(keys)

	for _, v := range keys {

		i, _ := strconv.ParseInt(v, 10, 64)
		rep = append(rep, data[i])
	}

	return rep
}

func ComputePeriodKline(period string, forexId int, code string, nowPrice apiws.QuoteData) (apiws.QuoteData, error) {

	id := FormatTimeline(period, time.Now())

	key := "kline:" + code + ":" + period
	klineList, err := redisDB.Get(key).Bytes()
	var structKline = make(map[int64]apiws.QuoteData)
	if err == nil {

		err = json.Unmarshal(klineList, &structKline)

		if err != nil {
			log.Debug("Redis k线数据格式错误：" + err.Error())
			return apiws.QuoteData{}, err
		}

	}
	oldKline := structKline[id]

	//如果等于空
	if reflect.DeepEqual(oldKline, apiws.QuoteData{}) {
		nowPrice.Id = id
		nowPrice.Period = period
		nowPrice.Volume = nowPrice.Close * nowPrice.Amount
		nowPrice.ForexId = forexId
		nowPrice.Code = code

		//矫正最高价和最低价

		nowPrice.Low = nowPrice.Close
		nowPrice.High = nowPrice.Close
		nowPrice.Open = nowPrice.Close

	} else {

		//更新最后老k线
		oldKline.Close = nowPrice.Close
		if oldKline.High < nowPrice.Close {

			oldKline.High = nowPrice.Close
		}
		if oldKline.Low > oldKline.Close {

			oldKline.Low = nowPrice.Close
		}
		oldKline.Amount += nowPrice.Amount
		oldKline.Volume += nowPrice.Close * nowPrice.Amount

		nowPrice = oldKline
	}
	if nowPrice.Time == 0 {
		nowPrice.Time = nowPrice.Id * 1000
	}
	structKline[id] = nowPrice

	return nowPrice, nil
}

func FormatTimeline(period string, timestamp time.Time) int64 {
	//layout := "2006-01-02 15:04:05"
	var repTime int64
	carbonTime := carbon.Time2Carbon(timestamp)
	//统一时区，程序处理
	t := carbonTime.SetTimezone(carbon.PRC)

	switch period {
	case "1min":
		m := t.Parse(t.Format("Y-m-d H:i:00"))
		repTime = m.Timestamp()
		break
	case "5min":
		startTimestamp := t.Parse(t.Format("Y-m-d H:00:00"))

		minute := t.Minute()
		multiple := minute / 5

		minuteRes := int64(multiple * 5)
		repTime = startTimestamp.Timestamp() + (minuteRes * 60)
		break
	case "15min":

		startTimestamp := t.Parse(t.Format("Y-m-d H:00:00"))

		minute := t.Minute()

		multiple := minute / 15
		minuteRes := int64(multiple * 15)

		repTime = startTimestamp.Timestamp() + (minuteRes * 60)
		break
	case "30min":
		startTimestamp := t.Parse(t.Format("Y-m-d H:00:00"))

		minute := t.Minute()

		multiple := minute / 30
		minuteRes := int64(multiple * 30)

		repTime = startTimestamp.Timestamp() + (minuteRes * 60)
		break
	case "60min":
		startTimestamp := t.Parse(t.Format("Y-m-d H:00:00"))

		repTime = startTimestamp.Timestamp()
		break

	case "4hour":
		//startTime := timestamp.Format("2006-01-02 00:00:00")
		//startTimestamp, _ := time.Parse(layout, startTime)
		startTimestamp := t.Parse(t.Format("Y-m-d 00:00:00"))

		//hours := timestamp.Format("15")
		hours := t.Hour()
		//m, _ := strconv.ParseInt(hours, 10, 64)
		multiple := hours / 4
		hoursRes := int64(multiple * 4)
		repTime = startTimestamp.Timestamp() + (hoursRes * 3600)
		break

	case "1day":
		startTimestamp := t.Parse(t.Format("Y-m-d 00:00:00"))
		repTime = startTimestamp.Timestamp()
		break

	case "1week":
		startTimestamp := t.Parse(t.Format("Y-m-d 00:00:00"))

		w := int64(t.Week())
		repTime = startTimestamp.Timestamp() - (w * 86400)
		break
	case "1mon":
		//startTime := timestamp.Format("2006-01") + "-01 00:00:00"
		//startTimestamp := t.Parse(startTime)
		startTimestamp := t.Parse(t.Format("Y-m-01 00:00:00"))
		repTime = startTimestamp.Timestamp()
		break
	case "1year":
		//startTime := timestamp.Format("2006") + "-01-01 00:00:00"
		//startTimestamp := t.Parse(startTime)
		startTimestamp := t.Parse(t.Format("Y-01-01 00:00:00"))

		repTime = startTimestamp.Timestamp()
		break
	}
	return repTime
}
