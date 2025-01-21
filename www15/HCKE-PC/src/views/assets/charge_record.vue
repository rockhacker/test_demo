<template>
  <div>
    <div class="between baselight2 ptb20 plr20 ft16 bgwhite flex alcenter">
      <p class="basecolor">{{ $t('assets.czjl') }}</p>
    </div>
    <div class="bgwhite plr15">
        <ul class="basecolor">
        <li class="flex alcenter ptb10">
          <span class="flex1">{{$t('trade.currency')}}</span>
          <span class="flex1 tl">{{$t('assets.czsl')}}</span>
          <span class="flex1 tl">{{$t('assets.czsj')}}</span>
          <span class="flex1 tl">{{$t('assets.czfs')}}</span>
        </li>
        <li class="flex alcenter ptb10" v-for="item in list" :key="item.id">
          <span class="flex1">{{item.currency_code}}</span>
          <span class="flex1 tl">{{item.number}}</span>
          <span class="flex1 tl">{{item.created_at}}</span>
          <span class="flex1 tl">{{item.type==0? $t('rechargeTransfer.linkTranster'):$t('rechargeTransfer.cardTranster')}}</span>
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
          <p class="basecolor">{{$t('assets.noData')}}</p>
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
      total: 0,
      list: []
    }
  },
  created() {
    this.getData()
  },
  methods: {
    getData() {
      var that = this
      that.$http
        .initDataToken(
          {
            url: 'quickCharge/quick_ist',
            data: {
              page: that.page
            }
          },
          false
        )
        .then((res) => {
          console.log(res)
            that.total = res.total
            that.list = res.data
        })
    },
    handleCurrentChange(val) {
      var that = this;
      that.list = [];
      that.page = val;
      that.getData();
    },
  }
}
</script>

<style></style>
