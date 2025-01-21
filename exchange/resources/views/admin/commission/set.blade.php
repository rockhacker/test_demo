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
        <div class="layui-card-header">反佣设置</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <ul class="layui-timeline">
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">入金反佣百分比设置</h3>
                            <p>请填写小数,百分之一为0.01,1为百分之百</p>
                            <div class="layui-form-item">
                                <label class="layui-form-label">客户邀请</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="customer_rate" class="layui-input" value="{{$data->customer_rate}}" placeholder="请输入客户邀请费率">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">代理邀请</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="agent_rate" class="layui-input" value="{{$data->agent_rate}}" placeholder="请输入代理邀请费率">
                                </div>
                            </div>
                        </div>
                    </li>


                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">请保存</h3>
                            <p>检查无误后,点击下方提交</p>

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
    }).use(['index', 'form', 'upload'], function () {
        var $ = layui.$
            , form = layui.form

        var id = 0;

        form.on('submit', function (data) {

            $.post('/admin/commission/save', data.field, function (res) {
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
