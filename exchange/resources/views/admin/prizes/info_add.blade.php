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
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-header">添加奖品多语言信息</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">

                <div class="layui-form-item">
                    <label class="layui-form-label">所属奖品</label>
                    <div class="layui-input-block">
                        <select name="prizes_id" id="">
                            @foreach($prizes as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">语言</label>
                    <div class="layui-input-block">
                        <select name="lang_id" id="">
                            @foreach($langs as $lang)
                                <option value="{{$lang->id}}">{{$lang->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">奖品名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" lay-verify="title" placeholder="请输入名称"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">奖品描述</label>
                    <div class="layui-input-block">
                        <textarea name="description" class="layui-textarea"></textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">奖品图片</label>
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn" id="upload">
                            <i class="layui-icon">&#xe67c;</i>上传图片
                        </button>
                        <input type="hidden" id="upload-input" name="img">
                        <div>
                            <img width="200px" id="upload-img" style="display: none;">
                        </div>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit>立即提交</button>

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
            $.post('/admin/prizes/info_add', data.field, function (res) {
                layer.msg(res.msg);
                if (res.code) {
                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                }
            });
            return false;
        })

    })
</script>
</body>
</html>
