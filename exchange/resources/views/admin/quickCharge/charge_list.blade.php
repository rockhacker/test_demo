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
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
                <div class="layui-inline" style="">
                    <div class="layui-input-inline">
                        <input type="checkbox" name="" lay-skin="switch" lay-filter="auto_refresh" lay-text="开启刷新|关闭刷新">
                    </div>
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
    @{{#  if(d.status == 0){ }}
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="recharge_coin">已完成</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="invalid">无效</a>
    {{--    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="reject">拒绝</a>--}}
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
            , url: '/admin/quickCharge/charge_list'
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
                // , {field: 'currency_code', title: '币种'}
                // , {field: 'address', title: '付款地址'}
                , {field: 'type', title: '来源', templet: function (d) {
                        switch (d.type){
                            case 0:
                                return '链上充值'
                            case 1:
                                return '电汇'
                            default:
                                return '未知'
                        }
                    }}
                , {field: 'number', title: '付款数量'}
                , {field: 'coin', title: '收款银行', templet: function (d) {
                        if(d.get_wire){
                            return d.get_wire.bank_name;
                        }else{
                            return '';
                        }
                    }}
                , {field: 'coin', title: '收款账户', templet: function (d) {
                        if(d.get_wire){
                            return d.get_wire.payee_account;
                        }else{
                            return '';
                        }
                    }}
                , {field: 'coin', title: '付款货币', templet: function (d) {
                        if(d.get_wire){
                            return d.get_wire.get_symbol.name;
                        }else{
                            return '';
                        }

                    }}
                , {field: ' proof_img', title: '付款凭证', templet: function (d) {
                        return "<a href='"+d.proof_img+"' target='_blank'>点击查看</a>"
                    }}
                , {field: 'status', title: '状态', templet: function (d) {
                        switch (d.status){
                            case 0:
                                return '未审核'
                            case 1:
                                return '已上分'
                            case 2:
                                return '已拒绝'
                            default:

                                return '未知'
                        }
                    }}
                , {field: 'created_at', title: '提交时间'}
                , {fixed: 'right', field: '', title: '操作', width: 250, templet: '#operateBar'}
            ]]
        });

        form.on('switch(auto_refresh)', function(data){

            if (data.elem.checked) {
                interval = setInterval(() => {


                    data_table.reload({});

                }, 5000);
            } else {
                clearInterval(interval);
            }
        });
        //监听工具条
        table.on('tool(data_table)', function (obj) {
            var data = obj.data
                , layEvent = obj.event
                , tr = obj.tr;
            if (layEvent === 'recharge_coin') {
                layer.confirm("真的确认执行操作?", function (index) {
                    $.ajax({
                        url: '/admin/quickCharge/recharge_coin?type=1'
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
            }else if(layEvent === 'invalid'){
                layer.confirm("真的确认执行操作?", function (index) {
                    $.ajax({
                        url: '/admin/quickCharge/recharge_coin?type=2'
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
            }else if (layEvent === 'reject'){

                layer.confirm("真的确认执行操作?", function (index) {
                    $.ajax({
                        url: '/admin/quickCharge/recharge_reject'
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
