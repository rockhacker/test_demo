<template>
  <div class="legalWithdraw w100 pt40">
    <div class="mauto w60 ptb20 bgpart">
      <div>
      <ul class="pt20 plr20 w100">
      <li class="flex between alcenter">
        <span>{{$t('collect.name')}}：</span>
        <input
          :disabled="true"
          type="text"
          v-model="realName"
          :placeholder="$t('collect.p_name')"
          class="ht30 bdinput lh30 plr10 radius2 ml10 w80 nwhite"
        />
      </li>
      <li class="flex between alcenter mt20">
        <span>{{$t('collect.nameofopeningbank')}}：</span>
        <input
        :disabled="true"
          type="text"
          v-model="bankName"
          :placeholder="$t('collect.pleaseenterthenameoftheopeningbank')"
          class="ht30 bdinput lh30 plr10 radius2 ml10 w80 nwhite"
        />
      </li>
      <li class="flex between alcenter mt20">
        <span>{{$t('collect.nameofopeningbranch')}}：</span>
        <input
        :disabled="true"
          type="text"
          v-model="bankAddress"
          :placeholder="$t('collect.pleaseenterthenameoftheopeningbranch')"
          class="ht30 bdinput lh30 plr10 radius2 ml10 w80 nwhite"
        />
      </li>
      <li class="flex between alcenter mt20">
        <span>{{$t('collect.no')}}：</span>
        <input
        :disabled="true"
          type="text"
          v-model="bankAccount"
          :placeholder="$t('collect.p_no')"
          class="ht30 bdinput lh30 plr10 radius2 ml10 w80 nwhite"
        />
      </li>
      <li class="flex between alcenter mt20">
        <span>{{$t('collect.brachCode')}}：</span>
        <input
        :disabled="true"
          type="text"
          v-model="bankCode"
          :placeholder="$t('collect.pleaseenterthebankcode')"
          class="ht30 bdinput lh30 plr10 radius2 ml10 w80 nwhite"
        />
      </li>
    </ul>
    </div>
    <div class="pt20  pr40 w100">
      <div class="ml20 mt20"  v-if="coin.list.length">
              {{ parseFloat(coin.list[coin.active].rate) }}
              {{ coin.list[coin.active].flat_money }} ≈ 1USDT 
            </div>
      <el-input
            :placeholder="$t('trade.p_num')"
            v-model="number"
            class="input-with-select bdinput mt20 w100 ml20 nwhite"
          >
          <div v-if="coin.list.length" class="my-select tc" slot="append">
            {{coin.list[coin.active].flat_money}}
          </div>
            <!-- <el-select class="my-select" v-model="coin.active" slot="append" placeholder="请选择">
              <el-option
                v-for="(item, index) in coin.list"
                :key="index"
                :label="item.flat_money"
                :value="index"
              />
            </el-select> -->
          </el-input>

          <div class="ml20 mt20 flex alcenter between">
           <div  v-if="coin.list[coin.active]"> {{ number == "" ? 0 : number
            }} {{ coin.list[coin.active].flat_money }} ≈ {{ calc }} USDT</div>
            <div>{{$t('trade.use')}}  : {{balance}} USDT</div>
          </div>

      <div
        class="bgblue w100 ml20 mt20 ht40 flex alcenter jscenter  white radius6 ft16 pointer"
        @click="submit"
      >
        {{ $t("collect.submits") }}
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
      balance:"",
      realName: "",
      bankName: "",
      bankAccount: "",
      bankCode: "",
      bankAddress: "",
      number: "",
      coin: {
        list: [],
        active: 0,
      },
      user_payway_id:""
    };
  },
  created(){
    this.getBalance()
    this.getBankList()
    this.getCurrencyRate()
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
  methods:{
    getBalance() {
      const that = this;
      that.$http
        .initDataToken(
          {
            url: "account/list",
            type: "GET",
          },
          false
        )
        .then((res) => {
          that.balance = res[0].accounts[0].balance
          console.log(res,'account');
        });
    },
    getBankList(){
      const that = this
        this.$http.initDataToken(
            {
                url: "pay_method/get_method_by_type?type=5",
                type: "GET"
            },
            false,
        ).then((res)=>{
          that.user_payway_id = res.id;
          that.realName = res.raw_data.real_name;
              that.bankName = res.raw_data.bank_name;
              that.bankAccount = res.raw_data.card_no;
              that.bankCode = res.raw_data.bank_code;
              that.bankAddress = res.raw_data.bank_address;
            console.log(res,'bank list');
        })
    },
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
          if (res.length) that.$set(that.coin, "list", res);
        });
    },
    submit() {
      if (!this.number) return this.$utils.layerMsg(this.$t("legal.p_amout"));
      let number = parseFloat(this.number);
      this.$http
        .initDataToken(
          {
            url: "quickCharge/with_submit",
            type: "POST",
            data: {
              amount: this.number,
              currency_rate_id: this.coin.list[this.coin.active].id,
              user_payway_id: this.user_payway_id
            },
          }
        )
        .then((res) => {
          this.getBalance()
          this.number = ''
          // if (res.status == 1) {
            
          // this.$notify.success({
          //               // showClose:false,
          //               customClass: 'gobal_tip gobal_tip_success',
          //               message: this.$t('feed.ok')
          //             });
          // }else{
          //   this.$notify.error({
          //       // showClose:false,
          //       customClass: 'gobal_tip gobal_tip_error',
          //       message: res.msg
          //     });
          // }
          
        });
    },
  }
};
</script>

<style lang="scss">
.legalWithdraw {
  .el-input-group__append,
  .el-input-group__prepend {
    width: 150px;
    background-color: transparent !important;
  }
  .el-input__inner,.el-input-group__append{
    border: 0;
  }
  /* 1px solid #e9e9e9 */
  /* border: 1px solid #273344;  */
  .new-gray {
    background: #f3f3f3;
  }
}
</style>