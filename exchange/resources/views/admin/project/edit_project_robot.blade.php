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
        .layui-timeline-title {
            margin-bottom: 15px;
        }

        p {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">编辑项目机器人</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <ul class="layui-timeline">

                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">编辑机器人配置</h3>
                            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                                <blockquote class="layui-elem-quote">如果无法读取到每日配置则使用每小时随机范围默认涨幅走k线</blockquote>
                                <blockquote class="layui-elem-quote">填写0.1为一小时涨幅百分之10</blockquote>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">随机涨幅</label>
                                <div class="layui-input-inline">
                                    <input type="number" class="layui-input" name="min_default_change" value="{{$robot->min_default_change}}"
                                           placeholder="最小涨跌">
                                </div>
                                <div class="layui-form-mid">-</div>
                                <div class="layui-input-inline">
                                    <input type="number" class="layui-input" name="max_default_change" value="{{$robot->max_default_change}}"
                                           placeholder="最大涨跌">
                                </div>
                            </div>
{{--                            <div class="layui-form-item">--}}
{{--                                <label class="layui-form-label"></label>--}}
{{--                                <div class="layui-input-inline">--}}
{{--                                    <input type="number" class="layui-input" name="default_change" value=""--}}
{{--                                           placeholder="默认涨幅">--}}
{{--                                </div>--}}

{{--                            </div>--}}
                        </div>
                    </li>

                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">最后:保存</h3>
                            <p>请仔细检查基本信息是否填写正确</p>
                            <p>检查无误后,点击下方提交</p>

                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit>立即提交</button>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </form>
        </div>

    </div>
</div>

<script src="/layuiadmin/layui/layui.js"></script>
<script>
    layui.config({
        base: '/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form', 'upload', 'layedit','laydate'], function () {
        var $ = layui.$
            , form = layui.form
            , upload = layui.upload
            , layedit = layui.layedit
            , laydate = layui.laydate;

        laydate.render({
            elem: '.time', //指定元素
            type: "datetime",
            range: true
        });
        var id = 0;


        form.on('submit', function (data) {
            data.field.id = "{{$robot->id}}"
            $.post('/admin/project/update_project_robot', data.field, function (res) {
                layer.msg(res.msg);
                if (res.code) {
                    id = res.data.id
                    setTimeout(function () {
                        location.reload()
                    })
                }
            });

            return false;
        });

    })
</script>
</body>
</html>
