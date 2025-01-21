@extends('agent.layadmin')

@section('page-head')

@endsection

@section('page-content')

    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto"
                 lay-filter="layadmin-userfront-formlist">
                <form class="layui-form  layui-inline" action="">

                    <div class='layui-form-item'>
                        <div class="layui-inline">
                            <label class="layui-form-label">uid</label>
                            <div class="layui-input-block">
                                <input type="text" name="account_number" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">手机号</label>
                            <div class="layui-input-block">
                                <input type="text" name="mobile" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">邮箱</label>
                            <div class="layui-input-block">
                                <input type="text" name="email" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    </div>
                    <div class='layui-form-item'>

                        <div class="layui-inline">
                            <label class="layui-form-label">交易对</label>
                            <div class="layui-input-inline" style="width:130px;">
                            <select class="layui-select" name="currency_match_id" id="">
                                @foreach($currency_matches as $currencyMatch)
                                    <option value="{{$currencyMatch->id}}">{{$currencyMatch->symbol}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>


                        <div class="layui-inline">
                            <label class="layui-form-label">开始日期：</label>
                            <div class="layui-input-inline" style="width:120px;">
                                <input type="text" class="layui-input" id="start_time" value="" name="start_time">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">结束日期：</label>
                            <div class="layui-input-inline" style="width:120px;">
                                <input type="text" class="layui-input" id="end_time" value="" name="end_time">
                            </div>
                        </div>

                        <div class="layui-inline">
                            <button class="layui-btn" lay-submit="" lay-filter="mobile_search">
                                <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                            </button>
                        </div>

                        <div class="layui-inline" style="">
                            <div class="layui-input-inline">
                                <input type="checkbox" name="" lay-skin="switch" lay-filter="auto_refresh" lay-text="开启刷新|关闭刷新">
                            </div>
                        </div>
                    </div>

                </form>

            </div>
            <div class="layui-card-body">
                <div class="layui-carousel layadmin-backlog" style="background-color: #fff">
                    <ul class="layui-row layui-col-space10 layui-this">
                        <li class="layui-col-xs3">
                            <a href="javascript:;" class="layadmin-backlog-body"
                               style="color: #fff;background-color: #01AAED;">
                                <h3>撮合交易合计：</h3>
                                <p><cite style="color:#fff" id="sum">0.0000000</cite></p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="layui-card-body">
                <table id="demo" lay-filter="test"></table>
            </div>
        </div>
    </div>
    <script type="text/html" id="uid">
                @{{ d.user.uid }}
    </script>
    <script type="text/html" id="mobile">
                @{{ d.user.mobile }}
    </script>
    <script type="text/html" id="email">
                @{{ d.user.email }}
    </script>
    <script type="text/html" id="symbol">
                @{{ d.currency_match.symbol }}
    </script>



@endsection

@section('scripts')
    <script>

        layui.use(['table','form','laydate'], function(){
            var table = layui.table;
            var $ = layui.jquery;
            var form = layui.form;
            var laydate = layui.laydate;
            laydate.render({
                elem: '#start_time'
            });
            laydate.render({
                elem: '#end_time'
            });
            var last_order_id = 0;
            //第一个实例
            var tx_list = table.render({
                elem: '#demo'
                ,url: '/agent/tx_complete/history_list' //数据接口
                ,page: true //开启分页
                ,id:'mobileSearch'
                ,toolbar:true
                ,cols: [[ //表头
                    {field: 'id', title: 'ID', width: 90, sort: true}
                    ,{field: 'symbol', title: '交易对', templet: '#symbol'}
                    ,{field: 'uid', title: 'uid', width: 120 , templet: '#uid'}
                    ,{field: 'mobile', title: 'mobile', width: 120 , templet: '#mobile'}
                    ,{field: 'email', title: 'email', width: 120 , templet: '#email'}
                    ,{field: 'price', title: '价格', width: 120}
                    ,{field: 'number', title: '数量', width: 100}
                    ,{field: 'transacted_amount', title: '已交金额', hide:true, width: 120}
                    ,{field: 'transacted_volume', title: '已成交量', hide:true , width: 120}
                    ,{field: 'fee', title: '手续费', hide:true, width: 120}

                    ,{field: 'way_name', title: '成交方式'}
                    ,{field: 'created_at', title: '成交时间', width: 180}
                ]], done: function(res,curr){
                    $("#sum").text(res.extra_data);
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
            form.on('switch(auto_refresh)', function(data){

                if (data.elem.checked) {
                    interval = setInterval(() => {
                        // let audio = new Audio("/layuiadmin/ding.mp3")
                        // audio.play();
                        tx_list.reload({});
                    }, 5000);
                } else {
                    clearInterval(interval);
                }
            });

            //监听提交
            form.on('submit(mobile_search)', function(data){

                table.reload('mobileSearch',{
                    where: data.field,
                    page: {curr: 1}         //重新从第一页开始
                });
                return false;
            });

        });
    </script>

@endsection
