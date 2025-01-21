package model

import "github.com/gin-gonic/gin"

const UserId = "userId"

// UserLock UserUnLock 是否锁定
const UserLock = 2
const UserUnLock = 1

type Users struct {
	Id          int64
	Uid         string
	Mobile      string
	Email       string
	Password    string
	PayPassword string
	Status      int
	TxStatus    int
	AgentPath   string
}

func GetUserId(c *gin.Context) int64 {

	return c.GetInt64(UserId)
}
