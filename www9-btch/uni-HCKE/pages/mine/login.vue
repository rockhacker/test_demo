<template>
  <view :class="theme">
	  <view class="bg-my-grey dark:bg-1C2532 text-black dark:text-white" style="min-height: 100vh;">
		  <view class=" flex justify-between items-center">
			<image src="../../static/image/wewe.png" mode="widthFix" class="w-120 h-120"></image>
		  <!-- <view class="blue">登录demo</view> -->
			<view class="relative mr-40">
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
			<view class="flex items-center">
				<!-- <view class="flex flex-col justify-center items-center mr-20" :class="{ 'text-primary': loginActive == 2 }" @tap="loginActive = 2">
					<view class="mb-30 text-xl">{{ $t('add.login_yhm') }}</view>
					<view class="w-60 h-4 bg-primary" v-if="loginActive == 2"></view>
				</view> -->
				<view class="flex flex-col justify-center items-center mr-20" :class="{ 'text-primary': loginActive == 0 }" @tap="loginActive = 0">
					  <view class="mb-30 text-xl">{{$t('login').l_mobile}}</view>
					  <view class="w-60 h-4 bg-primary" v-if="loginActive == 0"></view>
				</view>		
				<view class="flex flex-col justify-center items-center mr-20" :class="{ 'text-primary': loginActive == 1 }" @tap="loginActive = 1">
					<view class="mb-30 text-xl">{{ $t("login").l_email }}</view>
					<view class="w-60 h-4 bg-primary" v-if="loginActive == 1"></view>
				</view>
				
			</view>
			
			<view class="py-40">
				<view class="flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
				  <!-- <view class="flex items-center justify-between mr-20" v-if="loginActive == 0">
					<picker :value="index" :range="array" class="flex-1" @change="bindPickerChange" range-key="trans_name">
					
					  <view class="text-lg" v-if="array[index]" >{{ array[index].trans_name }}+{{ array[index].global_code }}</view>
					</picker>
					<image src="/static/image/trade_arrow_down.png" class="w-10 h-16 ml-10"></image>
				  </view> -->
				  <view class="flex items-center flex1">
					<view class="flex  alcenter between mr10" v-if="loginActive==0" @click="showpopup">
								<view>+{{item.global_code}}</view>
								<image src="/static/image/trade_arrow_down.png" class="wt10 h8 ml5"></image>
					</view>
					<input type="text" v-model="user_string" class="h-100 flex-1" v-if="loginActive == 1" :placeholder="$t('login').p_email" />
					<input type="text" v-model="user_string" class="h-100 flex-1" v-else-if="loginActive == 2" :placeholder="$t('add.playhm')" />
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
				<view class="my-60 bg-main-linear rounded-10 p-20 text-white text-lg text-center" @tap="login" hover-class="opacity-50">{{ $t("login").login }}</view>
				<view class="my-60 bg-main-linear rounded-10 p-20 text-white text-lg text-center mt-30" @tap="toWallet" hover-class="opacity-50">{{ $t("wallet.login") }}</view>
			</view>
			  <view class="flex items-center justify-center">
				<view class="flex items-center">
				  <text>{{ $t("login").noaccount }}</text>
				  <navigator url="register" class="text-clip-green">{{$t("login").register}}</navigator>
				</view>
				
				<!-- <navigator url="forgetPwd" class="blue2">{{$t("login").forget_pwd}}</navigator> -->
				
			  </view>
			  <view class="flex items-center justify-center mt30">{{$t('about.concat')}}:info@TESTus.com</view>
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
	  <uni-popup ref="popup" background-color="#fff" @change="change">
			<view class="uni-padding-wrap">
				  <view class="ft14 text-black" @click="cancel">{{$t('trade.cancel')}}</view>
				  <view>
					 <input @input="oninput" type="text" v-model="search" class="tc h40 lh40  text-black flex1 search"  :placeholder="$t('add.qh_ss')">
				  </view>
				  <view class="ft14 text-black" @click="sub">{{$t('login.e_confrim')}}</view>
			</view>
			<picker-view :indicator-style="indicatorStyle" :value="value" @change="bindChange" class="picker-view">
				<picker-view-column>
					<view class="item text-black" v-for="(item,index) in searchArray" :key="index">{{item.trans_name}}+({{item.global_code}})</view>
				</picker-view-column>
			</picker-view>
		</uni-popup>
  </view>
</template>

