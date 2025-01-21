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
        .layui-form-label {
            width: unset;
        }

        .icon {
            width: 1em;
            height: 1em;
            vertical-align: -0.15em;
            fill: currentColor;
            overflow: hidden;
        }
    </style>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">

        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">UID</label>
                    <div class="layui-input-block">
                        <input type="text" name="uid" placeholder="请输入" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" name="email" placeholder="请输入" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-inline">
                        <select name="status" id="status">
                            <option value="-1">所有</option>
                            <option value="1">未上分</option>
                            <option value="2">已上分</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="layui-card-body">
            <table id="data_table" lay-filter="data_table"></table>
        </div>
    </div>
</div>

</body>
<script src="/layuiadmin/layui/layui.js"></script>
<script src="/assets/admin/iconfont/iconfont.js"></script>
<script type="text/html" id="operateBar">
    @{{#  if(d.status == 2 && d.style == 1){ }}
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="recharge_order_coin">上分</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="recharge_order_reject">拒绝</a>
    @{{#  } }}

</script>
<script>
    layui.config({
        base: '/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'element', 'form', 'layer', 'table', 'laydate'], function () {
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

        form.on('submit(search)', function (data) {
            var field = data.field;
            //执行重载
            table.reload('data_table', {
                where: field
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
        });

        var data_table = table.render({
            elem: '#data_table'
            , url: '/admin/quickCharge/recharge_order_list'
            , height: 'full-160'
            , page: true
            , limit: 20
            , toolbar: true
            , totalRow: true
            , method: "POST"
            , cols: [[
                {field: 'id', title: 'ID', width: 70}
                , {field: 'uid_user', title: 'UID', templet: function (d) {
                        return d.get_users.uid;
                    }}
                , {field: 'email', title: '邮箱'}
                , {field: 'flat_money', title: '法定货币', templet: function (d) {
                        return d.get_rate.flat_money;
                    }}
                , {field: 'amount', title: '付款金额'}
                , {field: 'order_no', title: '订单号'}
                , {field: 'exch_usdt_num', title: '兑换usdt数量'}
                , {field: 'status', title: '状态', templet: function (d) {
                        switch (d.status){
                            case 1:
                                return '未支付'
                            case 2:
                                return '已支付'
                            default:

                                return '未知'
                        }
                    }}

                , {field: 'style', title: '上分状态', templet: function (d) {
                        switch (d.style){
                            case 1:
                                return '未操作'
                            case 2:
                                return '已上分'
                            case 3:
                                return '已拒绝'
                            default:

                                return '未知'
                        }
                    }}
                , {field: 'created_at', title: '提交时间'}
                , {fixed: 'right', field: '', title: '操作', width: 250, templet: '#operateBar'}
            ]]
        });
        //监听工具条
        table.on('tool(data_table)', function (obj) {
            var data = obj.data
                , layEvent = obj.event
                , tr = obj.tr;
            if (layEvent === 'recharge_order_coin') {
                layer.confirm("真的确认执行操作?", function (index) {
                    $.ajax({
                        url: '/admin/quickCharge/recharge_order_coin'
                        ,method: 'POST'
                        ,data: {id : data.id}
                        ,success: function (res) {
                            if (res.code === 1) {

                                layer.msg(res.msg)

                                setTimeout(function(){
                                    location.reload()
                                })
                            } else {
                                layer.msg(res.msg)
                            }
                        }
                        ,error: function () {
                            layer.msg("服务器出错")
                        }
                    });
                });
                return false;
            }else if (layEvent === 'recharge_order_reject'){

                layer.confirm("真的确认执行操作?", function (index) {
                    $.ajax({
                        url: '/admin/quickCharge/recharge_order_reject'
                        ,method: 'POST'
                        ,data: {id : data.id}
                        ,success: function (res) {
                            if (res.code === 1) {

                                layer.msg(res.msg)

                                setTimeout(function(){
                                    location.reload()
                                })
                            } else {
                                layer.msg(res.msg)
                            }
                        }
                        ,error: function () {
                            layer.msg("服务器出错")
                        }
                    });
                });
                return false;
            }

        });

    });
</script>
</html>
