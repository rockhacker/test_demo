<template>
<div>
  <div class="w100 baselight nmb_ptb10 nmb_plr10">
    <div class="flex mb_alcenter mb_vh100 mb_flexdir">
      <div class="flex3 flex column h100 mb_mr10  bgwhite dark-bg-1C2532" v-if="mathid">
        <div class="flex alcenter hidden-xs mb10">
          <div v-for="(item, index) in list" :key="index">
            <span class="ft16 ml10 pointer ht40 lh40 plr10 radius4" :class="{ 'bg-main-liner black': itm.symbol == currentSymbol,'gray6': itm.symbol != currentSymbol,}"
            v-for="(itm, j) in item.matches"
            :key="j"
            v-show="itm.open_microtrade == 1"
            @click="changeSymbol(index,j)">
            {{itm.base_currency_code}}
          </span>
          </div>
        </div>
		<div v-if="soon"  class="flex1 flex alcenter jscenter ft20">{{$t('trade.soon')}}</div>
        <!-- k线 -->
        <LeverKline
          class="flex2"
          :cny_usd="cny_usd"
          :currency_matchInfo="currency_matchInfo"
          ref="klineChild"
		  v-if="mathid && !soon"
        ></LeverKline>
        <!-- 订单记录 -->
        <LeverHistery
          :currentDelegation="currentDelegation"
          :currency_matchInfo="currency_matchInfo"
          :historyData="historyData"
          class="mt30 bgpart"
          @history="changePage"
		  v-if="mathid && !soon"
        ></LeverHistery>
      </div>
      <div class="h100 flex flex1 column bgwhite dark-bg-1C2532" v-if="!soon">
        <LeverDoorder
        ref="LeverDoorder"
        v-if="mathid"
          class=""
          :wallet_list="walletList"
          :second_List="secondList"
          :currency_matchInfo="currency_matchInfo"
          @funct="orderSuccess"
        ></LeverDoorder>
      </div>
    </div>
  </div>
