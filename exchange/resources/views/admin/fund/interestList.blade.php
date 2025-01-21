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
        <div class="layui-card-body">
            <table id="data_table" lay-filter="data_table"></table>
        </div>
    </div>
</div>

</body>
<script src="/layuiadmin/layui/layui.js"></script>
<script src="/assets/admin/iconfont/iconfont.js"></script>

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
            , laydate = layui.laydate


        $('input.layui-date').each(function () {
            laydate.render({
                elem: this
                , type: 'datetime'
            });
        });

        var data_table = table.render({
            elem: '#data_table'
            , url: '/admin/fund/grantInfo?id=' + "{{$id}}"
            , height: 'full-160'
            , page: true
            , limit: 20
            , toolbar: true
            , totalRow: true
            , method: "POST"
            , cols: [[
                {field: 'user_email', title: '用户邮箱'}
                , {field: 'interest', title: '发放金额'}
                , {field: 'created_at', title: '发放时间'}
            ]]
        });
    });
</script>
</html>
