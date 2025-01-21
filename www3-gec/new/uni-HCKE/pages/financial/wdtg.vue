<template>
  <view class="financial-wdtg">
    <view class="flex mt-40 px-60">
      <view
        class="text-xl mr-100"
        :class="{ type: active == 1 }"
        @click="change(1)"
      >
        {{ $t('financial.tgz') }}
      </view>
      <view class="text-xl" :class="{ type: active == 2 }" @click="change(2)">
        {{ $t('financial.ysh') }}
      </view>
    </view>

    <view v-for="(item, index) in list" :key="index"
					class="p-40 m-40 rounded-10 text-xl"  style="background: #272727">

					<view class="text-center text-xl font-bold border-0 border-b-2 border-solid border-gray-200 pb-20">
						{{item.get_matter.title}}
					</view>

					<view class="flex justify-between p-20 mb-20">
						<view class="text-xl">{{ item.get_matter.currency_code }}</view>
						<view>{{ item.get_matter.status_str }}</view>
					</view>

					<view class="my-20 flex items-center text-center">
						<view class="flex-1">
							<view class="my-10">{{item.share_amount}}</view>
							<view class="text-gray-500">{{$t('staking.shengoushuliang')}}</view>
						</view>
						<view class="flex-1">
							<view class="my-10">{{item.sub_time}}</view>
							<view class="text-gray-500">{{$t('staking.shengoushijian')}}</view>
						</view>
					</view>

					<view class="mt-20 rounded-3xl p-20 text-sm text-center"
						:class="item.status==1?'bg-primary text-white':'bg-gray-500 text-white'"
						@tap="item.status==1?applyRefund(item):''">
						{{ $t("staking.weiyueshuhui") }}
					</view>

					<navigator :url="`/pages/financial/income?id=${item.id}`"
						class="mt-20 rounded-3xl p-20 text-sm text-center bg-primary text-white"
					>
						{{ $t("staking.chakanshouyi") }}
					</navigator>
				</view>

    <view class="mt-80 text-center" v-if="list.length==0">
      <image src="../../static/image/anonymous.png" class="w-120 h-120"></image>
      <view>{{ $t('home.norecord') }}</view>
    </view>
  </view>
</template>

<script>
import { mapState } from 'vuex'
export default {
  data() {
    return {
      active: 1,
      page: 1,
      limit: 10,
      hasMore: true,
      list: []
    }
  },
  onLoad() {
    uni.setNavigationBarTitle({
      title: this.$t('financial.wdtuoguan')
    })
    this.getData()
  },
  onShow() {
    this.$utils.setThemeTop(this.theme)
    // this.getList()
  },
  computed: {
    ...mapState(['theme'])
  },
  onPullDownRefresh() {
    this.page = 1
    this.getData()
    setTimeout(function () {
      uni.stopPullDownRefresh()
    }, 1000)
  },
  onReachBottom() {
    if (!this.hasMore) {
      return
    }
    this.page++
    this.getData()
  },
  methods: {
    change(index) {
      this.active = index
      this.page = 1
      this.getData()
    },
    getData() {
      this.$utils.initDataToken(
        {
          url: 'matter/subList',
          data: {
            page: this.page,
            limit: this.limit,
            type: this.active
          }
        },
        (res) => {
          console.log(res, 44)
          if (this.page == 1) {
            this.list = res.data
          } else {
            this.list.push(...res.data)
          }
          this.hasMore = this.list.length < res.total
        }
      )
    },
    // 申请赎回
			applyRefund(item) {
				try {
					const that = this;
					// let penalSum = item.share_amount * ((item.get_fund.liquidated_damages / 100) * item.surplus_period)
					let penalSum = item.share_amount * (item.get_matter.liquidated_damages / 100)
					uni.showModal({
						title: that.$t('staking.hint'),
						content: `${that.$t('staking.pay')} ${penalSum}${item.get_matter.currency_code} ${that.$t('staking.payPenalSumRedemption')}`,
						showCancel: true,
						cancelText: that.$t('staking.fanhui'),
						confirmText: that.$t('staking.shuhui'),
						confirmColor: '#999999',
						success: res => {
							if (res.confirm) {
								that.$utils.initDataToken({
									url: "matter/applyRematter",
									data: {
										sub_id: item.id
									}
								}, (res, msg) => {
									that.$utils.showLayer(msg);
									setTimeout(() => {
										// that.getProductList();
                                        that.page = 1;
                                        that.getData()
									}, 1000)
								});
							}

						},
						fail: () => {},
						complete: () => {}
					});

				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}
			},
  }
}
</script>

<style lang="scss">
.financial-wdtg {
  .type {
    border: 0rpx solid #37b6ff;
    border-bottom-width: 4rpx;
  }
}
</style>
