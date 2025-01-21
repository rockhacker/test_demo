package redisDB

import (
	"forex_quote_server/conf"
	"github.com/go-redis/redis"
	log "github.com/sirupsen/logrus"
	"time"
)

// Db RedisDb 定义一个全局变量
var Db *redis.Client

func InitRedis() {

	Db = redis.NewClient(&redis.Options{
		Addr:     conf.Config.GetString("redis.host"), // 指定
		Password: conf.Config.GetString("redis.password"),
		DB:       conf.Config.GetInt("redis.db"), // redis一共16个库，指定其中一个库即可
	})

	_, err := Db.Ping().Result()

	if err != nil {

		log.Fatal("Redis 连接失败")
	}
}

func Set(key string, value interface{}, exp time.Duration) *redis.StatusCmd {

	return Db.Set(conf.Config.GetString("basic.app_name")+":"+key, value, exp)
}

func Get(key string) *redis.StringCmd {

	return Db.Get(conf.Config.GetString("basic.app_name") + ":" + key)
}
