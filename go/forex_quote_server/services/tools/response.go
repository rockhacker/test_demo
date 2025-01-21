package tools

import (
	ginI18n "github.com/gin-contrib/i18n"
	"github.com/gin-gonic/gin"
	"net/http"
)

func Response(c *gin.Context, code int, msg string, data interface{}) {

	i8res := ginI18n.MustGetMessage(msg)

	if i8res == "" {

		i8res = msg
	}

	c.JSON(http.StatusOK, gin.H{
		"code": code,
		"msg":  i8res,
		"data": data,
	})
	c.Abort()
}
