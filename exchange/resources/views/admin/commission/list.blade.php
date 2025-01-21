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
{{--                        <input type="text" name="uid" placeholder="请输入" class="layui-input">--}}
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
{{--                <div class="layui-inline" style="">--}}
{{--                    <div class="layui-input-inline">--}}
{{--                        <input type="checkbox" name="" lay-skin="switch" lay-filter="auto_refresh" lay-text="开启刷新|关闭刷新">--}}
{{--                    </div>--}}
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
<script type="text/html" id="operateBar">
    @{{#  if(d.status == 1){ }}
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="agree">返佣</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="reject">拒绝</a>
    @{{#  } }}

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
            , form = layui.form
            , laydate = layui.laydate

        $('input.layui-date').each(function () {
            laydate.render({
                elem: this
                , type: 'datetime'
            });
        });

        form.on('submit(search)', function (data) {
            var field = data.field;
            //执行重载
            table.reload('data_table', {
                where: field
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
        });

        var data_table = table.render({
            elem: '#data_table'
            , url: '/admin/commission/list_post'
            , height: 'full-160'
            , page: true
            , limit: 20
            , toolbar: true
            , totalRow: true
            , method: "POST"
            , cols: [[
                {field: 'id', title: 'ID', width: 70}
                , {field: 'uid_user', title: '币种', templet: function (d) {
                        return d.currency.code;
                    }}
                , {field: 'to_user_info', title: '冲币邮箱', templet: function (d) {
                        return d.from_user_info.email;
                    }}
                , {field: 'from_user_info', title: '返佣邮箱', templet: function (d) {
                        return d.to_user_info.email;
                    }}
                , {field: 'order_amount', title: '充值金额'}
                , {field: 'exc_amount', title: '返佣金额'}
                , {field: 'status', title: '状态', templet: function (d) {
                        switch (d.status){
                            case 1:
                                return '未审核'
                            case 2:
                                return '不返佣'
                            case 3:
                                return '已返佣'
                            default:
                                return '未知'
                        }
                    }}
                , {field: 'created_at', title: '入金时间'}
                , {fixed: 'right', field: '', title: '操作', width: 250, templet: '#operateBar'}
            ]]
        });

        form.on('switch(auto_refresh)', function(data){

            if (data.elem.checked) {
                interval = setInterval(() => {


                    data_table.reload({});

                }, 5000);
            } else {
                clearInterval(interval);
            }
        });
        //监听工具条
        table.on('tool(data_table)', function (obj) {
            var data = obj.data
                , layEvent = obj.event
                , tr = obj.tr;
            if (layEvent === 'agree') {
                layer.confirm("真的确认执行操作?", function (index) {
                    $.ajax({
                        url: '/admin/commission/agree'
                        ,method: 'POST'
                        ,data: {id : data.id}
                        ,success: function (res) {
                            if (res.code === 1) {

                                layer.msg(res.msg)

                                setTimeout(function(){
                                    location.reload()
                                })
                            } else {
                                layer.msg(res.msg)
                            }
                        }
                        ,error: function () {
                            layer.msg("服务器出错")
                        }
                    });
                });
                return false;
            }else if (layEvent === 'reject'){

                layer.confirm("真的确认执行操作?", function (index) {
                    $.ajax({
                        url: '/admin/commission/reject'
                        ,method: 'POST'
                        ,data: {id : data.id}
                        ,success: function (res) {
                            if (res.code === 1) {

                                layer.msg(res.msg)

                                setTimeout(function(){
                                    location.reload()
                                })
                            } else {
                                layer.msg(res.msg)
                            }
                        }
                        ,error: function () {
                            layer.msg("服务器出错")
                        }
                    });
                });
                return false;
            }

        });

    });
</script>
</html>
