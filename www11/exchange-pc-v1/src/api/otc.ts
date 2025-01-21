import { Res, Page } from "@/interface";
import { CurrencyUnit, MasterOrder, Otc, OtcCurrency, OtcListParams, OtcOrderAction, OtcOrderDetail, OtcOrderParams, OtcRecord, PayMethod } from "@/interface/otc";
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

// 我的店铺订单
export const getStoreOrder = http.get<{ page: number, way: string, status: number }, Res<Page<Otc[]>>>('/api/otc/seller_masters')

// 获取可发布币种
export const getOtcCurrency = http.get<{}, Res<OtcCurrency[]>>('/api/otc/seller_currencies')

// 获取价格单位
export const getOtcAreaList = http.get<{}, Res<CurrencyUnit[]>>('/api/default/area_list')

// 获取支付方式
export const getPayMethods = http.get<{}, Res<PayMethod[]>>('/api/pay_method/methods')

// 发布otc订单
export const publishOtcOrder = http.post<OtcOrderParams, Res>('/api/otc/post_master')

// 暂停otc订单
export const pauseOtcOrder = http.post<{ master_id: number }>('/api/otc/pause_master', undefined, { loading: true, showSuccessMessage: true })

// 开启otc订单
export const openOtcOrder = http.post<{ master_id: number }>('/api/otc/start_master', undefined, { loading: true, showSuccessMessage: true })

// 取消otc订单
export const cancelMasterOtcOrder = http.post<{ master_id: number }>('/api/otc/cancel_master', undefined, { loading: true, showSuccessMessage: true })

// 获取我的店铺订单详情
export const getMasterDetail = http.get<{ page: number, master_id: number, status: number }, Res<Page<MasterOrder[]>>>('/api/otc/master_details')