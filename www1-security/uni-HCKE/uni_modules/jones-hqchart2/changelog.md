## 1.1.11295（2022-08-06）
11294 修正一字涨停在美国线缩小时不显示  
11293 小程序K线一字涨停缩小以后不显示  
11292 修正一子板缩太小无法显示  
## 1.1.11291（2022-08-05）
11290 画图工具支持再Y轴手动缩放以后绘图  
11288 DBCLICK_KLINE事件增加鼠标位置  
11286 画图是不在可以绘制区域手型改变  
## 1.1.11259（2022-07-21）
11259 小程序横屏分时图支持刻度文字绘制在内部   
11257 修正键盘del删除画图，没有隐藏画图工具配置菜单  
11255 固定范围成交量分布选中菜单修改  
11253 ChartKLine支持外部替换   
11251 修正画布工具选中，没有全刷   
11250 修正画图工具删除没有清空当前选中状态    
11248 固定范围成交量分布图增加黑色配色  
11246 VolProfileVisibleRangeIndex支持参数  
11244 ChartVolProfileVisibleRange增加销毁函数  
11243 迷你分时图增加Y轴刻度显示配置  
11240 分时图数据扩展数据字段  
11239 修改分时图标题信息，隐藏以后，没有触发回调    
## 1.1.11238（2022-07-16）
11238 小程序修正SetStyle() 报错
## 1.1.11237（2022-07-14）
11236 小程序K线Y轴自定义刻度支持绘制再坐标轴框架内部设置  
11235 Y轴自定义支持绘制再坐标轴内部设置  
11234 增加ESC取消画布工具， 不过键盘焦点必须在画布上才可以。  
## 1.1.11221（2022-07-11）
修改说明
## 1.1.11220（2022-07-08）
11219 修正分时图成交量图隐藏时持仓线没有隐藏  
11217 订单流样式1增加POC背景  
11215 可视范围成交量分布图增加Value Arae Volume参数  
11214 可视范围成交量分布指标，增加VAL,VAH刻度线  
11213 订单流样式1，增加横向柱子  
11212 成交量柱子图-可视范围 增加最大值刻度线文字  
11210 成交量柱子图-可视范围支持配置设置  
## 1.1.11195（2022-06-28）
11194 筹码图按钮使用画布自绘  
11193 ChartDrawPriceLineV2 增加显示标题  
11191 K线修正指标窗口最大最小化时，工具栏按钮没有隐藏  
## 1.1.11187（2022-06-24）
11185 修正K线自定义坐标，显示当前屏最后一个数据不显示  
11184 小程序增加叠加股票Y轴自定义刻度  
11183 修正K线横屏百分比坐标Y轴刻度显示错误  
11182 叠加股票Y轴涨幅刻度支持横屏  
11178 自定义Y轴刻度增加当前屏最后一个数据的收盘价刻度  
11176 叠加股票涨幅刻度可以设置  
11175 叠加股票增加Y轴刻度  
11173 ChartKLine单独处理绘图区裁剪  
## 1.1.11172（2022-06-19）
11156 集合竞价盘前，盘后背景独立设置  
11155 叠加指标支持参数修改  
11153 修正DrawMultiDayBeforeOpen错误  
11151 setoption支持设置多日竞价图  
## 1.1.11135（2022-06-10）
11134 增加支持钉钉小程序  
11133 小程序指标计算引擎网络请求使用统一函数  
11132 小程序网络通讯封装  
11130 分时图标题栏显示最有一条数据，新增加格式  
11126 成交量分布图-可视范围 增加指标标题数据显示  
## 1.1.11125（2022-06-06）
11120 ChartStepLine 支持选中，拖拽  
11122 DrawLinePoint()增加判断当前图形是否显示  
11117 叠加指标支持 ChartStepLine  
11116 K线图增加ON_KEYDOWN_SELECT_RECT_FIRST  
11113 增加ON_KEYDOWN_SELECT_RECT_FIRST  
11112 小程序增加 ChartStepLine  
11109 小程序指标标题代码整理  
11108 ChartMultiLine 支持标题输出  
11102 指标引擎增加SETPLINE  
11100 增加阶梯折线  
## 1.1.11070（2022-05-28）
11070 小程序增加DATETIME变量  
11067 订单流样式2，3切换重新请求数据  
11064 增加固定范围成交量分布图  
11061 小程序修正变量名称拼错了 MaxReqeustDataCount=>MaxRequestDataCount  
11060 修正变量名称写错了 MaxReqeustDataCount=>MaxRequestDataCount  
11058 报价列表拖拽支持自动翻页  
## 1.1.11049（2022-05-24）
11047 小程序报价列表完善本地数据排序  
11046 小程序十字光标Y轴文字支持格式设置  
11044 十字光标显示Y轴信息增加格式设置  
## 1.1.11043（2022-05-23）
11043 umychart.regressiontest.wechat 导出改为ESM  
11042 小程序导出使用ESM  
11038 指标图形拖拽默认关闭  
11036 分时图双击事件返回增加当前的分钟数据  
11034 双击事件返回增加选中图形  
11033 报价列表自定义字段回调增加股票信息数据  
## 1.1.10983（2022-05-14）
10983 小程序统一变量this.AutoUpdateTimer初始化为null  
10982 小程序报价列表修正CancelAutoUpdate()调用错误  
## 1.1.10981（2022-05-14）
10979 小程序报价列表名称列增加自动截断<br>
10976 报价列表股票名称增加自动截断功能<br>
10974 小程序报价列表RequestStockSortData()修正回调数据中当前屏索引计算错误<br>
10972 报价列表RequestStockSortData()增加数据个数<br>
10971 报价列表RequestStockSortData()修正索引结束计算错误<br>
## 1.1.10970（2022-05-13）
10970 小程序报价列表SYMBOL_NAME_ID列增加数据为空的显示样式<br>
10968 报价列表SYMBOL_NAME_ID列调整数据为空时显示方式<br>
10967 小程序报价列表增加默认排序和股票缓存数据更新接口<br>
10965 报价列表增加更新缓存数据接口<br>
10964 小程序报价列表支持默认排序设置<br>
10963 报价列表增加默认排序设置<br>
## 1.1.10958（2022-05-12）
10957  修正报价列表手势点击坐标计算错误<br>
10956  小程序报价列表增加ChartDestory()接口<br>
## 1.1.10955（2022-05-11）
10955 修正小程序JSCanvasElement没有包含JSCommonUniApp<br>
10954 小程序报价列表调整表头字体大小<br>
10952 小程序报价列表增加 GetResource()<br>
10951 报价列表增加 SetStyle(), GetResource()<br>
## 1.1.10940（2022-05-10）
10939 报价列表计算表头宽度是增加排序字符宽度<br>
10936 报价列表手势滚动增加页脚信息<br>
10934 报价列表增加翻页循环<br>
      报价列表增加键盘上下移动选中行翻页<br>
