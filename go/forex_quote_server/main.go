package main

import (
	"forex_quote_server/commands/mtserver"
	"forex_quote_server/conf"
	_ "forex_quote_server/services/cache/go-cache"
	"forex_quote_server/services/model"
	"forex_quote_server/services/redisDB"
	"forex_quote_server/services/tools"
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

	mtserver.RunMt()

}
