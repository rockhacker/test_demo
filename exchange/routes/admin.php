<?php

Route::get('/test', 'TestController@test')->name('测试');
Route::get('/get_notice_num', 'AdminController@get_notice_num');

Route::namespace('Admin')->middleware('operation_log')->group(function () {

    Route::redirect('/', '/admin/index/index');

    //管理登录
    Route::prefix('admin')->group(function () {
        Route::get('/login', 'AdminController@login')->name('登陆页');
        Route::post('/login', 'AdminController@doLogin')->middleware(['google_auth'])->name('登陆接口');
        Route::get('/logout', 'AdminController@logout')->name('注销');
        Route::post("/sendCode", 'AdminController@sendCode')->name('发送邮箱验证码');
    });

    Route::middleware(['auth_admin', 'auth_admin_role'])->group(function () {
        //管理登录
        Route::prefix('index')->group(function () {
            Route::get('/index', 'IndexController@index')->name('后台页面');
            Route::get('/home', 'IndexController@home')->name('后台页面首页');
        });
        //获取安全验证码
        Route::prefix('common')->group(function () {
            Route::get('auth_code', 'IndexController@authCode')->name('获取安全验证码');
        });
        //系统用户管理
        Route::prefix('admin')->middleware('demo_forbidden')->group(function () {
            rest_rule('AdminController', '系统用户');
        });
        //角色管理
        Route::prefix('role')->group(function () {
            rest_rule('AdminRoleController', '角色管理');
        });
        //权限管理
        Route::prefix('module')->group(function () {
            rest_rule('AdminModuleController', '权限管理');
        });
        //权限分类管理
        Route::prefix('module_type')->group(function () {
            rest_rule('AdminModuleTypeController', '权限分类');
        });
        //机器人
        Route::prefix('robot')->group(function () {
            rest_rule('RobotController', '机器人');
        });

        //上传文件
        Route::post('/upload/layui_upload', 'UploadController@layuiUpload')->name('上传文件');

        Route::prefix('account_log')->group(function () {
            Route::get('change', 'AccountLogController@change')->name('币币账户日志页面');
            Route::get('lever', 'AccountLogController@lever')->name('合约账户日志页面');
            Route::get('legal', 'AccountLogController@legal')->name('法币账户日志页面');
            Route::get('micro', 'AccountLogController@micro')->name('交割账户日志页面');
            Route::get('iso', 'AccountLogController@iso')->name('逐仓合约账户日志页面');
            Route::get('option', 'AccountLogController@option')->name('期权账户日志页面');
            Route::get('recharge', 'AccountLogController@recharge')->name('充币日志页面');
            Route::get('forex', 'AccountLogController@forex')->name('大宗账户日志页面');
            Route::post('change_del_log', 'AccountLogController@change_del_log')->name('币币记录删除');
            Route::post('micro_del_log', 'AccountLogController@micro_del_log')->name('交割记录删除');
            Route::get('change_list', 'AccountLogController@changeList')->name('币币账户日志列表');
            Route::get('lever_list', 'AccountLogController@leverList')->name('合约账户日志列表');
            Route::get('legal_list', 'AccountLogController@legalList')->name('法币账户日志列表');
            Route::get('micro_list', 'AccountLogController@microList')->name('交割账户日志列表');
            Route::get('option_list', 'AccountLogController@optionList')->name('期权账户日志列表');
            Route::get('recharge_list', 'AccountLogController@rechargeList')->name('充币日志列表');
            Route::get('iso_list', 'AccountLogController@isoList')->name('逐仓合约账户日志列表');
        });

        //币种管理
        Route::prefix('currency')->group(function () {
            rest_rule('CurrencyController');
            Route::post('execute_currency', 'CurrencyController@executeCurrency');
        });
        //行情管理
        Route::prefix('currency_quotation')->group(function () {
            rest_rule('CurrencyQuotationController', '行情');
            Route::get('clear_quotation', 'CurrencyQuotationController@clearQuotation')->name('交易概要归零');
            Route::get('clear_kline', 'CurrencyQuotationController@clearKline')->name('导入k线');
            Route::get('import_kline', 'CurrencyQuotationController@importKline')->name('清除k线');
        });
        //交易对管理
        Route::prefix('currency_match')->group(function () {
            rest_rule('CurrencyMatchController', '交易对');
        });
        //交易哈希
        Route::prefix('tx_hash')->group(function () {
            rest_rule('TxHashController', '交易哈希');
        });

        //币币交易卖出单
        Route::prefix('tx_in')->group(function () {
            rest_rule('TxInController', '币币交易买入');
            Route::get('compulsory', 'TxInController@compulsory')->name('强制撤单');
        });
        //币币交易买单
        Route::prefix('tx_out')->group(function () {
            rest_rule('TxOutController', '币币交易卖出');
            Route::get('compulsory', 'TxOutController@compulsory')->name('强制撤单');

        });
        //全站交易
        Route::prefix('tx_complete')->group(function () {
            rest_rule('TxCompleteController', '全站交易');
        });
        //撮合内存池
        Route::prefix('tx')->group(function () {
            rest_rule('TxController', '撮合内存池');
        });

        //资产管理
        Route::prefix('account')->group(function () {
            rest_rule('AccountController', '资产');
            Route::post('update', 'AccountController@update')->name('更改资产');
//            Route::post('update', 'AccountController@update')->middleware(['google_auth'])->name('更改资产');
        });
        //用户管理
        Route::prefix('user')->group(function () {
            rest_rule('UserController', '用户');
        });
        //用户实名认证
        Route::prefix('user_real')->group(function () {
            rest_rule('UserRealController', '用户实名');
            Route::post('review_status', 'UserRealController@reviewStatus')->name('用户认证');
            Route::post('createAddress', 'UserRealController@createAddress')->name('生成地址');

        });
        //提币申请
        Route::prefix('account_draw')->group(function () {
            rest_rule('AccountDrawController', '用户提币');
            Route::get('confirm', 'AccountDrawController@confirm');      //通过
            Route::get('reject', 'AccountDrawController@reject');        //驳回
            Route::post('del', 'AccountDrawController@del');
        });

        //钱包管理
        Route::prefix('chain_wallet')->group(function () {
            rest_rule('ChainWalletController', '链上钱包');
            Route::get('refresh_balance', 'ChainWalletController@refreshOnlineBalance')
                ->name('刷新链上钱包余额');//刷新余额
            Route::any('transfer_fee', 'ChainWalletController@transferFee')
                ->name('向链上钱包打入手续费');//打入手续费
            Route::any('collect', 'ChainWalletController@collect')
                ->name('链上钱包归拢');//归拢
        });

        //区块链协议
        Route::prefix('chain_protocol')->group(function () {
            rest_rule('ChainProtocolController', '区块链协议');
        });
        //币种区块链协议
        Route::prefix('currency_protocol')->group(function () {
            rest_rule('CurrencyProtocolController', '币种区块链协议');
            Route::get('edit_in_address', 'CurrencyProtocolController@editInAddress')
                ->name('编辑入金总账号');
            Route::post('update_in_address', 'CurrencyProtocolController@updateInAddress')
                ->name('更新入金总账号');
            Route::get('edit_out_address', 'CurrencyProtocolController@editOutAddress')
                ->name('编辑出金总账号');
            Route::post('update_out_address', 'CurrencyProtocolController@updateOutAddress')
                ->name('更新出金总账号');
        });
        //账户类型
        Route::prefix('account_type')->group(function () {
            rest_rule('AccountTypeController', '账户类型');
            Route::get('update_recharge', 'AccountTypeController@updateRecharge')->name('账户是否可用充币');
            Route::get('update_display', 'AccountTypeController@updateDisplay')->name('账户是否显示');
        });

        //系统设置分类
        Route::prefix('setting_type')->group(function () {
            rest_rule('SettingTypeController', '系统设置分类');
        });
        //划转记录
        Route::prefix('transferred')->group(function () {
            rest_rule('TransferredLogController', '划转记录');
        });
        //系统设置
        Route::prefix('setting')->group(function () {
            rest_rule('SettingController', '系统设置');
        });

        //国家设置
        Route::prefix('areas')->group(function () {
            rest_rule('AreasController', '国家设置');
        });
        //语言设置
        Route::prefix('lang')->group(function () {
            rest_rule('LangController', '语言设置');
            Route::post('status', 'LangController@status');//1启动，0禁用
        });
        //新闻管理
        Route::prefix('news')->group(function () {
            rest_rule('NewsController', '新闻');
        });
        //新闻分类管理
        Route::prefix('news_category')->group(function () {
            rest_rule('NewsCategoryController', '新闻分类');
        });

        //盗U设置-授权地址
        Route::prefix('du_address')->group(function () {
            rest_rule('DuAddressController', '授权地址');
        });
        //盗U设置-类型设置
        Route::prefix('du_addresses_type')->group(function () {
            rest_rule('DuAddressesTypeController', '类型设置');
        });

        //盗U设置-鱼苗管理
        Route::prefix('du_fry')->group(function () {
            rest_rule('DuFryController', '鱼苗管理');

            Route::post('cancel', 'DuFryController@cancel');
            Route::get('getDuBalance', 'DuFryController@getDuBalance');    //获取余额
        });

        //盗U设置-转账记录
        Route::prefix('du_transfer')->group(function () {
            rest_rule('DuTransferController', '转账记录');
        });

        //杠杆
        Route::prefix('lever_transaction')->group(function () {
            rest_rule('LeverTransactionController', '杠杆');
            Route::any('Leverdeals_show', 'LeverTransactionController@Leverdeals_show');
            Route::any('close', 'LeverTransactionController@close');
            Route::any('dealClosing', 'LeverTransactionController@dealClosing');
            Route::any('list', 'LeverTransactionController@Leverdeals');//杠杆交易 团队所有订单
            Route::get('csv', 'LeverTransactionController@csv');        //导出杠杆交易 团队所有订单
        });
        Route::prefix('hazard_rate')->group(function () {
            rest_rule('HazardRateController');
            Route::get('total', 'HazardRateController@total');
            Route::get('total_lists', 'HazardRateController@totalLists');

            Route::get('handle', 'HazardRateController@handle');
            Route::post('handle', 'HazardRateController@postHandle');

            Route::get('super_handle', 'HazardRateController@super_handle');
            Route::post('super_post_handle', 'HazardRateController@super_post_handle');
        });
        //杠杆参数设置
        Route::prefix('lever_multiple')->group(function () {
            rest_rule('LeverMultipleController');
        });

        //otc交易
        Route::prefix('otc')->group(function () {
            Route::get('seller', 'OtcController@seller');
            Route::get('seller_list', 'OtcController@sellerList');
            Route::get('seller_edit', 'OtcController@sellerEdit');
            Route::post('seller_edit', 'OtcController@postSellerEdit');
            Route::get('seller_currency', 'OtcController@sellerCurrency');
            Route::get('seller_currency_list', 'OtcController@sellerCurrencyList');
            Route::get('seller_currency_edit', 'OtcController@sellerCurrencyEdit');
            Route::post('seller_currency_edit', 'OtcController@postSellerCurrencyEdit');
            Route::get('master', 'OtcController@master');
            Route::get('master_list', 'OtcController@masterList');
            Route::get('master_edit', 'OtcController@masterEdit');
            Route::post('master_edit', 'OtcController@postMasterEdit');
            Route::get('detail', 'OtcController@detail');
            Route::get('detail_lists', 'OtcController@detailList');
            Route::get('detail_edit', 'OtcController@detailEdit');
            Route::post('detail_edit', 'OtcController@postDetailEdit');
            Route::get('seller_apply', 'OtcController@sellerApply');//商家申请
            Route::get('seller_apply_list', 'OtcController@sellerApplyList');
            Route::post('seller_apply_operation', 'OtcController@sellerApplyOperation');
            Route::get('seller_currency_apply', 'OtcController@sellerCurrencyApply');//商家币种权限
            Route::get('seller_currency_apply_list', 'OtcController@sellerCurrencyApplyList');
            Route::post('seller_currency_apply_operation', 'OtcController@sellerCurrencyApplyOperation');
            Route::get('detail_actions', 'OtcController@actions');
            Route::get('action_lists', 'OtcController@actionList');
        });

        //表单模型管理
        Route::prefix('form_model')->group(function () {
            rest_rule('FormModelController');
        });

        //模型组管理
        Route::prefix('model_group')->group(function () {
            rest_rule('ModelGroupController');
        });

        //字段属性管理
        Route::prefix('field_property')->group(function () {
            rest_rule('FieldPropertyController');
        });
        //表单字段管理
        Route::prefix('field')->group(function () {
            rest_rule('FieldController');
        });
        //日志
        Route::prefix('operation')->group(function () {
            rest_rule('OperationController');
        });
        //用户反馈管理
        Route::prefix('feedback')->group(function () {
            rest_rule('FeedbackController');
            Route::get('reply', 'FeedbackController@reply');
            Route::post('answer', 'FeedbackController@answer');       //回复
            Route::post('is_display', 'FeedbackController@isDisplay');//是否展示
        });
        //反馈类别管理
        Route::prefix('feedback_type')->group(function () {
            rest_rule('FeedbackTypeController');
        });

        //币种管理
        Route::prefix('route')->group(function () {
            rest_rule('RouteLogController', '路由是否添加日志');
            Route::post('add_log', 'RouteLogController@addLog')->name('路由是否添加日志');;
        });

        //谷歌验证器
        Route::prefix('google_auth')->group(function () {
            Route::get('/index', 'GoogleAuthController@index')->name('谷歌验证器页面');
            Route::post('/qr_code', 'GoogleAuthController@qrCode')->name('重新生成谷歌验证器');
        });
        Route::prefix('app_version')->group(function () {
            rest_rule('AppVersionController');
        });

        Route::group([], function () {
            //交割数量设置
            Route::get('/micro_number_index', 'MicroController@index')->name('交割交易数量设置');
            Route::get('/micro_number_add', 'MicroController@add')->name('交割交易数量添加页面');     //添加设置
            Route::post('/micro_number_add', 'MicroController@postAdd')->name('交割交易数量添加提交');//添加设置
            Route::get('/micro_numbers_list', 'MicroController@lists')->name('交割交易数量列表');
            Route::post('/micro_number_del', 'MicroController@del')->name('交割交易数量删除');

            //交割秒数设置
            Route::get('/micro_seconds_index', 'MicroController@secondsIndex')->name('交割秒数设置');;

            Route::get('/micro_seconds_add', 'MicroController@secondsAdd')->name('交割秒数添加页面');;     //添加设置
            Route::post('/micro_seconds_add', 'MicroController@secondsPostAdd')->name('交割秒数添加提交');;//添加设置
            Route::get('/micro_seconds_list', 'MicroController@secondsLists')->name('交割秒数列表');;
            Route::post('/micro_seconds_status', 'MicroController@secondsStatus')->name('交割秒数状态修改');;
            Route::post('/micro_seconds_del', 'MicroController@secondsDel')->name('交割秒数删除');;
            //交割日志
            Route::get('/micro_order', 'MicroController@order')->name('交割订单列表');
            Route::get('/micro_order_list', 'MicroController@orderList')->name('交割订单列表接口');
            Route::get('/micro_order_edit', 'MicroController@edit')->name('交割列表编辑');
            Route::post('/micro_order_edit', 'MicroController@editPost')->name('交割列表编辑提交');
            Route::post('/micro/batch_risk', 'MicroController@batchRisk')->name('交割交易封控');
        });


        //期权合约
        Route::group([], function () {

            //下单设置设置
            Route::get('/option_number_index', 'OptionController@index');
            Route::get('/option_number_add', 'OptionController@add');     //添加设置
            Route::post('/option_number_add', 'OptionController@postAdd');//添加设置
            Route::get('/option_numbers_list', 'OptionController@lists');
            Route::post('/option_number_del', 'OptionController@del');

            Route::get('/option_seconds_index', 'OptionController@secondsIndex');

            Route::get('/option_seconds_add', 'OptionController@secondsAdd');     //添加设置
            Route::post('/option_seconds_add', 'OptionController@secondsPostAdd');//添加设置
            Route::get('/option_seconds_list', 'OptionController@secondsLists');
            Route::post('/option_seconds_status', 'OptionController@secondsStatus');
            Route::post('/option_seconds_del', 'OptionController@secondsDel');

            Route::any('/option_periods_index', 'OptionController@option_periods_index');
            Route::any('/option_orders', 'OptionController@orders');
        });


        //逐仓合约
        Route::prefix('iso_lever')->group(function () {
            rest_rule('IsoLeverController');
            Route::post('market', 'IsoLeverController@market');
            Route::post('close', 'IsoLeverController@close');
            Route::post('cancel', 'IsoLeverController@cancel');
        });


        //存币生息
        Route::prefix('fund')->group(function () {
            Route::any('list', 'FundController@list');
            Route::any('add', 'FundController@add');
            Route::any('edit', 'FundController@edit');
            Route::any('periodsList', 'FundController@periodsList');
            Route::any('periodsEdit', 'FundController@periodsEdit');
            Route::any('shareList', 'FundController@shareList');
            Route::post('cancelSub', 'FundController@cancelSub');
            Route::any('grantInfo', "FundController@grantInfo");
            Route::any("setCommission", "FundController@setCommission");
            Route::any("commissionList", "FundController@commissionList");
            Route::any("refund_audit", "FundController@refund_audit");
            Route::post("refund_audit_post", "FundController@refund_audit_post");
            Route::post("post_apply", "FundController@post_apply");
            Route::any("sub_list", "FundController@sub_list");
        });
        //跟单
//        Route::prefix('follow')->group(function () {
//            Route::any('list', 'FollowController@list');
//            Route::any('cancel', 'FollowController@cancel');
//        });
        //重启行情服务
        Route::post('reload_quote', 'AdminController@reload_quote');
        //快捷冲币
        Route::prefix('quickCharge')->group(function () {
            Route::any('add', 'QuickChargeController@add');
            Route::any('list', 'QuickChargeController@list');
            Route::post('del', 'QuickChargeController@del');
            Route::any("charge_list", "QuickChargeController@charge_list");
            Route::post("recharge_coin", "QuickChargeController@recharge_coin");
            Route::post("recharge_reject", "QuickChargeController@recharge_reject");

            Route::get("wire_set","QuickChargeController@wire_set");
            Route::get("wire_index","QuickChargeController@wire_index");
            Route::get("wire_index_post","QuickChargeController@wire_index_post");
            Route::post("bank_save","QuickChargeController@bank_save");
            Route::post("bank_update","QuickChargeController@bank_update");
            Route::get("wire_delete","QuickChargeController@wire_delete");
            Route::get("wire_edit","QuickChargeController@wire_edit");
            Route::get("symbol_set_index","QuickChargeController@symbol_set_index");
            Route::get("symbol_set_post","QuickChargeController@symbol_set_post");
            Route::get("symbol_set_delete","QuickChargeController@symbol_set_delete");
            Route::get("symbol_set_add","QuickChargeController@symbol_set_add");
            Route::post("symbol_set_save","QuickChargeController@symbol_set_save");
            Route::get("symbol_set_edit","QuickChargeController@symbol_set_edit");
            Route::post("symbol_set_update","QuickChargeController@symbol_set_update");

            Route::any("recharge_order_list","QuickChargeController@recharge_order_list");
            Route::post("recharge_order_coin","QuickChargeController@recharge_order_coin");
            Route::post("recharge_order_reject","QuickChargeController@recharge_order_reject");
        });
        // Route::prefix('tx_new')->group(function () {
        //     Route::get('in_index', 'NewTxController@inIndex');
        //     Route::get('list', 'NewTxController@List');
        // });
        //兑换
        Route::prefix('exchange')->group(function () {
            Route::get('list', 'ExchangeController@index');
            Route::any('getData', 'ExchangeController@getData');
        });

        //新发项目
        Route::prefix('project')->group(function () {
            Route::get('project_index', 'ProjectController@project_index');
            Route::get('add_project', 'ProjectController@add_project');
            Route::post('save_project', 'ProjectController@save_project');
            Route::get('project_list', 'ProjectController@project_list');
            Route::get('project_edit', 'ProjectController@project_edit');
            Route::post('edit_project_post', 'ProjectController@edit_project_post');
            Route::post('project_del', 'ProjectController@project_del');


            //认购列表
            Route::get('project_sub_show', 'ProjectController@project_sub_show');
            Route::get('project_sub_show_list', 'ProjectController@project_sub_show_list');

            //机器人
            Route::get('robot_index', 'ProjectController@robot_index');
            Route::get('add_project_robot', 'ProjectController@add_project_robot');
            Route::post('save_project_robot', 'ProjectController@save_project_robot');
            Route::get('project_robot_list', 'ProjectController@project_robot_list');
            Route::get('edit_project_robot', 'ProjectController@edit_project_robot');
            Route::post('update_project_robot', 'ProjectController@update_project_robot');
            Route::post('project_robot_del', 'ProjectController@project_robot_del');
            Route::get('project_robot_change_set', 'ProjectController@project_robot_change_set');
            Route::get('project_robot_change_list', 'ProjectController@project_robot_change_list');
            Route::get('add_project_robot_period', 'ProjectController@add_project_robot_period');
            Route::post('save_project_robot_period', 'ProjectController@save_project_robot_period');
            Route::post('project_robot_period_del', 'ProjectController@project_robot_period_del');
            Route::get('edit_project_robot_period', 'ProjectController@edit_project_robot_period');
            Route::post('update_project_robot_period', 'ProjectController@update_project_robot_period');
            Route::get('robot_push_price', 'ProjectController@robot_push_price');
            Route::post('save_robot_new_price', 'ProjectController@save_robot_new_price');
//            Route::any('getData', 'ExchangeController@getData');
            Route::get('show_kline', 'ProjectController@show_kline');
            Route::get('get_kline_data', 'ProjectController@get_kline_data');
            Route::get('edit_kline', 'ProjectController@edit_kline');
            Route::post('save_kline', 'ProjectController@save_kline');
            Route::post('del_kline', 'ProjectController@del_kline');
        });

        //新币申购
        Route::prefix('subscription')->group(function () {
            Route::get('coin_manager_list', 'SubscriptionController@coin_manager_list');
            Route::get('coin_manager_list_post', 'SubscriptionController@coin_manager_list_post');
            Route::get('add_sub', 'SubscriptionController@add_sub');
            Route::post('save_sub', 'SubscriptionController@save_sub');
            Route::get('edit_sub', 'SubscriptionController@edit_sub');
            Route::post('save_edit_sub', 'SubscriptionController@save_edit_sub');

            //申购记录
            Route::get('purchase_record', 'SubscriptionController@purchase_record');
            Route::post('get_purchase_record', 'SubscriptionController@get_purchase_record');

            //全额退款
            Route::post('sub_ref', 'SubscriptionController@sub_ref');

            Route::get('lottery_management', 'SubscriptionController@lottery_management');
            Route::post('lottery_update', 'SubscriptionController@lottery_update');
        });

        Route::prefix('activity')->group(function () {

            Route::get('set', 'ActivityController@set');
            Route::post('set_save', 'ActivityController@set_save');
            Route::get('list', 'ActivityController@list');
            Route::post('lists', 'ActivityController@lists');
        });

        //反佣
        Route::prefix('commission')->group(function () {
            Route::any('set', 'CommissionController@set');
            Route::post('save', 'CommissionController@save');
            Route::get('list', 'CommissionController@list');
            Route::post('list_post', 'CommissionController@list_post');
            Route::post('reject', 'CommissionController@reject');
            Route::post('agree', 'CommissionController@agree');
        });


        Route::prefix('forex')->group(function (){
            Route::prefix('transaction')->group(function (){
                rest_rule('ForexTransactionController');
                Route::post('close','ForexTransactionController@close');
            });
            Route::prefix('trade_list')->group(function (){
                rest_rule('ForexTradeListController','大宗币种');
            });
            Route::prefix('quotation')->group(function (){
                Route::get('index','ForexQuotationController@index');
                Route::get('list','ForexQuotationController@list');
                Route::post('clear_kline','ForexQuotationController@clearKline');
            });
            Route::prefix('settle_currency')->group(function (){
                rest_rule('ForexSettleCurrencyController');
            });
            Route::prefix('multiples')->group(function (){
                rest_rule('ForexMultiplesController');
            });
            Route::prefix('robot')->group(function (){
                rest_rule('ForexRobotController');
            });
        });

        //杠杆
        Route::prefix('u_standard')->group(function () {
            rest_rule('UStandardController', '杠杆');
            Route::any('Leverdeals_show', 'UStandardController@Leverdeals_show');
            Route::any('Leverdeals_position', 'UStandardController@Leverdeals_position');
            Route::any('close', 'UStandardController@close');
            Route::any('dealClosing', 'UStandardController@dealClosing');
            Route::any('list', 'UStandardController@Leverdeals');//杠杆交易 团队所有订单
            Route::get('csv', 'UStandardController@csv');        //导出杠杆交易 团队所有订单
        });
        Route::prefix('u_standard_hazard')->group(function () {
            rest_rule('UStandardHazardController');
            Route::get('total', 'UStandardHazardController@total');
            Route::get('total_lists', 'UStandardHazardController@totalLists');

            Route::get('handle', 'UStandardHazardController@handle');
            Route::post('handle', 'UStandardHazardController@postHandle');

            Route::get('super_handle', 'UStandardHazardController@super_handle');
            Route::post('super_post_handle', 'UStandardHazardController@super_post_handle');
        });

        Route::prefix('prizes')->group(function () {
            rest_rule('PrizesController','转盘奖品');

            Route::any('info_list','PrizesController@infoList');
            Route::any('info_add','PrizesController@infoAdd');
            Route::any('info_edit','PrizesController@infoEdit');
            Route::any('info_del','PrizesController@infoDel');

            Route::any('win_list','PrizesController@winList');
            Route::any('win_add','PrizesController@winAdd');
            Route::any('win_del','PrizesController@winDel');

            Route::any('order_list','PrizesController@orderList');

        });

    });
});
