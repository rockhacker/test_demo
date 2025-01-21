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
        <div class="layui-card-header">添加项目</div>
        <div class="layui-card-body">
            <form class="layui-form" lay-filter="layuiadmin-form-useradmin" id="layuiadmin-form-useradmin">
                <ul class="layui-timeline">
                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">第一步:填写基本信息</h3>
                            <div class="layui-form-item">
                                <label class="layui-form-label">选择货币</label>
                                <div class="layui-input-block">
                                    <select name="currency_id">
                                        @foreach($currencies as $item)
                                        <option value="{{$item->id}}">{{$item->code}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">项目标题</label>
                                <div class="layui-input-block">
                                    <input type="text" name="title" placeholder="请填写项目标题" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">项目Banner</label>
                                <div class="layui-input-block">
                                    <button type="button" class="layui-btn" id="upload">
                                        <i class="layui-icon">&#xe67c;</i>上传图片
                                    </button>
                                    <input type="hidden" id="upload-input" name="banner">
                                    <div style="margin-top: 10px">
                                        <img width="200px" id="upload-img">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">项目简介</label>
                                <div class="layui-input-block">
                                    <textarea class="layui-textarea" name="introduction" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">第二步:填写项目配置</h3>
                            <div class="layui-form-item">
                                <label class="layui-form-label">购买数量限制</label>
                                <div class="layui-input-inline">
                                    <input type="number" class="layui-input" name="min_buy_number" value="1"
                                           placeholder="最小数量">
                                </div>
                                <div class="layui-form-mid">-</div>
                                <div class="layui-input-inline">
                                    <input type="number" class="layui-input" name="max_buy_number" value="10000"
                                           placeholder="最大数量">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">总认购数量</label>
                                <div class="layui-input-inline">
                                    <input type="number" class="layui-input" name="project_number" value="100000000"
                                           placeholder="总认购数量">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">认购时间范围</label>
                                <div class="layui-input-block">
                                    <input type="text" class="layui-input time" name="range_time">
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                        <div class="layui-timeline-content layui-text">
                            <h3 class="layui-timeline-title">第三步:详细资料</h3>
                            <div class="layui-form-item">
                                <label class="layui-form-label">项目详细介绍</label>
                                <div class="layui-input-block">
                                    <textarea name="detail_introduction" id="detail_introduction_editor"
                                              style="display: none;"></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">参与条件</label>
                                <div class="layui-input-block">
                                    <textarea name="participation_conditions" id="participation_conditions_editor"
                                              style="display: none;"></textarea>
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
            , layedit = layui.layedit
            , laydate = layui.laydate;

        var detail_introduction_editor_index = layedit.build('detail_introduction_editor', {
            uploadImage: {
                url: '/admin/upload/layui_upload'
            }
        }); //建立编辑器
        var participation_conditions_editor_index = layedit.build('participation_conditions_editor', {
            uploadImage: {
                url: '/admin/upload/layui_upload'
            }
        }); //建立编辑器
        laydate.render({
            elem: '.time', //指定元素
            type: "datetime",
            range: true
        });
        var id = 0;

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

        form.on('submit', function (data) {
            data.field.detail_introduction = layedit.getContent(detail_introduction_editor_index);
            data.field.participation_conditions = layedit.getContent(participation_conditions_editor_index);
            $.post('/admin/project/save_project', data.field, function (res) {
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
