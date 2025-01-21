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
        <div class="layui-card-header">添加币种</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <div class="layui-form-item">
                    <label class="layui-form-label">币种代码</label>
                    <div class="layui-input-block">
                        <input type="text" name="code" lay-verify="code" placeholder="请输入币种code"
                               class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">是否开启交易</label>
                    <div class="layui-input-block">
                        <input type="radio" name="trade_status" value="0" title="关闭" checked>
                        <input type="radio" name="trade_status" value="1" title="开启">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">点差率</label>
                    <div class="layui-input-block">
                        <input type="text" name="forex_point_rate" lay-verify="forex_point_rate" placeholder="请输入点差率"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">手续费率</label>
                    <div class="layui-input-block">
                        <input type="text" name="forex_fee_rate" lay-verify="forex_fee_rate" placeholder="请输入手续费率"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">最小张数</label>
                    <div class="layui-input-block">
                        <input type="text" name="forex_min_cont"  placeholder="请输入最小张数"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">最大张数</label>
                    <div class="layui-input-block">
                        <input type="text" name="forex_max_cont"  placeholder="请输入最大张数"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">每张数量</label>
                    <div class="layui-input-block">
                        <input type="text" name="forex_cont_num"  placeholder="请输入每张数量"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-block">
                        <input type="text" name="sort"  placeholder="请输入排序"
                               class="layui-input" >
                    </div>
                </div>
                <ul class="layui-timeline">
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <div class="layui-form-item">
                                <label class="layui-form-label">星期天</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="market_day[0]"  id ="market_day_0"
                                           class="layui-input" >
                                </div>
                                <div class="layui-form-mid">开市时间-休市时间</div>
                            </div>

                        </div>
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <div class="layui-form-item">
                                <label class="layui-form-label">星期六</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="market_day[1]"  id ="market_day_1"
                                           class="layui-input" >
                                </div>
                                <div class="layui-form-mid">开市时间-休市时间</div>
                            </div>

                        </div>

                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <div class="layui-form-item">
                                <label class="layui-form-label">星期五</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="market_day[2]"  id ="market_day_2"
                                           class="layui-input" >
                                </div>
                                <div class="layui-form-mid">开市时间-休市时间</div>
                            </div>

                        </div>
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <div class="layui-form-item">
                                <label class="layui-form-label">星期四</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="market_day[3]"  id ="market_day_3"
                                           class="layui-input" >
                                </div>
                                <div class="layui-form-mid">开市时间-休市时间</div>
                            </div>

                        </div>
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <div class="layui-form-item">
                                <label class="layui-form-label">星期三</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="market_day[4]"  id ="market_day_4"
                                           class="layui-input" >
                                </div>
                                <div class="layui-form-mid">开市时间-休市时间</div>
                            </div>

                        </div>
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <div class="layui-form-item">
                                <label class="layui-form-label">星期二</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="market_day[5]"  id ="market_day_5"
                                           class="layui-input" >
                                </div>
                                <div class="layui-form-mid">开市时间-休市时间</div>
                            </div>

                        </div>
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <div class="layui-form-item">
                                <label class="layui-form-label">星期一</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="market_day[6]"  id ="market_day_6"
                                           class="layui-input" >
                                </div>
                                <div class="layui-form-mid">开市时间-休市时间</div>
                            </div>

                        </div>
                    </li>
                </ul>
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
    }).use(['index', 'form','laydate'], function () {
        var $ = layui.$
            , form = layui.form
            , laydate = layui.laydate
        for (i=0;i<=6; i++){
            laydate.render({
                elem: '#market_day_'+i //指定元素
                ,range:true
                ,type:"time"
                ,format: 'HH:mm:ss' //可任意组合
                ,value: '00:00:00 - 23:59:59' //参数即为：2018-08-20 20:08:08 的时间戳
            });
        }
        form.on('submit', function (data) {
            $.post('/admin/forex/trade_list/save', data.field, function (res) {
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
