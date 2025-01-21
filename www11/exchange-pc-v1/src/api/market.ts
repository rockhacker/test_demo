import { CurrencyMatches, GetKLine, Kline, PayableCurrency, Res, TradeSecond, Page, MicroOrder, TxOrder, LeverData, Transaction, LeverDealAll } from "@/interface";
import http from "@/utils/http";

// 获取交易对
export const getCurrencyMatches = http.get<{}, Res<CurrencyMatches[]>>("/api/market/currency_matches");

// 获取k线数据
export const getKLineData = http.get<GetKLine, Res<Kline[]>>('/api/market/kline')

// 秒合约下单时间
export const getMicroTradeSecond = http.get<{}, Res<TradeSecond[]>>('/api/microtrade/seconds')

// 秒合约交易模式列表
export const getMicroTradeMode = http.get<{}, Res<PayableCurrency[]>>('/api/microtrade/payable_currencies')

interface ISubmitMicroOrderParams {
    type: number; // type=1 买涨 type=2 买跌 
    currency_id: number;
    match_id: number;
    number: number;
    seconds: number;
}
// 秒合约下单
export const submitMicroOrder = http.post<ISubmitMicroOrderParams, Res<any>>('/api/microtrade/submit', undefined,
    {
        loading: true,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    })

interface IGetMicroOrderParams {
    status: number; // status=1 交易中 status=3 已平仓
    match_id: number;
    limit?: number;
    page: number;
}
// 秒合约订单
export const getMicroOrder = http.get<any, Res<Page<MicroOrder[]>>>('/api/microtrade/lists')

// 币币交易买入
export const buyCoin = http.post('/api/tx_in/add', {}, {
    loading: true
})

// 币币交易卖出
export const sellCoin = http.post('/api/tx_out/add', {}, {
    loading: true
})

// 币币交易买入订单
export const getTxInOrders = http.get<any, Res<Page<TxOrder[]>>>('/api/tx_in/list')

// 币币交易卖出订单
export const getTxOutOrders = http.get<any, Res<Page<TxOrder[]>>>('/api/tx_out/list')

// 撤销币币交易买入订单
export const cancelTxInOrder = http.get<{ id: number }, Res<any>>('/api/tx_in/cancel')

// 撤销币币交易卖出订单
export const cancelTxOutOrder = http.get<{ id: number }, Res<any>>('/api/tx_out/cancel')

// 获取历史委托
export const getTxHistoryOrder = http.get<{ page: number }, Res<Page<TxOrder[]>>>('/api/tx_history/list')


// 获取永续合约交易基本信息
export const getLeverData = http.post<{ currency_match_id: number }, Res<LeverData>>('/api/lever/deal')


interface LeverOrderParams {
    currency_match_id: number // 交易对id
    multiple: number // 倍数
    password?: string // 交易密码
    share: number // 手数
    status: number // 0 限价 1 市价
    target_price?: number // 限价
    type: number // 1 -> 买 2 -> 卖
}

// 永续合约下单
export const submitLeverOrder = http.post<LeverOrderParams, Res<any>>('/api/lever/submit', undefined, { loading: true })

// 永续合约下单
export const leverOrderClose = http.post<{ id: number }, Res<any>>('/api/lever/close', undefined, { loading: true })

// 永续设置止盈止损
export const leverOrderSetStop = http.post<{ id: number, stop_loss_price: number, target_profit_price: number }>('/api/lever/setstop', undefined, { loading: true })

// 获取兑换汇率
export const getExchangeRate = http.post<{ base_id: number, quote_id: number }, Res<{ last_price: number }>>('/api/exchange/lastPrice')

// 兑换
export const exchangeCoin = http.post<{ amount: number, base_id: number, quote_id: number, type: number }, Res<unknown>>('/api/exchange/submit', undefined, { loading: true })

// 获取永续订单
export const getLeverDealAll = http.post<{ currency_match_id: number, page: number }, Res<LeverDealAll>>('/api/lever/dealall')

// 一键平仓 -- 永续合约
export const closeLeverAllOrder = http.post<{ currency_match_id: number, type: number}, Res<unknown>>('/api/lever/batch_close')

// 永续订单记录
export const getLeverOrder = http.post<{ page: number, status: number }, Res<Page<Transaction[]>>>('/api/lever/my_trade')

// 永续订单 -- 撤单
export const cancelLeverOrder = http.post<{ id: number }, Res<unknown>>('/api/lever/cancel')