<template>
	<view>
		<web-view :src="url"></web-view>
	</view>
</template>
<script>
	import { mapState } from 'vuex';
	export default{
		data(){
			return {
				url:''
			}
		},
		computed: {
			...mapState(['theme'])
		},
		onLoad(e) {
			this.$utils.setThemeTop(this.theme)
			var token=uni.getStorageSync('token');
			if(token){
				this.customerService()
			}else{
				this.url=`https://direct.lc.chat/15129504/`;
			}
		},
		methods:{
			customerService(){
				  let that = this;
				  //获取用户信息
				  that.$utils.initDataToken({url:'user/info',type:'get'},res=>{
					  console.log(res)
						let visiter_name = '';
						if(res && res.uid)visiter_name = res.uid;
						this.url=`https://direct.lc.chat/15129504?uid=${visiter_name}`;
				  })
			},
		}
	}
</script>
