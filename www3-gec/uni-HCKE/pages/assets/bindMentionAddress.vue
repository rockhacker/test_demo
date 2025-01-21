<template>
	<view :class="theme">
		<view class="">
			<!-- <view class="flex items-center mb-40" v-if="coinList[index]">
				<picker class="bd_input ptb10 plr10 tc flex1 radius4" :value="index" :range="coinList" @change="pickChange" range-key="code">
					<view class="flex justify-between">
						<text>{{ $t('bind.cur_select') }}</text>
						<text v-if="coinList[index]">{{ coinList[index].code }}</text>
					</view>
				</picker>
			</view> -->
			<view class="px-30 py-20">
				<view class="font-bold text-lg mb-30">{{ $t('bind.cur_select') }}</view>
				<scroll-view scroll-x class="w-full whitespace-nowrap" :show-scrollbar="false">
					<view class="rounded-base px-20 py-10 mr-40 flex-col justify-center items-center text-lg inline-flex border-2 border-solid border-gray-200 dark:border-gray-700" hover-class="opacity-50"
						:class="{'bg-my-orange border-my-orange text-white':index==i}" v-for="(item,i) in coinList" :key="i" 
						@click="pickChange({target:{value:i}})">
						{{item.code}}
					</view>
				</scroll-view>
			</view>
			<view class="px-30 py-20">
				<view v-if="coinList.length&&coinList[index].currency_protocols">
					<view v-if="coinList[index].currency_protocols.length > 1">
						<view class="font-bold text-lg mb-30">{{ $t('bind.liantype') }}</view>
						<view class="flex mb-30">
							<view v-for="(item, index) in coinList[index].currency_protocols" :key="index" 
								class="rounded-base text-lg mr-20 py-10 px-20  border-2 border-solid border-gray-200 dark:border-gray-700" :class="{'text-white border-primary dark:border-primary': name == item.chain_protocol.code}"
								@tap="selectCharge(item)">
								{{ item.chain_protocol.code }}
							</view>
						</view>
					</view>
				</view>
				<view class="flex items-center">
					<text>{{ $t('bind.addr') }}：</text>
					<input type="text" value="" v-model="address" class="flex1 plr15 h40 bdb1f" :placeholder="$t('bind.p_addr')" />
				</view>
				<view class="mt-100 mb-60 bg-primary rounded-3xl p-20 text-white text-lg text-center" @tap="bindAddress" hover-class="opacity-50">{{ $t('bind.bind') }}</view>
			</view>
			<!-- 验证码 -->
			<!-- <view class="flex items-center">
				<text>{{ $t('bind.code') }} ：</text>
				<view class="bdb1f flex items-center flex1">
					<input type="text" value="" class="flex1 plr15 h40 " v-model="code" :placeholder="$t('login.p_vcode')" />
					<view class="ml10 plr10 white bgBlue ptb5 radius4" @tap="getCode">
						<text v-if="!hasSend">{{ $t('login.r_send') }}</text>
						<text v-else>{{ second }}s</text>
					</view>
				</view>
			</view> -->
		</view>
	</view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	data() {
		return {
			index: 0,
			coinList: [],
			uerid: '',
			hasSend: false,
			timeInterval: '',
			address: '',
			code: '',
			second: 60,
			name: '',
			coinType: [],
			currencyName: '',
			contractAddress: '',
			multiProtocol: 0,
			currencyProtocolsId: '',
			currencyId: '',
			incode:'',
			option:''
		};
	},
	onLoad(e) {
		this.incode=e.code
		this.option=e.options
		this.getCoinList();
		uni.setNavigationBarTitle({
			title: this.$t('bind').bindAddr
		});
	},
	computed: {
		...mapState(['theme'])
	},
	onShow() {
		this.$utils.setThemeTop(this.theme);
	},
	methods: {
		pickChange(e) {
			console.log( e.target.value);
			var that = this;
			var lists = that.coinList;
			that.index = e.target.value;
			that.address = '';
			that.code = '';
			that.hasSend = false;
			that.second = 60;
			lists.forEach((item, index) => {
				if (item.id == that.coinList[that.index].id) {
					if (item.currency_protocols.length > 1) {
						that.multiProtocol = 1;
					}
				}
			});
			let index=0;
			for(let i=0;i<that.coinList[that.index].currency_protocols.length;i++){
                    if(that.coinList[that.index].currency_protocols[i].chain_protocol.code==this.option){
						index=i
					}
			}
			if (that.multiProtocol == 1) {
				that.name = that.coinList[that.index].currency_protocols[index].chain_protocol.code;
				that.currencyName = that.coinList[that.index].code;
				that.contractAddress = that.coinList[that.index].currency_protocols[index].token_address;

			} else {
				if(that.coinList[that.index].currency_protocols.length >0){
					that.name = that.coinList[that.index].currency_protocols[index].chain_protocol.code;
					that.currencyName = that.coinList[that.index].code;
				}else{
					that.name = '';
					that.currencyName = that.coinList[that.index].code;
					that.contractAddress = '';	
				}
				
			}
			that.currencyProtocolsId = that.coinList[that.index].currency_protocols[index].id;
			
			that.currencyId = that.coinList[that.index].id;

			that.getAddress();
		},
		getCoinList() {
			var that = this;
			that.$utils.initDataToken({ url: 'block_chain/currency_protocols' }, res => {
				that.coinList = res;
				that.currencyId = res[0].id;
				that.currencyProtocolsId = res[0].currency_protocols[0].id;

				if (res[0].currency_protocols&&res[0].currency_protocols.length>1) {
					// that.getType(res.accounts[0].currency_id);
					that.name = res[0].currency_protocols[0].chain_protocol.code;
					that.currencyName = res[0].code;
					that.contractAddress = res[0].currency_protocols[0].token_address;
					console.log(1111111111)
					that.getUserInfo();
				} else {
					if(res[0].currency_protocols&&res[0].currency_protocols.length>0){
						that.name = res[0].currency_protocols[0].chain_protocol.code;
						that.currencyName = res[0].code;
						// that.contractAddress = res.accounts[0].contract_address;
					}else{
						that.name = '';
						that.currencyName = res[0].code;
						// that.contractAddress = res.accounts[0].contract_address;
					}
					console.log(22222222)
					that.getUserInfo();
				}
				for(let i=0;i<res.length;i++){
					if(res[i].code==that.incode){
						console.log(i)
						let obj={
							target:{
								value:i
							}
						}
						that.pickChange(obj)
					}
				}
			});
		},
		getUserInfo() {
			this.$utils.initDataToken({ url: 'user/info' }, res => {
				this.uerid = res.id;
				this.getAddress();
			});
		},
		// 获取链类型
		getType(currency) {
			var that = this;
			that.coinType = [];
			this.$utils.initDataToken(
				{
					url: 'wallet/get_info',
					type: 'POST',
					data: {
						currency: currency
					}
				},
				res => {
					console.log(res);
					that.coinType = res.type_data;
					that.name = res.type_data[0].type;
					that.currencyName = res.type_data[0].name;
					that.contractAddress = res.type_data[0].contract_address;
					that.getAddress();
				}
			);
		},
		// 选择充币类型
		selectCharge(options) {
			console.log(options);
			var that = this;
			that.code = '';
			that.hasSend = false;
			that.second = 60;
			that.contractAddress = options.token_address;
			that.name = options.chain_protocol.code;
			that.currencyType = options.chain_protocol.code;
			that.currencyName = options.code;
			that.currencyProtocolsId = options.id;
			that.currencyId = options.currency_id;
			that.getAddress();
		},
		getAddress() {
			console.log(this.name)
			this.address = '';
			this.$utils.getAddressOnline(
				{
					url: 'GetDrawAddress',
					data: {
						user_id: this.uerid,
						coin_name: this.name,
						contract_address: this.contractAddress,
						currency_id: this.currencyId,
						currency_protocol_id: this.currencyProtocolsId
					}
				},
				res => {
					console.log(res);
					console.log('hhhhhhhhhhh---' + res.data.address)
					if (res.code == 1) {
						console.log(res.data.address);
						this.address = res.data.address;
					}
				}
			);
		},
		// 获取验证码
		getCode() {
			if (this.timeInterval) return;
			this.$utils.getAddressOnline({ url: 'SendVerificationcode', data: { user_id: this.uerid } }, res => {
				console.log(res);
				if (res.code == 1) {
					this.$utils.showLayer(this.$t('bind.sendSuccess'));
					this.hasSend = true;
					this.timeInterval = setInterval(() => {
						if (this.second >= 1) {
							this.second--;
						} else {
							this.hasSend = false;
							clearInterval(this.timeInterval);
						}
					}, 1000);
				} else {
					// if(res.errorinfo=='不能重复发送验证码'){
					// 	this.$utils.showLayer('Cannot send verification code repeatedly')
					// }
					this.$utils.showLayer(res.errorinfo);
				}
			});
		},
		bindAddress() {
			if (!this.address) {
				return this.$utils.showLayer(this.$t('bind.p_addr'));
			}
			// if (!this.code) {
			// 	return this.$utils.showLayer(this.$t('login.p_vcode'));
			// }

			var obj = {
				user_id: this.uerid,
				address: this.address,
				coin_name: this.name,
				contract_address: this.contractAddress,
				verificationcode: this.code,
				t: Date.parse(new Date()) / 1000,
				currency_id: this.currencyId,
				currency_protocol_id: this.currencyProtocolsId
			};
			// var obj = {
			// 	user_id:2,
			// 	address:'BANG btc',
			// 	coin_name:'BTC',
			// 	contract_address:'',
			// 	verificationcode:'738646',
			// 	t:1566373963,
			// };
			var obj_str = JSON.stringify(obj);
			console.log(obj_str);
			console.log(this.$MD5(obj_str));
			// console.log(this.$MD5('{"user_id":2,"address":"BANG btc","coin_name":"BTC","contract_address":"","verificationcode":"738646","t":1566373963}'))
			var sign = this.$MD5(obj_str + 'abcd4321');
			console.log(sign);
			this.$utils.getAddressOnline({ url: 'BindDrawAddress', data: { data: obj_str, sign }, type: 'POST' }, res => {
				console.log(res);
				if (res.code == 1) {
					// 成功
					this.$utils.showLayer(this.$t('bind.bindOk'));
					uni.navigateBack({
						delta: 1
					});
				} else {
					this.$utils.showLayer(res.errorinfo);
				}
			});
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
