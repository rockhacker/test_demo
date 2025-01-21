<template>
	<view :class="theme">
		<view class="text-black dark:text-white dark:bg-101625 dark:bg-opacity-30 w-full min-h-screen">
			<uni-nav-bar fixed backIcon>
				<view class="flex-1 p-30 bg-white dark:bg-1C2532 flex justify-center items-center text-2xl">
					{{$t('staking.kuanjishangcheng')}}
				</view>
				<slot name="right">
					<view class="w-100"></view>
					<navigator url="/pages/staking/orders" 
						class="px-10 py-10 border-2 rounded-10 absolute top-24 right-20 z-10" >
						<image src="/static/image/record1.png" mode="aspectFit" class="w-30 h-30" @tap=""></image>
					</navigator>
				</slot>
			</uni-nav-bar>

			<scroll-view scroll-y class="w-full">
				<view class="p-30 pt-0">
					<view class="justify-between rounded-10 bg-white dark:bg-1C2532 text-black dark:text-white px-20 py-30 mt-30"
						v-for="item,indexs in accounts" :key="indexs">
						<view class="text-2xl text-center border-b-2 border-0 border-gray-200 border-solid pb-20">
							{{item.title}}</view>
						<view class="flex justify-between items-center py-20">
							<view class="text-xl font-bold flex">
								<image :src="`${item.icon}`" class="w-120 h-120"></image>
								<view class="ml-20 flex flex-col justify-center">
									<view class="text-2xl">{{item.code}}</view>
								</view>
							</view>
							<view class="ml-20 flex flex-col justify-between text-center pr-20">
								<view class="text-lg">{{$t('staking.meiqipaixi')}} {{item.dividend_percentage}}%</view>
								<view class="mt-10">{{$t('staking.qigoujine')}} {{item.staring_sub_amount}}</view>
							</view>
						</view>
						<navigator :url="`/pages/staking/details?id=${item.id}`"
							class="mt-20 rounded-3xl p-20 text-white text-sm text-center bg-main-linear">
							{{ $t("staking.shengou") }}
						</navigator>
						<view class="mt-20 flex items-center text-center">
							<view class="flex-1">
								<view class="mt-10">{{item.lock_dividend_days}}</view>
								<view class="text-gray-400">{{$t('staking.suocangtianshu')}}</view>
							</view>
							<view class="flex-1">
								<view class="mt-10">{{item.max_sub_amount}}</view>
								<view class="text-gray-400">{{$t('staking.zuigaoshengou')}}</view>
							</view>
						<!-- 	<view class="flex-1">
								<view class="mt-10">{{item.liquidated_damages}}%</view>
								<view class="text-gray-400">{{$t('staking.shuhui')}}</view>
							</view> -->
						</view>
					</view>
				</view>
			</scroll-view>
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
				accounts: []
			};
		},
		computed: {
			...mapState(['theme']),
		},
		onLoad() {
			this.getProductList()
		},
		methods: {
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
									max_sub_amount: item.max_sub_amount
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
