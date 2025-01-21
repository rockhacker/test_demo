<template>
  <div class="minh100 ft16 sign-in">
    <div class="mauto wt800 ptb20">
      <div class="white ft28">{{$t('new.lxqd')}}<span>{{day}}</span>{{$t('new.day')}}</div>
      <div class="ft22 mb20 f-item mt20 pb40" v-if="list.length">
        <div class="sign-in">
          <div class="flex around white">
            <div
              class="card bgheader flex1 mr20"
              :class="{ signed: day >= index + 1}"
              v-for="(item, index) in list.slice(0, 4)"
              :key="index"
            >
              <div class="mb20 span-xl">Day {{ index + 1 }}</div>
              <template v-if="day < index + 1 && has_price_day<index + 1">
                <div class="flex alcenter">
                  <img class="h-50 w-50 mb10" src="../../../static/imgs/jinbi.png" alt="" />
                  
                </div>

                <div>{{  item.price }}</div>
                <!-- <div class="tc" v-if="lang=='th' && rate.rate">{{item.price}}U  ≈  {{  (item.price*rate.rate).toFixed(2) }}{{rate.flat_money}}</div> -->
              </template>
              <img
                class="h-50 w-50"
                v-else-if="day >= index + 1"
                src="../../../static/imgs/duigou.png"
                alt=""
              />
            </div>
          </div>
          <div class="flex around mt40 white">
            <div
              class="card bgheader flex1 mr20"
              
              :class="{ signed: day >= index + 5,flex2:index==2 }"
              v-for="(item, index) in list.slice(4)"
              :key="index"
            >
              <div class="mb20 span-xl">Day {{ index + 5 }}</div>
              <template v-if="day < index + 5 && has_price_day<index + 5">
                <div class="flex alcenter">
                  <img class="h-50 w-50 mb10" src="../../../static/imgs/jinbi.png" alt="" />
                  <!-- <span v-if="lang!='th'">{{  item.price }}</span> -->
                </div>
                <span  :class="{ ft30:index==2 }">{{  item.price }}</span>
                <!-- <div class="tc" v-if="lang=='th' && rate.rate">{{item.price}}U  ≈  {{  (item.price*rate.rate).toFixed(2) }}{{rate.flat_money}}</div> -->
              </template>
              <img
                class="h-50 w-50"
                v-else-if="day >= index + 5"
                src="../../../static/imgs/duigou.png"
                alt=""
              />
            </div>
          </div>

          <div
            v-if="list.length"
            class="signed mt40 ptb20 w80 mauto radius40 tc white pointer"
            @click="signIn"
          >
            {{ $t("new.msqd") }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      day: 0,
      has_price_day:0,
      list: [],
      loading: false,
      rate:{},
      lang:""
    };
  },
  created() {
    this.lang = localStorage.getItem("lang");
    this.getConfig();
    this.getUserSignInfo();
    this.getCurrencyRate()
  },
  methods: {
    getCurrencyRate(){
      const that = this;
      that.$http
        .initDataToken(
          {
            url: "quickCharge/getCurrencyRate",
            type: "GET",
          },
          false
        )
        .then((res) => {
          console.log(res);
          that.rate = res[0]
          // if (res.length) that.$set(that.coin, "list", res);
        });
    },
    // 获取7天的配置
    getConfig() {
      this.$http
        .initDataToken({ url: "sign/list", type: "get" }, false)
        .then((res) => {
          console.log(res, "config");
          this.list = res;
        });
    },
    getUserSignInfo() {
      this.$http
        .initDataToken({ url: "sign/sign_day", type: "get" }, false)
        .then((res) => {
          this.day = res.day;
          this.has_price_day = res.has_price_day;
        });
    },
    signIn() {
      this.$http
        .initDataToken({ url: "sign/userSign", type: "post" })
        .then((res, msg) => {
          // this.loading = false
          console.log(res);
          this.getUserSignInfo();
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.sign-in {
  .card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 120px;
    height: 160px;
    /* background: linear-gradient(175deg, #f7626d, #fa4e7b) !important; */
    border-radius: 30px;
  }

  .signed {
    background: linear-gradient(175deg, #3abffe, #1477fa) !important;
  }

  .h-50{
    height: 50px;
  }

  .w-50{
    width: 50px;
  }
}
</style>
