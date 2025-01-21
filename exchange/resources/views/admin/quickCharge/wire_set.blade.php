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
        <div class="layui-card-header">电汇设置</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <ul class="layui-timeline">
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
{{--                            <div class="layui-form-item">--}}
{{--                                <label class="layui-form-label">开启电汇</label>--}}
{{--                                <div class="layui-input-block">--}}
{{--                                    <div class="layui-input-inline">--}}
{{--                                        <input type="radio" name="status" value="1" title="是" checked @if(!empty($setting->status)) checked @endif >--}}
{{--                                        <input type="radio" name="status" value="0" title="否" @if(empty($setting->status)) checked @endif >--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="layui-form-item">
                                <label class="layui-form-label">银行名称</label>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input" name="bank_name" value=""
                                           placeholder="请输入银行名称">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">银行地址</label>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input" name="bank_address" value=""
                                           placeholder="请输入银行地址">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">SWIFT</label>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input" name="bank_swift" value=""
                                           placeholder="请输入SWIFT">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">收款人姓名</label>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input" name="payee_name" value=""
                                           placeholder="请输入收款人姓名">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">收款人账户</label>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input" name="payee_account" value=""
                                           placeholder="请输入收款人账户">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">收款人货币</label>
                                <div class="layui-input-block">
                                    <select name="bank_coin" id="">
                                        @foreach($symbols as $symbol)
                                            <option value="{{$symbol->id}}" >{{$symbol->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">备注</label>
                                <div class="layui-input-inline">
                                    <input type="text" class="layui-input" name="bank_remark" value=""
                                           placeholder="请输入备注">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">是否显示</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="is_show" value="1" title="是"
                                           checked>
                                    <input type="radio" name="is_show" value="0" title="否">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
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
            , upload = layui.upload;

        var id = 0;


        form.on('submit', function (data) {

            $.post('/admin/quickCharge/bank_save', data.field, function (res) {
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
