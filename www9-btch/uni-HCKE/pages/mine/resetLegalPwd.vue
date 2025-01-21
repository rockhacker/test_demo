<template>
	<view class="min-h-screen"  :class="theme">
		<view class="bg-my-grey dark:bg-1C2532 p-40 min-h-screen">
			<!-- <view class="flex alcenter mt10">
				<image src="../../static/image/regi.png" class="wt15 h15"></image>
				<view class="chengse ft14">注册后不能修改</view>
			</view> -->
			<view class="my-50">
				<view class="flex items-center border-0 border-solid border-b-2 border-gray-200 dark:border-gray-700 ">
					<input type="text" password="" v-model="password" @input="passwordInput1" class="h-100 flex-1" :placeholder="$t('login').e_pdeal" />
					<image :src="`/static/image/${theme=='dark'?'password.png':'password_gray.png'}`" class="w-30 h-30 mx-20"></image>
				</view>
				<view class="text-sm pt-10 text-danger" v-if="verifyPwd1">{{ $t('login').p_len }}</view>
				<view class="flex items-center border-0 border-solid border-b-2 border-gray-200 dark:border-gray-700 ">
					<input type="text" password="" v-model="re_password" @input="passwordInput2" class="h-100 flex-1" :placeholder="$t('login').e_pdealConfrim" />
					<image :src="`/static/image/${theme=='dark'?'password.png':'password_gray.png'}`" class="w-30 h-30 mx-20"></image>
				</view>
				<view class="text-sm pt-10 text-danger" v-if="verifyPwd2">{{ $t('login').p_notsame }}</view>
			</view>
			<view class="mb-40 mt20" v-if="!isReg == 1 && obj.is_set_pay_password">
					<uni-data-checkbox @change="change" selectedColor="#48D2B9" v-model="sex" :localdata="sexs" />
					<view class="flex w-full items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700 mb-20">
						<input type="text" v-model="code" class="h-100 flex-1" :placeholder="$t('login').p_vcode"/>
						<button v-if="verify_type!='google_secret'" size="mini" type="primary" class="px-40 bg-main-linear text-white"  :disabled="disable" :loading="load" @click="send">{{ codeText }}</button>
					</view>	
					<!-- <input type="text" password="" class="border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700 h-80 w-full" v-model="password" :placeholder="$t('login.e_pdeal')" /> -->
				</view>
			<!-- <view class="mb10"> -->
			<!-- {{ $t('login').fixedemail1 }} <text class="blue2 plr10">support@379maq.com</text> {{ $t('login').fixedemail2 }} -->
			<!-- </view> -->
			
			
			<!-- 验证码 -->
			<!-- <view class="flex bgwhite alcenter bdb_myblue ">
				<input type="text" v-model="code" class="h40 lh40 flex1" :placeholder="$t('login').p_vcode" />
				<view>
					<button size="mini" type="primary" :disabled="disable" :loading="load" @click="send">{{ codeText }}</button>
				</view>
			</view> -->
			
			
			
			<!-- <view class="mt20 flex alcenter">
				<view class=" flex alcenter">
					<checkbox value="cb" :checked="isAgree"  @tap="tapChecked" style="transform:scale(0.7);color:'#1881d2'"/>
					<text>我同意</text>
				</view>
				<view class="ml10 blue2">《用户协议及隐私政策》</view>
			</view> -->
			<view class="mt-100 bg-main-linear rounded-10 p-20 text-white text-lg text-center" @tap="register" hover-class="opacity-50">{{ $t('login').e_confrim }}</view>
			<!-- <view v-if="isReg == 1" class="mt-20 h-80 flex justify-center items-center text-center bg-main-linear text-white text-lg rounded-10" @tap="toPath">{{ $t("add.tiaog") }}</view> -->
		</view>
	</view>
</template>

