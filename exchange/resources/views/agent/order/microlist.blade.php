@extends('agent.layadmin')

@section('page-head')

@endsection

@section('page-content')


    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto"
                 lay-filter="layadmin-userfront-formlist">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">ID</label>
                        <div class="layui-input-block">
                            <input type="text" name="id" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">UID</label>
                        <div class="layui-input-block">
                            <input type="text" name="uid" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">手机</label>
                        <div class="layui-input-block">
                            <input type="text" name="mobile" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">邮箱</label>
                        <div class="layui-input-block">
                            <input type="text" name="email" placeholder="请输入" autocomplete="off" class="layui-input">
                        </div>
                    </div>


                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">代理用户名</label>
                        <div class="layui-input-block">
                            <input type="text" name="agentusername" placeholder="请输入上级代理商" autocomplete="off"
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">开始日期</label>
                        <div class="layui-input-block">
                            <input type="text" name="start" id="datestart" placeholder="yyyy-MM-dd" autocomplete="off"
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">结束日期</label>
                        <div class="layui-input-block">
                            <input type="text" name="end" id="dateend" placeholder="yyyy-MM-dd" autocomplete="off"
                                   class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">交易对</label>
                        <div class="layui-input-inline" style="width:130px;">
                            <select name="match_id" id="status" lay-search>
                                <option value="0">所有</option>
                                @foreach ($matches as $match)
                                    <option value="{{$match->id}}">{{$match->symbol}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- <button class="layui-btn layui-btn-normal dao" lay-event="excel">导出表格</button> -->


                </div>
                <div class="layui-from-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">订单状态</label>
                        <div class="layui-input-block">
                            <select name="status">
                                <option value="0">不限</option>
                                <option value="1">交易中</option>
                                <option value="2">平仓中</option>
                                <option value="3">已平仓</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">交易类型</label>
                        <div class="layui-input-block">
                            <select name="type">
                                <option value="0">不限</option>
                                <option value="1">买入</option>
                                <option value="2">卖出</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-useradmin" lay-submit
                                lay-filter="LAY-user-front-search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>

                    </div>
                    <div class="layui-inline" style="">
                        <div class="layui-input-inline">
                            <input type="checkbox" name="" lay-skin="switch" lay-filter="auto_refresh" lay-text="开启刷新|关闭刷新">
                        </div>
                    </div>

                </div>
            </div>
            <div class="layui-card-body">
                <div class="layui-carousel layadmin-backlog">
                    <button class="layui-btn layuiadmin-btn-useradmin" onclick="setAllOrderEdit(1)">
                        在场订单预设盈利
                    </button>
                    <button class="layui-btn layuiadmin-btn-useradmin" onclick="setAllOrderEdit(-1)">
                        在场订单预设亏损
                    </button>
                    <button class="layui-btn layuiadmin-btn-useradmin" onclick="setAllOrderEdit(0)">
                        在场订单预设取消
                    </button>
                </div>
            </div>
            <div class="layui-card-body">
                <div class="layui-carousel layadmin-backlog" style="background-color: #fff">
                    <ul class="layui-row layui-col-space10 layui-this">
                        <li class="layui-col-xs4">
                            <a href="javascript:;" onclick="layer.tips('头寸总收益=已平仓最终盈亏', this, {tips: 3});"
                               class="layadmin-backlog-body"
                               style="color: #fff;background-color: #01AAED;">
                                <h3>头寸收益：</h3>
                                <p><cite style="color:#fff" id="toucun">0</cite></p>
                            </a>
                        </li>
                        <li class="layui-col-xs4">
                            <a href="javascript:;" onclick="layer.tips('手续费', this, {tips: 3});"
                               class="layadmin-backlog-body"
                               style="color: #fff;background-color: #01AAED;">
                                <h3>手续费</h3>
                                <p><cite style="color:#fff" id="fee">0</cite></p>
                            </a>
                        </li>
                        <li class="layui-col-xs4">
                            <a href="javascript:;" onclick="layer.tips('订单总量', this, {tips: 3});"
                               class="layadmin-backlog-body"
                               style="color: #fff;background-color: #01AAED;">
                                <h3>订单总量</h3>
                                <p><cite style="color:#fff" id="num">0</cite></p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="layui-card-body">
                <table id="LAY-user-manage" lay-filter="LAY-user-manage"></table>
            </div>

        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/html" id="barDemo">
        @{{d.status==1 ? '<a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="edit">预设盈亏</a>' : '' }}
    </script>
    <script type="text/html" id="lockTpl">
        @{{#  if(d.type == 1){ }}
        <span class="layui-badge layui-bg-red">买入</span>
        @{{#  } else { }}
        <span class="layui-badge layui-bg-blue">卖出</span>
        @{{#  } }}
    </script>
    <script type="text/html" id="addsonTpl">
        @{{#  if(d.status == 1){ }}
        <i class="layui-icon layui-icon-rate-half" style="font-size: 16px; color: #FFB800;">交易中</i>
        @{{#  } else if(d.status == 2) { }}
        <i class="layui-icon layui-icon-refresh-3" style="font-size: 16px; color: red;">平仓中</i>
        @{{#  } else if(d.status == 3) { }}
        <i class="layui-icon layui-icon-rate-solid" style="font-size: 16px; color: #009688;">已平仓</i>
        @{{#  } }}
    </script>

    <script>

        function setAllOrderEdit(type){
            var risk = type
            layui.use("layer",function(){
                let $ = layui.$
                    , layer = layui.layer
                    , table = layui.table
                $.ajax({
                    type: "POST",
                    url: "/agent/order/micro_order_all_rick",
                    dataType: "json",
                    data: {risk: risk},
                    success: function (result) {
                        layer.msg(result.msg)
                        table.reload('LAY-user-manage');
                    }
                });

            })
        }

        layui.use(['index', 'element', 'form', 'table', 'layer', 'laydate'], function () {
            var $ = layui.$
                , element = layui.element
                , layer = layui.layer
                , table = layui.table
                , laydate = layui.laydate
                , form = layui.form
                , admin = layui.admin


            //日期
            laydate.render({
                elem: '#datestart'
            });
            laydate.render({
                elem: '#dateend'
            });
            var last_order_id = 0;
            //订单管理
            var micro_list = table.render({
                elem: '#LAY-user-manage'
                , method: 'get'
                , url: '/agent/order/micro_list'
                , cols: [[
                    {field: 'id', width: 100, title: 'id', sort: true}
                    , {field: 'uid', title: 'UID', minWidth: 150}
                    , {field: 'mobile', title: '手机号', minWidth: 150}
                    , {field: 'email', title: '邮箱', minWidth: 150}
                    , {field: 'parent_agent_name', title: '所属代理商', width: 120}
                    , {field: 'user_agent_level', title: '用户等级', width: 100}
                    , {field: 'type', title: '交易类型', width: 90, templet: '#lockTpl'}
                    , {field: 'symbol', title: '交易对', width: 100}
                    , {field: 'status', title: '当前状态', sort: true, width: 110, templet: '#addsonTpl'}
                    , {field: 'pre_profit_result_name', title: '预设', width: 90, sort: true}
                    , {field: 'open_price', title: '开仓价', width: 120}
                    , {field: 'end_price', title: '平仓价', width: 120}
                    , {field: 'fact_profits', title: '最终盈亏', width: 120}
                    , {field: 'number', title: '下单数量', sort: true, width: 90}
                    , {field: 'fee', title: '手续费', sort: true, width: 90}
                    , {field: 'created_at', title: '创建时间', width: 170}
                    , {field: 'handled_at', title: '平仓时间', sort: true, width: 170}
                    , {field: 'complete_at', title: '完成时间', width: 170}
                    , {fixed: 'right', title: '操作', width: 100, align: 'center', toolbar: '#barDemo'}
                ]]
                , page: true
                , height: 'full-320'
                , toolbar: true
                , limits: [10, 20, 50, 100, 200, 500, 1000]
                , text: '对不起，加载出现异常！'
                , done: function (res, curr, count) {
                    $("#num").html(res.extra_data.order_total);
                    $("#toucun").html(res.extra_data.toucun);
                    $("#fee").html(res.extra_data.fee);

                    //第一页
                    if (curr === 1 && last_order_id !== 0){

                        if (last_order_id !== res.data[0].id){

                            let audio = new Audio("/layuiadmin/ding.mp3")
                            audio.play();
                        }

                        last_order_id = res.data[0].id
                    }else{
                        if(curr === 1){

                            last_order_id = res.data[0].id
                        }
                    }
                }
            });


            //监听搜索
            form.on('submit(LAY-user-front-search)', function (data) {
                var field = data.field;

                //执行重载
                table.reload('LAY-user-manage', {
                    where: field
                    , page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    , done: function (res) { //这里要说明一下：done 是只有 response 的 code 正常才会执行。而 succese 则是只要 http 为 200 就会执行

                        if (res.code === 1) {
                            layer.msg(res.msg, {icon: 5});
                        }
                    }
                });
            });


            //监听工具条
            table.on('tool(LAY-user-manage)', function (obj) {
                var data = obj.data;

                if (obj.event === 'getsons') {
                    // console.log('data');
                    // console.log(data);

                    $.ajax({
                        type: "GET",
                        url: "/agent/order/get_order_account",
                        dataType: "json",
                        data: {username: data.account},
                        success: function (result) {
                            console.log(result);
                            if (result.code == 1) {
                                $("#all").html(result.data._all);
                                $("#toucun").html(result.data._toucun);
                                $("#shouxu").html(result.data._shouxu);
                                $("#num").html(result.data._num);

                                $("#lock").html(result.data._lock);
                            } else {
                                alert(result.msg)
                            }
                        }
                    });


                    //执行重载
                    table.reload('LAY-user-manage', {
                        where: {
                            username: data.account
                        }
                        , page: {
                            curr: 1 //重新从第 1 页开始
                        }
                        , done: function (res) { //这里要说明一下：done 是只有 response 的 code 正常才会执行。而 succese 则是只要 http 为 200 就会执行

                        }
                    });
                } else if (obj.event === 'edit') {
                    layer.open({
                        type: 2,
                        title: '编辑交易',
                        area: ['400px', '300px'],
                        content: '/agent/order/micro_order_edit?id=' + data.id,
                        end: function () {
                            table.reload('LAY-user-manage');
                        }
                    });
                }
            });

            form.on('switch(auto_refresh)', function(data){

                if (data.elem.checked) {
                    interval = setInterval(() => {


                        micro_list.reload({});


                    }, 5000);
                } else {
                    clearInterval(interval);
                }
            });

            form.render(null, 'layadmin-userfront-formlist');


            $('.dao').click(function () {
                var id = $('input[name="id"]').val();
                var username = $('input[name="username"]').val();
                var agentusername = $('input[name="agentusername"]').val();
                var start = $('input[name="start"]').val();
                var end = $('input[name="end"]').val();
                var status = $("select[name='status']").val();
                var type = $("select[name='type']").val();
                var legal_id = $("select[name='legal_id']").val();

                var url = '/agent/order/order_excel?id=' + id + '&username=' + username + '&agentusername=' + agentusername + '&start=' + start + '&end=' + end + '&status=' + status + '&type=' + type + '&legal_id=' + legal_id;
                window.open(url);


            })


        });

    </script>
@endsection
