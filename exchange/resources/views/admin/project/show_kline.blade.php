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
            <div class="layui-inline">
                <label class="layui-form-label">期</label>
                <div class="layui-input-block">
                    <select name="p" id="">
                        @foreach($p as $s)
                            <option value="{{$s}}">{{$s}}</option>
                        @endforeach
                    </select>
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
            <script type="text/html" id="table-tool">
                {{--                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="change_set">涨幅设置</a>--}}
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="kline_edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del_kline">删除</a>
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
            , url: '/admin/project/get_kline_data?id={{$id}}&p=1min' //模拟接口
            , cols: [[
                {field: 'id', width: 100, title: 'ID', sort: true},
                {field: 'open', title: '开盘价'},
                {field: 'low', title: '最低价'},
                {field: 'high', title: '最高价'},
                {field: 'close', title: '收盘价'},
                {title: '操作', align: 'center', fixed: 'right', toolbar: '#table-tool'}
            ]]
            , height: 'full-220'
            , toolbar: true //开启工具栏，此处显示默认图标，可以自定义模板，详见文档


        });

        //监听工具条
        table.on('tool(list)', function (obj) {
            var data = obj.data;
            if (obj.event === 'kline_edit') {
                layer.open({
                    type: 2,
                    title: '编辑k线',
                    area: ['800px', '600px'],
                    content: '/admin/project/edit_kline?id=' + data.id + "&p=" + data.period + "&currency_match_id=" + data.currency_match_id,
                    end: function () {
                        table.reload('list');
                    }
                });
            } else if (obj.event === 'del_kline') {
                layer.confirm('确定要删除吗?', function (index) {
                    $.post('/admin/project/del_kline?id=' + data.id+ "&p=" + data.period +"&currency_match_id=" + data.currency_match_id, {
                        id: data.id
                    }, function (res) {
                        layer.msg(res.msg);
                        layer.close(index);
                        table.reload('list');
                    });
                });
            } else if (obj.event === "show_kline") {

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
