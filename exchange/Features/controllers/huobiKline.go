package controllers

import (
	"context"
	"encoding/json"
	"exchange_features/Tools"
	"exchange_features/huobiApi"
	"github.com/gin-gonic/gin"
)

func GetKline(c *gin.Context) {

	symbol, has := c.GetQuery("symbol")

	if !has {

		Tools.Response{Context: c, Msg: "缺少参数symbol"}.Error(nil)
		return
	}

	if !has {

		Tools.Response{Context: c, Msg: "缺少参数symbol"}.Error(nil)
		return
	}
	resp, err := huobiApi.GetKline(symbol)

	if err != nil {
		Tools.Response{Context: c, Msg: err.Error()}.Error(nil)
		return
	}
	Tools.Response{Context: c}.Success(resp)
	return

}

func GetCacheKline(c *gin.Context) {

	symbol, has := c.GetQuery("symbol")

	if !has {

		Tools.Response{Context: c, Msg: "缺少参数symbol"}.Error(nil)
		return
	}

	resp, err := Tools.InitRedis().Get(context.Background(), huobiApi.Prefix+symbol).Result()
	var in []interface{}

	if err != nil {
		Tools.Response{Context: c}.Success(in)
		return
	}
	_ = json.Unmarshal([]byte(resp), &in)

	Tools.Response{Context: c}.Success(in)
	return
}
