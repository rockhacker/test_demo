package database

import (
    "gorm.io/driver/mysql"
    "gorm.io/gorm"
    "log"
    "os"
)

var DB *gorm.DB

func InitDB(){

    var err error

    mysqlHost := os.Getenv("DB_HOST")
    //mysqlHost := "119.28.65.89"
    mysqlPort := os.Getenv("DB_PORT")
    mysqlName := os.Getenv("DB_DATABASE")
    mysqlUser := os.Getenv("DB_USERNAME")
    mysqlPass := os.Getenv("DB_PASSWORD")

    dsn := mysqlUser+":"+mysqlPass+"@tcp("+mysqlHost+":"+mysqlPort+")/"+mysqlName+"?charset=utf8mb4&parseTime=True&loc=Local"

    DB, err = gorm.Open(mysql.Open(dsn), &gorm.Config{})

    if err != nil {

        log.Fatal("无法连接数据库："+err.Error())
    }

    // SetMaxIdleConns 用于设置连接池中空闲连接的最大数量。
    sqlDb, _ := DB.DB()
    sqlDb.SetMaxIdleConns(10)

}
