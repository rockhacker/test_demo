<template>
  <div>
    <div class="divchart bg-white dark:bg-floor">
    <div class="relative">
      <div class="kline" id="kline" ref="kline">
        <!-- <view
          ref="countdown"
          id="countdown"
          v-show="CountDown.IsShow"
          v-bind:style="{
            left: CountDown.Left + 'px',
            top: CountDown.Top + 'px',
            color: CountDown.TextColor,
            'background-color': CountDown.BGColor,
          }"
          >{{ CountDown.Text }}</view
        > -->
      </div>
      <div class="absolute inset-0 z-50"></div>
    </div>
  </div>
  </div>
</template>

<script>
// #ifdef H5
import HQChart from "../uni_modules/jones-hqchart2/js_sdk/umychart.uniapp.h5.js";

//禁用日志
HQChart.JSConsole.Chart.Log = () => {};
HQChart.JSConsole.Complier.Log = () => {};

// #endif

// #ifndef H5
import { JSCommon } from "../uni_modules/jones-hqchart2/js_sdk/umychart.wechat.3.0.js";
import { JSCommonHQStyle } from "../uni_modules/jones-hqchart2/js_sdk/umychart.style.wechat.js";
import { JSConsole } from "../uni_modules/jones-hqchart2/js_sdk/umychart.console.wechat.js";
import { JSCommonCoordinateData } from "../uni_modules/jones-hqchart2/js_sdk/umychart.coordinatedata.wechat.js";

//禁用日志
JSConsole.Complier.Log = () => {};
JSConsole.Chart.Log = () => {};
// #endif

function DefaultData() {}

DefaultData.GetKLineOption = function () {
  let data = {
    Type: "历史K线图",
    Language: "EN",

    //窗口指标
    Windows: [
      { Index: "BOLL_EX", Modify: false, Change: false },
      { Index: "VOL", Modify: false, Change: false },
    ],

    IsCorssOnlyDrawKLine: true,
    CorssCursorTouchEnd: true,
    IsShowRightMenu: false, //是否显示右键菜单
    IsAutoUpdate: false, //是自动更新数据
    AutoUpdateFrequency: 10000, //数据更新频率单位ms
    IsApiPeriod: true, //复权,周期都使用后台数据
    ZoomStepPixel: 15, //缩放一次,2个手指需要移动的间距像素(默认5)

    //边框
    Border: {
      Left: 1,
      Right: 1, //右边间距
      Top: 25,
      Bottom: 25,
    },

    KLine: {
      Right: 1, //复权 0 不复权 1 前复权 2 后复权
      Period: 0, //周期: 0 日线 1 周线 2 月线 3 年线
      PageSize: 30,
      IsShowTooltip: false,
      RightSpaceCount: 4,
    },

    ExtendChart: [
      { Name: "KLineTooltip" }, //开启手机端tooltip
    ],

    //子框架设置
    Frame: [
      {
        SplitCount: 4,
        IsShowLeftText: false,
        Height: 8,
        SplitType: 1,
        Custom: [{ Type: 0, Position: "right", CountDown: true }],
      },

      { SplitCount: 2, IsShowLeftText: false, Height: 2 },
    ],
  };

  return data;
};

//K线分时面积图
DefaultData.GetKLineAreaOption = function () {
  //K线配置信息
  var option = {
    Type: "历史K线图", //创建图形类型
    Language: "EN",
    //窗口指标
    Windows: [
      {
        Index: "EMPTY",
        Modify: false,
        Change: false,
        IsShowIndexName: false,
        TitleHeight: 0,
      },
      {
        Index: "VOL",
        Modify: false,
        Change: false,
        Close: false,
        IsShowIndexName: false,
      },
    ],

    IsAutoUpdate: false, //是自动更新数据
    AutoUpdateFrequency: 10000, //数据更新频率 单位ms
    IsShowRightMenu: false, //右键菜单

    IsApiPeriod: true, //复权,周期都使用后台数据

    CorssCursorTouchEnd: true,
    IsClickShowCorssCursor: true, //手势点击出现十字光标
    //StepPixel:5,        //移动一个K线需要的手势移动的像素(默认4)
    //ZoomStepPixel:8,    //缩放一次,2个手指需要移动的间距像素(默认5)

    //K线设置
    KLine: {
      DragMode: 1, //拖拽模式 0 禁止拖拽 1 数据拖拽 2 区间选择
      Right: 0, //复权 0 不复权 1 前复权 2 后复权
      Period: 4, //周期 0 日线 1 周线 2 月线 3 年线 , 4=1分钟 5=5分钟 6=15分钟 7=30分钟 8=60分钟 11=120分钟 12=240分钟
      MaxReqeustDataCount: 300, //数据个数取300条
      MaxRequestMinuteDayCount: 300, //分钟数据取300条
      PageSize: 60, //一屏显示多少数据
      IsShowTooltip: false, //是否显示 div K线提示信息 (手机端要填false)
      DrawType: 4, //K线类型 0=实心K线柱子 1=收盘价线 2=美国线 3=空心K线柱子 4=收盘价面积图
      RightSpaceCount: 3,
    },

    //标题设置
    KLineTitle: {
      IsShowName: true, //不显示股票名称
      IsShowSettingInfo: true, //不显示周期/复权
    },

    //边框
    Border: {
      Left: 1, //左边间距
      Right: 1, //右边间距
      Bottom: 25, //底部间距
      Top: 1, //顶部间距
    },

    //子框架设置
    Frame: [
      {
        SplitCount: 3,
        IsShowLeftText: false,
        Height: 8,
        SplitType: 1,
        Custom: [{ Type: 0, Position: "right" }],
      },

      { SplitCount: 2, IsShowLeftText: false, Height: 2 },
    ],

    //扩展图形
    ExtendChart: [
      { Name: "KLineTooltip" }, //手机端tooltip
    ],
  };

  return option;
};

DefaultData.GetMinuteOption = function () {
  //分时图配置信息
  var option = {
    Language: "EN",
    Type: "分钟走势图", //创建图形类型
    //Type:'分钟走势图横屏',

    //窗口指标
    Windows: [
      //{Index:"MACD", Modify:true, Change:false, Close:false }
      //{Index:"涨跌趋势", Modify:false,Change:false},
    ],

    Symbol: "000001.sz",
    IsAutoUpdate: false, //关闭自动更新由外部ws更新
    AutoUpdateFrequency: 10000, //数据更新频率单位ms
    DayCount: 1, //1 最新交易日数据 >1 多日走势图
    IsShowRightMenu: false, //是否显示右键菜单
    CorssCursorTouchEnd: true,

    //CorssCursorInfo:{  Left:2, Right:2, Bottom:1,RightTextFormat:1 },

    MinuteLine: {
      IsDrawAreaPrice: true, //是否画价格面积图
      IsShowAveragePrice: false, //不显示均线
      //SplitType:2,
    },

    MinuteTitle: {
      IsShowTime: true,
      IsShowName: false,
      IsShowDate: false,
    },

    //EnableBorderDrag:false,

    //边框
    Border: {
      Left: 1, //左边间距
      Right: 1, //右边间距
      Top: 25,
      Bottom: 25,
    },

    //子框架设置
    Frame: [
      {
        SplitCount: 5,
        Custom: [{ Type: 0, Position: "right" }],
      },
      { SplitCount: 3, Height: 0 },
    ],

    //扩展图形
    ExtendChart: [
      { Name: "MinuteTooltip" }, //手机端tooltip
    ],
  };

  return option;
};

