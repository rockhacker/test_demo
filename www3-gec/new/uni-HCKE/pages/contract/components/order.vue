<template>
  <view>
    <view @click="showDetail(true)" class="p-20 border-0 border-solid border-b-2 border-gray-600">
      <view class="flex">
        <view>{{
          info.type == 1 ? $t("second.inTransaction") : $t("second.closed")
        }}</view>
        <image
          class="w-20 h-24 mx-10"
          src="/static/image/top.png"
          alt=""
          v-if="ploss >= 0"
        />
        <image
          class="w-20 h-24 mx-10"
          src="/static/image/bottom.png"
          alt=""
          v-else
        />
        <view>{{ info.symbol_name }} {{ secondsFormat(info.seconds) }}</view>
      </view>
      <view class="flex justify-between mt-10">
        <view class="flex flex-col justify-center items-center">
          <view>{{ $t("second.quantity") }}</view>
          <view class="mt-10">{{ parseInt(info.number) }}</view>
        </view>
        <view class="flex flex-col justify-center items-center">
          <view>{{ $t("second.puprice") }}</view>
          <view class="mt-10">{{ info.open_price }}</view>
        </view>
        <view class="flex flex-col justify-center items-center">
          <view>{{info.status==1? $t("second.cuPrice") :$t('second.fiprice')}}</view>
          <view class="mt-10">{{ price }}</view>
        </view>
        <view class="flex flex-col justify-center items-center">
          <view>
            {{ info.status == 1 ? $t("second.profitLoss") : $t("second.loss") }}
          </view>
          <view class="mt-10" :class="[ploss>=0?'text-success':'text-danger']">{{ ploss }}</view>
        </view>
      </view>
      <view class="flex justify-between mt-10">
        <view  v-if="(info.status==1)" class="text-left">
          <view>{{ $t("second.Countdown") }}</view>
          <view  class="mt-10"   style="display: block">{{
            secondsFormat(remain_milli_seconds)
          }}</view>
        </view>
        <view class="flex flex-col justify-center items-center">
          <view class="text-center">{{ $t("trade.time_start") }}</view>
          <view class="mt-10">{{ info.created_at }}</view>
        </view>
        <view v-if="info.status == 3" class="flex flex-col justify-center items-center">
          <view class="text-center">{{ $t("trade.time_end") }}</view>
          <view class="mt-10">{{ info.handled_at }}</view>
        </view>
      </view>
    </view>
    <uni-popup :show="showOrderDetail" :btnShow="false" :msg="info.symbol_name" @hidePopup="showOrderDetail=false">
      <view class=" text-52 py-16" v-if="info.status ==3" :class="info.fact_profits < 0 ? 'text-danger': 'text-success'">{{ info.fact_profits >=0? '+':'' }} {{ info.fact_profits }}</view>
		  <template  v-else>
         <charts  :remain_milli_seconds="remain_milli_seconds" :info="info"></charts>
      </template>
      <!-- <view class="text-base">{{ secondsFormat(remain_milli_seconds)}}</view> -->
				<view class="pb-60 pt-20 w-full mt-30">
					<view class="flex justify-between w-full px-30 mb-20">
					<view class="text-base">{{$t('trade.types')}}</view>
					<view class="text-base">{{info.type==1? $t('trade.rise'): $t('trade.fall')}}</view>
				</view>

				<view class="flex justify-between w-full px-30 mb-20">
					<view class="text-base">{{$t('trade.num')}}</view>
					<view class="text-base">{{info.number}}</view>
				</view>

				<template v-if="info.status==3">
          <view  class="flex justify-between w-full px-30 mb-20">
					<view class="text-base">{{$t('trade.price_cang')}}</view>
					<view class="text-base">{{info.open_price}}</view>
				</view>

        <view  class="flex justify-between w-full px-30 mb-20">
					<view class="text-base">{{$t('trade.real_num')}}</view>
					<view class="text-base">{{info.end_price}}</view>
				</view>	
        </template>
        <template  v-else>
          <view class="flex justify-between w-full px-30 mb-20">
					<view class="text-base">{{$t('second.cuPrice')}}</view>
					<view class="text-base">{{price}}</view>
				</view>

        <view class="flex justify-between w-full px-30 mb-20">
					<view class="text-base">{{$t('lever.profit')}}</view>
          <view class="text-base" v-if="info.status ==3" :class="info.fact_profits < 0 ? 'text-danger': 'text-success'">{{ info.fact_profits >=0? '+':'' }} {{ info.fact_profits }}</view>
          <view class="text-base" v-else :class="ploss < 0 ? 'text-danger': 'text-success'">{{ ploss >=0? '+':'' }} {{ ploss }}</view>
				</view>
        </template>

        

				
				</view>

			</uni-popup>
  </view>
