package model

import (
	"encoding/json"
	"fmt"
	"forex_quote_server/services/tools"
	"github.com/golang-module/carbon/v2"
	"gorm.io/gorm"
	"time"
)

const (
	// ForexWayBuy ForexWaySell 下单方向
	ForexWayBuy  = 1
	ForexWaySell = 2

	// ForexTradeOn ForexTradeOff 交易对状态
	ForexTradeOn  = 1
	ForexTradeOff = 0

	//ForexStatusEntrust ForexStatusTransaction ForexStatusClosing ForexStatusClosed ForexStatusCancel 交易对状态
	ForexStatusEntrust     = 0 //挂单中
	ForexStatusTransaction = 1 //交易中
	ForexStatusClosing     = 2 //平仓中
	ForexStatusClosed      = 3 //已平仓
	ForexStatusCancel      = 4 //已撤单

	ForexCloseByUnknown      = 0 // 未知
	ForexCloseByUserSelf     = 1 // 用户平仓
	ForexCloseByMarketPrice  = 1 // 市场价平仓
	ForexCloseByOutOfMoney   = 2 // 暴仓
	ForexCloseByTargetProfit = 3 // 止盈平仓SendMarket
	ForexCloseByStopLoss     = 4 // 止损平仓
	ForexCloseByAdmin        = 5 // 后台管理员平仓

)

// ForexSettleCurrency 计价币
type ForexSettleCurrency struct {
	Id                 int `gorm:"primaryKey;unique"`
	CurrencyName       string
	SettleStatus       int     //1 计价
	RechargeCurrencyId int     //兑换币种
	RechargeBili       float64 //比例
	AccountName        string  `gorm:"-"` //账户名
}

func (f *ForexSettleCurrency) TransAccountName() string {
	f.AccountName = "衍生品账户"

	return f.AccountName
}

// ForexTradeLists 币种列表
type ForexTradeLists struct {
	Id               int `gorm:"primaryKey;unique"`
	Code             string
	TradeStatus      int     //1开启交易 0关闭交易
	ForexPointRate   float64 //点差率
	ForexFeeRate     float64 //手续费率
	ForexMinCont     float64 //最小张数
	ForexMaxCont     float64 //最大张数
	ForexContNum     int     //每张数量
	Sort             int     //排序
	MarketStartDay   string  //开启时间配置
	CreatedAt        time.Time
	UpdatedAt        time.Time
	HasForexMultiple []ForexMultiple `gorm:"foreignKey:forex_id"` //倍数
	ForexQuotations  ForexQuotations `gorm:"foreignKey:forex_id"` //行情
	MarketStatus     int             `gorm:"-"`                   //1交易中 2休市
	LastPrice        string          `gorm:"-"`                   //输出最新价格字符串
}

//CheckMarketStatus 检查是否市场开启 1开启 2关闭
func (f *ForexTradeLists) CheckMarketStatus() (marketStatus int) {

	//默认关闭
	marketStatus = 2

	marketStartDay := f.MarketStartDay
	fmt.Println(marketStartDay)

	type marketStart struct {
		Start string `json:"start"`
		End   string `json:"end"`
	}
	marketStartDaySct := map[int]marketStart{}
	err := json.Unmarshal([]byte(marketStartDay), &marketStartDaySct)
	if err != nil {

		return 2
	}
	//var cstZone = time.FixedZone("CST", 8*3600)
	t := time.Now()
	//统一计算时区
	zone, _ := t.Zone()
	carbonZC := carbon.SetTimezone(zone)

	for d, h := range marketStartDaySct {
		//现在时间,转化为当前设定时区计算
		nowTime := carbonZC.CreateFromTimestamp(t.Unix()).ToDateTimeString()

		w := carbon.Parse(nowTime).Week()

		if d == w {

			//市场开启
			marketStatus = 1

			//开始时间
			startTime := carbonZC.Now().ToDateString() + " " + h.Start
			fmt.Println(startTime, nowTime)
			//结束时间
			endTime := carbonZC.Now().ToDateString() + " " + h.End

			//判断当前时间是否大于可开盘时间
			if carbon.Parse(startTime).Gt(carbon.Parse(nowTime)) {
				marketStatus = 2
			}

			//判断当前时间是否小于休盘时间
			if carbon.Parse(endTime).Lt(carbon.Parse(nowTime)) {
				marketStatus = 2
			}

			break
		}
	}
	return marketStatus
}

//ForexMultiple 倍数
type ForexMultiple struct {
	Id        int `gorm:"primaryKey;unique"`
	ForexId   int
	Value     int //倍率
	CreatedAt time.Time
	UpdatedAt time.Time
}

//ForexQuotations 大宗外汇行情表
type ForexQuotations struct {
	Id      int `gorm:"primaryKey;unique"`
	ForexId int
	Change  float64   //涨跌幅
	Volume  float64   //成交量
	Close   float64   //当前价位
	Open    float64   //开盘价
	Amount  float64   //成交金额
	High    float64   //最高价
	Low     float64   //最低价
	NowTime time.Time //更新插入时间
}

