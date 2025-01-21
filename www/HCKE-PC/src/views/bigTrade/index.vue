<template>
  <div class="w100 baselight">
    <div class="flex mt5 vh0" style="min-height: 800px;">
      <!-- 左侧行情 -->
      <div class="wt240 bd mr5 bgpart ptb10 radius2 h0">
        <div class="flex alcenter plr10">
          {{$t('new.realime')}}
          <!-- <div
            class="plr5 ht25 lh25 tc ft12 radius2 mr10 pointer"
            :class="{ 'bgblue txtwhite': currentIndex == i }"
            v-for="(item, i) in list"
            :key="item.id"
            @click="changelegal(i)"
          >
            {{ item.code }}
          </div> -->
        </div>
        <div class="flex alcenter mt10 mb10">
          <span class="flex1 pl10">{{ $t("trade.currency") }}</span>
          <span class="flex1 tr">{{ $t("trade.new_price") }}</span>
          <span class="flex1 tr pr10">{{ $t("trade.changes") }}</span>
        </div>
        <div class="overyscroll">
          <div v-if="list.length > 0 && list[currentIndex]">
            <div
              class="flex alcenter ptb5 markethover pointer"
              :class="{ bgshadow: itm.Code == currentCode }"
              v-for="(itm, j) in list"
              :key="j"
              @click="changeSymbol(j)"
            >
              <div class="flex1 pl10 baselight2">
                {{ itm.Code }}
              </div>
              <div class="flex1 tr baselight2" v-if="itm.ForexQuotations">
                <!-- {{ itm.base_currency_code=='TEST'?!isOnline(itm.market_time)?$t('trade.soon'):itm.currency_quotation.close:itm.currency_quotation.close }} -->
				<div v-if="itm.MarketStatus!=1" class="mlr10">{{$t('new.closed')}}</div>
				<div v-else>{{itm.ForexQuotations.Close}}</div>
              </div>
              <div
                class="flex1 tr pr10"
                :class="[itm.ForexQuotations.Change >= 0 ? 'green' : 'red']"
                v-if="itm.ForexQuotations && itm.MarketStatus==1"
              >
                <span v-if="itm.ForexQuotations.Change >= 0">+</span>
                {{ itm.ForexQuotations.Change || "0.00" | filterDecimals }}%
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex25 flex column h0 mr5" v-if="mathid && !soon">
        <!-- k线 -->
        <LeverKline
          class="flex2 bgpart"
          :currency_matchInfo="currency_matchInfo"
          ref="klineChild"
        ></LeverKline>
        <!-- 下单 -->
        <LeverDoorder
          ref="leverDoorder"
          class="flex12 mt5 bgpart"
          :order_data="orderData"
          :currency_matchInfo="currency_matchInfo"
          @func="orderSuccess"
        ></LeverDoorder>
      </div>
      <!-- 盘口 -->
      <LeverHandicap
        class="wt390 h0"
        v-if="mathid && !soon"
        :inlist="inlist"
        :outlist="outlist"
        :currency_matchInfo="currency_matchInfo"
      ></LeverHandicap>
	  <div class="flex1 flex alcenter jscenter ft20" v-if="soon">{{$t('trade.soon')}}</div>
    </div>
    <!-- 订单记录 -->
    <LeverHistery
      :currentDelegation="currentDelegation"
      :currency_matchInfo="currency_matchInfo"
      :historyData="historyData"
      class="mt5 bgpart"
      @history="changePage"
      @closeLever="leverCannel"
    ></LeverHistery>
  </div>
