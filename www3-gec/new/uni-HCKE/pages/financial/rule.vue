<template>
  <view class="px-30">
      <view class="text-center mt-20">
        <image class="h-130 w-400" src="/static/logo.png"></image>
      </view>
      <view class="mt-60 text-lg">
        {{$t('financial.bz')}}
      </view>
      <view class="mt-60 text-lg">
        {{$t('financial.syjs')}}
      </view>
      <view class="mt-30">
        <view class="text-lg">{{$t('financial.sygz')}}</view>
        <view>
          <view class="text-lg">
            10000U x 0.5% = 50U
          </view>
          <!-- <view class="text-lg">
            {{$t('financial.zd')}}: 10000U×0.3%=30U
          </view>
          <view class="text-lg">
            {{$t('financial.zg')}}: 10000U×0.5%=50U
          </view> -->
          <view class="text-lg">
            {{$t('financial.sysm')}}
          </view>
        </view>
      </view>
      <view class="mt-60">
        <view class="text-lg">{{$t('financial.gywyj')}}</view>
        <view class="mt-30 text-lg">
          {{$t('financial.wyjjs')}}
        </view>
        <view class="text-lg mt-30">{{$t('financial.wyjjl')}}</view>
      </view>
      <view class="mt-40 text-center leading-88 text-2xl bg-primary" style="height: 88rpx;border-radius: 44rpx;">{{$t('financial.ljgm')}}</view>
  </view>
</template>

<script>
import {mapState} from 'vuex'
export default {
    onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('financial.rule')
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