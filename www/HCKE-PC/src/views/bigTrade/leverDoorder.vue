<template>
  <div>
    <div class="bgheader bdbheader flex alcenter between plr10 baselight2">
      <div class=" flex alcenter">
        <div
        class="ptb5 mr30 bold ft14 pointer"
		:class="{'active2px':i==index}"
        v-for="(item,i) in list"
        :key="i"
        @click="changetype(i)"
      >{{item.texts}}</div>
      </div>
      <div class="bold ft14 pointer" @click="$refs.exchange.show()">{{$t('new.duih')}}</div>
    </div>
    <!-- <div
      class="flex alcenter mb10 plr10 ft14 pt10"
    >{{$t('lever.use')}}{{order_data.user_lever}}{{currency_matchInfo.quote_currency_code}}</div> -->
    <div class="flex ft12 pb10">
      <!-- 买 -->
      <div class="flex1 plr10 mt10 bdr38">
        <div class="flex alcenter mb10 posRelt mult">
          <span class="w15">{{$t('new.mrjg')}}</span>
          <input
            type="number"
            :disabled="index != 1"
            v-model="buyOrder.prices"
            :placeholder="index!=1? $t('new.zyjg') :$t('lever.p_price')"
            class="ht30 bdinput lh30 plr5 radius2 ml10 flex1 nwhite"
          />
        </div>
        <div class="flex alcenter mb10 posRelt">
          <span class="w15">{{$t('new.mrsl')}}</span>
          <div class="flex bdinput lh30 radius2 ml10 flex1 white mult flex">
            <div class="bdinput plr10 mr10 baselight" style="border-width: 0;border-right-width: 1px;">1{{$t('new.zhang')}} = {{currency_matchInfo.ForexContNum}}{{currency_matchInfo.Code}}</div>
            <input type="number"  v-model="buyOrder.shares" :placeholder="$t('legal.enterNumber')" class="nwhite flex2 lh30" />
          </div>
        </div>
        <div class="flex alcenter mb10 posRelt">
          <span class="w15"></span>
          <div class="flex1 flex ml10 between">
              <div
                class="flex1 bdheader ptb5 plr15 radius4 pointer tc"
                v-for="(item,index) in percentage"
                :class="{'bdblue blue':pIndex==index,'ml10':index!=0}"
                :key="index"
                @click="changePercent('buy',index)"
              >{{item}}%</div>
            </div>
        </div>
        <div class="flex alcenter mb10 posRelt mult">
          <span class="w15">{{$t('new.ggbs')}}</span>
          <el-select
            class="lh30 bdinput lh30 radius2 ml10 flex1 white"
            popper-class="selects"
            v-model="buyOrder.mult"
            :placeholder="$t('lever.p_times')"
            v-if="currency_matchInfo.HasForexMultiple"
          >
            <el-option
              v-for="item in currency_matchInfo.HasForexMultiple"
              :key="item.Value"
              :label="item.Value"
              :value="item.Value"
            ></el-option>
          </el-select>
        </div>
        <div class="flex alcenter mb10 posRelt mult jsend">
          {{$t('lever.use')}}
          {{order_data.forex_user_balance}} {{order_data.settle_currency_code}}
        </div>
        <div class="bdinput tc ht30 lh30 radius2 blue" v-if="!token">
          <router-link :to="{name:'login'}">{{$t('login.login')}}</router-link>
          <span class="baselight2">{{$t('trade.or')}}</span>
          <router-link :to="{name:'register'}">{{$t('register.register')}}</router-link>
        </div>
        <div class="tc ht30 lh30 white radius2" :class="[currency_matchInfo.MarketStatus!=1 ?'bagray':'bggreen']" @click="submits(1)" v-else>{{$t('lever.buy')}}</div>
      </div>
      <!-- 卖盘 -->
      <div class="flex1 plr10 mt10">
        <!-- <div class="flex alcenter mb10">可用123{{currencyName}}</div> -->
        <div class="flex alcenter mb10 posRelt mult">
          <span class="w15">{{$t('new.mrjg')}}</span>
          <input
            type="number"
            :disabled="index != 1"
            v-model="sellOrder.prices"
            :placeholder="index!=1? $t('new.zyjg') :$t('lever.p_price')"
            class="ht30 bdinput lh30 plr5 radius2 ml10 flex1 nwhite"
          />
        </div>
        <div class="flex alcenter mb10 posRelt">
          <span class="w15">{{$t('new.mrsl')}}</span>
          <div class="flex bdinput lh30 radius2 ml10 flex1 white mult flex">
            <div class="bdinput plr10 mr10 baselight" style="border-width: 0;border-right-width: 1px;">1{{$t('new.zhang')}} = {{currency_matchInfo.ForexContNum}}{{currency_matchInfo.Code}}</div>
            <input type="number" v-model="sellOrder.shares" :placeholder="$t('legal.enterNumber')" class="nwhite flex2 lh30" />
          </div>
        </div>

        <div class="flex alcenter mb10 posRelt">
          <span class="w15"></span>
          <div class="flex1 flex ml10 between">
              <div
                class="flex1 bdheader ptb5 plr15 radius4 pointer tc"
                v-for="(item,index) in percentage"
                :class="{'bdblue blue':sIndex==index,'ml10':index!=0}"
                :key="index"
                @click="changePercent('sell',index)"
              >{{item}}%</div>
            </div>
        </div>
        <div class="flex alcenter mb10 posRelt mult">
          <span class="w15">{{$t('new.ggbs')}}</span>
          <el-select
            class="bdinput lh30 radius2 ml10 flex1 white"
            popper-class="selects"
            v-model="sellOrder.mult"
            :placeholder="$t('lever.p_times')"
            v-if="currency_matchInfo.HasForexMultiple"
          >
            <el-option
              v-for="item in currency_matchInfo.HasForexMultiple"
              :key="item.Value"
              :label="item.Value"
              :value="item.Value"
            ></el-option>
          </el-select>
        </div>
        <div class="flex alcenter mb10 posRelt mult jsend">
          {{$t('lever.use')}}
          {{order_data.forex_user_balance}} {{order_data.settle_currency_code}}
        </div>

        <!-- <div class="flex alcenter mb10">交易额：666</div> -->
        <div class="bdinput tc ht30 lh30 radius2 blue" v-if="!token">
          <router-link :to="{name:'login'}">{{$t('login.login')}}</router-link>
          <span class="baselight2">{{$t('trade.or')}}</span>
          <router-link :to="{name:'register'}">{{$t('register.register')}}</router-link>
        </div>
        <div class="tc ht30 lh30 white radius2" :class="[currency_matchInfo.MarketStatus!=1 ?'bagray':'bgred']" @click="submits(2)" v-else>{{$t('lever.sell')}}</div>
      </div>
    </div>

    <!-- 提交弹窗 -->
    <el-dialog :title="$t('lever.confrim_order')" :visible.sync="orderShow" width="30%" :before-close="handleClose">
      <div class="mb15">
        <div class="flex pb10 alcenter between">
          <p>{{$t('new.pages')}}</p>
          <p>{{submitType==1?buyOrder.shares:sellOrder.shares}}</p>
        </div>
        <div class="flex pb10 alcenter between">
          <p>{{$t('lever.times')}}</p>
          <p>{{submitType==1?buyOrder.mult:sellOrder.mult}}</p>
        </div>
        <div class="flex pb10 alcenter between">
          <p>{{$t('lever.fee')}}</p>
          <p>{{leverOrder.fees || '0.00' |filterDecimals(6)}}</p>
        </div>
        <div class="flex pb10 alcenter between">
          <p>{{$t('lever.money')}}</p>
          <p>{{leverOrder.bonds || '0.00' |filterDecimals(6)}}</p>
        </div>
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button class="radius4" @click="orderShow=false">{{$t('lever.cannel')}}</el-button>
        <el-button type="primary" @click="orderSubmit" class="radius4">{{$t('lever.e_confrim2')}}</el-button>
      </span>
    </el-dialog>

    <!-- 兑换 -->
    <exchange ref="exchange"></exchange>
  </div>
