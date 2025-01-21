<template>
	<view class="">
		<view class="status_bar">
			<view class="top_view" style="height:88rpx;background-color: #171e26;line-height: 88rpx;">
				<uni-icons class="py-20 px-30 text-white" type="arrowleft" size="24"  @click="tapBack"  ></uni-icons>
			</view>
		</view>
		<web-view :src="url" style="top:88rpx"></web-view>
	</view>
</template>
<script>
	export default{
		data(){
			return {
				url:''
			}
		},
		onLoad(e) {
			let type = e.type || '';
			this.url=`/hybrid/html/index.html?legal_id=${e.legal_id}&currency_id=${e.currency_id}&symbol=${e.symbol}&currency_match_id=${e.currency_match_id}&type=${type}`
		},
		methods:{
			tapBack(){
				uni.navigateBack();
			}
		}
	}
</script>

<style>
</style>
