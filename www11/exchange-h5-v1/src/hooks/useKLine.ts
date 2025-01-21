import { getFxKLineData } from "@/api/forex";
import { getKLineData } from "@/api/market";
import { TIMEZONE } from "@/common";
import { GetKLine } from "@/interface";
import { GetFxKLine } from "@/interface/forex";
import { FOREX_Kline_DATA, KLineSymbol } from "@/interface/socket";
import { useForexSocketStore, useWebsocketStore } from "@/store";
import {
    init,
    TooltipShowRule,
    TooltipShowType,
    Options,
    registerLocale,
    type Chart,
    type KLineData,
} from "klinecharts";


registerLocale("zh-HK", {
    time: "時間：",
    open: "開：",
    high: "高：",
    low: "低：",
    close: "收：",
    volume: "成交量：",
});

export const Period: any = {
    "1M": "1min",
    "5M": "5min",
    "15M": "15min",
    "30M": "30min",
    "1H": "60min",
    "1D": "1day",
    "1WEEK": "1week",
    "1MON": "1mon"
};

const defaultOptions: Options = {
    styles: {
        grid: {
            show: false
        },
        candle: {
            tooltip: {
                showRule: TooltipShowRule.None,
                showType: TooltipShowType.Rect,
            },
            bar: {
                upColor: "#2fdab0",
                downColor: "#f84f4f",
                noChangeColor: "#888888",
                upBorderColor: "#2fdab0",
                downBorderColor: "#f84f4f",
                noChangeBorderColor: "#888888",
                upWickColor: "#2fdab0",
                downWickColor: "#f84f4f",
                noChangeWickColor: "#888888",
            },
        },
        xAxis: {
            axisLine: {
                show: false,
                color: '#888',
                size: 1
            },
        },
        yAxis: {
            // inside: true, // 内容
            axisLine: {
                show: false,
                color: '#888',
                size: 1
            },
        },
    },
};

export default function useKLineChat() {
    let kLineChart: Chart

    const { addListener, removeListener } = useWebsocketStore();

    // 初始化图表˝
    const initChart = (id: string, options?: Options) => {
        if(kLineChart) return
        kLineChart = init(id, options || defaultOptions) as Chart;
        kLineChart.setTimezone(TIMEZONE);

        // kLineChart.createIndicator("MA", false, { id: "candle_pane", });
        // kLineChart.createIndicator("VOL");
    }

    // 获取k线数据
    const getChartData = async (params: GetKLine) => {
        return new Promise<[boolean, KLineData[]]>((resolve) => {
            getKLineData(params).then(({ data }) => {
                const klineData = data.map((item) => ({
                    timestamp: item.time,
                    open: item.open,
                    high: item.high,
                    low: item.low,
                    close: item.close,
                }))
                resolve([true, klineData])
            }).catch(() => {
                resolve([false, []])
            })

        })
    }

    const setPriceVolumePrecision = (
        pricePrecision: number = 4,
        volumePrecision: number = 2
    ) => {
        // 设置精度
        kLineChart.setPriceVolumePrecision(pricePrecision, volumePrecision);
    };

    const applyNewData = (klineData: KLineData[]) => {
        kLineChart.applyNewData(klineData);
    };

    const updateData = (klineData: KLineData) => {
        kLineChart?.updateData(klineData);
    };

    const setTimezone = (timezone: string) => {
        kLineChart.setTimezone(timezone);
    };

    const setLocale = (locale: string) => {
        kLineChart.setLocale(locale);
    };

    let currentSymbol: string | undefined

    const socketCallback = (msg: KLineSymbol) => {
        if (msg.type === "KLINE" && msg.symbol === currentSymbol) {
            const kline = msg.kline
            updateData({
                high: kline.high,
                low: kline.low,
                volume: kline.volume,
                close: kline.close,
                timestamp: kline.time,
                open: kline.open
            })
        }
    }

    const subscribe = (symbol: string) => {
        currentSymbol = symbol
        addListener(`KLINE.${currentSymbol}`, socketCallback)
    }

    const unSubscribe = (symbol: string) => {
        removeListener(`KLINE.${symbol}`, socketCallback)
        currentSymbol = undefined
    }

    return {
        initChart,
        getChartData,
        setPriceVolumePrecision,
        applyNewData,
        updateData,
        setTimezone,
        setLocale,
        subscribe,
        unSubscribe
    }
}

export function useForexKLineChat() {
    let kLineChart: Chart

    const { addListener, removeListener } = useForexSocketStore();

    // 初始化图表˝
    const initChart = (id: string, options?: Options) => {
        kLineChart = init(id, options || defaultOptions) as Chart;
        kLineChart.setTimezone(TIMEZONE);

        // kLineChart.createIndicator("MA", false, { id: "candle_pane", });
        // kLineChart.createIndicator("VOL");
    }

    // 获取k线数据
    const getChartData = async (params: GetFxKLine) => {
        return new Promise<[boolean, KLineData[]]>((resolve) => {
            getFxKLineData(params).then(({ data }) => {
                const klineData = data.map((item) => ({
                    timestamp: item.Time,
                    open: item.Open,
                    high: item.High,
                    low: item.Low,
                    close: item.Close,
                }))
                resolve([true, klineData])
            }).catch(() => {
                resolve([false, []])
            })

        })
    }

    const setPriceVolumePrecision = (
        pricePrecision: number = 4,
        volumePrecision: number = 2
    ) => {
        // 设置精度
        kLineChart.setPriceVolumePrecision(pricePrecision, volumePrecision);
    };

    const applyNewData = (klineData: KLineData[]) => {
        kLineChart.applyNewData(klineData);
    };

    const updateData = (klineData: KLineData) => {
        kLineChart?.updateData(klineData);
    };

    const setTimezone = (timezone: string) => {
        kLineChart.setTimezone(timezone);
    };

    const setLocale = (locale: string) => {
        kLineChart.setLocale(locale);
    };

    let currentSymbol: string | undefined

    const socketCallback = (msg: FOREX_Kline_DATA) => {
        if (msg.type === "KLINE" && msg.symbol === currentSymbol) {
            const kline = msg.kline
            updateData({
                high: kline.High,
                low: kline.Low,
                volume: kline.Volume,
                close: kline.Close,
                timestamp: kline.Time,
                open: kline.Open
            })
        }
    }

    const subscribe = (symbol: string) => {
        currentSymbol = symbol
        addListener(`KLINE.${currentSymbol}`, socketCallback)
    }

    const unSubscribe = (symbol: string) => {
        removeListener(`KLINE.${symbol}`, socketCallback)
        currentSymbol = undefined
    }

    return {
        initChart,
        getChartData,
        setPriceVolumePrecision,
        applyNewData,
        updateData,
        setTimezone,
        setLocale,
        subscribe,
        unSubscribe
    }
}

