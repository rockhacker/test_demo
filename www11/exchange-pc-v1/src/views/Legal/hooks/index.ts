import { arbitrateOtcOrder, cancelOtcOrder, confirmOtcOrder, confirmPayOtcOrder, delayConfirmOtcOrder, getOtcOrderActions, getOtcOrderDetail } from "@/api/otc"
import { OtcOrderAction, OtcOrderDetail } from "@/interface/otc"
import { CurrentTime, useCountDown } from "@vant/use"
import { ElMessageBox } from "element-plus"
import { useI18n } from "vue-i18n"

export const useOrderStatus = () => {
    const { t } = useI18n()

    const typeList = [
        {
            label: t('legal.buy'),
            value: 'BUY'
        },
        {
            label: t('legal.sell'),
            value: 'SELL'
        }
    ]

    const statusList = [
        {
            label: t('public.all'),
            value: undefined
        },
        {
            label: t('legal.not_finish'),
            value: 0
        },
        {
            label: t('legal.payed'),
            value: 1
        },
        {
            label: t('legal.delay_confirm'),
            value: 2
        },
        {
            label: t('legal.protecting'),
            value: 3
        },
        {
            label: t('legal.canceled'),
            value: 4
        },
        {
            label: t('legal.finished'),
            value: 5
        }
    ]

    const getStatusLabel = (status: number, way?: string) => {
        if (way && status === 0) {
            return way === 'BUY' ? t('legal.please_pay') : t('legal.wait_pay')
        }
        return statusList.find(item => item.value === status)?.label
    }

    return {
        typeList,
        statusList,
        getStatusLabel
    }
}

export const useOtcOrder = () => {

    const { t } = useI18n()
    const route = useRoute()

    const id = Number(route.query.id)

    const orderDetail = ref<OtcOrderDetail>()
    const orderActions = ref<OtcOrderAction[]>([])

    const pay_voucher = ref('')


    let current: import("vue").ComputedRef<CurrentTime>
    let pause: () => void

    const time = computed(() => {
        if (!current) return `0${t('public.day')}0${t('public.hour')}0${t('public.min')}0${t('public.second')}`
        return `${current.value.days}${t('public.day')}${current.value.hours}${t('public.hour')}${current.value.minutes}${t('public.min')}${current.value.seconds}${t('public.second')}`
    })

    const startCountDown = (startTime: Date, endTime: Date) => {
        const countDown = useCountDown({
            // 倒计时 24 小时
            time: endTime.getTime() - startTime.getTime(), // 倒计时时长，单位毫秒
        })
        countDown.start()
        pause = countDown.pause
        current = countDown.current
    }

    const statusTip = computed(() => {
        if (!orderDetail.value) {
            return ''
        }
        const { status, way } = orderDetail.value
        if (status === 0) {
            if (way === 'SELL') {
                return t('legal.please_wait_user_pay')
            } else {
                return `${t('legal.overtime_cancel')}, ${t('legal.remainder_time')}: ${time.value}`
            }
        }
        if ((status === 1 || status === 2) && way === 'SELL') {
            return `${t('legal.overtime_confirm')}, ${t('legal.remainder_time')}: ${time.value}`
        }
        if (status === 1 && way === 'BUY') return t('legal.order_payed')
        if (status === 2) return t('legal.not_receive_pay')
        if (status === 3) return t('legal.order_no_pay_protection')
        if (status === 4) return t('legal.order_is_canceled')
        if (status === 5) return t('legal.order_is_done')

        return ''
    })

    const bankData = computed(() => {
        return orderDetail.value?.otc_payways.find(item => item.pay_code === 'bank')?.raw_data
    })

    const getData = () => {
        getOtcOrderDetail({ detail_id: id }).then(({ data }) => {
            console.log(data);
            orderDetail.value = data
            const { confirm_countdown, status, way, server_now, pay_countdown } = orderDetail.value
            // 买家付款剩余时间倒计时
            if (confirm_countdown === null && status === 0 && way === 'BUY') {
                return startCountDown(new Date(server_now), new Date(pay_countdown!))
            }
            if ((status === 1 || status === 2) && way === 'SELL') {
                return startCountDown(new Date(server_now), new Date(confirm_countdown!))
            }
        })

        getOtcOrderActions({ detail_id: id }).then(({ data }) => {
            console.log(data);
            orderActions.value = data
        })
    }

    getData()

    onMounted(() => {
        pause && pause()
    })

    // 取消订单
    const cancelOrder = async () => {
        await ElMessageBox.confirm(
            t('legal.cancel_rules'),
            t('legal.confirm_cancel_order'),
            {
                confirmButtonText: t('public.confirm'),
                cancelButtonText: t('public.cancel'),
                type: 'warning',
            }
        )

        await cancelOtcOrder({ detail_id: id }, { showSuccessMessage: true })


        getData()
    }

    // 确认付款
    const payOrder = async () => {
        await ElMessageBox.confirm(
            t('legal.confirm_pay_tip'),
            t('legal.confirm_has_pay'),
            {
                confirmButtonText: t('public.confirm'),
                cancelButtonText: t('public.cancel'),
                type: 'warning',
            }
        )

        await confirmPayOtcOrder({ detail_id: id, pay_voucher: pay_voucher.value }, { showSuccessMessage: true })

        getData()
    }

    // 延期确认
    const delayOrder = async () => {
        await ElMessageBox.confirm(
            t('legal.confirm_pay_tip'),
            t('legal.delay_confirm'),
            {
                confirmButtonText: t('public.confirm'),
                cancelButtonText: t('public.cancel'),
                type: 'warning',
            }
        )

        await delayConfirmOtcOrder({ detail_id: id }, { showSuccessMessage: true })

        getData()
    }

    // 申请维权
    const arbitrateOrder = async () => {
        await ElMessageBox.confirm(
            t('legal.confirm_pay_tip'),
            t('legal.apply_protection'),
            {
                confirmButtonText: t('public.confirm'),
                cancelButtonText: t('public.cancel'),
                type: 'warning',
            }
        )

        await arbitrateOtcOrder({ detail_id: id }, { showSuccessMessage: true })

        getData()
    }

    // 确认收款
    const confirmOrder = async () => {
        await ElMessageBox.confirm(
            t('legal.confirm_pay_tip'),
            t('legal.confirm_pay'),
            {
                confirmButtonText: t('public.confirm'),
                cancelButtonText: t('public.cancel'),
                type: 'warning',
            }
        )

        await confirmOtcOrder({ detail_id: id }, { showSuccessMessage: true })

        getData()
    }

    return {
        orderDetail,
        orderActions,
        statusTip,
        bankData,
        pay_voucher,

        cancelOrder,
        payOrder,
        delayOrder,
        confirmOrder,
        arbitrateOrder
    }
}