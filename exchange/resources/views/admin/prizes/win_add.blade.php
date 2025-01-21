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
        <div class="layui-card-header">添加中奖用户</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <blockquote class="layui-elem-quote">添加中奖用户后，该用户下一次抽奖则抽中配置对应奖品</blockquote>

                <div class="layui-form-item">
                    <label class="layui-form-label">中奖奖品</label>
                    <div class="layui-input-block">
                        <select name="prizes_id" id="">
                            @foreach($prizes as $p)
                                <option value="{{$p->id}}">{{$p->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">中奖用户UID</label>
                    <div class="layui-input-block">
                        <input type="text" name="uid" lay-verify="title" placeholder="请输入UID"
                               class="layui-input">
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
    }).use(['index', 'form'], function () {
        var $ = layui.$
            , form = layui.form

        form.on('submit', function (data) {
            $.post('/admin/prizes/win_add', data.field, function (res) {
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
