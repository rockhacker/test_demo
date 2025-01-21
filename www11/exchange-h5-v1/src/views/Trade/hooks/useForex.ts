import { Picker } from "@/interface"
import { FOREX_MarketDepth_DATA, OrderInfo } from "@/interface/socket"
import { useForexSocketStore, useForexStore } from "@/store"

export const useForex = () => {
    const { addListener, removeListener } = useForexSocketStore()

    const { getCurrentTradeItem } = storeToRefs(useForexStore())

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

    const multiple = ref<number>()

    const multiples = computed(() => {
        return getCurrentTradeItem.value?.HasForexMultiple.map((item) => {
            return {
                text: item.Value.toString(),
                value: item.Value,
            }
        }) || []
    })

    return {
        buyDepth,
        sellDepth,
        subDepth,
        unSubDepth,

        multiple,
        multiples
    }
}