<template>
	<view class="" :class="{'light light_white':theme=='light'}">
		<view class="plr10 ptb20" v-html="msg.content">
			
		</view>
	</view>
	
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return{
				msg:''
			}
		},
		created() {
			this.getMsg();
		},
		onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('about').privat
			})
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
		    this.$utils.setThemeTop(this.theme)
		},
		methods:{
			getMsg(){
				this.$utils.initData({url:'news/info',data:{id:19}},(res,msg)=>{
					this.msg = res
				})
			}
		}
	}
</script>

<style>
</style>
