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
        <div class="layui-card-header">k线详情</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <ul class="layui-timeline">
                    <li class="layui-timeline-item">
                        <div class="layui-timeline-content layui-text">
                            <input type="hidden" name="id" class="layui-input" value="{{$data->id}}">
                            <input type="hidden" name="currency_match_id" class="layui-input" value="{{$data->currency_match_id}}">
                            <input type="hidden" name="p" class="layui-input" value="{{$data->period}}">
                            <div class="layui-form-item">
                                <label class="layui-form-label">开盘价</label>
                                <div class="layui-input-block">
                                    <input type="text" name="open" placeholder="开盘价" class="layui-input" value="{{$data->open}}">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">收盘价</label>
                                <div class="layui-input-block">
                                    <input type="text" name="close" placeholder="收盘价" class="layui-input" value="{{$data->close}}">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">最高价</label>
                                <div class="layui-input-block">
                                    <input type="text" name="high" placeholder="最高价" class="layui-input" value="{{$data->high}}">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">最低价</label>
                                <div class="layui-input-block">
                                    <input type="text" name="low" placeholder="最低价" class="layui-input" value="{{$data->low}}">
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
    }).use(['index', 'form', 'upload', 'layedit','laydate'], function () {
        var $ = layui.$
            , form = layui.form


        form.on('submit', function (data) {
            $.post('/admin/project/save_kline', data.field, function (res) {
                layer.msg(res.msg);

            });

            return false;
        });

    })
</script>
</body>
</html>
