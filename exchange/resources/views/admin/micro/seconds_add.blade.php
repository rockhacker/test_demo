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
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            下单设置
        </div>

        <div class="layui-card-body">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <blockquote class="layui-elem-quote">温馨提示:收益率100%填写1,90%填写0.9</blockquote>
            </div>

            <form class="layui-form" action="">

                <div class="layui-form-item">
                    <label class="layui-form-label">秒数</label>
                    <div class="layui-input-block">
                        <input type="text" name="seconds" lay-verify="required" autocomplete="off" placeholder="" class="layui-input" value="{{$result->seconds}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        <input type="checkbox" name="status" value="1" lay-skin="switch" lay-text="开启|关闭"  {{ $result->status == 1 ? 'checked' : '' }}>

                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">收益率</label>
                    <div class="layui-input-block">
                        <input type="text" name="profit_ratio" lay-verify="required" autocomplete="off" placeholder="" class="layui-input" value="{{$result->profit_ratio}}">
                    </div>
                </div>

                <input type="hidden" name="id" value="{{$result->id}}">
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>

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
    }).use(['index', 'useradmin', 'table', 'laydate','element'],function () {
        var form = layui.form
            ,$ = layui.jquery
            ,laydate = layui.laydate
            ,index = parent.layer.getFrameIndex(window.name);
        //监听提交
        form.on('submit(demo1)', function(data){
            var data = data.field;
            $.ajax({
                url:'/admin/micro_seconds_add'
                ,type:'post'
                ,dataType:'json'
                ,data : data
                ,success:function(res){
                    if (!res.code) {
                        layer.msg(res.msg);
                    } else {
                        layer.msg(res.msg);

                        setTimeout(function(){
                        location.reload()
                    },1000)
                    }
                }
            });
            return false;
        });
    });
</script>


</body>
</html>
