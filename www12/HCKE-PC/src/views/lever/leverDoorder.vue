<template>
  <div>
    <div class="bgwhite dark-bg-1C2532 flex alcenter plr10 baselight2">
      <div
        class="ptb5 mr30 bold ft14 pointer"
		:class="{'text-clip-green border-b-2FA079':i==index}"
        v-for="(item,i) in list"
        :key="i"
        @click="changetype(i)"
      >{{item.texts}}</div>
    </div>
    <div
      class="flex alcenter mb10 plr10 ft14 pt10"
    >{{$t('lever.use')}}{{order_data.user_lever}}{{currency_matchInfo.quote_currency_code}}</div>
    <div class="flex ft12 pb10">
      <!-- 买 -->
      <div class="flex1 plr10 mt10 bdr38">
        <div class="flex alcenter mb10 posRelt mult" v-show="index==1">
          <span class="w15">{{$t('lever.price')}}</span>
          <input
            type="number"
            v-model="buyOrder.prices"
            :placeholder="$t('lever.p_price')"
            class="ht30 bdinput lh30 plr5 radius2 ml10 flex1 white"
          />
        </div>
        <div class="flex alcenter mb10 posRelt mult">
          <span class="w15">{{$t('lever.times')}}</span>
          <el-select
            class="lh30 bdinput lh30 radius2 ml10 flex1 white"
            popper-class="selects"
            v-model="buyOrder.mult"
            :placeholder="$t('lever.p_times')"
            v-if="order_data.multiple"
          >
            <el-option
              v-for="item in order_data.multiple.muit"
              :key="item.value"
              :label="item.value"
              :value="item.value"
            ></el-option>
          </el-select>
        </div>
        <div
          class="mb10"
        >{{$t('lever.onehand')}}{{currency_matchInfo.lever_share_num}}{{currency_matchInfo.base_currency_code}}</div>
        <div class="flex alcenter mb10 posRelt">
          <span class="w15">{{$t('lever.hands')}}</span>
          <div class="flex bdinput lh30 pl5 radius2 ml10 flex1 white mult">
            <input type="number" v-model="buyOrder.shares" class="nwhite flex2 lh30" />
            <div
              class="flex1 bdl383"
              v-if="order_data.multiple&&order_data.multiple.share.length >0"
            >
              <el-select popper-class="selects" v-model="buyOrder.shares" :placeholder="$t('lever.selectHand')">
                <el-option
                  v-for="item in order_data.multiple.share"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                ></el-option>
              </el-select>
            </div>
          </div>
        </div>
         <el-slider :marks="marks" v-model="value1" :step="1" show-stops  :class="loctheme=='dark'?' buyslider ml10':'buyslider2 ml10'" @change="sliderBuy"></el-slider>
        <div class="flex alcenter mb10">
          <span class="w15">{{$t('lever.s_dealpwd')}}</span>
          <input
            type="password"
            autocomplete="new-password"
            v-model="buyOrder.passwords"
            class="ht30 bdinput lh30 pl5 radius2 ml10 flex1 nwhite"
          />
        </div>
        <!-- <div class="flex alcenter mb10">合约市值：666</div> -->
        <div class="bg-main-liner tc ht40 lh40 radius2 blue ft16" v-if="!token">
          <router-link :to="{name:'login'}">{{$t('login.login')}}</router-link>
          <span class="baselight2">{{$t('trade.or')}}</span>
          <router-link :to="{name:'register'}">{{$t('register.register')}}</router-link>
        </div>
        <div class="bg-k-green tc ht30 lh30 white radius2" @click="submits(1)" v-else>{{$t('lever.buy')}}</div>
      </div>
      <!-- 卖盘 -->
      <div class="flex1 plr10 mt10">
        <!-- <div class="flex alcenter mb10">可用123{{currencyName}}</div> -->
        <div class="flex alcenter mb10 posRelt mult" v-show="index==1">
          <span class="w15">{{$t('lever.price')}}</span>
          <input
            type="number"
            v-model="sellOrder.prices"
            :placeholder="$t('lever.p_price')"
            class="ht30 bdinput lh30 plr5 radius2 ml10 flex1 white"
          />
        </div>
        <div class="flex alcenter mb10 posRelt mult">
          <span class="w15">{{$t('lever.times')}}</span>
          <el-select
            class="bdinput lh30 radius2 ml10 flex1 white"
            popper-class="selects"
            v-model="sellOrder.mult"
            :placeholder="$t('lever.p_times')"
            v-if="order_data.multiple"
          >
            <el-option
              v-for="item in order_data.multiple.muit"
              :key="item.value"
              :label="item.value"
              :value="item.value"
            ></el-option>
          </el-select>
        </div>
        <div
          class="mb10"
        >{{$t('lever.onehand')}}{{currency_matchInfo.lever_share_num}}{{currency_matchInfo.base_currency_code}}</div>
        <div class="flex alcenter mb10 posRelt">
          <span class="w15">{{$t('lever.hands')}}</span>
          <div class="flex bdinput lh30 pl5 radius2 ml10 flex1 white mult">
            <input type="number" v-model="sellOrder.shares" class="nwhite flex2 lh30" />
            <div
              class="flex1 bdl383"
              v-if="order_data.multiple&&order_data.multiple.share.length >0"
            >
              <el-select popper-class="selects" v-model="sellOrder.shares" :placeholder="$t('lever.selectHand')">
                <el-option
                  v-for="item in order_data.multiple.share"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                ></el-option>
              </el-select>
            </div>
          </div>
        </div>
         <el-slider :marks="marks" v-model="value2" :step="1 " show-stops  :class="loctheme=='dark'?' sellslider ml10':'sellslider2 ml10'" @change="sliderSell"></el-slider>
        <div class="flex alcenter mb10">
          <span class="w15">{{$t('lever.s_dealpwd')}}</span>
          <input
            type="password"
            autocomplete="new-password"
            v-model="sellOrder.passwords"
            class="ht30 bdinput lh30 pl5 radius2 ml10 flex1 nwhite"
          />
        </div>

        <!-- <div class="flex alcenter mb10">交易额：666</div> -->
        <div class="bg-main-liner tc ht40 lh40 radius2 blue ft16" v-if="!token">
          <router-link :to="{name:'login'}">{{$t('login.login')}}</router-link>
          <span class="baselight2">{{$t('trade.or')}}</span>
          <router-link :to="{name:'register'}">{{$t('register.register')}}</router-link>
        </div>
        <div class="bg-k-red tc ht30 lh30 white radius2" @click="submits(2)" v-else>{{$t('lever.sell')}}</div>
      </div>
    </div>

    <!-- 提交弹窗 -->
    <el-dialog :title="$t('lever.confrim_order')" :visible.sync="orderShow" width="30%" :before-close="handleClose">
      <div class="mb15">
        <div class="flex pb10 alcenter between">
          <p>{{$t('lever.hands')}}</p>
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
        <el-button type="primary" @click="orderSubmit" class="radius4 bg-main-liner black">{{$t('lever.e_confrim2')}}</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
