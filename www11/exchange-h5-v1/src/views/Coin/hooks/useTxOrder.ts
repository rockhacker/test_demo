import { getTxInOrders, getTxOutOrders, getTxHistoryOrder } from "@/api/market"
import { TradeType } from "@/common"
import { TxOrder } from "@/interface"
import { TxMatched } from "@/interface/socket"
import { useMarketStore, useWebsocketStore } from "@/store"

const useTxOrder = (isCurrentMatch = false) => {
    const { currentTradeMatch } = storeToRefs(useMarketStore())
    const { addListener } = useWebsocketStore()

    const page = ref(0)
    const [loading, setLoading] = useToggle(false)
    const [finished, setFinish] = useToggle(false)
    const [refreshing, setRefreshing] = useToggle(false)
    const [isHistory, setIsHistory] = useToggle(false)

    const txOrder = ref<TxOrder[]>([])

    const tradeType = ref(TradeType.BUY)

    const onLoad = () => {
        page.value++

        setLoading(true)

        const params: any = {
            page: page.value,
        }

        if (isCurrentMatch) {
            params.currency_match_id = currentTradeMatch.value?.id
        }

        let promise

        if (!isHistory.value) {
            promise = tradeType.value === TradeType.BUY ? getTxInOrders(params) : getTxOutOrders(params)
        } else {
            promise = getTxHistoryOrder(params)
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

    const subscribe = () => {
        addListener('TX_MATCHED', (msg: TxMatched) => {
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
        })
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

        txOrder,
        subscribe,

        isHistory,
        setIsHistory
    }
}

export default useTxOrder