import { Page } from ".";
import { Currency } from "./user";

// 获取交易对相关接口
export interface CurrencyMatches {
    id: number;
    code: string;
    logo: string;
    desc: string;
    decimal: number;
    accounts_display: string[];
    is_quote: number;
    usd_price: string;
    cny_price: string;
    draw_rate: string;
    draw_min: string;
    draw_max: string;
    created_at: Date;
    updated_at: Date;
    open_draw: number;
    micro_trade_fee: string;
    open_recharge: number;
    sort: number;
    is_pb: number;
    main_coin_type: null | string;
    coin_type: null | string;
    is_db: number;
    option_trade_fee: string;
    is_new: number;
    micro_account_display: boolean;
    change_account_display: boolean;
    lever_account_display: boolean;
    legal_account_display: boolean;
    option_account_display: boolean;
    matches: Match[];
}

export interface Match {
    id: number;
    quote_currency_id: number;
    base_currency_id: number;
    market_from: number;
    open_lever: number; // 永续是否打开
    open_change: number; // 币币交易是否打开
    open_iso: number;
    open_microtrade: number; // 交割是否打开
    lever_point_rate: string;
    lever_overnight_fee_rate: string;
    lever_fee_rate: string;
    change_fee_rate: string;
    use_process: number;
    lever_min_share: number;
    lever_max_share: number;
    lever_share_num: number;
    auto_match: number;
    match_user_id: number;
    sort: number;
    order_risk_rate: string;
    created_at: Date;
    updated_at: Date;
    floating_point: string;
    open_option: number;
    market_time: Date;
    is_new: number;
    process_id: number;
    decimal: number;
    symbol: string;
    base_currency_code: string;
    quote_currency_code: string;
    lower_symbol: string;
    currency_quotation: CurrencyQuotation;
    base_currency: CurrencyMatches;
    quote_currency: CurrencyMatches;
}

export interface CurrencyQuotation {
    id: number;
    currency_match_id: number;
    change: string;
    volume: string;
    close: number;
    open: string;
    amount: string;
    high: string;
    low: string;
}


// k线相关接口
export interface GetKLine {
    currency_match_id?: number,
    period?: string
    symbol?: string
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


export interface TradeSecond {
    id: number;
    seconds: number;
    status: number;
    profit_ratio: string;
    created_at: Date;
    updated_at: Date;
}

export interface MicroNumber {
    id: number;
    currency_id: number;
    number: string;
    created_at: Date;
    updated_at: Date;
    currency_code: string;
    currency: PayableCurrency;
}

export interface PayableCurrency {
    id: number;
    code: string;
    logo: string;
    desc: string;
    decimal: number;
    accounts_display: string[];
    is_quote: number;
    usd_price: string;
    cny_price: string;
    draw_rate: string;
    draw_min: string;
    draw_max: string;
    created_at: Date;
    updated_at: Date;
    open_draw: number;
    micro_trade_fee: string;
    open_recharge: number;
    sort: number;
    is_pb: number;
    main_coin_type: string;
    coin_type: string;
    is_db: number;
    option_trade_fee: string;
    is_new: number;
    micro_account?: MicroAccount;
    micro_account_display: boolean;
    change_account_display: boolean;
    lever_account_display: boolean;
    legal_account_display: boolean;
    option_account_display: boolean;
    micro_numbers?: MicroNumber[];
}

export interface MicroAccount {
    id: number;
    user_id: number;
    currency_id: number;
    account_type_id: number;
    balance: string;
    lock_balance: string;
    created_at: Date;
    updated_at: Date;
    p_show: number;
}


export interface MicroOrder {
    id: number;
    user_id: number;
    match_id: number;
    currency_id: number;
    type: number;
    is_insurance: number;
    seconds: number;
    number: string;
    open_price: string;
    end_price: string;
    fee: string;
    profit_ratio: string;
    fact_profits: string;
    status: number;
    profit_result: number;
    created_at: Date;
    updated_at: Date;
    handled_at: Date;
    complete_at: Date;
    agent_path: string;
    settled: number;
    currency_code: string;
    symbol_name: string;
    account: string;
    type_name: string;
    status_name: string;
    profit_result_name: string;
    remain_milli_seconds: number;
    currency: Currency;
    currency_match: CurrencyMatch;
}

export interface CurrencyMatch {
    id: number;
    quote_currency_id: number;
    base_currency_id: number;
    market_from: number;
    open_lever: number;
    open_change: number;
    open_iso: number;
    open_microtrade: number;
    lever_point_rate: string;
    lever_overnight_fee_rate: string;
    lever_fee_rate: string;
    change_fee_rate: string;
    use_process: number;
    lever_min_share: number;
    lever_max_share: number;
    lever_share_num: number;
    auto_match: number;
    match_user_id: number;
    sort: number;
    order_risk_rate: string;
    created_at: Date;
    updated_at: Date;
    floating_point: string;
    open_option: number;
    market_time: null;
    is_new: number;
    process_id: number;
    symbol: string;
    base_currency_code: string;
    quote_currency_code: string;
    lower_symbol: string;
    base_currency: Currency;
    quote_currency: Currency;
}

export interface TxOrder {
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
    created_at: string;
    updated_at: string;
    currency_match: CurrencyMatch;
    way: number;
    status_name: string;
}

export interface ECurrency {
    id: number;
    code: string;
    logo: string;
    desc: string;
    decimal: number;
    accounts_display: string[];
    is_quote: number;
    usd_price: string;
    cny_price: string;
    draw_rate: string;
    draw_min: string;
    draw_max: string;
    created_at: Date;
    updated_at: Date;
    open_draw: number;
    micro_trade_fee: string;
    open_recharge: number;
    sort: number;
    is_pb: number;
    main_coin_type: string;
    coin_type: string;
    is_db: number;
    option_trade_fee: string;
    is_new: number;
    micro_account_display: boolean;
    change_account_display: boolean;
    lever_account_display: boolean;
    legal_account_display: boolean;
    option_account_display: boolean;
}

export interface LeverData {
    quotation: Quotation;
    my_transaction: Transaction[];
    lever_share_limit: LeverShareLimit;
    multiple: Multiple;
    last_price: number;
    user_lever: string;
    all_levers: number;
    ustd_price: number;
}

export interface LeverShareLimit {
    min: number;
    max: number;
}

export interface Multiple {
    muit: Muit[];
    share: any[];
}

export interface Muit {
    value: string;
}

export interface Quotation {
    id: number;
    currency_match_id: number;
    change: string;
    volume: string;
    close: number;
    open: string;
    amount: string;
    high: string;
    low: string;
    cny_price: string;
    currency_match: CurrencyMatch;
}

export interface Transaction {
    id: number;
    type: number;
    user_id: number;
    currency_match_id: number;
    currency_match: CurrencyMatch;
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
    user: User;
}

export interface User {
    id: number;
    uid: string;
    mobile: string;
    email: string;
    area_id: number;
    status: number;
    tx_status: number;
    parent_id: number;
    invite_code: string;
    last_login_at: Date;
    parents_path: string;
    agent_id: number;
    agent_node_id: number;
    agent_path: string;
    updated_at: Date;
    created_at: Date;
    is_create_address: number;
    micro_cont_status: number;
    micro_risk_profit_probability: number;
    credit_score: number;
    level: string;
    head_image: null;
    is_withdraw: number;
}

export interface LeverDealAll {
    balance: string;
    hazard_rate: string;
    caution_money_total: string;
    origin_caution_money_total: string;
    profits_total: string;
    caution_money: string;
    origin_caution_money: string;
    profits: string;
    order: Page<Transaction[]>;
}