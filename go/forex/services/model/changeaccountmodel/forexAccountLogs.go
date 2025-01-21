package accountmodel

var ForexCashOut = [2]interface{}{2001, "衍生品兑出"}
var ForexCashIn = [2]interface{}{2002, "衍生品兑入"}

//ChangeAccountLogs 币币钱包日志
type ChangeAccountLogs struct {
	AccountLogs
}