## 1.1.10918（2022-05-06）
10917 修正行情报价手势左右或上下拖拽同时存在<br>
10909 报价列表增加支持手势操作<br>
10905 报价列表增加Y偏移函数<br>
10904 报价列表增加排序方式配置<br>
10903 报价列表自定义数值单元格支持颜色设置<br>
## 1.1.10902（2022-05-04）
10902 小程序分时图增加IsDrawTitleBG属性
10901 分时图增加IsDrawTitleBG属性
## 1.1.10883（2022-04-30）
10866 小程序分时图支持远程指标
10870 增加报价列表
## 1.1.10860（2022-04-27）
10859 小程序K线面积图填充左侧间隙<br>
10858 K线面积图把最左边的空隙补上<br>
## 1.1.10848（2022-04-25）
10847 修正手机页面画图工具绘制时会触发K线左右移动
## 1.1.10845（2022-04-25）
10843 成交明细增加自定义字段<br>
10839 修正画图工具黄金分割线横屏显示错误<br>
10838 分笔明细增量数据回调增加最后一个分笔数据信息<br>

## 1.1.10819（2022-04-18）
10819 小程序 MAX(), MIN() 支持多个变量比较<br>
10818 小程序 JSAlgorithm::Add(), JSAlgorithm::Subtract(), JSAlgorithm:: Multip() 修正判断数字逻辑错误<br>
10816 小程序增加日本股票市场<br>
10815 增加日本股票市场.JP<br>
## 1.1.10813（2022-04-17）
10812 小程序 MinuteTimeStringData::GetSHSZ(), MinuteTimeStringData::GetHK() 增加股票代码参数<br>
10811 MinuteTimeStringData::GetHK(), MinuteTimeStringData::GetTW() 增加股票代码参数<br>
10810 小程序增加台湾股票市场<br>
10809 OnSize()函数增加是否重新计算分割线位置属性<br>
10808 增加台湾股票<br>
## 1.1.10807（2022-04-12）
10805 小程序 ON_BIND_DRAWTEXT改成ON_BIND_DRAWICON
## 1.1.10804（2022-04-07）
10795 切换股票和周期增加图形销毁函数<br>
10796 切换指标增加图形销毁事件<br>
10797 ChartMultiHtmlDom增加销毁标识<br>
10799 小程序增加指标图形销毁事件<br>
10800 小程序增加DRAWICON外部绘图绑定事件<br>
10801 小程序分时图增加ON_PHONE_TOUCH事件支持<br>
10802 小程序修正分时图ON_PHONE_TOUCH事件没有更新x,y坐标。<br>
10803 增加ON_BIND_DRAWTEXT事件<br>
## 1.1.10794（2022-04-04）
10792 小程序setoption设置border独立成一个函数<br>
10791 setoption设置border独立方法<br>
10790 setoption设置AutoLeft和AutoRight使用深拷贝<br>
10787 分时图切换股票或天数的时候增加清空原有指标图形<br>
## 1.1.10785（2022-03-27）
10784 K线图增加键盘Ctrl+(left/right)移动十字光标<br>
10781 修正新版DRAWNUMBER读取配置错误<br>
10780 小程序DRAWTEXT, DRAWNUMBER函数重构，增加支持CKLINE<br>
10778 重构DRAWNUMBER函数，支持BACKGROUND,CKLINE。<br>
10776 DRAWTEXT增加连线功能<br>
## 1.1.10774（2022-03-22）
1.1.10774
## 1.1.10773（2022-03-22）
10773 小程序增加K线倒计时接口<br>
10772 K线倒计时支持框架内坐标<br>
10770 增加K线最新数据倒计时时间接口<br>
10767 增加EMA指标<br>
10766 增加EMA3， EMA4， EMA5，EMA6指标<br>
10765 小程序EMA周期支持数组<br>
10764 EMA周期为0是，返回无效数<br>
## 1.1.10763（2022-03-19）
10762 画图工具生成key独立成一个函数<br>
10761 小程序日K图X轴如果只有1个刻度显示YYYYY-MM格式<br>
10760 日K线图X轴如果只有1个刻度显示YYYY-MM格式<br>
## 1.1.10759（2022-03-17）
10758 小程序增加动态修改语言函数SetLanguage()<br>
10757 SetLanguage() 修正没有修改tooltip<br>
10756 设置多语言接口修改<br>
## 1.1.10755（2022-03-14）
10754 小程序分时图setoption增加IsShowXLine，IsShowYLine属性设置<br>
10753 分时图setoption增加 IsShowXLine， IsShowYLine 设置<br>
10752 增加画图工具加载事件<br>
## 1.1.10751（2022-03-11）
10750 分时图标题成家量成交金额支持多语言<br>
10749 小程序修正K线图标题栏成交量和成交金额不支持多语言<br>
10747 分时图显示最新数据支持集合竞价数据<br>
## 1.1.10746（2022-03-11）
10746 小程序增加指标标题字体设置<br>
10744 画图工具增加是否保存到本地变量<br>
10743 小程序 K线横屏增加拖拽历史数据下载功能<br>
10742 增加设置分时图指标标题字体功能<br>
10741 分时图初始化天数<=0， 绘制空图<br>
## 1.1.10740（2022-03-09）
10740 修正小程序不支持DRAWICON函数，绘制SVG图标。转成文字符号<br>
10738 DRAWICON()函数返回增加图标ID<br>
## 1.1.10737（2022-03-09）
10376 叠加指标支持K线背景色设置<br>
10375 小程序 umychart.index.wechat.js 增加引入 ChartData, SingleData类<br>
## 1.1.10734（2022-03-09）
10732 修正ChartSingleText计算字体高度时覆盖了原来的字体<br>
10731 小程序NetworkFilter增加AnnouncementInfo::RequestData<br>
## 1.1.10730（2022-03-05）
10729 K线横屏支持ON_PHONE_TOUCH事件<br>
10728 小程序K线横屏支持ON_PHONE_TOUCH事件<br>
## 1.1.10727（2022-03-01）
10727 小程序叠加日线数据支持拖拽下载历史数据<br>
10725 h5增加叠加分钟K线历史数据拖拽下载<br>
10724 h5增加叠加日线数据拖拽下载数据<br>
## 1.1.1073（2022-02-28）
10723 修正小程序K线标题字体间隔计算错误
## 1.1.10722（2022-02-28）
10720 小程序增加申明文字<br>
10719 增加申明文字<br>
## 1.1.10718（2022-02-23）
10717 小程序修正BACKGROUND再DRAWTEXT数组字符串中无效<br>
10714 修正涂鸦线段菜单绑定错误<br>
## 1.1.10713（2022-02-23）
10712 小程序增加BACKGROUND函数<br>
10711 增加BACKGROUND()函数，跟函数DRAWTEXT同时使用<br>
## 1.1.10710（2022-02-20）
增加K线训练demo
10710 JSUniAppCanvasHelper.MeasureText() 增加空格宽度<br>
10708 K线训练增加自动调整左右边框间距<br>
## 1.1.10707（2022-02-19）
10706 KLineTrainSimpleChartContainer中RightSpaceCount强制设置为0<br>
10705 小程序增加 “简单K线训练”<br>
10704 小程序去掉"简单图形"，'雷达图'，"饼图"， '地图'。 只做K线，通用图形不做<br>
10703 增加 KLineTrainSimpleChartContainer<br>
10701 小程序X，Y轴分割线支持样式自定义<br>
## 1.1.10697（2022-02-14）
10697 小程序K线支持阴线阳新都为空心柱<br>
10695 右键菜单K线类型增加空心阳线阴线<br>
10693 K图支持完全空心K线柱<br>
## 1.1.10692（2022-02-08）
10691 小程序 WINNER, COST价格支持范围调整为0-5000<br>
10690 WINNER价格支持范围调整到0-5000<br>
10688 分钟K线更新，流通股使用上一条记录的<br>
10686 流通股本初始化为null<br>
## 1.1.10678（2022-02-04）
10677 小程序 ChartData::GetVol(unit)增加参数unit
## 1.1.10676（2022-01-31）
2021年最后一个升级包. 新年快乐<br>

