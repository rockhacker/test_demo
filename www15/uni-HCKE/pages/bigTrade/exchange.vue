<template>
  <view :class="theme">
    <view class="bgPart px-30 bg-white dark:bg-floor min-h-screen" v-if="info.recharge_account">
      <view class="flex py-40" :class="[type == 1 ? 'flex-row' : 'flex-row-reverse']">
        <view
          class="flex-1 bg-gray-100 dark:bg-gray-800 w-full h-80 flex justify-center items-center"
        >
          <view class="text-xl">{{ recharge_name }}</view>
        </view>
        <view class="w-160 flex flex-col justify-center items-center">
          <image
          @click="changeType"
            class="w-60 h-60"
            src="../../static/image/qweqwekkk.png"
          ></image>
          <view class="mt10">1:{{type==1?info.recharge_bili:(1/info.recharge_bili).toFixed(2)}}</view>
        </view>
        <view
          class="flex-1 bg-gray-100 dark:bg-gray-800 w-full h-80 flex justify-center items-center"
        >
          <view class="text-xl">{{ settle_name }}</view>
        </view>
      </view>

      <view class="flex alcenter between" v-if="info.recharge_account">
          <view>
            {{$t('trade.balance')}}:{{type==1?info.recharge_account_balance: info.settle_account_balance}}
          </view>
          <view>
            {{$t('new.ked')}}:{{calc}}{{type==2?info.recharge_account.Code:info.settle_account.CurrencyName}}
          </view>
        </view>

        <view class="mt-20 py-20 title text-xl">{{$t('new.dhs')}}</view>
        <view class="w-full flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-600">
            <input class="flex-1 h-80 text-xl" type="text" v-model="number" placeholder="0.00">
            <view class="text-xl px-20 border-0 border-l-2 border-r-2 border-solid border-gray-200 dark:border-gray-600">{{type==1?info.recharge_account.Code:info.settle_account.CurrencyName}}</view>
            <view class="ml-20 text-gray-400 text-xl" @click="setAll">{{$t('new.quanb')}}</view>
        </view>
        <button class="w-full rounded-10 bg-primary text-black text-xl mt-100" @click="submit">{{$t('new.duih')}}</button>
    </view>
  </view>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      recharge_name: "",
      settle_name: "",
      type: 1,
      info: {},
      number: "",
    };
  },
  computed: {
    ...mapState(["theme"]),
    calc(){
      if(this.number==''){
        return 0
      }
      if(this.type==1){
        return (parseFloat(this.number)*this.info.recharge_bili).toFixed(2)
      }
      if(this.type==2){
        return (parseFloat(this.number)/this.info.recharge_bili).toFixed(2)
      }
    }
  },
  onLoad() {
    this.$utils.setThemeTop(this.theme)
    uni.setNavigationBarTitle({
      title: this.$t("new.duih"),
    });
    this.getInfo();
  },
  methods: {
    setAll(){
      this.number = this.type==1?this.info.recharge_account_balance: this.info.settle_account_balance
    },
    changeType() {
      this.type = this.type == 1 ? 2 : 1;
    },
    getInfo() {
      var that = this;
      that.$utils.httpDataToken(
        { url: "forex/recharge_to_forex", type: "get" },
        (res) => {
          that.recharge_name = res.recharge_name;
          that.settle_name = res.settle_name;
          that.info = res;
        }
      );
    },
    submit(){
        var that = this;
      that.$utils.httpDataToken(
        { url: `forex/recharge_submit?type=${that.type}&number=${that.number}&settle_id=${that.info.settle_account.Id}&currency_id=${that.info.recharge_account.Id}`, type: "get" },
        (res,msg) => {
            that.number = ''
            that.getInfo();
            that.$utils.showLayer(msg)
        }
      );
    }
  },
};
</script>

<style></style>
