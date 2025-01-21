<template>
	<view class="min-h-screen" :class="theme">
		<view class="min-h-screen bg-my-grey dark:bg-my-black text-white">
			<view class="text-center">
			<view class="flex h-80 items-center">
				<view class="flex-1">{{$t('subscription.shenggoushijian')}}</view>
				<view class="flex-1">{{$t('subscription.bizhong')}}</view>
				<view class="flex-1">{{$t('subscription.shenggoushuliang')}}</view>
				<view class="flex-1">{{$t('subscription.zhongqianshuliang')}}</view>
				<view class="flex-1">{{$t('subscription.shangshishijian')}}</view>
				<view class="flex-1">{{$t('subscription.status')}}</view>
			</view>
			<view class="flex h-100 items-center text-black dark:text-white border-0 border-solid border-b-2 border-gray-200" v-for="item,index in tableData" :key="index">
				<view class="flex-1">{{item.created_at}}</view>
				<view class="flex-1">{{item.subscription.currency_name}}</view>
				<view class="flex-1">{{item.number}}</view>
				<view class="flex-1">{{item.winning_lots_number}}</view>
				<view class="flex-1">{{item.subscription.market_time}}</view>
				<view class="flex-1 break-all">{{item.statusStr}}</view>
			</view>
		</view>
		</view>
	</view>
</template>
<script>
	import {mapState} from 'vuex'
	export default {
		data() {
			return {
				  tableData: []
			};
		},
		computed:{
		   ...mapState(['theme']),
		},
		onLoad(options) {
			uni.setNavigationBarTitle({
				title:this.$t("subscription.my_subscription")
			})
			this.getSubscriptionList();
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
		},
		methods:{
			// 申购列表
			getSubscriptionList() {
				try {
					const that=this;
					that.$utils.initDataToken({url: "subscription/mySubList" , data:{limit:100,page:0}}, res => {
						const statusStr = [this.$t("subscription.daichouqian"), this.$t("subscription.weizhongqian"), this.$t("subscription.yizhongqian") ,this.$t("subscription.yifabi") ,this.$t("subscription.yituikuan")];
						const data = res.data.map((item) => {
							item.status = item.status-1;
							return {
								...item,
								statusStr:  statusStr[item.status] + (item.is_return==2?that.$t('subscription.bufentuikuan'):'')
							}
						})
						that.$set(that,'tableData', data);
					});
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}	
			}
		}
	}
</script>