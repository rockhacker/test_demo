<template>
  <div>
    <div class="between baselight2 ptb20 plr20 ft16 flex alcenter dark-bg-1C2532 border-b-999FAA">
      <p>{{$t('header.mentionRecord')}}</p>
      <div>
        <el-select v-model="coinCode" :placeholder="$t('assets.selectCurrency')" class="flex1" @change="changeCoin">
          <el-option :label="$t('assets.all')" :value="1"></el-option>
          <el-option
            v-for="item in coinlist"
            :key="item.currency_id"
            :label="item.currency_code"
            :value="item"
          ></el-option>
        </el-select>
      </div>
    </div>
    <div class=" plr15">
      <!-- <div class="flex alcenter ptb10">
        <span class="flex1">币种</span>
        <span class="flex1 tc">数量</span>
        <span class="flex1 tc">记录</span>
        <span class="flex1 tr">时间</span>
      </div>-->
      <!-- 记录列表 -->
      <ul>
        <li class="flex alcenter ptb10">
          <span class="flex1">{{$t('assets.numbers')}}</span>
          <span class="flex1 tl">{{$t('assets.fee')}}</span>
          <span class="flex1 tl">{{$t('assets.recivenum')}}</span>
          <span class="tl" style="width:300px">{{$t('assets.mentionaddr')}}</span>
          <span class="flex1 tl">{{$t('assets.state')}}</span>
          <span class="flex1 tl">{{$t('assets.remarks')}}</span>
          <span class="flex1 tl">{{$t('assets.times')}}</span>
        </li>
        <li class="flex alcenter ptb10" v-for="item in logList" :key="item.id">
          <span class="flex1">{{item.number}}</span>
          <span class="flex1 tl">{{item.fee}}</span>
          <span class="flex1 tl">{{item.real_number}}</span>
          <span class="tl" style="width:300px">{{item.address}}</span>
          <span class="flex1 tl">{{item.status_name}}</span>
          <span class="flex1 tl">{{item.notes}}</span>
          <span class="flex1 tl">{{item.created_at}}</span>
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
      recordAccount: "change_account",
      page: 1,
      coinlist: [],
      coinCode: "",
      logList: [],
      total: 0,
      currency_id: "",
      name:''
    };
  },
  created() {
    var that = this;
    that.init();
    that.getCoinList();
  },
  methods: {
    init() {
      var that = this;
      that.$http
        .initDataToken(
          {
            url: 'account/draw_list',
            data: {
              currency_id: that.currency_id,
              page: that.page
            }
          },
          false
        )
        .then(res => {
          // console.log(res);
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
        res.forEach(item => {
          if (item.account_code == that.recordAccount) {
            that.coinlist = item.accounts;
            that.changeData = item;
          }
        });
      });
    },
    changeCoin(e) {
      var that = this;
      if (e == 1) {
        that.currency_id = "";
      } else {
        that.currency_id = e.currency_id;
        that.coinCode = e.currency_code;
      }
      that.page = 1;
      that.total = 0;
      that.logList = [];
      that.init();
    }
  }
};
</script>
<style>
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