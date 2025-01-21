<template>
	<view :class="theme">
		<view class="w-full fixed flex bottom-0 left-0 h-100 white" style="background:#19332F;">
			<navigator class="flex-1 justify-center items-center flex flex-col h-100" v-for="item,index in tabBar" :key="index" hover-class="opactive-50" :url="item.pagePath" open-type="switchTab">
				<image :src="item.iconPath" class="w-48 h-48"></image>
				{{$t(item.text)}}
			</navigator>
		</view>
	</view>
</template>

<script>
import {mapState} from 'vuex'
export default {
  props: {},
  computed:{
  	...mapState(['theme']),
  },
  data() {
    return {
		tabBar: [
			{
				"pagePath" : "/pages/home/home",
				"iconPath" : "/static/footer/index0.png",
				"selectedIconPath" : "/static/footer/index1.png",
				"text": "market.home"
			},
			// {
			// 	"pagePath" : "/pages/market/market",
			// 	"iconPath" : "/static/footer/hang0.png",
			// 	"selectedIconPath" : "/static/footer/hang1.png",
			// 	"text": "market.market"
			// },
			{
				"pagePath" : "/pages/trade/trade",
				"iconPath" : "/static/footer/trade0.png",
				"selectedIconPath" : "/static/footer/trade1.png",
				"text": "trade.bibi"
			},
			{
				"pagePath" : "/pages/contract/lever",
				"iconPath" : "/static/footer/gang0.png",
				"selectedIconPath" : "/static/footer/gang1.png",
				"text": "new.tran"
			},
			{
				"pagePath" : "/pages/assets/assets",
				"iconPath" : "/static/footer/mine0.png",
				"selectedIconPath" : "/static/footer/mine1.png",
				"text": "assets.assets"
			},
			{
				"pagePath" : "/pages/mine/mine",
				"iconPath" : "/static/footer/me0.png",
				"selectedIconPath" : "/static/footer/me1.png",
				"text": "new.mi"
			}
		]
	}
  },
}
</script>
