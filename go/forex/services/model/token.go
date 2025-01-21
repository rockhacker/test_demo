package model

import "time"

type Tokens struct {
	Id        int `gorm:"primaryKey;unique"`
	UserId    int64
	Token     string
	TimeoutAt time.Time
	CreatedAt time.Time
	updateAt  time.Time
}
