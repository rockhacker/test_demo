<template>
  <view class="sign-in">
    <view class="dark:text-white mb20 text-2xl">{{$t('new.lxqd')}}<text>{{day}}</text>{{$t('new.day')}}</view>
    <view class="flex justify-between">
      <view class="card" :class="{signed:day>=index+1}" v-for="(item, index) in list.slice(0, 4)" :key="index">
        <view class="mb-20 text-xl">Day {{index+1}}</view>
        <template v-if="day<index+1 && has_price_day<index + 1">
          <view class="flex items-center">
            <img class="h-50 w-50" src="../../static/image/wewe.png" alt="" />
          </view>

          <view class="mt-20 text-xl pb-10">{{item.price}}</view>
          <!-- <div class="text-center" v-if="lang=='th' && rate.rate">{{item.price}}U  ≈  {{  (item.price*rate.rate).toFixed(2) }}{{rate.flat_money}}</div> -->
        </template>
        <img class="h-50 w-50" v-else-if="day >= index + 1" src="../../static/image/duigou.png" alt="" />
      </view>
    </view>
    <view class="flex justify-around mt-40">
      <view class="card mr-20" :class="{signed:day>=index+5,flex2:index==2}" v-for="(item, index) in list.slice(4)" :key="index">
        <view class="mb-20 text-xl">Day {{index+5}}</view>
        <template v-if="day<index+5 && has_price_day<index + 5">
          <view class="flex items-center">
            <img class="h-50 w-50" src="../../static/image/wewe.png" alt="" />
            <!-- <text v-if="lang!='th'">{{item.price}}</text> -->
          </view>
          <view class="mt-20 text-xl pb-10" :class="{'text-3xl':index==2}">{{item.price}}</view>
          <!-- <div class="text-center" v-if="lang=='th' && rate.rate">{{item.price}}U  ≈  {{  (item.price*rate.rate).toFixed(2) }}{{rate.flat_money}}</div> -->
        </template>
        <img class="h-50 w-50" v-else-if="day >= index + 5" src="../../static/image/duigou.png" alt="" />
      </view>
    </view>

    
    
    <view v-if="list.length" class="text-lg text-center h-80 leading-80 mt-40 signed rounded-3xl" @click="signIn">
      {{$t('new.msqd')}}
    </view>

    <view class="mt-20">
        <view>{{$t('new.jlgz')}}:</view>
        <view class="mt-10">{{$t('new.jl1')}}</view>
        <view>{{$t('new.jl1desc')}}</view>
        <view class="mt-10">{{$t('new.jl2')}}</view>
        <view>{{$t('new.jl2desc')}}</view>
        <view class="mt-10">{{$t('new.jlnote')}}</view>
      </view>
  </view>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      day: 0,
      has_price_day:0,
      list: [],
      loading:false,
      rate:{},
      lang:""
    };
  },
  computed: {
    ...mapState(["theme"]),
  },
  mounted(e) {
    this.lang=uni.getStorageSync('lang')
    // this.$utils.setThemeTop(this.theme);
    // uni.setNavigationBarTitle({
    //   title: this.$t("new").qd,
    // });
    this.getConfig();
    this.getUserSignInfo();
    this.getCurrencyRate()
  },
  methods: {
    getCurrencyRate() {
      let that = this;
      that.$utils.initDataToken(
        { url: "quickCharge/getCurrencyRate", type: "get" },
        (res) => {
            if (res.length){
              that.rate = res[0]
            }
        }
      );
    },
    // 获取7天的配置
    getConfig() {
      this.$utils.initDataToken({ url: "sign/list", type: "get" }, (res) => {
        console.log(res, "config");
        this.list = res;
      });
    },
    getUserSignInfo() {
      this.$utils.initDataToken(
        { url: "sign/sign_day", type: "get" },
        (res) => {
          this.day = res.day;
          this.has_price_day = res.has_price_day;
        }
      );
    },
    signIn() {
      // if(this.loading){
      //   return
      // }
      // this.loading = true
      this.$utils.initDataToken(
        { url: "sign/userSign", type: "post" },
        (res, msg) => {
          // this.loading = false
          console.log(res);
          uni.showToast({
            icon: "none",
            title: msg,
          });
          this.getUserSignInfo()
        }
      );
    },
  },
};
</script>

<style lang="scss" scoped>
.sign-in {
  border-radius: 28rpx;
  margin: 40rpx;
  padding: 40rpx 20rpx;
  // background-color: #121826;
  .card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 150rpx;
    height: 200rpx;
    background-color: gainsboro;
    /* background-color: rgba(128, 128, 128, 0.438); */
    /* background: linear-gradient(175deg, #f7626d, #fa4e7b) !important; */
    border-radius: 18rpx;
  }

  .signed{
    background: linear-gradient(175deg, #3abffe, #1477fa) !important;
  }
}
</style>
