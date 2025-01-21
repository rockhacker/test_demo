package go_cache

import (
	"github.com/patrickmn/go-cache"
	"time"
)

var GoCache *cache.Cache

func init() {
	GoCache = cache.New(5*time.Minute, 60*time.Second)
}
