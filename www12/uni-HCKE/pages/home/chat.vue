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
			this.url=`https://go.crisp.chat/chat/embed/?website_id=9dec9228-10ec-48db-9442-6ed97d552cd9`;
			var token=uni.getStorageSync('token');
			if(token){
				this.customerService()
			}else{
				this.url=`https://go.crisp.chat/chat/embed/?website_id=9dec9228-10ec-48db-9442-6ed97d552cd9`;
			}
			// https://go.crisp.chat/chat/embed/?website_id=9dec9228-10ec-48db-9442-6ed97d552cd9&user_email=${visiter_name}
			
		},
		methods:{
			customerService(){
				  let that = this;
				  //获取用户信息
				  that.$utils.initDataToken({url:'user/info',type:'get'},res=>{
					  console.log(res)
						let visiter_name = '';
						if(res && res.email)visiter_name = res.email;
						this.url=`https://go.crisp.chat/chat/embed/?website_id=9dec9228-10ec-48db-9442-6ed97d552cd9&user_email=${visiter_name}`;
				  })
			},
		}
	}
</script>
