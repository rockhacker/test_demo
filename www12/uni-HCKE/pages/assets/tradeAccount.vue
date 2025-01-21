<template>
	<view :class="theme">
		<view class="p-30 bg-white dark:bg-main-black dark:text-white">
			<text class="text-2xl text-black dark:text-white" v-if="coinInfo.currency">{{ coinInfo.currency.code }}</text>
			<view class="flex mt-20 items-center">
				<view class="flex-1">
					<view class="text-sm">{{ this.$t('trade.use') }}</view>
					<view class="mt-10 text-sm ">{{ coinInfo.balance }}</view>
				</view>
				<view class="flex-1">
					<view class="text-sm">{{ $t('assets.lock') }}</view>
					<view class="mt-10 text-sm ">{{ coinInfo.lock_balance }}</view>
				</view>
				<view class="flex-1 text-right">
					<view class="text-sm">{{ $t('assets.zhehe') }}($)</view>
					<view class="mt-10">{{ coinInfo.convert_usd | filterDecimals }}</view>
				</view>
			</view>
		</view>
		<view class="px-20 pt-30 pb-140 mt-20 bg-white dark:bg-main-black dark:text-white" style="min-height: calc(100vh - 100px);">
			<view class="mb-20 text-xl">{{ $t('assets.records') }}</view>
			<view class="pb-100">
				<view class="flex items-center py-20 border-0 border-b-2 border-solid border-gray-100 dark:border-gray-900">
					<view class="flex-1">{{ $t('trade.num') }}</view>
					<view class="flex-1 ">{{ $t('assets.record') }}</view>
					<view class="w-250 tr">{{ $t('trade.time') }}</view>
				</view>
				<view class="flex py-20 h-80 items-center" v-for="(item, i) in logList" :key="i" v-if="logList.length > 0">
					<view class="flex-1">{{ item.value - 0 }}</view>
					<view class="flex-1">{{ item.memo }}</view>
					<view class="w-250 text-right">{{ item.created_at }}</view>
				</view>
				<view class="mt-40 text-center" v-if="logList.length == 0">
					<image src="../../static/image/anonymous.png" class="w-120 h-120"></image>
					<view>{{ $t('home.norecord') }}</view>
				</view>
				<view class="text-center py-40" v-show="!hasMore && logList.length > 0">{{ $t('home.nomore') }}</view>
			</view>
		</view>
		<view class="fixed w-full flex items-center bottom-0 bg-white dark:bg-floor border-0 border-t-2 border-solid border-gray-100 dark:border-gray-900">
			<!-- 币币账户 -->
			<block v-if="tradeType == 'change_account' &&coinInfo.account_type&& coinInfo.account_type.is_recharge == 1">
				<navigator :url="'transfer?accountTypeId=' + coinInfo.account_type_id+'&id='+coinInfo.id+'&account_code='+coinInfo.account_type.account_code" class="flex-1 text-center py-20" v-if="changeTransfer == 1">
					<image src="../../static/image/hz01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.transfer') }}</view>
				</navigator>
				<!-- 充币 -->
				<navigator
					:url="'charge?currency=' + currency_id + '&name=' + coinInfo.currency.code + '&id=' + id"
					class="flex-1 text-center py-20"
					v-if="coinInfo.currency && coinInfo.currency.open_recharge == 1"
				>
					<image src="../../static/image/cb01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.charge') }}</view>
				</navigator>
				<!-- 提币 -->
				<navigator
					:url="'mention?currency=' + currency_id + '&name=' + coinInfo.currency.code + '&id=' + account_id +'&account_type_id='+coinInfo.account_type_id" 
					class="flex-1 text-center py-20"
					v-if="coinInfo.currency && coinInfo.currency.open_draw == 1"
				>
					<image src="../../static/image/tb01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.mention') }}</view>
				</navigator>
			</block>
			<!-- 法币账户 -->
			<block v-if="tradeType == 'legal_account' && coinInfo.account_type&&coinInfo.account_type.is_recharge == 1">
				<navigator :url="'transfer?accountTypeId=' + coinInfo.account_type_id+'&id='+coinInfo.id" class="flex-1 text-center py-20" v-if="legalTransfer == 1">
					<image src="../../static/image/hz01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.transfer') }}</view>
				</navigator>
				<!-- 充币 -->
				<navigator
					:url="'charge?currency=' + currency_id + '&name=' + coinInfo.currency.code + '&id=' + id"
					class="flex-1 text-center py-20"
					v-if="coinInfo.currency && coinInfo.currency.open_recharge == 1"
				>
					<image src="../../static/image/cb01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.charge') }}</view>
				</navigator>
				<!-- 提币 -->
				<navigator
					:url="'mention?currency=' + currency_id + '&name=' + coinInfo.currency.code + '&id=' + account_id +'&account_type_id='+coinInfo.account_type_id"
					class="flex-1 text-center py-20"
					v-if="coinInfo.currency && coinInfo.currency.open_draw == 1"
				>
					<image src="../../static/image/tb01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.mention') }}</view>
				</navigator>
			</block>
			<!-- 杠杠账户 -->
			<block v-if="tradeType == 'lever_account' && coinInfo.account_type&&coinInfo.account_type.is_recharge == 1">
				<navigator :url="'transfer?accountTypeId=' + coinInfo.account_type_id+'&id='+coinInfo.id" class="flex-1 text-center py-20" v-if="leverTransfer == 1">
					<image src="../../static/image/hz01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.transfer') }}</view>
				</navigator>
				<!-- 充币 -->
				<navigator
					:url="'charge?currency=' + currency_id + '&name=' + coinInfo.currency.code + '&id=' + id"
					class="flex-1 text-center py-20"
					v-if="coinInfo.currency && coinInfo.currency.open_recharge == 1"
				>
					<image src="../../static/image/cb01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.charge') }}</view>
				</navigator>
				<!-- 提币 -->
				<navigator
					:url="'mention?currency=' + currency_id + '&name=' + coinInfo.currency.code + '&id=' + account_id +'&account_type_id='+coinInfo.account_type_id"
					class="flex-1 text-center py-20"
					v-if="coinInfo.currency && coinInfo.currency.open_draw == 1"
				>
					<image src="../../static/image/tb01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.mention') }}</view>
				</navigator>
			</block>
			<!-- 秒合约账户 -->
			<block v-if="tradeType == 'micro_account' && coinInfo.account_type&&coinInfo.account_type.is_recharge == 1">
				<navigator :url="'transfer?accountTypeId=' + coinInfo.account_type_id+'&id='+coinInfo.id" class="flex-1 text-center py-20" v-if="microTransfer == 1">
					<image src="../../static/image/hz01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.transfer') }}</view>
				</navigator>
				<!-- 充币 -->
				<navigator
					:url="'charge?currency=' + currency_id + '&name=' + coinInfo.currency.code + '&id=' + id"
					class="flex-1 text-center py-20"
					v-if="coinInfo.currency && coinInfo.currency.open_recharge == 1"
				>
					<image src="../../static/image/cb01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.charge') }}</view>
				</navigator>
				<!-- 提币 -->
				<navigator
					:url="'mention?currency=' + currency_id + '&name=' + coinInfo.currency.code + '&id=' + account_id +'&account_type_id='+coinInfo.account_type_id"
					class="flex-1 text-center py-20"
					v-if="coinInfo.currency && coinInfo.currency.open_draw == 1"
				>
					<image src="../../static/image/tb01.png" class="w-60 h-60"></image>
					<view class="text-white">{{ $t('assets.mention') }}</view>
				</navigator>
			</block>
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
			coinInfo: {
				currency:{},
				balance:0,
				lock_balance:0,
				convert_usd:0
			},
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
		//设置头部主题样式
		this.$utils.setThemeTop(this.theme);
		//设置底部主题样式
		// this.$utils.setThemeBottom(this.theme)
	},
	onLoad(e) {
		this.id = e.id;
		this.tradeType = e.type;
		this.currency_id = e.currency_id;
		this.account_id = e.account_id;
		this.getDetail();
		var that = this;
		if (e.type == 'change_account') {
			that.logurl = 'change';
			uni.setNavigationBarTitle({
				title: that.titles[0]
			});
		} else if (e.type == 'lever_account') {
			that.logurl = 'lever';
			uni.setNavigationBarTitle({
				title: that.titles[1]
			});
		} else if (e.type == 'micro_account'){
			that.logurl = 'micro';
			uni.setNavigationBarTitle({
				title: that.titles[3]
			});
		}else {
			that.logurl = 'legal';
			uni.setNavigationBarTitle({
				title: that.titles[2]
			});
		}
		this.getLog();
		// uni.setNavigationBarTitle({
		// 	title:e.titleName
		// })
	},
	methods: {
		getDetail() {
			var that = this;
			that.$utils.initDataToken({ url: 'account/detail', data: { account_type_id: that.id, id: that.account_id } }, res => {
				uni.stopPullDownRefresh();
				that.coinInfo = res;
				if (res.currency.is_recharge_account && res.currency.account_types.length > 1) {
					var datas = res.currency.account_types;
					datas.forEach(function(item, index) {
						if (item.account_code == 'change_account' && item.is_recharge == 1) {
							that.changeTransfer = 1;
						} else if (item.account_code == 'legal_account' && item.is_recharge == 1) {
							that.legalTransfer = 1;
						} else if (item.account_code == 'lever_account' && item.is_recharge == 1) {
							that.leverTransfer = 1;
						}
						else if (item.account_code == 'micro_account' && item.is_recharge == 1) {
							that.microTransfer = 1;
						}
					});
				}
			});
		},
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
			let url = 'account_log/' + this.logurl;
			this.$utils.initDataToken({ url: url, data: { currency_id: this.currency_id, page: this.page, limit: 15 } }, res => {
				uni.stopPullDownRefresh();
				let data = res.data;
				that.isBottom = false;
				that.logList = that.page == 1 ? data : that.logList.concat(data);
				that.hasMore = res.last_page == res.current_page ? false : true;
			});
		}
	},
	onPullDownRefresh() {
		this.page = 1;
		(this.bottom = false), (this.hasMore = true), this.getLog();
		this.getDetail();
	},
	onReachBottom() {
		if (!this.hasMore) return;
		this.page++;
		this.getLog();
	}
};
</script>