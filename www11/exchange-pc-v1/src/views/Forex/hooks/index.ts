import { getForexDeal, getForexOrder } from "@/api"
import { MyTransaction } from "@/interface/forex"
import { FOREX_CLOSED_DATA, FOREX_MarketDepth_DATA, FOREX_TRADE_DATA, OrderInfo } from "@/interface/socket"
import { useForexSocketStore, useForexStore } from "@/store"
import { useI18n } from "vue-i18n"

export const useForex = () => {
    const { addListener, removeListener } = useForexSocketStore()

    // const { getCurrentTradeItem } = storeToRefs(useForexStore())

    let currentSymbol: string | undefined

    const buyDepth = ref<OrderInfo[]>([])
    const sellDepth = ref<OrderInfo[]>([])

    const depthCallback = (msg: FOREX_MarketDepth_DATA) => {
        if (msg.type === 'MARKET_DEPTH' && currentSymbol === msg.symbol) {
            buyDepth.value = msg.depth.in
            sellDepth.value = msg.depth.out
        }
    }

    const subDepth = (symbol: string) => {
        currentSymbol = symbol
        addListener(`MARKET_DEPTH.${symbol}`, depthCallback)
    }

    const unSubDepth = () => {
        if (currentSymbol) {
            removeListener(`MARKET_DEPTH.${currentSymbol}`, depthCallback)
            currentSymbol = undefined
        }
    }

    // const multiple = ref<number>()

    // const multiples = computed(() => {
    //     return getCurrentTradeItem.value?.HasForexMultiple.map((item) => {
    //         return {
    //             text: item.Value.toString(),
    //             value: item.Value,
    //         }
    //     }) || []
    // })

    return {
        buyDepth,
        sellDepth,
        subDepth,
        unSubDepth,

        // multiple,
        // multiples
    }
}

export const useForexOrder = () => {
    const { addListener, removeListener } = useForexSocketStore()
    const { getCurrentTradeItem } = storeToRefs(useForexStore())
    const { t } = useI18n()
    const [loading, setLoading] = useToggle(false)
    const [finished, setFinish] = useToggle(false)
    const orderType = ref(-1)

    const orderList = ref<MyTransaction[]>([])

    const page = ref(0)

    const hazardRate = ref(0)
    const profitsTotal = ref(0)

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
        getForexDeal({ forex_id: getCurrentTradeItem.value.Id }, { raceKey: 'getForexOrder' })
            .then(({ data }) => {
                orderList.value = data.my_transaction
                setFinish(true)
            }).catch(() => {
                setFinish(true)
            })
            .finally(() => {
                setLoading(false)
            })
    }

    const getForexRecord = () => {
        getForexOrder({ page: page.value, status: orderType.value }, { raceKey: 'getForexOrder' })
            .then(({ data }) => {
                const list = data.data
                orderList.value = page.value === 1 ? list : orderList.value.concat(list);
                setFinish(data.total === page.value)
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
            getForexRecord()
        }
    }

    const FOREX_TRADE_CALLBACK = (msg: FOREX_TRADE_DATA) => {
        hazardRate.value = msg.HazardRate
        profitsTotal.value = msg.ProfitsTotal

        msg.TransOrder.forEach((order) => {
            const target = orderList.value.find((item) => item.Id === order.Id);
            if (target) {
                target.UpdatePrice = order.UpdatePrice;
                target.FactProfits = order.FactProfits;
            }
        });
    }

    const FOREX_CLOSED_CALLBACK = (msg: FOREX_CLOSED_DATA) => {
        if (msg.id.length) {
            msg.id.forEach((id) => {
                const index = orderList.value.findIndex((item) => item.Id === id);
                if (index === -1) {
                    return;
                }
                orderList.value.splice(index, 1);
            });
        }
    }

    const subscribe = () => {
        addListener('FOREX_TRADE', FOREX_TRADE_CALLBACK)
        addListener('FOREX_CLOSED', FOREX_CLOSED_CALLBACK)
    }

    const unSubscribe = () => {
        removeListener('FOREX_TRADE', FOREX_TRADE_CALLBACK)
        removeListener('FOREX_CLOSED', FOREX_CLOSED_CALLBACK)
    }

    const onRefresh = () => {
        page.value = 0
        orderList.value = []
        onLoad()
    }

    return {
        loading,
        finished,
        orderType,
        orderTypeList,
        onRefresh,
        hazardRate,
        profitsTotal,
        onLoad,
        subscribe,
        unSubscribe,
        orderList
    }
}