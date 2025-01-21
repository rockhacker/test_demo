<template>
	<view class="min-h-screen" :class="theme">
		<view class="min-h-screen bg-my-grey dark:bg-my-black">
			<uni-nav-bar fixed backIcon>
			<view class="flex-1 p-30 bg-white dark:bg-main-black text-black dark:text-white flex justify-center items-center text-xl">
				{{$t('subscription.new_subscription')}}
			</view>
			<slot name="right">
				<navigator url="./orders" class="px-10 py-10 border-solid border-2 border-new-orange rounded-10 absolute top-24 right-20 z-10 text-new-orange" >{{$t('subscription.my_subscription')}}</navigator>
			</slot>
		</uni-nav-bar>
			
		<view class="p-30" v-if="list.length">
			<navigator class="rounded-10 bg-white dark:bg-main-black dark:text-black p-20 mb-20" :url="`./details?id=${item.id}`" hover-class="opacity-50" v-for="(item,index) in list" :key="index">
				<view class="rounded-10">
					<view class="flex justify-between items-center mb-10">
						<text class="text-xl font-bold text-333333 dark:text-white">{{item.currency_name}} {{$t('subscription.new_subscription')}}</text>
						<view class="text-sm rounded-8 px-20 py-10 bg-main-linear">
							<view class="text-clip-yellow dark:text-101625">{{$t('subscription.canjiahuodong')}}</view>
						</view>
					</view>
					<view class="flex justify-between items-center mb-20">
						<view class="rounded-8 py-6 px-10 border-2 border-solid " v-if="statusFormatting(item.start_time,item.finish_time,item.market_time).index"
						:class="{
							'border-gray-400 text-gray-400':statusFormatting(item.start_time,item.finish_time,item.market_time).index == 1,
							'border-success text-success':statusFormatting(item.start_time,item.finish_time,item.market_time).index == 2,
							'border-yellow-500 text-yellow-500':statusFormatting(item.start_time,item.finish_time,item.market_time).index == 3,
							'border-blue-400 text-blue-400':statusFormatting(item.start_time,item.finish_time,item.market_time).index == 4,
						}">
							{{statusFormatting(item.start_time,item.finish_time,item.market_time).name}}
						</view>
						<!-- <view class="text-sm">
							<text>{{$t('锁仓期限')}}</text>:
							<text class="text-yellow-500 ml-10">0天</text>
						</view> -->
					</view>
					<view class="flex justify-between items-center mb-20">
						<view class="text-sm flex items-center">
							<view class="text-333333 dark:text-white font-bold">
								<text class="mr-10">{{item.subscribed}}</text>
								<text class="mr-10">{{item.currency_name}}</text>
								<text class="mr-10">/</text>
							</view>
							<view class="text-838B99 dark:text-999FAA">
								<text class="mr-10">{{item.issue_number}}</text>
								<text class="mr-10">{{item.currency_name}}</text>
							</view>
						</view>
						<view class="text-sm">
							<text class="text-333333 dark:text-white">{{$t('subscription.shengyu')}}</text>:
							<text class="ml-10 text-333333 dark:text-white">{{ remainingRatio(item.subscribed,item.issue_number)}}%</text>
						</view>
					</view>
					<view class="w-full h-30 rounded-2xl bg-gray-200 relative overflow-hidden">
						<view class="absolute left-0 h-full leading-30 bg-main-linear text-white text-sm text-right" :style="`width: ${remainingRatio(item.subscribed,item.issue_number)}%;`">
							<text class="mx-10">{{remainingRatio(item.subscribed,item.issue_number)}}%</text>
						</view>
					</view>
				</view>
			</navigator>
		</view>
		<view class="pt-100 text-center" v-if="list.length == 0">
			<image src="../../static/image/anonymous.png" class="w-120 h-120"></image>
			<view>{{ $t('home.norecord') }}</view>
		</view>
		</view>
	</view>
</template>
<script>
	import { mapState } from 'vuex';
	export default{
		computed: {
			...mapState(['theme']),
			// 计算剩余百分比
			remainingRatio(amount,sum){
				return (amount,sum)=>{
					return ((((sum-amount) / sum) * 100) || 0).toFixed(2);
				}
			},
			statusFormatting(start,end,market){
				return (start,end,market)=>{
					
					let statusStr = [0,this.$t('subscription.weikaishi'),this.$t('subscription.jinxingzhong'),this.$t('subscription.chouqianzhong'),this.$t('subscription.yishangshi')],
						index = 0,
						startTime = new Date(start).getTime(),
						endTime = new Date(end).getTime(),
						marketTime = new Date(market).getTime(),
						currentTime = new Date().getTime() - 28800000;
							
					if(currentTime < startTime)index = 1;
					if(currentTime >= startTime && currentTime < endTime)index = 2;
					if(currentTime >= endTime && currentTime < marketTime)index = 3;
					if(currentTime >= marketTime)index = 4;
					return {name:statusStr[index],index:index};
				}
			}
		},
		data(){
			return {
                list:[]
			}
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
		},
		onLoad() {
           this.getSubscriptionList();
		},
		methods: {
			// 申购列表
			getSubscriptionList() {
				try {
					const that = this;
					that.$utils.initDataToken({
						url: "subscription/subscription_list",
						data: {
							limit: 20,
							page: 0,
						}
					}, res => {
						if (res.data.length) that.$set(this, 'list', res.data);
					});
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}
			}
		}
	}
</script>