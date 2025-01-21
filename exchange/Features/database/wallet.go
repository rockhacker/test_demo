package database

import (
	"errors"
	"gorm.io/gorm"
	"math"
    "time"
)

var SubInterest = [2]interface{}{
	211,
	"认购收益",
}
var SubPrincipal = [2]interface{}{
	212,
	"认购本金退还",
}
var FundCommission = [2]interface{}{
    213,
    "生息返佣",
}


type walletModel struct {
	Db *gorm.DB `gorm:"-"`
}

type ChangeAccountLogs struct {
	UserId     int64
	CurrencyId int
	Before     float64
	Value      float64
	After      float64
	Type       int
	Memo       string
	IsLock     int
	ExtraData  string
    CreatedAt   time.Time
    UpdatedAt   time.Time
}

type ChangeAccounts struct {
	walletModel `gorm:"-"`
	Balance     float64
	LockBalance float64
}

type ReturnAccount struct {
	ChangeAccounts `gorm:"-"`
	currencyId     int
	userId         int64
}

func NewChangeAccount(db *gorm.DB) ChangeAccounts {
    return ChangeAccounts{
        walletModel{
            Db: db,
        },
        0,
        0,
    }
}

//GetAccount 获取用户的币币账户
func (c ChangeAccounts) GetAccount(currencyId int, userId int64) (*ReturnAccount, error) {

	err := c.Db.Where("user_id = ? and currency_id = ? ", userId, currencyId).Find(&c).Error

	r := new(ReturnAccount)
	r.ChangeAccounts = c
	r.currencyId = currencyId
	r.userId = userId

	return r, err
}

//ChangeBalance 改变账户余额
func (c ReturnAccount) ChangeBalance(logsType [2]interface{}, number float64) error {

	if number < 0 && c.Balance < math.Abs(number) {

		return errors.New("余额不足")
	}

	before := c.Balance
	c.Balance = c.Balance + number
	after := c.Balance

	err := c.ChangeAccounts.Db.Model(&ChangeAccounts{}).Where("user_id = ? and currency_id = ? ", c.userId, c.currencyId).Update("balance", c.Balance).Error

	if err != nil {

		return err
	}

	AccountLog := ChangeAccountLogs{}
	AccountLog.UserId = c.userId
	AccountLog.CurrencyId = c.currencyId
	AccountLog.Before = before
	AccountLog.After = after
	AccountLog.Value = number
	AccountLog.IsLock = 0
	AccountLog.Type = logsType[0].(int)
	AccountLog.Memo = logsType[1].(string)
    AccountLog.CreatedAt = time.Now()
    AccountLog.UpdatedAt = time.Now()
	err = c.ChangeAccounts.Db.Create(&AccountLog).Error

	if err != nil {

		return err
	}

	return nil
}

func (c ReturnAccount) ChangeLockBalance(logsType [2]interface{}, number float64) error {

	if number < 0 && c.LockBalance < math.Abs(number) {

		return errors.New("锁定余额不足")
	}

	before := c.LockBalance
	c.Balance = c.LockBalance + number
	after := c.LockBalance

	err := c.ChangeAccounts.Db.Model(&ChangeAccounts{}).Where("user_id = ? and currency_id = ? ", c.userId, c.currencyId).Update("lock_balance", c.LockBalance).Error

	if err != nil {

		return err
	}

	AccountLog := ChangeAccountLogs{}
	AccountLog.UserId = c.userId
	AccountLog.CurrencyId = c.currencyId
	AccountLog.Before = before
	AccountLog.After = after
	AccountLog.Value = number
	AccountLog.IsLock = 1
	AccountLog.Type = logsType[0].(int)
	AccountLog.Memo = logsType[1].(string)
    AccountLog.CreatedAt = time.Now()
    AccountLog.UpdatedAt = time.Now()
	err = c.ChangeAccounts.Db.Create(&AccountLog).Error

	if err != nil {

		return err
	}

	return nil
}
