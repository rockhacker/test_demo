package model

import (
	"forex_quote_server/conf"
	log "github.com/sirupsen/logrus"
	"gorm.io/driver/mysql"
	"gorm.io/gorm"
	"gorm.io/gorm/logger"
	"time"
)

var DB *gorm.DB

func InitDB() {

	username := conf.Config.GetString("mysql.username")
	password := conf.Config.GetString("mysql.password")
	tableName := conf.Config.GetString("mysql.tableName")
	host := conf.Config.GetString("mysql.host")
	port := conf.Config.GetString("mysql.port")
	dsn := username + ":" + password + "@tcp(" + host + ":" + port + ")/" + tableName + "?charset=utf8mb4&parseTime=True&loc=Local"

	newLogger := logger.New(
		log.New(),
		logger.Config{
			SlowThreshold:             time.Second,   // 慢 SQL 阈值
			LogLevel:                  logger.Silent, // 日志级别
			IgnoreRecordNotFoundError: true,          // 忽略ErrRecordNotFound（记录未找到）错误
			Colorful:                  false,         // 禁用彩色打印
		},
	)

	db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{
		Logger: newLogger,
	})
	//db.Debug()
	if err != nil {
		log.Fatal(err)
	}

	///*如不需要或创建失败可删除*/
	//err = db.Use(
	//	dbresolver.Register(dbresolver.Config{}).
	//		SetConnMaxIdleTime(time.Hour).
	//		SetConnMaxLifetime(24 * time.Hour).
	//		SetMaxIdleConns(20).
	//		SetMaxOpenConns(40))
	//if err != nil {
	//	log.Fatal("创建Mysql连接池失败")
	//}

	DB = db
}
