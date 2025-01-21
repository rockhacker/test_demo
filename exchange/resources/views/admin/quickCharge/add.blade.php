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
        <div class="layui-card-header">添加</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <ul class="layui-timeline">
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">

                            <div class="layui-form-item">
                                <label class="layui-form-label">币种</label>
                                <div class="layui-input-block">
                                    <select name="currency_protoc_id" id="">
                                        @foreach($currencies as $currency)
                                            <option value="{{$currency->id}}">{{$currency->currency->code}}-{{$currency->chainProtocol->code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">付款地址</label>
                                <div class="layui-input-block">
                                    <input type="text" name="address" placeholder="请填写付款地址" class="layui-input">
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
    }).use(['index', 'form', 'upload','laydate'], function () {
        var $ = layui.$
            , form = layui.form
            , upload = layui.upload
            , laydate = layui.laydate;

            laydate.render({
                elem: '#time', //指定元素
                type:"datetime",
                range: true
            });

        form.on('submit', function (data) {

            $.post('/admin/quickCharge/add', data.field, function (res) {
                layer.msg(res.msg);
                if (res.code) {
                    id = res.data.id
                    setTimeout(function(){
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
