<template>
  <view>
    <view
    class="m-20"
      style="
        height: 360rpx;
        padding-top: 88rpx;
        background: url('./static/image/lc_item_bg.png');
        background-size: 100% 100%;
        background-repeat: no-repeat;
      "
    >
      <view class="text-2xl text-center">
        {{ $t('financial.financial') }}
        <!-- <navigator
          class="text-my-orange float-right text-lg pr-10 absolute right-40 top-90"
          url="/pages/financial/rule"
        >
          <text>{{ $t('financial.rule') }}</text>
        </navigator> -->
      </view>
      <view class="text-center font-medium mt-60" style="font-size: 60rpx">
        {{ base.total_amount }}
      </view>
      <view class="text-center text-base mt-30"
        >{{ $t('financial.zztgdd') }}(USDT)</view
      >
    </view>

    <view
      class="mt-30 mx-30 rounded-xl h-174 flex items-center justify-between overflow-hidden"
      style="background: #272727"
    >
      <view class="flex justify-around flex-2">
        <view>
          <view class="text-center">{{ base.day_profit }}</view>
          <view class="text-center">{{ $t('financial.rsy') }}</view>
        </view>
        <view>
          <view class="text-center">{{ base.total_profit }}</view>
          <view class="text-center">{{ $t('financial.ljsy') }}</view>
        </view>
      </view>
      <view
        class="h-36 w-1"
        style="background: rgba(255, 255, 255, 0.2)"
      ></view>
      <view class="flex-1">
        <view class="text-center">{{ base.total_in }}</view>
        <view class="text-center">{{ $t('financial.tgzdd') }}</view>
      </view>
        <navigator
        url="/pages/financial/wdtg"
        class="text-my-orange text-xs rounded-xl pl-16 pr-20 border-primary border-2 border-solid"
        style="margin-right: -16rpx;"
        >{{ $t('financial.ck') }}</navigator
      >
    </view>

    <view class="px-30 mt-30 pb-100">
      <navigator
        class="h-200 px-30 py-26 rounded-xl mb-30"
        style="background: #272727"
        :url="`/pages/financial/buy?id=${item.id}`"
        v-for="(item,index) in list"
        :key="index"
      >
        <view
          class="flex items-center justify-between pb-20"
          style="
            border: 0 solid rgba(255, 255, 255, 0.2);
            border-bottom-width: 1rpx;
          "
        >
          <view class="flex items-center">
            <image
              class="h-60 w-60 mr-20"
              src="/static/image/lc_item.png"
            ></image>
            <text>{{item.title}}</text>
          </view>
          <view class="flex items-center">
            <view
              class="rounded-xl px-16 py-6 text-my-orange"
              style="background: rgba(255, 178, 22, 0.1)"
              >{{$t('financial.rsyl')}} {{item.dividend_percentage}}%</view
            >
            <image
              src="/static/image/aw_right1.png"
              class="w-30 h-30 ml-12"
            ></image>
          </view>
        </view>
        <view class="mt-30" style="color: #979797">
          <view
            >{{ $t('financial.dbxe') }}:
            <text class="pl-10 white">{{item.staring_sub_amount}}-{{item.max_sub_amount}}</text>
          </view>
          <!-- <view class="mt-10"
            >{{ $t('financial.gq') }}:
            <text class="pl-10 white">{{item.expire}}</text>
          </view> -->
        </view>
      </navigator>
    </view>
  </view>
</template>

<script>
export default {
  data() {
    return {
      base: {},
      page: 1,
      limit: 10,
      hasMore: true,
      list:[]
    }
  },
  onShow() {
    this.getData()
  },
  onLoad() {
    this.getProductList()
  },
  onPullDownRefresh() {
    this.getData()
    this.page = 1
    this.getProductList()
    setTimeout(function () {
      uni.stopPullDownRefresh()
    }, 1000)
  },
  onReachBottom() {
    if (!this.hasMore) {
      return
    }
    this.page++
    this.getProductList()
  },
  methods: {
    getData() {
      this.$utils.initDataToken({ url: 'matter/list' }, (res) => {
        console.log(res)
        this.base = res.info
      })
    },
    // 产品列表
    getProductList() {
      try {
        const that = this
        that.$utils.initDataToken(
          {
            url: 'matter/list',
            data: {
              limit: this.limit,
              page: this.page
            }
          },
          (res) => {
            console.log(res,222);
            if (this.page == 1) {
              this.list = res.outs.data
            } else {
              this.list.push(...res.outs.data)
            }
            this.hasMore = this.list.length < res.outs.total
            console.log(this.list,222);
          }
        )
      } catch (e) {
        console.log(e)
        //TODO handle the exception
      }
    }
  }
}
</script>

<style></style>
