
import { init, Chart, TooltipShowRule, CandleType, Options } from "klinecharts";

const defaultOptions: Options = {
    styles: {
        candle: {
            type: CandleType.Area,
            area: {
                lineSize: 2,
                lineColor: "#2fdab0",
                backgroundColor: [
                    {
                        offset: 0,
                        color: "rgba(47, 218, 176, 0.01)",
                    },
                    {
                        offset: 1,
                        color: "rgba(47, 218, 176, 0.2)",
                    },
                ],
            },
            tooltip: {
                // 隐藏头部数据
                showRule: TooltipShowRule.None,
            },
            priceMark: {
                show: false,
            },
        },
        grid: {
            show: false,
        },
        indicator: {
            lastValueMark: {
                show: false,
            },
        },
        crosshair: {
            show: false,
        },
        yAxis: {
            show: false,
            tickText: {
                show: false,
            },
        },
        xAxis: {
            show: false,
            tickText: {
                show: false,
            },
        },
    },
};

export default function useAreaChart(id: string, options?: Options) {
    // 初始化图表
    const AreaChart = init(id, options || defaultOptions) as Chart;
    // AreaChart.scrollByDistance(50, 100);
    return AreaChart;
}
