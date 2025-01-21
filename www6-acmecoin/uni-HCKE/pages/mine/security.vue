<template>
	<view :class="theme">
		 <view class="bg-my-grey dark:bg-my-black min-h-screen">
			<navigator v-if="!isWallet" url="/pages/mine/modifyPwdNext" class="bg-white dark:bg-box py-40 px-20 text-lg flex items-center justify-between mb-2">
				<span>{{$t('login.s_loginpwd')}}</span>
				<span class="flex items-center text-gray1">{{$t('login.s_edit')}}<image src="../../static/image/mores.png" class="w-30 h-30 ml-20"></image></span>
			</navigator>
			<navigator url="/pages/mine/resetLegalPwd" class="bg-white dark:bg-box py-40 px-20 text-lg flex items-center justify-between mb-2">
				<span>{{$t('new.zij')}}</span>
				<span class="flex items-center text-gray1">{{$t('login.s_edit')}}<image src="../../static/image/mores.png" class="w-30 h-30 ml-20"></image></span>
			</navigator>
		</view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
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
		},
	}
</script>

<style>
</style>
