<template>
	<view :class="{'light light_white':theme=='light'}" class="bgPart">
		 <view class="content" v-html="val"></view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return{
				val:''
			}
		},
		onLoad(e) {
			console.log(e)
			this.val=e.val
			uni.setNavigationBarTitle({
				title:e.title
			})
		},
		methods:{
		   
		},
		onShow() {
		   this.$utils.setThemeTop(this.theme)
		},
		computed:{
		   ...mapState(['theme']),
		},
	}
</script>

<style>
.content{
	padding:20upx ;
	font-size: 32upx;
}
</style>
