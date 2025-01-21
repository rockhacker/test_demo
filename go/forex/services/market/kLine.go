package market

import (
	"math"
	"time"
)

var TimeOffset = int64(3600 * 3)

type KLine struct {
	Open        float64 `json:"open"`
	Close       float64 `json:"close"`
	High        float64 `json:"high"`
	Low         float64 `json:"low"`
	TradeVolume int64   `json:"tradeVolume"`
	TickTime    float64 `json:"tickTime"`
}

func (kline KLine) getIntervalEnd(interval time.Duration) time.Time {
	return time.Unix(int64(kline.TickTime), 0).Add(interval)
}

func (kline KLine) alignStartTime(klineTime time.Time, interval time.Duration) time.Time {
	offset := klineTime.Unix() % int64(interval.Seconds())
	return klineTime.Add(-time.Duration(offset) * time.Second)
}

func (kline KLine) getIntervalStart(interval time.Duration) time.Time {
	baseTime := time.Unix(int64(kline.TickTime)-TimeOffset, 0)
	offset := baseTime.Unix() % int64(interval.Seconds())
	return baseTime.Add(-time.Duration(offset) * time.Second)
}

func MergeKLines(klines []KLine, interval time.Duration) []KLine {
	var merged []KLine
	var currentKLine *KLine

	for _, kline := range klines {
		//计算偏移
		klineTime := time.Unix(int64(kline.TickTime)-TimeOffset, 0)
		intervalEnd := currentKLine != nil && klineTime.After(currentKLine.getIntervalEnd(interval))

		if intervalEnd {
			merged = append(merged, *currentKLine)
			currentKLine = nil
		}

		if currentKLine == nil {
			currentKLine = &KLine{
				Open:        kline.Open,
				Close:       kline.Close,
				High:        kline.High,
				Low:         kline.Low,
				TradeVolume: kline.TradeVolume,
				TickTime:    float64(klineTime.Unix()),
			}
		} else {
			currentKLine.Close = kline.Close
			currentKLine.High = math.Max(currentKLine.High, kline.High)
			currentKLine.Low = math.Min(currentKLine.Low, kline.Low)
			currentKLine.TradeVolume += kline.TradeVolume
		}
	}

	if currentKLine != nil {
		merged = append(merged, *currentKLine)
	}

	return merged
}

func MergeKLinesV2(klines []KLine, interval time.Duration) []KLine {
	var merged []KLine
	var currentKLine *KLine
	var nextIntervalStart time.Time

	for _, kline := range klines {
		//fmt.Println(int64(kline.TickTime))
		//klineTime := time.Unix(int64(kline.TickTime), 0)
		klineTime := time.Unix(int64(kline.TickTime)-TimeOffset, 0)

		if currentKLine == nil {
			intervalStart := kline.getIntervalStart(interval)
			nextIntervalStart = intervalStart.Add(interval)
			currentKLine = &KLine{
				Open:        kline.Open,
				Close:       kline.Close,
				High:        kline.High,
				Low:         kline.Low,
				TradeVolume: kline.TradeVolume,
				TickTime:    float64(intervalStart.Unix()),
			}
		} else if klineTime.After(nextIntervalStart) || klineTime.Equal(nextIntervalStart) {
			merged = append(merged, *currentKLine)
			intervalStart := kline.getIntervalStart(interval)
			nextIntervalStart = intervalStart.Add(interval)
			currentKLine = &KLine{
				Open:        kline.Open,
				Close:       kline.Close,
				High:        kline.High,
				Low:         kline.Low,
				TradeVolume: kline.TradeVolume,
				TickTime:    float64(intervalStart.Unix()),
			}
		} else {
			currentKLine.Close = kline.Close
			currentKLine.High = math.Max(currentKLine.High, kline.High)
			currentKLine.Low = math.Min(currentKLine.Low, kline.Low)
			currentKLine.TradeVolume += kline.TradeVolume
		}
	}

	if currentKLine != nil {
		merged = append(merged, *currentKLine)
	}

	return merged
}