</template>
<script>
import exchange from './exchange.vue'
export default {
  props: ["order_data", "currency_matchInfo"],
  components:{
    exchange
  },
  data() {
    return {
      percentage:[25,50,75,100],
      pIndex:-1,
      sIndex:-1,
      list: [
        {
          texts: this.$t('lever.marketPrice'),
          types: 1
        },
        {
          texts: this.$t('lever.fixing'),
          types: 0
        }
      ],
      index: 0,
      submitType: 1,
      buyOrder: {
        prices: "",
        mult: "",
        shares: "",
        passwords: ""
      },
      sellOrder: {
        prices: "",
        mult: "",
        shares: "",
        passwords: ""
      },
      leverOrder: {
        marketPrice: "",
        bonds: "",
        fees: ""
      },
      orderShow: false
    };
  },
  created() {
    this.token = localStorage.getItem("token");
    // 获取当前币余额
    // this.initBalance(this.currencyId, 0);
  },
  mounted() {
    eventBus.$on("changeBuyPrice", msg => {
      this.buyprice = msg;
    });
    eventBus.$on("changeSellPrice", msg => {
      this.sellprice = msg;
    });
  },
  methods: {
    init(value){
      this.buyOrder.mult = this.sellOrder.mult = value;
    },
    calcPrice(prices,mult,percentage){
      const that = this
      const bonds = ((1*that.currency_matchInfo.ForexContNum*prices)/mult)
      const fees =  (bonds *that.currency_matchInfo.ForexFeeRate)
      return Math.floor(this.order_data.forex_user_balance/(bonds+fees)*percentage)
    },
    changePercent(target,index){
      const that = this
      var mults =  target=='buy' ?that.buyOrder.mult:that.sellOrder.mult;
      if (!mults) {
          that.$utils.layerMsg(that.$t('lever.p_times'));
          return
        }
      var prices = target=='buy' ?this.buyOrder.prices:this.sellOrder.prices;
      if(that.list[that.index].types != 0){
        prices = that.currency_matchInfo.ForexQuotations.Close
      }

      if (!prices) {
            that.$utils.layerMsg(that.$t('lever.p_delprice'));
            return
          }

      if(target=='buy'){
        this.pIndex = index
        this.buyOrder.shares = this.calcPrice(prices,mults,this.percentage[index]/100)
      }else{
        this.sIndex = index
        this.sellOrder.shares = this.calcPrice(prices,mults,this.percentage[index]/100)
      }
    },
    // 点击提交按钮
    submits(options) {
      if(this.currency_matchInfo.MarketStatus!=1){
        return
      }
      var that = this;
      that.submitType = options;
      var shares = that.submitType == 1?that.buyOrder.shares:that.sellOrder.shares;
      var mults = that.submitType == 1?that.buyOrder.mult:that.sellOrder.mult;
      var passwords = that.submitType == 1?that.buyOrder.passwords:that.sellOrder.passwords;
      var prices = that.submitType == 1?that.buyOrder.prices:that.sellOrder.prices || '';
      if(that.list[that.index].types == 0){
         if (!prices) {
            that.$utils.layerMsg(that.$t('lever.p_delprice'));
            return false;
          }
      }
       if (!mults) {
          that.$utils.layerMsg(that.$t('lever.p_times'));
          return false;
        }
        if (!shares) {
          that.$utils.layerMsg(that.$t('new.p_pages'));
          return false;
        }
        // if (!passwords) {
        //   that.$utils.layerMsg(that.$t('lever.payPassword'));
        //   return false;
        // }
        if(that.list[that.index].types == 0){
          that.calculation(prices, mults, shares);
        }else{
          that.calculation(that.currency_matchInfo.ForexQuotations.Close, mults, shares);
        }
        
      that.orderShow = true;
    },
    // 下单计算
    calculation(prices, mult, shares) {
      // 价格+或者-点差  * 手数 * 每手数量  /倍数
      var that = this;
      var spreadPrices = Number(
        (prices * that.currency_matchInfo.ForexPointRate) / 100
      );
      var pricesTotal = 0;
      if (that.submitType == 2) {
        pricesTotal = Number(prices - spreadPrices);
      } else {
        pricesTotal = Number(prices - 0 + (spreadPrices - 0));
      }
      // 计算保证金的话就是 (张数*每张数量*现在价格)/倍数
      that.leverOrder.bonds = ((shares*that.currency_matchInfo.ForexContNum*prices)/mult).toFixed(6)
      that.leverOrder.fees =  (that.leverOrder.bonds *that.currency_matchInfo.ForexFeeRate).toFixed(6)

      // console.log(prices);
      // that.leverOrder.marketPrice = Number(
      //   pricesTotal * shares * that.currency_matchInfo.lever_share_num
      // ); //合约市值
      // that.leverOrder.bonds = Number(
      //   (that.leverOrder.marketPrice - 0) / (mult - 0)
      // ).toFixed(4); //保证金
      // that.leverOrder.fees = Number(that.leverOrder.marketPrice * that.currency_matchInfo.lever_fee_rate); //手续费
    },
    // 关闭弹窗
    handleClose() {
      var that = this;
      that.orderShow = false;
    },

    // 确认下单
    orderSubmit() {
      var that = this;
      var shares = that.submitType == 1?that.buyOrder.shares:that.sellOrder.shares;
      var mults = that.submitType == 1?that.buyOrder.mult:that.sellOrder.mult;
      var passwords = that.submitType == 1?that.buyOrder.passwords:that.sellOrder.passwords;
      var prices = that.submitType == 1?that.buyOrder.prices:that.sellOrder.prices || '';
      that.orderShow = false;
      that.$http
        .initDataToken({
          url: "forex/submit",
          type: "get",
          data: {
            cont: shares,
            multiple: mults,
            forex_id: that.currency_matchInfo.Id,
            type: that.submitType,
            status: that.list[that.index].types,
            target_price: prices,
            // password: passwords
          },
        },true,true,false,{baseURL:`${this.API}/v1/api/`})
        .then(res => {
          that.buyOrder.shares = "";
          that.sellOrder.shares = "";
          that.buyOrder.mult = "";
          that.sellOrder.mult = "";
          that.buyOrder.prices="";
          that.sellOrder.prices="";
          that.buyOrder.passwords="";
          that.sellOrder.passwords="";
          this.$emit('func',1);
        });
    },

    // 切换交易类型
    changetype(i) {
      this.index = i;
      if(i==0){
        this.buyOrder.prices = this.sellOrder.prices = ''
      }
    }
  }
};
</script>
<style lang="scss">
.mult {
  .el-input__inner {
    border: none !important;
    height: 30px;
    line-height: 30px;
  }
  .el-input__icon {
    line-height: 30px;
  }
}
.selects {
  background: #171b2b;
  border: 1px solid #383f66;
}
.el-popper[x-placement^="bottom"] .popper__arrow::after {
  border-bottom-color: #171b2b;
}
.selects .el-popper .popper__arrow::after {
  border-bottom-color: #171b2b;
}
input[type="number"] {
  -moz-appearance: textfield;
}
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>