ver 10676
10676 小程序JsonDataToFinance()修正变量拼写错误<br>
10674 FrameSplitMinuteX 修正多日背景区域索引计算错误<br>
## 1.1.10673（2022-01-28）
10673 小程序MA，SUM周期参数支持数组<br>
10671 FrameSplitMinuteX 修正X轴文字背景区域最新一天索引错误<br>
10669 多日分时图增加X轴背景颜色设置<br>

## 1.1.10660（2022-01-23）
10657 ChartOX支持tooltip提示信息<br>
10660 小程序修正ChartStickLine宽度小于<1时无法显示<br>
## 1.1.10646（2022-01-21）
修正HQChartControl插件， 增加风格接口及K线类型切换接口
## 1.1.10645（2022-01-19）
10645 小程序增加ON_DRAW_KLINE_LAST_POINT事件<br>
10643 分时图支持集合竞价区域键盘移动十字光标<br>
## 1.1.10642（2022-01-12）
10642 小程序增加AddScriptIndexWindow(), AddAPIIndexWindow()<br>
10640 增加AddAPIIndexWindow<br>
## 1.1.10639（2022-01-10）
10639 小程序指标脚本支持$
## 1.1.10638（2022-01-08）
10638 小程序修正KLineFrame::ZoomUp(), KLineFrame::ZoomDown() 没有处理数据偏移为负数的情况
## 1.1.10637（2022-01-08）
10637 小程序增加函数
PWINNER（暂时空的，拿不到算法）
BETWEEN，CONST，CEILING，FLOOR，TOPRANGE，LOWRANGE，FINDLOW，FINDLOWBARS，FINDHIGH，FINDHIGHBARS，BARSNEXT，HOD，LOD，AMA，TMA，ROUND，ROUND2，TRMA，VALUEWHEN，HARMEAN，DATETODAY，DAYTODATE
## 1.1.10636（2022-01-06）
10636 小程序 ScriptIndex::GetColor() 修正颜色转换错误
## 1.1.10635（2021-12-31）
10635 小程序修正指标标题信息过长超过K线区域<br>
10633 KLineChartContainer::UpdateOverlayMinuteRealtimeData() 支持v2.0数据结构更新<br>
## 1.1.10630（2021-12-28）
10629 小程序K线，分时图标题栏增加字段间距宽度设置<br>
10628 修正KLineTrainChartContainer::RecvFlowCapitalData() 读取流通股本报错<br>
10627 JSUniAppCanvasHelper.MeasureText() 增加':'单独调整宽度<br>
## 1.1.10626（2021-12-25）
小程序umychart.wechat.3.0.js文件大小减少到500K一下<br>
<br>

