<template>
	<view>
		<web-view :src="url"></web-view>
	</view>
</template>
<script>
import { mapState } from 'vuex';
export default {
	data() {
		return {
			url: '',
			type: ''
		}
	},
	computed: {
		...mapState(['theme'])
	},
	onLoad(e) {
		this.$utils.setThemeTop(this.theme)
		this.type = e.n
		var token=uni.getStorageSync('token');
		// if (this.type == 1) {
		// 	this.url = 'https://chat.ichatlink.net/widget/standalone.html?eid=60dd0ea60cb4d397da0f54e9c540c0f4&language=en'
		// } else {
		// 	this.url = 'https://chat.ichatlink.net/widget/standalone.html?eid=ec1ca902e661d35961f562c481072048&language=en'
		// }
		// if (token) {
		// 	this.customerService()
		// }
		

		//this.url = 'https://chat.ichatlink.net/widget/standalone.html?eid=ec1ca902e661d35961f562c481072048&language=en'
	},
	methods: {
		customerService() {
			let that = this;
			//获取用户信息
			that.$utils.initDataToken({ url: 'user/info', type: 'get' }, res => {
				if (res && res.email) {
					if(this.type == 1){
						this.url += `&user_email=${res.email}`
					}else{
						let obj = {
							email: res.email
						}
						this.url += `&metadata=${JSON.stringify(obj)}`
					}
					// https://go.crisp.chat/chat/embed/?website_id=532c9af6-50fc-4c62-bf4d-28fe5a58b145&user_email=${visiter_name}
					// this.url = `https://chat.ichatlink.net/widget/standalone.html?eid=ec1ca902e661d35961f562c481072048&language=en&metadata=${JSON.stringify(obj)}`
				};
				console.log(this.url)
				// this.url=`https://chat.cointigerex.cc/index/index/home?visiter_id=&visiter_name=${visiter_name}&avatar=&groupid=0&business_id=3`;
			})
		},
	}
}
</script>
