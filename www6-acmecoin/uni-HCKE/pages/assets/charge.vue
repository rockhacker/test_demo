<template>
	<view :class="theme">
		<view class="bg-white dark:bg-box">
			<view class="p-30 flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700 text-lg">
				<text>{{ $t('assets.cur_coin') }}</text>
				<text>{{ currencyName || '--' }}</text>
			</view>
			<view class="p-30" v-if="walletData.length > 1">
				<view class="text-lg">{{$t('bind.liantype')}}</view>
				<view class="flex mt-20">
					<view v-for="item, index in walletData" :key="index" class="mr-20 px-20 py-10 border-2 border-solid"
						:class="name == item.chain_protocol.code ? 'text-my-green border-my-green' : 'text-gray-500 border-gray-500'" @tap="selectCharge(item)">
						{{ item.chain_protocol.code }}
					</view>
				</view>
			</view>
		</view>
		<view class="p-30 flex justify-between mt-20 items-center" v-if="labelText">
			<view class="text-lg">{{ labelText }}</view>
			<view class="w-160 h-60 flex justify-center items-center bg-primary rounded-10" @tap="copyLabel">复制标签</view>
		</view>
		<view class="mt-20 bg-white dark:bg-box p-30 text-center">
			<image :src="img" mode="widthFix" :style="{ width: size + 'px', height: size + 'px' }" class="mauto"></image>
			<view class="p-30 text-lg text-center">{{ $t('assets.addr_charge') }}</view>
			<view class="text-center text-sm mt-10">{{ address }}</view>
			<view class="mt-20 mx-auto w-160 h-60 rounded-10 flex justify-center items-center bg-primary text-white" @tap="fuzhi_invite">{{ $t('assets.coypaddr') }}</view>
		</view>
		<view class="bg-white dark:bg-box p-30 text-gray1">
			<!-- <view class="mb-10">
				<text class="ft12">{{ $t('assets.c_tip1') }}</text>
				<text class="ft12">{{ currencyName || '--' }}</text>
				<text class="ft12">{{ $t('assets.assets') }}，</text>
				<text class="ft12">{{ $t('assets.c_tip2') }}。</text>
			</view> -->
			
			<view class="mb-10 text-sm">
				<text>{{ $t('assets.c_tip2_1') }}</text>
				<text>{{ currencyName || '--' }} </text>
				<text>{{ $t('assets.c_tip2_2') }}，</text>
				<text>{{ $t('assets.c_tip2_3') }}。</text>
			</view>
			<view class="mb-10 text-sm">
				<text>{{ currencyName || '--' }} </text>
				<text>{{ $t('assets.c_tip3') }}。</text>
			</view>
			<view class="mb-10 text-sm">{{ $t('assets.c_tip4') }}。</view>
			<!-- <view class="mb-10 text-sm">
				<text class="ft12">{{ $t('assets.c_tip5') }}：</text>
				<text class="mainnum ft12">{{ coinInfo.min_number || '--' }}</text>
				<text class="ft12">{{ currencyName || '--' }}</text>
				,
			</view> -->
			<!-- <view class="mb-10 ft12">{{ $t('assets.c_tip6') }}。</view> -->
			<view class="mb-10 text-sm">{{ $t('assets.c_tip7') }}。</view>
			<view class="mb-10 text-sm">{{ $t('assets.c_tip8') }}。</view>
		</view>
	</view>
</template>

