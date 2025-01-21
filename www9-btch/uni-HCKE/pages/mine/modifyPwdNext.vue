<template>
	<view class="min-h-screen" :class="theme">
		<view class="p-40 bg-white dark:bg-1C2532 min-h-screen">
			<view class="py-60">
				<view class="flex bgwhite items-center border-0 border-solid border-b-2 border-gray-200 dark:border-gray-700">
					<input type="text" password="" v-model="old_password" class="h-100 flex-1" :placeholder="$t('login').p_jiupwd">
					<image :src="`/static/image/${theme=='dark'?'password.png':'password_gray.png'}`" class="w-30 h-30 mx-20"></image>
				</view>
				<view class="flex bgwhite items-center border-0 border-solid border-b-2 border-gray-200 dark:border-gray-700">
					<input type="text" password="" v-model="password" @input="passwordInput1" class="h-100 flex-1" :placeholder="$t('login').p_pwd">
					<image :src="`/static/image/${theme=='dark'?'password.png':'password_gray.png'}`" class="w-30 h-30 mx-20"></image>
				</view>
				<view class="text-sm pt-10 text-danger" v-if="verifyPwd1">{{$t('login').p_len}}</view>
				<view class="flex bgwhite items-center border-0 border-solid border-b-2 border-gray-200 dark:border-gray-700">
					<input type="text" password="" v-model="re_password" @input="passwordInput2" class="h-100 flex-1" :placeholder="$t('login').p_confirmPwd">
					<image :src="`/static/image/${theme=='dark'?'password.png':'password_gray.png'}`" class="w-30 h-30 mx-20"></image>
				</view>
				<view class="text-sm pt-10 text-danger" v-if="verifyPwd2">{{$t('login').p_notsame}}</view>
				<!-- <view class="mb-40">
					<uni-data-checkbox @change="change" selectedColor="#48D2B9" v-model="sex" :localdata="sexs" />
				</view> -->
				<view class="mb-40 mt20">
					<uni-data-checkbox @change="change" selectedColor="#48D2B9" v-model="sex" :localdata="sexs" />
					<view class="flex w-full items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700 mb-20">
						<input type="text" v-model="code" class="h-100 flex-1" :placeholder="$t('login').p_vcode"/>
						<button v-if="verify_type!='google_secret'" size="mini" type="primary" class="px-40 bg-main-linear text-white"  :disabled="disable" :loading="load" @click="send">{{ codeText }}</button>
					</view>	
					<!-- <input type="text" password="" class="border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700 h-80 w-full" v-model="password" :placeholder="$t('login.e_pdeal')" /> -->
				</view>
			</view>
			<view class="mt-100 bg-main-linear rounded-10 p-20 text-white text-lg text-center" @tap="reset">{{$t('login').e_chongzhi}}</view>
		</view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				user_string:'',
				password:'',
				re_password:'',
				//code:'',
				area_code:'',
				isAgree:false,
				invite_code:'',
				verifyPwd1:false,
				verifyPwd2:false,
				lang:'',
				disable:false,
				load:false,
				old_password:'',
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
				info:{}
			}
		},
		onLoad(e) {
			this.user_string=e.account;
			this.code=e.code;
			uni.setNavigationBarTitle({
				title:this.$t('login').e_chongzhi
			})
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
		    this.$utils.setThemeTop(this.theme)
			this.verified_info()
			this.info = JSON.parse(uni.getStorageSync('info'));
		},
		methods:{
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
			reset(){
				if(!this.old_password){
					return this.$utils.showLayer('请输入旧密码')
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
				var data={
					old_password:this.old_password,
					new_password: this.password,
					secondary_password: this.re_password,
					verify_type:this.verify_type,
						code:this.code, 
				}
				this.$utils.initDataToken({url:'user/amend_password',data,type:'POST'},(res,msg)=>{
					this.$utils.showLayer(msg);
					setTimeout(()=>{
						uni.navigateBack({
							delta:1
						})
					},1000)
				})
			}
		}
	}
</script>