</div>
</template>
<script>
import LeverKline from "@/views/second/leverKline.vue";
import LeverDoorder from "@/views/second/leverDoorder.vue";
// import LeverHandicap from "@/views/second/leverHandicap.vue";
import LeverHistery from "@/views/second/leverHistery.vue";
export default {
  components: {
    LeverKline,
    LeverDoorder,
    LeverHistery,
    // LeverHandicap
  },
  data() {
    return {
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
      types: 1,
      walletList:[],
      secondList:[],
      set:null,
      token:""
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
  		return this.currency_matchInfo.base_currency_code=='ETHFX' && !this.isOnline(this.currency_matchInfo.market_time)
  	 }
  },
  created() {
    this.token = localStorage.getItem('token')
    // if(!localStorage.getItem('token')){
    //   this.$utils.layerMsg(this.$t('second.p_loginandtrade'));
    //   this.$router.push({name:'login'})
    //   return;
    // }
    this.getmathes();
    // this.getWallet();
    this.getSeocnd();
    // this.bindSocket();
  },
  mounted(){
    // this.bindSocket()
  },
  methods: {
     // 改变法币
        changelegal(i){
            this.currentIndex = i;
        },
    // 获取左侧行情信息
    getmathes() {
      var that = this;
      that.$http
        .initDataToken({ url: "market/currency_matches" }, false)
        .then(res => {
          // 判断支持合约交易的法币
          // that.list = res.filter(item => item.is_quote == 1 && item.code=='USDT');
          that.list = res
          // that.list = res;
          // 判断是否存储过信息
          var localStatus = false;
          var data3 = [];
          var data1 = [];
          var data2 = [];
          if (that.list.length > 0) {
            if (
              localStorage.getItem("secondData") &&
              localStorage.getItem("secondData") != 'undefined'
            ) {
              var secondData = localStorage.getItem("secondData") || "";
              console.log('secondData')
              console.log(secondData)

              data1 = JSON.parse(secondData);
              data2 = res.filter((item,index) => {
                if(item.id == data1.quote_currency_id){
                  that.currentIndex = index
                  return true
                }else{
                  return false
                }
              });
              if (data2.length>0) {
                data3 = data2[0].matches.filter(
                  item =>
                    item.open_microtrade == 1 &&
                    item.base_currency_id == data1.base_currency_id
                );

                localStatus = true;
              }
            }
            if (localStatus) {
              that.cny_usd = data2[0].cny_price;
              that.currency_matchInfo = data3[0];
            } else {
              that.cny_usd = res[0].cny_price;
              var datas = that.list[0].matches.filter(
                item => item.open_microtrade == 1
              )[0];
              that.currency_matchInfo = datas;
            }
            localStorage.setItem(
              "secondData",
              JSON.stringify(that.currency_matchInfo)
            );
            that.getcurmatchinfo(that.currency_matchInfo);
            this.getWallet(true);
            that.bindSocket();
          }
        });
    },
    bindSocket(){
      var that=this;
      var tokens = localStorage.getItem("token");
      that.$socket.connected((socket)=>{
        // 行情socket
        socket.send([{ type: "login", params: tokens },{type: "sub", params: "DAY_MARKET"},{type: "sub", params: "MICRO_CLOSED"}]);
        socket.on('DAY_MARKET',msg=>{
          var datas = that.list[that.currentIndex].matches;
          datas.forEach((item, index) => {
            if (item.currency_quotation.currency_match_id == msg.currency_match_id) {
              that.list[that.currentIndex].matches[index].currency_quotation.change = msg.quotation.change;
              that.list[that.currentIndex].matches[index].currency_quotation.close = msg.quotation.close;
			  that.list[that.currentIndex].matches[index].currency_quotation.volume = msg.quotation.volume;
            }
          });
        })
        //  盘口socket
        // that.depthSocket();
        // that.$socket.send([{type: "login", params: tokens},{type: "sub",params: "MARKET_DEPTH."+that.currency_matchInfo.symbol},{type:'sub',params: "GLOBAL_TX."+that.currency_matchInfo.symbol},{type:'sub',params:'KLINE.'+that.currency_matchInfo.symbol}])
        // that.$socket.on('MARKET_DEPTH',msg=>{
        //   that.outlist = msg.depth.out.reverse();
        //   that.inlist = msg.depth.in;
        // })
        // 单子已经平仓
        socket.on('MICRO_CLOSED',msg=>{
          if(msg.type=='MICRO_CLOSED'){
			 
            var datas = msg.order;
            for (var i = 0; i < that.historyData.currentPosition.length; i++) {
              if (that.historyData.currentPosition[i].id == datas.id) {
                that.historyData.currentPosition[i] = datas;
				 that.getWallet()
                setTimeout(function() {
                  var arr = that.historyData.currentPosition;
                  arr.splice(i, 1);
                  that.historyData.currentPosition = arr;
				  
                }, 500);
                return false;
              }
            }
          }
        });
      })
    },
     // 盘口socket
    depthSocket(){
      let that = this;
      that.$socket.send([{type: "login", params: localStorage.getItem("token")},{type: "sub",params: "MARKET_DEPTH."+that.currency_matchInfo.symbol}])
      that.$socket.on('MARKET_DEPTH',msg=>{
        that.outlist = msg.depth.out.reverse();
        that.inlist = msg.depth.in;
      })
    },
    //获取秒合约信息
    getWallet(init = false){
      if(!this.token){
        return
      }
      var that =this;
      that.$http.initDataToken({url:"microtrade/payable_currencies"},false)
      .then(res =>{
        that.walletList = res;
        if(init){
          const modelIndex = that.walletList.findIndex((item)=> item.id == this.list[this.currentIndex].id)
          that.$refs.LeverDoorder.changeModel(modelIndex)
        }
      })
    },
    //获取开仓时间
    getSeocnd(){
      var that =this;
      that.$http.initDataToken({url:"microtrade/seconds"},false)
      .then(res =>{
        that.secondList = res;
      })
    },
    getcurmatchinfo(temp) {
      var that = this;
      that.currentSymbol = temp.symbol;
      that.mathid = temp.currency_quotation.currency_match_id;
      that.currencyId = temp.base_currency_id;
      that.legalId = temp.quote_currency_id;
      that.currencyName = temp.base_currency_code;
      that.legalName = temp.quote_currency_code;
      // 获取合约交易信息
      that.getCurrent();
    },
    // 改变当前交易对
    changeSymbol(index,j) {
      var that = this;
      that.currentIndex = index
      this.unbindSocket();
      var curmatch = that.list[that.currentIndex].matches[j];
      that.currency_matchInfo = curmatch;
      localStorage.setItem(
        "secondData",
        JSON.stringify(that.currency_matchInfo)
      );
       const modelIndex = that.walletList.findIndex((item)=> item.id == this.list[index].id)
      that.$refs.LeverDoorder.changeModel(modelIndex)
      // this.depthSocket();
      that.getcurmatchinfo(curmatch);
    },

    // 下单成功
    orderSuccess(data) {
	 
      var that = this;
      if (data) {
        that.page = 1;
        that.getCurrent();
		that.getWallet()
      }
    },
    // 订单记录更改页码
    changePage(data) {
      var that = this;
      that.page = data.pages;
      that.types = data.status;
    },
    // 获取当前持仓
    getCurrent() {
      if(!this.token){
        return
      }
      var that = this;
      if(that.set!=null){
        clearInterval(that.set);
      }
      that.historyData.currentPosition = [];
      if (that.page == 1) {
        that.historyData.currentPositionTotal = 0;
      }
      that.$http.initDataToken({url: "microtrade/lists",
            data: {
              match_id:that.currency_matchInfo.currency_quotation.currency_match_id,
              page: that.page,
              limit:10,
              status:that.types
            }
          },false)
        .then(res => {
          for (var i = 0; i < res.data.length; i++) {
            res.data[i].remain_milli_seconds = parseInt((Number(res.data[i].remain_milli_seconds))/1000);
          }
          if(res.data.length>0){
            that.set = setInterval(() => {
              for (var i = 0; i < res.data.length; i++) {
                if(res.data[i].remain_milli_seconds<=0){
                  res.data[i].remain_milli_seconds = 0
                }else{
                  res.data[i].remain_milli_seconds--;
                }
              }
            }, 1000);
          }
          that.historyData.currentPosition = res.data;
          that.historyData.currentPositionTotal = res.total;
          that.historyData.currentPositionPer = res.per_page;
        });
    },
    unbindSocket(){
      let that = this;
      // this.$socket.send([{type: "unsub",params: "MARKET_DEPTH."+that.currency_matchInfo.symbol}]);
    },
  },
  beforeRouteLeave(to, from, next){
    next();
    this.$socket.send([{type: "unsub", params: "DAY_MARKET"},{type: "unsub", params: "MICRO_CLOSED"}]);
    let symbol = this.currencyName+'/'+this.legalName;
    this.$refs.klineChild.unbindSocket(symbol);
  }
};
</script>
<style lang="scss">
  @media (min-width: 768px) {
        .mb_alcenter{
          align-items: center;
        }
        #tv_chart_container{
          width:100%;
          height: 90%;
        }
        .mb_vh100{
          height:100vh;
        }
        .mb_mr10{
          margin-right: 10px;
        }
        .nmb_ptb10{
          padding: 10px;
        }
    }
    @media (max-width: 768px) {
        .mb_flexdir{
          flex-direction: column;
        }
         #tv_chart_container{
          height: 500px;
          width:100%;
        }

    }
</style>
