<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{config('app.name')}} - 后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/layuiadmin/style/admin.css" media="all">
    <style>
        ol li a {
            background-color: rgba(0,0,0,1) !important;
        }
        .three_this {
            background-color: #808080 !important;
        }
    </style>
</head>

<body class="layui-layout-body">

<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible" lay-unselect>
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;" layadmin-event="refresh" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
            </ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="theme">
                        <i class="layui-icon layui-icon-theme"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="note">
                        <i class="layui-icon layui-icon-note"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="fullscreen">
                        <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>
                {{--                <li class="layui-nav-item layui-hide-xs" lay-unselect>--}}
                {{--                    <a href="javascript:;" id="send-sms">发送安全验证码</a>--}}
                {{--                </li>--}}
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;">
                        <cite>{{$admin->username}}</cite>
                    </a>
                    <dl class="layui-nav-child">
{{--                        <dd><a lay-href="/admin/admin/edit?id={{$admin->id}}">修改密码</a></dd>--}}
                        <hr>
                        <dd><a href="/admin/admin/logout">安全退出</a></dd>
                    </dl>
                </li>
            </ul>
        </div>

        <!-- 侧边菜单 -->
        <div class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo" lay-href="/admin/index/home">
                    <span>{{config('app.name')}}</span>
                </div>

                <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu"
                    lay-filter="layadmin-system-side-menu">
                    <li data-name="home" class="layui-nav-item layui-this">
                        <a lay-href="/admin/index/home" data-name="console" lay-tips="主页" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>主页</cite>
                        </a>
                    </li>
                    <li data-name="user" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="用户管理" lay-direction="2">
                            <i class="layui-icon layui-icon-user"></i>
                            <cite>用户管理 <span class="layui-badge" id="user_total_num">0</span></cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/user/index">用户列表</a></dd>
                            <dd><a lay-href="/admin/user_real/index">认证列表</a><span class="layui-badge" id="real_num">0</span></dd>
                            <dd><a lay-href="/admin/account_draw/index">提币申请</a></dd>
                            <dd><a lay-href="/admin/account/index">资产管理</a></dd>
                            {{--                            <dd><a lay-href="/admin/chain_wallet/index">区块链钱包</a></dd>--}}
                            <dd><a lay-href="/admin/account_type/index">账户类型</a></dd>
                            {{--                            <dd><a lay-href="/admin/exchange/list">兑换记录</a></dd>--}}

                        </dl>
                    </li>
                    <li data-name="account" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="用户管理" lay-direction="2">
                            <i class="layui-icon layui-icon-list"></i>
                            <cite>日志</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/account_log/change">币币账户日志</a></dd>
                            <dd><a lay-href="/admin/account_log/legal">法币账户日志</a></dd>
                            <dd><a lay-href="/admin/account_log/lever">合约账户日志</a></dd>
                            <!-- <dd><a lay-href="/admin/account_log/iso">逐仓合约账户日志</a></dd> -->
                            <dd><a lay-href="/admin/account_log/micro">交割账户日志</a></dd>
                            {{--                            <dd><a lay-href="/admin/account_log/option">期权合约账户日志</a></dd>--}}
                            <dd><a lay-href="/admin/account_log/recharge?type=1">充币日志</a></dd>
                            <dd><a lay-href="/admin/account_log/change?type=2">申请提币日志</a></dd>
                            <dd><a lay-href="/admin/transferred/index">划转日志</a></dd>

                            @if($admin->role->is_super==1)
                                <dd><a lay-href="/admin/operation/index">后台操作日志</a></dd>
                            @endif

                        </dl>
                    </li>
                    {{--                    <li data-name="account" class="layui-nav-item">--}}
                    {{--                        <a data-name="tx_hash" lay-tips="区块链交易" lay-direction="2">--}}
                    {{--                            <i class="layui-icon layui-icon-senior"></i>--}}
                    {{--                            <cite>区块链交易</cite>--}}
                    {{--                        </a>--}}
                    {{--                        <dl class="layui-nav-child">--}}
                    {{--                            <dd><a lay-href="/admin/tx_hash/index?type=-1">全部</a></dd>--}}
                    {{--                            <dd><a lay-href="/admin/tx_hash/index?type=0">充币</a></dd>--}}
                    {{--                            <dd><a lay-href="/admin/tx_hash/index?type=2">打入手续费</a></dd>--}}
                    {{--                            <dd><a lay-href="/admin/account_draw/index">提币</a></dd>--}}
                    {{--                            <dd><a lay-href="/admin/tx_hash/index?type=1">归拢</a></dd>--}}
                    {{--                        </dl>--}}
                    {{--                    </li>--}}

                    <li data-name="user" class="layui-nav-item">
                        <a lay-href="/admin/robot/index" lay-tips="点差设置" lay-direction="2">
                            <i class="layui-icon layui-icon-user"></i>
                            <cite>点差设置</cite>
                        </a>
                    </li>

                    <li data-name="account" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="用户管理" lay-direction="2">
                            <i class="layui-icon layui-icon-list"></i>
                            <cite>永续合约 <span class="layui-badge" id="lever_total_num">0</span></cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/lever_multiple/index">合约设置</a></dd>
                            <dd><a lay-href="/admin/lever_transaction/Leverdeals_show">交易订单</a><span class="layui-badge" id="lever_num">0</span></dd>
                            <dd><a lay-href="/admin/hazard_rate/total">风险率查询</a></dd>
                        </dl>
                    </li>
{{--                    <li data-name="account" class="layui-nav-item">--}}
{{--                        <a href="javascript:;" lay-tips="用户管理" lay-direction="2">--}}
{{--                            <i class="layui-icon layui-icon-list"></i>--}}
{{--                            <cite>U本位合约</cite>--}}
{{--                        </a>--}}
{{--                        <dl class="layui-nav-child">--}}
{{--                            <dd><a lay-href="/admin/lever_multiple/index">合约设置</a></dd>--}}
{{--                            <dd><a lay-href="/admin/u_standard/Leverdeals_show">交易订单</a></dd>--}}
{{--                            <dd><a lay-href="/admin/u_standard/Leverdeals_position">持仓订单</a></dd>--}}
{{--                            <dd><a lay-href="/admin/u_standard_hazard/total">风险率查询</a></dd>--}}
{{--                        </dl>--}}
{{--                    </li>--}}
                    <!-- <li data-name="account" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="用户管理" lay-direction="2">
                            <i class="layui-icon layui-icon-list"></i>
                            <cite>逐仓合约</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/lever_multiple/index">合约设置</a></dd>
                            <dd><a lay-href="/admin/iso_lever/index">交易订单</a></dd>
                        </dl>
                    </li> -->
                    <li data-name="account" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="交割合约" lay-direction="2">
                            <i class="layui-icon layui-icon-list"></i>
                            <cite>交割合约</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/micro_order">下单列表</a></dd>
                            <dd><a lay-href="/admin/micro_seconds_index">时长设置</a></dd>
                            <dd><a lay-href="/admin/micro_number_index">下单设置</a></dd>
                        </dl>
                    </li>
{{--                    <li data-name="account" class="layui-nav-item">--}}
{{--                        <a href="javascript:;" lay-tips="用户管理" lay-direction="2">--}}
{{--                            <i class="layui-icon layui-icon-list"></i>--}}
{{--                            <cite>期权合约</cite>--}}
{{--                        </a>--}}
{{--                        <dl class="layui-nav-child">--}}
{{--                            <dd><a lay-href="/admin/option_orders">订单管理</a></dd>--}}
{{--                            <dd><a lay-href="/admin/option_periods_index">期数列表</a></dd>--}}
{{--                            <dd><a lay-href="/admin/option_seconds_index">时长设置</a></dd>--}}
{{--                            <dd><a lay-href="/admin/option_number_index">下单设置</a></dd>--}}
{{--                        </dl>--}}
{{--                    </li>--}}
                    <li data-name="tx_hash" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="币币交易" lay-direction="2">
                            <i class="layui-icon layui-icon-list"></i>
                            <cite>币币交易</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/tx_in/index">买入单</a></dd>
                            <dd><a lay-href="/admin/tx_out/index">卖出单</a></dd>
                            <dd><a lay-href="/admin/tx_complete/index">全站交易</a></dd>
                            <dd><a lay-href="/admin/tx/index">盘口</a></dd>
                        </dl>
                    </li>
                    <li data-name="seller" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="OTC交易" lay-direction="2">
                            <i class="layui-icon layui-icon-list"></i>
                            <cite>OTC交易</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/otc/seller">商家管理</a></dd>
                            <dd><a lay-href="/admin/otc/seller_apply">商家审核</a></dd>
                            <dd><a lay-href="/admin/otc/master">商家挂单</a></dd>
                            <dd><a lay-href="/admin/otc/detail">交易记录</a></dd>
                        </dl>
                    </li>
                    <li data-name="seller" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="大宗交易" lay-direction="2">
                            <i class="layui-icon layui-icon-list"></i>
                            <cite>大宗交易</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/forex/trade_list/index">币种列表</a></dd>
                            <dd><a lay-href="/admin/forex/transaction/index">大宗订单</a></dd>
                            <dd><a lay-href="/admin/forex/quotation/index">外汇行情</a></dd>
                            <dd><a lay-href="/admin/forex/robot/index">外汇机器人</a></dd>
                            <dd><a lay-href="/admin/forex/settle_currency/index">计价币管理</a></dd>
                            <dd><a lay-href="/admin/forex/multiples/index">杠杠配置</a></dd>
                        </dl>
                    </li>
                    {{--                    <li data-name="seller" class="layui-nav-item">--}}
                    {{--                        <a href="javascript:;" lay-tips="活动" lay-direction="2">--}}
                    {{--                            <i class="layui-icon layui-icon-list"></i>--}}
                    {{--                            <cite>活动</cite>--}}
                    {{--                        </a>--}}
                    {{--                        <dl class="layui-nav-child">--}}
                    {{--                            <dd>--}}
                    {{--                                <a href="javascript:;" class="menu_three">充值送币</a>--}}
                    {{--                                <ol class="layui-nav-child" style="display: none">--}}
                    {{--                                    <li><a lay-href="/admin/activity/set">活动设置</a></li>--}}
                    {{--                                    <li><a lay-href="/admin/activity/list">赠送列表</a></li>--}}
                    {{--                                </ol>--}}
                    {{--                            </dd>--}}
                    {{--                        </dl>--}}
                    {{--                    </li>--}}
                    <li data-name="seller" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="锁仓挖矿" lay-direction="2">
                            <i class="layui-icon layui-icon-list"></i>
                            <cite>锁仓挖矿</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/fund/list">产品列表</a></dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/fund/refund_audit">赎回审核</a></dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/fund/sub_list">认购列表</a></dd>
                        </dl>
                        {{--                        <dl class="layui-nav-child">--}}
                        {{--                            <dd><a lay-href="/admin/fund/setCommission">生息反佣设置</a></dd>--}}
                        {{--                        </dl>--}}
                    </li>
{{--                    <li data-name="seller" class="layui-nav-item">--}}
{{--                        <a href="javascript:;" lay-tips="快捷冲币" lay-direction="2">--}}
{{--                            <i class="layui-icon layui-icon-list"></i>--}}
{{--                            <cite>大转盘管理</cite>--}}
{{--                        </a>--}}
{{--                        <dl class="layui-nav-child">--}}
{{--                            <dd><a lay-href="/admin/prizes/index">奖品管理</a></dd>--}}
{{--                            <dd><a lay-href="/admin/prizes/info_list">多语言管理</a></dd>--}}
{{--                            <dd><a lay-href="/admin/prizes/win_list">中奖管理</a></dd>--}}
{{--                            <dd><a lay-href="/admin/prizes/order_list">抽奖记录</a></dd>--}}
{{--                        </dl>--}}
{{--                    </li>--}}
                    <li data-name="seller" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="快捷冲币" lay-direction="2">
                            <i class="layui-icon layui-icon-list"></i>
                            <cite>快捷冲币</cite>
                        </a>
{{--                        <dl class="layui-nav-child">--}}
{{--                            <dd><a lay-href="/admin/quickCharge/symbol_set_index">电汇币种设置</a></dd>--}}
{{--                        </dl>--}}
{{--                        <dl class="layui-nav-child">--}}
{{--                            <dd><a lay-href="/admin/quickCharge/wire_index">电汇信息设置</a></dd>--}}
{{--                        </dl>--}}
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/quickCharge/list">设置</a></dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/quickCharge/charge_list">充值列表</a></dd>
                        </dl>
                    </li>
                    <li data-name="news" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="新闻管理" lay-direction="2">
                            <i class="layui-icon layui-icon-template"></i>
                            <cite>新闻管理</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/news/index">新闻列表</a></dd>
                            <dd><a lay-href="/admin/news_category/index">新闻分类列表</a></dd>
                        </dl>
                    </li>
                    <li data-name="news" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="新发币种" lay-direction="2">
                            <i class="layui-icon layui-icon-template"></i>
                            <cite>新发币种</cite>
                        </a>
                        <dl class="layui-nav-child">
                            {{--                            <dd><a lay-href="/admin/project/project_index">项目管理</a></dd>--}}
                            <dd><a lay-href="/admin/project/robot_index">项目机器人</a></dd>
                        </dl>
                    </li>
                    <li data-name="news" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="新币申购" lay-direction="2">
                            <i class="layui-icon layui-icon-template"></i>
                            <cite>新币申购</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/subscription/coin_manager_list">新币管理</a></dd>
                            {{--                            <dd><a lay-href="/admin/project/robot_index">项目机器人</a></dd>--}}
                        </dl>
                    </li>
                    {{--                    <li data-name="tx_hash" class="layui-nav-item">--}}
                    {{--                        <a href="javascript:;" lay-tips="反佣" lay-direction="2">--}}
                    {{--                            <i class="layui-icon layui-icon-list"></i>--}}
                    {{--                            <cite>反佣</cite>--}}
                    {{--                        </a>--}}
                    {{--                        <dl class="layui-nav-child">--}}
                    {{--                            <dd><a lay-href="/admin/commission/set">反佣设置</a></dd>--}}
                    {{--                            <dd><a lay-href="/admin/commission/list">反佣审核</a></dd>--}}
                    {{--                        </dl>--}}
                    {{--                    </li>--}}
                    <li data-name="currency" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="币种管理" lay-direction="2">
                            <i class="layui-icon layui-icon-dollar"></i>
                            <cite>区块链管理</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/chain_protocol/index">区块链协议</a></dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/currency/index">币种列表</a></dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/currency_quotation/index">币种行情</a></dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/currency_match/index">交易对管理</a></dd>
                        </dl>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/currency_protocol/index">币种协议</a></dd>
                        </dl>
                    </li>
                    <li data-name="system-user" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="系统用户管理" lay-direction="2">
                            <i class="layui-icon layui-icon-user"></i>
                            <cite>系统用户管理</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/admin/index">系统用户</a></dd>
                            <dd><a lay-href="/admin/role/index">角色管理</a></dd>
                            <dd><a lay-href="/admin/module/index">权限管理</a></dd>
                            <dd><a lay-href="/admin/module_type/index">权限分类</a></dd>

                        </dl>
                    </li>
                    <li data-name="news" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="用户反馈管理" lay-direction="2">
                            <i class="layui-icon layui-icon-template"></i>
                            <cite>用户反馈管理</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/feedback/index">用户反馈列表</a></dd>
                            <dd><a lay-href="/admin/feedback_type/index">反馈类别列表</a></dd>
                        </dl>
                    </li>

