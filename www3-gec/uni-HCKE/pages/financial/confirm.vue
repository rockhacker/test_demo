<template>
  <view class="p-30">
      <view class="p-30 rounded-xl flex justify-between" style="background: #272727;">
          <view class="text-lg" style="color:#CACACA">{{$t('financial.sdje')}}(USDT):</view>
          <view class="text-lg ml-20">800</view>
      </view>

      <view class="p-30 rounded-xl mt-30" style="background: #272727;">
            <view class="flex justify-between">
                <view class="text-lg" style="color:#CACACA">{{$t('financial.yqsy')}}</view>
                <view class="text-lg ml-20">12.0~12.0</view>
            </view>
            <view class="flex mt-10 justify-between">
                <view class="text-lg" style="color:#CACACA">{{$t('financial.tgsj')}}</view>
                <view class="text-lg ml-20">5天 </view>
            </view>
            <view class="flex mt-10 justify-between">
                <view class="text-lg" style="color:#CACACA">{{$t('financial.rsy')}}</view>
                <view class="text-lg ml-20">0.3~0.3%</view>
            </view>
      </view>

        <view class="p-30 rounded-xl mt-30" style="background: #272727;">
            <view class="flex justify-between pb-20" style="border:0 solid rgba(255, 255, 255, 0.2);border-bottom-width: 1rpx;">
                <view class="text-lg" style="color:#CACACA">{{$t('financial.qxsj')}}</view>
                <view class="text-lg ml-20">2022-04-10</view>
            </view>
            <view class="flex justify-between mt-20">
                <view class="text-lg" style="color:#CACACA">{{$t('financial.dqsj')}}</view>
                <view class="text-lg ml-20">2022-04-15</view>
            </view>
        </view>
         
        <view class="p-30 rounded-xl mt-30" style="background: #272727;">
            <view class="flex justify-between pb-20" style="border:0 solid rgba(255, 255, 255, 0.2);border-bottom-width: 1rpx;">
                <view class="text-lg" style="color:#CACACA">{{$t('financial.ddbh')}}</view>
                <view class="text-lg ml-20">22042542021520125896</view>
            </view>
            <view class="flex justify-between mt-20">
                <view class="text-lg" style="color:#CACACA">{{$t('financial.ddsj')}}</view>
                <view class="text-lg ml-20">2022-04-10 14:45:20</view>
            </view>
        </view>

        <view class="h-88 w-580 rounded-3xl text-center leading-88 text-2xl mx-auto mt-60" style="background: linear-gradient(90deg, #FFB216, #FF9D12);">
            {{$t('financial.qrgm')}}
        </view>

        <view class="text-center mt-30" style="color:#CACACA">
            {{$t('trade.cancel')}}
        </view>

  </view>
</template>

<script>
import {mapState} from 'vuex'
export default {
    onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('financial.qrgm')
			})
	},
    onShow() {
		   this.$utils.setThemeTop(this.theme)
		  // this.getList()
		},
    computed:{
        ...mapState(['theme']),
    },
}
</script>

<style>

</style>