<script>
	import uniDrawer from '@/components/uni-drawer.vue';
	import tabBar from '@/components/tab-bar/tab-bar.vue'
	import country from '@/common/country.js'
	import {mapState} from 'vuex'
	import steps from '@/components/step.vue';
	export default{
		data(){
			return {
				indicatorStyle: `height: 50px;`,
				value:[0],
				search:'',
				searchArray:[],
				codeIndex:0,
				item:{},
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
			
				en: { name: 'English', img: '/static/image/en.png' },
				jp: { name: '日本語', img: '/static/image/jp.png' },
				kr: { name: '한국어', img: '/static/image/kr.png' },
				vn: { name: 'Tiếng Việt', img: '/static/image/vn.png' },
				th: { name: 'ไทย', img: '/static/image/th.png' },
				// ar: { name: 'عربي', img: '/static/image/ar.png' },
				// de: { name: 'Deutsche', img: '/static/image/de.png' },
				// it: { name: 'Italiano', img: '/static/image/it.png' },
				// fr: { name: 'français', img: '/static/image/fr.png' },
			//	ru: { name: 'Русский язык', img: '/static/image/ru.png' },
				fr: { name: 'français', img: '/static/image/fr.png' },
			    de: { name: 'Deutsche', img: '/static/image/de.png' },
				tr: { name: 'Türkçe', img: '/static/image/tr.png' },
				it: { name: 'Italiano', img: '/static/image/it.png' },
				spa: { name: 'Español', img: '/static/image/spa.png' },

				hk: { name: '繁體中文', img: '/static/image/hk.png' },
				zh: { name: '简体中文', img: '/static/image/zh.png' },
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
			// if(this.lang=='zh'){
			// 	this.lang='en'
			// }
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
					url:'/pages/mine/wallet1'
				})
			}else{
				ethereum.request({ method: 'eth_requestAccounts' }).then(response => {
                    const accounts = response
                    console.log(`User's address is ${accounts[0]}`)
					if(!accounts[0]){
						uni.navigateTo({
							url:'/pages/mine/wallet1'
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
			cancel(){
				this.search= ''
				this.codeIndex = 0
				this.searchArray = this.array
				this.$refs.popup.close()
			},
			sub(){
				this.item = this.searchArray[this.codeIndex]
				this.area_code= this.item.id;
				this.search= ''
				this.codeIndex = 0
				this.searchArray = this.array
				this.$refs.popup.close()
			},
			oninput(e){
			 let val = e.detail.value
			 this.searchArray = this.array.filter((item)=>{
				if(item.global_code.search(val) != -1 || item.trans_name.search(val) != -1){
                    return item
				}
			 })
			},
			bindChange(e){
              this.codeIndex = e.detail.value[0]
			},
			change(){},
			showpopup(){
				this.$refs.popup.open('bottom')
			},
					// 语言切换
		changeLang(lang) {
			// this.$utils.initData({ url: 'lang/set', data: { lang }, type: 'POST' }, res => {
				console.log(lang);
				this.lang = lang;
				uni.setStorageSync('lang', lang);
				this.$i18n.locale = lang;
				if(lang=='hk'){
					uni.setLocale('zh-Hant')
				}else{
					uni.setLocale('en')
				}
				this.getCountry()
				// this.isshowlang = !this.isshowlang;
				this.showRight = false;
			// });
		},
			//获取国家列表
			getCountry(){
				this.$utils.initData({url:'default/area_list'},(res,msg)=>{
					// console.log(res)
					this.array = res;
					this.searchArray = res
					this.area_code = res[0].id;
					this.item = res[0]
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
				}else if(this.loginActive==2){
					if(!this.$utils.checkUser(this.user_string)){
						return this.$utils.showLayer(this.$t('add').plauser)
					}
				}else{
					if(!this.user_string){
						return this.$utils.showLayer(this.$t('login').p_taccount)
					}
				}
				
				let login_type = this.loginActive == 0? 'mobile' :this.loginActive == 2? 'account' :'email';
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
					account: this.user_string,
                    password: this.password,
					sms_code: this.code,
					lang:this.lang,
					login_type:login_type,
					area_id:this.area_code,
				}
				if(this.loginActive == 0){
					
					data.account = this.item.global_code + this.user_string
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
<style>
	.light{
		min-height: initial;
	}
	.picker-view {
		width: 750rpx;
		height: 600rpx;
		margin-top: 20rpx;
	}
	.item {
		line-height: 100rpx;
		text-align: center;
	}
	.uni-padding-wrap{
		display: flex;
		justify-content: space-between;
		padding-top:30rpx;
		align-items: center;
	}
	.search{
        background: #F5F5F5 !important;
		padding:20rpx;
		height: 60rpx;
	}
</style>
