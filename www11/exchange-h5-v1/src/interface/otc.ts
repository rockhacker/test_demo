import { Currency } from "./user";

export interface Otc {
    id: number;
    way: string;
    user_id: number;
    seller_id: number;
    currency_id: number;
    area_id: number;
    price: string;
    total_qty: string;
    completed_qty: string;
    dealing_qty: string;
    remain_qty: string;
    min_number: string;
    max_number: string;
    status: number;
    payways: Payway[];
    created_at: Date;
    started_at: Date;
    paused_at: null;
    stoped_at: null;
    canceled_at: null;
    finished_at: null;
    updated_at: Date;
    user_uid: string;
    seller_name: string;
    seller_uid: string;
    area_currency: string;
    status_name: string;
    payways_name: string;
    user: User;
    seller: Seller;
    area: Area;
}

export interface OtcRecord {
    id: number;
    master_id: number;
    currency_id: number;
    way: string;
    user_id: number;
    seller_id: number;
    seller_user_id: number;
    buy_user_id: number;
    sell_user_id: number;
    price: string;
    number: string;
    amount: string;
    pay_voucher: string;
    status: number;
    canceled_at: Date;
    payed_at: null;
    defered_at: null;
    arbitrated_at: null;
    finished_at: Date;
    created_at: Date;
    updated_at: Date;
    buy_user_account: string;
    sell_user_account: string;
    currency_name: string;
    sell_user_payways: OtcPaywayElement[];
    area_info: Area;
    pay_countdown: null;
    confirm_countdown: null;
    server_now: Date;
    buy_user: User;
    sell_user: User;
    currency: Currency;
    otc_payways: OtcPaywayElement[];
    master: Master;
}

export interface OtcOrderDetail {
    id: number;
    master_id: number;
    currency_id: number;
    way: string;
    user_id: number;
    seller_id: number;
    seller_user_id: number;
    buy_user_id: number;
    sell_user_id: number;
    price: string;
    number: string;
    amount: string;
    pay_voucher: string;
    status: number;
    canceled_at: Date;
    payed_at: null;
    defered_at: null;
    arbitrated_at: null;
    finished_at: Date;
    created_at: Date;
    updated_at: Date;
    buy_user_account: string;
    sell_user_account: string;
    currency_name: string;
    sell_user_payways: OtcPaywayElement[];
    area_info: Area;
    pay_countdown: Date | null;
    confirm_countdown: null;
    server_now: Date;
    buy_user: User;
    sell_user: User;
    currency: Currency;
    otc_payways: OtcPaywayElement[];
    master: Master;
}

export interface Area {
    id: number;
    code: string;
    name: string;
    currency: string;
    currency_symbol: string;
    decimal: number;
    global_code: string;
    lang_id: number;
    payways: string;
    timezone: string;
    sort: number;
    created_at: Date;
    updated_at: Date;
    lang_name: string;
    payway_name: string;
    lang: Lang;
}

export interface Lang {
    id: number;
    name: string;
    code: string;
    status: number;
    sort: number;
}

export interface Payway {
    id: number;
    name: string;
    code: string;
    logo: string;
    form_id: number;
    form_field: string;
    created_at: Date;
    updated_at: Date;
}

export interface Seller {
    id: number;
    user_id: number;
    name: string;
    status: number;
    created_at: Date;
    updated_at: Date;
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

export interface OtcListParams {
    way?: 'SELL' | 'BUY';
    page: number;
    currency_id: number;
}


export interface Master {
    id: number;
    way: string;
    user_id: number;
    seller_id: number;
    currency_id: number;
    area_id: number;
    price: string;
    total_qty: string;
    completed_qty: string;
    dealing_qty: string;
    remain_qty: string;
    min_number: string;
    max_number: string;
    status: number;
    payways: Payway[];
    created_at: Date;
    started_at: Date;
    paused_at: null;
    stoped_at: null;
    canceled_at: null;
    finished_at: null;
    updated_at: Date;
    user_uid: string;
    seller_name: string;
    seller_uid: string;
    currency_name: string;
    area_currency: string;
    status_name: string;
    payways_name: string;
    area: Area;
    user: User;
    seller: Seller;
    currency: Currency;
}

export interface Payway {
    id: number;
    name: string;
    code: string;
    logo: string;
    form_id: number;
    form_field: string;
    created_at: Date;
    updated_at: Date;
}

export interface Seller {
    id: number;
    user_id: number;
    name: string;
    status: number;
    created_at: Date;
    updated_at: Date;
    user: User;
}

export interface OtcPaywayElement {
    id: number;
    detail_id: number;
    user_id: number;
    payway_id: number;
    raw_data: RawData;
    created_at: Date;
    updated_at: Date;
    pay_code: string;
    payway: Payway;
}

export interface RawData {
    card_no: string;
    bank_code: string;
    bank_name: string;
    real_name: string;
    bank_address: string;
}

export interface OtcOrderAction {
    id: number;
    detail_id: number;
    user_id: number;
    buy_user_id: number;
    sell_user_id: number;
    status: number;
    operator_type: number;
    public_msg: Msg;
    to_buy_msg: Msg;
    to_sell_msg: Msg;
    memo: string;
    created_at: Date;
    updated_at: Date;
}

export interface Msg {
    type: string;
    title: string;
    content: string;
}
