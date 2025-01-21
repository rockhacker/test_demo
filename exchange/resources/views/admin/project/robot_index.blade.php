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
            <button class="layui-btn" lay-href="/admin/project/add_project_robot">添加项目机器人</button>
        </div>

        <div class="layui-card-body">
            <table id="list" lay-filter="list"></table>
            <script type="text/html" id="table-tool">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="change_set">涨幅设置</a>
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="push_price">推送价格</a>
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
{{--                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="show_kline">查看k线</a>--}}
            </script>
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
            , url: '/admin/project/project_robot_list' //模拟接口
            , cols: [[
                {field: 'id', width: 100, title: 'ID', sort: true},
                {field: 'symbol', title: '交易对'},
                {field: 'open_price', title: '开盘价'},
                {field: 'min_default_change', title: '默认最小小时涨跌浮'},
                {field: 'max_default_change', title: '默认最大小时涨跌浮'},
                {field: 'created_at', title: '创建时间'},
                {field: 'updated_at', title: '更新时间'},
                {title: '操作', align: 'center', fixed: 'right', toolbar: '#table-tool'}
            ]]
            , page: true
            , limit: 20
            , height: 'full-220'

            ,  limits: [10, 20, 50, 100, 200, 500, 1000]
            , toolbar: true //开启工具栏，此处显示默认图标，可以自定义模板，详见文档



        });

        //监听工具条
        table.on('tool(list)', function (obj) {
            var data = obj.data;
            if (obj.event === 'change_set') {
                layer.open({
                    type: 2,
                    title: '涨幅设置',
                    area: ['1200px', '800px'],
                    content: '/admin/project/project_robot_change_set?id=' + data.id,
                    end: function () {
                        table.reload('list');
                    }
                });
            }  else if (obj.event === 'push_price') {
                layer.open({
                    type: 2,
                    title: '推送价格',
                    area: ['800px', '600px'],
                    content: '/admin/project/robot_push_price?id=' + data.id,
                    end: function () {
                        table.reload('list');
                    }
                });
            }else if (obj.event === 'edit') {
                layer.open({
                    type: 2,
                    title: '编辑',
                    area: ['800px', '600px'],
                    content: '/admin/project/edit_project_robot?id=' + data.id,
                    end: function () {
                        table.reload('list');
                    }
                });
            }  else if (obj.event === 'delete') {
                layer.confirm('确定要删除吗?', function (index) {
                    $.post('/admin/project/project_robot_del', {
                        id: data.id
                    }, function (res) {
                        layer.msg(res.msg);
                        layer.close(index);
                        table.reload('list');
                    });
                });
            }else if(obj.event === "show_kline"){

                layer.open({
                    type: 2,
                    title: '查看k线数据',
                    area: ['800px', '600px'],
                    content: '/admin/project/show_kline?id=' + data.id,
                    end: function () {
                        table.reload('list');
                    }
                });
            }
        });

    });
</script>
</body>
</html>
