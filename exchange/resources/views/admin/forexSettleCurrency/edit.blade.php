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
        <div class="layui-card-header">编辑币种</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <input type="hidden" name="id" value="{{ $info->id}}">
                <div class="layui-form-item">
                    <label class="layui-form-label">币种名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="currency_name" value="{{ $info->currency_name }}" placeholder="请填写币种名称,如:USD" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">LOGO</label>
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" id="upload">
                            <i class="layui-icon">&#xe67c;</i>上传图片
                        </button>
                        <input type="hidden" id="upload-input" name="logo" value="{{$info->logo}}">
                        <div style="margin-top: 10px">
                            <img width="200px" id="upload-img" src="{{$info->logo}}">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否结算账户</label>
                    <div class="layui-input-block">
                        <input type="radio" name="settle_status" value="1" title="是" checked>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">兑换币</label>
                    <div class="layui-input-block">
                        <select name="recharge_currency_id">
                            @foreach($currencies as $currency)
                                <option value="{{$currency->id}}" {{ $currency->id == $info->recharge_currency_id? 'selected': '' }}>{{$currency->code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">兑换比例</label>
                    <div class="layui-input-block">
                        <input type="text" name="recharge_bili" value="{{ $info->recharge_bili }}" placeholder="请填写" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit>立即提交</button>
                    </div>
                </div>
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
    }).use(['index', 'form', 'upload'], function () {
        var $ = layui.$
            , form = layui.form
            , upload = layui.upload;

        var uploadInst = upload.render({
            elem: '#upload' //绑定元素
            , url: '/admin/upload/layui_upload' //上传接口
            , done: function (res) {
                $('#upload-img').attr('src', res.data.src);
                $('#upload-img').show();
                $('#upload-input').val(res.data.src);
            }
            , error: function () {
                layer.msg('上传失败');
            }
        });

        form.on('submit', function (data) {

            $.post('/admin/forex/settle_currency/update', data.field, function (res) {
                layer.msg(res.msg);

                if (res.code) {
                    setTimeout(function () {
                        location.reload()
                    }, 1000);
                }
            });

            return false;
        })

    })
</script>
</body>
</html>
