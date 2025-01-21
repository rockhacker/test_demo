package Tools

import (
	"github.com/go-redis/redis/v8"
	"os"
)

func InitRedis() *redis.Client {

	rdb := redis.NewClient(&redis.Options{
		Addr:     "127.0.0.1:6379",
		Password: os.Getenv("REDIS_PASSWORD"), // no password set
		DB:       0,                           // use default DB
	})
	return rdb
}
