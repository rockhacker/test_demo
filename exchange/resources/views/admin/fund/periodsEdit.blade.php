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
        <div class="layui-card-header">编辑期数详情</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <ul class="layui-timeline">
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title"></h3>
                            <div class="layui-form-item">
                                <label class="layui-form-label">派息百分比(本金*百分比=息)</label>
                                <div class="layui-input-block">
                                    <input type="number" name="each_dividend" class="layui-input"
                                           value="{{$res->each_dividend}}"
                                           placeholder="请输入派息百分比（百分之1填写1）">
                                </div>
                            </div>
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
    }).use(['index', 'form', 'upload', 'laydate'], function () {
        var $ = layui.$
            , form = layui.form
            , upload = layui.upload
            , laydate = layui.laydate;


        form.on('submit', function (data) {

            $.post('/admin/fund/periodsEdit?id='+"{{$res->id}}", data.field, function (res) {
                layer.msg(res.msg);
                if (res.code) {
                    setTimeout(function () {
                        var index = parent.layer.getFrameIndex(window.name);
                        parent.layer.close(index);
                    }, 1000)
                }
            });
            return false;
        })

    })
</script>
</body>
</html>
