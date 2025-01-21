package api

import (
	"forex/conf"
	"forex/services/api/controller/basic"
	forexController "forex/services/api/controller/forex"
	"forex/services/api/handle"
	"forex/services/api/ws"
	"github.com/gin-gonic/gin"
)

func Route() *gin.Engine {

	if conf.Config.GetBool("basic.debug_mode") {

		gin.SetMode(gin.DebugMode)
	} else {

		gin.SetMode(gin.ReleaseMode)
	}

	r := gin.Default()
	//信任所有IP
	_ = r.SetTrustedProxies(nil)

	//解决跨域问题
	r.Use(handle.Cors())
	//设置多语言
	r.Use(handle.ApiLang())

	v1 := r.Group("v1")

	//ws
	v1.GET("/ws", apiws.Ws.Handler())

	authApi := v1.Group("api")
	//需要登陆
	authApi.Use(handle.ApiAuth)
	{
		forex := authApi.Group("forex")
		{

			//提交交易
			forex.GET("/submit", forexController.Submit)

			//修改止盈止损
			forex.GET("/set_stop_price", forexController.SetStopPrice)

			//取交易信息
			forex.GET("/deal", forexController.Deal)

			//交易列表
			forex.GET("/deal_all", forexController.DealAll)

			//我的交易
			forex.GET("/my_deal", forexController.MyDeal)

			//平仓
			forex.GET("/close", forexController.Close)

			//按方向平仓或平所有
			forex.GET("/batch_Close_by_type", forexController.BatchCloseByType)

			//撤单
			forex.GET("/cancel_trade", forexController.CancelTrade)

			//兑换参数
			forex.GET("/recharge_to_forex", forexController.RechargeToForex)

			//兑换提交
			forex.GET("/recharge_submit", forexController.RechargeSubmit)
		}

	}

	//无需登陆
	api := v1.Group("api")
	{

		forex := api.Group("forex")
		{
			//获取衍生品交易列表
			forex.GET("/trade_list", forexController.TradeList)

			//获取衍生品k线
			forex.GET("/kline", forexController.Kline)

			//获取衍生品k线
			forex.GET("/getMtKlineV2", forexController.GetMtKlineV2)

		}
		main := api.Group("main")
		{
			user := main.Group("user")
			{

				//获取图形验证码
				user.POST("getB64s_code", basic.GetB64sCode)
			}

		}
	}
	return r
}
