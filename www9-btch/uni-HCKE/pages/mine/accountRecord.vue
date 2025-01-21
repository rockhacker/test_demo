<template>
	<view class="blue" :class="{ light: theme == 'light' }">
		<!-- <view class="bgHeader h10"></view> -->
		<view class="plr10 ptb15 mt10 bgPart" style="min-height: 80vh;">
			<view class="mt10 pb100">
				<view class="flex alcenter ptb10 bdb_blue3 ">
					<view class="flex1">{{ $t('legal.coin') }}</view>
					<view class="flex1">{{ $t('trade.num') }}</view>
					<view class="flex1 ">{{ $t('assets.record') }}</view>
					<view class="flex1 tr">{{ $t('trade.time') }}</view>
				</view>
				<view class="mt10 flex bdb_blue3 ptb5" v-for="(item, i) in logList" :key="i" v-if="logList.length > 0">
					<view class="flex1">{{ item.currency.code }}</view>
					<view class="flex1">{{ item.value - 0 }}</view>
					<view class="flex1 wordbreak pr10">{{ item.memo }}</view>
					<view class="flex1 tr">{{ item.created_at }}</view>
				</view>
				<view class="mt20 tc" v-if="logList.length == 0">
					<image src="../../static/image/anonymous.png" class="wt60 h60"></image>
					<view>{{ $t('home.norecord') }}</view>
				</view>
				<view class="tc gray7 ptb20" v-show="!hasMore && logList.length > 0">{{ $t('home.nomore') }}</view>
			</view>
		</view>
	</view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	data() {
		return {
			currency: '',
			tradeType: '',
			page: 1,
			isBottom: false,
			hasMore: true,
			coinInfo: {},
			logList: [],
			titles: [this.$t('assets.tradeacc'), this.$t('assets.leveracc'), this.$t('assets.legalacc'),this.$t('assets.microacc')],
			ExRate: 6.5,
			id: '',
			account_id: '',
			currency_id: '',
			logurl: '',
			changeTransfer: 0,
			legalTransfer: 0,
			leverTransfer: 0,
			microTransfer: 0,
		};
	},
	computed: {
		...mapState(['theme'])
	},
	onShow() {
		this.$utils.setThemeTop(this.theme);
		// this.$utils.setThemeBottom(this.theme)
	},
	onLoad(e) {
		this.getLog();
		uni.setNavigationBarTitle({
				title: this.$t('new.record')
		});
		// uni.setNavigationBarTitle({
		// 	title:e.titleNameflegal
		// })
	},
	methods: {
		goTrade() {
			let localData = uni.getStorageSync('tradeData') || {};
			let currency_name = this.coinInfo.currency_name;
			console.log(uni.getStorageSync('tradeData'), localData);
			if (localData.legal_name && localData.legal_name != currency_name) {
				console.log(123);
				localData.currency_name = currency_name;
				localData.currency_id = this.currency_id;
				uni.setStorageSync('tradeData', localData);
			}
			uni.switchTab({
				url: '/pages/trade/trade'
			});
		},
		getLog() {
			let that = this;
			let url = 'account_log/allChangeLogs';
			this.$utils.initDataToken({ url: url, data: {  page: this.page, limit: 15 } }, res => {
				uni.stopPullDownRefresh();
				that.isBottom = false;
				if(this.page==1){
					that.logList=res.data
				}else if(this.page>1){
					for(let key in res.data){
						that.logList.push(res.data[key])
					}
				}
			 
			});
		}
	},
	onPullDownRefresh() {
		this.page = 1;
		(this.bottom = false), (this.hasMore = true), this.getLog();
	},
	onReachBottom() {
		if (!this.hasMore) return;
		this.page++;
		this.getLog();
	}
};
</script>

<style></style>
