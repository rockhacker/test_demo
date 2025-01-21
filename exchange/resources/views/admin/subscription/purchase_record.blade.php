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

    @{{#  if(d.status <=2 && d.is_return == 0){ }}
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="ref">全额退款</a>
    @{{# } }}

    @{{#  if(d.status <=3){ }}
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="lottery_management">中签管理</a>
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
            , url: '/admin/subscription/get_purchase_record?id=' + "{{$id}}"
            , height: 'full-160'
            , page: true
            , limit: 20
            , toolbar: true
            , totalRow: true
            , method: "POST"
            , cols: [[
                {field: 'user_email', title: '邮箱',templet:function (param){
                        return param.get_user_info.email
                    }}
                , {field: 'pay_amount', title: '支付金额',templet:function (param){
                        return param.pay_amount +""+param.pay_currency.code
                    }}
                , {field: 'number', title: '申购数量'}
                , {field: 'winning_lots_number', title: '中签数量'}
                , {field: 'winning_lots_number', title: '中签数量*上市价', templet: function (param) {
                        return param.winning_lots_number * param.subscription.market_price;
                    }}
                , {
                    field: 'status', title: '状态', templet: function (param) {
                        if (param.status === 1) {
                            return "待抽签"
                        } else if(param.status === 2) {

                            return "未中签"
                        } else if(param.status === 3) {

                            return "已中签"
                        }  else if(param.status === 4) {

                            return "已发币"
                        }  else if(param.status === 5) {

                            return "已退款"
                        } else{

                            return "未知状态"
                        }
                    }
                }
                ,{
                    field: 'is_return', title: '是否退款', templet: function (param) {
                        if (param.is_return === 1) {
                            return "已退款"
                        } else if(param.is_return === 2) {

                            return "部分退款"
                        } else if(param.is_return === 3) {

                            return "全额退款"
                        } else{

                            return "否"
                        }
                    }
                }
                , {field: 'created_at', title: '认购时间'}
                , {fixed: 'right', field: '', title: '操作', templet: '#operateBar'}
            ]]
        });
        //监听工具条
        table.on('tool(data_table)', function (obj) {
            var data = obj.data
                , layEvent = obj.event
                , tr = obj.tr;
            if (layEvent === 'ref') {
                layer.confirm('是否全额退款申购金额', {
                    btn: ['确定','取消']
                }, function(){
                    $.post('/admin/subscription/sub_ref?id=' + data.id, {}, function (res) {
                        layer.msg(res.msg);
                        if (res.code) {

                            setTimeout(function(){
                                location.reload()
                            })
                        }
                    });
                }, function(){

                });
            }else if(layEvent === "lottery_management"){

                layer.open({
                    type: 2,
                    title: '中签管理',
                    area: ['800px', '600px'],
                    content: '/admin/subscription/lottery_management?id=' + data.id,
                });

            }
        });

    });
</script>
</html>
