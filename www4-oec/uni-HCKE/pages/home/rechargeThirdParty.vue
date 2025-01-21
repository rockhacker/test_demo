<template>
  <view :class="theme">
    <view class="bg-white dark:bg-floor min-h-screen">
      <view class="py-40 text-2xl text-center">
        {{ $t("trade.buy") }} USDT
      </view>
      <view class="flex justify-center items-center">
        <image
          src="../../static/image/USDT.png"
          class="w-50 h-50 mr-20"
        ></image>
        <span class="text-base" v-if="coin.list.length">
          1USDT ≈ {{ parseFloat(coin.list[coin.active].rate) }}
          {{ coin.list[coin.active].flat_money }}
        </span>
      </view>

      <view v-if="lang !='th'" class="text-center my-30 text-base">{{$t('new.llqyz')}}</view>
      <view
        class="mt-60 px-30 flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-800"
      >
        <input
        type="digtal"
          class="h-100 flex-1"
          v-model="number"
          :placeholder="$t('trade.p_num')"
        />
        <view class="flex items-center">
          <picker
            :range="coin.list"
            range-key="flat_money"
            @change="pickChange"
          >
            <view
              class="text-gray-400 text-lg pr-20"
              v-if="coin.list.length"
              >{{ coin.list[coin.active].flat_money || "--" }}</view
            >
          </picker>
        </view>
      </view>
      <view class="text-base mt-20 text-center" v-if="coin.list.length">
            {{number==''?0:number }}{{coin.list[coin.active].flat_money}} ≈ {{calc}}USDT
      </view>
      <view class="px-30 py-20 mt-40">
        <view
          class="bg-primary text-black rounded-10 p-30 text-lg text-center"
          hover-class="opacity-50"
          @click="submit"
        >
          {{ $t("login.e_confrim") }}
        </view>
      </view>

      <div class="white my-30 px-20 pb-20">
          <div class="">
            <div class=" flex  alcenter jscenter radius10 mt20  plr10" style="background-color: rgb(23 183 148 / 1);">
              <img class="w-200" src="../../static/image/instant.png" />
              <div>
                <div class="bold text-3xl">{{ $t("new.jszz") }}</div>
                <div>{{ $t("new.jszzdc") }}</div>
              </div>
            </div>
            <div class=" flex  alcenter jscenter radius10 mt20  plr10" style="background-color: rgb(40 81 138  / 1);">
              <img class="w-200" src="../../static/image/easy_quick.png" />
              <div>
                <div class="bold text-3xl">{{ $t("new.ksyz") }}</div>
                <div>{{ $t("new.ksyzdc") }}</div>
              </div>
            </div>
          </div>
          <div>
            <div class=" flex  alcenter jscenter radius10 mt20  plr10" style="background-color: rgb(40 81 138 / 1);">
              <img class="w-200" src="../../static/image/secure.png" />
              <div>
                <div class="bold text-3xl">{{ $t("new.aqjy") }}</div>
                <div>{{ $t("new.aqjydc") }}</div>
              </div>
            </div>
            <div class=" flex  alcenter jscenter radius10 mt20  plr10" style="background-color: rgb(1 0 94 / 1);">
              <img class="w-200" src="../../static/image/support.png" />
              <div>
                <div class="bold text-3xl">{{ $t("new.qtzc") }}</div>
                <div>{{ $t("new.qtzcdc") }}</div>
              </div>
            </div>
          </div>
        </div>

    </view>
  </view>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      number: "",
      coin: {
        list: [],
        active: 0,
      },
      lang:'en'
    };
  },
  computed: {
    ...mapState(["theme"]),
    calc(){
      if(this.number == ''){
        return 0
      }
      return (parseFloat(this.number)/ parseFloat(this.coin.list[this.coin.active].rate)).toFixed(4)
    }
  },
  onLoad() {
    uni.setNavigationBarTitle({
      title: this.$t("new.dsfcz"),
    });
    this.$utils.setThemeTop(this.theme);
    this.getSymbols();
    this.lang = uni.getStorageSync('lang') || 'en';
  },
  methods: {
    pickChange(e) {
      console.log(e);
      this.coin.active = e.detail.value;
    },
    getSymbols() {
      const that = this;
      that.$utils.initDataToken(
        {
          url: "quickCharge/getCurrencyRate",
          type: "GET",
        },
        (res) => {
          // console.log(res)
          if (res.length) that.$set(that.coin, "list", res);
        }
      );
    },
    submit() {
      if (!this.number) return this.$utils.showLayer(this.$t("legal.p_amout"));
      let number = parseFloat(this.number);
      let min_money = parseFloat(this.coin.list[this.coin.active].min_money);
      let max_money = parseFloat(this.coin.list[this.coin.active].max_money);
      if (number < min_money || number > max_money)
        return this.$utils.showLayer(
          this.$t("legal.p_amout") + min_money + "-" + max_money
        );

       let  newWindow = null

       if(this.lang !='th'){
        newWindow = window.open('', '_blank');
       }
      
      this.$utils.initDataToken(
        {
          url: "quickCharge/recharge_submit",
          type: "POST",
          data: {
            amount: this.number,
            currency_rate_id: this.coin.list[this.coin.active].id,
          },
        },
        (res, msg) => {
          // console.log(res);
          if (res.status == 2) {
            // window.open(res.url)
           if(this.lang != 'th'){
            newWindow.location = res.url;
            this.number = ''
           }else{
             uni.navigateTo({
              url: "/pages/home/webPay?path=" + res.url,
            });
           }
            // uni.navigateTo({
            //   url: "/pages/home/webPay?path=" + res.url,
            // });
            // this.$utils.showLayer(msg);
          }else{
            this.lang != 'th' &&  newWindow.close()
          }
        },
        false,true
      );
    },
  },
};
</script>

<style></style>
