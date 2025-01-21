package huobiApi

import (
	"github.com/huobirdcenter/huobi_golang/pkg/client"
	"github.com/huobirdcenter/huobi_golang/pkg/model/market"
)

func GetKline(symbol string) ([]market.Candlestick, error) {

	c := new(client.MarketClient).Init(Host)
	optionalRequest := market.GetCandlestickOptionalRequest{Period: market.MIN1, Size: 200}
	resp, err := c.GetCandlestick(symbol, optionalRequest)

	return resp, err
}
