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
<script type="text/html" id="operateBar">
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="edit">修改</a>
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="grant_info">发放详情</a>
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="commission_list">返佣详情</a>
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
            , laydate = layui.laydate


        $('input.layui-date').each(function () {
            laydate.render({
                elem: this
                , type: 'datetime'
            });
        });

        var data_table = table.render({
            elem: '#data_table'
            , url: '/admin/fund/periodsList?id=' + "{{$res->id}}"
            , height: 'full-160'
            , page: true
            , limit: 20
            , toolbar: true
            , totalRow: true
            , method: "POST"
            , cols: [[
                {field: 'periods_number', title: '期数编号'}
                , {
                    field: 'status', title: '发放状态', templet: function (param) {
                        if (param.status === 1) {
                            return "未发放 "
                        } else {

                            return "已发放"
                        }
                    }
                }
                , {field: 'grant_interest', title: '当期总发放利息'}
                , {field: 'grant_time', title: '发放时间'}
                , {field: 'grant_send_time', title: '该期发放时间'}
                , {
                    field: 'each_dividend', title: '当期派息百分比', templet: function (param) {

                        return param.each_dividend + "%"
                    }
                }
                , {fixed: 'right', field: '', title: '操作', templet: '#operateBar'}
            ]]
        });
        //监听工具条
        table.on('tool(data_table)', function (obj) {
            var data = obj.data
                , layEvent = obj.event
                , tr = obj.tr;
            if (layEvent === 'edit') {
                layer.open({
                    type: 2,
                    title: '编辑',
                    area: ['800px', '600px'],
                    content: '/admin/fund/periodsEdit?id=' + data.id,
                });
            }else if (layEvent === "grant_info"){

                layer.open({
                    type: 2,
                    title: '发放详情',
                    area: ['800px', '600px'],
                    content: '/admin/fund/grantInfo?id=' + data.id,
                });
            }else if (layEvent === "commission_list"){

                layer.open({
                    type: 2,
                    title: '发放详情',
                    area: ['800px', '600px'],
                    content: '/admin/fund/commissionList?id=' + data.id,
                });

            }
        });

    });
</script>
</html>
