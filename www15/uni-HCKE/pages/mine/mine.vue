<template>
  <view :class="theme" >
	
	<uni-nav-bar>
		<view class="w-full">
			<view class="w-full text-black bg-white dark:bg-floor dark:text-white p-40">
				<view class="w-full flex justify-between">
					<!-- <navigator class="" :url="`/pages/mine/${token?'login':'userCenter'}`"> -->
					<div class="">
						<view class="text-lg">{{ token?(info.mobile || info.email || '- -'):$t("home.p_login") }}</view>
						<view class="text-lg">{{ token?(`UID: ${info.uid || '- -'}`):$t("home.welcome") }}</view>
					</div>
					<view class="flex flex-col">
						<view class="text-lg text-primary">{{ info.level || '- -' }}</view>
						<view class="text-lg text-primary">{{ `${$t('home.credit')}: ${info.credit_score || '- -'}` }}</view>
					</view>
					<button v-if="info.uid" type="primary" size="default" class="text-sm px-20 bg-primary text-white" @click="logout">
					  {{ $t("home.logout") }}
					</button>
				</view>
			</view>
			
			<view class="w-full px-20 pb-20 text-white">
				<view class="rounded-lg p-40" style="background: linear-gradient(180deg, rgba(33, 113, 100, 1) 0%, rgba(0, 49, 41, 1) 100%);">
					<view class="flex justify-between">
						<view class="text-2xl">{{ $t("new.mine") }}</view>
						<!-- <image src="/static/image/a.png" class="w-40 h-40" v-if="active == 1" @click="aetActive(2)"></image>
						<image src="/static/image/b.png" class="w-40 h-40" v-else @click="aetActive(1)"></image> -->
					</view>
					<view class="my-20">{{ $t("new.zichan") }} </view>
					<navigator url="/pages/assets/assets" open-type="switchTab" class="flex justify-between items-center mb10">
						<view class="text-2xl my-20">{{ active==1?(all?all.toFixed(2):all):'******' }} <span class="ml-20 text-xs">(USDT)</span> </view>
						<image src="/static/image/mores.png" class="w-40 h-40"></image>
					</navigator>
					<!-- <navigator url="/pages/assets/assets" open-type="switchTab" class="flex justify-between items-center">
						<view class="bg-deep-green rounded-3xl px-20 py-10">
							{{active==1?(`${$t("new.keyong")} : ${all - lock}`):'****'}}
						</view>
						<image src="/static/image/mores.png" class="w-40 h-40"></image>
					</navigator> -->
					<view class="flex justify-between items-center">
						<span class="bg-deep-green rounded-3xl px-20 py-10">
							{{active==1?(`${$t("new.keyong")} : ${all - lock}`):'****'}}
						</span>
						<span>{{$t('home.jryk')}}: {{total_profit}}</span>
					</view>
					
				</view>
			</view>
		</view>
	</uni-nav-bar>
	
	<view class="pb-100">
		<view class="dark:bg-floor dark:text-white">
			<!-- <navigator v-if="token && is_agent" url="/pages/marketingTeam/index" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("team.team") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<navigator v-if="token" url="/pages/home/recharge" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("new.chozhi") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/charge_record" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("home.czjl") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/withdraw" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("new.zhuan") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/transfer" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("new.zhuanzhang") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/exchange" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("new.duih") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<view class="flex items-center px-40 py-30 justify-between text-lg" @click="dow">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("login.downApp") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</view>
		</view>		
		<view class="bg-black p-30">{{ $t("new.acctieon") }}</view>
		<view class="bg-white dark:bg-floor dark:text-white">	  
			<!-- <navigator v-if="token" url="/pages/mine/real_authentication" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("authentication.renzheng") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
		<!-- 	<navigator v-if="info.is_seller" url="/pages/legal/storeDetail" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("home.myshop") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<navigator v-if="token" :url="'/pages/mine/invite?code=' + info.invite_code" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("home.myshare") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<!-- <navigator url="/pages/mine/authorization_code" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("bind.codeauth") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<navigator url="/pages/mine/security" class="flex items-center px-40 py-30 justify-between text-lg" >
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("login.security") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator url="/pages/assets/bindMentionAddress" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("bind.bindAddr") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
		<!-- 新币申购开放	<navigator url="/pages/assets/subscriptionRunning" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("assets.subscriptionRunning") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
				<navigator url="/pages/mine/collect" class="flex items-center px-40 py-30 justify-between text-lg">
					<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("new.fa") }}</view>
					<image src="/static/image/mores.png" class="w-40 h-40"></image>
				</navigator>
		</view>	
		<view class="bg-black p-30">{{ $t("new.tong") }}</view>
		<view class="bg-white dark:bg-floor dark:text-white pb-100">	
