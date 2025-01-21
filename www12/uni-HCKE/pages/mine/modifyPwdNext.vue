<template>
	<view class="min-h-screen" :class="theme">
		<view class="p-40 bg-white dark:bg-main-black min-h-screen">
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
			</view>
			<view class="mt-100 bg-new-orange rounded-10 p-20 text-black text-lg text-center" @tap="reset">{{$t('login').e_chongzhi}}</view>
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
				code:'',
				area_code:'',
				isAgree:false,
				invite_code:'',
				verifyPwd1:false,
				verifyPwd2:false,
				lang:'',
				disable:false,
				load:false,
				old_password:''
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
		},
		methods:{
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