<script>
	import {
		mapState
	} from 'vuex';
	export default {
		data() {
			return {
				user_string: '',
				password: '',
				re_password: '',
			//	code: '',
				area_code: '',
				isAgree: false,
				invite_code: '',
				verifyPwd1: false,
				verifyPwd2: false,
				lang: '',
				disable: false,
				load: false,
				codeText: this.$t('login').r_send,
				accountNumber: '',
				codeId: '',
				isReg:0,
				verify_type:'',
				sexs: [{
					text: this.$t('add.sjyz'),
					value: 'mobile'
				}, {
					text: this.$t('add.yxyz'),
					value: 'email'
				}, {
					text: this.$t('add.ggyz'),
					value: 'google_secret'
				}],
				sex:0,
				codeText:this.$t('login.r_send'),
				code:'',
				info:{},
				obj:{}
			};
		},
		onLoad(e) {
			this.isReg = e.isReg
			// this.getUserInfo();
			this.user_string = e.user_string;
			this.code = e.code;
			this.is_mobile = this.is_mobile;
			this.area_code = this.areaCode;
			this.lang = uni.getStorageSync('lang');
			if(e.bool || e.isReg == 1){
				uni.setNavigationBarTitle({
					title:this.$t('new.sehz')+ this.$t('new.zij')
				});
			}else{
				uni.setNavigationBarTitle({
					title:this.$t('new.xiu')+  this.$t('new.zij')
				});
			}
			
		},
		computed: {
			...mapState(['theme'])
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
			this.accountNumber = uni.getStorageSync('accountNumber');
			this.codeId = uni.getStorageSync('codeId');
			this.verified_info()
			this.info = JSON.parse(uni.getStorageSync('info'));
		},
		methods: {
			verified_info(){
				this.$utils.initDataToken({url:'user/verified_info'},(res,msg)=>{
					this.obj  = res
				
				})
		},		
		change(e){
		    if(e.detail.value == 'mobile'){
                if(!this.obj.mobile_verified){
					this.$utils.showLayer(this.$t('add.bdsj'));
					
				}
			}
			if(e.detail.value == 'email'){
				if(!this.obj.email_verified){
					this.$utils.showLayer(this.$t('add.bdyx'));
					
				}
			}
			if(e.detail.value == 'google_secret'){
				if(!this.obj.google_secret_verified){
					this.$utils.showLayer(this.$t('add.bdgg'));
					
				}
			}
			this.verify_type = e.detail.value
		},
		send(){
			if(!this.sex){
					return this.$utils.showLayer(this.$t('add.quzyz'));
				}
				var datas = {
					to: '',
					//area_id: this.area_code,
					type: 5
				};
				var url;
			
				if(this.verify_type=='mobile'){
					url='notify/send_sms';
                    datas.to = this.info.mobile
				}else{
					url='notify/send_email';
					datas.to = this.info.email
				}
				this.$utils.initDataToken({ url: url, data: datas, type: 'post' }, (res, msg) => {
					this.$utils.showLayer(msg);
					this.disable = true;
					// this.load = true;
					var times = 60;
					var timer = setInterval(() => {
						times--;
						if (times < 10) {
							times = '0' + times;
						}
						this.codeText = times + 's';
						if (times <= 0) {
							clearInterval(timer);
							this.disable = false;
							this.load = false;
							this.codeText = this.$t('login.r_send');
						}
					}, 1000);
				},true);
			},
			toPath(){
				uni.switchTab({url: '/pages/home/home' })
			},
			//获取用户信息
			getUserInfo() {
				var that = this;
				this.$utils.initDataToken({
					url: 'user/info',
					data: {},
					type: 'get'
				}, (res, msg) => {
					that.accountNumber = res.account_number;
				});
			},
			//发送验证码
			// send() {
			// 	var reg = /^1[345678]\d{9}$/;
			// 	var emreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
			// 	var url = 'notify/send_sms';
			// 	if (emreg.test(this.accountNumber)) {
			// 		url = 'notify/send_email';
			// 	}
			// 	var datas = {
			// 		to: this.accountNumber,
			// 		area_id: this.codeId,
			// 		lang: this.lang,
			// 		type: 3
			// 	};
			// 	this.$utils.initDataToken({
			// 		url: url,
			// 		data: datas,
			// 		type: 'post'
			// 	}, (res, msg) => {
			// 		this.$utils.showLayer(msg);
			// 		this.disable = true;
			// 		// this.load = true;
			// 		var times = 60;
			// 		var timer = setInterval(() => {
			// 			times--;
			// 			if (times < 10) {
			// 				times = '0' + times;
			// 			}
			// 			this.codeText = times + 's';
			// 			if (times <= 0) {
			// 				clearInterval(timer);
			// 				this.disable = false;
			// 				this.load = false;
			// 				this.codeText = this.$t('login').r_send;
			// 			}
			// 		}, 1000);
			// 	});
			// },
			passwordInput1(e) {
				if (e.target.value.length < 6) {
					this.verifyPwd1 = true;
				} else {
					this.verifyPwd1 = false;
				}
			},
			passwordInput2(e) {
				if (e.target.value != this.password) {
					this.verifyPwd2 = true;
				} else {
					this.verifyPwd2 = false;
				}
			},
			tapChecked() {
				this.isAgree = !this.isAgree;
			},
			register() {
				var that = this;
				if (!this.password) {
					return this.$utils.showLayer(this.$t('login').e_pdeal);
				}
				if (this.password.length < 6) {
					return this.$utils.showLayer(this.$t('login').p_simple);
				}
				if (this.password != this.re_password) {
					return this.$utils.showLayer(this.$t('login').p_inputagain);
				}
				// if (!this.code) {
				// 	this.$utils.showLayer(this.$t('login').p_vcode);
				// 	return;
				// }
				var data = {
					password: this.password,
					secondary_password: this.re_password,
					//auth_code: this.code,
					verify_type:this.verify_type,
					code:this.code, 
				};
				this.$utils.initDataToken({
					url: 'user/amend_pay_password',
					data,
					type: 'POST'
				}, (res, msg) => {
					that.$utils.showLayer(msg);
					setTimeout(() => {
						if(that.isReg == 1){
							uni.navigateTo({
									url:'/pages/mine/real_authentication?isReg=1'
							})
						}else{
							uni.navigateBack({
								delta: 1
							});
						}
						
					}, 1000);
				});
			}
		}
	};
</script>