<!-- 			<navigator url="/pages/mine/about" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("about.abt") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<navigator class="flex items-center px-40 py-30 justify-between text-lg" url="/pages/home/chat">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("new.lianxikefu") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator class="flex items-center px-40 py-30 justify-between text-lg" url="/pages/mine/helpCenter">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("new.jies") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator class="flex items-center px-40 py-30 justify-between text-lg" @click="topo(lang=='hk'?'bitstamp_zh.pdf':'bitstamp_en.pdf')">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("new.baip") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator class="flex items-center px-40 py-30 justify-between text-lg" @click="topo('prove_dlzm.pdf')">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("home.dlzm") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator class="flex items-center px-40 py-30 justify-between text-lg" @click="topo('certificate_zczs.pdf')">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("home.zczs") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator class="flex items-center px-40 py-30 justify-between text-lg" @click="topo('finance_jrpz.pdf')">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("home.jrpz") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator url="/pages/mine/workOrder" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("new.gongd") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<!-- <view class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-my-yellow border-solid">{{ $t("about.theme") }}</view>
				<switch @change="switchChange" :checked="theme == 'light' ? false : true"/>
			</view> -->
			
		</view>
	</view>

	<uni-popup v-if="false"  :show="announcementModal.showModal" @hidePopup="hideBtn" :closeBtn="true" :msg="announcementModal.title" :btnShow="announcementModal.tipbtnShow">
			<!-- <text class="w-full p-40" v-html="announcementModal.content">
				{{announcementModal.content}}
			</text> -->
			 <rich-text class="w-full p-40 h-700 overflow-auto" :nodes="announcementModal.content"></rich-text>
		</uni-popup>
 
  </view>
</template>

