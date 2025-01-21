import { getLeverData } from "@/api/market"
import { Picker, Transaction } from "@/interface"
import { useMarketStore } from "@/store"

const useLever = () => {
    const { currentLeverMatch } = storeToRefs(useMarketStore())

    const balance = ref<number>(0)

    const multiple = ref<number>()

    const multiples = ref<Picker[]>([])

    const myTransaction = ref<Transaction[]>([])

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
        })
    }

    return {
        multiple,
        multiples,

        balance,
        myTransaction,

        getBaseData,

    }
}

export default useLever