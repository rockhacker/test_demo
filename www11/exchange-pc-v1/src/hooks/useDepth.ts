import { GLOBAL_TX_DATA, MarketDepth, OrderInfo, TxComplete } from "@/interface/socket"
import { useWebsocketStore } from "@/store"
import dayjs from 'dayjs'

const useDepth = () => {
    const buyList = ref<OrderInfo[]>([])
    const sellList = ref<OrderInfo[]>([])

    const globalList = ref<TxComplete[]>([])

    let currentSymbol: string | undefined

    const callback = (msg: MarketDepth) => {
        if (msg.symbol === currentSymbol) {
            buyList.value = msg.depth.in
            sellList.value = msg.depth.out
        }
    }

    const globalCallback = (msg: GLOBAL_TX_DATA) => {
        msg.completes.forEach((item) => {
            item.time = dayjs.unix(item.timestamp).format("HH:MM:ss")
            globalList.value.unshift(item)
        })
        globalList.value = globalList.value.slice(0, 25)
    }

    const { addListener, removeListener } = useWebsocketStore()

    const startDepth = (symbol: string) => {
        buyList.value = sellList.value = globalList.value = []
        currentSymbol = symbol
        addListener(`MARKET_DEPTH.${symbol}`, callback)
        addListener(`GLOBAL_TX.${symbol}`, globalCallback)
    }

    const stopDepth = () => {
        removeListener(`MARKET_DEPTH.${currentSymbol}`, callback)
        removeListener(`GLOBAL_TX.${currentSymbol}`, globalCallback)
        currentSymbol = undefined
    }

    return {
        buyList,
        sellList,
        globalList,
        startDepth,
        stopDepth
    }
}

export default useDepth
