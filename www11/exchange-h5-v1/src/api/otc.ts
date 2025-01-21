import { Res, Page } from "@/interface";
import { Otc, OtcListParams, OtcOrderAction, OtcOrderDetail, OtcRecord } from "@/interface/otc";
import { Currency } from "@/interface/user";
import http from "@/utils/http";

// 获取可交易币种类型
export const getCurrencies = http.get<{}, Res<Currency[]>>('/api/otc/currencies')

// 获取买卖交易列表
export const getOtcList = http.get<OtcListParams, Res<Page<Otc[]>>>('/api/otc/masters')

// 提交otc订单
export const submitOtcOrder = http.post<{ master_id: number, number: number, price: number }, Res<unknown>>('/api/otc/match_master', undefined, { loading: true })

// 获取交易记录
export const getOtcOrderRecord = http.get<OtcListParams & { status: number }, Res<Page<OtcRecord[]>>>('/api/otc/user_details')

// 获取交易详情
export const getOtcOrderDetail = http.get<{ detail_id: number }, Res<OtcOrderDetail>>('/api/otc/detail')

// 获取交易订单状态跟踪
export const getOtcOrderActions = http.get<{ detail_id: number }, Res<OtcOrderAction[]>>('/api/otc/detail_actions')

// 取消交易订单
export const cancelOtcOrder = http.post<{ detail_id: number }, Res<unknown>>('/api/otc/cancel', undefined, { loading: true })

// 订单确认已付款
export const confirmPayOtcOrder = http.post<{ detail_id: number, pay_voucher: string }, Res<unknown>>('/api/otc/pay', undefined, { loading: true })

// 延期确认 
export const delayConfirmOtcOrder = http.post<{ detail_id: number }, Res<unknown>>('/api/otc/defer', undefined, { loading: true })

// 确认收款
export const confirmOtcOrder = http.post<{ detail_id: number }, Res<unknown>>('/api/otc/confirm', undefined, { loading: true })

// 申请维权
export const arbitrateOtcOrder = http.post<{ detail_id: number }, Res<unknown>>('/api/otc/arbitrate', undefined, { loading: true })