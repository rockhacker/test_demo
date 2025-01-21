<template>
	<view :class="theme">
		
		<view class="p-30 bg-white dark:bg-main-black dark:text-white">
			<view class="flex items-center justify-between border-2 border-solid border-gray-200 dark:border-gray-800 rounded-10">
				<view class="flex items-center flex-1">
					<view class="flex flex-col items-center px-30">
						<text class="w-10 h-10 rounded-half bg-new-orange"></text>
						<view class="w-4 h-40 my-10 bg-gray-200 dark:bg-gray-800"></view>
						<text class="w-10 h-10 rounded-half bg-k-red"></text>
					</view>
					<view class="flex-1">
						<view class="h-100 flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-800">
							<text class="text-gray-400 mr-20">{{ $t('assets.from') }}</text>
							<view :class="[{ animateDown: type == 1, animateOff: type == 0 }]" v-if="accountList1.length >0">
								<picker :value="index1" :range="accountList1" class="flex-1" @change="bindPickerChange1" range-key="name">
									<view class="text-sm">{{ accountList1[index1].name }}</view>
								</picker>
							</view>
						</view>
						<view class="h-100 flex items-center">
							<text class="text-gray-400 mr-20">{{ $t('assets.to') }}</text>
							<view :class="[{ animateUp: type == 1, animateOff: type == 0 }]" v-if="accountList1.length >0">
								<picker :value="index2" :range="accountList1" class="flex-1" @change="bindPickerChange2" range-key="name">
									<view class="text-sm">{{ accountList1[index2].name }}</view>
								</picker>
							</view>
						</view>
					</view>
				</view>
			</view>
		</view>
		
		<view class="mt-20 py-20 bg-white dark:bg-main-black dark:text-white">
			<view class="px-30 py-20">{{ $t('assets.transfernum') }}</view>
			<view class="px-30 flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-800 dark:text-white">
				<input type="number" class="h-100 flex-1" v-model="number" :placeholder="$t('assets.p_transfernum')" />
				<view class="flex items-center">
					<text class="blue ft14 pr10 bdr_white50" v-if="coinInfo.currency.code">{{ coinInfo.currency.code || '--' }}</text>
					<view class="pl-20" @tap="all">{{ $t('trade.all') }}</view>
				</view>
			</view>
			<view class="px-30 py-20 text-gray-400 text-sm" v-if="coinInfo.currency.code">
				{{ $t('trade.use') }}:
				<text class="mx-10">
					<template v-if="accountList1[index1] && accountList1[index1].account_code == 'change_account'">{{ changeBalance ||'0.00'}}</template>
					<template v-if="accountList1[index1] && accountList1[index1].account_code == 'legal_account'">{{ legalBalance ||'0.00'}}</template>
					<template v-if="accountList1[index1] && accountList1[index1].account_code == 'lever_account'">{{ leverBalance ||'0.00'}}</template>
					<template v-if="accountList1[index1] && accountList1[index1].account_code == 'micro_account'">{{ microBalance ||'0.00'}}</template>
				</text>
				{{ coinInfo.currency.code }}
			</view>
			<view class="px-30 py-20 mt-40">
				<view class="bg-new-orange text-black rounded-10 p-30 text-lg text-center" @tap="transfer" hover-class="opacity-50">{{ $t('assets.transfer') }}</view>
			</view>
		</view>
		
		<view class="py-30 mt-20 bg-white dark:bg-main-black dark:text-white" style="min-height:50vh">
			<view class="px-30 text-xl">{{ $t('assets.transferlog') }}</view>
			<view>
				<view class="p-30 flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-800">
					<view class="flex-1">{{ $t('trade.num') }}</view>
					<view class="w-220">{{ $t('assets.record') }}</view>
					<view class="w-240 text-right">{{ $t('trade.time') }}</view>
				</view>
				<view class="mx-30 py-20 flex items-center justify-center" v-for="(item, i) in logList" :key="i" v-if="logList.length > 0">
					<view class="flex-1">{{ item.balance - 0 }}</view>
					<view class="w-220">{{ item.from_name+'-'+item.to_name }}</view>
					<view class="w-240 text-right">{{ item.created_at }}</view>
				</view>
				<view class="text-center p-100" v-if="logList.length == 0">
					<image src="../../static/image/anonymous.png" class="w-120 h-120"></image>
					<view>{{ $t('home.norecord') }}</view>
				</view>
				<view class="text-center text-gray-400 py-40" v-show="!hasMore && logList.length > 0">{{ $t('home.nomore') }}</view>
			</view>
		</view>
	</view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	data() {
		return {
			number: '',
			name: '',
			coinInfo: {currency:{}},
			changeName: [this.$t('assets.legalacc'), this.$t('assets.tradeacc')],
			changeType: ['legal', 'change'],
			type: 0, //法币兑币币
			hasChange: 0,
			animateTab1: '',
			animateTab2: '',
			currencyLegal: {},
			currencyTrade: {},
			balance: '',
			wallet_id: '',
			accountList1: [],
			accountList2: [],
			accountTypeId:'',
			ids:'',
			index1:0,
			index2:1,
			currency_id:'',
			changeBalance:'',
			legalBalance:'',
			leverBalance:'',
			microBalance:'',
			logList: [],
			page:1,
			isBottom: false,
			hasMore: true,
			account_code:'',
			changeTransfer: 0,
		    legalTransfer: 0,
		    leverTransfer: 0,
			microTransfer: 0,
		};
	},
	onLoad(e) {
		this.accountTypeId = e.accountTypeId;
		this.ids = e.id;
		this.account_code = e.account_code;
		uni.setNavigationBarTitle({
			title: this.$t('assets').transfer
		});
		this.$utils.setThemeTop(this.theme);
		this.init();
		
	},
	onPullDownRefresh() {
		this.getList();
		this.page = 1;
		(this.bottom = false), (this.hasMore = true), this.getLog();
	},
	computed: {
		...mapState(['theme'])
	},
	onShow() {
		
	},
	methods: {
		init() {
			var that = this;
			that.$utils.initDataToken({ url: 'account/detail', data: { account_type_id: that.accountTypeId, id: that.ids } }, res => {
				uni.stopPullDownRefresh();
				that.coinInfo = res;
				that.currency_id = res.currency_id;
				this.index1 =1
				this.index2 =0
				if (res.currency.is_recharge_account && res.currency.account_types.length > 1) {
					var datas = res.currency.account_types;
					that.accountList1 = res.currency.account_types;
					// that.accountList2 = res.currency.account_types;
					datas.forEach(function(item, index) {
						if (item.account_code == 'change_account' && item.is_recharge == 1) {
							that.changeTransfer = 1;
						} else if (item.account_code == 'legal_account' && item.is_recharge == 1) {
							that.legalTransfer = 1;
						} else if (item.account_code == 'lever_account' && item.is_recharge == 1) {
							that.leverTransfer = 1;
						}else if (item.account_code == 'micro_account' && item.is_recharge == 1) {
							that.microTransfer = 1;
						}
					});
				}
				this.getList();
				this.getLog();
			});
		},
		getList() {
			var that = this;
			that.$utils.initDataToken({ url: 'account/list' }, res => {
				uni.stopPullDownRefresh();
				// 获取法币余额和当前法币信息
				res.forEach(function(item,index){
					if(item.account_code=='change_account'){
						var change_account = item.accounts;
						var selectChange_wallet = change_account.filter(options => options.currency_id == that.currency_id);
						that.changeBalance = selectChange_wallet[0].balance;
					}else if(item.account_code=='legal_account'){
						var legal_account = item.accounts;
						var selectLegal_wallet = legal_account.filter(options => options.currency_id == that.currency_id);
						that.legalBalance = selectLegal_wallet[0].balance;
					}else if(item.account_code=='lever_account'){
						var lever_account = item.accounts;
						var selectLever_wallet = lever_account.filter(options => options.currency_id == that.currency_id);
						that.leverBalance = selectLever_wallet[0].balance;
					}else if(item.account_code=='micro_account'){
						var micro_account = item.accounts;
						var selectLever_wallet = micro_account.filter(options => options.currency_id == that.currency_id);
						that.microBalance = selectLever_wallet[0].balance;
					}
				})
			});
		},
		bindPickerChange1(e){
			var that = this;
			var indexs= e.target.value;
			that.index1 = indexs;
			if(that.changeTransfer == 1){
				if(that.accountList1[indexs].account_code == 'change_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code!= 'change_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'legal_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'change_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'lever_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'change_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'micro_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'change_account'){
							that.index2 = index;
							return false;
						}
					})
				}
			}else if(that.legalTransfer == 1){
				if(that.accountList1[indexs].account_code == 'change_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'legal_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'legal_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code!= 'legal_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'lever_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'legal_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'micro_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'legal_account'){
							that.index2 = index;
							return false;
						}
					})
				}
			}else if(that.leverTransfer == 1){
				if(that.accountList1[indexs].account_code == 'change_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'lever_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'legal_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'lever_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'lever_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code!= 'lever_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'micro_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'lever_account'){
							that.index2 = index;
							return false;
						}
					})
				}
			}else if(that.microTransfer == 1){
				if(that.accountList1[indexs].account_code == 'change_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'micro_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'legal_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'micro_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'lever_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'micro_account'){
							that.index2 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'micro_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code!= 'micro_account'){
							that.index2 = index;
							return false;
						}
					})
				}
			}
		},
		bindPickerChange2(e){
			var that = this;
			var indexs= e.target.value;
			that.index2 = indexs;
			if(that.changeTransfer == 1){
				if(that.accountList1[indexs].account_code == 'change_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code!= 'change_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'legal_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'change_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'lever_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'change_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'micro_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'change_account'){
							that.index1 = index;
							return false;
						}
					})
				}
			}else if(that.legalTransfer == 1){
				if(that.accountList1[indexs].account_code == 'change_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'legal_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'legal_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code!= 'legal_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'lever_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'legal_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'micro_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'legal_account'){
							that.index1 = index;
							return false;
						}
					})
				}
			}else if(that.leverTransfer == 1){
				if(that.accountList1[indexs].account_code == 'change_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'lever_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'legal_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'lever_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'lever_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code!= 'lever_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'micro_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code!= 'lever_account'){
							that.index1 = index;
							return false;
						}
					})
				}
			}else if(that.microTransfer == 1){
				if(that.accountList1[indexs].account_code == 'change_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'micro_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'legal_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code== 'micro_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'lever_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code!= 'micro_account'){
							that.index1 = index;
							return false;
						}
					})
				}else if(that.accountList1[indexs].account_code == 'micro_account'){
					that.accountList1.forEach(function(item,index){
						if(item.account_code!= 'micro_account'){
							that.index1 = index;
							return false;
						}
					})
				}
			}
		},
		tapChange() {
			console.log(this.hasChange);
			this.type = this.type == 0 ? 1 : 0;
			this.changeType = this.changeType.reverse();
			console.log(this.changeType);
			if (this.type == 0) {
				this.balance = this.currencyLegal.legal_balance;
			} else {
				this.balance = this.currencyTrade.change_balance;
			}
			this.hasChange++;
		},
		all() {
			if(this.accountList1[this.index1].account_code == 'change_account'){
				this.number = this.changeBalance;
			}else if (this.accountList1[this.index1].account_code == 'legal_account'){
				this.number = this.legalBalance;
			}else if (this.accountList1[this.index1].account_code == 'legal_account'){
				this.number = this.legalBalance;
			}else{
				this.number = this.microBalance;
			}
		},
		transfer() {
			if (!this.number) {
				return this.$utils.showLayer(this.$t('assets.p_transfernum'));
			}
			this.$utils.initDataToken(
				{
					url: 'account/transfer',
					type: 'POST',
					data: {
						currency_id: this.currency_id,
						balance: this.number,
						from: this.accountList1[this.index1].account_code,
						to: this.accountList1[this.index2].account_code
					}
				},
				(res,msg) => {
					this.number = '';
					this.$utils.showLayer(msg);
					setTimeout(() => {
						this.getList();
						this.page = 1;
		                (this.bottom = false), (this.hasMore = true), this.getLog();
					}, 1500);
				}
			);
		},
		getLog() {
			let that = this;
			this.$utils.initDataToken({ url: 'account/transfer_log', data: { currency_id: this.currency_id, page: this.page,type:this.account_code,limit: 15 } }, res => {
				uni.stopPullDownRefresh();
				let data = res.data;
				that.isBottom = false;
				that.logList = that.page == 1 ? data : that.logList.concat(data);
				that.hasMore = res.last_page == res.current_page ? false : true;
			});
		},
		onReachBottom() {
			if (!this.hasMore) return;
			this.page++;
			this.getLog();
		}
	}
};
</script>

<style>
.animateUp {
	transform: translateY(-80upx);
	transition: all 0.5s;
}
.animateDown {
	transform: translateY(80upx);
	transition: all 0.5s;
}
.animateOff {
	transform: translateY(0);
	transition: all 0.5s;
}
</style>
