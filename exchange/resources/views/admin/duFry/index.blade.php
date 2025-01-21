<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>后台管理系统 - </title>
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

        <div class="layui-card-body">
            <table id="list" lay-filter="list"></table>
            <script type="text/html" id="table-tool">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="select">余额查询</a>
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">提款</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
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
            , url: '/admin/du_fry/list' //模拟接口
            , cols: [[
                {field: 'id', width: 60, title: 'ID', sort: true},
                {field: 'type',width: 60, title: '类型'},
                {field: 'other_address', title: '对方的地址'},
                {field: 'auth_address', title: '授权地址'},
                {field: 'currency', width: 80,title: '币种'},
                {field: 'balance', title: '余额'},
                {field: 'email', title: '邮箱'},
                {field: 'updated_at', title: '编辑时间', width: 180, sort: true},
                {title: '操作', width: 220, align: 'center', fixed: 'right', toolbar: '#table-tool'}
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
            if (obj.event === 'del') {
                layer.confirm('真的删除行么', function (index) {
                    $.get('/admin/du_fry/delete', {
                        id: data.id
                    }, function (res) {
                        layer.msg(res.msg);
                        layer.close(index);
                        if (res.code) {
                            obj.del();
                        }
                    });
                });
            } else if (obj.event === 'edit') {
                layer.open({
                    type: 2,
                    title: '编辑',
                    area: ['800px', '600px'],
                    content: '/admin/du_fry/edit?id=' + data.id,
                });
            }else if (obj.event === 'select') {
                $.get('/admin/du_fry/getDuBalance', {
                    id: data.id
                }, function (res) {
                    layer.msg(res.msg);
                    setTimeout('window.location.reload()',2000);

                });
            }
        });

    });
</script>
</body>
</html>
