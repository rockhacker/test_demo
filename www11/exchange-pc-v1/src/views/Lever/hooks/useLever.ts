import { getLeverData, getLeverDealAll, getLeverOrder } from "@/api/market"
import { Picker, Transaction } from "@/interface"
import { LeverClosed, LeverTrade } from "@/interface/socket"
import { useMarketStore, useWebsocketStore } from "@/store"
import { useI18n } from "vue-i18n"

const useLever = () => {
    const { currentLeverMatch } = storeToRefs(useMarketStore())

    const balance = ref<number>(0)

    const multiple = ref<number>()

    const multiples = ref<Picker[]>([])

    const myTransaction = ref<Transaction[]>([])

    const [load, setLoad] = useToggle(false)

    const getBaseData = () => {
        getLeverData({ currency_match_id: currentLeverMatch.value!.id }).then(({ data }) => {
            multiples.value = data.multiple.muit.map((item) => {
                return {
                    text: item.value,
                    value: +item.value
                }
            })
            // 初始化默认倍数
            !multiple.value && (multiple.value = multiples.value[0]?.value)

            balance.value = +data.user_lever

            myTransaction.value = data.my_transaction
        }).finally(() => {
            setLoad(true)
        })
    }

    return {
        multiple,
        multiples,

        balance,
        myTransaction,

        getBaseData,
        load
    }
}

export const useLeverOrder = () => {
    const { t } = useI18n()
    const [loading, setLoading] = useToggle(false)
    const [finished, setFinish] = useToggle(false)
    const { currentLeverMatch } = storeToRefs(useMarketStore())
    const orderType = ref(-1)

    const { addListener, removeListener } = useWebsocketStore()


    const page = ref(0)

    const hazardRate = ref('0')
    const profitsTotal = ref(0)
    const orderList = ref<Transaction[]>([])

    const orderTypeList = [
        {
            label: t('trade.current_holding'),
            value: -1
        },
        {
            label: t('trade.all_holding'),
            value: 1
        },
        {
            label: t('trade.all_wait_entrust'),
            value: 0
        },
        {
            label: t('trade.close_all'),
            value: 3
        },
        {
            label: t('trade.all_canceled'),
            value: 4
        },
    ]

    const getCurrentHoldOrder = () => {
        getLeverDealAll({ page: page.value, currency_match_id: currentLeverMatch.value!.id }, { raceKey: "useLeverOrder" })
            .then(({ data }) => {
                hazardRate.value = data.hazard_rate
                profitsTotal.value = +data.profits_total
                const list = data.order.data
                orderList.value = page.value === 1 ? list : orderList.value.concat(list);
                setFinish(data.order.last_page === page.value)
            })
            .catch(() => {
                setFinish(true)
            })
            .finally(() => {
                setLoading(false)
            })
    }

    const getLeverRecord = () => {
        getLeverOrder({ page: page.value, status: orderType.value }, { raceKey: "useLeverOrder" })
            .then(({ data }) => {
                const list = data.data
                orderList.value = page.value === 1 ? list : orderList.value.concat(list);
                setFinish(data.last_page === page.value)
            })
            .catch(() => {
                setFinish(true)
            })
            .finally(() => {
                setLoading(false)
            })
    }

    const onLoad = async () => {
        if (page.value !== 0 && loading.value) return

        page.value++

        setLoading(true)

        if (orderType.value === -1) {
            getCurrentHoldOrder()
        } else {
            getLeverRecord()
        }
    }

    const onRefresh = () => {
        page.value = 0
        orderList.value = []
        onLoad()
    }

    const LEVER_TRADE_CALLBACK = ({ trades_all, currency_match_id, hazard_rate, profits_all }: LeverTrade) => {
        trades_all.forEach((item) => {
            if (currentLeverMatch.value?.id === currency_match_id) {
                hazardRate.value = hazard_rate
                profitsTotal.value = +profits_all
            }

            const target = orderList.value.find((order) => order.id === item.id)
            if (target) {
                target.profits = item.profits
                target.update_price = item.update_price
            }
        })
    }

    const LEVER_CLOSED_CALLBACK = ({ id }: LeverClosed) => {
        id.forEach(value => {
            const index = orderList.value.findIndex((order) => order.id === value)
            if (index != -1) {
                orderList.value.splice(index, 1)
            }
        });
    }

    const subscribe = () => {
        addListener('LEVER_TRADE', LEVER_TRADE_CALLBACK)
        addListener('LEVER_CLOSED', LEVER_CLOSED_CALLBACK)
    }

    const unSubscribe = () => {
        removeListener('LEVER_TRADE', LEVER_TRADE_CALLBACK)
        removeListener('LEVER_CLOSED', LEVER_CLOSED_CALLBACK)
    } 


    return {
        orderType,
        orderTypeList,
        loading,
        onLoad,
        finished,
        onRefresh,

        hazardRate,
        profitsTotal,
        orderList,

        subscribe,
        unSubscribe,
    }
}

export default useLever