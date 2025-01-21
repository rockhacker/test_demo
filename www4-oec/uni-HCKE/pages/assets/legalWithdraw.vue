<template>
  <view  :class="theme">
    <view class="bg-white dark:bg-floor">
      <view
        class="flex items-center pl-20 mt-20 border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700"
      >
        <text class="text-right">{{ $t("collect.name") }}：</text>
        <input
          :disabled="true"
          type="text"
          v-model="name"
          class="h-80 flex-1 pr-20 text-right"
        />
      </view>
      <view
        class="flex items-center pl-20 mt-20 border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700"
      >
        <text class="text-right">{{ $t("collect.bank") }}：</text>
        <input
        :disabled="true"
          type="text"
          v-model="kaihu"
          class="h-80 flex-1 pr-20 text-right"
        />
      </view>
      <view
        class="flex items-center pl-20 mt-20 border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700"
      >
        <text class="text-right">{{ $t("collect.no") }}：</text>
        <input
        :disabled="true"
          type="text"
          v-model="card_no"
          class="h-80 flex-1 pr-20 text-right"
        />
      </view>
      <view
        class="flex items-center pl-20 mt-20 border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700"
      >
        <text class="text-right">{{ $t("collect.z_bank") }}：</text>
        <input
        :disabled="true"
          type="text"
          v-model="bank_adress"
          class="h-80 flex-1 pr-20 text-right"
        />
      </view>
      <view
        class="flex items-center pl-20 mt-20 border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700"
      >
        <text class="text-right">{{ $t("collect.bank_code") }}：</text>
        <input
        :disabled="true"
          type="text"
          v-model="bank_code"
          class="h-80 flex-1 pr-20 text-right"
        />
      </view>

      <view class="flex items-center pl-20 h-80 mt-20 border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700" v-if="coin.list[coin.active]">
         {{ parseFloat(coin.list[coin.active].rate) }}
          {{ coin.list[coin.active].flat_money }} ≈ 1USDT  
        </view>
        

      <view
        class="mt-20 px-20 flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-800"
      >
        <input
        type="digtal"
          class="h-100 flex-1"
          v-model="number"
          :placeholder="$t('trade.p_num')"
        />
        <view class="flex items-center">
          <!-- <picker
            :range="coin.list"
            range-key="flat_money"
            @change="pickChange"
          > -->
            <view
              class="text-black dark:text-gray-400 text-lg pr-20"
              v-if="coin.list[coin.active]"
              >{{ coin.list[coin.active].flat_money || "--" }}</view
            >
          <!-- </picker> -->
        </view>
      </view>

      <view class="flex items-center justify-between  px-20 h-80 mt-20 border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700" v-if="coin.list[coin.active]">
        <text> {{number==''?0:number }} {{coin.list[coin.active].flat_money}} ≈ {{calc}}  USDT</text> 
        <text>{{$t('trade.use')}} : {{balance}}</text>
        </view>

        <view
          class="bg-primary text-black rounded-10 mx-20 mt-20 p-30 text-lg text-center"
          hover-class="opacity-50"
          @click="submit"
        >
          {{ $t("login.e_confrim") }}
        </view>
    </view>
  </view>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      name: "",
      mobile: "",
      kaihu: "",
      card_no: "",
      bank_adress: "",
      bank_code: "",
      number: "",
      coin: {
        list: [],
        active: 0,
      },
      balance:"",
      user_payway_id:""
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
  onLoad(e) {
    this.$utils.setThemeTop(this.theme);
    uni.setNavigationBarTitle({
      title: this.$t("new").fbtx,
    });
    this.getBankInfo();
    this.getCurrencyRate();
    this.getBalance()
  },
  methods: {
    pickChange(e) {
      console.log(e);
      this.coin.active = e.detail.value;
    },
    getBankInfo() {
      let that = this;
      //获取用户信息
      that.$utils.initDataToken(
        { url: "pay_method/get_method_by_type?type=5", type: "get" },
        (res) => {
            that.user_payway_id = res.id;
          that.name = res.raw_data.real_name;
          that.kaihu = res.raw_data.bank_name;
          that.card_no = res.raw_data.card_no;
          that.bank_adress = res.raw_data.bank_address;
          that.bank_code = res.raw_data.bank_code;
          console.log(res);
        }
      );
    },
    getCurrencyRate() {
      let that = this;
      that.$utils.initDataToken(
        { url: "quickCharge/getCurrencyRate", type: "get" },
        (res) => {
            if (res.length) that.$set(that.coin, "list", res);
        }
      );
    },
    getBalance(){
        let that = this;
      that.$utils.initDataToken(
        { url: "account/list", type: "get" },
        (res) => {
            that.balance = res[0].accounts[0].balance
        }
      );
    },
    submit() {
      if (!this.number) return this.$utils.showLayer(this.$t("legal.p_amout"));
    //   let number = parseFloat(this.number);
    //   let min_money = parseFloat(this.coin.list[this.coin.active].min_money);
    //   let max_money = parseFloat(this.coin.list[this.coin.active].max_money);
    //   if (number < min_money || number > max_money)
    //     return this.$utils.showLayer(
    //       this.$t("legal.p_amout") + min_money + "-" + max_money
    //     );
      this.$utils.initDataToken(
        {
          url: "quickCharge/with_submit",
          type: "POST",
          data: {
            amount: this.number,
            currency_rate_id: this.coin.list[this.coin.active].id,
            user_payway_id: this.user_payway_id
          },
        },
        (res, msg) => {
          // console.log(res);
          // if (res.status == 1) {
            this.getBalance()
            this.number = ''
            // uni.navigateTo({
            //   url: "/pages/home/webPay?path=" + res.url,
            // });
            this.$utils.showLayer(msg);
          // }else{
          //   this.$utils.showLayer(res.msg);
          // }
        }
      );
    },
  },
};
</script>

<style></style>
