import {
    Datafeed, SymbolInfo, Period, DatafeedSubscribeCallback
} from "@/modules/kline/klinecharts-pro.js";

import { KLineData } from 'klinecharts'
import { useForexKLineChat } from "./useKLine";
import { useForexSocketStore } from "@/store";
import { FOREX_Kline_DATA } from "@/interface/socket";

const getPeriodVal: any = {
    "1M": "1min",
    "5M": "5min",
    "15M": "15min",
    "30M": "30min",
    "1H": "60min",
    "1D": "1day",
};


const useMatchDataFeed = (match: globalThis.Ref<any> | globalThis.ComputedRef<any>) => {
    let currentPeriod = "";
    let currentSymbol: string | undefined

    let socketCallBack: any

    const { getChartData } = useForexKLineChat()
    const { addListener, removeListener } = useForexSocketStore();

    const datafeed: Datafeed = {
        /**
         * 模糊搜索标的
         * 在搜索框输入的时候触发
         * 返回标的信息数组
         */
        searchSymbols: function (search?: string | undefined): Promise<SymbolInfo[]> {
            // 根据模糊字段远程拉取标的数据
            return Promise.resolve([]);
        },
        getHistoryKLineData: function (
            symbol: SymbolInfo,
            period: Period,
            from: number,
            to: number
        ): Promise<KLineData[]> {
            // 完成数据请求
            return new Promise(async (resolve, reject) => {
                currentPeriod = getPeriodVal[period.text];
                const [success, data] = await getChartData({
                    forex_id: match.value.Id,
                    period: currentPeriod
                })
                resolve(data)
            });
        },
        subscribe: function (
            symbol: SymbolInfo,
            period: Period,
            callback: DatafeedSubscribeCallback
        ): void {
            currentSymbol = match.value.Code
            socketCallBack = (msg: FOREX_Kline_DATA) => {
                if (msg.type === "KLINE" && msg.symbol === currentSymbol) {
                    const kline = msg.kline
                    callback({
                        high: kline.High,
                        low: kline.Low,
                        volume: kline.Volume,
                        close: kline.Close,
                        timestamp: kline.Time,
                        open: kline.Open
                    })
                }
            }
            addListener(`KLINE.${currentSymbol}`, socketCallBack)
        },
        unsubscribe: function (symbol: SymbolInfo, period: Period): void {
            removeListener(`KLINE.${currentSymbol}`, socketCallBack);
            currentSymbol = undefined
        },
    };

    return {
        datafeed
    }
}

export default useMatchDataFeed