//深度图
DefaultData.GetDepthChartOption = function () {
  var option = {
    Language: "EN",
    Type: "深度图", //创建图形类型

    Symbol: "BTCBUSD.bit",
    IsAutoUpdate: true, //是自动更新数据
    AutoUpdateFrequency: 10000, //数据更新频率
    //CorssCursorTouchEnd:true,
    EnableScrollUpDown: true,

    MaxVolRate: 1.2,

    CorssCursorInfo: { HPenType: 0, VPenType: 1, IsShowTooltip: true },

    //边框
    Border: {
      Left: 1, //左边间距
      Right: 40, //右边间距
      Bottom: 25, //底部间距
      Top: 1, //顶部间距
    },

    //框架设置
    Frame: { SplitCount: 6, IsShowLeftText: false },
  };

  return option;
};

//0=日线 1=周线 2=月线 3=年线 9=季线 21=双周
//4=1分钟 5=5分钟 6=15分钟 7=30分钟 8=60分钟 11=120分钟 12=240分钟
var PERIOD_NAME = new Map([
  // [0, "1d"], //day
  // [1, "1w"], //week
  // [2, "1M"], //month

  // [4, "1m"], //1 minute
  // [6, "15m"], //15 minute
  // [8, "1h"], //60 minute

  [0, "1day"], //day
  [1, "1week"], //week
  [2, "1mon"], //month

  [4, "1min"], //1 minute
  [5, "5min"], //5 minute
  [6, "15min"], //15 minute
  [7, "30min"], //30 minute
  [8, "60min"], //60 minute
]);

var g_KLine = { JSChart: null };

