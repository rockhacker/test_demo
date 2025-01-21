<template>
	<view :class="theme">
		<!-- style="background-color: #141419" -->
		<view class="text-black dark:text-white w-full h-full min-h-full bg-white dark:bg-new-black2"> 
			<uni-nav-bar fixed backIcon>
				<view class="flex-1 p-30 bg-white dark:bg-new-black flex justify-center items-center text-2xl">
					{{$t('staking.mining')}}
				</view>
				<slot name="right">
					<view class="w-100"></view>
					<navigator url="/pages/staking/orders" 
						class="px-10 py-10 border-2 rounded-10 absolute top-24 right-20 z-10" >
						<image src="/static/image/record1.png" mode="aspectFit" class="w-30 h-30" ></image>
					</navigator>
				</slot>
			</uni-nav-bar>

			<!-- <scroll-view scroll-y class="w-full" style="height calc(100vh - 50px);"> -->
				<view class="p-30">
					<view class="mb-30" v-if="list.length">
						<view class="flex items-center pb-10 border-0 border-solid border-b-2 border-gray-400">
							<view class="flex-1">{{ $t('new.mingzi') }}</view>
							<view class="flex-1">{{ $t('legal.coin') }}</view>
							<view class="flex-1">{{ $t('new.zhangfu') }}</view>
							<!-- <view class="flex-1 text-right">{{ $t('new.shizhi') }}</view> -->
							<view>{{ $t('new.dizi') }}</view>
						</view>
						<view v-for="item in list" :key="item.id" class="flex items-center py-10 border-0 border-solid border-b-2 border-gray-400">
							<view class="flex-1">{{ item.name }}</view>
							<view class="flex-1">{{ item.symbol }}</view>
							<view class="flex-1" :class="[item.quote.USD.percent_change_24h<0?'text-danger':'text-success']" style="color: #00AB86">{{ item.quote.USD.percent_change_24h }}%</view>
							<!-- <view class="flex-1 text-right ml-20">{{ item.quote.USD.market_cap }}</view> -->
							<view class="w-120 ml-10 overflow-hidden" style="text-overflow:ellipsis">{{ item.platform && item.platform.token_address }}</view>
						</view>
					</view>

					<view class="justify-between rounded-3xl bg-gray-100 dark:bg-new-black text-whte px-40 py-30 mb-30"
						v-for="item,indexs in accounts" :key="indexs">
						<view class="flex">
							<image :src="`${item.icon}`" class="w-120 h-120 mr-40"></image>
							<view>
								<view class="text-xl font-bold">{{item.title}}</view>
								<view class="text-xl text-black dark:text-gray-400">{{item.code}}</view>
								<view class="text-lg">{{$t('staking.meiqipaixi')}} <text class="pl-10 text-primary"> {{item.dividend_percentage}}%</text> </view>
							</view>
						</view>
						<view class="mt-60">
							<view class="text-2xl"><text class="dark:text-gray-400 pr-10">{{$t('staking.suocangtianshu')}}:</text> {{item.lock_dividend_days}}/day</view>
							<view class="mt-10"> <text class="text-base dark:text-gray-400 pr-10">{{$t('staking.qigoujine')}}:</text>  {{item.staring_sub_amount}}</view>
						    <view class="mt-10"> <text class="text-base dark:text-gray-400 pr-10">{{$t('staking.zuigaoshengou')}}:</text> {{item.max_sub_amount}}</view>
						</view>

						<view class="savingProgressBar relative my-40">
						<view class="savingRunBar absolute"  :style="`width:${item.speed}%`"></view>
						</view>


						<view class="flex justify-end w-full">
							<navigator :url="`/pages/staking/details?id=${item.id}`"
							class="w-200 mt-20 rounded-3xl p-10 font-bold text-black text-xl text-center bg-primary">
							{{ $t("staking.shengou") }}
						</navigator>
						</view>
					</view>
				</view>
			<!-- </scroll-view> -->
		</view>
	</view>
</template>
<script>
	import {
		mapState
	} from 'vuex'
	export default {
		data() {
			return {
				accounts: [],
				list:[]
			};
		},
		computed: {
			...mapState(['theme']),
		},
		onLoad() {
			this.getList()
			this.getProductList()
		},
		methods: {
			getList(){
				const that = this
				that.$utils.initDataToken({
						url: "defi"
					}, res => {
						that.list = res.data
						console.log(res,22);
					});
			},
			// 产品列表
			getProductList() {
				try {
					const that = this;
					that.$utils.initDataToken({
						url: "fund/list",
						data: {
							limit: 20,
							page: 0,
						}
					}, res => {
						console.log(res);
						if (res.data.length) {
							const data = res.data.map((item) => {
								return {
									id: item.id,
									icon: item.image,
									title: item.title,
									code: item.currency_code,
									staring_sub_amount: item.staring_sub_amount,
									lock_dividend_days: item.lock_dividend_days,
									liquidated_damages: item.liquidated_damages,
									dividend_percentage: item.dividend_percentage,
									max_sub_amount: item.max_sub_amount,
									speed:item.speed*100
								}
							})
							console.log(data);
							that.$set(this, 'accounts', data);
						}
					});
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}
			},
		}
	};
</script>