</template>
<script>
import LeverKline from "./leverKline.vue";
import LeverDoorder from "./leverDoorder.vue";
import LeverHandicap from "./leverHandicap.vue";
import LeverHistery from "./leverHistery.vue";
export default {
  components: {
    LeverKline,
    LeverDoorder,
    LeverHistery,
    LeverHandicap
  },
  data() {
    return {
      tradeList:[],
      currentCode:'',

      list: [],
      currentIndex: 0,
      currentSymbol: "",
      mathid: "",
      currencyId: "",
      legalId: "",
      currencyName: "",
      legalName: "",
      cny_usd: "",
      inlist: [],
      outlist: [],
      completelist: [],
      currency_matchInfo: {},
      orderData: {},
      currentDelegation: [],
      page: 1,
      historyData: {
        currentPosition: [],
        orderList: [],
        currentPositionTotal: 0,
        orderListTotal: 0,
        risk: 0,
        totalRisk: 0,
        currentPositionPer:0,
        orderListPer:0,
      },
      types: 5
    };
  },
  computed:{
	 isOnline(){
		 return (time)=>{
			 if(!time)return false;
			let date = new Date(time).getTime(),
				currentDate = new Date().getTime();
			return date <= currentDate; 
		 };
	 },
	 soon(){
		return this.currency_matchInfo.base_currency_code=='TEST' && !this.isOnline(this.currency_matchInfo.market_time)
	 }
  },
  mounted() {
    console.log('mounted');
    if(!localStorage.getItem('token')){
      this.$utils.layerMsg(this.$t('second.p_loginandtrade'));
      this.$router.push({name:'login'})
      return;
    }
    // this.getTradeMathes()
    this.getmathes();
    // this.bindSocket();
  },
  // mounted(){
  //   // this.bindSocket()
  // },
  methods: {
    // getTradeMathes(){
    //   console.log('getTradeMathes');
    //   var that = this;
    //   that.$http
    //     .initDataToken({ url: "forex/trade_list" }, false,true,false,{baseURL:`${this.API}/v1/api/`})
    //     .then(res => {
    //       this.tradeList = res
    //       this.currentCode = res[0].Code

    //      console.log(res,'trade_list');
    //     });
    // },
    // 获取左侧行情信息
    getmathes() {
      console.log('getmathes');
      var that = this;
      that.$http
        .initDataToken({ url: "forex/trade_list" }, false,true,false,{baseURL:`${this.API}/v1/api/`})
        .then(res => {
          // 判断支持合约交易的法币
          that.list = res
          console.log('list',that.list);
          this.currentCode = res[0].Code
          // that.list = res.filter(item => item.is_quote == 1);
          console.log(res)
          console.log("12312321312321312")
          // that.list = res;
          // 判断是否存储过信息
          var localStatus = false;
          var data3 = [];
          var data1 = [];
          var data2 = [];
          if (that.list.length > 0) {
            if (
              localStorage.getItem("bigTradeDate") &&
              localStorage.getItem("bigTradeDate") != 'undefined'
            ) {
              var leverData = localStorage.getItem("bigTradeDate") || "";
              data1 = JSON.parse(leverData);
              data2 = res.find(item => item.Id == data1.Id);
              if (data2) {
                that.currentCode = data2.Code
                // data3 = data2[0].matches.filter(
                //   item =>
                //     item.open_lever == 1 &&
                //     item.base_currency_id == data1.base_currency_id
                // );
                localStatus = true;
              }
            }
            if (localStatus) {
              // that.cny_usd = data2[0].cny_price;
              that.currency_matchInfo = data2;
            } else {
              console.log('12222');
              // that.cny_usd = res[0].cny_price;
              var datas = that.list[0]
              that.currency_matchInfo = datas;
            }
            localStorage.setItem(
              "bigTradeDate",
              JSON.stringify(that.currency_matchInfo)
            );
            if(that.currency_matchInfo.HasForexMultiple.length){
              that.$nextTick(()=>{
              that.$refs.leverDoorder.init(that.currency_matchInfo.HasForexMultiple[0].Value)
            })
            }
            console.log('that.currency_matchInfo22',that.currency_matchInfo);
            that.getcurmatchinfo(that.currency_matchInfo);
            that.bindSocket();
          }
        });
    },
    bindSocket(){
      var that=this;
      var tokens = localStorage.getItem("token");
      that.$newSocket.connected((socket)=>{
        // console.log('3334343');
        // 行情socket
        socket.send([{ type: "login", params: tokens },{type: "sub", params: "DAY_MARKET"},
        {type: "sub", params: "FOREX_TRADE"},
        {type: "sub", params: "FOREX_CLOSED"}
      ]);
        socket.on('DAY_MARKET',msg=>{
          that.list.forEach((item)=>{
            if(item.Code=== msg.symbol ){
              item.ForexQuotations.Close = msg.quotation.close;
              item.ForexQuotations.Change = msg.quotation.change;
              item.ForexQuotations.High = msg.quotation.high
              item.ForexQuotations.Low = msg.quotation.low
              item.ForexQuotations.Volume =msg.quotation.volume
            }
          })
        // var datas = that.list[that.currentIndex];

      //   datas.forEach((item, index) => {
      //     if (item.currency_quotation.currency_match_id == msg.currency_match_id) {
      //       that.list[that.currentIndex].matches[index].currency_quotation.change = msg.quotation.change;
      //       that.list[that.currentIndex].matches[index].currency_quotation.close = msg.quotation.close;
			// that.list[that.currentIndex].matches[index].currency_quotation.volume = msg.quotation.volume;
      //       }
      //     });
        })
        //  盘口socket
       if(that.currency_matchInfo.MarketStatus==1){
        that.depthSocket();
       }else{
        that.outlist =[];
        that.inlist =[];
       }
        // that.$socket.send([{type: "login", params: tokens},{type: "sub",params: "MARKET_DEPTH."+that.currency_matchInfo.symbol},{type:'sub',params: "GLOBAL_TX."+that.currency_matchInfo.symbol},{type:'sub',params:'KLINE.'+that.currency_matchInfo.symbol}])
        // that.$socket.on('MARKET_DEPTH',msg=>{
        //   that.outlist = msg.depth.out.reverse();
        //   that.inlist = msg.depth.in;
        // })
        // 未平仓单子socket
        socket.on('FOREX_TRADE',msg=>{
          // console.log(msg);
          // let data1 = JSON.parse(msg);
          let data1 = msg;
          var data2 = data1.TransOrder;
          var datas = [];
          if (that.types == 5) {
            datas = that.historyData.currentPosition;
            // if (
            //   that.currency_matchInfo.currency_quotation.currency_match_id ==
            //   msg.currency_match_id
            // ) {
              that.historyData.risk = msg.HazardRate;
              that.historyData.totalRisk = msg.ProfitsTotal;
            // }
          } else {
            datas = that.historyData.orderList;
          }
          data2.forEach((item, index) => {
            datas.forEach((itm, inx) => {
              if (
                item.Id == itm.Id
              ) {
                if (that.types == 5) {
                  that.historyData.currentPosition.splice(inx, 1, item);
                } else {
                  that.historyData.orderList.splice(inx, 1, item);
                }
              }
            });
          });
        });
        // // 单子已经平仓
        socket.on('FOREX_CLOSED',msg=>{
          var data2 = msg.id;
          var datas = [];
          // that.orderData.forex_user_balance = msg.balance
          if (that.types == 5) {
            // that.historyData.risk = msg.hazard_rate;
            // that.historyData.totalRisk = msg.profits;
            datas = that.historyData.currentPosition;
          } else if (that.types == 6) {
            datas = that.currentDelegation;
          } else {
            datas = that.historyData.orderList;
          }
          data2.forEach((item, index) => {
            datas.forEach((itm, inx) => {
              if (item == itm.Id) {
                if (that.types == 5) {
                  that.historyData.currentPosition.splice(inx, 1);
                } else if (that.types == 6) {
                  that.currentDelegation.splice(inx, 1);
                } else {
                  that.historyData.orderList.splice(inx, 1);
                }
              }
            });
          });
        });
      
      })
    },
     // 盘口socket
    depthSocket(){
      let that = this;
      console.log(that.currency_matchInfo,'that.currency_matchInfo');
      that.$newSocket.send([{type: "login", params: localStorage.getItem("token")},{type: "sub",params: "MARKET_DEPTH."+that.currency_matchInfo.Code}])
      that.$newSocket.on('MARKET_DEPTH',msg=>{
        // console.log(msg,'msg');
        that.outlist = msg.depth.out;
        that.inlist = msg.depth.in;
      })
    },
    // 获取合约交易信息
    getDefault() {
      var that = this;
      that.$http
        .initDataToken(
          {
            url: "forex/deal",
            data: {
              forex_id:
                that.currency_matchInfo.Id
            },
            type: "get"
          },
          false,true,false,{baseURL:`${this.API}/v1/api/`}
        )
        .then(res => {
          that.orderData = res;
          // that.inlist = res.lever_transaction.in;
          // that.outlist = res.lever_transaction.out.reverse();
          that.currentDelegation = res.my_transaction;
        });
    },
    getcurmatchinfo(temp) {
      // return
      var that = this;
      that.currentSymbol = temp.Code;
      that.mathid = temp.Id;
      // that.currencyId = temp.base_currency_id;
      // that.legalId = temp.quote_currency_id;
      that.currencyName = temp.Code;
      // that.legalName = temp.quote_currency_code;
      // 获取合约交易信息
      that.getDefault();
      that.getCurrent();
    },
    // 改变当前交易对
    changeSymbol(j) {
      this.currentIndex = j
      var that = this;
      var curmatch = that.list[j];
      if(curmatch.Id == that.currency_matchInfo.Id){
        return
      }
      this.unbindSocket();
      that.currency_matchInfo = curmatch;
      that.currentCode = curmatch.Code
      localStorage.setItem(
        "bigTradeDate",
        JSON.stringify(that.currency_matchInfo)
      );
    console.log(that.currency_matchInfo,'23');
    if(that.currency_matchInfo.HasForexMultiple.length){
        that.$nextTick(()=>{
        that.$refs.leverDoorder.init(that.currency_matchInfo.HasForexMultiple[0].Value)
      })
    }else{
      that.$refs.leverDoorder.init('')
    }
    if(that.currency_matchInfo.MarketStatus!=1 ){
      that.outlist = []
      that.inlist = [];
    }else{
      this.depthSocket();
    }
   
		
		that.getcurmatchinfo(curmatch);
    },
    // 改变法币
    changelegal(i){
        this.currentIndex = i;
    },
    // 下单成功
    orderSuccess(data) {
      console.log(data);
      var that = this;
      if (data) {
        if (that.types == 6) {
          that.getDefault();
        } else if (that.types == 5) {
          that.page = 1;
          that.getCurrent();
        } else {
          that.page = 1;
          that.getOrder();
        }
      }
    },
    // 平仓成功
    leverCannel(data) {
      var that = this;
      var data1 = that.currentDelegation;
      var data2 = that.historyData.currentPosition;
      var data3 = that.historyData.orderList;
      that.currentDelegation = data1.filter(item => item.Id != data);
      that.historyData.currentPosition = data2.filter(item => item.Id != data);
      that.historyData.orderList = data3.filter(item => item.Id != data);
    },

    // 订单记录更改页码
    changePage(data) {
      var that = this;
      that.page = data.pages;
      that.types = data.types;
    },
    // 获取当前持仓
    getCurrent() {
      var that = this;
      that.historyData.currentPosition = [];
      if (that.page == 1) {
        that.historyData.currentPositionTotal = 0;
      }

      that.$http
        .initDataToken(
          {
            url: "forex/deal_all",
            type: "get",
            data: {
              forex_id:
                that.currency_matchInfo.Id,
              page: that.page
            }
          },
          false,true,false,{baseURL:`${this.API}/v1/api/`}
        )
        .then(res => {
          that.orderData.forex_user_balance = res.balance
          console.log(res);
          that.historyData.risk = res.hazard_rate;
          that.historyData.totalRisk = res.profits_total;
          that.historyData.currentPosition = res.order.data;
          that.historyData.currentPositionTotal = res.order.total;
          that.historyData.currentPositionPer = res.order.currency_page;
  
        });
    },
    // 获取全部订单
    getOrder() {
      var that = this;
      that.historyData.orderList = [];
      if (that.page == 1) {
        that.historyData.orderListTotal = 0;
      }
      that.$http
        .initDataToken(
          {
            url: "forex/my_deal",
            type: "get",
            data: {
              status: that.types,
              page: that.page
            }
          },
          false,true,false,{baseURL:`${this.API}/v1/api/`}
        )
        .then(res => {
          that.orderData.forex_user_balance = res.balance
          // console.log(res);
          that.historyData.orderList = res.data;
          that.historyData.orderListTotal = res.total;
          that.historyData.orderListPer=res.currency_page;
        });
    },
    unbindSocket(){
      let that = this;
      this.$newSocket.send([{type: "unsub",params: "MARKET_DEPTH."+that.currency_matchInfo.Code}]);
    },
  },
  beforeRouteLeave(to, from, next){
    next();
    this.$newSocket.send([{type: "unsub", params: "DAY_MARKET"},{type: "unsub", params: "FOREX_TRADE"},{type: "unsub", params: "FOREX_CLOSED"}]);
    this.unbindSocket();
    let symbol = this.currencyName+'/'+this.legalName;
    this.$refs.klineChild.unbindSocket(symbol);
  }
};
</script>
