<?php
Route::get('app_switch','Api\DefaultController@app_switch');
Route::get('st5_app','Api\DefaultController@st5_app');
Route::get('xt6_app','Api\DefaultController@xt6_app');
Route::get('tradest5_app','Api\DefaultController@tradest5_app');
Route::get('tt5_app','Api\DefaultController@tt5_app');
Route::namespace('Api')->middleware(['xss_filter'])->group(function () {
    Route::middleware(['auth_api','index_log'])->group(function () {
        // 法币交易
        Route::prefix('otc')->group(function () {
            // 商家相关操作
            Route::middleware('check_seller')->group(function () {
                Route::get('seller_currencies', 'OtcController@sellerCurrencies');           // 获取商家支持的OTC币种
                Route::post('post_master', 'OtcController@postMaster')
                    ->middleware(['tx_auth', 'real_name_auth']);     // 发布一个挂单(广告)
                Route::post('start_master', 'OtcController@startMaster');                    // 开启挂单交易
                Route::post('pause_master', 'OtcController@pauseMaster');                    // 暂停挂单交易(暂停后不会再被用户匹配)
                Route::post('cancel_master', 'OtcController@cancelMaster');                  // 撤回挂单(限挂单下没有进行中的交易)
                Route::get('seller_masters', 'OtcController@sellerMasters');                 // 商家挂单查询
                Route::get('master_details', 'OtcController@masterDetails');                 // 查挂单下所有交易明细
                Route::post('seller_currency_apply', 'SellerController@applySellerCurrency');//商家申请某币种权限
            });

            // 用户相关操作
//            Route::get('masters', 'OtcController@masters');              // 市场所有挂单
            Route::get('detail', 'OtcController@detail');                // 按id查交易
            Route::get('detail_actions', 'OtcController@detailActions'); // 交易明细状态追踪
            Route::get('user_details', 'OtcController@userDetails');     // 用户的交易明细

            Route::post('match_master', 'OtcController@matchMaster')->middleware(['tx_auth', 'real_name_auth']); // 匹配交易
            Route::post('pay', 'OtcController@pay');                  // 确认支付(须上传凭证)
            Route::post('confirm', 'OtcController@confirm');          // 确认交易
            Route::post('cancel', 'OtcController@cancel');            // 取消交易(限买家)
            Route::post('defer', 'OtcController@defer');              // 延期确认
            Route::post('arbitrate', 'OtcController@arbitrate');      //申请维权仲裁

            //商家申请
            Route::post('seller_apply', 'SellerController@applySeller');
        });


        //日志相关
        Route::prefix('account_log')->group(function () {
            Route::get('change', 'AccountLogController@change');
            Route::get('allChangeLogs', 'AccountLogController@allChangeLogs');
            Route::get('legal', 'AccountLogController@legal');
            Route::get('lever', 'AccountLogController@lever');
            Route::get('micro', 'AccountLogController@micro');
        });
        //用户实名
        Route::prefix('user_real')->group(function () {
            Route::get('center', 'UserController@userCenter');   //个人中心
            Route::post('real_name', 'UserController@realName'); //身
        });

        Route::prefix('user')->group(function () {
            Route::post('amend_pay_password', 'UserController@amendPayPassword'); //修改支付密码
            Route::post('amend_password', 'UserController@amendPassword');        //修改密码
            Route::get('info', 'UserController@info');                            //账号详情
            Route::post('logout', 'UserController@logout');                       //注销
            Route::get('getUSDTAddress', 'UserController@getUSDTAddress');
            Route::get('authorization_code', 'UserController@authCode');//添加代理商时用户的授权码
            Route::get('advert', 'UserController@advert');//获取下级


            Route::post('saveCurrencyUnit', 'UserController@saveCurrencyUnit'); // 保存用户计价单位
            Route::get('getCurrencyRate', 'UserController@getCurrencyRate'); // 获取货币汇率
            Route::get('getCurrencyList', 'UserController@getCurrencyList'); // 获取货币汇率


            Route::get('get_google_secret', 'UserController@getGoogleSecret'); // 获取谷歌认证密钥
            Route::post('bind_verify_method', 'UserController@bindVerifyMethod'); // 绑定验证方式
            Route::get('verified_info', 'UserController@verifiedInfo'); // 绑定验证方式


        });
        //用户反馈
        Route::prefix('feedback')->group(function () {
            Route::get('type', 'FeedbackController@type');          //反馈类型
            Route::get('list', 'FeedbackController@list');          //用户反馈列表
            Route::post('feedback', 'FeedbackController@feedback'); //用户反馈
        });

        Route::prefix('account')->group(function () {
            Route::post('transfer', 'AccountController@transfer');       //划转
            Route::get('transfer_log', 'AccountController@transferLog'); //划转日志

            Route::post('draw', 'AccountController@draw')
                ->middleware(['check_pay_password','real_name_auth','check_follow']);             //提币
            Route::get('draw_list', 'AccountController@drawList');//提币列表
            Route::get('detail', 'AccountController@detail');     //钱包详情
            Route::get('list', 'AccountController@list');
        });


        //币币交易买入
        Route::prefix('tx_in')->group(function () {
            Route::post('add', 'TxInController@add')->middleware(['tx_auth', 'real_name_auth','check_follow']);
            Route::get('cancel', 'TxInController@cancel');
            Route::get('detail', 'TxInController@detail');
            Route::get('list', 'TxInController@list');
        });
        //币币交易卖出
        Route::prefix('tx_out')->group(function () {
            Route::post('add', 'TxOutController@add')->middleware(['tx_auth', 'real_name_auth','check_follow']);
            Route::get('cancel', 'TxOutController@cancel');
            Route::get('detail', 'TxOutController@detail');
            Route::get('list', 'TxOutController@list');
        });
        //币币交易挂单历史
        Route::prefix('tx_history')->group(function () {
            Route::get('list', 'TxHistoryController@list');
        });
        //链上钱包
        Route::prefix('wallet')->group(function () {
            Route::get('wallets', 'WalletController@wallets');
            Route::get('wallet', 'WalletController@wallet');
        });

        Route::prefix('lever')->group(function () {
            Route::post('deal', 'LeverController@deal');                    //杠杆deal
            Route::post('dealall', 'LeverController@dealAll');              //杠杆全部
            Route::post('submit', 'LeverController@submit')->middleware(['tx_auth', 'real_name_auth','check_follow']);                //杠杆下单
            Route::post('close', 'LeverController@close')->middleware(['check_follow']);                  //杠杆平仓
            Route::post('cancel', 'LeverController@cancelTrade');           //撤销委托(取消)
            Route::post('batch_close', 'LeverController@batchCloseByType')->middleware(['check_follow']); //一键平仓
            Route::post('setstop', 'LeverController@setStopPrice');         //设置止盈止损价
            Route::post('my_trade', 'LeverController@myTrade');             //我的交易记录
        });

        // U本位合约
        Route::prefix('u_standard')->group(function () {
            Route::post('deal', 'UStandardController@deal');                    //杠杆deal
            Route::post('dealall', 'UStandardController@dealAll');              //杠杆全部
            Route::post('submit', 'UStandardController@submit');
//            Route::post('submit', 'LeverController@submit')->middleware(['tx_auth', 'real_name_auth','check_follow']);                //杠杆下单
            Route::post('close', 'UStandardController@close')->middleware(['check_follow']);                  //杠杆平仓
            Route::post('cancel', 'UStandardController@cancelTrade');           //撤销委托(取消)
            Route::post('batch_close', 'UStandardController@batchCloseByType')->middleware(['check_follow']); //一键平仓
            Route::post('setstop', 'UStandardController@setStopPrice');         //设置止盈止损价
            Route::post('my_trade', 'UStandardController@myTrade');             //我的交易记录
        });

        Route::prefix('iso_lever')->group(function () {
            Route::post('deal_setting', 'IsoLeverController@dealSetting');
            Route::post('currency_hold', 'IsoLeverController@currencyHold');
            Route::post('my_transactions', 'IsoLeverController@myTransaction');
            Route::post('submit', 'IsoLeverController@submit')->middleware(['tx_auth', 'real_name_auth','check_follow']);
            Route::post('set_stop_price', 'IsoLeverController@setStopPrice');
            Route::post('close', 'IsoLeverController@close');
            Route::post('batch_close', 'IsoLeverController@batchCloseByType');
            Route::post('cancel', 'IsoLeverController@cancel');
        });

        //交割路由
        Route::prefix('microtrade')->group(function () {
            Route::get('payable_currencies', 'MicroOrderController@getPayableCurrencies'); //可支付的币种列表
//            Route::get('seconds', 'MicroOrderController@getSeconds'); //到期时间
            Route::post('submit', 'MicroOrderController@submit'); //提交下单
//            Route::post('submit', 'MicroOrderController@submit')->middleware(['tx_auth', 'real_name_auth','check_follow']); //提交下单
            Route::get('lists', 'MicroOrderController@lists'); //下单记录
        });

        //存币生息
        Route::prefix('fund')->group(function () {
            Route::get('buy', 'FundController@buy');
            Route::get('subList', 'FundController@subList');
            Route::get('applyRefund', 'FundController@applyRefund');
            Route::get('insList', 'FundController@insList');
        });

        //申购新币
        Route::prefix('subscription')->group(function () {
            Route::get('submit', 'SubscriptionController@submit');
            Route::get('mySubList', 'SubscriptionController@mySubList');
            Route::post('getPayableCurrencies', 'SubscriptionController@getPayableCurrencies');
            Route::get('SubAccountLog', 'SubscriptionController@SubAccountLog');

        });

        //跟单
        Route::prefix('follow')->group(function () {
            Route::get('followAccount', 'FollowController@followAccount');
        });

        //期权合约下单
        Route::prefix('optionTrade')->group(function () {
            Route::post('submit', 'OptionOrderController@submit')->middleware(['tx_auth', 'real_name_auth']); //提交下单
            Route::post('history', 'OptionOrderController@history');
            Route::post('getSupportBalance', 'OptionOrderController@getSupportBalance');
        });

        //快捷冲币
        Route::prefix('quickCharge')->group(function () {
            Route::get('info', 'QuickChargeController@info');
            Route::get('submit', 'QuickChargeController@submit');

            Route::get('wire_info', 'QuickChargeController@wire_info');
            Route::get('symbols', 'QuickChargeController@symbols');
            Route::get('wire_submit', 'QuickChargeController@wire_submit');
            Route::get('quick_ist', 'QuickChargeController@quick_ist');
        });

        //兑换
        Route::prefix('exchange')->group(function () {
            Route::post('submit', 'ExchangeController@submit');
            Route::post('lastPrice', 'ExchangeController@lastPrice');
        });

        //项目
        Route::prefix('project')->group(function () {
            Route::post('submit', 'ProjectController@submit');
        });
    });

    Route::prefix('otc')->group(function () {
        Route::get('masters', 'OtcController@masters');              // 市场所有挂单 (新)
    });
    Route::get('test', 'DefaultController@test'); // 测试
    Route::get('check_login', 'DefaultController@check_login'); // 测试

    Route::prefix('microtrade')->group(function () {
        Route::get('seconds', 'MicroOrderController@getSeconds'); //到期时间
    });

    /** 无需登录的 */
    // 法币商家
    Route::prefix('otc')->group(function () {
        Route::get('currencies', 'OtcController@otcCurrencies'); // 法币列表
    });
    Route::prefix('lever')->group(function () {
        Route::get('currency_lever_matches', 'LeverController@currencyLeverMatches'); //设置
    });
    Route::prefix('common')->group(function () {
        Route::post('image_upload', 'DefaultController@imageUpload')->middleware(['throttle:10,1']);
    });
    //新闻
    Route::prefix('news')->group(function () {
        Route::get('list', 'NewsController@list');
        Route::get('info', 'NewsController@info');
        Route::get('categories', 'NewsController@categories');
    });

    Route::prefix('user')->middleware('index_log')->group(function () {
        Route::post('register', 'UserController@register');              //注册
        Route::post('login', 'UserController@login');                    //登录
        Route::post('login_for_wallet', 'UserController@loginForWallet');                    //钱包登录
        Route::post('forget_password', 'UserController@forgetPassword'); //忘记密码
    });
    Route::prefix('notify')->group(function () {
        Route::post('send_email', 'NotifyController@sendEmailCode'); //发送邮件
        Route::post('send_sms', 'NotifyController@sendSmsCode');     //发送短信
        Route::post('check_code', 'NotifyController@checkCode');     //验证吗检验
    });
    Route::prefix('default')->group(function () {
        Route::get('area_list', 'DefaultController@areaList');       //国家列表
        Route::get('lang_list', 'DefaultController@langList');       //国家列表
        Route::get('setting', 'DefaultController@setting');          //查询系统设置
        Route::get('check_update', 'DefaultController@checkUpdate'); //查询系统设置
    });
    Route::prefix('market')->group(function () {
        Route::get('quotation', 'MarketController@quotation');
        Route::get('kline', 'MarketController@kline');
        Route::get('deal', 'MarketController@deal');
        Route::get('currency_matches', 'MarketController@currencyMatches');

        //成交榜
        Route::get('currency_matches_volume', 'MarketController@currencyMatchesVolume');

        //热力榜
        Route::get('currency_matches_hot', 'MarketController@currencyMatchesHot');
    });
    //支付方式
    Route::prefix('pay_method')->group(function () {
        Route::get('methods', 'PayMethodController@methods');                   //获取用户已有支付方式列表
        Route::post('save', 'PayMethodController@saveMethod');                  //保存支付方式
        Route::get('types', 'PayMethodController@getMethodType');               //获取支付方式类型
        Route::get('get_method_by_type', 'PayMethodController@getMethodByType');//获取支付方式类型
    });
    Route::prefix('block_chain')->group(function () {
        Route::post('recharge', 'BlockChainController@apiRecharge');               //API充币接口
        Route::get('chain_protocols', 'BlockChainController@chainProtocols');      //区块链协议接口
        Route::get('currency_protocols', 'BlockChainController@currencyProtocols');//区块链协议接口
    });

    Route::post('/notice/UDunNotice','NoticeController@UDunNotice');
    Route::get('/appVersion/getAppVersionUrls','DefaultController@getAppVersionUrls');

    Route::post('/notify/createDuAddress','NotifyController@createDuAddress');

    Route::prefix('fund')->group(function () {
        Route::get('list', 'FundController@list');
        Route::get('info', 'FundController@info');
    });
    // Route::prefix('new_tx')->group(function () {
    //     Route::post('in', 'NewTxController@in')->middleware(['tx_auth', 'real_name_auth']);
    //     Route::get('in_currency', 'NewTxController@currencies');
    // });

    //生成用户地址
    Route::any("apiCreateAddress","AccountController@apiCreateAddress");

    //期权合约
    Route::prefix('option')->group(function () {

        //获取期权交易列表
        Route::post('getOptionMatches', 'OptionController@getOptionMatches');

        //获取下单时长
        Route::post('getOrderTime', 'OptionController@getOrderTime');

        //获取历史期数
        Route::post('getPeriods', 'OptionController@getPeriods');

        //获取指定状态期数
        Route::post('getChoosePeriods', 'OptionController@getChoosePeriods');

        //获取下单金额
        Route::post('getAmount', 'OptionController@getAmount');
    });

    //项目
    Route::prefix('project')->group(function () {

        //获取列表
        Route::any('getProjects', 'ProjectController@getProjects');

        //获取历史列表
        Route::any('getHistoryProjects', 'ProjectController@getHistoryProjects');

    });

    //申购新币
    Route::prefix('subscription')->group(function () {
        Route::get('subscription_list', 'SubscriptionController@subscription_list');
        Route::get('sub_info', 'SubscriptionController@sub_info');
    });
    Route::prefix('user')->group(function () {

        Route::get('get_user_info', 'UserController@get_user_info');
    });

    Route::prefix('prizes')->group(function (){
        Route::get('list','PrizesController@list');
        Route::post('submit','PrizesController@submit');
        Route::get('lottery_record','PrizesController@lotteryRecord');
    });
});

