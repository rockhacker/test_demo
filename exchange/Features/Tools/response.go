package Tools

import "github.com/gin-gonic/gin"

type Response struct {
	Context *gin.Context
	Msg     string
}

func (r Response) Error(data interface{}) Response {

	if r.Msg == "" {

		r.Msg = "请求失败"
	}

	r.Context.JSON(200, map[string]interface{}{
		"code": 0,
		"msg":  r.Msg,
		"data": data,
	})

	return r
}

func (r Response) Success(data interface{}) Response {

	if r.Msg == "" {

		r.Msg = "请求成功"
	}
	r.Context.JSON(200, map[string]interface{}{
		"code": 1,
		"msg":  r.Msg,
		"data": data,
	})

    return r
}
