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
        <div class="layui-card-header">编辑新币申购</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <input type="hidden" name="id" value="{{$data->id}}">
                <ul class="layui-timeline">
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">编辑新币时间配置</h3>
                            <div class="layui-form-item">
                                <label class="layui-form-label">申购开始结束时间</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input time" name="range_time" value="{{$data->start_time}} - {{$data->finish_time}}">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">上市时间</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input time2" name="market_time" value="{{$data->market_time}}">
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">价格设置</h3>
                            <div class="layui-form-item">
                                <label class="layui-form-label">申购价格</label>
                                <div class="layui-input-inline">
                                    <input type="number" class="layui-input" name="sub_price" value="{{$data->sub_price}}"
                                           placeholder="申购价格">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">上市价格</label>
                                <div class="layui-input-inline">
                                    <input type="number" class="layui-input" name="market_price" value="{{$data->market_price}}"
                                           placeholder="上市价格">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">是否显示</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="is_show" value="1" title="是" @if($data->is_show) checked @endif>
                                    <input type="radio" name="is_show" value="0" title="否" @if($data->is_show == 0) checked @endif>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">最后:保存</h3>
                            <p>请仔细检查基本信息是否填写正确</p>
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
    }).use(['index', 'form', 'upload', 'layedit','laydate'], function () {
        var $ = layui.$
            , form = layui.form
            , upload = layui.upload
            , laydate = layui.laydate;

        laydate.render({
            elem: '.time', //指定元素
            type: "datetime",
            range: true
        });
        laydate.render({
            elem: '.time2', //指定元素
            type: "datetime",
            range: false
        });
        var id = 0;

        form.on('submit', function (data) {
            $.post('/admin/subscription/save_edit_sub', data.field, function (res) {
                layer.msg(res.msg);
                if (res.code) {
                    id = res.data.id
                    setTimeout(function () {
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
