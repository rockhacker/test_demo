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
                    <button class="layui-btn" lay-href="/admin/fund/add">添加产品</button>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">标题</label>
                    <div class="layui-input-inline" style="width:130px;">
                        <input type="text" name="title" placeholder="请输入标题" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit lay-filter="form_submit">
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
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="edit">修改</a>
{{--    @{{#  if(d.status !=1){ }}--}}
{{--    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="periods">查看期数</a>--}}

{{--    @{{# } }}--}}
    <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="share">查看认购</a>
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

        var data_table = table.render({
            elem: '#data_table'
            , url: '/admin/fund/list'
            , height: 'full-160'
            , page: true
            , limit: 20
            , toolbar: true
            , totalRow: true
            , method: "POST"
            , cols: [[
                {field: 'title', title: '产品标题', width: 200}
                , {field: 'currency_code', title: '币种', width: 120}
                , {field: 'lock_dividend_days', title: '锁仓天数', width: 150}
                , {field: 'staring_sub_amount', title: '最大下单金额', width: 150}
                , {field: 'liquidated_damages', title: '提前赎回违约金', width: 150, templet: function (param) {
                        return param.liquidated_damages + "%"
                    }
                }
                , {
                    field: 'dividend_percentage', title: '派息百分比', width: 170, templet: function (param) {
                        return param.dividend_percentage + "%"
                    }
                }
                // , {field: 'status_str', title: '状态', width: 170}
                // , {field: 'created_at', title: '创建时间', width: 170}
                , {
                    field: 'is_show', title: '是否显示', templet: function (param) {
                        if (param.is_show) {
                            return "显示"
                        } else {

                            return "不显示"
                        }
                    }
                }
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

            } else if(layEvent === 'share'){

                parent.layui.index.openTabsPage('/admin/fund/shareList?id=' + data.id,
                    data.title + "查看认购" );


                // layer.open({
                //     type: 2,
                //     title: '',
                //     area: ['800px', '600px'],
                //     content: '/admin/fund/shareList?id=' + data.id,
                // });

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
