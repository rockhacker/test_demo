import { getMicroTradeSecond, getMicroTradeMode, getMicroOrder } from '@/api/market';
import { MicroOrder, PayableCurrency, TradeSecond } from '@/interface';
import { useMarketStore } from '@/store';
import { useI18n } from 'vue-i18n';

const useMicro = () => {
    // 下单时间 -> 选择秒数
    const tradeSecond = ref<TradeSecond[]>([])
    const selectTradeSecond = ref<TradeSecond>()
    getMicroTradeSecond().then(({ data }) => {
        tradeSecond.value = data
        selectTradeSecond.value = tradeSecond.value[0]
    })

    // 交易模式 -> 选择币种
    const payableCurrency = ref<PayableCurrency[]>([])
    const useCurrency = ref<PayableCurrency>()

    const numberOptions = computed(() => {
        if (!useCurrency.value || !useCurrency.value.micro_numbers) return []
        return useCurrency.value.micro_numbers.map((item) => (
            { text: +item.number, value: +item.number }
        ))
    })

    const currentCurrencyBalance = computed(() => {
        if (!useCurrency.value) {
            return 0
        }
        return useCurrency.value.micro_account!.balance
    })

    const balanceLabel = computed(() => {
        if (!useCurrency.value) {
            return '--'
        }
        return currentCurrencyBalance.value + useCurrency.value.code
    })

    const getTradeMode = () => {
        getMicroTradeMode().then(({ data }) => {
            payableCurrency.value = data
            if (!useCurrency.value) {
                useCurrency.value = payableCurrency.value[0]
            } else {
                useCurrency.value = payableCurrency.value.find((item) => item.id === useCurrency.value?.id)
            }
        })
    }



    return {
        tradeSecond,
        selectTradeSecond,

        payableCurrency,
        useCurrency,
        currentCurrencyBalance,
        balanceLabel,

        numberOptions,
        getTradeMode


    }
}

export const useMicroOrder = () => {
    let controller: AbortController | null;
    let promise: Promise<any> | null;

    const { currentMicroMatch } = storeToRefs(useMarketStore())
    const { t } = useI18n()

    const orderType = ref(1)

    const orderTypeList = [
        {
            label: t('trade.in_transaction'),
            value: 1 // 交易中
        },
        {
            label: t('trade.closed_position'),
            value: 3 // 已平仓
        }
    ]

    const orderList = ref<MicroOrder[]>([])

    let timer: string | number | NodeJS.Timer | undefined // 秒合约倒计时任务

    const page = ref(0)
    const [loading, setLoading] = useToggle(false)
    const [finished, setFinish] = useToggle(false)
    const [refreshing, setRefreshing] = useToggle(false)

    const onLoad = async () => {
        
        if (page.value === 0 && loading.value) return
        setLoading(true)

        if (timer) {
            clearInterval(timer)
            timer = undefined
        }

        page.value++


        promise = getMicroOrder({
            match_id: currentMicroMatch.value?.id,
            page: page.value,
            status: orderType.value
        }, { raceKey: 'getMicroOrder' })
            .then(({ data }) => {
                const list = data.data

                // 毫秒 -> 秒
                if (orderType.value === 1) {
                    list.forEach((item) => {
                        item.remain_milli_seconds = parseInt((item.remain_milli_seconds / 1000).toString())
                    })
                }

                orderList.value = page.value === 1 ? list : orderList.value.concat(list);
                setFinish(data.last_page === page.value)

                if (orderType.value === 1 && orderList.value.length) {
                    timer = setInterval(() => {
                        orderList.value.forEach((item) => {
                            item.remain_milli_seconds = item.remain_milli_seconds - 1
                        })
                        orderList.value = orderList.value.filter((item) => item.remain_milli_seconds > 0)
                        if (orderList.value.length === 0) {
                            clearInterval(timer)
                            timer = undefined
                        }
                    }, 1000)
                }

            })
            .catch(() => {
                setFinish(true)
            })
            .finally(() => {
                setLoading(false)
                setRefreshing(false)
                promise = null
            })

    }


    const onRefresh = () => {
        setRefreshing(true)
        orderList.value = []
        page.value = 0
        onLoad()
    }



    return {
        orderType,
        orderTypeList,
        orderList,

        onLoad,
        onRefresh,

        page,
        loading,
        finished,
        refreshing,

    }
}

export default useMicro