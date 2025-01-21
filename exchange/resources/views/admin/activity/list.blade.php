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
        {{--        <div class="layui-form layui-card-header layuiadmin-card-header-auto">--}}
        {{--            <div class="layui-form-item">--}}
        {{--                <div class="layui-inline">--}}
        {{--                    <label class="layui-form-label">UID</label>--}}
        {{--                    <div class="layui-input-block">--}}
        {{--                        <input type="text" name="uid" placeholder="请输入UID" class="layui-input">--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="layui-inline">--}}
        {{--                    <label class="layui-form-label">邮箱</label>--}}
        {{--                    <div class="layui-input-block">--}}
        {{--                        <input type="text" name="email" placeholder="请输入" class="layui-input">--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--                <div class="layui-inline">--}}
        {{--                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="search">--}}
        {{--                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>--}}
        {{--                    </button>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
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
            , form = layui.form
            , laydate = layui.laydate


        $('input.layui-date').each(function () {
            laydate.render({
                elem: this
                , type: 'datetime'
            });
        });
        //监听搜索
        form.on('submit(search)', function (data) {
            var field = data.field;

            //执行重载
            table.reload('data_table', {
                where: field,
                page: {
                    curr: 1
                }
            });
        });
        var data_table = table.render({
            elem: '#data_table'
            , url: '/admin/activity/lists'
            , height: 'full-160'
            , page: true
            , limit: 20
            , toolbar: true
            , totalRow: true
            , method: "POST"
            , cols: [[
                {
                    field: 'user_email', title: '邮箱', templet: function (param) {
                        return param.get_user_info.email
                    }
                }
                , {
                    field: 'currency', title: '赠送币种', templet: function (param) {
                        return param.currency.code
                    }
                }
                , {field: 'amount', title: '赠送金额'}
                , {field: 'created_at', title: '赠送时间'}
            ]]
        });


    });
</script>
</html>
