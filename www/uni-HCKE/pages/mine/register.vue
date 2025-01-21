<template>
	<view :class="theme">
		 <view class="p-30 bg-my-grey dark:bg-1C2532 text-black dark:text-white" style="min-height: 100vh;">
			<view>
			<view class="ft24 text-clip-green" v-if="loginActive==0">
				{{$t('login').r_mobile}}
			</view>
			<view class="ft24 text-clip-green" v-else>
				{{$t('login').r_email}}
			</view>
			<!-- <view class="flex alcenter mt10">
				<image src="../../static/image/regi.png" class="wt15 h15"></image>
				<view class="chengse ft14">{{$t('login').r_noedit}}</view>
			</view> -->
			<view class="mt40 ">
				<view class="mb10 ">
					<!-- <view class="flex  alcenter between mr10" v-if="loginActive==1">
						<picker :value="index" :range="array" class=" flex1"  @change="bindPickerChange" range-key="code">
							<view class="uni-input">{{array[index].name_cn}}</view>
							<view class="ft12" v-if="array[index]">{{array[index].code}}{{array[index].global_code}}</view>
						</picker>
						<image src="/static/image/trade_arrow_down.png" class="wt10 h8 ml5"></image>
					</view> -->
					<view class="flex alcenter flex1 bdb_myblue">
						<input type="text"  v-model="user_string" class="h40 lh40  flex1" v-if="loginActive==1" :placeholder="$t('login').p_email">
						<input type="text" v-model="user_string" class="h40 lh40  flex1" v-else :placeholder="$t('login').p_mobile">
					</view>
					<view class="flex bgwhite alcenter bdb_myblue ">
						<input type="text" password="" v-model="password" @input="passwordInput1" class="h40 lh40 flex1" :placeholder="$t('login').p_pwd">
						<image src="/static/image/password.png" class="wt15 h15 ml10"></image>
					</view>
					<view class="ft10 pt5 chengse" v-if="verifyPwd1">{{$t('login').p_len}}</view>
					<view class="flex bgwhite alcenter bdb_myblue ">
						<input type="text" password="" v-model="re_password" @input="passwordInput2" class="h40 lh40 flex1" :placeholder="$t('login').p_confirmPwd">
						<image src="/static/image/password.png" class="wt15 h15 ml10"></image>
					</view>
					<view class="ft10 pt5 chengse" v-if="verifyPwd2">{{$t('login').p_notsame}}</view>
					<view class="flex bgwhite alcenter bdb_myblue ">
						<input type="text" v-model="code" class="h40 lh40 flex1" :placeholder="$t('login').p_vcode" />
						<button size="mini" type="primary" class="px-40 bg-main-linear text-white"  :disabled="disable" :loading="load" @click="send">{{ codeText }}</button>
					</view>
					<view class="flex bgwhite alcenter bdb_myblue ">
						<input type="text" v-model="invite_code"  class="h40 lh40 flex1" :placeholder="$t('login').p_invitecode">
					</view>
					
						<template v-if="is_quick_register">
						<view class="flex bgwhite alcenter bdb_myblue ">
							<input type="text" v-model="name"  class="h40 lh40 flex1" :placeholder="$t('collect.p_name')">
						</view>
						<view class="flex bgwhite alcenter bdb_myblue ">
							<input type="text" v-model="card_id"  class="h40 lh40 flex1" :placeholder="$t('collect.p_cardno')">
						</view>
						<view class="mt-20">
						<view class="w-full rounded-8 text-center py-40" @tap="uploadImg(1)">
							<view v-if="!hasUp1">
								<image :src="img" class="w-160 h-160"></image>
								<view class="mt-20 text-center">{{$t('collect.up_cardz')}}</view>
							</view>
							<image :src="img1" class="w-full h-400" mode="widthFix" v-else></image>
						</view>
						<view class="w-full rounded-8 text-center py-40" @tap="uploadImg(2)">
							<view v-if="!hasUp2">
								<image :src="img" class="w-160 h-160" ></image>
								<view class="mt10 text-center">{{$t('collect.up_cardf')}}</view>
							</view>
							<image :src="img2" class="w-full h-400" mode="widthFix" v-else></image>
						</view>

			</view>
					</template>


					<view class="mt20 flex alcenter">
						<view class=" flex alcenter">
							<checkbox value="cb" :checked="isAgree"  @tap="tapChecked" style="transform:scale(0.7);color:'#1881d2'"/>
							<text>{{$t('login').p_agree}}</text>
						</view>
						<navigator :url="'/pages/home/agreement'">
							<view class="ml10 text-clip-green">《{{$t('login').p_private}}》</view>
						</navigator>
					</view>
					<view class="mt45 radius4 ptb10 ft14 tc mb10 bg-main-linear text-white" @tap="register">{{$t('login.register')}}</view>
				</view>
			</view>
			<view class="mt20 flex between alcenter" style="justify-content: end;">
				<!-- <view class="text-primary" v-if="loginActive==1" @click="loginActive=0;user_string=''">
					{{$t('login.r_mobile')}}
				</view>
				<view class="text-primary" v-else @click="loginActive=1;user_string=''">
					{{$t('login.r_email')}}
				</view> -->
				<!-- #ifdef H5 -->
				<!-- <view class="text-clip-green" @tap="downLoad">
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
		<tab-bar></tab-bar>
		</view>
	</view>
