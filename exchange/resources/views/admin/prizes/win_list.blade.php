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
            <button class="layui-btn" lay-href="/admin/prizes/win_add">添加中奖用户</button>
        </div>
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">UID</label>
                    <div class="layui-input-block">
                        <input type="text" name="uid" placeholder="请输入UID" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" name="email" placeholder="请输入" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">所属奖品</label>
                    <div class="layui-input-block">
                        <select name="prizes_id">
                            <option value="-1">不限</option>
                            @foreach($prizes as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="layui-inline">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        <select name="prizes_id">
                            <option value="-1">不限</option>
                            <option value="0">未抽奖</option>
                            <option value="1">已中奖</option>
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
            <table id="list" lay-filter="list"></table>
            <script type="text/html" id="table-tool">
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
            , method:'post'
            , url: '/admin/prizes/win_list' //模拟接口
            , cols: [[
                {field: 'id', width: 100, title: 'ID', sort: true},
                {field: 'prizes_name', title: '奖品',templet:function (p){
                    return p.prizes.name;
                    }},
                {field: 'status', title: '状态',templet:function (p){
                        return p.status === 0 ? '<span class="layui-badge" style="padding: 0 6px;text-align: center;">未抽奖</span>' : '<span class="layui-bg-green"  style="padding: 0 6px;text-align: center;">已中奖</span>';
                    }},
                {field: 'uid', title: 'UID',templet:function (p){
                        return p.user.uid;
                    }},
                {field: 'email', title: '邮箱',templet:function (p){
                        return p.user.email;
                    }},
                {field: 'created_at', title: '创建时间'},
                {field: 'used_at', title: '中奖时间'},
                {title: '操作', width: 150, align: 'center', fixed: 'right', toolbar: '#table-tool'}
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
                    $.get('/admin/prizes/win_del', {
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
                    title: '编辑奖品多语言信息',
                    area: ['800px', '600px'],
                    content: '/admin/prizes/win_edit?id=' + data.id,
                });
            }
        });

    });
</script>
</body>
</html>