10625 小程序KLineChartContainer::UpdateMainData()修正历史数据为空，更新数据大于一屏数据时，没有移动到最新数据<br>
10624 KLineChartContainer::UpdateMainData()修正历史数据为空，更新数据大于一屏数据时，没有移动到最新数据<br>
10623 迁移APIScriptIndex类到umychart.index.wechat.js<br>
10622 迁移ChartStraightLine类到umychart.chartpaint.wechat.js<br>
10621 迁移ChartLineMultiData类到umychart.chartpaint.wechat.js<br>
10620 迁移ChartOverlayMinutePriceLine到umychart.chartpaint.wechat.js<br>
## 1.1.10608（2021-12-22）
10604 秒周期支持拖拽下载数据
10606 小程序 KLineChartContainer::DragDownloadData() 支持秒周期下载
## 1.1.10594（2021-12-09）
10594 修正使用K线UI数据指标计算异常
## 1.1.10592（2021-12-08）
修正h5页面OnKLinePageChange 报错
## 1.1.10550（2021-12-08）
10590 小程序 DRAWBAND支持横屏<br>
10587 增加K线缩放拖拽以后触发指标计算配置<br>
10585 增加画布工具点搜否始终显示选项<br>
10583 画图工具选中点支持方框模式<br>
10582 内置画图工具设置菜单支持rgb颜色<br>

## 1.1.10579（2021-11-30）
10578 小程序增加深证交易所股票期权 .SZO<br>
10577 小程序 DRAWICON支持FONTSIZE参数<br>
10576 DRAWICON 支持 FONTSIZE参数<br>
10574 增加 深证股票期权<br>
## 1.1.10573（2021-11-29）
10572 分时图支持选中画图图形显示X，Y轴坐标信息<br>
10570 修正DrawDrawPictureXCoordinate() 变量未定义报错<br>
10568 画图工具选中增加X，Y轴坐标信息<br>
10566 小程序增加TFILTER<br>
10565 修改TFILTER算法<br>
10552 小程序 JSChart.SetUSATimeType()<br>
## 1.1.10551（2021-11-18）
10550 小程序深度图支持多语言<br>
10549 深度图支持多语言 <br>
## 1.1.10548（2021-11-18）
10547 修正K线切换周期和复权没有清空已有的指标
## 1.1.10544（2021-11-18）
10543 小程序深度图增加数据下载提示信息设置
## 1.1.10541（2021-11-17）
10541 小程序深度图增加X轴个数设置 <br>
## 1.1.10538（2021-11-17）
10537 小程序增加北交所市场<br>
10535 1. 增加北交所后缀 BJ<br>
      2. Y轴刻度文字增加间距配置项<br>
