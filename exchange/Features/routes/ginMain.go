package routes

import (
    "exchange_features/controllers"
    "exchange_features/middlewares"
    "github.com/gin-gonic/gin"
)

func InitGinRouter() *gin.Engine {

    r := gin.Default()
    f := r.Group("feature")
    {
        //允许跨域
        f.Use(middlewares.Cors())
        f.Any("getKline", controllers.GetKline)
        f.Any("getCacheKline",controllers.GetCacheKline)
    }

    return r
}
