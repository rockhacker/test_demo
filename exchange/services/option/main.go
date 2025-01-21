package main

import (
    "github.com/joho/godotenv"
    "log"
    "option/database"
    "time"
)

func init() {

    err := godotenv.Load("../../.env")

    if err != nil {
        log.Fatal("无法加载配置文件" + err.Error())
    }

}

func main() {

    database.InitDB()

    periodRoutine := make(chan database.OptionPeriods)

    //运行期数，先运行这个方法，不然协程无法消费造成堵塞
    go GoroutinePeriod(periodRoutine)

    //重新启动后需要把以前还没结算的订单先重新开启协程去处理
    FixRunningPeriods(periodRoutine)

    //生成期数
    go func() {

        for {

            GeneratePeriods()

            time.Sleep(2 * time.Second)
        }
    }()

    //开始该期数
    go func() {

        for {

            RunningPeriod(periodRoutine)

            time.Sleep(2 * time.Second)
        }
    }()

    //找到没有结算的订单进行结算（兜底）
    go func() {

        for {

            ReviewOrder()
            time.Sleep(5 * time.Second)
        }
    }()

    select {}
}
