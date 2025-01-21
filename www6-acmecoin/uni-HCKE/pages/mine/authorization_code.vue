<template>
	<view :class="theme">
		<view class="bg-my-grey dark:bg-my-black min-h-screen">
			<view class="bg-white dark:bg-box p-40">
				<view class="py-20 flex items-center justify-center border-2 border-solid border-gray1 ">
				<text class="text-gray1">{{$t('bind.codeauth')}}：</text>
				<text class="text-xl font-bold ml-20">{{code || '-- --'}}</text>
			</view>
			<view class="p-40 text-sm text-center text-gray1">{{$t('bind.codetip')}}</view>
			</view>
		</view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return{
				code:''
			}
		},
		onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('bind.codeauth')
			})
		},
		onShow() {
		   this.$utils.setThemeTop(this.theme)
		   this.getInfo()
		},
		methods:{
			getInfo(){
				this.$utils.initDataToken({url:'user/authorization_code'},res=>{
					this.code=res;
				})
			}
		},
		computed:{
		   ...mapState(['theme']),
		},
	}
</script>
