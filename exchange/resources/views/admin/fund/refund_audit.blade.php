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
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="data_table" lay-filter="data_table"></table>
        </div>
    </div>
</div>

</body>
<script src="/layuiadmin/layui/layui.js"></script>
<script src="/assets/admin/iconfont/iconfont.js"></script>
<script type="text/html" id="operateBar">
    {{--    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="edit">修改</a>--}}
    {{--    @{{#  if(d.status !=1){ }}--}}
    {{--    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="periods">查看期数</a>--}}

    {{--    @{{# } }}--}}
    {{--    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="share">查看认购</a>--}}
    @{{#  if(d.status ==1){ }}
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="agree">同意</a>
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="refuse">拒绝</a>
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
            , url: '/admin/fund/refund_audit_post'
            , height: 'full-160'
            , page: true
            , limit: 20
            , toolbar: true
            , totalRow: true
            , method: "POST"
            , cols: [[
                {
                    field: 'user_email', title: '客户邮箱', width: 200, templet: function (param) {
                        return param.user_email
                    }
                }
                , {
                    field: 'title', title: '产品标题', width: 200, templet: function (param) {
                        return param.get_fund.title
                    }
                }
                , {
                    field: 'currency_code', title: '币种', width: 120, templet: function (param) {
                        return param.get_fund.currency_code
                    }
                }
                , {
                    field: 'liquidated_damages', title: '提前赎回违约金', width: 150, templet: function (param) {
                        return param.get_fund.liquidated_damages + "%"
                    }
                }
                , {
                    field: 'share_amount', title: '赎回本金', width: 150, templet: function (param) {
                        return param.get_sub_fund.share_amount
                    }
                }
                , {
                    field: 'fund_amount', title: '已产生利息', width: 150, templet: function (param) {
                        return param.get_sub_fund.fund_amount
                    }
                }
                // , {field: 'status_str', title: '状态', width: 170}
                , {field: 'created_at', title: '创建时间', width: 170}
                , {fixed: 'right', field: '', title: '操作', width: 250, templet: '#operateBar'}
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
                    content: '/admin/fund/edit?id=' + data.id,
                });
            } else if (layEvent === 'periods') {
                parent.layui.index.openTabsPage('/admin/fund/periodsList?id=' + data.id,
                    data.title + "期数" + data.id);

            } else if (layEvent === 'share') {

                parent.layui.index.openTabsPage('/admin/fund/shareList?id=' + data.id,
                    data.title + "查看认购");

            } else if (layEvent === 'agree') {

                layer.confirm('是否同意退回认购金额并收取违约金', {
                    btn: ['确定', '取消']
                }, function () {
                    $.post('/admin/fund/post_apply?id=' + data.id + "&type=3", {}, function (res) {
                        layer.msg(res.msg);
                        if (res.code) {

                            setTimeout(function () {
                                location.reload()
                            })
                        }
                    });
                }, function () {

                });
            } else if (layEvent === 'refuse') {

                layer.confirm('是否拒绝客户的赎回', {
                    btn: ['确定', '取消']
                }, function () {
                    $.post('/admin/fund/post_apply?id=' + data.id + "&type=2", {}, function (res) {
                        layer.msg(res.msg);
                        if (res.code) {

                            setTimeout(function () {
                                location.reload()
                            })
                        }
                    });
                }, function () {

                });
            }
        });

        form.on('submit(form_submit)', function (data) {
            var search_data = data.field
            data_table.reload({
                where: search_data
                , page: {
                    curr: 1 //重新从第 1 页开始
                }
            });
            return false;
        });
    });
</script>
</html>
