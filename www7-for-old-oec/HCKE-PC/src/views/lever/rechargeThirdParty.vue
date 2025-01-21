<template>
  <div class="rechageThirdParty minh100 ft16">
    <div class="mauto wt1200 ptb20">
      <el-card class="mb20 pb20">
        <div class="flex column alcenter">
          <div class="tc">{{ $t("trade.buy") }} USDT</div>
          <div class="mt20 flex jscenter alcenter">
            <img style="width:30px" src="../../assets/images/USDT.png" />
            <div class="ml20" v-if="coin.list[coin.active]">
              1USDT ≈ {{ parseFloat(coin.list[coin.active].rate) }}
              {{ coin.list[coin.active].flat_money }}
            </div>
          </div>
          <el-input
            :placeholder="$t('trade.p_num')"
            v-model="number"
            class="input-with-select mt20 w70 baselight"
          >
            <el-select v-model="coin.active" slot="append" placeholder="请选择">
              <el-option
                v-for="(item, index) in coin.list"
                :key="index"
                :label="item.flat_money"
                :value="index"
              />
            </el-select>
          </el-input>
          <div class="mt20" v-if="coin.list.length">
            {{ number == "" ? 0 : number
            }}{{ coin.list[coin.active].flat_money }} ≈ {{ calc }}USDT
          </div>
          <div
            class="bgblue w70 mt20 ht40 flex alcenter jscenter  white radius6 ft16 pointer"
            @click="submit"
          >
            {{ $t("collect.submits") }}
          </div>
        </div>
        <div class="white mt30">
          <div class="flex">
            <div class="flex1 flex  alcenter jscenter radius10 mt20 mr10 plr10" style="background-color: rgb(23 183 148 / 1);">
              <img style="width:150px" src="../../assets/images/instant.png" />
              <div>
                <div class="bold ft24">{{ $t("new.jszz") }}</div>
                <div>{{ $t("new.jszzdc") }}</div>
              </div>
            </div>
            <div class="flex1 flex  alcenter jscenter radius10 mt20 ml10 plr10" style="background-color: rgb(40 81 138  / 1);">
              <img style="width:150px" src="../../assets/images/easy_quick.png" />
              <div>
                <div class="bold ft24">{{ $t("new.ksyz") }}</div>
                <div>{{ $t("new.ksyzdc") }}</div>
              </div>
            </div>
          </div>
          <div class="flex">
            <div class="flex1 flex  alcenter jscenter radius10 mt20 mr10 plr10" style="background-color: rgb(40 81 138 / 1);">
              <img style="width:150px" src="../../assets/images/secure.png" />
              <div>
                <div class="bold ft24">{{ $t("new.aqjy") }}</div>
                <div>{{ $t("new.aqjydc") }}</div>
              </div>
            </div>
            <div class="flex1 flex  alcenter jscenter radius10 mt20 ml10 plr10" style="background-color: rgb(1 0 94 / 1);">
              <img style="width:150px" src="../../assets/images/support.png" />
              <div>
                <div class="bold ft24">{{ $t("new.qtzc") }}</div>
                <div>{{ $t("new.qtzcdc") }}</div>
              </div>
            </div>
          </div>
        </div>
      </el-card>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      number: "",
      coin: {
        list: [],
        active: 0,
      },
    };
  },
  created() {
    this.getSymbols();
  },
  computed: {
    calc() {
      if (this.number == "") {
        return 0;
      }
      console.log(this.number,this.coin.list[this.coin.active].rate);
      return (
        parseFloat(this.number) /
        parseFloat(this.coin.list[this.coin.active].rate)
      ).toFixed(4);
    },
  },
  methods: {
    getSymbols() {
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
          if (res.length) that.$set(that.coin, "list", res);
        });
    },
    submit() {
      if (!this.number) return this.$utils.layerMsg(this.$t("legal.p_amout"));
      let number = parseFloat(this.number);
      let min_money = parseFloat(this.coin.list[this.coin.active].min_money);
      let max_money = parseFloat(this.coin.list[this.coin.active].max_money);
      if (number < min_money || number > max_money)
        return this.$utils.layerMsg(
          this.$t("legal.p_amout") + min_money + "-" + max_money
        );
      this.$http
        .initDataToken(
          {
            url: "quickCharge/recharge_submit",
            type: "POST",
            data: {
              amount: this.number,
              currency_rate_id: this.coin.list[this.coin.active].id,
            },
          },
          false
        )
        .then((res) => {
          console.log(res);
          if (res.status == 2) {
            window.open(res.url);
          }
        });
    },
  },
};
</script>

<style lang="scss">
.rechageThirdParty {
  .el-input-group__append,
  .el-input-group__prepend {
    width: 150px;
    background-color: transparent !important;
  }
  .new-gray {
    background: #f3f3f3;
  }
}
</style>
