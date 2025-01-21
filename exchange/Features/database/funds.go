package database

import (
	"time"
)

const FundsSubscription = 1
const FundsToBeSubscribed = 2

type Funds struct {
	Id                 int64
	CurrencyId         int
	StartTime          time.Time //开始认购时间
	OverTime           time.Time //结束认购时间
	LockDividendDays   int       //锁仓天数
	LockDividendCount  int       //锁仓派息次数
	DividendPercentage float64   //派息百分比
	Status             int64
}

type FundsPeriods struct {
	Id            int64
	FundId        int64
	PeriodsNumber string    //期数编号
	Status        int       //1.未发放 2.已发放
	GrantInterest float64   //当期总发放利息
	GrantTime     time.Time //发放时间
	GrantSendTime time.Time //该期发放日
	EachDividend  float64   //当期派息百分比
	IsFy          int       //是否反佣
}

type SubFund struct {
	Id          int64
	ShareAmount float64 //认购的总金额
	UserId      int64
}

type InterestFunds struct {
	Id        int
	FundId    int64
	UserId    int64
	Interest  float64
	CreatedAt time.Time
	SubId     int64
	PeriodsId int64
}

func (SubFund) TableName() string {

	return "sub_fund"
}

type SetCommission struct {
	Levels string
	Status int
}

type FundCommissionLists struct {
	ForSubId          int64
	ForUserId         int64
	ForPeriodsId      int64
	UserId            int64
	ForFundId         int64
	CreatedAt         time.Time
	Amount            float64
	CommissionLevel   int
	CommissionSetData string
}
