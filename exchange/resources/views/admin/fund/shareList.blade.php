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

    @{{#  if(d.status ==1){ }}
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="edit">取消认购</a>
    @{{# } }}
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
            , url: '/admin/fund/shareList?id=' + "{{$res->id}}"
            , height: 'full-160'
            , page: true
            , limit: 20
            , toolbar: true
            , totalRow: true
            , method: "POST"
            , cols: [[
                {field: 'user_email', title: '邮箱'}
                , {field: 'sub_time', title: '认购时间'}
                , {field: 'share_amount', title: '认购金额'}
                , {field: 'fund_amount', title: '已发放利息'}
                // , {field: 'share', title: '认购份额'}
                , {
                    field: 'status', title: '状态', templet: function (param) {
                        if (param.status === 1) {
                            return "已认购"
                        } else if(param.status === 2) {

                            return "申请退款中"
                        } else if(param.status === 3) {

                            return "已退款"
                        }  else if(param.status === 4) {

                            return "已结束"
                        } else{

                            return "未知状态"
                        }
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
                // layer.open({
                //     type: 2,
                //     title: '编辑',
                //     area: ['800px', '600px'],
                //     content: '/admin/fund/shareEdit?id=' + data.id,
                // });

                layer.confirm('是否取消锁仓并退回认购金额', {
                    btn: ['确定','取消']
                }, function(){
                    $.post('/admin/fund/cancelSub?id=' + data.id, {}, function (res) {
                        layer.msg(res.msg);
                        if (res.code) {

                            setTimeout(function(){
                                location.reload()
                            })
                        }
                    });
                }, function(){

                });
            }
        });

    });
</script>
</html>
