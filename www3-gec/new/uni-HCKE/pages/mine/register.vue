<template>
	<view class="bg-transparent" :class="theme">
		<uni-nav-bar backIcon>
			<view class="w-full text-center">
				<text style="font-size:36rpx;padding-right: 90rpx;">{{$t('login.register')}}</text>
			</view>
			<view class="absolute right-20 top-36">
				<view class="flex items-center" @tap="isshowlang = !isshowlang">
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
		</uni-nav-bar>

		<view class="plr20">
			<view class="mt30 ">
			<view class="ft24 bold" v-if="loginActive==0">
				{{$t('login').r_mobile}}
			</view>
			<view class="ft24 bold" v-else>
				{{$t('login').r_email}}
			</view>
			<view class="flex alcenter mt10">
				<image src="../../static/image/regi.png" class="wt15 h15"></image>
				<view class="chengse ft14">{{$t('login').r_noedit}}</view>
			</view>
			<view class="mt40 ">
				<view class="mb10  px-60">
					<!-- <view class="flex  alcenter between mr10" v-if="loginActive==1">
						<picker :value="index" :range="array" class=" flex1"  @change="bindPickerChange" range-key="code">
							<view class="uni-input">{{array[index].name_cn}}</view>
							<view class="ft12" v-if="array[index]">{{array[index].code}}{{array[index].global_code}}</view>
						</picker>
						<image src="/static/image/trade_arrow_down.png" class="wt10 h8 ml5"></image>
					</view> -->
					 <view class="flex items-center flex1 border-2 border-solid  px-20 mb-20  border-my-orange rounded-xl">
						 <div  v-if="loginActive == 1" class="mr-20">{{$t('login.e_email')}} :</div>
						 <div v-else class="mr-20">{{$t('login.e_mb')}} :</div>
						<input type="text"  v-model="user_string" class="h40 lh40  flex1" v-if="loginActive==1" :placeholder="$t('login').p_email">
						<input type="text" v-model="user_string" class="h40 lh40  flex1" v-else :placeholder="$t('login').p_mobile">
					</view>
					 <view class="flex items-center flex1 border-2 border-solid  px-20 mb-20  border-my-orange rounded-xl">
						 <div class="mr-20">{{$t('login.pwd')}}:</div>
						<input type="text" v-model="password" @input="passwordInput1" class="h-100 flex-1" v-if="showPassA == true"  :placeholder="$t('login').p_pwd"/>
						<input type="text" password="" v-model="password" @input="passwordInput1" class="h-100 flex-1" v-else  :placeholder="$t('login').p_pwd" />
						<image src="/static/image/a.png" class="w-40 h-40" v-if="showPassA == true" @click="showPassA=false"></image>
						<image src="/static/image/b.png" class="w-40 h-40" v-else @click="showPassA=true"></image>
					</view>
					<view class="ft10 mb-10 chengse" v-if="verifyPwd1">{{$t('login').p_len}}</view>
					<view class="flex items-center flex1 border-2 border-solid  px-20 mb-20  border-my-orange rounded-xl">
						 <div class="mr-20">{{$t('login.pwd')}}:</div>
						<!-- <input type="text" password="" v-model="re_password" @input="passwordInput2" class="h40 lh40 flex1" :placeholder="$t('login').p_confirmPwd"> -->
						<input type="text" v-model="re_password" @input="passwordInput2" class="h-100 flex-1" v-if="showPassB == true"  :placeholder="$t('login').p_confirmPwd"/>
						<input type="text" password="" v-model="re_password" @input="passwordInput2" class="h-100 flex-1" v-else  :placeholder="$t('login').p_confirmPwd" />
						<image src="/static/image/a.png" class="w-40 h-40" v-if="showPassB == true" @click="showPassB=false"></image>
						<image src="/static/image/b.png" class="w-40 h-40" v-else @click="showPassB=true"></image>
					</view>
					<view class="ft10 mb-10 chengse" v-if="verifyPwd2">{{$t('login').p_notsame}}</view>
					<view class="flex items-center flex1 border-2 border-solid  px-20 mb-20  border-my-orange rounded-xl">
						<input type="text" v-model="code" class="h40 lh40 flex1" :placeholder="$t('login').p_vcode" />
						<button size="mini" type="primary" class="px-40 bg-my-orange text-white"  :disabled="disable" :loading="load" @click="send">{{ codeText }}</button>
					</view>
					<view class="flex items-center flex1 border-2 border-solid  px-20  border-my-orange rounded-xl">
						<div class="mr-20">{{$t('login.p_invitecode')}}:</div>
						<input type="text" v-model="invite_code"  class="h40 lh40 flex1" :placeholder="$t('login').p_invitecode">
					</view>
					<!-- <view class="mt20 flex alcenter">
						<view class=" flex alcenter">
							<checkbox value="cb" :checked="isAgree"  @tap="tapChecked" style="transform:scale(0.7);color:'#1881d2'"/>
							<text>{{$t('login').p_agree}}</text>
						</view>
						<navigator :url="'/pages/home/agreement'">
							<view class="ml10 blue2">《{{$t('login').p_private}}》</view>
						</navigator>
					</view> -->
					<view class="mt-20 radius4 ptb10 ft14 tc mb10 bg-my-orange rounded-3xl text-white" @tap="register">{{$t('login.register')}}</view>
				</view>
			</view>
			<view class="mt20 flex between alcenter">
				<!-- <view class="text-primary" v-if="loginActive==1" @click="loginActive=0;user_string=''">
					{{$t('login.r_mobile')}}
				</view>
				<view class="text-primary" v-else @click="loginActive=1;user_string=''">
					{{$t('login.r_email')}}
				</view> -->
				<!-- #ifdef H5 -->
				<!-- <view class="text-primary" @tap="downLoad">
					{{$t('login.downApp')}}
				</view> -->
				<!-- #endif -->
			</view>
			<!-- #ifdef APP-PLUS -->
			<view class="mt45">
				<view class="flex alcenter">
					<text>{{$t('login').r_hasaccount}}?</text>
					<navigator url="login" class="text-primary">{{$t('login').login}}</navigator>
				</view>
			</view>
			<!-- #endif -->
			
		</view>
		<view class="fixed my_layer pos_l0b0 w100 ht100" v-if="isShowCodeLayer" @tap="isShowCodeLayer=false;">
			<view class="fixed pos_l0b0 bgHeader w100 pt20 pb10 plr10" @tap.stop>
				<view class="ptb14 tc blue2 ft14 bold" v-if="loginActive==0">{{$t('login').r_sms}}</view>
				<view class="ptb14 tc blue2 ft14 bold" v-else>{{$t('login').r_smsemail}}</view>
				<view class="flex bgwhite alcenter bdb_blue mb10 mt20" >
					<input type="text" v-if="loginActive==0" v-model="code" class="h40 lh40 flex1" :placeholder="$t('login').r_pmobilecode">
					<input type="text" v-else v-model="code" class="h40 lh40 flex1" :placeholder="$t('login').r_pemailcode">
					<view class="ml10 plr10 white bgBlue ptb5 radius4" @tap="getCode">
						<text v-if="!hasSend">{{$t('login').r_send}}</text>
						<text v-else>{{second}}s</text>
					</view>
				</view>	
				<view class="mt30 bgBlue radius4 ptb10 white ft14 tc mb10" @tap.stop="confirm">{{$t('login').r_next}}</view>
			</view>
		</view>
		</view>
		<tab-bar></tab-bar>
	</view>
