<template>
  <view :class="theme">
	  <view class="bg-my-grey dark:bg-1C2532 text-black dark:text-white" style="min-height: 100vh;">
		  <view class="p-40 flex justify-between">
			<image src="../../static/image/wewe.png" mode="widthFix"  class="w-80 h-80"></image>
		  <!-- <view class="blue">登录demo</view> -->
			<view class="relative mt-20">
				<view class="flex items-center" @tap="showRight = true">
				  <text>{{ languages[lang].name }}</text>
				  <image :src="languages[lang].img" class="w-30 h-24 ml-20"></image>
				</view>
				<view class="absolute top-60 right-0 z-10 bg-gray-600 px-20 rounded-10" v-show="isshowlang">
				  <view class="text-white flex items-center py-20 justify-between border-0 border-b-2 border-solid border-gray-700 langs" v-for="(item, i) in languages" :key="i" @tap="changeLang(i)">
					<text>{{ item.name }}</text>
					<image :src="item.img" class="w-30 h-24 ml-20"></image>
				  </view>
				</view>
			 </view>
		</view>
		
		<view class="p-40">
			<view class="flex items-start justify-between">
				<view class="flex items-center">
				<view class="flex flex-col justify-center items-center mr-20" :class="{ 'text-new-blue': loginActive == 0 }" @tap="loginActive = 0">
					  <view class="mb-30 text-xl">{{$t('login').l_mobile}}</view>
					  <view class="w-60 h-4 bg-new-blue" v-if="loginActive == 0"></view>
				</view>		
				<view class="flex flex-col justify-center items-center" :class="{ 'text-new-blue': loginActive == 1 }" @tap="loginActive = 1">
					<view class="mb-30 text-xl">{{ $t("login").l_email }}</view>
					<view class="w-60 h-4 bg-new-blue" v-if="loginActive == 1"></view>
				</view>
			</view>
			<navigator url="/pages/home/chat">
			<image class="w-60 h-60" :src="`/static/image/kefu.png`"></image>
			</navigator>
			</view>
			
			<view class="py-40">
				<view class="flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
					<view class="flex items-center justify-between mr-20" v-if="loginActive == 0">
					<picker :value="index" :range="array" class="flex-1" @change="bindPickerChange" range-key="code">
					  <!-- <view class="uni-input">{{array[index].name_cn}}</view> -->
					  <view class="text-lg" v-if="array[index]" >{{ array[index].global_code }}</view>
					</picker>
					<image src="/static/image/trade_arrow_down.png" class="w-10 h-16 ml-10"></image>
				  </view>
				  <view class="flex items-center flex1">
					<input type="text" v-model="user_string" class="h-100 flex-1" v-if="loginActive == 1" :placeholder="$t('login').p_email" />
					<input type="text" v-model="user_string" class="h-100 flex-1" v-else :placeholder="$t('login').p_mobile" />
				  </view>
				</view>
				<view class="mb-20">
				  <view class="flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
					<input type="text" password="" v-model="password" @input="passwordInput" class="h-100 flex-1" :placeholder="$t('login').p_pwd" />
					<image :src="`/static/image/${theme=='dark'?'password.png':'password_gray.png'}`" class="w-30 h-30 mx-20"></image>
				  </view>
				  <!-- <view class="ft10 pt5 chengse" v-if="verifyPwd">密码输入不正确</view> -->
				</view>
				<view class="flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700 mb-20" v-if="isShowCode">
				  <input type="text" v-model="code" class="h-100 flex-1" :placeholder="$t('login').p_vcode"/>
				  <view class="ml-20 p-20 bg-primary rounded-8" @tap="getCode">
					<text v-if="!hasSend">{{ $t("login").get_code }}</text>
					<text v-else>{{ second }}s</text>
				  </view>
				</view>
				<view class="mt-30 flex items-center justify-between">
					<view class="">
						<checkbox value="cb" :checked="isRemember" @tap="tapChecked" style="transform: scale(0.7); color: '#1881d2'" />
						<text>{{ $t("login").rem_pwd }}</text>
					</view>
					<!-- <navigator url="forgetPwd" class="text-blue-500">{{$t("login").forget_pwd}}</navigator> -->
				</view>
				<view class="my-60 bg-new-blue rounded-10 p-20 text-white text-lg text-center" @tap="login" hover-class="opacity-50">{{ $t("login").login }}</view>
				<view class="my-60 bg-new-blue rounded-10 p-20 text-white text-lg text-center mt-30" @tap="toWallet" hover-class="opacity-50">{{ $t("wallet.login") }}</view>
			</view>
			  <view class="flex items-center justify-center">
				<view class="flex items-center">
				  <text>{{ $t("login").noaccount }}</text>
				  <navigator url="register" class="text-new-blue">{{$t("login").register}}</navigator>
				</view>
				<!-- <navigator url="forgetPwd" class="blue2">{{$t("login").forget_pwd}}</navigator> -->
			  </view>
		</view>
	  </view>

	  <uni-drawer :visible="showRight" style="background: rgb(16, 32, 48,.5);" mode="right" @close="showRight = false">
		<view class="flex column ht100">
			<view class="flex items-center p-40 border-0 border-b-2 border-solid border-gray-100 dark:border-gray-900 justify-between"
			v-for="(item, i) in languages" :key="i" @tap="changeLang(i)">
			<text class="">{{ item.name }}</text>
			<image :src="item.img" class="w-40 h-24 ml-10"></image>
			</view>
		</view>
	</uni-drawer>
	  
	  <tab-bar></tab-bar>
  </view>
