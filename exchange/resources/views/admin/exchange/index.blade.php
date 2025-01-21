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
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">UID</label>
                    <div class="layui-input-block">
                        <input type="text" name="uid" class="layui-input" placeholder="请输入UID">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" name="email" class="layui-input" placeholder="请输入">
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
            <table id="list" lay-filter="list"></table>
        </div>
    </div>
</div>

<script src="/layuiadmin/layui/layui.js"></script>
<script>
    layui.config({
        base: '/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'useradmin', 'table'], function () {
        var $ = layui.$
            , form = layui.form
            , table = layui.table;

        //监听搜索
        form.on('submit(search)', function (data) {
            var field = data.field;

            //执行重载
            table.reload('list', {
                where: field,
                page: {
                    curr: 1
                }
            });

        });

        //用户管理
        table.render({
            elem: '#list'
            , url: "/admin/exchange/getData" //模拟接口
            , cols: [[
                {field: 'id', width: 100, title: 'ID'},
                {field: 'email', title: '邮箱'},
                {field: 'UID', title: 'UID', templet: function (d){
                     return d.user.uid;
                    }},
                {field: 'last_price', title: '兑换价格'},
                {field: 'amount', title: '兑换数量', templet: function (d){
                        if (d.type == 1){

                            return d.amount + " " + d.quote_currency_code
                        }else{

                            return d.amount + " " + d.base_currency_code
                        }
                    }},
                {field: 'logo', title: '类型', templet: function (d){
                    if (d.type == 1){
                        return d.quote_currency_code +"兑"+d.base_currency_code

                    }else{
                        return d.base_currency_code +"兑"+d.quote_currency_code

                    }
                }},
                {field: 'number', title: '最终数量', templet: function (d){
                        if (d.type == 1){

                            return d.number + " " + d.base_currency_code
                        }else{

                            return d.number + " " + d.quote_currency_code
                        }
                    }},
                {field: 'created_at', title: '兑换时间'},
            ]]
            , page: true
            , limit: 20
            , height: 'full-220'

            , limits: [10, 20, 50, 100, 200, 500, 1000]
            , toolbar: true //开启工具栏，此处显示默认图标，可以自定义模板，详见文档


        });

    });
</script>
</body>
</html>
