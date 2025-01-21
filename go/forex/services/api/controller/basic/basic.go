package basic

import (
	"forex/services/tools"
	"forex/services/tools/base64Captcha"
	"github.com/gin-gonic/gin"
)

func GetB64sCode(c *gin.Context) {

	id, b64s, err := base64Captcha.GenerateCaptcha()

	if err != nil {

		tools.Response(c, 0, "Err", nil)
		return

	}

	data := map[string]interface{}{
		"id":   id,
		"b64s": b64s,
	}

	tools.Response(c, 1, "", data)
	return
}
