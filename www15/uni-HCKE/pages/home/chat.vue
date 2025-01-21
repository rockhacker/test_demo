<template>
	<view>
		<web-view :src="url"></web-view>
	</view>
</template>
<script>
	const CryptoJS = require("crypto-js");
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
			// this.url=`https://links.nbkefu.com/index/index/home`;
			this.customerService()
		},
		methods:{
			aesKeyBytes() {
			var keyBytes = CryptoJS.SHA1("7Ou5PYbbHO8051xtcBPUoj4d0NwDGULS").toString().substring(0, 16); 
			return keyBytes; 
			},
			encrypt(str) { 
			// 字符串类型的key用之前需要用uft8先parse一下才能用
			var key = CryptoJS.enc.Utf8.parse(this.aesKeyBytes()); 
			// console.log("utf-i-key = "+key); // 加密 
			var encryptedData = CryptoJS.AES.encrypt(str, key, { mode: CryptoJS.mode.ECB, padding: CryptoJS.pad.Pkcs7 }); 
			var encryptedBase64Str = encryptedData.toString(); 
			// console.log(encryptedBase64Str); 
			return encryptedData.ciphertext.toString(); 
			},
			customerService(){
				  let that = this;
				  //获取用户信息
				  that.$utils.getGlobalSettting({url:'user/info',type:'get'},res=>{
					  console.log(res,3333)
						let visiter_name = '';
						if(res && res.data && res.data.uid)visiter_name = res.data.uid;
						this.url=`https://direct.lc.chat/14410884?uid=${visiter_name}`;
						// const text = JSON.stringify({vipid:res.uid,name:res.uid})
						// const text = JSON.stringify({"phone": "17348088081", "vipid": "vipid", "name": "测试", "headimgurl": "http://127.0.0.1:8081/res/image.html?id=user%2F1da306311ef 4929774b39e26c0822719.png", "category": "一级", "vip": true, "email": "13115@qq.com"})
						// const extradata = this.encrypt(text)
						// this.url = `https://5dtow1.com/chat/text/chat_158ohA.html?l=en&extradata=${extradata}&vipid=${res.uid}&name=${res.uid}`
						// this.url=`https://links.nbkefu.com/index/index/home?visiter_id=${visiter_name}&visiter_name=${visiter_name}&avatar=&groupid=0&business_id=90`;
						// this.url=`https://links.niubikefu.com/index/index/kefu?u=62cda366c7ab3&uid=${visiter_name}&name=${visiter_name}`;

				  })
			},
		}
	}
</script>