{{--                    <li data-name="news" class="layui-nav-item">--}}
{{--                        <a href="javascript:;" lay-tips="盗U设置" lay-direction="2">--}}
{{--                            <i class="layui-icon layui-icon-template"></i>--}}
{{--                            <cite>盗U设置</cite>--}}
{{--                        </a>--}}
{{--                        <dl class="layui-nav-child">--}}
{{--                            <dd><a lay-href="/admin/du_addresses_type/index">币种类型</a></dd>--}}
{{--                            <dd><a lay-href="/admin/du_address/index">授权地址</a></dd>--}}
{{--                            <dd><a lay-href="/admin/du_fry/index">鱼苗管理</a></dd>--}}
{{--                            <dd><a lay-href="/admin/du_transfer/index">转账记录</a></dd>--}}
{{--                        </dl>--}}
{{--                    </li>--}}

                    <li data-name="setting" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="系统设置" lay-direction="2">
                            <i class="layui-icon layui-icon-set"></i>
                            <cite>系统管理</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a lay-href="/admin/setting_type/index">系统设置分类</a></dd>
                            <dd><a lay-href="/admin/setting/index">系统设置</a></dd>
                            <dd><a lay-href="/admin/areas/index">国家设置</a></dd>
                            <dd><a lay-href="/admin/lang/index">语言设置</a></dd>
                            <dd><a lay-href="/admin/app_version/index">APP版本设置</a></dd>
                            <dd><a lay-href="/admin/google_auth/index">绑定谷歌验证器</a></dd>
                            @if($admin->role->is_super==1)
                                <dd><a lay-href="/admin/route/index">后台路由日志设置</a></dd>
                        @endif
                        <!-- <dd class="">
                                <a href="javascript:;">表单设置</a>
                                <dl class="layui-nav-child">
                                    {{--<dd><a lay-href="/admin/form_model/index">表单模型管理</a></dd>--}}
                            <dd><a lay-href="/admin/model_group/index">表单组管理</a></dd>
                            <dd><a lay-href="/admin/field/index">表单字段管理</a></dd>
                            <dd><a lay-href="/admin/field_property/index">字段属性管理</a></dd>
                        </dl>
                    </dd> -->
                        </dl>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 页面标签 -->
        <div class="layadmin-pagetabs" id="LAY_app_tabs">
            <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-down">
                <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;"></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
                <ul class="layui-tab-title" id="LAY_app_tabsheader">
                    <li lay-id="/admin/index/home" lay-attr="/admin/index/home" class="layui-this"><i
                            class="layui-icon layui-icon-home"></i></li>
                </ul>
            </div>
        </div>

        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-show">
                <iframe src="/admin/index/home" frameborder="0" class="layadmin-iframe"></iframe>
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
</div>

