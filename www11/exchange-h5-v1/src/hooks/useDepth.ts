import { MarketDepth, OrderInfo } from "@/interface/socket"
import { useWebsocketStore } from "@/store"

const useDepth = () => {
    const buyList = ref<OrderInfo[]>([])
    const sellList = ref<OrderInfo[]>([])

    let currentSymbol: string | undefined

    const callback = (msg: MarketDepth) => {
        if (msg.symbol === currentSymbol) {
            buyList.value = msg.depth.in
            sellList.value = msg.depth.out
        }
    }

    const { addListener, removeListener } = useWebsocketStore()

    const startDepth = (symbol: string) => {
        currentSymbol = symbol
        addListener(`MARKET_DEPTH.${symbol}`, callback)
    }

    const stopDepth = () => {
        removeListener(`MARKET_DEPTH.${currentSymbol}`, callback)
        currentSymbol = undefined
    }

    return {
        buyList,
        sellList,
        startDepth,
        stopDepth
    }
}

export default useDepth
