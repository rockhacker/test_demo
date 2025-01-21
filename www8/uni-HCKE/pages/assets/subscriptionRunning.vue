<template>
	<view :class="theme">
		<view class="px-20 pt-30 mt-20 bg-white dark:bg-gray-800 min-h-full">
			<view class="flex items-center py-20 border-0 border-b-2 border-solid border-gray-100 dark:border-gray-900">
				<view class="flex-1">{{ $t('assets.currency') }}</view>
				<view class="flex-1">{{ $t('trade.num') }}</view>
				<view class="flex-1 ">{{ $t('assets.record') }}</view>
				<view class="w-250 tr">{{ $t('trade.time') }}</view>
			</view>
			<view class="flex py-20 h-80 items-center" v-for="(item, i) in list" :key="i" v-if="list.length > 0">
				<view class="flex-1">{{item.currency.code}}</view>
				<view class="flex-1">{{ item.value - 0 }}</view>
				<view class="flex-1">{{ item.memo }}</view>
				<view class="w-250 text-right">{{ item.created_at }}</view>
			</view>
			<view class="text-center py-40" v-show="!hasMore && list.length > 0">{{ $t('home.nomore') }}</view>
		</view>
		<view class="mt-40 text-center" v-if="list.length == 0">
			<image src="../../static/image/anonymous.png" class="w-120 h-120"></image>
			<view>{{ $t('home.norecord') }}</view>
		</view>
	</view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	data() {
		return {
			pageInfo:{
				pageSize:15,
				pageNumber:1
			},
			list: [],
			isBottom: false,
			hasMore: true,
		};
	},
	computed: {
		...mapState(['theme'])
	},
	onShow() {
		//设置头部主题样式
		this.$utils.setThemeTop(this.theme);
	},
	onLoad(e) {
		uni.setNavigationBarTitle({
			title: this.$t('assets.subscriptionRunning')
		})
		this.getSubAccountLog();
	},
	methods: {
		getSubAccountLog(){
			
			try {
				
				const that=this;
				
				that.$utils.initDataToken({
					url: "subscription/SubAccountLog",
					data:{
						limit: that.pageInfo.pageSize,
						page: that.pageInfo.pageNumber,
					}}, res => {
						uni.stopPullDownRefresh();
						
						that.isBottom = false;
						
						that.$set(this,'list',that.pageInfo.pageNumber == 1 ? res.data : that.list.concat(res.data));
						
						that.hasMore = res.last_page != res.current_page;
						
					});
			} catch (e) {
				console.log(e);
				//TODO handle the exception
			}
		},
	},
	onPullDownRefresh() {
		this.pageInfo.pageNumber = 1;
		(this.bottom = false), (this.hasMore = true), this.getSubAccountLog();
	},
	onReachBottom() {
		if (!this.hasMore) return;
		this.pageInfo.pageNumber++;
		this.getSubAccountLog();
	}
};
</script>