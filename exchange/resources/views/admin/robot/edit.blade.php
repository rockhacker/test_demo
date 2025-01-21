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
        <div class="layui-card-body">

            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <input type="hidden" name="id" value="{{$robot->id}}">
                <div class="layui-timeline-content layui-text">
                    <div class="layui-form-item">
                        <label class="layui-form-label">浮点</label>
                        <div class="layui-input-block">
                            <input type="text" name="point" class="layui-input point" value="0">
{{--                            <button type="button" class="layui-btn layui-btn-primary layui-btn-sm layui-bg-green add">加0.00010</button>--}}
{{--                            <button type="button" class="layui-btn layui-btn-primary layui-btn-sm layui-bg-red minus">减0.00010</button>--}}

                        </div>
                    </div>
{{--                    按时间缓慢生效浮点--}}
{{--                    <div class="layui-form-item">--}}
{{--                        <label class="layui-form-label">生效趋势（秒）</label>--}}
{{--                        <div class="layui-input-block">--}}
{{--                            <input type="text" name="trend_second" class="layui-input" placeholder="生效趋势（秒）0秒为立即生效" value="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    调整值--}}
{{--                    <div class="layui-form-item">--}}
{{--                        <table class="layui-table" lay-size="sm"  lay-even>--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>原值</th>--}}
{{--                                <th>调整后</th>--}}
{{--                                <th>累积修正值</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            <tr>--}}
{{--                                <td>{{ $robot->price - $robot->point }}</td>--}}
{{--                                <td>{{ $robot->price }}</td>--}}
{{--                                <td>{{ $robot->point }}</td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                        生效趋势--}}

{{--                        <table class="layui-table" lay-size="sm"  lay-even>--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th>待生效值</th>--}}
{{--                                <th>时间</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @if($robot->trend_second != 0)--}}
{{--                            <tr>--}}
{{--                                <td>{{ $robot->trend_point}}</td>--}}
{{--                                <td>{{ $robot->trend_second - (time() - $robot->trend_start_time) }}</td>--}}
{{--                            </tr>--}}
{{--                            @endif--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
                    <div class="layui-form-item">
                        <label class="layui-form-label">交易对</label>
                        <div class="layui-input-block">
                            <select name="currency_match_id" id="" disabled>
                                @foreach($currency_matches as $currencyMatch)
                                    <option value="{{$currencyMatch->id}}"
                                            @if($robot->currency_match_id==$currencyMatch->id) selected @endif>{{$currencyMatch->symbol}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">模拟火币交易对</label>
                        <div class="layui-input-block">
                            <input type="text" name="virtual_symbol" class="layui-input"
                                   value="{{$robot->virtual_symbol}}" disabled>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">价格小数位数</label>
                        <div class="layui-input-block">
                            <input type="text" name="decimal" class="layui-input"
                                   value="{{$robot->decimal}}" disabled>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">是否开启</label>
                        <div class="layui-input-block">
                            <input type="radio" name="status" value="0" title="关闭"
                                   @if($robot->status==0) checked @endif disabled>
                            <input type="radio" name="status" value="1" title="开启"
                                   @if($robot->status==1) checked @endif disabled>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" lay-submit>立即提交</button>

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

        $(".add").click(function() {
            var n=$('.point').val();
            var num=(parseFloat(n)+0.0001).toFixed(5);
            if(num>20){ return;}
            $('.point').val(num);
        });
        $(".minus").click(function() {
            var n=$('.point').val();
            var num=(parseFloat(n)-0.0001).toFixed(5);
            if(num>20){ return;}
            $('.point').val(num);
        });
        form.on('submit', function (data) {

            $.post('/admin/robot/update', data.field, function (res) {
                layer.msg(res.msg);

                if (res.code) {
                    setTimeout(function () {
                        location.reload()
                    }, 1000);
                }
            });

            return false;
        })

    })
</script>
</body>
</html>
