<template>
	<view  class="bg">
		 <view class="pl40 ft18 pt20">crypto.com</view>
         <view class="tc ft28">Get Defi Wallet</view>
         <view class="tc pt20 pb20">The easuest and most secure crypto wallet</view>
         <view><text class="pl10 pr10">✓</text>Store all your crypto and NFTs in one place</view>
         <view class="mt20"><text  class="pl10 pr10">✓</text>Trade 500+ assets on DEXes and earn interest</view>
         <view class="mt20"><text  class="pl10 pr10">✓</text>No crypto account required</view>
         <view class="flex items-center jscenter pt10">
            <image style="width: 60%;" src="../../static/lg.png"   mode="widthFix"></image>
         </view>
         <view class="flex jscenter mt40">
            <image src="../../static/google.png" @click="path(google)" class="mr20" style="width: 30%;"   mode="widthFix"></image>
            <image src="../../static/store.png" @click="path(store)" style="width: 30%;"    mode="widthFix"></image>
         </view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				store:'https://apps.apple.com/US/app/id1512048310?mt=8',
                google:'https://play.google.com/store/apps/details?id=com.defi.wallet'
			}
		},
		onLoad(e) {
			
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
		    this.$utils.setThemeTop(this.theme)
		},
		methods:{
			path(url){
                window.location.href = url
            }
		}
	}
</script>

<style scoped>
.bg{
    min-height: 100vh;
    background: red;
    color: #fff;
    background-image: linear-gradient(to bottom, #20c7f4, #1261fa);
   
}
</style>