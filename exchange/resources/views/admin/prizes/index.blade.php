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
            奖品管理
        </div>

        <div class="layui-card-body">
            <table id="list" lay-filter="list"></table>

            <script type="text/html" id="table-tool">
                <a class="layui-btn layui-btn-default layui-btn-xs" lay-event="edit">编辑</a>
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
            , table = layui.table

        //用户管理
        table.render({
            elem: '#list'
            , url: '/admin/prizes/list' //模拟接口
            , cols: [[
                {field: 'id', width: 80, title: 'ID', sort: true},
                {field: 'name', title: '奖品名称'},
                {field: 'default_win', title: '默认中奖奖品',templet:function (p){
                    return p.default_win === 1 ? '是' : '否';
                }},
                {title: '操作', width: 200, align: 'center', fixed: 'right', toolbar: '#table-tool'}
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
            if (obj.event === 'edit') {
                layer.open({
                    type: 2,
                    title: '修改',
                    area: ['800px', '600px'],
                    content: '/admin/prizes/edit?id=' + data.id,
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
