<template>
	<view :class="theme">
		<view class="p-40 bg-white dark:bg-floor">
			<view class="flex items-center">
				<view class="flex flex-col justify-center items-center mr-10" :class="{ 'text-primary': loginActive == 0 }" @tap="loginActive=0;">
					<view class="mb-30 text-xl">{{$t('login').f_mobile}}</view>
					<view class="w-60 h-4 bg-primary" v-if="loginActive == 0"></view>
				</view>
				<view class="flex flex-col justify-center items-center" :class="{ 'text-primary': loginActive == 1 }" @tap="loginActive=1;">
					<view class="mb-30 text-xl">{{$t('login').f_email}}</view>
					<view class="w-60 h-4 bg-primary" v-if="loginActive == 1"></view>
				</view>
			</view>
			<view class="mt-80">
				<view class="flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
					<view class="flex  items-center between mr10" v-if="loginActive==0">
						<picker :value="index" :range="array" class="flex-1"  @change="bindPickerChange" range-key="code">
							<!-- <view class="uni-input">{{array[index].name_cn}}</view> -->
							<view class="ft12" v-if="array[index]">{{array[index].global_code}}</view>
						</picker>
						<image src="/static/image/trade_arrow_down.png" class="wt10 h8 ml5"></image>
					</view>
					<view class="flex items-center flex-1">
						<input type="text"  v-model="user_string" class="h-100 flex-1" v-if="loginActive==1" :placeholder="$t('login').p_email">
						<input type="text" v-model="user_string" class="h-100 flex-1" v-else :placeholder="$t('login').p_mobile">
					</view>
				</view>
				<view class="my-100 bg-primary rounded-10 p-20 text-black text-lg text-center" @tap="goNext" hover-class="opacity-50">{{$t('login').r_next}}</view>
			</view>
		</view>
		<view class="fixed my_layer pos_l0b0 w100 ht100" v-if="isShowCodeLayer" @tap="isShowCodeLayer=false;">
			<view class="fixed pos_l0b0 bgHeader w100 pt20 pb10 plr10" @tap.stop>
				<view class="ptb14 tc blue2 ft14 bold" v-if="loginActive==0">{{$t('login').r_sms}}</view>
				<view class="ptb14 tc blue2 ft14 bold" v-else>{{$t('login').r_smsemail}}</view>
				<view class="flex bgwhite items-center bdb_blue mb10 mt20" >
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
</template>

<script>
	import country from '@/common/country.js'
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				loginActive:0,
				user_string:'',
				password:'',
				re_password:'',
				code:'',
				array: [],
				index: 0,
				area_code:'+86',
				hasSend:false,
				second:60,
				isRemember:false,
				verifyPwd:false,
				isShowCodeLayer:false,
				timeInterval:'',
				lang:'',
				nationality:'China'
			}
		},
		onLoad() {
			this.lang=uni.getStorageSync('lang');
			uni.setNavigationBarTitle({
				title:this.$t('login').forget_pwd
			})
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
		   this.$utils.setThemeTop(this.theme);
		   this.getCountry();
		},
		methods:{
			//获取国家列表
			getCountry(){
				this.$utils.initData({url:'default/area_list'},(res,msg)=>{
					console.log(res)
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
				if(this.loginActive==0){
					if(!this.user_string){
						return this.$utils.showLayer(this.$t('login').p_taccount)
					}
					this.$utils.initData({url:'notify/send_sms',type:'POST',
						data:{
							to:this.user_string,
							type:2,
							area_id:this.area_code,
							lang:this.lang
						}},(res,msg)=>{
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
						return this.$utils.showLayer(this.$t('login').p_temail)
					}
					this.$utils.initData({url:'notify/send_email',type:'POST',
						data:{
							to:this.user_string,
							type:2,
							lang:this.lang,
							area_id:this.area_code,
						}},(res,msg)=>{
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
			// 下一步
			goNext(){
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
				const user_string =  this.loginActive == 0?`${this.array[this.index].global_code}${this.user_string}`: this.user_string
				uni.navigateTo({
					url:'/pages/mine/forgetPwdNext?account='+user_string+'&area_code='+this.area_code+'&is_mobile='+this.loginActive
				})
				// this.isShowCodeLayer=true;
				// this.hasSend=false;
				// this.timeInterval='';
				// this.code='';
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
				var data={
					user_string: this.user_string,
					lang:this.lang
				}
				var url='';
				uni.navigateTo({
					url:'/pages/mine/forgetPwdNext?account='+this.user_string+'&code='+this.code+'&country_code='+this.area_code
				})
				// if(this.loginActive==0){
				// 	// 手机登录
				// 	data.country_code=this.area_code;
				// 	data.mobile_code=this.code;
				// 	url="user/check_mobile";
				// 	data.scene='reset_password';
				// 	data.lang=this.lang;
				// }else{
				// 	data.email_code=this.code;
				// 	data.country_code=this.area_code;
				// 	data.scene='reset_password';
				// 	url='user/check_email';
				// 	data.lang=this.lang;
				// }
				// this.$utils.initData({url,data,type:'POST'},(res,msg)=>{
				// 	this.$utils.showLayer(msg);
				// 	this.isShowCodeLayer=false;
				// 	setTimeout(()=>{
				// 		uni.navigateTo({
				// 			url:'/pages/mine/forgetPwdNext?account='+this.user_string+'&code='+this.code+'&country_code='+this.area_code
				// 		})
				// 	},1500)
				// })
			}
		}
	}
</script>

<style>
</style>