10533 小程序增加Y轴刻度文字和边框的间距配置<br>
## 1.1.10532（2021-11-12）
10530 ChartKLine::DrawKBar_Unchagne()修正影线不居中<br>
10529 小程序ChartKLine::DrawKBar_Unchagne() 修正影线上下不居中<br>
## 1.1.10528（2021-11-11）
10528 小程序修正K线影线不居中的问题<br>
10526 修正空心K线影线不居中<br>
10522 修改K线缩放默认配置比例数组<br>
10520 ChartKLine::DrawOrderFlow() 单独处理K线柱子<4的情况<br>
10513 增加新建自定义指标窗口接口 AddScriptIndexWindow<br>
10511 修正KLineChartContainer::CreateSubFrameItem()没有设置周期和股票代码<br>
10509 ON_PHONE_TOUCH 支持分时图<br>
## 1.1.10493（2021-11-02）
10490 JSSymbolData 支持后台周期<br>
10482 K线数据请求回调增加周期和复权变量<br>
10477 KLINE_BG 背景图支持穿区间方位<br>
10475 注册了区间选择事件，默认就禁止内置的区间选择框弹出<br>
10472 分时图增加AutoUpdateEvent() 事件函数<br>
## 1.1.10468.1（2021-10-27）
HQChartControl.Vue插件增加复权函数
## 1.1.10468（2021-10-22）
10467 增加空函数DepthChartCorssCursor::PtInButton()
## 1.1.10465（2021-10-22）
10465 小程序优化请求最新版本号逻辑<br>
10463 请求版本号逻辑优化<br>
## 1.1.10395（2021-10-11）
10394 小程序修正K线最新价格刻度线切换周期后无效<br>
10393 KLineChartContainer::RecvRealtimeData()代码整理<br>
10392 小程序增加复权因子<br>
## 1.1.10391（2021-10-09）
10390 小程序增加繁体文字<br>
10289 修正ChartData::GetRightData()使用复权系数报错<br>
10388 文字本地化增加繁體TC<br>
10385 KLineChartContainer::ClearCustomKLine() 增加是否重绘标识<br>
## 1.1.10384（2021-10-01）
10383 增加清空自定义K线颜色接口<br>
10382 小程序增加清空自定义K线接口KLineChartContainer::ClearCustomKLine()<br>
10381 小程序增加自定义单个K线颜色接口<br>
10379 小程序 HHV，LLV增加小于周期的数值计算<br>
10378 HHV,LLV增加处理不不满足周期数据处理<br>
## 1.1.10370（2021-09-23）
10369 修正ChartBorder::GetBorder()  ChartBorder::GetHScreenBorder() 图形宽度高度变量错误<br>
      小程序指标标题支持JSCHART_EVENT_ID.ON_INDEXTITLE_DRAW事件<br>
10368 小程序修正FINDSTR()函数<br>
10367 FINDSTR()函数修正<br>
10366 小程序增加函数FINDSTR<br>
10364 增加函数 FINDSTR<br>
10363 K线图鼠标移动到X轴变左右箭头<br>
## 1.1.10362（2021-09-19）
10361 ON_DRAW_KLINE_LAST_POINT事件代码整理
10360 叠加指标支持动态标题
10357 增加X轴拖拽缩放K线
10355 OnMouseMove() 增加鼠标离开画布不显示十字光标
## 1.1.10354（2021-09-16）
10353 十字光标按钮支持iconfont<br>
10348 增加十字光标点击按钮事件<br>
10347 分时图最新价格刻度支持时间输出<br>
10344 小程序修正STD, STDP算法<br>
10343 修正算法STD, STDP<br>
10342 K线图过场动画不调整左右边框间距<br>
## 1.1.10333（2021-09-13）
10332 叠加指标支持VERTLINE，HORLINE<br>
10330 增加叠加指标移动到新窗口，MoveOverlayIndexToNewWindow<br>
10328 K线图支持 IsFixXLastTime<br>
10326 APIScriptIndex派生CopyTo虚函数<br>
10325 增加叠加指标移动<br>
10324 小程序MULTI_LINE 支持设置线段宽度<br>
10322 ChartMultiLine 支持设置线段宽度<br>
## 1.1.10321（2021-09-09）
10320 AddIndexWindow()修正OverlayIndexType参数位置写错了<br>
10318 单行显示指标标题支持横屏<br>
10316 1. 修正IChartFramePainting::ClearCoordinateText()没有判断Message字段是否有效<br>
      2. 修正HQTradeFrame::Draw()在动画场景时不自动调整左右边框间距<br>
10315 叠加指标标题支持单行显示<br>
## 1.1.10309（2021-09-01）
10309 小程序修正分时图ChartStickLine柱子太粗了。
## 1.1.10306（2021-08-31）
10305 修正uniapp分时图指标工具栏$报错<br>
10302 修正OnTouchDBClick()手势坐标没有转换到K线图相对坐标<br>

## 1.1.10301 （2021-08-27）
增加用户协议<br>
10285 修正DrawInsideHorizontal，DrawCustomHorizontal没有处理最小化窗口指标<br>
10284 小程序增加双击副图缩放指标窗口<br>

