import { ForexKline, Order as ForexOrder } from './forex'

export interface DayMarket {
    symbol: string;
    currency_match_id: number;
    quotation: Quotation;
    type: string;
}

export interface Quotation {
    id: number;
    currency_match_id: number;
    change: string;
    volume: string;
    close: number;
    open: number;
    amount: string;
    high: number;
    low: number;
}

export interface KLineSymbol {
    symbol: string;
    kline: Kline;
    currency_match_id: number;
    type: string;
}

export interface Kline {
    id: number;
    period: string;
    "base-currency": string;
    "quote-currency": string;
    open: number;
    close: number;
    high: number;
    low: number;
    amount: number;
    volume: number;
    market_from: number;
    currency_match_id: number;
    time: number;
}


export interface MarketDepth {
    symbol: string;
    currency_match_id: number;
    depth: Depth;
    type: string;
}

export interface Depth {
    in: OrderInfo[];
    out: OrderInfo[];
    symbol: string;
    currency_match_id: number;
}

export interface OrderInfo {
    amount: number;
    price: string;
    sum: number;
    index: string;
}

export interface TxMatched {
    order: Order;
    way: string;
    type: string;
}

export interface Order {
    id: number;
    currency_match_id: number;
    user_id: number;
    price: string;
    number: string;
    transacted_volume: string;
    transacted_amount: string;
    quote_account_id: number;
    base_account_id: number;
    fee: string;
    created_at: Date;
    updated_at: Date;
}

export interface LeverTrade {
    type: string;
    to: number;
    currency_match_id: number;
    currency_match_name: string;
    hazard_rate: string;
    caution_money_all: string;
    origin_caution_money_all: string;
    profits_all: string;
    caution_money: string;
    origin_caution_money: string;
    profits: string;
    trades_all: Trades[];
    trades_entrust: any[];
    trades_cur: Trades[];
}

export interface Trades {
    id: number;
    type: number;
    user_id: number;
    currency_match_id: number;
    base_currency_id: number;
    quote_currency_id: number;
    origin_price: string;
    price: string;
    update_price: string;
    target_profit_price: string;
    stop_loss_price: string;
    share: number;
    number: string;
    multiple: number;
    origin_caution_money: string;
    caution_money: string;
    fact_profits: string;
    trade_fee: string;
    overnight: string;
    overnight_money: string;
    status: number;
    settled: number;
    create_time: number;
    transaction_time: Date;
    update_time: string;
    handle_time: string;
    complete_time: string;
    closed_type: number;
    agent_path: string;
    time: Date;
    profits: string;
    status_name: string;
    type_name: string;
}

export interface LeverClosed {
    id: number[];
    type: string;
}

export interface GlobalTx {
    symbol: string;
    currency_match_id: number;
    completes: Complete[];
    type: string;
}

export interface Complete {
    in_user_id: number;
    out_user_id: number;
    price: string;
    amount: string;
    way: number;
    currency_match_id: number;
    timestamp: number;
    forex_id: number;
}

export interface DAY_MARKET_DATA {
    type: string;
    symbol: string;
    quotation: {
        amount: number;
        change: number;
        close: number;
        forex_id: number;
        high: number;
        id: null;
        low: number;
        open: number;
        volume: number;
    };
}

export interface FOREX_TRADE_DATA {
    type: string;
    To: number;
    HazardRate: number;
    CautionMoneyAll: number;
    ProfitsTotal: number;
    OriginCautionMoneyTotal: number;
    TransOrder: ForexOrder[];
}

export interface FOREX_CLOSED_DATA {
    type: string;
    id: number[];
}

export interface FOREX_MarketDepth_DATA {
    depth: {
        forex_id: number,
        in: OrderInfo[],
        out: OrderInfo[],
        symbol: string
    },
    forex_id: number,
    symbol: string,
    type: string
}

export interface FOREX_Kline_DATA {
    forex_id: number,
    kline: ForexKline,
    type: string
    symbol: string
}

export interface Forex_GlobalTx {
    symbol: string;
    forex_id: number;
    completes: Complete[];
    type: string;
}