export default {
  props: ["order_data", "currency_matchInfo"],
  data() {
    return {
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
        shares: 1,
        passwords: ""
      },
      sellOrder: {
        prices: "",
        mult: "",
        shares: 1,
        passwords: ""
      },
      leverOrder: {
        marketPrice: "",
        bonds: "",
        fees: ""
      },
      orderShow: false,
       value1:0,
      value2:0,
      loctheme:'',
      marks:{
        // 25:'25%',
        // 50:'50%',
        // 75:'75%',
        // 100:'100%'
      }
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
     sliderSell(val){
        let that = this
        let mults = that.sellOrder.mult;
        if (!mults) {
            this.value2 = 0
            that.$utils.layerMsg(that.$t('lever.p_times'));
            return false;
        }
        let bn = that.order_data.user_lever - this.fee(val,2)  //可用余额
        let close ; //价格
        if(that.index == 0 ){
          //市价
          close = that.currency_matchInfo.currency_quotation.close
        }else  if(that.index == 1 ){
          //限价
          close = that.sellOrder.prices
        }
        let b = that.sellOrder.mult //倍数
        let s = (bn * val / 100) / (close / b) //计算出来的手数
        let _s = parseInt(s) // 取整
        that.sellOrder.shares = _s
    },
    sliderBuy(val){
      let that = this
      let mults = that.buyOrder.mult;
      if (!mults) {
          this.value1 = 0
          that.$utils.layerMsg(that.$t('lever.p_times'));
          return false;
      }
      let bn = that.order_data.user_lever  - this.fee(val,1) //可用余额
      let close ; //价格
      if(that.index == 0 ){
        //市价
        close = that.currency_matchInfo.currency_quotation.close
      }else  if(that.index == 1 ){
        //限价
        close = that.buyOrder.prices
      }
      let b = that.buyOrder.mult //倍数
      let s = (bn * val / 100) / (close / b) //计算出来的手数
      let _s = parseInt(s) // 取整
      that.buyOrder.shares = _s
    },
         //手续费
    fee(val,type){
       let that = this
      let mults = that.buyOrder.mult;
      if (!mults) {
          this.value1 = 0
          that.$utils.layerMsg(that.$t('lever.p_times'));
          return false;
      }
      let bn = that.order_data.user_lever //可用余额
      let close ; //价格
      if(that.index == 0 ){
        //市价
        close = that.currency_matchInfo.currency_quotation.close
      }else  if(that.index == 1 ){
        //限价
        close = that.buyOrder.prices
      }
      let b = that.buyOrder.mult //倍数
      let s = (bn * val / 100) / (close / b) //计算出来的手数

      //

      var spreadPrices = Number(
        (close * that.currency_matchInfo.lever_point_rate) / 100
      );
      var pricesTotal = 0;
       if (type == 2) {
        pricesTotal = Number(close - spreadPrices);
      } else {
        pricesTotal = Number(close - 0 + (spreadPrices - 0));
      }
     let marketPrice = Number(
        pricesTotal * s * that.currency_matchInfo.lever_share_num
      ); //合约市值

      // 手续费
     
      return  marketPrice* that.currency_matchInfo.lever_fee_rate
    },
    // 点击提交按钮
    submits(options) {
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
          that.$utils.layerMsg(that.$t('lever.p_hands'));
          return false;
        }
        if (!passwords) {
          that.$utils.layerMsg(that.$t('lever.payPassword'));
          return false;
        }
        if(that.list[that.index].types == 0){
          that.calculation(prices, mults, shares);
        }else{
          that.calculation(that.currency_matchInfo.currency_quotation.close, mults, shares);
        }
        
      that.orderShow = true;
    },
    // 下单计算
    calculation(prices, mult, shares) {
      // 价格+或者-点差  * 手数 * 每手数量  /倍数
      var that = this;
      var spreadPrices = Number(
        (prices * that.currency_matchInfo.lever_point_rate) / 100
      );
      var pricesTotal = 0;
      if (that.submitType == 2) {
        pricesTotal = Number(prices - spreadPrices);
      } else {
        pricesTotal = Number(prices - 0 + (spreadPrices - 0));
      }
      console.log(prices);
      that.leverOrder.marketPrice = Number(
        pricesTotal * shares * that.currency_matchInfo.lever_share_num
      ); //合约市值
      that.leverOrder.bonds = Number(
        (that.leverOrder.marketPrice - 0) / (mult - 0)
      ).toFixed(4); //保证金
      that.leverOrder.fees = Number(that.leverOrder.marketPrice * that.currency_matchInfo.lever_fee_rate); //手续费
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
          url: "lever/submit",
          type: "POST",
          data: {
            share: shares,
            multiple: mults,
            currency_match_id: that.currency_matchInfo.currency_quotation.currency_match_id,
            type: that.submitType,
            status: that.list[that.index].types,
            target_price: prices,
            password: passwords
          }
        })
        .then(res => {
          that.buyOrder.shares = 1;
          that.sellOrder.shares = 1;
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
// .selects {
//   background: #171b2b;
//   border: 1px solid #383f66;
// }
// .el-popper[x-placement^="bottom"] .popper__arrow::after {
//   border-bottom-color: #171b2b;
// }
// .selects .el-popper .popper__arrow::after {
//   border-bottom-color: #171b2b;
// }
input[type="number"] {
  -moz-appearance: textfield;
}
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
.buyslider{
        .el-slider__bar{
            background-color: #009688;
        }  
        .el-slider__button{
            border-color: #009688;
            background-color: #171b2b;
        }
        .el-slider__runway{
            background: #252a44;
        }
        .el-slider__stop{
            background: #171b2b;
        }
    }  
    .buyslider2{
        .el-slider__bar{
            background-color: #009688;
        }  
        .el-slider__button{
            border-color: #009688;
            background-color: #e5ebf5;
        }
        .el-slider__runway{
            background: #e5ebf5;
        }
        .el-slider__stop{
            background: #909399;
        }
    }
    .sellslider{
        .el-slider__bar{
            background-color: #cc4951;
        }  
        .el-slider__button{
            border-color: #cc4951;
            background-color: #171b2b;
        }
        .el-slider__runway{
            background: #252a44
        }
        .el-slider__stop{
            background: #171b2b
        }
    } 
    .sellslider2{
        .el-slider__bar{
            background-color: #cc4951;
        }  
        .el-slider__button{
            border-color: #cc4951;
            background-color: #e5ebf5;
        }
        .el-slider__runway{
            background: #e5ebf5;
        }
        .el-slider__stop{
            background: #909399;
        }
    }
</style>