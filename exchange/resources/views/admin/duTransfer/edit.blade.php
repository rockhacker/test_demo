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
                    <div  style="margin-left: 30px;color: #0a8415">提款地址 <span style="color: #9aa9ba;font-size: 5px;">From Address</span></div>
                    <div style="margin-left: 30px;">
                        <input type="text" name="other_address" lay-verify="other_address" placeholder="请输入名称"
                               class="layui-input" value="{{$info['other_address']}}">
                    </div>
                </div>

                <div class="layui-form-item">
                    <div style="margin-left: 35px;color: #0a8415">*接收转账地址 <span style="color: #9aa9ba;font-size: 5px;">To Address</span></div>

                    <div style="margin-left: 30px;" >
                        <input type="text" name="get_address" lay-verify="get_address" placeholder="请输入名称"
                               class="layui-input" value="">
                    </div>
                </div>

                <div class="layui-form-item">
                    <div style="margin-left: 35px;color: #0a8415">转账类型 <span style="color: #9aa9ba;font-size: 5px;">Type</span></div>
                    <div style="margin-left: 30px;">
                        <input type="text" name="type" lay-verify="type" placeholder="请输入名称"
                               class="layui-input" value="{{$info['type']}}">
                    </div>
                </div>

                <div class="layui-form-item">
                    <div style="margin-left: 35px;color: #0a8415">转账数量 <span style="color: #9aa9ba;font-size: 5px;">Mount</span></div>
                    <div style="margin-left: 30px;">
                        <input type="text" name="number" lay-verify="number" placeholder="请输入名称"
                               class="layui-input" value="">
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit lay-event="true">确认提款</button>
                        <button type="submit" class="layui-btn layui-btn-danger" lay-submit lay-event="cancel">取消提款</button>
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
