import { Currency } from "./user";

export interface Fund {
    id: number;
    title: string;
    currency_id: number;
    lock_dividend_days: number;
    created_at: Date;
    updated_at: Date;
    is_show: number;
    status: number;
    staring_sub_amount: string;
    max_sub_amount: string;
    liquidated_damages: number;
    dividend_percentage: number;
    image: string;
    desc: string;
    currency_code: string;
    status_str: string;
    currency: Currency;
}

export interface FundOrder {
    id: number;
    fund_id: number;
    user_id: number;
    sub_time: Date;
    created_at: Date;
    updated_at: Date;
    share_amount: string;
    is_return: number;
    status: number;
    surplus_period: number;
    interest_gen_next_time: Date;
    fund_amount: string;
    user_email: string;
    get_fund: Fund;
    get_user_info: GetUserInfo;
}

export interface GetUserInfo {
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

export interface MiningProfit {
    id: number;
    user_id: number;
    interest: string;
    fund_id: number;
    sub_id: number;
    created_at: Date;
    updated_at: Date;
    get_user_info: GetUserInfo;
}

export interface Ico {
    id:            number;
    currency_id:   number;
    issue_number:  number;
    subscribed:    number;
    start_time:    Date;
    finish_time:   Date;
    market_time:   Date;
    sub_price:     string;
    market_price:  string;
    created_at:    Date;
    updated_at:    Date;
    status:        number;
    is_show:       number;
    currency_name: string;
    currency:      Currency;
}

export interface IcoOrder {
    id:                  number;
    user_id:             number;
    sub_id:              number;
    number:              string;
    pay_currency_id:     number;
    pay_amount:          string;
    pay_last_price:      string;
    created_at:          Date;
    updated_at:          Date;
    status:              number;
    winning_lots_number: string;
    is_return:           number;
    currency_name:       string;
    pay_currency:        Currency;
    subscription:        Ico;
}
