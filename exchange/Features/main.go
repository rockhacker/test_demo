package main

import (
	//"exchange_features/controllers"
	"exchange_features/database"
	"exchange_features/huobiApi"
	"exchange_features/routes"
	"github.com/joho/godotenv"
	"log"
	"os"
	"time"
)

func init() {

	err := godotenv.Load("../.env")

	if err != nil {
		log.Fatal("无法加载配置文件"+err.Error())
	}
}

func main() {

	defer func() {
		if err := recover(); err != nil {
			log.Println("服务重启")
			time.Sleep(3 * time.Second)
			server()
		}

	}()

	server()
	select {}
}

func server() {

	//连接数据库
	database.InitDB()

	//创建用户地址
// 	go new(controllers.CreateAddress).Check()

	//缓存火币行情协程
	go huobiApi.Cam()

	//存币生息服务和反佣
// 	go fundSubscription.RunServer().RunCommission()

	//http服务
	_ = routes.InitGinRouter().Run(os.Getenv("FEATURE_URL"))
}
