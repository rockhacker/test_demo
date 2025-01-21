<template>
	<view class="">
		<!-- <view class="status_bar">
			<view class="top_view"></view>
		</view> -->
		<web-view :src="url"></web-view>
	</view>
</template>
<script>
import {mapState} from 'vuex'
	export default{
		data(){
			return {
				url:''
			}
		},
		onLoad(e) {
			this.$utils.setThemeTop(this.theme);
			let type = e.type || '';
			this.url=`/hybrid/html/index.html?legal_id=${e.legal_id}&currency_id=${e.currency_id}&symbol=${e.symbol}&currency_match_id=${e.currency_match_id}&type=${type}`
		},
		computed:{
		   ...mapState(['theme']),
		},
	}
</script>

<style>
</style>
