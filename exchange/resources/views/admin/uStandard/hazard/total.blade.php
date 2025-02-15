<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理系统 - {{config('app.name')}}</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/layuiadmin/style/admin.css" media="all">
</head>

<body class="layui-layout-body">
<style>
    .number {
        text-align: right;
        margin-right: 10px;
    }
    .layui-form-label {
        width: unset;
    }
    .percent:after {
        content: '%';
    }
</style>
<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" name="email" placeholder="请输入" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">手机</label>
                    <div class="layui-input-block">
                        <input type="text" name="mobile" placeholder="请输入" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">uid</label>
                    <div class="layui-input-block">
                        <input type="text" name="uid" placeholder="请输入" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
            <div class="layui-inline">
                    <label class="layui-form-label">币种</label>
                    <div class="layui-input-inline" style="width:100px;">
                        <select name="quote_currency_id" lay-verify="required">
                            <option value="-1">无</option>
                            @foreach ($currencies as $key => $currency)
                                <option value="{{$currency->id}}">{{$currency->code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">方向</label>
                    <div class="layui-input-inline" style="width:100px;">
                        <select name="type" lay-verify="required">
                            <option value="-1">全部</option>
                            <option value="1">买入(做多)</option>
                            <option value="2">卖出(做空)</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">风险率</label>
                    <div class="layui-input-inline" style="width:90px; margin-right: 0px">
                        <select name="operate" lay-verify="required">
                            <option value="-1">范围</option>
                            <option value="1">&gt;=</option>
                            <option value="2">&lt;=</option>
                        </select>
                    </div>
                    <div class="layui-input-inline" style="width:80px; margin-right: 0px">
                        <input type="text" class="layui-input" name="hazard_rate" placeholder="输入数值">
                    </div>
                    <div class="layui-form-mid layui-word-aux">%</div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn" lay-submit lay-filter="submit">查询</button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="data_table" lay-filter="data_table"></table>
        </div>
    </div>
</div>

<script id="operate_bar" type="text/html">
    <button class="layui-btn layui-btn-primary layui-btn-xs" lay-event="detail">查看交易</button>
</script>
<script src="/layuiadmin/layui/layui.js"></script>

<script>
    layui.use(['table', 'layer', 'form'], function() {
        var table = layui.table
            ,layer = layui.layer
            ,form = layui.form
            ,$ = layui.$
        var data_table = table.render({
            elem: '#data_table'
            ,url: '/admin/u_standard_hazard/total_lists'
            ,height: 'full'
            ,toolbar: true
            ,page: true
            ,totalRow: true
            ,cols: [[
                {field: 'user_id', title: 'id', width: 80, totalRowText: '小计:'}
                ,{field: 'mobile', title: '电话', width: 120}
                ,{field: 'email', title: 'email', width: 150}
                ,{field: 'uid', title: 'uid', width: 150}

                ,{field: 'lever_balance', title: '余额', width: 150, sort: true, totalRow: true, templet: '<div><p class=""><span>@{{ Number(d.lever_balance).toFixed(4) }}</span></p></div>'}
                ,{field: 'profits_total', title: '盈亏总额', width: 150, sort: true, totalRow: true, templet: '<div><p class=""><span>@{{ Number(d.profits_total).toFixed(4) }}</span></p></div>'}
                ,{field: 'caution_money_total', title: '保证金总额', width: 150, sort: true, totalRow: true, templet: '<div><p class=""><span>@{{ Number(d.caution_money_total).toFixed(4) }}</span></p></div>'}
                ,{field: 'hazard_rate', title: '风险率', width: 150, sort: true, templet: '<div><p class="number"><span class="percent">@{{ d.hazard_rate }}</span></p></div>'}
                //,{field: '', title: '爆仓价', width: 120}
                ,{fixed: 'right', title: '操作', width: 120, toolbar: '#operate_bar'}
            ]]
        });

        form.on('submit(submit)', function (data) {
            var option = {
                where: data.field
            }
            data_table.reload(option);
        });

        table.on('tool(data_table)', function (obj) {
            var data = obj.data //获得当前行数据
                ,layEvent = obj.event //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
                ,tr = obj.tr //获得当前行 tr 的DOM对象
            if (layEvent == 'detail') {
                parent.layui.index.openTabsPage('/admin/u_standard_hazard/index' + '?user_id=' + data.user_id, '交易记录');
            }
        });
    });
</script>
</body>

</html>