</template>

<script>
	// import country from '@/common/country.js'
	import tabBar from '@/components/tab-bar/tab-bar.vue'
	import {mapState} from 'vuex'
	 import helper from '@/common/helper.js'
	export default{
		data(){
			return {
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

				is_quick_register: false,
				name:'',
				card_id:'',
				img:'/static/image/addImg.png',
				hasUp1:false,
				hasUp2:false,
				img1:'',
				img2:'',
			}
		},
		onLoad(e) {
			if(e.invite_code&&e.invite_code!='undefined'){
				this.invite_code=e.invite_code || '';
				this.from_invite = true;
			}
			this.lang=uni.getStorageSync('lang');
			uni.setNavigationBarTitle({
				title:this.$t('login').register
			})

			this.$utils.initData({url:'default/setting?key=is_quick_register'},(res,msg)=>{
				this.is_quick_register = res ==1 
				console.log(this.is_quick_register,' is_quick_register');
			})

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
		    this.$utils.setThemeTop(this.theme);
			// this.init();
		},
		methods:{
			// init(){
			// 	var that = this;
			// 	this.$utils.initData({url:'default/setting',data:{
			// 		key:'app_download_url'
			// 	}},(res,msg)=>{
			// 		that.downUrl = res;
			// 	})
			// },
			uploadImg(i){
				var that=this;
				uni.chooseImage({
					count: 1,
					sizeType: ['compressed'],
					success: (chooseImageRes) => {
						// this.ossFileUpload(chooseImageRes.tempFiles[0],res=>{
						// 			var img='img'+i;
						// 			var hsup='hasUp'+i;
								
						// 			that[img]=res.url;
						// 			that[hsup]=true;
											
						// })
						const tempFilePaths = chooseImageRes.tempFilePaths;
						uni.uploadFile({
							//url: domain+'/api/common/image_upload', //仅为示例，非真实的接口地址
							// #ifdef APP-PLUS
							url:helper._DOMAIN+'/api/common/image_upload',
							// #endif
							filePath: tempFilePaths[0],
							name: 'file',
							formData: {
								'user': 'test'
							},
							success: (uploadFileRes) => {
								console.log(typeof uploadFileRes.data);
								var data=JSON.parse(uploadFileRes.data);
								if(data.code==1){
									var img='img'+i;
									var hsup='hasUp'+i;
									console.log(data)
									that[img]=data.data.url;
									that[hsup]=true;
								}
							}
						});
					}
				});
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

				if(this.is_quick_register){
					if(!this.name){
					return this.$utils.showLayer(this.$t('collect.p_name'))
					}
					if(!this.card_id){
						return this.$utils.showLayer(this.$t('collect.p_cardno'))
					}
					if(!this.img1){
						return this.$utils.showLayer(this.$t('collect.up_cardz'))
					}
					if(!this.img2){
						return this.$utils.showLayer(this.$t('collect.up_cardf'))
					}
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
					sms_code:this.code,
					name:this.name,
					card_id:this.card_id,
					front_pic:this.img1,
					reverse_pic:this.img2,
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