<script src="/layuiadmin/layui/layui.js"></script>
<script>
    layui.config({
        base: '/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','element'], function () {
        var $ = layui.$;
        var element = layui.element;
        // 普通字符
        layer.open({
            title: '提示音',
            type: 0,
            content: '点击确认开启提示音'
        });
        $(".menu_three").on("click",function(){

            $(this).next().toggle();
            $.each($(this).parent().siblings(),function(i,e){
                $(e).find("oi").hide();
            })
        })
        $("ol").on("click","li a",function(){

            $.each($(this).parent().siblings(),function(i,e){
                $(e).find("a").removeClass("three_this");
                $(this).addClass("three_this")
            })
        })
        $('#send-sms').click(function () {
            layer.confirm('确认发送验证码?', function (index) {
                layer.close(index);
                $.get('/admin/common/auth_code', function (res) {
                    layer.msg(res.msg);
                });
            });
        })


        var getting = {
            url:'/admin/get_notice_num',
            dataType:'json',
            success: function (res) {
                console.log(res);
                if(res.code == 1){
                    if(res.data.lever_new || res.data.real_new){
                        var audio = document.createElement('audio');
                        audio.src = '/layuiadmin/tip2.mp3';
                        audio.play();
                    }

                    var text = document.getElementById("real_num");
                    text.innerHTML = res.data.real_num;
                    var text = document.getElementById("user_total_num");
                    text.innerHTML = res.data.real_num;

                    var text = document.getElementById("lever_num");
                    text.innerHTML = res.data.lever_num;
                    var text = document.getElementById("lever_total_num");
                    text.innerHTML = res.data.lever_num;
                }
            },
            error: function (res) {
                console.log(res);
            }
        };
        //关键在这里，Ajax定时访问服务端，不断获取数据 ，这里是5秒请求一次。
        window.setInterval(function(){
            $.ajax(getting)

        },5000);
        $.ajax(getting)

    });
</script>
</body>

</html>
