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
        <div class="layui-card-header layuiadmin-card-header-auto">
            <button class="layui-btn layuiadmin-btn-useradmin" lay-href="/admin/setting/add">
                添加设置项
            </button>
            <button class="layui-btn layuiadmin-btn-useradmin" onclick="reload_quote()" id="reload" >
                重启行情服务
            </button>
        </div>

        <div class="layui-form layui-card-header layuiadmin-card-header-auto" lay-filter="form">

            <div class="layui-inline">
                <label class="layui-form-label">类型</label>
                <div class="layui-inline">
                    <select name="setting_type_id" id="">
                        <option value="0">不限</option>
                        @foreach($setting_types as $settingType)
                            <option value="{{$settingType->id}}">{{$settingType->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="search">
                        筛选
                    </button>
                </div>
            </div>

        </div>

        <div class="layui-card-body">
            <table id="list" lay-filter="list"></table>
            <script type="text/html" id="imgTpl">
                <img style="display: inline-block;height: 100%;" src="@{{ d.avatar }}">
            </script>
            <script type="text/html" id="table-tool">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            </script>
        </div>
    </div>
</div>

<script src="/layuiadmin/layui/layui.js"></script>
<script>
    function reload_quote(){
        layui.$('#reload').addClass('layui-btn-disabled');
        layui.$.post('/admin/reload_quote', {}, function (res) {
            layer.msg(res.msg);

            layui.$('#reload').removeClass('layui-btn-disabled');
        });
    }

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
            ,url: '/admin/setting/list' //模拟接口
            ,cols: [[
                {field: 'id', width: 100, title: 'ID'},
                {field: 'key', title: '配置项'},
                {field: 'value', title: '值'},
                {field: 'desc', title: '简介'},
                {field: 'visible', title: '前台可见', templet: '#visible'},
                {field: 'type_name', title: '分类'},
                {title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#table-tool'}
            ]]
            ,page: true
            ,limit: 20
            ,height: 'full-220'

            ,limits: [10, 20, 50, 100, 200, 500, 1000]
            ,toolbar: true //开启工具栏，此处显示默认图标，可以自定义模板，详见文档
        });

        //监听工具条
        table.on('tool(list)', function (obj) {
            var data = obj.data;
            if (obj.event === 'del') {
                layer.confirm('危险操作!真的删除么?', function (index) {
                    $.get('/admin/setting/delete', {
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
                    title: '编辑属性',
                    area: ['800px', '600px'],
                    content: '/admin/setting/edit?id=' + data.id,
                    end: function () {
                        table.reload('list');
                    }
                });
            }
        });
    });
</script>
<script type="text/html" id="visible">
    @{{# if (d.visible) { }}
    <span class="layui-badge">是</span>
    @{{# } else { }}
    <span class="layui-badge-rim">否</span>
    @{{# } }}
</script>
</body>
</html>
