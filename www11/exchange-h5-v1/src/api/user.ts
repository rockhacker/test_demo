
import http from "@/utils/http";
import { Page, Res } from "@/interface";
import { AccontLogItem, Account, AccountDetail, CollectMethodItem, CurrencyProtocol, FeedbackItem, FlatBindData, QuickCharge, TransferItem, UserInfo, WithdrawItem } from "@/interface/user";

// 注册接口
export const submitRegister = http.post<any, Res<any>>('/api/user/register', undefined,
    {
        loading: true,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    })

// 登录接口
export const submitLogin = http.post('/api/user/login', undefined,
    {
        loading: true,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    })

export const walletLogin = http.post('/api/user/login_for_wallet', undefined,
    {
        loading: true,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    })

// 获取账户详情
export const accountDetail = http.get<{ account_type_id?: number, currency_id?: number, id?: number }, Res<AccountDetail>>('/api/account/detail')

// 获取用户信息
export const getUserInfo = http.get<{}, Res<UserInfo>>('/api/user/info')

// 获取充值列表
export const getQuickChargeList = http.get<{}, Res<QuickCharge[]>>('/api/quickCharge/info')

// 提交充值凭证
export const chargeDataSubmit = http.get(
    "/api/quickCharge/submit",
    {},
    { loading: true }
);

// 实名认证
export const realName = http.post("/api/user_real/real_name");

// 查询用户实名状态
export const queryAuthStatus = http.get("/api/user_real/center");

// 获取资产信息
export const getAccountList = http.get<{}, Res<Account[]>>("/api/account/list")

// 获取提币币种类型
export const getCurrencyProtocols = http.get<{}, Res<CurrencyProtocol[]>>('/api/block_chain/currency_protocols')

// 获取绑定的提币地址
export const getDrawAddress = http.get<{ user_id?: number, coin_name?: string, contract_address?: string, currency_id?: number, currency_protocol_id?: number }, Res<{ address: string, fee: null | number, meno: string | null }>>('/walletMiddle/GetDrawAddress')

// 绑定提币地址
export const bindWithdrawAddress = http.post<{ data: string, sign: string }, Res<unknown>>('/walletMiddle/BindDrawAddress', undefined, {
    loading: true,
    headers: {
        "Content-Type": "application/x-www-form-urlencoded",
    },
})

// 提币
export const withdrawCoin = http.post<{ address: string, currency_id: number | string, currency_protocol_id: number | string, memo?: string, number: number, pay_password: string }, Res<unknown>>('/api/account/draw', undefined, { loading: true })

// 提币记录
export const getWithdrawList = http.get<{ currency_id: number, page: number }, Res<Page<WithdrawItem[]>>>('/api/account/draw_list')

// 划转记录
export const getTransferList = http.get<{ currency_id: number, page: number, type: string }, Res<Page<TransferItem[]>>>('/api/account/transfer_log')

// 划转
export const transferCoin = http.post<{ balance: number, currency_id: number, from: string, to: string }, Res<unknown>>('/api/account/transfer')

// 获取法币收款方式
export const getPayMethod = http.get<{}, Res<CollectMethodItem[]>>('/api/pay_method/types')

// 获取法币绑定信息
export const getFlatBindData = http.get<{ type: number }, Res<FlatBindData>>('/api/pay_method/get_method_by_type')

// 绑定提币信息
export const saveFlatBindData = http.post<any, Res<unknown>>('/api/pay_method/save')

// 获取授权码
export const getAuthCode = http.get<{}, Res<string>>('/api/user/authorization_code')

export interface IAccountLog {
    currency_id: number
    page: number
}

// 币币账户记录
export const changeAccountLog = http.get<IAccountLog, Res<Page<AccontLogItem[]>>>('/api/account_log/change')

// 永续账户记录
export const leverAccountLog = http.get<IAccountLog, Res<Page<AccontLogItem[]>>>('/api/account_log/lever')

// 交割账户记录
export const microAccountLog = http.get<IAccountLog, Res<Page<AccontLogItem[]>>>('/api/account_log/micro')

// 法币账户记录
export const legalAccountLog = http.get<IAccountLog, Res<Page<AccontLogItem[]>>>('/api/account_log/legal')

// 期权账户记录
export const optionAccountLog = http.get<IAccountLog, Res<Page<AccontLogItem[]>>>('/api/account_log/option')

// 衍生品账户记录
export const forexAccountLog = http.get<IAccountLog, Res<Page<AccontLogItem[]>>>('/api/account_log/forex')

// 提交工单
export const feedback = http.post<{ title: string, content: string, type_id?: number }, Res<unknown>>('/api/feedback/feedback')

// 工单记录
export const getFeedbackList = http.get<{ page: number }, Res<Page<FeedbackItem[]>>>('/api/feedback/list')

// 重置登录密码
export const resetLoginPassword = http.post<{ old_password: string, new_password: string, secondary_password: string }, Res<unknown>>('/api/user/amend_password', undefined, { loading: true })

// 重置交易密码
export const resetTradePassword = http.post<{ password: string, secondary_password: string }, Res<unknown>>('/api/user/amend_pay_password', undefined, { loading: true })

// 忘记密码
export const forgotLoginPassword = http.post<{ account: string, auth_code: string, new_password: string, secondary_password: string, type: string }>('/api/user/forget_password')