import { Res } from "@/interface";
import { ForexDeal, ForexExchange, ForexKline, MyTransaction } from "@/interface/forex";
import { TradeItem } from "@/interface/forex";
import http from "@/utils/http";

// 获取衍生品交易对
export const getTradeList = http.get<
    { searchCurrency?: string },
    Res<TradeItem[]>
>("/v1/api/forex/trade_list");

// 获取衍生品兑换信息
export const getForexExchange = http.get<{}, Res<ForexExchange>>('/v1/api/forex/recharge_to_forex')

// 提交衍生品兑换订单
export const submitForexExchange = http.get<{ type: number, number: number, settle_id: number, currency_id: number }, Res<unknown>>('/v1/api/forex/recharge_submit')

// 获取当前衍生品交易对订单信息
export const getForexDeal = http.get<{ forex_id: number }, Res<ForexDeal>>('/v1/api/forex/deal')

// 提交衍生品订单
export const submitForexOrder = http.get<{ cont: number, multiple: number, forex_id: number, type: number, status: number, target_price?: number }>('/v1/api/forex/submit')

// 衍生品订单平仓
export const closeForexOrder = http.get<{ id: number }, Res<unknown>>('/v1/api/forex/close')

// 衍生品订单撤单
export const cancelForexOrder = http.get<{ id: number }, Res<unknown>>('/v1/api/forex/cancel_trade')

// 设置止盈止损
export const setOrderStopPrice = http.get<{ id: number, target_profit_price: number, stop_loss_price: number }, Res<unknown>>('/v1/api/forex/set_stop_price')

// 获取衍生品订单
export const getForexOrder = http.get<{ status: number, page: number }, Res<{ currency_page: number, data: MyTransaction[], total: number }>>('/v1/api/forex/my_deal')

// 获取k线历史数据
export const getFxKLineData = http.get<{ symbol?: string, period?: string, forex_id?: number }, Res<ForexKline[]>>('/v1/api/forex/kline')

// 一键平仓
export const closeForexOAllOrder = http.get<{ type: number }>('/v1/api/forex/batch_Close_by_type')