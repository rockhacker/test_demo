import { getTxInOrders, getTxOutOrders, getTxHistoryOrder } from "@/api/market"
import { TradeType } from "@/common"
import { TxOrder } from "@/interface"
import { TxMatched } from "@/interface/socket"
import { useMarketStore, useWebsocketStore } from "@/store"
import { useI18n } from "vue-i18n"

const useTxOrder = () => {
    const { t } = useI18n()
    const { currentTradeMatch } = storeToRefs(useMarketStore())
    const { addListener, removeListener } = useWebsocketStore()

    const page = ref(0)
    const [loading, setLoading] = useToggle(false)
    const [finished, setFinish] = useToggle(false)
    const [refreshing, setRefreshing] = useToggle(false)

    const txOrder = ref<TxOrder[]>([])

    const tradeType = ref(TradeType.BUY)

    const orderType = ref(0)
    const orderTypeList = [
        {
            label: t('trade.current_delegate'),
            value: 0 // 当前委托
        },
        {
            label: t('trade.all_entrust'),
            value: 1 // 全部委托
        },
        {
            label: t('trade.history_entrust'),
            value: 2 // 历史委托
        }
    ]

    const changeOrderType = (type: number) => {
        orderType.value = type
        onRefresh()
    }

    const tradeTypeList = [
        { label: t('trade.buy_in'), value: TradeType.BUY },
        { label: t('trade.sell_out'), value: TradeType.SELL },
    ]

    const changeTradeType = (type: TradeType) => {
        tradeType.value = type
        onRefresh()
    }

    const onLoad = () => {
        if (page.value !== 0 && loading.value) return

        page.value++

        setLoading(true)

        const params: any = {
            page: page.value,
        }

        if (orderType.value === 0) {
            params.currency_match_id = currentTradeMatch.value?.id
        }

        let promise

        if (orderType.value !== 2) {
            promise = tradeType.value === TradeType.BUY ? getTxInOrders(params, { raceKey: "getTxInOrders" }) : getTxOutOrders(params, { raceKey: "getTxOutOrders" })
        } else {
            promise = getTxHistoryOrder(params, { raceKey: 'getTxHistoryOrder' })
        }

        promise.then(({ data }) => {
            const list = data.data

            txOrder.value = page.value === 1 ? list : txOrder.value.concat(list);
            setFinish(data.last_page === page.value)
        }).finally(() => {
            setLoading(false)
            setRefreshing(false)
        })

    }

    const callback = (msg: TxMatched) => {
        const { order } = msg
        const index = txOrder.value.findIndex((item) => item.id === order.id)
        if (index !== -1) {
            if (+order.number === +order.transacted_amount) {
                txOrder.value.splice(index, 1)
            } else {
                txOrder.value[index].number = order.number
                txOrder.value[index].transacted_amount = order.transacted_amount
            }
        }
    }

    const subscribe = () => {
        addListener('TX_MATCHED', callback)
    }

    const unSubscribe = () => {
        removeListener('TX_MATCHED', callback)
    }

    const onRefresh = () => {
        setRefreshing(true)
        txOrder.value = []
        page.value = 0
        onLoad()
    }

    return {
        loading,
        finished,
        refreshing,
        onLoad,
        onRefresh,
        tradeType,
        changeTradeType,

        txOrder,
        subscribe,
        unSubscribe,

        orderType,
        orderTypeList,
        tradeTypeList,
        changeOrderType
    }
}

export default useTxOrder