package main

import (
	"forex/commands/mtQuote"
	"forex/commands/mtserver"
	"forex/conf"
	"forex/services/api"
	apiWs "forex/services/api/ws"
	_ "forex/services/cache/go-cache"
	"forex/services/logic"
	"forex/services/model"
	"forex/services/redisDB"
	"forex/services/tools"
	"github.com/zh-five/xdaemon"
	"os"
)

func init() {

	//读取配置文件
	conf.Init()

	//设置时区
	_ = os.Setenv("TZ", conf.Config.GetString("basic.tz"))

	//加载日志系统
	tools.LogInit()

	//连接数据库
	model.InitDB()

	//连接Redis
	redisDB.InitRedis()
}

func main() {

	//
	//fmt.Println(market.FormatTimeline("60min", time.Now()))
	//v := model.ForexTradeLists{}
	//
	//model.DB.Where("id = 2").First(&v)
	//fmt.Println(v.CheckMarketStatus())

	if conf.Config.GetBool("basic.daemon") {

		//启动一个子进程后主程序退出
		_, _ = xdaemon.Background(conf.Config.GetString("basic.daemonFile"), true)
	}

	//启动APi Ws客户端服务
	go apiWs.RunJobs()

	//查找行情
	//go mtserver.NewSyncMTConnect()
	go mtserver.RunMt()

	//行情服务初始化
	go mtQuote.Init()

	//衍生品平仓
	go logic.RunCheckNeedClosingOrder()

	//衍生品检查爆仓
	go logic.RunCheckNeedBurst()

	err := api.Route().Run(conf.Config.GetString("basic.listenAndServe"))
	if err != nil {

		return
	}
}