func (f *ForexQuotations) GetOne(forexId int) ForexQuotations {

	DB.Where("forex_id = ?", forexId).First(f)

	return *f
}

//ForexQuotationRobots 大宗外汇订阅表
type ForexQuotationRobots struct {
	Id              int `gorm:"primaryKey;unique"`
	ForexId         int
	Status          int     //开启状态，0开启1关闭
	Decimal         float64 //小数位
	CreatedAt       time.Time
	Virtual         string //行情关联交易对名
	UpdatedAt       time.Time
	Point           float64         //浮点
	ForexTradeLists ForexTradeLists `gorm:"foreignKey:forex_id"` //币种详情
}

//ForexTransactions 订单表
type ForexTransactions struct {
	Id               int `gorm:"primaryKey;unique"`
	UserId           int64
	ForexId          int
	OriginPrice      float64 //初始价格
	OrderType        int     //ForexWayBuy ForexWaySell 下单方向
	Price            float64 //开仓价格(点差处理之后)
	SettleCurrencyId int     //结算货币
	UpdatePrice      float64 //当前价
	//交易状态: ForexStatusEntrust 挂单中 ForexStatusTransaction 交易中
	//ForexStatusClosing 平仓中 ForexStatusClosed 已平仓 ForexStatusCancel 已撤单
	Status             int
	TargetProfitPrice  float64 //止赢价格
	TargetLossPrice    float64 //止损价格
	Multiple           int
	OriginCautionMoney float64         //初始保证金
	CautionMoney       float64         //订单保证金
	FactProfits        float64         //最终盈亏
	TradeFee           float64         //手续费
	CreateTime         int64           //下单时间
	CreateTimeHandler  string          `gorm:"-"`
	TransactionTime    int64           //成交时间
	UpdateTime         int64           //价格刷新时间
	HandleTime         int64           //平仓时间
	CompleteTime       int64           //完成时间
	ClosedType         int             //平仓类型:0.未知,1.市价,2.暴仓,3.止盈,4.止损,5.后台
	AgentPath          string          //代理关系
	Quantity           float64         //订单数量
	ForexContNum       int             //每张的数量
	ForexTradeLists    ForexTradeLists `gorm:"foreignKey:forex_id"`
}

//AfterFind 查询钩子，计算盈亏
func (f *ForexTransactions) AfterFind(tx *gorm.DB) (err error) {
	if f.Status == ForexStatusTransaction {
		f.FactProfits = tools.Decimal(GetProfitByOne(*f), "%.8f")
	}
	f.CreateTimeHandler = time.Unix(f.CreateTime, 0).Format("2006-01-02 15:04:05")
	return
}

func GetRobots() (robot []ForexQuotationRobots) {

	DB.Where("status = ?", 1).Preload("ForexTradeLists").Find(&robot)
	return robot
}

type OrderEp struct {
	ProfitsTotal            float64
	CautionMoneyTotal       float64
	OriginCautionMoneyTotal float64
}

//GetUserProfit 取用户盈利和保证金
func GetUserProfit(userId int64, forexId int) OrderEp {
	sg := OrderEp{}

	w := map[string]interface{}{
		"user_id": userId,
		"status":  ForexStatusTransaction,
	}
	if forexId != 0 {
		w["forex_id"] = forexId
	}

	DB.Model(ForexTransactions{}).Where(w).Select("user_id").
		Select("SUM((CASE `order_type` WHEN 1 THEN `update_price` - `price` WHEN 2 THEN `price` - `update_price` END) * `quantity` * `forex_cont_num`) AS `profits_total`,SUM(`caution_money`) AS `caution_money_total`,SUM(`origin_caution_money`) AS `origin_caution_money_total`").
		Group("user_id").First(&sg)

	return sg
}

//GetAccountHazardRate 获取风险率
func GetAccountHazardRate(OrderEp OrderEp, balance float64) float64 {
	if OrderEp.CautionMoneyTotal != 0 {

		var hazardRate float64
		totalMoney := balance + OrderEp.OriginCautionMoneyTotal

		if totalMoney > 0 {
			hazardRate = tools.Decimal(((totalMoney+OrderEp.ProfitsTotal)/OrderEp.OriginCautionMoneyTotal)*100, "%.2f")
		}
		return hazardRate
	} else {

		return 0
	}

}

//GetProfitByOne 获取一个订单的盈亏
func GetProfitByOne(order ForexTransactions) float64 {

	var profit float64

	var profitCont float64

	if order.OrderType == ForexWayBuy {

		profitCont = order.UpdatePrice - order.Price
	} else {

		profitCont = order.Price - order.UpdatePrice
	}
	profit = (profitCont * order.Quantity) * float64(order.ForexContNum)

	return profit
}