## 1.1.10283（2021-08-22）
10282 小程序JSChartContainer::FullDraw()数据加载去掉坐标文字<br>
10281 显示数据加载时， 不显示刻度文字<br>
10276 增加手势双击缩放附图指标窗口<br>
10274 画图工具支持附图窗口最小化<br>
10273 部分图形画法支持指标窗口隐藏模式<br>
10271 修正右边自动调整叠加指标宽度是没有动态计算叠加刻度<br>
10270 增加是否启动双击缩放附图窗口配置<br>
10269 增加子窗口双击缩放<br>

## 1.1.10265（2021-08-17）
10264 修正KLineChartContainer::Update()没有更新Y轴坐标分割线数据<br>
10263 DrawCustomItem() 支持多行自定义刻度文字<br>
## 1.1.10251（2021-08-12）
10250 小程序指标翻译器函数翻译代码整理<br>
10249 指标解释器函数解释代码整理<br>
10247 小程序指标翻译器增加部分字符串函数翻译<br>
10245 指标翻译器增加部分字符串函数翻译<br>
10241 ON_TITLE_DRAW事件增加叠加股票信息<br>
## 1.1.10238（2021-08-09）
10237 h5修正左右边框间距自动调整没有考虑筹码图宽度<br>
10235 h5K线图边框间距自适应支持横屏<br>
10234 小程序自动调整左右边框距离支持横屏<br>
10233 小程序K线图支持左右边框间距根据刻度文字自动调整<br>
10230 修正拖拽指标边框触发区间选择<br>
10227 h5K线图增加左右两侧边框间距根据刻度自动调整<br>
## 1.1.110226（2021-08-09）
10225 小程序修正指标翻译是LLVBARS,HHVBARS报错<br>
10223 K线增加复权因子读取.<br>
10222 指标翻译器修正HHVBARS, LLVBARS报错<br>
10221 增加复权使用复权因子算法<br>
## 1.1.110220（2021-08-05）
10219 修正 ChartMinutePriceLine::GetTooltipData()报错<br>
10217 h5信息地雷数据支持修改域名<br>
## 1.1.110216（2021-08-04）
10216 小程序修正百分比坐标Y轴超出刻度范围<br>
10214 修正K线百分比坐标超出当前Y轴范围<br>
10212 修正分笔图十字光标区域背景最右边溢出<br>
10210 分笔图增加区间背景<br>
10209 JsonDataToTickData() 每个分笔数据的前收盘使用当日的前收盘<br>
10208 分笔图支持tooltip提示信息<br>
## 1.1.110189（2021-07-27）
10189 修正小程序MinuteFrame里的成员变量DataWidth, DistanceWidth 没有设置为1<br>
10188 OnDoubleClick() 代码整理<br>
10187 小程序CallFunctionExplain() 增加函数不存在报错<br>
10185 CallFunctionExplain()增加函数不存在报错<br>
10183 十字光标竖线支持连续<br>
10182 K线tooltip和K线信息地雷禁止选中<br>
10181 判断tooltip代码整理， 独立成2个函数 PtInChartPaintTooltip，PtInOverlayChartPaintTooltip<br>
10179 ChartOverlayMinutePriceLine, ChartMinutePriceLine 增加函数GetTooltipData()<br>
10178 OnMinuteSelectRectMouseUp()增加CLICK事件通知<br>
## 1.1.110177（2021-07-23）
10174 K线左右拖拽数据增加自动模式 (StepPixel=0)
## 1.1.110173（2021-07-22）
10172 自定义K线支持横屏<br>
10171 小程序K线图最大最小显示配置支持横屏<br>
10170 K线最大最小值显示设置支持横屏<br>
10169 K线图支持自定义K线颜色<br>
10167 ChartKLine::DrawKBar()代码整理<br>
## 1.1.110166（2021-07-19）
10165 GetVariantData()增加错误提示<br>
10161 修正GetVariantData()外部数据对接格式错误<br>
10159 小程序增加INBLOCK<br>
10157 增加INBLOCK<br>
10156 小程序支持板块函数<br>
10154 增加板块函数<br>

## 1.1.110127（2021-07-14）
10125 K线图增加叠加指标参数修改更新接口<br>
10124 去掉scss相关内容和webpack配置<br>
10122 修正分时图区间选择最后的结束时间点超出当前交易时间报错 <br>


## 1.1.110119 （2021-07-12）
10117 JSExplainer语法检测器迁移到小程序<br>
10115 小程序AddIndexWindow()增加SplitCount,IsShowLeftText,IsShowRightText属性设置<br>
10114 AddIndexWindow() 增加SplitCount属性<br>
10110 增加区间统计框关闭以后, 操作选中区域完毕以后,弹出对应的菜单或框<br>
## 1.1.10095（2021-07-07）
10094 ChangeIndexWindowCount() 增加IsShowLeftText, IsShowRightText设置<br>
10092 AddIndexWindow() 增加IsShowLeftText,IsShowRightText设置<br>
10090 修正多日分时图切换最大最小值没有清空 <br>

