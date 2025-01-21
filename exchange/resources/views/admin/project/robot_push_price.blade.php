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
        <div class="layui-card-header">推送价格</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <ul class="layui-timeline">

                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">推送价格配置</h3>
                            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                                <blockquote class="layui-elem-quote">推送价格后立刻生效</blockquote>
                                <blockquote class="layui-elem-quote">推送价格后按照推送价格继续生成行情</blockquote>
                                <blockquote class="layui-elem-quote">推送价格后可能涨可能跌，设置价格时需要有所保留或等价格生效后再继续设置</blockquote>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">价格</label>
                                <div class="layui-input-inline">
                                    <input type="number" class="layui-input" name="price" value=""
                                           placeholder="推送价格">
                                </div>
                            </div>
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
            data.field.id = "{{$id}}"
            $.post('/admin/project/save_robot_new_price', data.field, function (res) {
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
