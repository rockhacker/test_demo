package model

type Currencies struct {
	Id   int `gorm:"primaryKey;unique"`
	Code string
}
