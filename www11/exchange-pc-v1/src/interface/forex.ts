export interface HasForexMultiple {
    Id: number;
    Forexid: number;
    Value: number;
    CreatedAt: string;
    UpdatedAt: string;
}

export interface ForexQuotation {
    Id: number;
    Forexid: number;
    Change: number;
    Volume: number;
    Close: number;
    Open: number;
    Amount: number;
    High: number;
    Low: number;
    NowTime: string;
}

export interface TradeItem {
    Id: number;
    Code: string;
    CategoryId: number;
    TradeStatus: number;
    ForexPointRate: number;
    ForexFeeRate: number;
    ForexMinCont: number;
    ForexMaxCont: number;
    ForexContNum: number;
    ShowCode: string;
    Sort: number;
    MarketStartDay: string;
    CreatedAt: string;
    UpdatedAt: string;
    HasForexMultiple: HasForexMultiple[];
    ForexQuotations: ForexQuotation;
    MarketStatus: number;
    Logo: string;
    LastPrice: string;
    MarginMode: number;
    Pip: number;
    PricePrecision: number;
}

export interface Order {
    Id: number;
    UserId: number;
    ForexId: number;
    OriginPrice: number;
    OrderType: number;
    Price: number;
    SettleCurrencyId: number;
    UpdatePrice: number;
    Status: number;
    TargetProfitPrice: number;
    TargetLossPrice: number;
    Multiple: number;
    OriginCautionMoney: number;
    CautionMoney: number;
    FactProfits: number;
    TradeFee: number;
    CreateTime: number;
    CreateTimeHandler: Date;
    TransactionTime: number;
    UpdateTime: number;
    HandleTime: number;
    CompleteTime: number;
    ClosedType: number;
    AgentPath: string;
    Quantity: number;
    ForexContNum: number;
    ForexTradeLists: ForexTradeLists;
}

export interface ForexTradeLists {
    Id: number;
    Code: string;
    TradeStatus: number;
    ForexPointRate: number;
    ForexFeeRate: number;
    ForexMinCont: number;
    ForexMaxCont: number;
    ForexContNum: number;
    ShowCode: string;
    Sort: number;
    MarketStartDay: string;
    CreatedAt: Date;
    UpdatedAt: Date;
    HasForexMultiple: null;
    ForexQuotations: ForexQuotations;
    MarketStatus: number;
    LastPrice: string;
    PricePrecision: number;
}

export interface ForexQuotations {
    Id: number;
    ForexId: number;
    Change: number;
    Volume: number;
    Close: number;
    Open: number;
    Amount: number;
    High: number;
    Low: number;
    NowTime: Date;
}

export interface ForexExchange {
    recharge_account: RechargeAccount;
    recharge_account_balance: number;
    recharge_bili: number;
    recharge_name: string;
    settle_account: SettleAccount;
    settle_account_balance: number;
    settle_name: string;
}

export interface RechargeAccount {
    Id: number;
    Code: string;
}

export interface SettleAccount {
    Id: number;
    CurrencyName: string;
    SettleStatus: number;
    RechargeCurrencyId: number;
    RechargeBili: number;
    AccountName: string;
}

export interface ForexDeal {
    forex_cont_limit: ForexContLimit;
    forex_user_balance: number;
    last_price: number;
    my_transaction: MyTransaction[];
    quotation: Quotation;
    settle_currency_code: string;
}

export interface ForexContLimit {
    max: number;
    min: number;
}

export interface MyTransaction {
    Id: number;
    UserId: number;
    ForexId: number;
    OriginPrice: number;
    OrderType: number;
    Price: number;
    SettleCurrencyId: number;
    UpdatePrice: number;
    Status: number;
    TargetProfitPrice: number;
    TargetLossPrice: number;
    Multiple: number;
    OriginCautionMoney: number;
    CautionMoney: number;
    FactProfits: number;
    TradeFee: number;
    CreateTime: number;
    CreateTimeHandler: Date;
    CompleteTimeHandler: Date;
    TransactionTime: number;
    UpdateTime: number;
    HandleTime: number;
    CompleteTime: number;
    ClosedType: number;
    AgentPath: string;
    Quantity: number;
    ForexContNum: number;
    ForexTradeLists: ForexTradeLists;
}

export interface ForexTradeLists {
    Id: number;
    Code: string;
    TradeStatus: number;
    ForexPointRate: number;
    ForexFeeRate: number;
    ForexMinCont: number;
    ForexMaxCont: number;
    ForexContNum: number;
    Sort: number;
    MarketStartDay: string;
    CreatedAt: Date;
    UpdatedAt: Date;
    HasForexMultiple: null;
    ForexQuotations: Quotation;
    MarketStatus: number;
    LastPrice: string;
}

export interface Quotation {
    Id: number;
    ForexId: number;
    Change: number;
    Volume: number;
    Close: number;
    Open: number;
    Amount: number;
    High: number;
    Low: number;
    NowTime: Date;
}

export interface ForexKline {
    Id: number;
    Close: number;
    Open: number;
    High: number;
    Low: number;
    Volume: number;
    Amount: number;
    Change: number;
    Period: string;
    Code: string;
    ForexId: number;
    Time: number;
}

export interface GetFxKLine {
    forex_id?: number,
    period?: string
    symbol?: string
}