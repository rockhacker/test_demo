package accountmodel

import (
	"errors"
	"forex/services/model"
	"gorm.io/gorm"
	"gorm.io/gorm/clause"
)

//ForexAccounts 衍生品钱包
type ForexAccounts struct {
	Accounts
}

func NewForexAccount(db *gorm.DB) *ForexAccounts {

	return &ForexAccounts{

		Accounts{
			Balance:     0,
			LockBalance: 0,
			CurrencyId:  0,
			UserId:      0,
			Db:          db,
		},
	}
}

func (c *ForexAccounts) GetAccount(userId int64) (*Accounts, error) {

	currency := model.ForexSettleCurrency{}

	c.Db.Where("settle_status = ?", 1).First(&currency)

	if currency.Id == 0 {

		return nil, errors.New("无法找到结算币种")
	}

	err := c.Db.Clauses(clause.Locking{Strength: "UPDATE"}).Where("user_id = ? and currency_id = ? ", userId, currency.Id).Find(&c).Error

	return &c.Accounts, err
}
