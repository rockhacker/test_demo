<template>
	<view>
			<view style="margin:0 auto;" class=" bg-main-linear mt-100 w80 h-80 flex justify-center items-center text-center bg-my-orange text-white text-xl rounded-10" @click="confirm('whatsApp_url')">WhatsApp</view>
		    <view style="margin:0 auto;" class=" bg-main-linear mt-50 w80 h-80 flex justify-center items-center text-center bg-my-orange text-white text-xl rounded-10" @click="confirm('line_url')">Line</view>
			<view style="margin:0 auto;" class=" bg-main-linear mt-50 w80 h-80 flex justify-center items-center text-center bg-my-orange text-white text-xl rounded-10" >{{ $t('login.e_email') }}:{{email}}</view>
	</view>
</template>
<script>
	import { mapState } from 'vuex';
	export default{
		data(){
			return {
				email:''
			}
		},
		computed: {
			...mapState(['theme'])
		},
		onLoad(e) {
			this.$utils.setThemeTop(this.theme)
			this.getChat()
		},
		methods:{
			confirm(val){
			  this.getChat(val)
			},
			getChat(val) {
				// uni.showLoading();
				this.$utils.initData({ url: 'default/setting', data: { key: val ? val : 'kefu_email' }}, (res, msg) => {
					 
					  if(val){
						   window.location.href = res
					  }else{
						  this.email = res
					  }
				});
			},
		}
	}
</script>
