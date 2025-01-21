package handle

import (
	"forex/services/model"
	"forex/services/tools"
	"github.com/gin-gonic/gin"
)

func ApiAuth(c *gin.Context) {

	authorization := c.GetHeader("AUTHORIZATION")

	token := model.Tokens{}

	model.DB.Where("token = ?", authorization).First(&token)

	if token.Id == 0 {

		tools.Response(c, 999, "请登入", nil)
		c.Abort()
	}

	c.Set("userId", token.UserId)

	c.Next()
}
