<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理系统 - {{config('app.name')}}</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/layuiadmin/style/admin.css" media="all">
    <style>
        .order_type_rise {
            /*
            background-color:#89deb3;
            */
            color:#1aab65;
        }
        .order_type_fall {
            /*
            background-color:#d67a7a;
            */
            color:#de1919;
        }
        .order_type {
            /*
            color:#fff;
            */
            font-size: 10px;
            text-align: center;
        }
        .layui-item {
            margin: 10px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-item">
                <div class="layui-inline" style="margin-left: 10px;">
                    <label>交易对</label>
                    <div class="layui-input-inline" style="width: 120px">
                        <select name="match_id" id="currency_match" class="layui-input">
                            <option value="-1">所有</option>
                            @foreach ($currency_matches as $key=> $currency_match)
                                <option value="{{ $currency_match->id }}">{{ $currency_match->symbol }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="layui-inline" style="margin-left: 10px;">
                    <label>状态</label>
                    <div class="layui-input-inline" style="width: 90px">
                        <select name="status" id="status" class="layui-input">
                            <option value="-1">所有</option>
                            <option value="1">交易中</option>
                            <option value="2">结算中</option>
                            <option value="3">已结束</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline" style="margin-left: 10px;">
                    <label>结果</label>
                    <div class="layui-input-inline" style="width: 90px">
                        <select name="profit_result" id="profit_result" class="layui-input">
                            <option value="-1">所有</option>
                            <option value="1">涨</option>
                            <option value="2">跌</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" name="email" placeholder="请输入" class="layui-input">
                    </div>
                </div>
                <div class="layui-btn-group">
                    <button class="layui-btn" id="btn-search" lay-submit lay-filter="btn-search">搜索</button>
                </div>

            </div>

        </div>

        <div class="layui-card-body">
            <table id="order_list" lay-filter="order_list"></table>
        </div>

    </div>
</div>

<script src="/layuiadmin/layui/layui.js"></script>
<script type="text/html" id="barDemo">
    @{{d.status==1 ? '<a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="edit">预设盈亏</a>' : '' }}
</script>


<script type="text/html" id="profit_result_name">
    @{{# if (d.result == 1) { }}
    <span style="color:#89deb3;">涨</span>
    @{{# } else if (d.result == 2) { }}
    <span style="color:#d67a7a;">跌</span>
    @{{# } else { }}
    <span class="layui-badge-rim">无</span>
    @{{# } }}
</script>
<script type="text/html" id="type_name">
    @{{# if (d.type == 1) { }}
    <span style="color:#89deb3;">看涨</span>
    @{{# } else if (d.type == 2) { }}
    <span style="color:#d67a7a;">看跌</span>
    @{{# } }}
</script>
<script type="text/html" id="status_name">
    @{{# if (d.status == 1) { }}
    <span style="color:#89deb3;">交易中</span>
    @{{# } else if (d.status == 2) { }}
    <span style="color:#d67a7a;">结算中</span>
    @{{# } else if (d.status == 3) { }}
    <span style="color:#ba8b00;">已结束</span>
    @{{# } else { }}
    <span class="layui-badge-rim">未开始</span>
    @{{# } }}
</script>


<script type="text/html" id="second_num">
    <span class="layui-badge">@{{d.second.seconds}}</span>
</script>

<script type="text/html" id="period">
    <span>@{{d.currency_match.symbol}}-@{{d.period.period}}期</span>
</script>
<script type="text/html" id="exec_currency">
    <span>@{{d.currency.code}}</span>
</script>
<script type="text/html" id="email">
    <span>@{{d.get_user.email}}</span>
</script>
<script>
    window.onload = function () {
        document.onkeydown = function (event) {
            var e = event || window.event || arguments.callee.caller.arguments[0];
            if (e && e.keyCode == 13) { // enter 键
                $('#btn-search').click();
            }
        };
        layui.config({
            base: '/layuiadmin/' //静态资源所在路径
        }).extend({
            index: 'lib/index' //主入口模块
        }).use(['index', 'useradmin', 'table', 'laydate','element'], function () {
            var element = layui.element;
            var layer = layui.layer;
            var table = layui.table;
            var $ = layui.$;
            var form = layui.form;
            var laydate = layui.laydate;
            laydate.render({
                elem: '#start_time',
                type: 'datetime'
            });
            laydate.render({
                elem: '#end_time',
                type: 'datetime'
            });
            form.on('submit(btn-search)', function (data) {
                var option = {
                    where: data.field,
                    page: {curr: 1}
                }
                data_table.reload(option);
                return false;
            });


            var data_table = table.render({
                elem: '#order_list',
                url: "/admin/option_orders",
                done: function (res, curr, count) {
                    $('tr:has(div.order_type_rise)').css('backgroundColor', '#f4fdf8');
                    $('tr:has(div.order_type_fall)').css('backgroundColor', '#fff8f8');
                },
                page: true,
                method: 'post',
                limit: 20,
                limits: [20, 50, 100, 500, 1000],
                toolbar: true,
                height: 'full-180',
                totalRow: true,
                cols: [[
                    {field: 'email', title: '客户邮箱', templet: '#email'}
                    ,{field: 'period', title: '期数', templet: '#period'}
                    ,{field: 'status_name', title: '状态', width: 90, sort: true, templet: '#status_name'}
                    ,{field: 'type_name', title: '下单方向', width: 100, sort: true, templet: '#type_name'}
                    ,{field: 'profit_result_name', title: '结果', width: 100, sort: true, templet: '#profit_result_name'}
                    ,{field: 'exec_currency', title: '下单币种', width: 100, sort: true, templet: '#exec_currency'}
                    ,{field: 'number', title: '下单数量', width: 90, sort: true}
                    ,{field: 'fee', title: '手续费', width: 90, sort: true}
                    ,{field: 'created_at', title: '下单时间', width: 170, sort: true}
                    ,{field: 'handle_time', title: '结束时间', width: 170, sort: true,}
                    // ,{fixed: 'right', title: '操作', width: 100, align: 'center', toolbar: '#barDemo'}
                ]]
            });

            //监听工具条
            table.on('tool(order_list)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data;
                var layEvent = obj.event;
                var tr = obj.tr;
                if (layEvent === 'edit') { //编辑
                    layer.open({
                        type: 2,
                        title: '编辑交易',
                        area: ['400px', '300px'],
                        content: '/admin/micro_order_edit?id=' + data.id,
                        end: function () {
                            table.reload('list');
                        }
                    });
                }
            });

        });
    }
</script>
</body>
</html>


