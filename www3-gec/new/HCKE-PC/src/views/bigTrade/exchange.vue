<template>
  <div>
    <el-dialog
      :title="$t('new.duih')"
      :visible.sync="dialogVisible"
      width="500px"
      custom-class="minwc500"
      :before-close="handleClose"
    >
      <div>
        <div class="flex alcenter between" :class="[type == 1 ? '' : 'row-reverse']">
          <input
           v-if="type == 1"
            v-model="recharge_name"
            :disabled="true"
            type="text"
            class="ht40 lh40 plr20 bdinput black"
            style="width:180px !important"
          />
          <input
          v-else
            v-model="settle_name"
            :disabled="true"
            type="text"
            class="ht40 lh40 plr20 bdinput black"
            style="width:180px !important"
          />
          <div class="flex column alcenter">
            <img
              width="50px"
              src="../../assets/images/qweqwekkk.png"
              alt
              class="imgct mlr20 pointer"
              @click="changeType"
            />
            <div class="mt10">1:{{type==1?info.recharge_bili:(1/info.recharge_bili).toFixed(2)}}</div>
          </div>
          <input
          v-if="type == 1"
            v-model="settle_name"
            :disabled="true"
            type="text"
            class="ht40 lh40 plr20 bdinput black"
            style="width:180px !important"
          />
          <input
         v-else
            v-model="recharge_name"
            :disabled="true"
            type="text"
            class="ht40 lh40 plr20 bdinput black"
            style="width:180px !important"
          />
         
        </div>

        <div class="flex alcenter between" v-if="info.recharge_account">
          <div>
            {{$t('new.balance')}}:{{type==1?info.recharge_account_balance: info.settle_account_balance}}
          </div>
          <div>
            {{$t('new.ked')}}:{{calc}}{{type==2?info.recharge_account.Code:info.settle_account.CurrencyName}}
          </div>
        </div>

        <div class="flex alcenter w100 mb40 duih mt40">
        <span class="wt120" v-if="info.recharge_account">{{ $t("new.dhs") }}({{type==1?info.recharge_account.Code:info.settle_account.CurrencyName}}):</span>
        <input
          type="text"
          v-model="number"
          class="ht40 lh40 plr20 bdinput flex1 black"
        />
      </div>
      </div>

      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">{{$t('trade.cancel')}}</el-button>
        <el-button type="primary" @click="submit()"
          >{{$t('login.e_confrim2')}}</el-button
        >
      </span>
    </el-dialog>
  </div>
</template>

<script>
export default {
  data() {
    return {
      dialogVisible: false,
      recharge_name: "",
      settle_name: "",
      type: 1,
      info: {},
      number:""
    };
  },
  computed:{
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
  methods: {
    changeType() {
      this.type = this.type == 1 ? 2 : 1;
    },
    show() {
      this.number =''
      this.dialogVisible = true;
      this.getInfo();
    },
    getInfo() {
      var that = this;
      that.$http
        .initDataToken({ url: "forex/recharge_to_forex" }, false, true, false, {
          baseURL: `${this.API}/v1/api/`,
        })
        .then((res) => {
          that.recharge_name = res.recharge_name;
          that.settle_name = res.settle_name;
          that.info = res;
          console.log(res, "recharge_to_forex");
        });
    },
    submit() {
      var that = this;
      that.$http
        .initDataToken({ url: `forex/recharge_submit?type=${that.type}&number=${that.number}&settle_id=${that.info.settle_account.Id}&currency_id=${that.info.recharge_account.Id}` }, true, true, false, {
          baseURL: `${this.API}/v1/api/`,
        })
        .then((res) => {
         that.number = ''
         that.getInfo();
        });
    },
    handleClose(done) {
      done()
      // this.$confirm("确认关闭？")
      //   .then((_) => {
      //     done();
      //   })
      //   .catch((_) => {});
    },
  },
};
</script>

<style>
.minwc500{
  min-width: 500px !important;
}
</style>
