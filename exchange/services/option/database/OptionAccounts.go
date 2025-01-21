package database

import (
    "gorm.io/gorm"
    "time"
)

var OptionTradeOrderClose = [2]interface{}{222, "期权平仓"}

//OptionAccounts 期权钱包
type OptionAccounts struct {
    Accounts
}

type OptionAccountLogs struct {
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

func NewOptionAccount(db *gorm.DB) *OptionAccounts {

    return &OptionAccounts{
        Accounts{
            Balance: 0,
            LockBalance: 0,
            CurrencyId:0,
            UserId: 0,
            Db: db,
        },
    }
}

func (c *OptionAccounts) GetAccount(currencyId int, userId int64) (*Accounts, error) {

   err := c.Db.Where("user_id = ? and currency_id = ? ", userId, currencyId).Find(&c).Error

   return &c.Accounts, err
}
