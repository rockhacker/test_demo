import {
    KLineChartPro,
    Datafeed,
    DatafeedSubscribeCallback,
    Period,
    SymbolInfo,
} from "@/modules/kline/klinecharts-pro.js";
import { useAppStore } from "@/store";
import { langs } from "@/lang";
import { Match } from "@/interface";
import { TIMEZONE } from "@/common";

const useKLineChartPro = (match: globalThis.Ref<any> | globalThis.ComputedRef<any>, datafeed: Datafeed) => {
    const { lang } = storeToRefs(useAppStore());

    const chart = ref<KLineChartPro>()

    const isForex = computed(() => {
        return !!match.value.Code
    })

    const setLocale = () => {
        chart.value?.setLocale(langs[lang.value].key);
    };

    const init = () => {
        chart.value = new KLineChartPro({
            locale: langs[lang.value].key,
            // @ts-ignore
            container: document.getElementById("container"),
            // @ts-ignore
            header: document.getElementById("top"),
            // @ts-ignore
            drawingbar: document.getElementById("left"),
            watermark: "",
            // 初始化标的信息
            symbol: {
                // exchange: "XNYS",
                // market: "stocks",
                // name: "Alibaba Group Holding Limited American Depositary Shares, each represents eight Ordinary Shares",
                // shortName: "BABA",
                ticker: isForex.value ? match.value.Code : match.value.symbol,
                pricePrecision: (isForex.value ? match.value.ForexQuotations.Close.toString().split('.')[1]?.length : match.value.currency_quotation.close.toString().split('.')[1]?.length) || 4,
                // volumePrecision:
                // priceCurrency: "usd",
                // type: "ADRC",
            },
            // 初始化周期
            period: { multiplier: 1, timespan: "minute", text: "1M" },
            periods: [
                { multiplier: 1, timespan: "minute", text: "1M" },
                { multiplier: 5, timespan: "minute", text: "5M" },
                { multiplier: 15, timespan: "minute", text: "15M" },
                { multiplier: 30, timespan: "minute", text: "30M" },
                { multiplier: 1, timespan: "hour", text: "1H" },
                // { multiplier: 2, timespan: "hour", text: "2H" },
                // { multiplier: 4, timespan: "hour", text: "4H" },
                { multiplier: 1, timespan: "day", text: "1D" },
                // { multiplier: 1, timespan: "week", text: "W" },
                // { multiplier: 1, timespan: "month", text: "M" },
                // { multiplier: 1, timespan: "year", text: "Y" },
            ],
            styles: {
                candle: {
                    // tooltip: {
                    //   showRule: TooltipShowRule.None,
                    //   showType: TooltipShowType.Rect,
                    // },
                    bar: {
                        upColor: "#2fdab0",
                        downColor: "#f84f4f",
                        noChangeColor: "#888888",
                        upBorderColor: '#2fdab0',
                        downBorderColor: '#f84f4f',
                        noChangeBorderColor: '#888888',
                        upWickColor: '#2fdab0',
                        downWickColor: '#f84f4f',
                        noChangeWickColor: '#888888'
                    },
                },
                yAxis: {
                    // inside: true, // 内容
                },
                indicator: {
                    ohlc: {
                        upColor: "#2fdab0",
                        downColor: "#f84f4f",
                    },
                    bars: [
                        {
                            upColor: "#2fdab0",
                            downColor: "#f84f4f",
                            noChangeColor: "#888888"
                        },
                    ],
                },
            },
            subIndicators: ["VOL"],
            // 这里使用默认的数据接入，如果实际使用中也使用默认数据，需要去 https://polygon.io/ 申请 API key
            datafeed: datafeed,
            timezone: TIMEZONE,
        });

        chart.value.setTheme('dark')

        setTimeout(() => {
            setLocale();
        });
    }

    return {
        chart,
        setLocale,
        init
    }
}

export default useKLineChartPro