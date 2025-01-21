import { Res, Page } from "@/interface";
import { Fund, FundOrder, Ico, IcoOrder, MiningProfit } from "@/interface/finance";
import { Currency } from "@/interface/user";
import http from "@/utils/http";

// 云挖矿列表
export const getMiningList = http.get<{ page: number }, Res<Page<Fund[]>>>('/api/fund/list')

// 云挖矿详情
export const getMiningInfo = http.get<{ id: number }, Res<Fund>>('/api/fund/info')

// 提交云挖矿订单
export const submitMiningOrder = http.get<{ id: number, amount: number }, Res<unknown>>('/api/fund/buy', undefined, { loading: true })

// 获取云挖矿订单
export const getMiningOrderList = http.get<{ page: number }, Res<Page<FundOrder[]>>>('/api/fund/subList')

// 获取云挖矿订单收益
export const getMiningOrderProfit = http.get<{ sub_id: number, page: number }, Res<Page<MiningProfit[]>>>('/api/fund/insList')

// 云挖矿订单违约赎回
export const refundMiningOrder = http.get<{ sub_id: number }, Res<unknown>>('/api/fund/applyRefund', undefined, { loading: true })

// ico列表
export const getIcoList = http.get<{ page: number }, Res<Page<Ico[]>>>('/api/subscription/subscription_list')

// ico详情
export const getIcoInfo = http.get<{ id: number }, Res<Ico>>('/api/subscription/sub_info')

// ico可支付余额
export const getIcoBalance = http.post<{}, Res<Currency[]>>('/api/subscription/getPayableCurrencies')

// 提交ico订单
export const submitIcoOrder = http.get<{ sub_id: number, amount: number, pay_currency_id: number }>('/api/subscription/submit', undefined, { loading: true })

// 获取ico订单列表
export const getIcoOrderList = http.get<{ page: number }, Res<Page<IcoOrder[]>>>('/api/subscription/mySubList')