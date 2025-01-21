<template>
	<view :class="theme">
		<view class="bg-white dark:bg-1C2532 text-black dark:text-white">
			
			<view class="p-40  border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
				<view class="text-2xl">{{ currencyName || '--' }} {{ $t('assets.mention') }}</view>
				<view class="mt-20">{{ $t('trade.use') }} {{ balance }} {{ currencyName || '--' }}</view>
				<view class="pt-40" v-if="coinInfo.currency_protocols&&coinInfo.currency_protocols.length > 1">
					<view class="text-lg">{{$t('bind.liantype')}}</view>
					<view class="flex mt-20">
						<view v-for="(item, index) in coinInfo.currency_protocols" :key="index" class="mr-20 px-20 py-10 border-2 border-solid"
							:class="name == item.chain_protocol.code ? 'text-my-green border-my-green' : 'text-gray-500 border-gray-500'" @tap="selectCharge(item)">
							{{ item.chain_protocol.code }}
						</view>
					</view>
				</view>
			</view>
			<view class="p-40 ">
				<view class="mb-40">
					<view class="text-xl">{{ $t('assets.mentionaddr') }}</view>
					<view class="flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
						<input type="text" v-model="address" class="h-80 flex-1" disabled="" :placeholder="$t('assets.p_addr')" />
						<view class="flex items-center px-20"  @click="toUrl">
							<view class="text-lg" v-if="!address">{{$t('new.shezhi')}}</view>
						</view>
					</view>
				</view>
				<view class="mb-40">
					<view class="text-xl">{{ $t('trade.num') }}</view>
					<view class="flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
						<input type="number" class="h-80 flex-1" v-model="number" @input="numberChange" :placeholder="$t('assets.minnum') + (coinInfo.draw_min || '0.00')" />
						<view class="flex items-center">
							<text class="text-gray-500 text-lg pr-20 border-0 border-r-2 border-solid border-gray-200 dark:border-gray-700 ">{{ currencyName || '--' }}</text>
							<view class="text-lg px-20" @tap="all">{{ $t('trade.all') }}</view>
						</view>
					</view>
				</view>
			
				<view class="mb-40">
					<view class="text-xl">{{ $t('login.s_dealpwd') }}</view>
					<input type="text" password="" class="border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700 h-80 w-full" v-model="password" :placeholder="$t('login.e_pdeal')" />
				</view>
				<view class="mb-40 flex items-center justify-between">
					<view class="text-xl">{{ $t('assets.recivenum') }}</view>
					<view class="text-xl">{{ reciveNumber }} {{ currencyName || '--' }}</view>
				</view>
				<view class="mb-40">{{ $t('trade.fee') }}：{{ coinInfo.draw_rate*100 || '--' }}% {{ currencyName || '--' }}</view>
				
				<view class="mt-20 rounded-10 h-80 flex justify-center items-center text-white text-sm text-center bg-main-linear" @tap="mention">{{ $t('assets.mention') }}</view>
			</view>
			
			<view class="p-40">
				<view class="text-xl mb-20">{{ $t('assets.merecord') }}</view>
				<view class="min-h-500">
					<!-- <view class="flex items-center py-20 border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
						<view class="flex-1">{{ $t('trade.num') }}</view>
						<view class="flex-1">{{ $t('assets.record') }}</view>
						<view class="flex-1 text-right">{{ $t('trade.time') }}</view>
					</view> -->
					<view class="mb-40 border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700 py-20" v-for="(item, i) in logList" :key="i" v-if="logList.length > 0">
						<view class="flex">
							<view class="flex-1">
								<text class="text-gray-500">{{ $t('trade.num') }}</text>
								<view class="mt-10 text-lg">{{item.number}}</view>
							</view>
							<view class="flex-1 text-center">
								<text class="text-gray-500">{{ $t('trade.fee') }}</text>
								<view class="mt-10 text-lg">{{item.fee}}</view>
							</view>
							<view class="flex-1 text-right">
								<text class="text-gray-500">{{ $t('assets.recivenum') }}</text>
								<view class="mt-10 text-lg">{{item.real_number}}</view>
							</view>
						</view>
						<view class="flex mt-20">
							<view class="flex-1">
								<text class="text-gray-500">{{ $t('assets.status') }}</text>
								<view class="mt-10 text-lg">{{item.status_name}}</view>
							</view>
							<view class="flex-1 text-right">
								<text class="text-gray-500">{{ $t('trade.time') }}</text>
								<view class="mt-10 text-lg">{{item.created_at}}</view>
							</view>
						</view>
						<view class="flex mt-20">
							<view class="flex-1">
								<text class="text-gray-500">{{ $t('assets.mentionaddr') }}</text>
								<view class="mt-10 text-lg">{{item.address}}</view>
							</view>
						</view>
						<view class="flex mt-20" v-if="item.notes">
							<view class="flex-1">
								<text class="text-gray-500">{{ $t('assets.remarks') }}</text>
								<view class="mt-10 text-lg">{{item.notes}}</view>
							</view>
						</view>
					</view>
					<view class="py-100 flex justify-center flex-col items-center text-center" v-if="logList.length == 0">
						<image src="../../static/image/anonymous.png" class="w-120 h-120"></image>
						<view class="mt-20">{{ $t('home.norecord') }}</view>
					</view>
					<view class="text-center py-40" v-show="!hasMore && logList.length > 0">{{ $t('home.nomore') }}</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	data() {
		return {
			password: '',
			currency: '',
			coinInfo: {},
			address: '',
			name: '',
			number: '',
			reciveNumber: '0.0',
			chargeType: [],
			contractAddress: '',
			userId: '',
			currencyName: '',
			currencyType: '',
			balance: '',
			labelText: '',
			walletData: [],
			showMemo:false,
			memoText:"",
			currencyProtocolId:'',
			account_type_id:'',
			currencyId: '',
			page: 0,
			hasMore: true,
			logList: [],
		};
	},
	onLoad(e) {
		uni.setNavigationBarTitle({
			title: this.$t('assets').mention
		});
		this.id = e.id;
		this.currency = e.currency;
		this.name = e.name;
		console.log(this.name)
		this.account_type_id = e.account_type_id;
		this.getLog();
		this.getCoinInfo();
	},
	computed: {
		...mapState(['theme'])
	},
	onPullDownRefresh() {
		this.page = 0;
		this.getLog();
		this.getCoinInfo();
	},
	onReachBottom() {
		if (!this.hasMore){
			return;
		} 
		this.page++;
		this.getLog();
	},
	onShow() {
		this.getCoinInfo();
		this.$utils.setThemeTop(this.theme);
	},
	methods: {
		toUrl(){
			console.log(this.name)
			uni.navigateTo({url: '/pages/assets/bindMentionAddress?code='+this.currencyName+'&options='+this.name })
		},
		getCoinInfo() {
			this.$utils.initDataToken({url:'account/detail',data:{currency_id:this.currency,account_type_id:this.account_type_id,id:this.id}},res=>{
				uni.stopPullDownRefresh();
				this.coinInfo=res.currency;
				this.currencyName = res.currency.code;
				this.balance = res.balance;
				this.userId = res.user_id;
				if(res.currency.currency_protocols.length >0){
					this.currencyProtocolId = res.currency.currency_protocols[0].id;
					this.name = res.currency.currency_protocols[0].chain_protocol.code;
					this.contractAddress = res.currency.currency_protocols[0].token_address;
					this.currency_id = res.currency.id;
					this.getAddress(res.user_id);
				}else{
					this.getAddress(res.user_id);
				}
				
			})
			// this.$utils.initDataToken({ url: 'account/get_info', type: 'POST', data: { currency_id: this.currency } }, res => {
			// 	uni.stopPullDownRefresh();
			// 	this.currencyName = res.name;
			// 	this.balance = res.change_balance;
			// 	this.walletData = res.wallet_data;
			// 	if(res.make_wallet == 2){
			// 		this.showMemo = true;
			// 	}else{
			// 		this.showMemo = false;
			// 	}
			// 	if (res.multi_protocol == 1) {
			// 		this.chargeType = res.type_data;
			// 		this.contractAddress = res.type_data[0].contract_address;
			// 		this.name = res.type_data[0].name;
			// 		this.coinInfo = res.type_data[0];
			// 		this.currencyType = res.type_data[0].type;
			// 		var ids = res.type_data[0].id;
					
			// 	} else {
			// 		this.contractAddress = res.contract_address;
			// 		this.name = res.name;
			// 		this.coinInfo = res;
			// 		// if (res.wallet_data && res.wallet_data.length > 0) {
			// 		// 	this.labelText = res.wallet_data[0].label;
			// 		// }
			// 	}
			// 	this.getUserInfo();
			// });
		},
		// getUserInfo() {
		// 	this.$utils.initDataToken({ url: 'user/info' }, res => {
		// 		this.getAddress(res.id);
		// 		this.userId = res.id;
		// 	});
		// },
		getAddress(id) {
			let contract_address='';
			// if(this.coinInfo.currency_protocols.length>0){
			// 	contract_address = this.coinInfo.currency_protocols[0].token_address;
			// }
			this.$utils.getAddressOnline(
				{ url: 'GetDrawAddress', data: { user_id: id, coin_name: this.name, contract_address:this.contractAddress, 
				currency_id: this.currency_id, currency_protocol_id: this.currencyProtocolId} },
				res => {
					uni.stopPullDownRefresh();
					console.log(res);
					if (res.code == 1) {
						this.address = res.data.address;
					} else {
						this.$utils.showLayer(res.errorinfo);
					}
				}
			);
		},
		all() {
			this.number = this.balance;
			// this.reciveNumber = this.balance* (1 - this.coinInfo.rate / 100);
			this.reciveNumber = this.balance - (this.balance*(this.coinInfo.draw_rate));
		},
		numberChange(e) {
			// 到账数量
			// this.reciveNumber = e.target.value * (1 - this.coinInfo.draw_rate / 100);
			this.reciveNumber = e.target.value - (e.target.value*(this.coinInfo.draw_rate));
		},
		// 选择充币类型
		selectCharge(options) {
			var that = this;
			that.contractAddress = options.token_address;
			that.name = options.chain_protocol.code;
			// that.coinInfo = options;
			this.currencyProtocolId = options.id;
			// that.currencyType = options.type;
			that.address = "";
			that.memoText = "";
			// var ids = options.id;
			// if (that.walletData.length > 0) {
			// 	that.walletData.forEach(item => {
			// 		if (ids == item.currency) {
			// 			that.labelText = item.label;
			// 		}
			// 	});
			// }
			that.getAddress(that.userId);
		},
		// 复制标签地址
		copyLabel() {
			var that = this;
			// #ifdef APP-PLUS
			uni.setClipboardData({
				data: that.labelText,
				success: function() {
					that.$utils.showLayer(that.$t('assets.copy_success'));
				},
				fail: function() {
					that.$utils.showLayer(that.$t('assets.copy_err'));
				}
			});
			// #endif
		},
		mention() {
			if (!this.address) {
				return this.$utils.showLayer(this.$t('assets.p_addr'));
			}
			if (!this.number) {
				return this.$utils.showLayer(this.$t('assets.p_minnum'));
			}
			if (!this.password) {
				return this.$utils.showLayer(this.$t('login.e_pdeal'));
			}
			if (this.password.length < 6) {
				return this.$utils.showLayer(this.$t('login.e_pdealerr'));
			}
			this.$utils.initDataToken(
				{
					url: 'account/draw',
					type: 'POST',
					data: { currency_id: this.currency, number: this.number, address: this.address, pay_password: this.password,memo:this.memoText,currency_protocol_id:this.currencyProtocolId }
				},
				(res, msg) => {
					console.log(res);
					this.$utils.showLayer(msg);
					this.page = 1;
					this.getLog();
					setTimeout(() => {
						// this.getCoinInfo();
						uni.navigateBack({
							delta: 1
						});
					}, 1500);
				}
			);
		},
		getLog() {
			let that = this;

			this.$utils.initDataToken({ url: 'account/draw_list', data: { currency_id: this.currency, page: this.page, limit: 15 } }, res => {
				uni.stopPullDownRefresh();
				let data = res.data;
				that.logList = that.page == 1 ? data : that.logList.concat(data);
				that.hasMore = res.last_page <= res.current_page ? false : true;
				console.log(that.hasMore)
			});
		}
	}
};
</script>