## 1.1.10087（2021-07-01）
10087 小程序修正分时图RecvMinuteData()报错
## 1.1.10086（2021-07-01）
10086 小程序国内期货增加新品种<br>
10085 小程序DynamicTitleData增加是否显示标识<br>
10084 小程序修正IFrameSplitOperator.IsString()空字符串判断错误<br>
10083 IFrameSplitOperator.IsString()修正""空字符串判断错误<br>
10081 MULTI_BAR叠加指标增加往标题实例中设置数据<br>
10080 自定义多柱子增加数据设置到标题<br>
## 1.1.10076（2021-06-29）
10074 小程序分时图Y轴增加涨跌停坐标轴<br>
10073 小程序 分时图Y周支持根据最高最低加分割<br>
10072 1. 小程序 IChangeStringFormat 迁移到umychart.framesplit.wechart.js中<br>
      2. 小程序 增加IChangeStringFormat工厂类<br>
10068 K线tooltip和标题信息成交量A股统一改成手单位<br>
## 1.1.10065（2021-06-28）
10064 修正分时图没有判断是否支持区间选择导致报错
## 1.1.10063（2021-06-28）
10061 小程序十字光标X轴日期文字支持3种格式 0=YYYY-MM-DD 1=YYYY/MM/DD  2=YYYY/MM/DD/W 3=DD/MM/YYYY<br>
10060 十字光标X轴日期显示 支持YY/MM/YYYY<br>
10057 修正百分比坐标价格和百分比两个颜色配置颠倒了.<br>
10055 修正分笔K线区间统计框起始时间格式显示不对.<br>
## 1.1.10040（2021-06-25）
10039 K线图支持上下拖拽<br>
10037 分笔K线增加支持叠加指标<br>
10035 分笔K线数据更新增加2.0格式<br>
10034 1. 分笔K线全量数据增加新的数据格式<br>
      2. 分笔标题信息和tooltip显示样式修改<br>
      3. 分笔增加百分比坐标<br>

## 1.1.9984（2021-06-17）
9983 修正SplitLogarithmicXYCoordinate()预留高度为负数是,显示错误<br>
9978 修正KLineChartContainer::ChangeIndexWindowCount() 显示错位<br>
     增加AddIndexWindow() 添加指标窗口<br>
9977 K线图增加事件ON_SPLIT_XCOORDINATE<br>
9958 KLineChartContainer.JsonDataToHistoryData(), KLineChartContainer.JsonDataToMinuteRealtimeData(), KLineChartContainer.JsonDataToMinuteHistoryData() 去掉价格<0的无效价格判断.<br>
9954 ChartVericaltLine, ChartHorizontalLine 支持横屏<br>
9953 绘图函数HORLINE()支持单数值条件<br>
9951 增加绘图函数HORLINE<br>
9950 增加绘图函数VERTLINE<br>
9949 部分替换 for(var i in array ) 改成 for(var i=0;i<array.length;++i)<br>
## 1.1.9948（2021-06-12）
9948 小程序分时图和K线图十字光标移动优化<br>
9947 小程序增加分时图十字光标移动延迟绘图间隔设置<br>
## 1.1.9946（2021-06-12）
9946 小程序优化分时图十字光标移动效率<br>
9945 小程序修正ChangePeriod()未完成数据下载切换周期报错<br>
9942 小程序ChartMinutePriceLine迁移到umychart.chartpaint.wechart.js中<br>
## 1.1.9938（2021-06-10）
9937 小程序K线训练增加是否显示最高最低价格显示控制<br>
9936, 9935 把部分数组循环遍历 (var i in array) 改成=> (var i=0;i<array.length;++i)<br>
## 1.1.9933（2021-06-09）
9931 小程序更新定时器增加判断是否图形已销毁<br>
9925 期货增加 郑州商品交易所-红枣(CJ)<br>
9921 JsonDataToMinuteDataArray 修正跨天数据 日期时间显示错误<br>
9919 修正分时图标题高度没有设置为0<br>
9917 大盘指数(INDEXA, INDEXC....)支持对3放数据对接<br>
## 1.1.9907（2021-06-06）
9907 修正IFrameSplitOperator::IntegerCoordinateSplit() 负数最小值计算错误<br>
9902 增加指标标题绘制回调函数 ON_INDEXTITLE_DRAW<br>
## 1.1.9901（2021-06-06）
9900 小程序修正IFrameSplitOperator::IntegerCoordinateSplit()最低价计算错误 <br>
9899 IFrameSplitOperator::IntegerCoordinateSplit() 修正最低价计算错误 <br>
## 1.1.9893（2021-06-04）
9892 小程序IFrameSplitOperator::IntegerCoordinateSplit()算法优化<br>
9890 IFrameSplitOperator::IntegerCoordinateSplit() 修正计算错误<br>
9886 增加多日集合竞价最新数据更新<br>
9885 修正FrameSplitY::GetCallAcutionSplitY() 多日分时Y轴多算了一个刻度<br>
     多日分时图集合竞价Y轴统一最大,最小值<br>
## 1.1.9864（2021-05-30）
9863 分时图集合竞价十字光标显示最近的有效数据<br>
9862 多日集合竞价十字光标支持Y轴数据显示<br>
9861 多日分时图Y轴显示集合竞价刻度<br>
## 1.1.9792（2021-05-21）
9792 小程序  <br>
1. 修正DRAWRECTREL()位置正确性没有判断<br>
2. Y轴内部刻度增加属性YTextBaseline,支持上下位置可以配置<br>
9790 FrameSplitMinutePriceY::GetMaxMin() 修正计算错误. Y轴内部刻度文字支持上下位子配置<br>
9788 导出 CoordinateInfo <br>

