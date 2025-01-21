package accountmodel

import (
	"gorm.io/gorm"
)

//ChangeAccounts 币币钱包
type ChangeAccounts struct {
	Accounts
}

func NewChangeAccount(db *gorm.DB) *ChangeAccounts {

	return &ChangeAccounts{
		Accounts{
			Balance:      0,
			LockBalance:  0,
			CurrencyId:   0,
			UserId:       0,
			AccountsName: "币币账户",
			Db:           db,
		},
	}
}

func (c *ChangeAccounts) GetAccount(userId int64, currencyId int) (*Accounts, error) {

	err := c.Db.Where("user_id = ? and currency_id = ? ", userId, currencyId).Find(&c).Error

	return &c.Accounts, err
}
