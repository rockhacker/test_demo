<template>
  <div>
    <div class="between baselight2 ptb20 plr20 ft16 bgheader flex alcenter">
      <p class="ft14"><span class="blue ft16">{{currency_code}}</span> {{$t('assets.transferRecord')}}</p>
      <div>
        <el-select v-model="type" :placeholder="$t('assets.pleaseselectaccounttype')" class="flex1 bde9 bdinput radius4" @change="changeType">
          <!-- <el-option :label="'全部'" :value="1"></el-option> -->
          <el-option
            v-for="item in accountList"
            :key="item.id"
            :label="item.name"
            :value="item.account_code"
          ></el-option>
        </el-select>
      </div>
    </div>
    <div class="bgpart plr15">
      <!-- <div class="flex alcenter ptb10">
        <span class="flex1">币种</span>
        <span class="flex1 tc">数量</span>
        <span class="flex1 tc">记录</span>
        <span class="flex1 tr">时间</span>
      </div>-->
      <!-- 记录列表 -->
      <ul>
        <li class="flex alcenter ptb10">
          <span class="w20">{{$t('assets.currency')}}</span>
          <span class="flex1 tc">{{$t('assets.numbers')}}</span>
          <span class="flex1 tc">{{$t('assets.record')}}</span>
          <span class="flex1 tr">{{$t('assets.times')}}</span>
        </li>
        <li class="flex alcenter ptb10" v-for="item in logList" :key="item.id">
          <span class="w20">{{currency_code}}</span>
          <span class="flex1 tc">{{item.balance}}</span>
          <span class="flex1 tc">{{$t('assets.from')}}{{item.from_name}}{{$t('assets.reach')}}{{item.to_name}}</span>
          <span class="flex1 tr">{{item.created_at}}</span>
        </li>
      </ul>
      <!-- 分页 -->
      <div v-if="total >15" class="w100 tc pages mb40 mt20">
        <el-pagination
          :total="total"
          layout="prev, pager, next"
          @current-change="handleCurrentChange"
        ></el-pagination>
      </div>
      <div>
        <div class="tc ptb40" v-if="total==0">
          <img src="../../assets/images/nodata.png" alt class="wt70" />
          <p>{{$t('assets.noData')}}</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      page: 1,
      accountList:'',
      currency_id: "",
      currency_code:"",
      type:'',
      total:0,
      logList:[]
    };
  },
  created() {
    var that = this;
    that.currency_id = this.$route.query.currency_id;
    that.currency_code = this.$route.query.currency_code;
    that.getCoinList();
  },
  methods: {
    init() {
      var that = this;
      that.$http
        .initDataToken({url: 'account/transfer_log',
            data: {
              currency_id: that.currency_id,
              type:that.type,
              page: that.page
            }
          },false)
      .then(res => {
        that.total = res.total;
        that.logList = res.data;
      });
    },
    handleCurrentChange(val) {
      var that = this;
      that.logList = [];
      that.page = val;
      that.init();
    },
    getCoinList() {
      var that = this;
      that.$http.initDataToken({ url: "account/list" }, false).then(res => {
        that.accountList = res;
        that.type = res[0].account_code;
        that.init();
      });
    },
    changeType(e) {
      var that = this;
      that.page = 1;
      that.total = 0;
      that.logList = [];
      that.init();
    }
  }
};
</script>
<style lang='scss'>
.pages .el-dialog,
.el-pager li {
  background: transparent;
}

.pages .el-pagination button {
  background: transparent !important;
  color: #b0b8db !important;
}

.pages .el-pagination button:disabled {
  color: #5a5a5a !important;
}

.pages .el-pagination {
  color: #b0b8db;
}
</style>