<script>
	import QR from '@/common/qrcode.js';
	import {
		mapState
	} from 'vuex';
	export default {
		data() {
			return {
				title: '',
				currency: '',
				coinInfo: {},
				img: '',
				size: 160,
				address: '',
				name: '',
				chargeType: [],
				contractAddress: '',
				userId: '',
				currencyName: '',
				labelText: '',
				walletData: []
			};
		},
		onLoad(e) {
			this.currency = e.currency;
			this.name = e.name;
			uni.setNavigationBarTitle({
				title: this.$t('assets').charge
			});
			this.getCoinInfo();
		},
		onPullDownRefresh() {
			this.getCoinInfo();
		},
		computed: {
			...mapState(['theme'])
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
		},
		methods: {
			getCoinInfo() {
				this.$utils.initDataToken({
					url: 'wallet/wallet',
					data: {
						currency_id: this.currency
					}
				}, res => {
					this.currencyName = res.code;
					this.walletData = res.wallets;
					this.coinInfo = res.wallets[0];
					this.name = res.wallets[0].chain_protocol.code;
					this.labelText = res.wallets[0].memo;
					this.address = res.wallets[0].address;
					this.creatQrcode();
					// if (res.wallets.length > 1) {
					// 	this.chargeType = res.wallets;
					// 	this.contractAddress = res.type_data[0].contract_address;
					// 	this.name = res.type_data[0].type;
					// 	this.coinInfo = res.type_data[0];
					// 	var ids = res.type_data[0].id;
					// 	if (res.wallet_data && res.wallet_data.length > 0) {
					// 		res.wallet_data.forEach(item => {
					// 			if (ids == item.currency) {
					// 				this.labelText = item.label;
					// 			}
					// 		});
					// 	}
					// } else {
					// 	this.contractAddress = res.contract_address;
					// 	this.name = res.type;
					// 	this.coinInfo = res;
					// 	if (res.wallet_data && res.wallet_data.length > 0) {
					// 		this.labelText = res.wallet_data[0].label;
					// 	}
					// }
					this.getUserInfo();
				});
			},
			getUserInfo() {
				this.$utils.initDataToken({
					url: 'user/info'
				}, res => {
					this.userId = res.id;
					// this.getAddress(res.id);
				});
			},
			// 选择充币类型
			selectCharge(options) {
				var that = this;
				this.img = '';
				this.coinInfo = options;
				this.name = options.chain_protocol.code;
				this.labelText = options.memo;
				this.address = options.address;
				this.creatQrcode();
				// that.contractAddress = options.contract_address;
				// that.name = options.type;
				// that.coinInfo = options;
				// var ids = options.id;
				// if (that.walletData.length > 0) {
				// 	that.walletData.forEach(item => {
				// 		if (ids == item.currency) {
				// 			that.labelText = item.label;
				// 		}
				// 	});
				// }
				// that.getAddress(that.userId);
			},
			getAddress(id) {
				this.$utils.getAddressOnline({
					url: 'walletMiddle/GetRechargeAddress',
					data: {
						user_id: id,
						coin_type: this.name,
						contract_address: this.contractAddress
					}
				}, res => {
					uni.stopPullDownRefresh();
					console.log(res);
					if (res.code == 0) {
						this.address = res.data.address;
						this.creatQrcode();
					}
				});
			},
			// 复制
			fuzhi_invite() {
				var that = this;


				// alert(1)
				// uni.setClipboardData({
				// 	data: that.address,
				// 	success: function() {
				// 		that.$utils.showLayer(that.$t('assets.copy_success'));
				// 	},
				// 	fail: function() {
				// 		that.$utils.showLayer(that.$t('assets.copy_err'));
				// 	}
				// });
				
			 if (!document.queryCommandSupported('copy')) {
			   // 不支持
			   that.$utils.showLayer(that.$t('assets.copy_err'));
			 }
			 
			 let textarea = document.createElement("textarea")
			 textarea.value = that.address
			 textarea.readOnly = "readOnly"
			 document.body.appendChild(textarea)
			 textarea.select() // 选择对象
			 textarea.setSelectionRange(0, that.address.length) //核心
			 let result = document.execCommand("copy") // 执行浏览器复制命令
			 textarea.remove()
			 that.$utils.showLayer(that.$t('assets.copy_success'));
			},
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
			creatQrcode() {
				if (this.address == '') {
					return false;
				}
				let img = QR.createQrCodeImg(this.address);
				this.img = img;
			}
		}
	};
</script>

<style>
	.active {
		color: #007aff;
		border-color: #007aff;
	}
</style>
