import { MatchType } from "@/interface"
import { useMarketStore } from "@/store"

const useMatch = (type: MatchType) => {
    const {
        currentTradeMatch, currentLeverMatch, currentMicroMatch
    } = storeToRefs(useMarketStore())

    const match = computed(() => {
        if (type === 'micro') {
            return currentMicroMatch.value
        }
        if (type === 'lever') {
            return currentLeverMatch.value
        }
        return currentTradeMatch.value
    })

    return {
        match
    }

}

export default useMatch