</template>

<script>
	import uniDrawer from '@/components/uni-drawer.vue';
	import tabBar from '@/components/tab-bar/tab-bar.vue'
	import country from '@/common/country.js'
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				showRight:false,
				loginActive:1,
				user_string:'',
				password:'',
				re_password:'',
				code:'',
				array: [],
				index: 0,
				area_code:'',
				hasSend:false,
				second:60,
				isRemember:false,
				verifyPwd:false,
				isShowCode:false,
				timeInterval:'',
				lang:'',
				isshowlang: false,
				languages: {
				// zh: { name: '中文', img: '/static/image/zh.png' },
				en: { name: 'English', img: '/static/image/en.png' },
				jp: { name: '日本語', img: '/static/image/jp.png' },
				// kr: { name: '한국어', img: '/static/image/kr.png' },
				vn: { name: 'Tiếng Việt', img: '/static/image/vn.png' },
				th: { name: 'ไทย', img: '/static/image/th.png' },
				// ru: { name: 'Русский язык', img: '/static/image/ru.png' },
				fr: { name: 'français', img: '/static/image/fr.png' },
			    de: { name: 'Deutsche', img: '/static/image/de.png' },
				tr: { name: 'Türkçe', img: '/static/image/tr.png' },
				it: { name: 'Italiano', img: '/static/image/it.png' },
				spa: { name: 'Español', img: '/static/image/spa.png' },
				// ar: { name: 'عربي', img: '/static/image/ar.png' },
				// de: { name: 'Deutsche', img: '/static/image/de.png' },
				// it: { name: 'Italiano', img: '/static/image/it.png' },
				// fr: { name: 'français', img: '/static/image/fr.png' },
				hk: { name: '繁體中文', img: '/static/image/hk.png' },
					},
			}
		},
		computed:{
			...mapState(['theme']),
		},
		components: {
			uniDrawer,
			tabBar
		},
		onLoad(e) {
			
			uni.setNavigationBarTitle({
				title:this.$t('login').login
			})
			this.getCountry();
			if(uni.getStorageSync('isRemember')==0){
				this.isRemember=false;
			}else{
				this.isRemember=true;
				this.user_string= uni.getStorageSync('userString');
				this.password=uni.getStorageSync('userPwd');
			}
			this.lang=uni.getStorageSync('lang')||e.lang||'en';
			if(this.lang=='zh'){
				this.lang='en'
			}
			console.log(this.lang)
			this.$utils.initData({url:'default/setting',data:{key:'login_use_sms'}},(res)=>{
				this.isShowCode = res==1 ? true :false;
				uni.setStorageSync('smcode',this.isShowCode);
			})
			// this.$utils.getGlobalSettting({url:'env.json'},res=>{
			// 	console.log(res);
			// 	uni.setStorageSync('socketPort',res.socket_io_port)
			// 	uni.setStorageSync('smcode',res.login_need_smscode)
			// 	this.isShowCode=res.login_need_smscode;
			// })
		},
		onShow() {
			this.$utils.setThemeTop(this.theme)
		},
		methods:{
			toWallet(){
			if(!window.ethereum){
				uni.navigateTo({
					url:'/pages/mine/wallet'
				})
			}else{
				ethereum.request({ method: 'eth_requestAccounts' }).then(response => {
                    const accounts = response
                    console.log(`User's address is ${accounts[0]}`)
					if(!accounts[0]){
						uni.navigateTo({
							url:'/pages/mine/wallet'
						})
					}else{
						this.$utils.initData({url:'user/login_for_wallet',data:{
							w_address:accounts[0]
						},type:'POST'},(res,msg)=>{
							uni.setStorageSync('token',res);
							uni.setStorageSync('walletAddress',accounts[0]);
							uni.setStorageSync('walletLogin',true);
							uni.reLaunch({
								url:'/pages/home/home'
							})
						})
					}
                    // this.address = accounts[0]

                    // Optionally, have the default account set for web3.js
                    // web3.eth.defaultAccount = accounts[0]
                })
			}
			
		},
					// 语言切换
		changeLang(lang) {
			// this.$utils.initData({ url: 'lang/set', data: { lang }, type: 'POST' }, res => {
				console.log(lang);
				this.lang = lang;
				uni.setStorageSync('lang', lang);
				if(lang=='hk'){
					uni.setLocale('zh-Hant')
				}else{
					uni.setLocale('en')
				}
				this.$i18n.locale = lang;
				// this.isshowlang = !this.isshowlang;
				this.showRight = false;
			// });
		},
			//获取国家列表
			getCountry(){
				this.$utils.initData({url:'default/area_list'},(res,msg)=>{
					console.log(res[0],222)
					res.sort(function (s1, s2) {
						const x1 = s1.code.toUpperCase();
						const x2 = s2.code.toUpperCase();
						if (x1 < x2) {
							return -1;
						}
						if (x1 > x2) {
							return 1;
						}
						return 0;
					}); 
					res.map((item)=>{
						item.code = `${item.code}(+${item.global_code})`
					})
					this.array = res;
					this.area_code = 4;
					this.index = res.findIndex((item)=>item.id == 4) || 0
				})
			},
			// 区号选择
			bindPickerChange(e){
				this.index=e.target.value;
				let item=this.array[this.index];
				this.area_code=item.id;
			},
			// 获取验证码
			getCode(){
				if(this.timeInterval) return;
				if(this.loginActive==0){
					if(!this.user_string){
						return this.$utils.showLayer(this.$t('login').p_taccount)
					}
					this.$utils.initData({url:'sms_send',type:'POST',data:{user_string:this.user_string,type:5,country_code:this.area_code,lang:this.lang}},(res,msg)=>{
						this.$utils.showLayer(msg);
						this.hasSend=true;
						this.timeInterval=setInterval(()=>{
							if(this.second>=1){
								this.second--;
							}else{
								this.hasSend=false
								clearInterval(this.timeInterval);
							}
						},1000)
					})
				}else{
					if(!this.$utils.checkEmail(this.user_string)){
						return this.$utils.showLayer(this.$t('login').p_email)
					}
					this.$utils.initData({url:'sms_mail',type:'POST',data:{user_string:this.user_string,type:5,lang:this.lang}},(res,msg)=>{
						this.$utils.showLayer(msg);
						this.hasSend=true;
						this.timeInterval=setInterval(()=>{
							if(this.second>=1){
								this.second--;
							}else{
								this.hasSend=false
								clearInterval(this.timeInterval);
							}
						},1000)
					})
				}
			},
			// 是否选中记住密码
			tapChecked(){
				this.isRemember=!this.isRemember;
				if(this.isRemember){
					uni.setStorageSync('isRemember',1)
				}else{
					uni.setStorageSync('isRemember',0)
				}
			},
			// 密码框输入判断提示
			passwordInput(e){
				this.hasSend=false;
				if(e.target.value.length<6){
					this.verifyPwd=true;
				}else{
					this.verifyPwd=false;
				}
			},
			login(){
				if(this.loginActive==1){
					// 邮箱登录
					if(!this.$utils.checkEmail(this.user_string)){
						return this.$utils.showLayer(this.$t('login').p_temail)
					}
				}else{
					if(!this.user_string){
						return this.$utils.showLayer(this.$t('login').p_taccount)
					}
				}
				
				let login_type = this.loginActive == 0? 'mobile' :'email';
				if(!this.password){
					return this.$utils.showLayer(this.$t('login').p_pwd)
				}
				if(this.password.length<6){
					return this.$utils.showLayer(this.$t('login').p_pwderr)
				}
				if(this.isShowCode&& !this.code){
					return this.$utils.showLayer(this.$t('login').p_vcode)
				}
				var data={
					account: this.loginActive == 0?`${this.array[this.index].global_code}${this.user_string}`: this.user_string,
                    password: this.password,
					sms_code: this.code,
					lang:this.lang,
					login_type:login_type
				}
				// if(this.loginActive==0){
					// 手机登录
					data.country_code=this.area_code;
				// }
				this.$utils.initData({url:'user/login',data,type:'POST'},(res,msg)=>{
					uni.setStorageSync('token',res);
					uni.setStorageSync('accountNumber',this.user_string);
					uni.setStorageSync('codeId',this.area_code);
					if(this.isRemember){
						uni.setStorageSync('userString',this.user_string);
						uni.setStorageSync('userPwd',this.password);
					}
					uni.setStorageSync('walletLogin',false);
					setTimeout(() => {
						uni.reLaunch({
							url:'/pages/home/home'
						})
					}, 1500);
				})
			},
			
		}
	}
</script>