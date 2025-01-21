package huobiApi

import (
	"context"
	"encoding/json"
	"exchange_features/Tools"
	"exchange_features/database"
	"log"
	"strings"
	"time"
)

var Prefix = "exchange_image_kline_"

func Cam() {

	t := time.NewTicker(120 * time.Second)
	defer t.Stop()
	onT(t.C)
}

func onT(c <-chan time.Time) {

	for {

		select {
		case <-c:

			run()

		}
	}
}

func run() {
	db := database.DB

	var currencyMatches []database.CurrencyMatches
	result := db.Find(&currencyMatches)

	if result.RowsAffected == 0 {

		return
	}

	for _, val := range currencyMatches {

		baseCurrency := database.Currencies{}
		quoteCurrency := database.Currencies{}
		db.Where("id = ?", val.BaseCurrencyId).First(&baseCurrency)
		db.Where("id = ?", val.QuoteCurrencyId).First(&quoteCurrency)

		if baseCurrency.Code == "" || quoteCurrency.Code == "" {

			continue
		}

		symbol := strings.ToLower(baseCurrency.Code + quoteCurrency.Code)

		kline, err := GetKline(symbol)

		if err != nil {

			continue
		}

		klineByte, _ := json.Marshal(kline)

		err = Tools.InitRedis().Set(context.Background(), Prefix+symbol, klineByte, 0).Err()

		if err != nil {
			log.Println(err.Error())
			continue
		}
	}

}
