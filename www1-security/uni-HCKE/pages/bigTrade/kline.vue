<template>
	<view class="">
		<!-- <view class="status_bar">
			<view class="top_view"></view>
		</view> -->
		<web-view :src="url"></web-view>
	</view>
</template>
<script>
	import { mapState } from 'vuex';
	export default{
		data(){
			return {
				url:''
			}
		},
		computed: {
			...mapState(['theme'])
		},
		onLoad(e) {
			this.$utils.setThemeTop(this.theme)
			uni.setNavigationBarTitle({
				title: e.symbol
			});
			let type = e.type || '';
			this.url=`/hybrid/html/bigTrade.html?legal_id=${e.legal_id}&currency_id=${e.currency_id}&symbol=${e.symbol}&currency_match_id=${e.currency_match_id}&type=${type}`
		}
	}
</script>

<style>
</style>
