import { Complete, GlobalTx } from "@/interface/socket"
import { useWebsocketStore } from "@/store"

const useGlobalTx = (symbol: string) => {
    const txList = ref<Complete[]>([])

    const { addListener } = useWebsocketStore()

    addListener(`GLOBAL_TX.${symbol}`, (msg: GlobalTx) => {
        msg.completes.forEach((item) => {
            txList.value.unshift(item)
            txList.value.length > 30 && txList.value.pop()
        })
    })

    return {
        txList
    }
}

export default useGlobalTx