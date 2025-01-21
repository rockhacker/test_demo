import { defineStore } from "pinia";
import { getTradeList } from "@/api/forex";
import { TradeItem } from "@/interface/forex";
import { useForexSocketStore } from "@/store";
import { Topic } from "@/store/forexSocket";
import { DAY_MARKET_DATA } from "@/interface/socket";

const forexStore = defineStore(
    "forex",
    () => {
        const tradeList = ref<TradeItem[]>([]);
        const getTradeListPromise = ref<Promise<any>>();

        const currentTradeId = ref<Number>();

        const initMarket = async () => {
            getTradeListPromise.value = getTradeList()
            await getTradeListPromise.value.then(({ data }) => {
                tradeList.value.length = 0;
                tradeList.value.push(...data);
            }).finally(() => {
                getTradeListPromise.value = undefined;
            })
        };

        const getCurrentTradeItem = computed(() => {
            return tradeList.value.find((item) => item.Id === currentTradeId.value) || tradeList.value[0];
        });

        const setCurrentTradeItem = (Id: number) => {
            // 无需重复设置
            if (Id === currentTradeId.value) {
                console.warn("当前交易队已是当前选项");
                return;
            }
            if (!tradeList.value.find((item) => item.Id === Id)) {
                console.error("当前交易对不存在");
                return;
            }
            currentTradeId.value = Id;
        };

        const updateTradeListData = () => {
            const { addListener } = useForexSocketStore();
            addListener(Topic.DAY_MARKET, (msg: DAY_MARKET_DATA) => {
                if (msg.type === Topic.DAY_MARKET) {
                    tradeList.value.find((item) => {
                        if (item.Code === msg.symbol) {
                            item.ForexQuotations.Close = msg.quotation.close;
                            item.ForexQuotations.Change = msg.quotation.change;
                            return true;
                        }
                    });
                }
            });
        };

        return {
            tradeList,
            getTradeListPromise,
            currentTradeId,
            initMarket,
            setCurrentTradeItem,
            getCurrentTradeItem,
            updateTradeListData,
        };
    },
    {
        persist: {
            storage: sessionStorage,
            paths: ['tradeList', 'currentTradeId'],
        },
    }
);

export default forexStore;
