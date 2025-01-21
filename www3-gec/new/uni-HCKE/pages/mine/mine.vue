<template>
  <view :class="theme" >
	
	<uni-nav-bar>
		<view class="w-full">
			<view class="text-center text-2xl" style="height:88rpx;line-height:88rpx;">{{$t('new.mi')}}</view>
			<view class="w-full p-40">
				<view class="w-full flex justify-between items-center">
					<view class="" :url="`/pages/mine/${token?'login':'userCenter'}`">
						<view class="text-3xl">{{ token?(info.mobile || info.email || '- -'):$t("home.p_login") }}</view>
						<view class="text-base mt5">{{ token?(`UID: ${info.uid || '- -'}`):$t("home.welcome") }}</view>
					    <view class="mt5">{{ $t('home.credit') }} :{{info.credit_score}}</view>
					</view>
					<!-- <navigator class="" :url="`/pages/mine/${token?'login':'userCenter'}`">
						<view class="text-lg">{{ token?(info.mobile || info.email || '- -'):$t("home.p_login") }}</view>
						<view class="text-lg">{{ token?(`UID: ${info.uid || '- -'}`):$t("home.welcome") }}</view>
					</navigator> -->
					<!-- <view class="flex flex-col">
						<view class="text-lg text-primary">{{ info.level || '- -' }}</view>
						<view class="text-lg text-primary">{{ `${$t('home.credit')}: ${info.credit_score || '- -'}` }}</view>
					</view> -->

					<view class="text-sm px-20 h-52 leading-52 border-2 border-solid border-my-orange text-my-orange rounded-2xl" @click="logout">
					  {{ $t("home.logout") }}
					</view>
				</view>
			</view>
			
			<view class="w-690 mx-auto bg-cover bg-no-repeat border-solid border-2 border-primary rounded-default mb-30" style="height:290rpx;">
				<view class="p-40">

					<navigator url="/pages/assets/assets" class="">
					<view class="flex justify-between items-center border-0 border-solid border-b-2 pb-20" style="border-color:rgba(255, 255, 255, 0.2)">
						<view class="flex items-center">
							<view class="text-xl">{{ $t("new.mine") }}</view>
							<view class="text-base ml-36">{{ $t("new.zichan") }} (USDT) </view>
						</view>
						<image src="/static/image/mores.png" class="w-40 h-40"></image>
					</view>
					</navigator>
					<view class="flex items-center justify-between mt-20">
						<view>
							<view class="text-2xl my-20">{{ active==1?(all?all.toFixed(2):all):'******' }} </view>
							<view class="bg-my-orange rounded-3xl px-20 py-10">
								{{active==1?(`${$t("new.keyong")} : ${all - lock}`):'****'}}
							</view>
						</view>
						<image src="/static/image/a.png" class="w-40 h-40" v-if="active == 1" @click="aetActive(2)"></image>
						<image src="/static/image/b.png" class="w-40 h-40" v-else @click="aetActive(1)"></image>
					</view>
				</view>
			</view>
		</view>
	</uni-nav-bar>
	
	<view class="pt-30 pb-100 px-30">
		<view class="bg-my-gray rounded-xl px-30">
			<navigator v-if="token" url="/pages/home/recharge" class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)">
				<view class="flex items-center">
					<image src="/static/image/us.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("new.chozhi") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/withdraw" class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)">
				<view class="flex items-center">
					<image src="/static/image/icon_tb.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("new.zhuan") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<!-- <navigator v-if="token" url="/pages/mine/transfer" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("new.zhuanzhang") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<div v-if="token" @click="transfer"  class="flex items-center py-30 justify-between">
				<view class="flex items-center">
					<image src="/static/image/icon_zh.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("assets.transfer") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</div>
			<navigator v-if="token" url="/pages/mine/exchange" class="flex items-center py-30 justify-between " style="border-color:rgba(255, 255, 255, 0.2)">
				<!-- <view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("new.duih") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image> -->
					<view class="flex items-center">
					<image src="/static/image/qweqwekkk.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("new.duih") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
		</view>		
		<view class="pt-50 pb-30 text-xl">{{ $t("new.acctieon") }}</view>
		<view class="bg-my-gray rounded-xl px-30">
			<navigator v-if="token" url="/pages/mine/real_authentication" class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)">
				<view class="flex items-center">
					<image src="/static/image/icon_yhrz.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("authentication.renzheng") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/security" class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)">
				<view class="flex items-center">
					<image src="/static/image/icon_xgmm.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("login.e_pwd") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" url="/pages/mine/collect" class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)">
				<view class="flex items-center">
					<image src="/static/image/icon_skzh.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("new.fa") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator v-if="token" :url="'/pages/mine/invite?code=' + info.invite_code" class="flex items-center py-30 justify-between">
				<view class="flex items-center">
					<image src="/static/image/icon_wyfx.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("home.myshare") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
		<!-- 	<navigator v-if="info.is_seller" url="/pages/legal/storeDetail" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("home.myshop") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<!-- <navigator v-if="token" :url="'/pages/mine/invite?code=' + info.invite_code" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("home.myshare") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<!-- <navigator url="/pages/mine/authorization_code" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("bind.codeauth") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator url="/pages/mine/security" class="flex items-center px-40 py-30 justify-between text-lg" >
				<view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("login.security") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator url="/pages/assets/bindMentionAddress" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("bind.bindAddr") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
		<!-- 新币申购开放	<navigator url="/pages/assets/subscriptionRunning" class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("assets.subscriptionRunning") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
				<!-- <navigator url="/pages/mine/collect" class="flex items-center px-40 py-30 justify-between text-lg">
					<view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("new.fa") }}</view>
					<image src="/static/image/mores.png" class="w-40 h-40"></image>
				</navigator> -->
		</view>	
		<view class="pt-50 pb-30 text-xl">{{ $t("new.tong") }}</view>
		<view class="bg-my-gray rounded-xl px-30 mb-30">	
			<navigator url="/pages/home/chatBtn" class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)">
				<view class="flex items-center">
					<image src="/static/image/bzzx.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{$t('home.news')}}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<navigator url="/pages/mine/about" class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)">
				<view class="flex items-center">
					<image src="/static/image/icon_gywm.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("about.abt") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<!-- <view class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)" @click="topo">
				<view class="flex items-center">
					<image src="/static/image/baip.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("new.baip") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</view> -->
			<view class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)" @click="dow">
				<view class="flex items-center">
					<image src="/static/image/download-app.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("login.downApp") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</view>
			<navigator url="/pages/mine/workOrder" class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)">
				<view class="flex items-center">
					<image src="/static/image/tjgd.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("new.gongd") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<!-- <view class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)" @click="connectWallet()">
				<view class="flex items-center">
					<image src="/static/image/bdtbdz.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{$t("new.connectWallet")}}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</view> -->
			<!-- <navigator url="/pages/mine/authorization_code" class="flex items-center py-30 justify-between border-0 border-solid border-b-2" style="border-color:rgba(255, 255, 255, 0.2)">
				<view class="flex items-center">
					<image src="/static/image/wdsqm.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("bind.codeauth") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator> -->
			<navigator url="/pages/assets/bindMentionAddress" class="flex items-center py-30 justify-between">
				<view class="flex items-center">
					<image src="/static/image/bdtbdz.png" class="w-46 h-46"></image>
					<view class="ml-28 text-lg">{{ $t("bind.bindAddr") }}</view>
				</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<!-- <navigator class="flex items-center px-40 py-30 justify-between text-lg" @click="topo">
				<view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("new.baip") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</navigator>
			<view class="flex items-center px-40 py-30 justify-between text-lg">
				<view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("about.theme") }}</view>
				<switch @change="switchChange" :checked="theme == 'light' ? false : true"/>
			</view>
			<view class="flex items-center px-40 py-30 justify-between text-lg" @click="dow">
				<view class="flex items-center pl-20 border-0 border-l-8 border-primary border-solid">{{ $t("login.downApp") }}</view>
				<image src="/static/image/mores.png" class="w-40 h-40"></image>
			</view> -->
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
				bid:'',
				lang:''
			}
		},
		onLoad() {
			var token = uni.getStorageSync('token');
			if (token) {
				this.getUserInfo();
			}
			uni.setNavigationBarTitle({
				title: this.$t('new.mi')
			});
			//this.setIcon()
			this.active=uni.getStorageSync('active')?uni.getStorageSync('active'):1
		},
		methods:{
			dow(){
				location.href=`/app`;
			},
			aetActive(val){
				uni.setStorageSync('active',val);
				this.active=val
			},
			//退出登录
			logout() {
				const lang=uni.getStorageSync('lang') || 'hk';
				this.$utils.initDataToken({ url: 'user/logout', data: {}, type: 'post' }, (res, msg) => {
					uni.clearStorageSync();
					uni.setStorageSync('lang',lang)
					this.$utils.showLayer(msg);
					uni.navigateTo({
						url: '/pages/mine/login'
					})
				});
			},
			connectWallet(){
				window.open(`${this.$utils._DOMAIN}/connectWallet`);
			},
			transfer(){
				uni.navigateTo({
					url: `/pages/mine/transfer`
				})
			},
			// url="/pages/assets/transfer?accountTypeId=1&id=1&account_code=change_account"
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
				  document.body.style.backgroundColor="#111111"
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
										iconPath :  "static/footer/me2.png",
									});

									uni.setTabBarItem({
										index: 5,
									    iconPath :  "static/footer/mine2.png",
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
								   	iconPath :  "static/footer/me1.png",
								   });
								   uni.setTabBarItem({
								   	index: 5,
								   	iconPath :  "static/footer/mine0.png",
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
							 if(res[key].id==1){
								const tar = res[key].accounts.find((item)=>item.currency_code=="USDT")
								if(tar){
									this.bid = tar.id
								}
							 }
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
			},
			topo(){
			var lang = this.lang;
			 if(lang == 'hk'){
				  lang = 'tw'
			 }else{
				  lang = 'en'
			 }
			window.open(`${this.$utils._DOMAIN}/wp/white-wp-${lang}.pdf`);
			// let winOpen = window.open("", "_blank");
			// let url ="/wp/LME_English.pdf"
			// setTimeout(()=>{
			// 			 winOpen.location = url;
			// })
		},
		},
		onPullDownRefresh() {
			this.getAssets();
		},
		onShow() {
			this.getAssets()
			this.token = uni.getStorageSync('token');
			this.$utils.setThemeTop(this.theme)
			this.$utils.setThemeBottom(this.theme)
			this.lang = localStorage.getItem('lang') || 'hk';
			// this.$nextTick(()=>{
			// 	uni.setNavigationBarTitle({
			// 		title: this.$t('new.mi')
			// 	});
			
			// })
		},
		computed:{
		   ...mapState(['theme']),
		},
	}
</script>
