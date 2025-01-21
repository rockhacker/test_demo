import { getCurrencyMatches } from "@/api/market";
import { CurrencyMatches } from "@/interface";
import { defineStore } from "pinia";
import { useWebsocketStore } from "./index";
import { Topic } from "./websocket";
import { DayMarket } from "@/interface/socket";

const marketStore = defineStore(
    "market",
    () => {
        const currentMarket = ref(1)

        // const setCurrentMarket = (val: number) => {
        //     currentMarket.value = val
        // }

        // 数字货币交易对集合
        const currencyMatches = ref<CurrencyMatches[]>([])

        // 当前币币交易基币id
        const tradeCurrencyId = ref<number>()
        // 当前币币交易队id
        const tradeMatchId = ref<number>()
        // 币币交易队信息
        const currentTradeMatch = computed(() => {
            if (tradeCurrencyId.value) {
                const target = currencyMatches.value.find(item => item.id === tradeCurrencyId.value)
                if (target && target.matches.length && tradeMatchId.value) {
                    const match = target.matches.find(item => item.id === tradeMatchId.value)
                    // 有交易对 并且交易对使用状态为开启
                    if (match && match.open_change) {
                        return match
                    }
                }
            }
            // 默认返回第一个开启中的
            return currencyMatches.value[0].matches.find((item) => item.open_change === 1)
        })

        // 当前永续合约交易基币id
        const leverCurrencyId = ref<number>()
        // 当前永续合约交易对id
        const leverMatchId = ref<number>()
        // 永续交易队信息
        const currentLeverMatch = computed(() => {
            if (leverCurrencyId.value) {
                const target = currencyMatches.value.find(item => item.id === leverCurrencyId.value)
                if (target && target.matches.length && leverMatchId.value) {
                    const match = target.matches.find(item => item.id === leverMatchId.value)
                    // 有交易对 并且交易对使用状态为开启
                    if (match && match.open_lever) {
                        return match
                    }
                }
            }
            // 默认返回第一个开启中的
            return currencyMatches.value[0].matches.find((item) => item.open_lever === 1)
        })

        // 当前交割合约交易基币id
        const microCurrencyId = ref<number>()
        // 当前交割合约交易队id
        const microMatchId = ref<number>()
        // 交割交易队信息
        const currentMicroMatch = computed(() => {
            if (microCurrencyId.value) {
                const target = currencyMatches.value.find(item => item.id === microCurrencyId.value)
                if (target && target.matches.length && microMatchId.value) {
                    const match = target.matches.find(item => item.id === microMatchId.value)
                    // 有交易对 并且交易对使用状态为开启
                    if (match && match.open_microtrade) {
                        return match
                    }
                }
            }
            // 默认返回第一个开启中的
            return currencyMatches.value[0].matches.find((item) => item.open_microtrade === 1)
        })

        const initMarket = async () => {
            await getCurrencyMatches().then(({ data }) => {
                currencyMatches.value = data
            })
        };

        const updateMatchListData = () => {
            const { addListener } = useWebsocketStore();
            addListener(Topic.DAY_MARKET, ({ type, quotation }: DayMarket) => {
                if (type === Topic.DAY_MARKET) {
                    currencyMatches.value.find((item) => {
                        const match = item.matches.find((match) => match.id === quotation.id)
                        if (match) {
                            match.currency_quotation.close = quotation.close
                            match.currency_quotation.change = quotation.change
                            match.currency_quotation.high = quotation.high.toString()
                            match.currency_quotation.low = quotation.low.toString()
                            match.currency_quotation.volume = quotation.volume
                            return true
                        }
                    })
                }
            });
        };

        return {
            currencyMatches,

            tradeCurrencyId,
            tradeMatchId,
            currentTradeMatch,

            leverCurrencyId,
            leverMatchId,
            currentLeverMatch,

            microCurrencyId,
            microMatchId,
            currentMicroMatch,

            initMarket,

            updateMatchListData,

            currentMarket,
            // setCurrentMarket
        };
    },
    {
        persist: {
            storage: sessionStorage,
            paths: ['currentMarket', 'currencyMatches', 'tradeCurrencyId', 'tradeMatchId', 'leverCurrencyId', 'leverMatchId', 'microCurrencyId', 'microMatchId'],
        },
    }
);

export default marketStore