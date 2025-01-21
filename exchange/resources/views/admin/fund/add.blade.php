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
        <div class="layui-card-header">添加产品</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <ul class="layui-timeline">
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title"></h3>

                            <div class="layui-form-item">
                                <label class="layui-form-label">产品标题</label>
                                <div class="layui-input-block">
                                    <input type="text" name="title" placeholder="请填写产品的标题" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">起购金额</label>
                                <div class="layui-input-inline">
                                    <input type="number" name="staring_sub_amount" class="layui-input"
                                           value="1" placeholder="请输入起购金额">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">单笔最大金额</label>
                                <div class="layui-input-inline">
                                    <input type="number" name="max_sub_amount" class="layui-input"
                                           value="1" placeholder="请输入单笔最大金额">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">产品图片</label>
                                <div class="layui-input-block">
                                    <button type="button" class="layui-btn" id="upload">
                                        <i class="layui-icon">&#xe67c;</i>上传图片
                                    </button>
                                    <input type="hidden" id="upload-input" name="image">
                                    <div style="margin-top: 10px">
                                        <img width="200px" id="upload-img">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">币种</label>
                                <div class="layui-input-block">
                                    <select name="currency_id" id="">
                                        @foreach($currencies as $currency)
                                            <option value="{{$currency->id}}">{{$currency->code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">锁仓天数</label>
                                <div class="layui-input-block">
                                    <input type="number" name="lock_dividend_days" class="layui-input" value=""
                                           placeholder="请输入锁仓天数(整数)">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">提前赎回违约金</label>
                                <div class="layui-input-block">
                                    <input type="number" name="liquidated_damages" class="layui-input" value=""
                                           placeholder="请输入提前赎回违约金（百分之1填写1）">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">每期派息百分比(本金*百分比=息)</label>
                                <div class="layui-input-block">
                                    <input type="number" name="dividend_percentage" class="layui-input" value=""
                                           placeholder="请输入派息百分比（百分之1填写1）">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">产品简介</label>
                                <div class="layui-input-block">
                                    <textarea class="layui-textarea" name="desc" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">是否显示</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="is_show" value="1" title="是">
                                    <input type="radio" name="is_show" value="0" title="否" checked>
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
    }).use(['index', 'form', 'upload', 'laydate'], function () {
        var $ = layui.$
            , form = layui.form
            , upload = layui.upload
            , laydate = layui.laydate;
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

        laydate.render({
            elem: '#time', //指定元素
            type: "datetime",
            range: true
        });

        form.on('submit', function (data) {

            $.post('/admin/fund/add', data.field, function (res) {
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
