import { init, Chart, TooltipShowRule, CandleType, Options, utils, FormatDateType } from "klinecharts";

const defaultOptions: Options = {
  styles: {
    candle: {
      type: CandleType.Area,
      area: {
        lineSize: 1,
      },
      tooltip: {
        custom: [{ title: 'high', value: '{high}' }, { title: 'open', value: '{open}' }, { title: "low", value: "{low}" }],
        // showRule: TooltipShowRule.None,
        // showType: TooltipShowType.Rect,
        text: {
          size: 11
        }
      },
      bar: {
        upColor: "#0166FC",
        downColor: "#F23C48",
        noChangeColor: "#888888",
        upBorderColor: "#0166FC",
        downBorderColor: "#F23C48",
        noChangeBorderColor: "#888888",
        upWickColor: "#0166FC",
        downWickColor: "#F23C48",
        noChangeWickColor: "#888888",
      },
    },
    yAxis: {
      // inside: true, // 内容
    },
    crosshair: {
      horizontal: {
        line: {
          show: false
        }
      }
    },
    grid: {
      horizontal: {
        show: false
      },
      vertical: {
        show: false
      }
    }
  },
  // customApi: {
  //   formatDate: (
  //     dateTimeFormat: Intl.DateTimeFormat,
  //     timestamp,
  //     format: string,
  //     type: FormatDateType
  //   ) => {
  //     switch (period.value) {
  //       case "1min":
  //       case "5min":
  //       case "15min":
  //       case "30min": {
  //         if (type === FormatDateType.XAxis) {
  //           return utils.formatDate(dateTimeFormat, timestamp, "HH:mm");
  //         }
  //         return utils.formatDate(
  //           dateTimeFormat,
  //           timestamp,
  //           "YYYY-MM-DD HH:mm"
  //         );
  //       }
  //       case "60min": {
  //         if (type === FormatDateType.XAxis) {
  //           return utils.formatDate(dateTimeFormat, timestamp, "MM-DD HH:mm");
  //         }
  //         return utils.formatDate(
  //           dateTimeFormat,
  //           timestamp,
  //           "YYYY-MM-DD HH:mm"
  //         );
  //       }
  //       case "1day":
  //       case "1week":
  //         return utils.formatDate(dateTimeFormat, timestamp, "YYYY-MM-DD");
  //       case "1min": {
  //         if (type === FormatDateType.XAxis) {
  //           return utils.formatDate(dateTimeFormat, timestamp, "YYYY-MM");
  //         }
  //         return utils.formatDate(dateTimeFormat, timestamp, "YYYY-MM-DD");
  //       }
  //       case "year": {
  //         if (type === FormatDateType.XAxis) {
  //           return utils.formatDate(dateTimeFormat, timestamp, "YYYY");
  //         }
  //         return utils.formatDate(dateTimeFormat, timestamp, "YYYY-MM-DD");
  //       }
  //     }
  //     return utils.formatDate(dateTimeFormat, timestamp, "YYYY-MM-DD HH:mm");
  //   },
  // },
};

export default function useAreaChart(id: string, options?: Options) {
  // 初始化图表
  const AreaChart = init(id, options || defaultOptions) as Chart;
  // AreaChart.scrollByDistance(50, 100);
  return AreaChart;
}
