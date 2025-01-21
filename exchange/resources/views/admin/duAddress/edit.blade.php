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
        <div class="layui-card-header">编辑</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <input type="hidden" name="id" value="{{$info->id}}">

                <div class="layui-form-item">
                    <label class="layui-form-label">类型</label>
                    <div class="layui-input-block">
                        <select name="type_id">
                            <option value="0">请选择</option>
                            @foreach($types as $type)
                                <option value="{{$type->id}}" @if($info->type_id == $type->id) selected
                                    @endif>{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">地址</label>
                    <div class="layui-input-block">
                        <input type="text" name="address" lay-verify="address" placeholder="请输入名称"
                               class="layui-input" value="{{$info['address']}}">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">私钥</label>
                    <div class="layui-input-block">
                        <input type="text" name="private_key" lay-verify="private_key" placeholder="请输入名称"
                               class="layui-input" value="{{$info['private_key']}}">
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

        form.on('submit', function (data) {

            $.post('/admin/du_address/update', data.field, function (res) {
                layer.msg(res.msg);

                if (res.code) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layui.table.reload('list');
                    parent.layer.close(index);
                }
            });
            return false;
        })

    })
</script>
</body>
</html>
