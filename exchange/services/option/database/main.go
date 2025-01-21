package database

import (
	"gorm.io/driver/mysql"
	"gorm.io/gorm"
	"log"
	"os"
	"time"
)

var DB *gorm.DB

func InitDB() {
	var err error
	mysqlHost := os.Getenv("DB_HOST")
	mysqlPort := os.Getenv("DB_PORT")
	mysqlName := os.Getenv("DB_DATABASE")
	mysqlUser := os.Getenv("DB_USERNAME")
	mysqlPass := os.Getenv("DB_PASSWORD")

	dsn := mysqlUser + ":" + mysqlPass + "@tcp(" + mysqlHost + ":" + mysqlPort + ")/" + mysqlName + "?charset=utf8mb4&parseTime=True&loc=Local"

	DB, err = gorm.Open(mysql.Open(dsn), &gorm.Config{})

	if err != nil {

		log.Fatal("无法连接数据库：" + err.Error())
	}
	// SetMaxIdleConns 用于设置连接池中空闲连接的最大数量。

	sqlDb, _ := DB.DB()
	sqlDb.SetMaxIdleConns(10)

}

type OptionSecond struct {
	Id          int64
	Seconds     int64
	Status      int
	ProfitRatio float64
}

type OptionPeriods struct {
	Id                int64
	Period            int64
	SecondsId         int64
	Status            int
	Result            int //0未开奖1涨2跌
	ResultTime        time.Time
	StartTime         time.Time
	CreatedTime       time.Time
	CapStartTimestamp int64
	CapEndTimestamp   int64
	CurrencyMatchId   int64
	OpenPrice         float64
	ClosePrice        float64
}

type OptionOrders struct {
	Id           int64
	Status       int
	HandleTime   time.Time
	Type         int
	Result       int
	Number       float64
	CurrencyId   int
	UserId       int64
	ResultAmount float64
	SecondId     int64
}

type CurrencyMatches struct {
	Id              int64
	QuoteCurrencyId int64
	BaseCurrencyId  int64
}

type Currencies struct {
	Code string
}

const (
	PeriodsNotRun     = iota //未开始
	PeriodsRunning           //正在运行
	PeriodsSettlement        //结算中
	PeriodsFinish            //已结束
)
const (
	PeriodsOrderTrading    = iota + 1 //交易中
	PeriodsOrderSettlement            //结算中
	PeriodsOrderFinish                //已结束
)