import { mapState } from 'vuex';
export default {
  props:['currencyMatch'],
  data() {
    let data = {
      symbol: "BTC/USDT",
      currency_match_id: 1,
      decimal:4,

      Symbol: "BTCBUSD.bit",
      ChartWidth: 300,
      ChartHeight: 600,

      KLine: {
        Option: DefaultData.GetKLineOption(),
      },

      Minute: {
        Option: DefaultData.GetMinuteOption(),
        Data: null, //缓存所有显示的数据
        Symbol: null,
        DateTimeRange: null, //交易时间段
        XCoordinateData: null, //x轴信息
      },

      DepthChart: {
        Option: DefaultData.GetDepthChartOption(),
      },

      //K线倒计时
      CountDown: {
        Text: "04:11",
        IsShow: false,
        EndDate: null,
        Left: 0,
        Top: 0,
        Width: 50,
        TimerID: null, //定时器
        BGColor: "rgb(0,0,0)",
        TextColor: "rgb(0,0,0)",
      },

      WSUrl: "wss://stream.binance.com/stream",
      SocketOpen: false,
      LastSubString: null, //最后一个订阅的数据
      SubID: 1,

      CahceUpdate: null, //更新缓存
      LastUpdateTime: null, //最后一次更新时间
      EnableCacheUpdate: false,

      isKline: false,
      period: null,
      callback: null,
    };

    return data;
  },
  computed:{
    ...mapState(['theme']),
  },
  onLoad() {},

  mounted() {
    uni.getSystemInfo({
      success: (res) => {
        var width = res.windowWidth;
        var height = res.windowHeight;
        this.ChartWidth = width;
        this.ChartHeight = 316;
        this.$nextTick(() => {
          this.InitalHQChart();
          this.OnSize();
          //   this.ChangeKLineArea()
          // this.ChangeLanguage("EN");
        });
      },
    });
  },

  onReady() {
    this.$nextTick(() => {
      //this.InitalHQChart();
      //this.OnSize();
      //this.CreateKLineChart();
    });
  },

  // onHide() {
  //   if (this.SocketOpen) {
  //     uni.closeSocket();
  //     this.SocketOpen = false;
  //   }
  //   clearInterval(this.CountDown.TimerID);
  //   this.ClearChart();
  // },

  // onUnload() {
  //   if (this.SocketOpen) {
  //     uni.closeSocket();
  //     this.SocketOpen = false;
  //   }
  //   clearInterval(this.CountDown.TimerID);
  //   this.ClearChart();
  // },

  methods: {
    hide() {
      clearInterval(this.CountDown.TimerID);
      this.ClearChart();
      this.$ws.unSub([`KLINE.${this.symbol}`]);
      this.$ws.unRegisterCallBack(this.callback);
      this.callback = null;
    },
    OnSize() {
      // #ifdef H5
      var chartHeight = this.ChartHeight;
      var chartWidth = this.ChartWidth;

      var kline = this.$refs.kline;
      kline.style.width = chartWidth + "px";
      kline.style.height = chartHeight + "px";
      if (g_KLine.JSChart) g_KLine.JSChart.OnSize();
      // #endif
    },

    IsKLineChart() {
      if (this.IsKLineAreaChart()) return false;

      if (!g_KLine.JSChart || !g_KLine.JSChart.JSChartContainer) return false;
      return (
        g_KLine.JSChart.JSChartContainer.ClassName == "KLineChartContainer"
      );
    },

    IsMinuteChart() {
      if (!g_KLine.JSChart || !g_KLine.JSChart.JSChartContainer) return false;
      return (
        g_KLine.JSChart.JSChartContainer.ClassName == "MinuteChartContainer"
      );
    },

    IsKLineAreaChart() {
      if (!g_KLine.JSChart || !g_KLine.JSChart.JSChartContainer) return false;
      return g_KLine.JSChart.KLineName == "KLineArea";
    },

    IsDepthChart() {
      if (!g_KLine.JSChart || !g_KLine.JSChart.JSChartContainer) return false;
      return g_KLine.JSChart.ClassName == "DepthChartContainer";
    },

    ClearChart() {
      if (g_KLine.JSChart) {
        g_KLine.JSChart.ChartDestory();
        g_KLine.JSChart = null;
      }

      // #ifdef H5
      var divKLine = document.getElementById("kline");
      if (divKLine && divKLine.hasChildNodes()) {
        var aryNode = divKLine.childNodes;
        var aryRemoveNode = [];
        for (var i = 0; i < aryNode.length; ++i) {
          var item = aryNode[i];
          if (item.id == "countdown") continue;
          aryRemoveNode.push(item);
        }

        for (var i = 0; i < aryRemoveNode.length; ++i) {
          aryRemoveNode[i].remove();
        }
      }
      // #endif
    },

    ChangeDepthChart() {
      this.ResetCountDown();
      if (!this.IsDepthChart()) this.CreateDepthChart();
    },

    CreateDepthChart() {
      this.ClearChart();

      // #ifdef H5
      this.CreateDepthChart_h5();
      // #endif

      // #ifndef H5
      this.CreateDepthChart_app();
      // #endif
    },

    CreateDepthChart_h5() {
      this.DepthChart.Option.Symbol = this.Symbol;
      this.DepthChart.Option.NetworkFilter = this.NetworkFilter;
      let chart = HQChart.JSChart.Init(this.$refs.kline);
      chart.SetOption(this.DepthChart.Option);
      g_KLine.JSChart = chart;
    },

    CreateDepthChart_app() {
      let element = new JSCommon.JSCanvasElement();
      // #ifdef APP-PLUS
      element.IsUniApp = true; //canvas需要指定下 是uniapp的app
      // #endif
      element.ID = "kline2";
      element.Height = this.ChartHeight; //高度宽度需要手动绑定!!
      element.Width = this.ChartWidth;

      g_KLine.JSChart = JSCommon.JSChart.Init(element);
      this.DepthChart.Option.NetworkFilter = this.NetworkFilter;
      this.DepthChart.Option.Symbol = this.Symbol;
      this.DepthChart.Option.IsFullDraw = true; //每次手势移动全屏重绘
      g_KLine.JSChart.SetOption(this.DepthChart.Option);
    },

    //切换指标
    ChangeIndex(windowIndex, name) {
      if (g_KLine.JSChart) g_KLine.JSChart.ChangeIndex(windowIndex, name);
    },

    ChangeMinute() {
      this.ResetCountDown();
      if (!this.IsMinuteChart()) this.CreateMinuteChart();
    },

    ChangeLanguage(value) {
      if (g_KLine.JSChart) g_KLine.JSChart.SetLanguage(value);
    },

    CreateKLineChart(
      period //创建K线图
    ) {
      this.clearCallback();
      this.ClearChart();
      this.CahceUpdate = null;
      this.isKline = true;
      // #ifdef H5
      this.CreateKLineChart_h5(period);
      // #endif

      // #ifndef H5
      this.CreateKLineChart_app(period);
      // #endif
    },

    //设置图形颜色
    SetHQChartStyle(blackStyle) {
      blackStyle.BGColor =  this.theme =='dark'?"#171e26":"#fff"; //背景
      blackStyle.TooltipPaint.BGColor = "rgba(14,24,46,0.8)"; //tooltip背景色
      blackStyle.FrameTitleBGColor = this.theme =='dark'?"#171e26":"#fff"; //指标标题背景
      blackStyle.FrameSplitTextColor = "rgb(101,117,138)"; //刻度颜色

      //K线颜色
      blackStyle.UpBarColor = "rgb(37,175,142)";
      blackStyle.UpTextColor = blackStyle.UpBarColor;
      blackStyle.DownBarColor = "rgb(210,73,99)";
      blackStyle.DownTextColor = blackStyle.DownBarColor;
      //平盘
      blackStyle.UnchagneBarColor = blackStyle.UpBarColor;
      blackStyle.UnchagneTextColor = blackStyle.UpBarColor;

      //指标线段颜色
      blackStyle.Index.LineColor[0] = "rgb(88,106,126)";
      blackStyle.Index.LineColor[1] = "rgb(222,217,167)";
      blackStyle.Index.LineColor[2] = "rgb(113,161,164)";

      blackStyle.TitleFont;

      //最新价格刻度颜色
      blackStyle.FrameLatestPrice.UpBarColor = "rgb(37,175,142)";
      blackStyle.FrameLatestPrice.DownBarColor = "rgb(210,73,99)";
      blackStyle.FrameLatestPrice.UnchagneBarColor =
        blackStyle.FrameLatestPrice.UpBarColor;

      //blackStyle.Minute.PriceColor='rgb(255,255,255)';
    },

    InitalHQChart() {
      // #ifdef H5
      HQChart.MARKET_SUFFIX_NAME.GetBITDecimal = this.GetBITDecimal;
      var blackStyle = HQChart.HQChartStyle.GetStyleConfig(
        HQChart.STYLE_TYPE_ID.BLACK_ID
      );
      HQChart.JSChart.GetResource().FrameLogo.Text = null;

      this.SetHQChartStyle(blackStyle);
      HQChart.JSChart.SetStyle(blackStyle);

      HQChart.JSChart.GetMinuteTimeStringData().CreateBITData = () => {
        return this.CreateBITDataIndex();
      }; //当天所有的交易时间点
      HQChart.JSChart.GetMinuteCoordinateData().GetBITData = (upperSymbol) => {
        return this.Minute.XCoordinateData;
      }; //X轴刻度
      // #endif

      // #ifndef H5
      JSCommon.MARKET_SUFFIX_NAME.GetBITDecimal = this.GetBITDecimal;
      var blackStyle = JSCommonHQStyle.GetStyleConfig(
        JSCommonHQStyle.STYLE_TYPE_ID.BLACK_ID
      );
      this.SetHQChartStyle(blackStyle);
      JSCommon.JSChart.SetStyle(blackStyle);

      JSCommonCoordinateData.MinuteCoordinateData.GetBITData = (
        upperSymbol
      ) => {
        return this.Minute.XCoordinateData;
      };
      JSCommonCoordinateData.MinuteTimeStringData.CreateBITData = () => {
        return this.CreateBITDataIndex();
      };
      // #endif

      //倒计时定时器
      this.CountDown.TimerID = setInterval(() => {
        this.CountDownTimer();
      }, 600);
    },

    CreateKLineChart_h5(
      period //创建K线图
    ) {
      //if (g_KLine.JSChart) return;
      this.KLine.Option.Symbol = this.Symbol;
      this.KLine.Option.KLine.Period = period;
      this.KLine.Option.NetworkFilter = this.NetworkFilter;
      this.KLine.Option.Border.AutoRight = { Blank: 5, MinWidth: 40 };
      this.KLine.Option.Border.Right = 40;
      let chart = HQChart.JSChart.Init(this.$refs.kline);
      HQChart.JSChart.GetResource().KLine.MaxMin.Color =  this.theme =='dark'?"rgb(255,250,240)":"rgb(0,0,0)"; //最高价格 最低价格颜色

      chart.SetOption(this.KLine.Option);
      g_KLine.JSChart = chart;

      chart.AddEventCallback({
        event: HQChart.JSCHART_EVENT_ID.ON_DRAW_COUNTDOWN,
        callback: (event, data, chart) => {
          this.OnDrawCountDown(event, data, chart);
        },
      });
    },

    CreateKLineChart_app(period) {
      let element = new JSCommon.JSCanvasElement();
      // #ifdef APP-PLUS
      element.IsUniApp = true; //canvas需要指定下 是uniapp的app
      // #endif
      element.ID = "kline2";
      element.Height = this.ChartHeight; //高度宽度需要手动绑定!!
      element.Width = this.ChartWidth;

      g_KLine.JSChart = JSCommon.JSChart.Init(element);
      this.KLine.Option.NetworkFilter = this.NetworkFilter;
      this.KLine.Option.Symbol = this.Symbol;
      this.KLine.Option.KLine.Period = period;
      this.KLine.Option.IsClickShowCorssCursor = true;
      this.KLine.Option.IsFullDraw = true; //每次手势移动全屏重绘
      g_KLine.JSChart.SetOption(this.KLine.Option);

      g_KLine.JSChart.AddEventCallback({
        event: JSCommon.JSCHART_EVENT_ID.ON_DRAW_COUNTDOWN,
        callback: (event, data, chart) => {
          this.OnDrawCountDown(event, data, chart);
        },
      });
    },

    CreateKLineAreaChart() {
      this.ClearChart();
      this.isKline = false;
      // #ifdef H5
      this.CreateKLineAreaChart_h5();
      // #endif

      // #ifndef H5
      this.CreateKLineAreaChart_app();
      // #endif
    },

    CreateKLineAreaChart_h5() {
      //if (g_KLine.JSChart) return;
      var option = DefaultData.GetKLineAreaOption();
      option.Symbol = this.Symbol;
      option.NetworkFilter = this.NetworkFilter;
      let chart = HQChart.JSChart.Init(this.$refs.kline);
      chart.KLineName == "KLineArea";
      chart.SetOption(option);
      g_KLine.JSChart = chart;
    },

    CreateKLineAreaChart_app() {
      let element = new JSCommon.JSCanvasElement();
      // #ifdef APP-PLUS
      element.IsUniApp = true; //canvas需要指定下 是uniapp的app
      // #endif
      element.ID = "kline2";
      element.Height = this.ChartHeight; //高度宽度需要手动绑定!!
      element.Width = this.ChartWidth;

      g_KLine.JSChart = JSCommon.JSChart.Init(element);
      g_KLine.JSChart.KLineName = "KLineArea";

      var option = DefaultData.GetKLineAreaOption();
      option.NetworkFilter = this.NetworkFilter;
      option.Symbol = this.Symbol;
      option.IsClickShowCorssCursor = true;
      option.IsFullDraw = true; //每次手势移动全屏重绘
      g_KLine.JSChart.SetOption(option);
    },

    CreateMinuteChart() {
      this.ClearChart();

      this.Minute.Data = null;
      this.CreateDateTimeRange();

      // #ifdef H5
      this.CreateMinuteChart_h5();
      // #endif

      // #ifndef H5
      this.CreateMinuteChart_app();
      // #endif
    },

    CreateMinuteChart_app() {
      let element = new JSCommon.JSCanvasElement();
      // #ifdef APP-PLUS
      element.IsUniApp = true; //canvas需要指定下 是uniapp的app
      // #endif
      element.ID = "kline2";
      element.Height = this.ChartHeight; //高度宽度需要手动绑定!!
      element.Width = this.ChartWidth;

      g_KLine.JSChart = JSCommon.JSChart.Init(element);
      this.Minute.Option.NetworkFilter = this.NetworkFilter;
      this.Minute.Option.Symbol = this.Symbol;
      this.Minute.Option.IsClickShowCorssCursor = true;
      this.Minute.Option.IsFullDraw = true; //每次手势移动全屏重绘
      g_KLine.JSChart.SetOption(this.Minute.Option);
    },

    CreateMinuteChart_h5() {
      this.Minute.Option.Symbol = this.Symbol;
      this.Minute.Option.NetworkFilter = this.NetworkFilter;
      let chart = HQChart.JSChart.Init(this.$refs.kline);
      chart.SetOption(this.Minute.Option);
      g_KLine.JSChart = chart;
    },

    ChangeKLineArea(data) {
      if (data) {
        this.currency_match_id = data.currency_match_id;
        this.symbol = data.symbol;
        this.decimal = data.decimal
      }
      this.clearCallback();
      //分时面积图
      if (!this.IsKLineAreaChart()) {
        this.ResetCountDown();
        this.CreateKLineAreaChart();
      }
    },

    ChangePeriod(period, data = {}) {
      this.currency_match_id = data.currency_match_id || this.currency_match_id;
      this.symbol = data.symbol || this.symbol;
      this.decimal = data.decimal || 4
      this.clearCallback();
      this.ResetCountDown();
      if (this.IsKLineChart() && this.isKline) {
        g_KLine.JSChart.ChangePeriod(period);
      } else {
        this.CreateKLineChart(period);
      }
    },

    ChangeSymbol(symbol) {
      if (g_KLine.JSChart) {
        this.ResetCountDown();
        this.Symbol = symbol;
        g_KLine.JSChart.ChangeSymbol(symbol);
      }
    },

    //不同的品种返回不同的小数位数
    GetBITDecimal(symbol) {
      try {
        return this.currencyMatch.base_currency.decimal || 6
      } catch (error) {
        return 6
      }
      // var upperSymbol = symbol.toUpperCase();
      // if (upperSymbol == "BUSDUSDT.BIT") return 4;
      // else if (upperSymbol == "ADXBTC.BIT") return 8;

      // return 2;
    },

    CountDownTimer() {
      if (!this.UpdateCountDownText()) this.CountDown.IsShow = false;
    },

    UpdateCountDownText() {
      //更新K线倒计时
      if (this.CountDown.EndDate == null) return false;

      var newDate = new Date();
      var endDate = this.CountDown.EndDate;

      var endTime = endDate.getTime();
      var nowTime = newDate.getTime();

      if (nowTime >= endTime) return false;

      var time = `${endDate.getHours()}:${endDate.getMinutes()}:${endDate.getSeconds()}`;

      var difSecond = Math.ceil((endTime - nowTime) / 1000);

      var minute = parseInt(difSecond / 60);
      var second = difSecond % 60;

      if (minute < 10) minute = `0${minute}`;
      else minute = minute.toString();

      if (second < 10) second = `0${second}`;
      else second = second.toString();

      this.CountDown.Text = `${minute}:${second}`;
      return true;
    },

    OnDrawCountDown(event, data, chart) {
      // console.log("[App:OnDrawCountDown] data", data);
      if (this.CountDown.EndDate == null) {
        this.CountDown.IsShow = false;
        return;
      }

      if (!this.UpdateCountDownText()) {
        this.CountDown.IsShow = false;
        return;
      }

      if (data.IsShow) {
        var pixelTatio = 1;
        if (data.PixelTatio > 0) pixelTatio = data.PixelTatio;
        if (data.IsInside) {
          //窗口内部显示
          var divCountdown = this.$refs.countdown;
          this.CountDown.Left = data.Right / pixelTatio - this.CountDown.Width;
          this.CountDown.Top = data.Top / pixelTatio;
        } else {
          this.CountDown.Left = data.Left / pixelTatio;
          this.CountDown.Top = data.Top / pixelTatio;
        }

        this.CountDown.TextColor = data.TextColor;
        this.CountDown.BGColor = data.BGColor;
        this.CountDown.IsShow = true;
      } else {
        this.CountDown.IsShow = false;
      }
    },

    ResetCountDown() {
      this.CountDown.IsShow = false;
      this.CountDown.EndDate = null;
    },

    NetworkFilter(data, callback) {
      console.log("[HQChartDemo::NetworkFilter] data", data);
      switch (data.Name) {
        case "KLineChartContainer::ReqeustHistoryMinuteData": //分钟全量数据下载
          this.RequestHistoryMinuteData(data, callback);
          break;

        case "KLineChartContainer::RequestHistoryData": //日线全量数据下载
          this.RequestHistoryData(data, callback);
          break;

        case "MinuteChartContainer::RequestMinuteData": //分时图
          this.RequestMinuteData(data, callback);
          break;

        case "DepthChartContainer::RequestDepthData": //深度图
          this.RequestDepthData(data, callback);
          break;
      }
    },

    GetDateTime() {
      var date = new Date();
      var strValue = `${date.getFullYear()}-${
        date.getMonth() + 1
      }-${date.getDate()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;

      return strValue;
    },

    //HQChart 品种代码转安币代码
    ToBinanceSymbol(symbol) {
      var upperSymbol = symbol.toUpperCase();
      var value = upperSymbol.replace(".BIT", "");
      return value;
    },

    GetKLineUrl(symbol, interval, limit) {
      var url;
      if (limit > 0)
        url = `https://www.binance.com/api/v1/klines?symbol=${symbol}&interval=${interval}&limit=${limit}`;
      else
        url = `https://www.binance.com/api/v1/klines?symbol=${symbol}&interval=${interval}`;

      return url;
    },

    GetWSParam(symbol, period) {
      var value = symbol.toLowerCase() + "@kline_" + period;
      return value;
    },

    //日线数据
    RequestHistoryData(data, callback) {
      data.PreventDefault = true;
      var self = this;
      var symbol = data.Request.Data.symbol;
      var period = data.Self.Period;
      var right = data.Self.Right;
      var dayCount = data.Self.MaxReqeustDataCount;
      this.CahceUpdate = null;

      //   var url = this.GetKLineUrl(
      //     this.ToBinanceSymbol(symbol),
      //     PERIOD_NAME.get(period)
      //   );
      //   var log = `[${this.GetDateTime()}][KLineChart::RequestHistoryData] 全量日K数据请求信息 代码=${symbol} 周期=${period} 复权=${right} K线个数=${dayCount}, url=${url}`;
      //   console.log(log);

      this.$utils.initDataToken(
        {
          url: "market/kline",
          data: {
            period: PERIOD_NAME.get(period),
            currency_match_id: this.currency_match_id,
          },
        },
        (res) => {
          this.RecvHistoryData(data, callback, res);
        }
      );
    },

    RecvHistoryData(data, callback, recvdata) {
      // console.log("[KLineChart::RecvHistoryData] recvdata", recvdata);

      var symbol = data.Request.Data.symbol;
      var hqChartData = { symbol: symbol, Name: symbol, data: [] };

      var yClose = null; //前收盘
      recvdata.map((item) => {
        var dateTime = new Date(item.time);
        const losAngelesTime = dateTime.toLocaleString("en-US", {
          timeZone: "America/New_York",
        });
        const losAngelesTimestamp = new Date(losAngelesTime).getTime();
        dateTime.setTime(losAngelesTimestamp);
        var date =
          dateTime.getFullYear() * 10000 +
          (dateTime.getMonth() + 1) * 100 +
          dateTime.getDate();
        var time = dateTime.getHours() * 100 + dateTime.getMinutes();
        var open = parseFloat(item.open);
        var high = parseFloat(item.high);
        var low = parseFloat(item.low);
        var close = parseFloat(item.close);
        var vol = parseFloat(item.volume);
        var amount = parseFloat(item.amount);
        var newItem = [date, yClose, open, high, low, close, vol, amount, time];
        // var endDate = new Date();
        // endDate.setTime(item[6]);
        // lastData = { Date: date, Time: time, Close: close, EndDate: endDate };

        yClose = close;
        hqChartData.data.push(newItem);
      });

      if (data.Self.IsDestroy == false) {
        // #ifdef H5
        callback(hqChartData);
        // #endif

        // #ifndef H5
        callback({ data: hqChartData });
        // #endif

        //订阅最新数据
        this.SubscribeRealtimeData(data);
      }
    },

    //订阅最新日K线数据
    SubscribeRealtimeData(data) {
      //订阅最新数据
      // var symbol = data.Request.Data.symbol;
      var period = data.Self.Period;

      const param = `KLINE.${this.symbol}`;

      this.$ws.Sub(param);

      this.callback = (recvData) => {
        this.RecvSubscribeRealtimeData(recvData, data);
      };

      this.$ws.registerCallBack(this.callback);
    },

    RecvSubscribeRealtimeData(recvdata, data) {
      var symbol = data.Self.Symbol;
      var period = data.Self.Period;
      // var param = this.GetWSParam(
      //   this.ToBinanceSymbol(symbol),
      //   PERIOD_NAME.get(period)
      // );

      if (
        !recvdata ||
        !recvdata.kline ||
        this.symbol != recvdata.symbol ||
        PERIOD_NAME.get(period) != recvdata.kline.period
      ) {
        return;
      }

      // console.log("[KLineChart::RecvSubscribeRealtimeData] recvdata", recvdata);

      var kData = recvdata.kline;
      var hqChartData = { stock: [], code: 0 };

      var yClose = null; //前收盘
      var newItem = { symbol: symbol, name: symbol };

      var dateTime = new Date(kData.time);
      const losAngelesTime = dateTime.toLocaleString("en-US", {
        timeZone: "America/New_York",
      });
      const losAngelesTimestamp = new Date(losAngelesTime).getTime();
      dateTime.setTime(losAngelesTimestamp);
      var date =
        dateTime.getFullYear() * 10000 +
        (dateTime.getMonth() + 1) * 100 +
        dateTime.getDate();
      var time =
        dateTime.getHours() * 10000 +
        dateTime.getMinutes() * 100 +
        dateTime.getSeconds();

      newItem.date = date;
      newItem.time = time;
      newItem.price = parseFloat(kData.close);
      newItem.high = parseFloat(kData.high);
      newItem.low = parseFloat(kData.low);
      newItem.open = parseFloat(kData.open);
      newItem.vol = parseFloat(kData.volume);
      newItem.amount = parseFloat(kData.amount);

      hqChartData.stock[0] = newItem;

      if (data.Self.IsDestroy == false) {
        // #ifdef H5
        data.Self.RecvRealtimeData(hqChartData);
        // #endif

        // #ifndef H5
        data.Self.RecvRealtimeData({ data: hqChartData });
        // #endif
      }
    },

    //分钟数据
    RequestHistoryMinuteData(data, callback) {
      data.PreventDefault = true;
      var symbol = data.Request.Data.symbol;
      var period = data.Self.Period;
      var right = data.Self.Right;
      var dayCount = data.Self.MaxRequestMinuteDayCount;
      this.CahceUpdate = null;

      //   var url = this.GetKLineUrl(
      //     this.ToBinanceSymbol(symbol),
      //     PERIOD_NAME.get(period)
      //   );
      //   var log = `[${this.GetDateTime()}][KLineChart::RequestHistoryMinuteData] 全量分钟K数据请求信息 代码=${symbol} 周期=${period} 复权=${right} K线(天数)=${dayCount}, rul=${url}`;
      //   console.log(log);

      this.$utils.initDataToken(
        {
          url: "market/kline",
          data: {
            period: PERIOD_NAME.get(period),
            currency_match_id: this.currency_match_id,
          },
        },
        (res) => {
          this.RecvHistoryMinuteData(data, callback, res);
        }
      );

      //   uni.request({
      //     url: url, //仅为示例，并非真实接口地址。
      //     success: (res) => {
      //       console.log(res.data);
      //       this.RecvHistoryMinuteData(data, callback, res);
      //     },
      //   });
    },

    RecvHistoryMinuteData(data, callback, recvdata) {
      var symbol = data.Request.Data.symbol;
      var hqChartData = { symbol: symbol, Name: symbol, data: [] };

      var lastData = null;
      var yClose = null; //前收盘
      recvdata.map((item) => {
        // 修改时区
        var dateTime = new Date(item.time);
        const losAngelesTime = dateTime.toLocaleString("en-US", {
          timeZone: "America/New_York",
        });
        const losAngelesTimestamp = new Date(losAngelesTime).getTime();
        dateTime.setTime(losAngelesTimestamp);
        var date =
          dateTime.getFullYear() * 10000 +
          (dateTime.getMonth() + 1) * 100 +
          dateTime.getDate();
        var time = dateTime.getHours() * 100 + dateTime.getMinutes();
        var open = parseFloat(item.open);
        var high = parseFloat(item.high);
        var low = parseFloat(item.low);
        var close = parseFloat(item.close);
        var vol = parseFloat(item.volume);
        var amount = parseFloat(item.amount);
        var newItem = [date, yClose, open, high, low, close, vol, amount, time];
        // var endDate = new Date();
        // endDate.setTime(item[6]);
        // lastData = { Date: date, Time: time, Close: close, EndDate: endDate };

        yClose = close;
        hqChartData.data.push(newItem);
      });

      //   for (var i in recvdata.data) {
      //     var item = recvdata.data[i];
      //     var dateTime = new Date();
      //     dateTime.setTime(item[0]);
      //     var date =
      //       dateTime.getFullYear() * 10000 +
      //       (dateTime.getMonth() + 1) * 100 +
      //       dateTime.getDate();
      //     var time = dateTime.getHours() * 100 + dateTime.getMinutes();
      //     var open = parseFloat(item[1]);
      //     var high = parseFloat(item[2]);
      //     var low = parseFloat(item[3]);
      //     var close = parseFloat(item[4]);
      //     var vol = parseFloat(item[5]);
      //     var amount = parseFloat(item[7]);
      //     var newItem = [date, yClose, open, high, low, close, vol, amount, time];

      //     var endDate = new Date();
      //     endDate.setTime(item[6]);
      //     lastData = { Date: date, Time: time, Close: close, EndDate: endDate };

      //     yClose = close;
      //     hqChartData.data.push(newItem);
      //   }

      if (data.Self.IsDestroy == false) {
        // if (lastData.EndDate) this.CountDown.EndDate = lastData.EndDate;

        // #ifdef H5
        callback(hqChartData);
        // #endif

        // #ifndef H5
        callback({ data: hqChartData });
        // #endif

        this.SubscribeMinuteRealtimeData(data);
      }
    },

    //ws更新分钟K数据
    SubscribeMinuteRealtimeData(data) {
      //订阅最新数据

      // var symbol = data.Request.Data.symbol;
      // var period = data.Self.Period;
      // PERIOD_NAME.get(period)

      const param = `KLINE.${this.symbol}`;

      this.$ws.Sub(param);

      this.callback = (recvData) => {
        this.RecvSubscribeMinuteRealtimeData(recvData, data);
      };

      this.$ws.registerCallBack(this.callback);

      // var param = this.GetWSParam(
      //   this.ToBinanceSymbol(symbol),
      //   PERIOD_NAME.get(period)
      // );
      // var postData = { method: "SUBSCRIBE", params: [param] };
      // var obj = { SendData: postData, Symbol: symbol, Period: period };

      // this.RequestWSData(obj, (recvData) => {
      //   this.RecvSubscribeMinuteRealtimeData(recvData, data);
      // });
    },

    RecvSubscribeMinuteRealtimeData(recvdata, data) {
      var symbol = data.Self.Symbol;
      var period = data.Self.Period;

      // var param = this.GetWSParam(
      //   this.ToBinanceSymbol(symbol),
      //   PERIOD_NAME.get(period)
      // );
      if (
        !recvdata ||
        !recvdata.kline ||
        this.symbol != recvdata.symbol ||
        PERIOD_NAME.get(period) != recvdata.kline.period
      ) {
        return;
      }
      // console.log(
      //   "[KLineChart::RecvSubscribeMinuteRealtimeData] recvdata",
      //   recvdata
      // );

      var lastData = null;
      var kData = recvdata.kline;
      var dateTime = new Date(kData.time);
      const losAngelesTime = dateTime.toLocaleString("en-US", {
        timeZone: "America/New_York",
      });
      const losAngelesTimestamp = new Date(losAngelesTime).getTime();
      dateTime.setTime(losAngelesTimestamp);
      var date =
        dateTime.getFullYear() * 10000 +
        (dateTime.getMonth() + 1) * 100 +
        dateTime.getDate();
      var time = dateTime.getHours() * 100 + dateTime.getMinutes();
      var yClose = null; //前收盘
      var close = parseFloat(kData.close);
      var high = parseFloat(kData.high);
      var low = parseFloat(kData.low);
      var open = parseFloat(kData.open);
      var vol = parseFloat(kData.volume);
      var amount = parseFloat(kData.amount);
      var newItem = [date, yClose, open, high, low, close, vol, amount, time];

      // var endDate = new Date();
      // endDate.setTime(kData.T);
      // lastData = { Date: date, Time: time, Close: close, EndDate: endDate };

      // if (this.EnableCacheUpdate) {
      //   //是否启动缓存定时更新，降低刷新频率
      //   if (!this.CahceUpdate) {
      //     this.CahceUpdate = { Data: [newItem] };
      //   } else {
      //     var item = this.CahceUpdate.Data[this.CahceUpdate.Data.length - 1];
      //     if (item[0] == newItem[0] && item[8] == newItem[8])
      //       this.CahceUpdate.Data[this.CahceUpdate.Data.length - 1] = newItem;
      //     else this.CahceUpdate.Data.push(newItem);
      //   }

      //   var bUpdate = true;
      //   if (this.LastUpdateTime) {
      //     var now = Date.now();
      //     if (now - this.LastUpdateTime < 15 * 1000)
      //       //15s更新一次界面
      //       bUpdate = false;
      //   }

      //   if (!bUpdate) return; //不更新

      //   var hqChartData = {
      //     symbol: symbol,
      //     Name: symbol,
      //     data: this.CahceUpdate.Data,
      //     ver: 2,
      //   };
      //   this.CahceUpdate = null;
      //   this.LastUpdateTime = Date.now();
      // } else {
      var hqChartData = {
        symbol: symbol,
        Name: symbol,
        data: [newItem],
        ver: 2,
      };
      // }

      if (data.Self.IsDestroy == false) {
        // if (lastData.EndDate) this.CountDown.EndDate = lastData.EndDate;

        // #ifdef H5
        data.Self.RecvMinuteRealtimeData(hqChartData);
        // #endif

        // #ifndef H5
        data.Self.RecvMinuteRealtimeData({ data: hqChartData });
        // #endif
      }
    },

    //分时图
    //////////////////////////////////////////////////////////////
    //坐标 刻度设置

    CreateDateTimeRange() {
      var date = new Date();
      var t = date.getTime();
      date.setTime(t - 1000 * 60 * 60 * 2);
      var startTime = date.getHours() * 100;
      var startDate =
        date.getFullYear() * 10000 +
        (date.getMonth() + 1) * 100 +
        date.getDate();

      date.setTime(t + 1000 * 60 * 60 * 2);
      var endTime = date.getHours() * 100;
      var endDate =
        date.getFullYear() * 10000 +
        (date.getMonth() + 1) * 100 +
        date.getDate();
      var TIME_SPLIT = [{ Start: startTime, End: endTime }];
      if (endDate != startDate) {
        //跨天
        TIME_SPLIT = [
          { Start: startTime, End: 2359 },
          { Start: 0, End: endTime },
        ];
      }

      // #ifdef H5
      var indexData =
        HQChart.JSChart.GetMinuteTimeStringData().CreateTimeData(TIME_SPLIT);
      var stringformat = HQChart.IFrameSplitOperator.FormatTimeString;
      // #endif

      // #ifndef H5
      var indexData =
        JSCommonCoordinateData.MinuteTimeStringData.CreateTimeData(TIME_SPLIT);
      var stringformat = JSCommon.IFrameSplitOperator.FormatTimeString;
      // #endif

      this.Minute.DateTimeRange = {
        Start: { Time: startTime, Date: startDate },
        End: { Time: endTime, Date: endDate },
        Count: indexData.length,
      };

      console.log(
        "[MinuteChart::CreateDateTimeRange] Datetime range ",
        this.DateTimeRange
      );

      var xCoordinateData = {
        Count: this.Minute.DateTimeRange.Count,
        MiddleCount: parseInt(this.Minute.DateTimeRange.Count / 2),
        Full: [],
        Simple: [],
        Min: [],
        GetData: function (width) {
          if (width < 200) return this.Min;
          else if (width < 450) return this.Simple;

          return this.Full;
        },
      };

      for (var i = 0; i < indexData.length; ++i) {
        if (i % (60 * 2) == 0) {
          //2小时一个刻度
          var value = indexData[i];
          xCoordinateData.Full.push([
            parseInt(i),
            1,
            "RGB(200,200,200)",
            stringformat(value),
          ]);
        }

        if (i % (60 * 4) == 0) {
          //4小时一个刻度
          var value = indexData[i];
          xCoordinateData.Simple.push([
            parseInt(i),
            1,
            "RGB(200,200,200)",
            stringformat(value),
          ]);
        }

        if (i % (60 * 6) == 0) {
          //6小时一个刻度
          var value = indexData[i];
          xCoordinateData.Min.push([
            parseInt(i),
            1,
            "RGB(200,200,200)",
            stringformat(value),
          ]);
        }
      }

      this.Minute.XCoordinateData = xCoordinateData;
    },

    CreateBITDataIndex() {
      var TIME_SPLIT = [
        {
          Start: this.Minute.DateTimeRange.Start.Time,
          End: this.Minute.DateTimeRange.End.Time,
        },
      ];
      if (
        this.Minute.DateTimeRange.Start.Date !=
        this.Minute.DateTimeRange.End.Date
      ) {
        TIME_SPLIT = [
          { Start: this.Minute.DateTimeRange.Start.Time, End: 2359 },
          { Start: 0, End: this.Minute.DateTimeRange.End.Time },
        ];
      }

      // #ifdef H5
      return HQChart.JSChart.GetMinuteTimeStringData().CreateTimeData(
        TIME_SPLIT
      );
      // #endif

      // #ifndef H5
      return JSCommonCoordinateData.MinuteTimeStringData.CreateTimeData(
        TIME_SPLIT
      );
      // #endif
    },

    RequestMinuteData(data, callback) {
      data.PreventDefault = true;
      var symbol = data.Request.Data.symbol[0];

      //新的股票 清空外部缓存
      this.Minute.Data = null;

      var url = this.GetKLineUrl(
        this.ToBinanceSymbol(symbol),
        PERIOD_NAME.get(4)
      );
      // var log = `[${this.GetDateTime()}][KLineChart::RequestMinuteData] 全量走势图数据请求信息 代码=${symbol} `;
      // console.log(log);

      uni.request({
        url: url, //仅为示例，并非真实接口地址。
        success: (res) => {
          console.log(res.data);
          this.RecvMinuteData(data, callback, res);
        },
      });
    },

    RecvMinuteData(data, callback, res) {
      var symbol = data.Request.Data.symbol[0];
      var stock = { symbol: symbol, name: symbol, minute: [] };

      var yClose = null,
        open = null; //前收盘
      var bFindFirst = false;
      for (var i in res.data) {
        var item = res.data[i];
        var dateTime = new Date(item[0]);
        const losAngelesTime = dateTime.toLocaleString("en-US", {
          timeZone: "America/New_York",
        });
        const losAngelesTimestamp = new Date(losAngelesTime).getTime();
        dateTime.setTime(losAngelesTimestamp);
        var date =
          dateTime.getFullYear() * 10000 +
          (dateTime.getMonth() + 1) * 100 +
          dateTime.getDate();
        var time = dateTime.getHours() * 100 + dateTime.getMinutes();
        var open = parseFloat(item[1]);
        var high = parseFloat(item[2]);
        var low = parseFloat(item[3]);
        var close = parseFloat(item[4]);
        var vol = parseFloat(item[5]);
        var amount = parseFloat(item[7]);

        if (
          date == this.Minute.DateTimeRange.Start.Date &&
          time == this.Minute.DateTimeRange.Start.Time
        ) {
          bFindFirst = true;
          open = open;
        } else {
          yClose = close; //上一天的收盘价
        }

        if (!bFindFirst) continue;

        var minuteItem = {
          date: date,
          time: time,
          open: open,
          high: high,
          low: low,
          price: close,
          vol: vol,
          amount: amount,
        };

        stock.date = date;
        stock.time = time;

        stock.minute.push(minuteItem);
      }

      stock.yclose = yClose;
      stock.open = open;
      this.Minute.Data = stock;

      var hqChartData = { code: 0, stock: [this.Minute.Data] };

      if (data.Self.IsDestroy == false) {
        // #ifdef H5
        callback(hqChartData);
        // #endif

        // #ifndef H5
        callback({ data: hqChartData });
        // #endif

        // this.SubscribeMinuteData(data);
      }
    },

    SubscribeMinuteData(data) {
      //订阅最新数据
      var symbol = data.Request.Data.symbol[0];

      var param = this.GetWSParam(
        this.ToBinanceSymbol(symbol),
        PERIOD_NAME.get(4)
      );
      var postData = { method: "SUBSCRIBE", params: [param] };
      var obj = {
        SendData: postData,
        Symbol: symbol,
        Period: 4,
        Info: "分时图",
      };

      this.RequestWSData(obj, (recvData) => {
        this.RecvSubscribeMinuteData(recvData, data);
      });
    },

    RecvSubscribeMinuteData(recvdata, data) {
      // console.log("[KLineChart::RecvSubscribeMinuteData] recvdata", recvdata);
      var symbol = data.Self.Symbol;
      var param = this.GetWSParam(
        this.ToBinanceSymbol(symbol),
        PERIOD_NAME.get(4)
      );

      if (param != recvdata.stream) return;

      var kData = recvdata.data.k;
      var dateTime = new Date(kData.t);
      const losAngelesTime = dateTime.toLocaleString("en-US", {
        timeZone: "America/New_York",
      });
      const losAngelesTimestamp = new Date(losAngelesTime).getTime();
      dateTime.setTime(losAngelesTimestamp);
      var date =
        dateTime.getFullYear() * 10000 +
        (dateTime.getMonth() + 1) * 100 +
        dateTime.getDate();
      var time = dateTime.getHours() * 100 + dateTime.getMinutes();
      var yClose = null; //前收盘
      var close = parseFloat(kData.c);
      var high = parseFloat(kData.h);
      var low = parseFloat(kData.l);
      var open = parseFloat(kData.o);
      var vol = parseFloat(kData.v);
      var amount = parseFloat(kData.q);

      var lastItem =
        this.Minute.Data.minute[this.Minute.Data.minute.length - 1];
      if (lastItem.time == time && lastItem.date == date) {
        lastItem.open = open;
        lastItem.high = high;
        lastItem.low = low;
        lastItem.price = close;
        lastItem.vol = vol;
        lastItem.amount = amount;
      } else if (
        (lastItem.time < time && lastItem.date == date) ||
        lastItem.date < date
      ) {
        var minuteItem = {
          date: date,
          time: time,
          open: open,
          high: high,
          low: low,
          price: close,
          vol: vol,
          amount: amount,
        };
        this.Minute.Data.minute.push(minuteItem);
      } else {
        return;
      }

      this.Minute.Data.date = date;
      this.Minute.Data.time = time;
      var hqChartData = { code: 0, stock: [this.Minute.Data] };

      if (data.Self.IsDestroy == false) {
        // #ifdef H5
        data.Self.RecvMinuteData(hqChartData);
        // #endif

        // #ifndef H5
        data.Self.RecvMinuteData({ data: hqChartData });
        // #endif
      }
    },

    ///////////////////////////////////////////////////////////////////////////////////
    // ws数据更新
    RequestWSData(request, recvCallback) {
      if (!this.SocketOpen) {
        uni.connectSocket({ url: this.WSUrl }); //创建连接

        uni.onSocketOpen((event) => {
          this.SocketOpen = true;
          console.log(event);
          var message = JSON.stringify({
            method: "SUBSCRIBE",
            params: request.SendData.params,
            id: this.SubID++,
          });
          uni.sendSocketMessage({ data: message });
          if (request.SendData.method == "SUBSCRIBE")
            this.LastSubString = request.SendData;
        });
      } else {
        this.SendUnSubscribeMessage();
        var message = JSON.stringify({
          method: "SUBSCRIBE",
          params: request.SendData.params,
          id: this.SubID++,
        });
        uni.sendSocketMessage({ data: message });
        if (request.SendData.method == "SUBSCRIBE")
          this.LastSubString = request.SendData; //保存最后一个订阅信息
      }

      uni.onSocketMessage((event) => {
        var recvData = JSON.parse(event.data);
        if (recvData.ping) {
          //TODO:心跳包, 没看到服务器发过来
          this.SendWSHeartMessage(); //回复服务器心跳包
        } else if (recvData.stream) {
          recvCallback(recvData);
        } else {
          console.log("[uni.onSocketMessage] event", event);
        }
      });

      uni.onSocketError((evnet) => {
        console.log(event);
      });
    },

    SendUnSubscribeMessage() {
      if (!this.LastSubString || !this.SocketOpen) return;

      var message = JSON.stringify({
        method: "UNSUBSCRIBE",
        params: this.LastSubString.params,
        id: this.SubID++,
      }); //取消上次订阅的信息
      uni.sendSocketMessage({ data: message });
      this.LastSubString = null; //清空最后一个订阅信息
    },

    ////////////////////////////////////////////////////////////////////////////////
    //
    RequestDepthData(data, callback) {
      var symbol = data.Request.Data.symbol.toUpperCase();
      var internalSymbol = symbol.replace(".BIT", "");

      var url = `https://www.binance.com/api/v3/depth?symbol=${internalSymbol}&limit=100`;
      uni.request({
        url: url,
        success: (recvData) => {
          //console.log(recvData);
          //this.LastUpdateId=recvData.lastUpdateId;
          var hqChartData = {
            code: 0,
            asks: recvData.data.asks, //卖盘
            bids: recvData.data.bids, //买盘
            datatype: "snapshot", //全量数据
          };
          if (data.Self.IsDestroy == false) {
            callback(hqChartData);
          }
        },
        error: (request) => {
          //self.RecvError(request,RECV_DATA_TYPE.DERIVATIVE_DATA);
        },
      });
    },

    ///////////////////////////////////////////////
    //手势事件 app/小程序才有
    //KLine事件
    KLineTouchStart: function (event) {
      if (g_KLine.JSChart) g_KLine.JSChart.OnTouchStart(event);
    },

    KLineTouchMove: function (event) {
      if (g_KLine.JSChart) g_KLine.JSChart.OnTouchMove(event);
    },

    KLineTouchEnd: function (event) {
      if (g_KLine.JSChart) g_KLine.JSChart.OnTouchEnd(event);
    },

    ////////////////////////////////////////////////////////////////////////////
    //自定义指标
    LoadCustomIndex() {
      var index = [
        {
          ID: "BOLL_EX", //指标ID
          Name: "BOLL_EX", //指标名称
          Description: "BOLL_EX", //描述信息
          IsMainIndex: true, //是否是主图指标
          Args: [{ Name: "M", Value: 20 }], //指标参数
          OutName: [{ Name: "UB2", DynamicName: "UB2(%)" }],
          //脚本
          Script:
            "BOLL:MA(CLOSE,M);\n\
						UB:BOLL+2*STD(CLOSE,M);\n\
						LB:BOLL-2*STD(CLOSE,M);\n\
						UB2:(UB-C)/C, NODRAW;\n\
						LB2:(LB-C)/C,NODRAW;",
        },
      ];

      HQChart.JSIndexScript.AddIndex(index); //添加到系统指标中
    },

    clearCallback() {
      if (this.callback) {
        this.$ws.unRegisterCallBack(this.callback);
        this.callback = null;
      }
    },
  },
};
</script>

<style>
#countdown {
  position: absolute;
  background-color: rgb(205, 92, 92);
  color: #fff;
  font-size: 14px;
  pointer-events: none;
}
</style>
