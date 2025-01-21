<template>
	<view :class="theme">
		<view class="w-full bg-white dark:bg-1C2532 fixed flex bottom-0 left-0 border-0 border-t-2 border-solid border-gray-200 h-100 text-gray-400"  style="background:#171e26">
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
				"iconPath" : "/static/footer/index2.png",
				"selectedIconPath" : "/static/footer/index2.png",
				"text": "market.home"
			},
			{
				"pagePath" : "/pages/market/market",
				"iconPath" : "/static/footer/hang2.png",
				"selectedIconPath" : "/static/footer/hang2.png",
				"text": "market.market"
			},
			{
				"pagePath" : "/pages/trade/trade",
				"iconPath" : "/static/footer/trade2.png",
				"selectedIconPath" : "/static/footer/trade1.png",
				"text": "trade.bibi"
			},
			{
				"pagePath" : "/pages/contract/lever",
				"iconPath" : "/static/footer/gang2.png",
				"selectedIconPath" : "/static/footer/gang2.png",
				"text": "new.tran"
			},
			{
				"pagePath" : "/pages/assets/assets",
				"iconPath" : "/static/footer/mine2.png",
				"selectedIconPath" : "/static/footer/mine2.png",
				"text": "bigTrade.bigTrade"
			},
			{
				"pagePath" : "/pages/mine/mine",
				"iconPath" : "/static/footer/me2.png",
				"selectedIconPath" : "/static/footer/me2.png",
				"text": "new.mi"
			}
		]
	}
  },
}
</script>