</template>

<script>
	// import country from '@/common/country.js'
	import tabBar from '@/components/tab-bar/tab-bar.vue'
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				showPassA: false,
				showPassB: false,
				loginActive:1,
				user_string:'',
				password:'',
				re_password:'',
				code:'',
				array: [],
				index: 0,
				area_code:'+86',
				hasSend:false,
				verifyPwd1:false,
				verifyPwd2:false,
				disable:false,
				load:false,
				invite_code:'',
				codeText:this.$t('login.r_send'),
				from_invite:false,
				isAgree:true,
				second:60,
				isRemember:false,
				verifyPwd:false,
				isShowCodeLayer:false,
				timeInterval:'',
				lang:'',
				nationality:'China',
				invitecode:'',
				downUrl:"",
				isshowlang: false,
				languages: {
				// zh: { name: '中文', img: '/static/image/zh.png' },
				en: { name: 'English', img: '/static/image/en.png' },
				jp: { name: '日本語', img: '/static/image/jp.png' },
				// kr: { name: '한국어', img: '/static/image/kr.png' },
				vn: { name: 'Tiếng Việt', img: '/static/image/vn.png' },
				th: { name: 'ไทย', img: '/static/image/th.png' },
				// ar: { name: 'عربي', img: '/static/image/ar.png' },
				// de: { name: 'Deutsche', img: '/static/image/de.png' },
				// it: { name: 'Italiano', img: '/static/image/it.png' },
				// fr: { name: 'français', img: '/static/image/fr.png' },
				hk: { name: '繁體中文', img: '/static/image/hk.png' },
					},
			}
		},
		onLoad(e) {
			if(e.invite_code&&e.invite_code!='undefined'){
				this.invite_code=e.invite_code || '';
				this.from_invite = true;
			}
			
			// uni.setNavigationBarTitle({
			// 	title:this.$t('login').register
			// })
			// this.code=e.code;
			this.getCountry();
		},
		components: {
			tabBar
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
			this.lang=uni.getStorageSync('lang');
		    this.$utils.setThemeTop(this.theme);
			this.init();
		},
		methods:{
						// 语言切换
		changeLang(lang) {
			// this.$utils.initData({ url: 'lang/set', data: { lang }, type: 'POST' }, res => {
				console.log(lang);
				this.lang = lang;
				uni.setStorageSync('lang', lang);
				this.$i18n.locale = lang;
				this.isshowlang = false;
			// });
		},
			init(){
				var that = this;
				this.$utils.initData({url:'default/setting',data:{
					key:'app_download_url'
				}},(res,msg)=>{
					that.downUrl = res;
				})
			},
			//获取国家列表
			getCountry(){
				this.$utils.initData({url:'default/area_list'},(res,msg)=>{
					console.log(res)
					this.array = res;
					this.area_code = res[0].id;
				})
			},
			// 区号选择
			bindPickerChange(e){
				this.index=e.target.value;
				let item=this.array[this.index];
				this.area_code=item.global_code;
				this.nationality=item.code;
				this.area_code=item.id;
			},
			// 获取验证码
			getCode(){
				if(this.timeInterval) return;
				let url;
				if(this.loginActive==0){
					url='notify/send_sms';
					if(!this.user_string){
						return this.$utils.showLayer(this.$t('login').p_taccount)
					}
				}else{
					url='notify/send_email';
					if(!this.$utils.checkEmail(this.user_string)){
						return this.$utils.showLayer(this.$t('login').p_temail)
					}
				}
				this.$utils.initData({url:url,type:'POST',data:{to:this.user_string,type:1,area_id:this.area_code}},(res,msg)=>{
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
			},
			//发送验证码
			send() {
				var url;
				if(this.loginActive==0){
					url='notify/send_sms';
				}else{
					url='notify/send_email';
				}
				var datas = {
					to: this.user_string,
					area_id: this.area_code,
					type: 1
				};
				if(this.load) return
				this.load = true;
				this.codeText = ''
				this.$utils.initDataToken({ url: url, data: datas, type: 'post' }, (res, msg) => {
					this.$utils.showLayer(msg);
					this.disable = true;
					var times = 60;
					this.load = false;
					var timer = setInterval(() => {
						times--;
						if (times < 10) {
							times = '0' + times;
						}
						this.codeText = times + 's';
						if (times <= 0) {
							clearInterval(timer);
							this.disable = false;
							this.codeText = this.$t('login.r_send');
						}
					}, 1000);
				});
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
			// 确定
			confirm(){
				if(!this.code){
					return this.$utils.showLayer(this.$t('login').p_vcode)
				}
				uni.navigateTo({
					url:`setPwd?user_string=${this.user_string}&is_mobile=${this.loginActive}&code=${this.code}&areaCode=${this.area_code}&invitecode=${this.invitecode}`
				})
				return;
				var data={
					user_string: this.user_string,
					lang:this.lang
				}
				var url=''
				if(this.loginActive==0){
					// 手机注册
					data.country_code=this.area_code;
					data.mobile_code=this.code;
					url="user/check_mobile";
					data.scene='register';
				}else{
					data.email_code=this.code;
					data.country_code=this.area_code;
					url='user/check_email';
					data.scene='register';
				}
				this.$utils.initData({url,data,type:'POST'},(res,msg)=>{
					this.$utils.showLayer(msg);
					this.isShowCodeLayer=false;
					setTimeout(()=>{
						uni.navigateTo({
							url:`setPwd?user_string=${this.user_string}&is_mobile=${this.loginActive}&code=${this.code}&areaCode=${this.area_code}&invitecode=${this.invitecode}`
						})
					},1500)
				})
			},
			downLoad(){
				location.href=`/app`;
			},
			passwordInput1(e){
				if(e.target.value.length<6){
					this.verifyPwd1=true;
				}else{
					this.verifyPwd1=false;
				}
			},
			passwordInput2(e){
				if(e.target.value!=this.password){
					this.verifyPwd2=true;
				}else{
					this.verifyPwd2=false;
				}
			},
			tapChecked(){
				this.isAgree=!this.isAgree;
			},
			register(){
				if(this.loginActive==1){
					// 邮箱登录
					if(!this.$utils.checkEmail(this.user_string)){
						return this.$utils.showLayer(this.$t('login').p_temail)
					}
				}else{
					if(!this.$utils.checkMobile(this.user_string)){
						return this.$utils.showLayer(this.$t('login').p_taccount)
					}
				}
				if(!this.password){
					return this.$utils.showLayer(this.$t('login').p_pwd)
				}
				if(this.password.length<6){
					return this.$utils.showLayer(this.$t('login').p_simple)
				}
				if(this.password!=this.re_password){
					return this.$utils.showLayer(this.$t('login').p_inputagain)
				}
				if(!this.code){
					return this.$utils.showLayer(this.$t('login').p_vcode)
				}
				// if(this.invite_code){
				// 	return this.$utils.showLayer(this.$t('login').p_inviteInput)
				// }
				if(!this.isAgree){
					return this.$utils.showLayer(this.$t('login').p_first)
				}
				var data={
					account: this.user_string,
					password: this.password,
					invite_code: this.invite_code,
					re_password:this.re_password,
					// lang:this.lang,
					area_id:this.area_code,
					sms_code:this.code
				}
				if(this.loginActive==0){
					// 手机
					data.type='mobile';
					// data.country_code=this.area_code;
				}else{
					// 邮箱
					data.type='email';
					// data.country_code=this.area_code;
				}
				if(this.isloading){
					return;
				}
				this.isloading = true;
				setTimeout(()=>{
					this.isloading = false;
				},3000)
				this.$utils.initData({url:'user/register',data,type:'POST'},(res,msg)=>{
					this.$utils.showLayer(msg);
					if(res.jump&&this.from_invite){
						location.href=res.jump;
					}else{
						setTimeout(()=>{
							uni.reLaunch({
								url:'login'
							})
						},1000)
					}
				})
			}
		}
	}
</script>

<style>
	.light{
		min-height: initial;
	}
</style>
