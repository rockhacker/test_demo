<template>
  <div class="baselight">
    <div class="flex between baselight2 ptb20 plr20 ft16  bgwhite dark-bg-1C2532 border-b-999FAA">
      <span>{{$t('assets.currencyTransfer')}}</span>
      <router-link :to="{name:'transferLog',query:{currency_id:currency_id,currency_code:curcoin}}" class="text-333333 dark-text-white">{{$t('assets.transferRecord')}}</router-link>
    </div>
    <div class="plr20 pt20 pb50 cointransfer">
      <div>
        <div class="flex alcenter">
        <span class="inblock wt80">{{$t('assets.transferCurrency')}}:</span>
        <el-select v-model="curcoin" class="flex1" @change="changeCoin" placeholder="">
          <el-option
            v-for="item in coinlist"
            :key="item.currency_id"
            :label="item.currency_code"
            :value="item.currency_code"
          ></el-option>
        </el-select>
      </div>
      <div class="flex mt30 alcenter">
        <div class="wt80">{{$t('assets.transferAccount')}}:</div>
        <div class="flex alcenter flex1">
          
            <div class="pr10">{{$t('assets.from')}}</div>
            <el-select class="flex1" v-model="fromtype" @change="changetransfer1" placeholder="">
                <el-option
                  v-for="item in accoutlist"
                  :key="item.account_code"
                  :label="item.name"
                  :value="item.name"
                >
                  <!-- <span class="">{{ item }}</span> -->
                </el-option>
              </el-select>
              <div class="plr10">{{$t('assets.reach')}}</div>
              <el-select class="flex1" v-model="totype" @change="changetransfer2" placeholder="">
                <el-option
                  v-for="item in accoutlist"
                  :key="item.account_code"
                  :label="item.name"
                  :value="item.name"
                >
                  <!-- <span class="">{{ item }}</span> -->
                </el-option>
              </el-select>
            <!-- <div class="mt20">余额：12</div> -->
          <!-- <div class="tc plr20">
            <img src="../../assets/images/huazhuan.png" class="wt40 ht40 mtb20" alt />
          </div>-->
          
        </div>
      </div>
        <div  class="flex">
          <div class="wt80"></div>
          <div class="mt10">{{$t('trade.balance')}}: {{balance||'0.00'}}</div>
        </div>
      </div>
      <div class="mt30 flex alcenter">
        <span class="inblock wt80">{{$t('assets.transfernum')}}:</span>
		<div class="ht40 lh40 radius2 baselight2 flex1">
			<el-input type="number" class="h100 baselight2 w100" v-model="number" />
			<!-- <span class="plr10" @click="number=balance">{{$t('assets.max')}}</span> -->
		</div>
      </div>
      <div class="flex mt30">
        <div class="wt80"></div>
        <div class=" lh48 ht48 tc white ft16 radius4 flex1 bg-main-liner" @click="transferConfirm">{{$t('login.e_confrim2')}}</div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      accoutlist: [],
      coinlist: [],
      curindex: 0,
      curcoin: "",
      fromtype: "",
      totype: "",
      number: "",
      changeTransfer: 0,
      legalTransfer: 0,
      leverTransfer: 0,
      from: "",
      tos: "",
      currency_id: "",
      balance: "",
      transferData: []
    };
  },
  created() {
    var that = this;
    that.init();
  },
  methods: {
    init() {
      var that = this;
      that.$http.initDataToken({ url: "account/list" }, false).then(res => {
        that.transferData = res;

        res.forEach(item => {
          if (item.is_recharge == 1 && item.account_code == "change_account") {
            that.changeTransfer = 1;
            var datas = item.accounts;
            var arr = datas.filter(
              options =>
                options.currency.is_recharge_account &&
                options.currency.account_types.length > 1
            );
            that.coinlist = arr;
            that.accoutlist = arr[0].currency.account_types;
            that.fromtype = that.accoutlist[0].name;
            that.totype = that.accoutlist[1].name;
            that.currency_id = arr[0].currency_id;
            that.curcoin = arr[0].currency_code;
            that.from = that.accoutlist[0].account_code;
            that.tos = that.accoutlist[1].account_code;
            var data1 = that.transferData.filter(
              options => options.account_code == that.accoutlist[0].account_code
            );
            that.balance = data1[0].accounts.filter(
              options => options.currency_id == that.currency_id
            )[0].balance;
          } else if (
            item.is_recharge == 1 &&
            item.account_code == "legal_account"
          ) {
            that.legalTransfer = 1;
            var datas = item.accounts;
            var arr = datas.filter(
              options =>
                options.currency.is_recharge_account &&
                options.currency.account_types.length > 1
            );
            that.coinlist = arr;
            that.accoutlist = arr[0].currency.account_types;
            that.fromtype = that.accoutlist[0].name;
            that.totype = that.accoutlist[1].name;
            that.currency_id = arr[0].currency_id;
            that.curcoin = arr[0].currency_code;
            that.from = that.accoutlist[0].account_code;
            that.tos = that.accoutlist[1].account_code;
            var data1 = that.transferData.filter(
              options => options.account_code == that.accoutlist[0].account_code
            );
            that.balance = data1[0].accounts.filter(
              options => options.currency_id == that.currency_id
            )[0].balance;
          } else if (
            item.is_recharge == 1 &&
            item.account_code == "lever_account"
          ) {
            that.leverTransfer = 1;
            var datas = item.accounts;
            var arr = datas.filter(
              options =>
                options.currency.is_recharge_account &&
                options.currency.account_types.length > 1
            );
            that.coinlist = arr;
            that.accoutlist = arr[0].currency.account_types;
            that.fromtype = that.accoutlist[0].name;
            that.totype = that.accoutlist[1].name;
            that.currency_id = arr[0].currency_id;
            that.curcoin = arr[0].currency_code;
            that.from = that.accoutlist[0].account_code;
            that.tos = that.accoutlist[1].account_code;
            var data1 = that.transferData.filter(
              options => options.account_code == that.accoutlist[0].account_code
            );
            that.balance = data1[0].accounts.filter(
              options => options.currency_id == that.currency_id
            )[0].balance;
          }
        });
      });
    },
     // 切换左侧划转账户
    changetransfer1(e) {
      var that = this;
      var obj = that.accoutlist.filter(item => item.name == e)[0];
      that.fromtype = obj.name;
      that.from = obj.account_code;
      var data1 = that.transferData.filter(
        options => options.account_code == that.from
      );
      that.balance = data1[0].accounts.filter(
        options => options.currency_id == that.currency_id
      )[0].balance;
    
      if (that.changeTransfer == 1) {
        if (obj.account_code == "change_account") {
          that.totype = that.accoutlist.filter(
            options => options.account_code != "change_account"
          )[0].name;
          that.tos = that.accoutlist.filter(
            options => options.account_code != "change_account"
          )[0].account_code;
        }
      } else if (that.legalTransfer) {
        if (obj.account_code == "legal_account") {
          that.totype = that.accoutlist.filter(
            options => options.account_code != "legal_account"
          )[0].name;
          that.tos = that.accoutlist.filter(
            options => options.account_code != "legal_account"
          )[0].account_code;
        }
      }  else if (that.microTransfer) {
        if (obj.account_code == "micro_account") {
          that.totype = that.accoutlist.filter(
            options => options.account_code != "micro_account"
          )[0].name;
          that.tos = that.accoutlist.filter(
            options => options.account_code != "micro_account"
          )[0].account_code;
        } 
      }else if (that.leverTransfer == 1) {
        if (obj.account_code == "lever_account") {
          that.totype = that.accoutlist.filter(
            options => options.account_code != "lever_account"
          )[0].name;
          that.tos = that.accoutlist.filter(
            options => options.account_code != "lever_account"
          )[0].account_code;
        } 
      }
    },
    // 切换右侧划转账户
    changetransfer2(e) {
      var that = this;
      var obj = that.accoutlist.filter(item => item.name == e)[0];
      that.totype = obj.name;
      that.tos = obj.account_code;
      console.log(that.from ,that.tos)
      if (that.changeTransfer == 1) {
        if (obj.account_code == "change_account") {
          that.fromtype = that.accoutlist.filter(
            options => options.account_code != "change_account"
          )[0].name;
          that.from = that.accoutlist.filter(
            options => options.account_code != "change_account"
          )[0].account_code;
        }
        var data1 = that.transferData.filter(
          options => options.account_code == that.from
        );
        that.balance = data1[0].accounts.filter(
          options => options.currency_id == that.currency_id
        )[0].balance;
      } else if (that.legalTransfer == 1) {
        if (obj.account_code == "legal_account") {
          that.fromtype = that.accoutlist.filter(
            options => options.account_code != "legal_account"
          )[0].name;
          that.from = that.accoutlist.filter(
            options => options.account_code != "legal_account"
          )[0].account_code;
        }
        var data1 = that.transferData.filter(
          options => options.account_code == that.from
        );
        that.balance = data1[0].accounts.filter(
          options => options.currency_id == that.currency_id
        )[0].balance;
      } else if (that.microTransfer == 1) {
        if (obj.account_code == "micro_account") {
          that.fromtype = that.accoutlist.filter(
            options => options.account_code != "micro_account"
          )[0].name;
          that.from = that.accoutlist.filter(
            options => options.account_code != "micro_account"
          )[0].account_code;
        }
        var data1 = that.transferData.filter(
          options => options.account_code == that.from
        );
        that.balance = data1[0].accounts.filter(
          options => options.currency_id == that.currency_id
        )[0].balance;
      } else if (that.leverTransfer == 1) {
        if (obj.account_code == "lever_account") {
          that.fromtype = that.accoutlist.filter(
            options => options.account_code != "lever_account"
          )[0].name;
          that.from = that.accoutlist.filter(
            options => options.account_code != "lever_account"
          )[0].account_code;
        } 
        var data1 = that.transferData.filter(
          options => options.account_code == that.from
        );
        that.balance = data1[0].accounts.filter(
          options => options.currency_id == that.currency_id
        )[0].balance;
      }
    },
    // 切换币种
    changeCoin(e) {
      var that = this;
      var data1 = that.coinlist.filter(item => item.currency_code == e)[0];
      that.accoutlist = data1.currency.account_types;
      that.fromtype = that.accoutlist[0].name;
      that.totype = that.accoutlist[1].name;
      that.currency_id = data1.currency_id;
      that.curcoin = data1.currency_code;
      that.from = that.accoutlist[0].account_code;
      that.tos = that.accoutlist[1].account_code;
      var data1 = that.transferData.filter(
        options => options.account_code == that.accoutlist[0].account_code
      );
      that.balance = data1[0].accounts.filter(
        options => options.currency_id == that.currency_id
      )[0].balance;
    },
    // 确认划转
    transferConfirm() {
      var that = this;
      if (!that.number) {
        that.$utils.layerMsg(this.$t('assets.p_transfernum'));
        return false;
      }
      that.$http
        .initDataToken({
          url: "account/transfer",
          type: "POST",
          data: {
            currency_id: that.currency_id,
            balance: that.number,
            from: that.from,
            to: that.tos
          }
        })
        .then(res => {
          setTimeout(() => {
            that.init();
            that.number = "";
          }, 1000);
        });
    }
  }
};
</script>
<style lang="">
.cointransfer .el-input__inner {
  border-color: #80808085;
}

.bdinput .el-input input{
  padding: 0 40px;
}
.myselect .el-input__inner{
  padding-left:24px !important;
}
</style>