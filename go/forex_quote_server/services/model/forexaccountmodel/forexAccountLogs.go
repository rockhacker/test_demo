package accountmodel

var ForexCaution = [2]interface{}{1001, "衍生品保证金"}
var ForexTransFee = [2]interface{}{1002, "衍生品下单手续费"}
var ForexTransAdd = [2]interface{}{1003, "衍生品平仓"}
var ForexTransFrozen = [2]interface{}{1004, "衍生品爆仓"}
var ForexTransFeeCancel = [2]interface{}{1005, "衍生品手续费撤回"}
var ForexTransCancel = [2]interface{}{1005, "衍生品保证金撤回"}

var ForexCashOut = [2]interface{}{2001, "衍生品兑出"}
var ForexCashIn = [2]interface{}{2002, "衍生品兑入"}

//ForexAccountLogs 衍生品钱包日志
type ForexAccountLogs struct {
	AccountLogs
}
