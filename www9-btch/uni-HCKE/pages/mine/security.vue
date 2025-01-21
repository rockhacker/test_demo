<template>
	<view :class="theme">
		 <view class="px-40 bg-white flex between wraps mt30">
			<view class="item mt10" @click="path('/pages/mine/google?verified='+obj.google_secret_verified)">
				<view class="flex flex items-center between pl10 pr20">
					<image src="../../static/image/google2.png" v-if="obj.google_secret_verified" style="width: 86rpx;height: 66rpx;"  mode="widthFix"></image>
					<image src="../../static/image/google.png" v-else style="width: 86rpx;height: 66rpx;"  mode="widthFix"></image>
					<image src="../../static/image/y.png"  style="width: 26rpx;height: 2rpx;" mode="widthFix"></image>
				</view>
				<view class="mt10">{{ $t('add.ggyzq') }}</view>
			</view>
			<view class="item mt10" @click="path('/pages/mine/phone?verified='+obj.mobile_verified)">
				<view class="flex flex items-center between pl10 pr20">
					<image src="../../static/image/sj2.png" v-if="obj.mobile_verified" style="width: 86rpx;height: 66rpx;"  mode="widthFix"></image>
					<image src="../../static/image/sj.png" v-else style="width: 86rpx;height: 66rpx;"  mode="widthFix"></image>
					<image src="../../static/image/y.png"  style="width: 26rpx;height: 2rpx;" mode="widthFix"></image>
				</view>
				<view class="mt10">{{ $t('add.sjyz') }}</view>
			</view>
			<view class="item mt10" @click="path('/pages/mine/email?verified='+obj.email_verified)">
				<view class="flex flex items-center between pl10 pr20">
					<image src="../../static/image/yx1.png" v-if="obj.email_verified"  style="width: 86rpx;height: 66rpx;"  mode="widthFix"></image>
					<image src="../../static/image/yx.png" v-else style="width: 86rpx;height: 66rpx;"  mode="widthFix"></image>
					<image src="../../static/image/y.png"  style="width: 26rpx;height: 2rpx;" mode="widthFix"></image>
				</view>
				<view class="mt10">{{ $t('add.yxyz') }}</view>
			</view>
		 </view>
		 <view class="bg-my-grey dark:bg-my-black min-h-screen">
			<navigator v-if="!isWallet" url="/pages/mine/modifyPwdNext" class="bg-white dark:bg-1C2532 py-40 px-40 text-lg flex items-center justify-between border-0 border-solid border-b-2 border-gray-200 dark:border-gray-700">
				<span>{{$t('login.s_loginpwd')}}</span>
				<span class="flex items-center">{{$t('login.s_edit')}}<image src="../../static/image/mores.png" class="w-30 h-30 ml-20"></image></span>
			</navigator>
			<navigator url="/pages/mine/resetLegalPwd" class="bg-white dark:bg-1C2532 py-40 px-40 text-lg flex items-center justify-between border-0 border-solid border-b-2 border-gray-200 dark:border-gray-700">
				<span>{{$t('new.zij')}}</span>
				<span class="flex items-center">{{$t('login.s_edit')}}<image src="../../static/image/mores.png" class="w-30 h-30 ml-20"></image></span>
			</navigator>
		</view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				obj:{},
				isWallet:false
			}
		},
		onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('login').security
			})
			this.isWallet = uni.getStorageSync('walletLogin')
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
		    this.$utils.setThemeTop(this.theme)
			this.verified_info()
		},
		methods:{
			path(url,bool){
                if(bool){
                    uni.switchTab({url: url })
                }else{
                    uni.navigateTo({url: url })
                }
            },
            verified_info(){
				this.$utils.initDataToken({url:'user/verified_info'},(res,msg)=>{
					this.obj  = res
				
				})
			},			
		}
	}
</script>

<style lang="scss" scoped>
.item{
	width: 48%;
	background: #f6f6f6;
	height: 180rpx;
	padding:0 20rpx;
	display: flex;
	flex-direction: column;
	justify-content: center;
}
</style>
