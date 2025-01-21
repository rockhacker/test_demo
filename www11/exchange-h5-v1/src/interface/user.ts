export interface AccountDetail {
    id: number;
    user_id: number;
    currency_id: number;
    account_type_id: number;
    balance: number;
    lock_balance: string;
    created_at: Date;
    updated_at: Date;
    p_show: number;
    convert_cny: number;
    convert_usd: string;
    account_type: AccountType;
    currency: Currency;
}

export interface AccountType {
    id: number;
    name: string;
    classname: string;
    account_code: string;
    is_recharge: number;
    is_display: number;
}

export interface QuickCharge {
    id: number;
    currency_id: number;
    address: string;
    created_at: Date;
    updated_at: Date;
    currency_protoc_id: number;
    currency_code: string;
    protocol_code: string;
    currency_code_protocol: string;
    currency: Currency;
    currency_protocol: CurrencyProtocol;
}

export interface ChangeAccount {
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

export interface Currency {
    id: number;
    code: string;
    logo: string;
    desc: string;
    decimal: number;
    accounts_display: string[];
    change_account: ChangeAccount,
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
    account_types: AccountType[];
    is_recharge_account: boolean;
    currency_protocols: CurrencyProtocol[];
}



export interface CurrencyProtocol {
    id: number;
    chain_protocol_id: number;
    currency_id: number;
    in_address: string;
    out_address: string;
    decimal: number;
    token_address: string;
    chain_protocol: ChainProtocol;
}

export interface ChainProtocol {
    id: number;
    code: string;
}

export interface UserInfo {
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
    is_seller: boolean;
    seller: Seller;
}

export interface Seller {
    id: number;
    user_id: number;
    name: string;
    status: number;
    created_at: Date;
    updated_at: Date;
}

export interface Account {
    id: number;
    name: string;
    account_code: AccountCode;
    is_recharge: number;
    is_display: number;
    convert_usd: string;
    convert_lock_usd: string;
    accounts: AccountElement[];
}

export enum AccountCode {
    ChangeAccount = "change_account",
    LegalAccount = "legal_account",
    LeverAccount = "lever_account",
    MicroAccount = "micro_account",
    OptionAccount = "option_account",
}

export interface AccountElement {
    id: number;
    currency_id: number;
    balance: string;
    lock_balance: string;
    convert_usd: string;
    currency_code: string;
    sum_balance: string;
    currency: Currency;
}

export interface AccountType {
    id: number;
    name: string;
    classname: string;
    account_code: string;
    is_recharge: number;
    is_display: number;
}

export interface CurrencyProtocol {
    id: number;
    code: string;
    logo: string;
    micro_account_display: boolean;
    change_account_display: boolean;
    lever_account_display: boolean;
    legal_account_display: boolean;
    option_account_display: boolean;
    currency_protocols: CurrencyProtocolElement[];
}

export interface CurrencyProtocolElement {
    id: number;
    chain_protocol_id: number;
    currency_id: number;
    token_address: string;
    chain_protocol: ChainProtocol;
}

export interface ChainProtocol {
    id: number;
    code: string;
}

export interface WithdrawItem {
    id: number;
    currency_id: number;
    user_id: number;
    address: string;
    number: string;
    status: number;
    fee: string;
    real_number: string;
    created_at: Date;
    updated_at: Date;
    review_at: string;
    tx_hash_id: number;
    use_chain_api: number;
    memo: string;
    notes: string;
    account_type_id: number;
    currency_protocol_id: number;
    finish_time: null;
    businessId: string;
    status_name: string;
}

export interface TransferItem {
    id: number;
    currency_id: number;
    user_id: number;
    from: string;
    to: string;
    balance: string;
    memo: string;
    created_at: Date;
    updated_at: Date;
    from_name: string;
    to_name: string;
}

export interface CollectMethodItem {
    id: number;
    name: string;
    code: string;
    logo: string;
    form_id: number;
    form_field: string;
    created_at: Date;
    updated_at: Date;
}

export interface FlatBindData {
    id: number;
    user_id: number;
    payway_id: number;
    form_id: number;
    raw_data: RawData;
    created_at: Date;
    updated_at: Date;
    pay_code: string;
    payway: Payway;
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

export interface RawData {
    card_no: string;
    bank_code: string;
    bank_name: string;
    real_name: string;
    bank_address: string;
}

export interface AccontLogItem {
    id: number;
    currency_id: number;
    type: number;
    user_id: number;
    from_id: number;
    before: string;
    value: string;
    after: string;
    is_lock: number;
    memo: string;
    extra_data: ExtraData;
    created_at: Date;
    updated_at: Date;
    is_lock_name: string;
    currency: Currency;
}

export interface ExtraData {
    strict: boolean;
}

export interface FeedbackItem {
    id: number;
    user_id: number;
    type_id: number;
    title: string;
    content: string;
    reply: null | string;
    is_display: number;
    is_replied: number;
    created_at: Date;
    updated_at: Date;
    type_name: null;
}