</template>

<script>
import uniPopup from '@/components/uni-popup.vue';
import { mapState } from "vuex";
import charts from "./charts.vue";
export default {
  components: {
		uniPopup,
    charts
	},
  props: ["info"],
  data() {
    return {
      timer: null,
      remain_milli_seconds: "",
      showOrderDetail:false
    };
  },
  computed: {
    ...mapState(["currencyMatch"]),
    price() {
      if(this.info.status!=1){
        return this.info.end_price
      }
      if (this.currencyMatch && this.currencyMatch.currency_quotation) {
        return this.currencyMatch.currency_quotation.close;
      }
      return "";
    },
    ploss() {
      const order = this.info;
      if (order.status != 1) {
        return order.fact_profits;
      }
      const match = this.currencyMatch;
      if (!match.currency_quotation) {
        return "";
      }
      const buy = parseFloat(this.info.open_price);
      const current = parseFloat(match.currency_quotation.close);
      const number = parseFloat(order.number);
      // 买涨
      if (order.type == 1) {
        if (current > buy) {
          return number * order.profit_ratio;
        } else if (current < buy) {
          return number * order.profit_ratio * -1;
        } else {
          return 0;
        }
      } else {
        if (current < buy) {
          return number * order.profit_ratio;
        } else if (current > buy) {
          return number * order.profit_ratio * -1;
        } else {
          return 0;
        }
      }
    },
  },
  mounted() {
    this.remain_milli_seconds = this.info.seconds
    if(this.info.show){
      this.showDetail()
    }
    if(this.info.status!=1){
      return
    }
    this.timer = setInterval(() => {
      this.remain_milli_seconds = parseInt(this.remain_milli_seconds - 1);
      console.log(this.remain_milli_seconds)
      if (this.remain_milli_seconds <= 0) {
        this.remain_milli_seconds = 0;
        clearInterval(this.timer);
        this.$emit('update',this.info.id)
        this.timer = null;
      }
    }, 1000);
  },
  methods: {
    showDetail(bool){
      // if(this.info.status !=3){
      //   return
      // }
    
      this.showOrderDetail = true
    
    },
    // format(s) {
    //   var day = Math.floor(s / (24 * 3600)); // Math.floor()向下取整
    //   var hour = Math.floor((s - day * 24 * 3600) / 3600);
    //   var minute = Math.floor((s - day * 24 * 3600 - hour * 3600) / 60);
    //   var second = s - day * 24 * 3600 - hour * 3600 - minute * 60;
    //   return day > 0
    //     ? day + this.$t("second.tian")
    //     : hour > 0
    //     ? hour + this.$t("second.shi")
    //     : minute > 0
    //     ? minute + this.$t("second.fenz")
    //     : second + this.$t("second.miao");
    // },
    secondsFormat(s) {
      var day = Math.floor(s / (24 * 3600)); // Math.floor()向下取整
      var hour = Math.floor((s - day * 24 * 3600) / 3600);
      var minute = Math.floor((s - day * 24 * 3600 - hour * 3600) / 60);
      var second = s - day * 24 * 3600 - hour * 3600 - minute * 60;
      let d = day > 0 ? day + this.$t("second.tian") : "";
      let h = hour > 0 ? hour + this.$t("second.shi") : "";
      let m = minute > 0 ? minute + this.$t("second.fenz") : "";
      let se = second >= 0 ? second + this.$t("second.miao") : "";
      return d + h + m + se;
    },
  },
  beforeDestroy() {
    console.log("beforeDestroy");
    if (this.timer) {
      clearInterval(this.timer);
      this.timer = null;
    }
  },
};
</script>

<style></style>
