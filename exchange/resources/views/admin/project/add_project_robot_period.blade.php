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
        <div class="layui-card-header">添加日期</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <ul class="layui-timeline">

                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <div class="layui-form-item">
                                <label class="layui-form-label">时间</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input time" name="period">
                                </div>
                            </div>
                            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                                <blockquote class="layui-elem-quote">填写0.1为涨幅百分之10</blockquote>
                            </div>
                            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                                <blockquote class="layui-elem-quote">每小时可能会有0.001%偏差</blockquote>
                            </div>
                            <div style="display: flex;flex-wrap: wrap;">
                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置0-1点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number"  class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置1-2点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置2-3点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置3-4点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置4-5点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置5-6点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置6-7点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置7-8点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置8-9点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置9-10点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置10-11点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置11-12点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置12-13点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置13-14点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置14-15点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置15-16点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置16-17点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置17-18点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置18-19点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置19-20点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置20-21点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置21-22点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置22-23点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>

                                <div style="border:2px #e2e2e2 solid;margin-left: 10px;margin-bottom: 10px;text-align: center;">
                                    <span style="font-size: 18px;">设置23-24点涨幅</span>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">大概涨幅</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input change_class" name="change[]" value="0"
                                                   placeholder="大概涨幅">
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">收盘价</label>
                                        <div class="layui-input-inline">
                                            <input type="number" class="layui-input" name="day_close_price[]" value="0"
                                                   placeholder="收盘价">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </li>
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">最终结果</h3>
                            <p>总涨跌幅：<span id="res">0</span>%</p>
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
    var sum = 0;
    window.onkeyup = function(e) {
        let change = document.getElementsByClassName("change_class")
        let key
        var sum = 0;
        for(key=0;key<change.length;key++){
            sum += Number(change[key].value);
        }

        document.getElementById('res').innerHTML = sum * 100;

    }
    document.getElementById('res').innerHTML = sum
    layui.config({
        base: '/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form', 'upload', 'layedit','laydate'], function () {
        var $ = layui.$
            , form = layui.form
            , upload = layui.upload
            , layedit = layui.layedit
            , laydate = layui.laydate;

        laydate.render({
            elem: '.time', //指定元素
            type: "datetime",
            range: false,
            format: 'yyyyMMdd'

        });
        var id = 0;



        form.on('submit', function (data) {
            data.field.id = '{{$id}}';
            $.post('/admin/project/save_project_robot_period', data.field, function (res) {
                layer.msg(res.msg);
                if (res.code) {
                    id = res.data.id
                    setTimeout(function () {
                        location.reload()
                    },2000)
                }
            });

            return false;
        });

    })
</script>
</body>
</html>
