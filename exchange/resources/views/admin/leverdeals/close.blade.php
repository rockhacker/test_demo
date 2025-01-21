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
        <div class="layui-card-header">平仓</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <input type="hidden"  name="id" value="{{$id}}">


                <div class="layui-form-item">
                    <label class="layui-form-label">平仓价格</label>
                    <div class="layui-input-block">
                        <input type="number" name="update_price" placeholder="请输入价格，留空为当前价平仓"
                               class="layui-input" >
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
    }).use(['index', 'form',], function () {
        var $ = layui.$
            , form = layui.form

        form.on('submit', function (data) {

            $.post('/admin/lever_transaction/close', data.field, function (res) {
                layer.msg(res.msg);

                if (res.code) {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layui.table.reload('leverList');
                    parent.layer.close(index);
                }
            });
            return false;
        })

    })
</script>
</body>
</html>
