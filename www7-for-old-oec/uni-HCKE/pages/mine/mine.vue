<template>
  <view :class="theme" >
	
	<uni-nav-bar fixed>
		<view class="w-full">
			<view class="w-full p-40 text-black bg-white dark:bg-floor dark:text-white">
				<view class="flex justify-between w-full">
					<navigator class="" :url="`/pages/mine/${token?'login':'userCenter'}`">
						<view class="text-lg">{{ token?(info.mobile || info.email || '- -'):$t("home.p_login") }}</view>
						<view class="text-lg">{{ token?(`UID: ${info.uid || '- -'}`):$t("home.welcome") }}</view>
					</navigator>
					<view class="flex flex-col">
						<view class="text-lg text-primary">LEVEL: {{ info.level || '- -' }}</view>
						<view  v-if="false" class="text-lg text-primary">{{ `${$t('home.credit')}: ${info.credit_score || '- -'}` }}</view>
					</view>
					<button type="primary" size="default" class="px-20 text-sm text-black bg-primary" @click="logout">
					  {{ $t("home.logout") }}
					</button>
				</view>
			</view>
			
			<view class="w-full px-20 pb-20 text-white bg-white dark:bg-floor">
				<view class="p-40 rounded-lg bg-mask dark:bg-gray-600">
					<view class="flex justify-between">
						<view class="text-2xl">{{ $t("new.mine") }}</view>
						<image src="/static/image/a.png" class="w-40 h-40" v-if="active == 1" @click="aetActive(2)"></image>
						<image src="/static/image/b.png" class="w-40 h-40" v-else @click="aetActive(1)"></image>
					</view>
					<view class="my-20">{{ $t("new.zichan") }} (USDT) </view>
					<view class="my-20 text-2xl">{{ active==1?(all?all.toFixed(2):all):'******' }} </view>
					<navigator url="/pages/assets/assets" open-type="switchTab" class="flex items-center justify-between">
						<view class="px-20 py-10 bg-deep-green rounded-3xl">
							{{active==1?(`${$t("new.keyong")} : ${all - lock}`):'****'}}
						</view>
						<image src="/static/image/mores.png" class="w-40 h-40"></image>
					</navigator>
				</view>
			</view>
		</view>
	</uni-nav-bar>
	
	<view class="pt-20 bg-white dark:bg-black pb-140">
		<view class="bg-white dark:bg-floor dark:text-white">
			<navigator v-if="token" url="/pages/home/recharge" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("new.chozhi") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/withdraw" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("new.zhuan") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/transfer" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("new.zhuanzhang") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token && false" url="/pages/mine/exchange" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("new.duih") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token && false" url="/pages/assets/legalWithdraw" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("new.fbtx") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
		</view>		
		<view class="bg-gray-100 dark:bg-transparent p-30">{{ $t("new.acctieon") }}</view>
		<view class="bg-white dark:bg-floor dark:text-white">	  
			<!-- <navigator v-if="token" url="/pages/mine/real_authentication" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("authentication.renzheng") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
		<!-- 	<navigator v-if="info.is_seller" url="/pages/legal/storeDetail" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("home.myshop") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<navigator v-if="token" :url="'/pages/mine/invite?code=' + info.invite_code" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("home.myshare") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<!-- <navigator url="/pages/mine/authorization_code" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("bind.codeauth") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<navigator url="/pages/mine/security" class="flex items-center justify-between px-40 text-lg py-30" >
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("login.security") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator url="/pages/assets/bindMentionAddress" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("bind.bindAddr") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
		<!-- 新币申购开放	<navigator url="/pages/assets/subscriptionRunning" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("assets.subscriptionRunning") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
				<!-- <navigator url="/pages/mine/collect" class="flex items-center justify-between px-40 text-lg py-30">
					<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("new.fa") }}</view>
					<image src="/static/image/mores.png" class="w-40 h-40"></image>
				</navigator> -->
		</view>	
		<view class="bg-gray-100 dark:bg-transparent p-30">{{ $t("new.tong") }}</view>
		<view class="bg-white dark:bg-floor dark:text-white">	
			<!-- <navigator url="/pages/mine/about" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("about.abt") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<navigator class="flex items-center justify-between px-40 text-lg py-30" @click="topo">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("new.baip") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator url="/pages/mine/workOrder" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("new.gongd") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<view v-if="false" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("about.theme") }}</view>
				<switch @change="switchChange" :checked="theme == 'light' ? false : true"/>
			</view>
			<view class="flex items-center justify-between px-40 text-lg py-30" @click="dow">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t("login.downApp") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</view>
			<navigator url="/pages/mine/policy" class="flex items-center justify-between px-40 text-lg py-30">
				<view class="flex items-center pl-20 border-0 border-l-8 border-solid border-primary">{{ $t('about.privat') }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
		</view>
	</view>
 
  </view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return{
				token:'',
				info:{},
				active:1,
				lock:'',
				all:''
			}
		},
		onLoad() {
			var token = uni.getStorageSync('token');
			if (token) {
				this.getUserInfo();
			}
			//this.setIcon()
			this.active=uni.getStorageSync('active')?uni.getStorageSync('active'):1
		},
		methods:{
			dow(){
				location.href=`/app`;
			},
			topo(){
				var lang = this.lang;
				 if(lang == 'hk'){
					  lang = 'zh'
				 }else{
					  lang = 'en'
				 }
				 console.log()
				window.open(`${this.$utils._DOMAIN}/wp/oec-${lang}.pdf`);
			},
			aetActive(val){
				uni.setStorageSync('active',val);
				this.active=val
			},
			//退出登录
			logout() {
				this.$utils.initDataToken({ url: 'user/logout', data: {}, type: 'post' }, (res, msg) => {
					let lang = uni.getStorageSync('lang') || 'en';
					uni.clearStorageSync();
					uni.setStorageSync('lang', lang);
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
			setIcon(){
				if(this.theme=='light'){
									uni.setTabBarItem({
										index: 0,
									    iconPath : "static/footer/index2.png",
									});
									uni.setTabBarItem({
										index: 1,
									    iconPath : "static/footer/hang2.png",
									});
									uni.setTabBarItem({
										index: 2,
									    iconPath :"static/footer/trade2.png",
									});
									uni.setTabBarItem({
										index: 3,
									    iconPath : "static/footer/gang2.png",
									});
									// uni.setTabBarItem({
									// 	index: 3,
									//     iconPath :  "static/footer/gang2.png",
									// });
									uni.setTabBarItem({
										index: 4,
									    iconPath :  "static/footer/mine2.png",
									});
									uni.setTabBarItem({
										index: 5,
										iconPath :  "static/footer/me2.png",
									});
							}else{
								   uni.setTabBarItem({
								   	index: 0,
								   	iconPath : "static/footer/index0.png",
								   });
								   uni.setTabBarItem({
								   	index: 1,
								   	iconPath : "static/footer/hang0.png",
								   });
								   uni.setTabBarItem({
								   	index: 2,
								       iconPath :"static/footer/trade0.png",
								   });
								   uni.setTabBarItem({
								   	index: 3,
								   	iconPath : "static/footer/gang0.png",
								   });
								   // uni.setTabBarItem({
								   // 	index: 3,
								   // 	iconPath :  "static/footer/gang0.png",
								   // });
								   uni.setTabBarItem({
								   	index: 4,
								   	iconPath :  "static/footer/mine0.png",
								   });
								   uni.setTabBarItem({
								   	index: 5,
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
			this.getAssets()
			this.token = uni.getStorageSync('token');
			this.$utils.setThemeTop(this.theme)
			this.$utils.setThemeBottom(this.theme)
		},
		computed:{
		   ...mapState(['theme']),
		},
	}
</script>
