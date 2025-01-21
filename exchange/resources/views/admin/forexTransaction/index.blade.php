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
    <style>
        .layui-input-inline {
            width: 150px !important;
        }

        .layui-form-label {
            width: 50px !important;
        }
    </style>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline" style="">
                    <label class="layui-form-label">外汇种类</label>
                    <div class="layui-input-inline">
                        <select name="forex_id" id="forex_id" lay-search>
                            <option value="0">所有</option>
                            @foreach ($forex as $f)
                                <option value="{{$f->id}}">{{$f->code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline" style="">
                    <label class="layui-form-label">计价币</label>
                    <div class="layui-input-inline">
                        <select name="forex_id" id="settle_currency" lay-search>
                            <option value="0">所有</option>
                            @foreach ($settle_currencies as $settle_currency)
                                <option value="{{$settle_currency->id}}">{{$settle_currency->currency_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-inline">
                        <select name="status" id="status">
                            <option value="-1">所有</option>
                            @foreach($status_list as $status => $name)
                                <option value="{{ $status }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">平仓类型</label>
                    <div class="layui-input-inline">
                        <select name="closed_type" id="closed_type">
                            <option value="-1">所有</option>
                            @foreach($closed_type_list as $status => $name)
                                <option value="{{ $status }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">类型</label>
                    <div class="layui-input-inline" style="width:70px;">
                        <select name="order_type" id="type">
                            <option value="0">所有</option>
                            <option value="{{\App\Models\Forex\ForexTransaction::TYPE_BUY}}">买入</option>
                            <option value="{{\App\Models\Forex\ForexTransaction::TYPE_SELL}}">卖出</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">UID</label>
                    <div class="layui-input-inline">
                        <input type="text" name="uid" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">手机</label>
                    <div class="layui-input-inline">
                        <input type="text" name="mobile" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-inline">
                        <input type="text" name="email" placeholder="请输入" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="mobile_search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="leverList" lay-filter="leverList"></table>
        </div>

        <script type="text/html" id="operateBar">
{{--            @{{# if (d.status == 1) { }}--}}
{{--            <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="cancel">撤单</a>--}}
{{--            @{{# } }}--}}
            @{{# if (d.status == 1) { }}
            <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="close">平仓</a>
{{--            <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="market">插针</a>--}}
            @{{# } }}
        </script>
    </div>
</div>
<script src="/layuiadmin/layui/layui.js"></script>
<script>

    layui.use(['element', 'form', 'layer', 'table', 'laydate'], function () {
        var element = layui.element
            , layer = layui.layer
            , table = layui.table
            , $ = layui.$
            , form = layui.form
            , laydate = layui.laydate
        $('input.layui-date').each(function () {
            laydate.render({
                elem: this
                , type: 'datetime'
            });
        });

        var lever_list = table.render({
            elem: '#leverList'
            , url: '/admin/forex/transaction/list'
            , height: 'full-80'
            , page: true
            , limit: 20
            , toolbar: true
            , totalRow: true
            , cols: [[
                {field: 'id', title: 'ID', width: 80}
                , {field: 'code', title: '交易对', width: 100}
                , {field: 'currency_name', title: '计价币', width: 100}
                , {field: 'uid', title: 'uid', width: 120}
                , {field: 'type_name', title: '类型', width: 80}
                , {field: 'status_name', title: '状态', width: 80}
                , {field: 'closed_type_name', title: '平仓类型', width: 100}
                , {field: 'origin_price', title: '原始价', width: 100}
                , {field: 'price', title: '开仓价', width: 100}
                , {field: 'update_price', title: '当前价', width: 100}
                , {field: 'target_profit_price', title: '止盈价', width: 100}
                , {field: 'target_loss_price', title: '止损价', width: 100}
                , {field: 'quantity', title: '下单数量(张)', width: 90}
                , {field: 'forex_cont_num', title: '每张数量', width: 90}
                , {field: 'multiple', title: '倍数', sort: true, width: 90}
                , {field: 'origin_caution_money', title: '初始保证金', width: 100}
                , {field: 'caution_money', title: '可用保证金', width: 100}
                , {field: 'trade_fee', title: '手续费', width: 80, totalRow: true}
                // , {field: 'overnight_money', title: '隔夜费', width: 80, totalRow: true, hide: true}
                , {field: 'fact_profits', title: '盈亏', width: 100, totalRow: true}
                , {field: 'create_time', title: '下单时间', width: 170}
                , {field: 'update_time', title: '刷新时间', sort: true, width: 170}
                , {field: 'transaction_time', title: '成交时间', sort: true, width: 170}
                , {field: 'handle_time', title: '平仓时间', sort: true, width: 170}
                , {field: 'complete_time', title: '完成时间', sort: true, width: 170}
                , {fixed: 'right', title: '操作', minWidth: 100, align: 'center', toolbar: '#operateBar'}
            ]]
        });

        table.on('tool(leverList)', function (obj) { //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
            var data = obj.data
                , layEvent = obj.event
                , tr = obj.tr;
            if (layEvent === 'cancel') { //删除
                layer.confirm('真的要撤单吗？', function (index) {
                    //向服务端发送删除指令
                    $.ajax({
                        url: "/admin/iso_lever/cancel",
                        type: 'post',
                        dataType: 'json',
                        data: {id: data.id},
                        success: function (res) {
                            layer.msg(res.msg);
                            if (res.code) {
                                lever_list.reload();
                            } else {
                                layer.close(index);
                            }
                        }
                    });
                });
            }
            if (layEvent === 'close') { //删除
                layer.confirm('真的要平仓吗？', function (index) {
                    //向服务端发送删除指令
                    $.ajax({
                        url: "/admin/forex/transaction/close",
                        type: 'post',
                        dataType: 'json',
                        data: {id: data.id},
                        success: function (res) {
                            layer.msg(res.msg);
                            if (res.code) {
                                lever_list.reload();
                            } else {
                                layer.close(index);
                            }
                        }
                    });
                });
            }
            //插针
            if (layEvent === 'market') {
                layer.prompt({
                    formType: 0,
                    update_price: '0',
                    title: '交易处理',
                }, function (update_price, index, elem) {
                    $.ajax({
                        url: "/admin/iso_lever/market",
                        type: 'post',
                        dataType: 'json',
                        data: {id: data.id, update_price: update_price},
                        success: function (res) {
                            layer.msg(res.msg);
                            if (res.code) {
                                layer.close(index);
                                table.reload();
                            }
                        }
                    });
                });
            }
        });

        form.on('submit(mobile_search)', function (data) {
            var search_data = data.field
            lever_list.reload({
                where: search_data
                , page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
            return false;
        });
    });
</script>
</body>
</html>
