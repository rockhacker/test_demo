package accountmodel

import (
	"errors"
	"gorm.io/gorm"
	"math"
	"time"
)

type Accounts struct {
	Wallet       `gorm:"-"`
	Balance      float64
	LockBalance  float64
	CurrencyId   int
	UserId       int64
	AccountsName string   `gorm:"-"`
	Db           *gorm.DB `gorm:"-"`
}

type AccountLogs struct {
	UserId     int64
	CurrencyId int
	Before     float64
	Value      float64
	After      float64
	Type       int
	Memo       string
	IsLock     int
	ExtraData  string
	CreatedAt  time.Time
	UpdatedAt  time.Time
}

type Wallet interface {
	GetAccount(*gorm.DB, int, int64) (*Accounts, error)
	ChangeBalance([2]interface{}, float64) error
	ChangeLockBalance([2]interface{}, float64) error
}

//ChangeBalance 改变账户余额
func (c *Accounts) ChangeBalance(logsType [2]interface{}, number float64) error {

	if number < 0 && c.Balance < math.Abs(number) {

		return errors.New("余额不足")
	}

	before := c.Balance
	c.Balance = c.Balance + number
	after := c.Balance

	err := c.Db.Model(&ChangeAccounts{}).Where("user_id = ? and currency_id = ? ", c.UserId, c.CurrencyId).Update("balance", c.Balance).Error

	if err != nil {

		return err
	}

	AccountLog := ChangeAccountLogs{}
	AccountLog.UserId = c.UserId
	AccountLog.CurrencyId = c.CurrencyId
	AccountLog.Before = before
	AccountLog.After = after
	AccountLog.Value = number
	AccountLog.IsLock = 0
	AccountLog.Type = logsType[0].(int)
	AccountLog.Memo = logsType[1].(string)
	AccountLog.CreatedAt = time.Now()
	AccountLog.UpdatedAt = time.Now()
	err = c.Db.Create(&AccountLog).Error

	if err != nil {

		return err
	}

	return nil
}
