package base64Captcha

import (
	"context"
	"forex/services/redisDB"
	"github.com/mojocn/base64Captcha"
	"time"
)

// var store = base64Captcha.DefaultMemStore
var (
	key = "CAPTCHA_"
)

// NewDefaultRedisStore 重写store
func NewDefaultRedisStore() *RedisStore {
	return &RedisStore{
		Expiration: time.Second * 10 * 60, //10分钟过期
		PreKey:     key,
	}
}

type RedisStore struct {
	Expiration time.Duration
	PreKey     string
	Context    context.Context
}

func (rs *RedisStore) UseWithCtx(ctx context.Context) base64Captcha.Store {
	rs.Context = ctx
	return rs
}

// 实现store接口

func (rs *RedisStore) Set(id string, value string) error {
	err := redisDB.Db.Set(rs.PreKey+id, value, rs.Expiration).Err()

	if err != nil {
		return err
	}
	return nil
}

func (rs *RedisStore) Get(key string, clear bool) string {
	val, err := redisDB.Db.Get(key).Result()
	if err != nil {
		return ""
	}
	if clear {
		err := redisDB.Db.Del(key).Err()
		if err != nil {
			return ""
		}
	}
	return val
}

func (rs *RedisStore) Verify(id, answer string, clear bool) bool {
	key := rs.PreKey + id
	v := rs.Get(key, clear)
	return v == answer
}

func GenerateCaptcha() (id string, b64s string, err error) {

	store := NewDefaultRedisStore()

	driver := base64Captcha.NewDriverDigit(80, 240, 6, 0.7, 80)

	c := base64Captcha.NewCaptcha(driver, store)
	id, b64s, err = c.Generate()

	return c.Generate()
}
