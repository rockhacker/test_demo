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
				this.url=`https://go.crisp.chat/chat/embed/?website_id=7984727a-2c6d-4417-9a69-089aa97b6b84`;
			}
		},
		methods:{
			customerService(){
				  let that = this;
				  //获取用户信息
				  that.$utils.initDataToken({url:'user/info',type:'get'},res=>{
					  console.log(res)
						let visiter_name = '';
						if(res && res.email)visiter_name = res.email;
						this.url=`https://go.crisp.chat/chat/embed/?website_id=7984727a-2c6d-4417-9a69-089aa97b6b84&user_nickname=${res.uid}`;
				  })
			},
		}
	}
</script>