<script>
    const CryptoJS = require("crypto-js");	
	import {mapState} from 'vuex'
	import uniPopup from '@/components/uni-popup.vue';
	export default{
		components: {
			uniPopup
		},
		data(){
			return{
				token:'',
				info:{},
				active:1,
				lock:'',
				all:'',
				is_agent:true,
				total_profit: '****',
				lang:'en',
				announcementModal:{
				showModal: false,
				title: '',
				content: '',
				tipbtnShow: false
			}
			}
		},
		onLoad() {
			
			var token = uni.getStorageSync('token');
			if (token) this.getUserInfo();
			//this.setIcon()
			this.active=uni.getStorageSync('active')?uni.getStorageSync('active'):1
			this.getAgency();
		},
		methods:{
			getAnnouncement() {
			try {
				const that = this;
				that.$utils.initDataToken({
					url: "news/list?category_id=0"
				}, res => {
					if (res.data.length && res.data[0].content) {
						this.$set(this.announcementModal,'title', res.data[0].title);
						this.$set(this.announcementModal,'content', res.data[0].content);
						this.$set(this.announcementModal,'showModal', true);
					}
				});
			} catch (e) {
				console.log(e);
				//TODO handle the exception
			}
		},
		hideBtn(){
			this.announcementModal.showModal = false;
		},
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
			chat(){
				let that = this;
				 that.$utils.initDataToken({url:'user/info',type:'get'},res=>{
					  console.log(res)
						let visiter_name = '';
						if(res && res.uid)visiter_name = res.uid;
						const text = JSON.stringify({vipid:res.uid,name:res.uid})
						// const text = JSON.stringify({"phone": "17348088081", "vipid": "vipid", "name": "测试", "headimgurl": "http://127.0.0.1:8081/res/image.html?id=user%2F1da306311ef 4929774b39e26c0822719.png", "category": "一级", "vip": true, "email": "13115@qq.com"})
						const extradata = this.encrypt(text)
						const url = `https://5dtow1.com/chat/text/chat_158ohA.html?l=en&extradata=${extradata}&vipid=${res.uid}&name=${res.uid}`
						window.open(url,'_blank')
						// this.url=`https://links.nbkefu.com/index/index/home?visiter_id=${visiter_name}&visiter_name=${visiter_name}&avatar=&groupid=0&business_id=90`;
						// this.url=`https://links.niubikefu.com/index/index/kefu?u=62cda366c7ab3&uid=${visiter_name}&name=${visiter_name}`;

				  })
			},
			dow(){
				location.href=`/app`;
			},
			topo(name){
				// var lang = this.lang;
				//  if(lang == 'hk'){
				// 	  lang = 'zh'
				//  }else{
				// 	  lang = 'en'
				//  }
				window.open(`${this.$utils._DOMAIN}/wp/${name}`);
			},
			aetActive(val){
				uni.setStorageSync('active',val);
				this.active=val
			},
			//退出登录
			logout() {
				this.$utils.initDataToken({ url: 'user/logout', data: {}, type: 'post' }, (res, msg) => {
					uni.clearStorageSync();
					uni.setStorageSync('lang',this.lang);
					this.$utils.showLayer(msg);
					uni.navigateTo({
						url: '/pages/mine/login'
					})
				});
			},
			// 切换主题
			switchChange(e){
				var ui  = (this.theme == 'light') ? 'dark' : 'light';
				this.$store.dispatch("changeTheme",ui);
				this.$utils.setThemeTop(this.theme);
				this.$utils.setThemeBottom(this.theme);
				this.setIcon()
				if(this.theme == 'light'){
				  document.body.style.backgroundColor="#fff"
				}else{
				  document.body.style.backgroundColor="#171e26"
				}
			},
			getAgency(){
				try {
					const that = this;
					that.$utils.initDataToken({
						url: "commission/is_agent",
						type: "POST",
					}, res => {
						this.is_agent = res.is_agent;
					});
				} catch (e) {
					console.log(e);
					// TODO handle the exception
				}
			},
			setIcon(){
				if(this.theme=='light'){
									uni.setTabBarItem({
										index: 0,
									    iconPath : "static/footer/index2.png",
									});
									// uni.setTabBarItem({
									// 	index: 1,
									//     iconPath : "static/footer/hang2.png",
									// });
									uni.setTabBarItem({
										index: 1,
									    iconPath :"static/footer/trade2.png",
									});
									uni.setTabBarItem({
										index: 2,
									    iconPath : "static/footer/gang2.png",
									});
									// uni.setTabBarItem({
									// 	index: 3,
									//     iconPath :  "static/footer/gang2.png",
									// });
									uni.setTabBarItem({
										index: 3,
									    iconPath :  "static/footer/mine2.png",
									});
									uni.setTabBarItem({
										index: 4,
										iconPath :  "static/footer/me2.png",
									});
							}else{
								   uni.setTabBarItem({
								   	index: 0,
								   	iconPath : "static/footer/index0.png",
								   });
								//    uni.setTabBarItem({
								//    	index: 1,
								//    	iconPath : "static/footer/hang0.png",
								//    });
								   uni.setTabBarItem({
								   	index: 1,
								       iconPath :"static/footer/trade0.png",
								   });
								   uni.setTabBarItem({
								   	index: 2,
								   	iconPath : "static/footer/gang0.png",
								   });
								   // uni.setTabBarItem({
								   // 	index: 3,
								   // 	iconPath :  "static/footer/gang0.png",
								   // });
								   uni.setTabBarItem({
								   	index: 3,
								   	iconPath :  "static/footer/mine0.png",
								   });
								   uni.setTabBarItem({
								   	index: 4,
								   	iconPath :  "static/footer/me1.png",
								   });
							}
			},
			getUserInfo() {
				var that = this;
				this.$utils.initDataToken({ url: 'user/info', data: {}, type: 'get' }, (res, msg) => {
					uni.stopPullDownRefresh();
					uni.setStorageSync('uid', msg.id);
					that.info = res;
					});
			},
			getAssets() {
				this.$utils.initDataToken({url:'account/list'},res=>{
					if(res.length>0){
						this.total_profit = res[0].total_profit
						 let all=0
						 let lock=0
						 for(let key in res){
							 console.log(res[key])
							all+=parseFloat(res[key].convert_usd)
							lock+=parseFloat(res[key].convert_lock_usd)
						 }
						this.all=all
						this.lock=lock
						console.log(this.all)
						console.log(this.lock)
					}
				})
			}
		},
		onPullDownRefresh() {
			this.getAssets();
		},
		onShow() {
			this.lang = uni.getStorageSync('lang') || 'en';
			this.getAssets()
			this.token = uni.getStorageSync('token');
			this.$utils.setThemeTop(this.theme)
			this.$utils.setThemeBottom(this.theme)
			this.getAnnouncement()
		},
		computed:{
		   ...mapState(['theme']),
		},
	}
</script>