## 1.1.9759（2021-05-19）
9758 DynamicMinuteTitlePainting调整集合竞价1.0数据格式显示样式<br>
9756 小程序 ChartVolStick柱子高度<1,统一显示为1 <br>
9754 ChartVolStick() 高度小于1, 统一调整为1 <br>
9748 ShowSelectRect() 分时图显示位置调整<br>
9747 分时图增加区间选择接口<br>
9746 RequestDragMinuteData, RequestDragDayData 数据回调增加周期和复权参数<br>
9743 集合竞价支持绘制点 <br>


## 1.1.9725（2021-05-15）
9724 修正ChartMultiHtmlDom() 在页面放大倍数以后, DOM坐标计算错误 <br>
9719 小程序 JSComplier.Execute() 去掉ios回报错的日志 <br>
## 1.1.9694（2021-05-10）
9694 小程序 1. JSCHART_EVENT_ID定义迁移到umychart.data.wechart.js里面 <br>
      2. 支持 JSCHART_EVENT_ID.ON_SPLIT_YCOORDINATE 事件 <br>
9687 小程序ChartBorder增加 GetBorder(),GetHScreenBorder() <br>
## 1.1.9683（2021-05-09）
修改readme
## 1.1.9682（2021-05-09）
修改readme
## 1.1.9681（2021-05-09）
9671 增加分时图集合竞价关闭按钮<br>
9670 分时图集合竞价支持横屏<br>
9668 增加收盘集合竞价<br>
## 1.1.9654（2021-05-04）
9653 1.分时图双击事件 <br>
     2.集合竞价宽度设置 <br>
9651 修正ChartMinutePriceLine::DrawBeforeOpen()报错 <br>
9649 MULTI_LINE多线段支持"C","H"等特殊标识价格 <br>
9648 1.修正分时图叠加指标共享Y轴横屏没有读取主图Y轴信息 <br>
     2.ChartMultiSVGIcon 使用GetBorder获取坐标信息 <br>
9647 分时图集合竞价框架重新调整 <br>
## 1.1.9617（2021-04-28）
9616 修正IsSHSZStockA() 没有包含300创业板<br>
9610 UpdateFrameMaxMin()  主图计算Y轴最大最小值增加叠加指标数据 <br>
9604 分时图和K线主图支持ON_SPLIT_YCOORDINATE事件 <br>
9599 Y轴分割函数，增加是否支持Y轴缩放查询接口 <br>
9597 增加 Y轴分割刻度回调事件 <br>


## 1.1.9536（2021-04-23）
增加插件教程说明
## 1.1.9535（2021-04-22）
增加HQChart模板样例
## 1.1.9534（2021-04-22）
9532 公告信息地雷支持去重更新 <br>
9529 信息地理拖拽下载数据以后,支持更新调用 <br>
9520 增加AB波浪尺 <br>
## 1.1.9518（2021-04-21）
9517 修正多日分时图更新当天数据时,叠加指标没有重新计算 <br>
9516 小程序增加ON_PHONE_TOUCH事件回调 <br>
9509 修正OverlayScriptIndex::CreateTextLine()画法保存错误 <br>
9501 1. 信息地雷顶部画不下了, 移动下面画<br>
     2. 修正单击K线和双击K线同时触发回调的问题<br>

## 1.1.9500（2021-04-19）
9481 增加画图工具图标<br>
9479 小程序修正BARSSINCEN算法错误<br>
9478 修正BARSSINCEN算法<br>
9477 修正 JSCHART_OPERATOR_ID.OP_LEFT_ZOOM_OUT 数据索引计算错误<br>
9497 走势图支持后台指标API数据<br>
9496 修正"BindOverlayPositionData", "ClearBindOverlayPositionData" 指标变量写错了.<br>
9495 分时图支持叠加指标<br>
9499 h5增加手势事件回调ON_PHONE_TOUCH. <br>

## 1.1.9473（2021-04-12）
9472 修正K线数据更新以后叠加指标没有执行更新<br>
9471 小程序"CIRCLEDOT","POINTDOT"点半径支持设置<br>
9469 CIRCLEDOT, POINTDOT支持半径大小设置<br>
9466 小程序ChartOperator右移K线支持下载功能<br>
9465 小程序COLORSTICK支持标题字体颜色设置<br>
9469 COLORSTICK 支持后面增加颜色控制标题的字体颜色<br>
9462 增加点击回调事件<br>
9458 ChartOperator() 数据右移增加，历史数据下载功能<br>
## 1.1.9444（2021-04-08）
9443 增加K线叠加指标是否显示指标名字配置
9441 ChangeIndexTemplate() 支持指标标题字体设置
9338 ChartSingleText 获取X轴坐标分时图和K线图分开

## 1.1.9417（2021-04-01）
9416 增加水平线段
## 1.1.9416（2021-03-31）
增加测试用例项目
## 1.1.9415（2021-03-31）
把原来hqchart改成uniapp插件模式. 版本号 1.9415
