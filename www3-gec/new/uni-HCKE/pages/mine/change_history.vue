<template>
  <view class="p-10">
    <view class="flex p-20">
      <view class="flex1">{{ $t('assets.currency') }}</view>
      <view class="flex1 tc">{{ $t('trade.num') }}</view>
      <view class="flex1 tc">{{ $t('assets.record') }}</view>
      <view class="flex1 tr">{{ $t('trade.time') }}</view>
    </view>
    <view class="flex bg-my-gray p-20 mb-30 rounded-xl" v-for="item in list" :key="item.id">
      <span class="flex1">{{ item.currency.code }}</span>
      <span class="flex1 tc">{{ item.value }}</span>
      <span class="flex1 tc">{{ item.memo }}</span>
      <span class="flex1 tr">{{ item.created_at }}</span>
    </view>
  </view>
</template>

<script>
import { mapState } from 'vuex'
export default {
  data() {
    return {
      page: 1,
      viewmit: 10,
      list: [],
      last: false
    }
  },
  onLoad() {
    uni.setNavigationBarTitle({
      title: this.$t('assets.zbjl')
    })
    this.$utils.setThemeTop(this.theme)
    this.getData()
  },
  computed: {
    ...mapState(['theme'])
  },
  onPullDownRefresh() {
    this.page = 1
    this.getData()
    setTimeout(() => {
      uni.stopPullDownRefresh()
    }, 1000)
  },
  onReachBottom() {
    if (this.last) return this.$utils.showLayer(this.$t('team.noRecords'))
    this.page++
    this.getData()
  },
  methods: {
    getData() {
      var that = this
      this.$utils.initDataToken(
        {
          url: 'account_log/change',
          data: { page: that.page, viewmit: that.viewmit }
        },
        (res) => {
          console.log(res)
          if (that.page == 1) {
            that.list = res.data
          } else {
            this.list.push(...res.data)
          }
          that.last = res.total == that.list.length //已加载完 禁止触底
        }
      )
    }
  }
}
</script>

<style></style>
