<template>
  <view :class="theme">
	<view class="bg-white dark:bg-default-black">

	<uni-nav-bar>
		<view class="w-full bg-my-grey dark:bg-default-black">
			<view class="w-full bg-white dark:bg-main-black p-30">
				<view class="w-full flex justify-between">
					<navigator class="" :url="`/pages/mine/${token?'login':'userCenter'}`">
						<view class="text-sm text-333333 dark:text-white">{{ token?(info.email || '- -'):$t("home.p_login") }}</view>
						<view class="text-sm text-333333 dark:text-white">{{ token?(`UID: ${info.uid || '- -'}`):$t("home.welcome") }}</view>
					</navigator>
					<view class="flex flex-col">
						<view class="text-sm text-new-orange">{{ info.level || '- -' }}</view>
						<view class="text-sm text-new-orange">{{ `${$t('home.credit')}: ${info.credit_score || '- -'}` }}</view>
					</view>
					<button type="primary" size="default" class="text-sm px-20 bg-new-orange text-black rounded-10" @click="logout">
					  {{ token? $t("home.logout"):$t("login.login") }}
					</button>
				</view>
			</view>
			
			<view class="mt-20 w-full px-20 pb-20">
				<view class="bg-new-orange rounded-lg p-40">
					<view class="flex justify-between">
						<view class="text-xl font-bold text-black dark:text-black">{{ $t("new.mine") }}</view>
						<image src="/static/image/a.png" class="w-40 h-40" v-if="active == 1 && token" @click="aetActive(2)"></image>
						<image src="/static/image/b.png" class="w-40 h-40" v-else @click="aetActive(1)"></image>
					</view>
					<view class="my-20 text-xs text-white dark:text-black">{{ $t("new.zichan") }} (USDT) </view>
					<view class="text-white dark:text-black text-lg my-20">{{ active==1 && token?(all?all.toFixed(2):all):'******' }} </view>
					<navigator url="/pages/assets/assets" open-type="switchTab" class="flex justify-between items-center">
						<view class="rounded-3xl px-20 py-10 text-black" :class="[theme=='dark'?'dark:bg-white':'bg-white']">
							{{active==1 && token?(`${$t("new.keyong")} : ${all - lock}`):'****'}}
						</view>
						<image src="/static/image/mores.png" class="w-40 h-40"></image>
					</navigator>
				</view>
			</view>
		</view>
	</uni-nav-bar>
	
	<view class="bg-white dark:bg-main-black pb-180 dark:text-white">
		<view class="px-30">
			<navigator v-if="token" url="/pages/home/recharge" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("new.chozhi") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/withdraw" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("new.zhuan") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/transfer" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("new.zhuanzhang") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/exchange" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("new.duih") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
		</view>		
		<view class="py-30 bg-my-grey dark:bg-default-black text-333333 dark:text-white text-sm px-30">{{ $t("new.acctieon") }}</view>
		<view class="px-30">	  
			<!-- <navigator v-if="token" url="/pages/mine/real_authentication" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">{{ $t("authentication.renzheng") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
		<!-- 	<navigator v-if="info.is_seller" url="/pages/legal/storeDetail" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">{{ $t("home.myshop") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<navigator v-if="token" :url="'/pages/mine/invite?code=' + info.invite_code" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("new.wdtg") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<!-- <navigator url="/pages/mine/authorization_code" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("bind.codeauth") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<navigator url="/pages/mine/security" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black" >
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("login.security") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator url="/pages/assets/bindMentionAddress" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("bind.bindAddr") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
		<!-- 新币申购开放	<navigator url="/pages/assets/subscriptionRunning" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">{{ $t("assets.subscriptionRunning") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
				<!-- <navigator url="/pages/mine/collect" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
					<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("new.fa") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
				</navigator> -->
		</view>	
		<view class="py-30 bg-my-grey dark:bg-default-black text-333333 dark:text-white text-sm px-30">{{ $t("new.tong") }}</view>
		<view class="px-30">	
			<!-- <navigator url="/pages/mine/about" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">{{ $t("about.abt") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<navigator class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black" @click="topo">
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("new.baip") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator url="/pages/mine/workOrder" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("new.gongd") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<!-- <view class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black">
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("about.theme") }}</view>
				</view>
				<switch @change="switchChange" :checked="theme == 'light' ? false : true"/>
			</view> -->
			<view v-if="download" class="flex items-center py-30 justify-between text-lg border-0 border-solid border-b-2 border-EEEEEE dark:border-default-black" @click="dow">
				<view class="flex items-center">
					<view class="w-6 h-26 mr-20 bg-new-orange"></view>
					<view class="text-333333 dark:text-white text-sm">{{ $t("login.downApp") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</view>
		</view>
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
				all:'',
				download:true
			}
		},
		onLoad() {
			//this.setIcon()
			if(window.flutter_inappwebview){
				this.download = false
			}
			this.active=uni.getStorageSync('active')?uni.getStorageSync('active'):1
		},
		methods:{
			dow(){
				location.href=`/app`;
			},
			topo(){
				var lang=uni.getStorageSync('lang') || 'en';
				 if(lang == 'hk'){
					  lang = 'zh'
				 }else{
					  lang = 'en'
				 }
				window.open(`${this.$utils._DOMAIN}/wp/DEMO.pdf`);
			},
			aetActive(val){
				if(!this.token){
					return
				}
				uni.setStorageSync('active',val);
				this.active=val
			},
			//退出登录
			logout() {
				if(!this.token){
					uni.navigateTo({
						url: '/pages/mine/login'
					})
					return
				}
				this.$utils.initDataToken({ url: 'user/logout', data: {}, type: 'post' }, (res, msg) => {
					var lang=uni.getStorageSync('lang') || 'hk';
					uni.clearStorageSync();
					uni.setStorageSync('lang',lang)
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
			this.token = uni.getStorageSync('token');
			console.log(this.token ,222);
			if (this.token) {
				this.getUserInfo();
			    this.getAssets()
			}
			this.$utils.setThemeTop(this.theme)
			this.$utils.setThemeBottom(this.theme)
		},
		computed:{
		   ...mapState(['theme']),
		},
	}
</script>
