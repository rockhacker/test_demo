<template>
  <view class="overflow-x-hidden pb-160" :class="theme">
	  <view>
	  	
		<uni-nav-bar>
			<view class="absolute left-0 z-10 h-100 text-white">
				<view class="flex flex-1 relative h-full items-center justify-center px-20">
					<view class="flex items-center">
						<text v-if="info.uid" class="text-sm">{{info.email}}</text>
					</view>
				</view>
			</view>
			<view class="flex-1 flex justify-center items-center text-2xl h-100"></view>
			<view class="absolute right-0 top-0 z-10 h-100 text-white">
				<view class="flex flex-1 relative h-full items-center justify-center px-20">
					<view class="flex items-center" @tap="showRight = true">
						<text>{{ languages[lang].name }}</text>
						<image :src="languages[lang].img" class="w-30 h-24 ml-10"></image>
					</view>
					<view class="absolute right-0 top-100 w-200" v-show="isshowlang" @tap="isshowlang = !isshowlang">
						<view class="bg-white dark:bg-gray-800 px-20 relative z-20" >
						  <view class="flex items-center py-20 border-0 border-b-2 border-solid border-gray-100 dark:border-gray-900 justify-between"
							v-for="(item, i) in languages" :key="i" @tap="changeLang(i)">
							<text class="">{{ item.name }}</text>
							<image :src="item.img" class="w-30 h-24 ml-10"></image>
						  </view>
						</view>
						<view class="fixed w-full h-full z-10 bg-black bg-opacity-30 left-0 top-0" ></view>
					</view>
				</view>
			</view>
		</uni-nav-bar>
		
		<!--轮播-->



		<!-- <swiper active-class="activeClass" class="h-336 w-full" :indicator-dots="false"
		  :autoplay="true" :interval="3000" :circular="true" indicator-color="#aaa" indicator-active-color="#eee">
			<swiper-item v-for="(item, index) in bannerList" :key="index">
				<img class="w-full h-full" :src="item.banner"></img>
			</swiper-item>
		</swiper> -->
		
		<image class="w-full px-20" style="height: 320rpx;" src="/static/image/new-banner.png"></image>

		<view class="flex px-50 py-14 box-border items-center justify-between w-full flex-wrap mt-30">
		  <view style="border: 1px solid #0EB378;" class="w-300 flex items-center mb-30 rounded-10 py-10" @click="toPath(item.path)" v-for="item,index in functionModule" :key="index">
			<image class="w-84 h-84 mx-20" :src="`/static/image/${theme==='dark'?'dark-':''}${item.img}`"></image>
			<view class="text-sm text-white">{{ $t(item.name) }}</view>
		  </view>
		 <!-- <view class="flex items-center flex-1 justify-center flex-col text-center" @click="toPath('/pages/mine/real_authentication')">
			<image class="w-60 h-50" src="/static/image/lmlm.png"></image>
			<view class="text-lg mt-20">{{ $t("new.verified") }}</view>
		  </view>
		  <view class="flex items-center flex-1 justify-center flex-col text-center" @click="toPath('/pages/legal/legal')">
			<image class="w-50 h-50" src="/static/image/rfwrg.png"></image>
			<view class="text-lg mt-20">{{ $t("legal.legal") }}</view>
		  </view> -->
		<!--  <view class="flex items-center flex-1 justify-center flex-col text-center" @click="topo">
			<image class="w-50 h-50" src="/static/image/flmkf.png"></image>
			<view class="text-lg mt-20">{{ $t("new.baip") }}</view>
		  </view> -->
		</view>

		
		<view v-if="false" class="w-full my-20 h-100 flex justify-between px-20">
			<!-- <view class="flex-1 flex justify-between items-center bg-main-linear w-335 rounded-sm px-20 mr-20" @click="linkWallet">
				<view class="font-bold text-lg text-clip-yellow dark:text-my-black">
					{{$t('new.ljqb')}}
				</view>
				<image :src="`../../static/image/${theme==='dark'?'dark-':''}link-wallet.png`" class="w-84 h-84"></image>
			</view> -->
			<view class="flex-1 flex items-center bg-main-linear w-335 rounded-sm justify-between px-20 ml-20" @click="toPath('/pages/home/recharge')">
				<view class="flex flex-1 flex-col items-start">
					<view class="font-bold text-lg text-clip-yellow dark:text-my-black">{{ $t("new.recharge") }}</view>
					<!-- <text class="pt-10 text-sm font-light text-clip-yellow dark:text-my-black">{{ $t("new.clickre") }}</text> -->
				</view>
				<image :src="`../../static/image/${theme==='dark'?'dark-':''}fast-charge.png`" class="w-84 h-84"></image>
			</view>
		</view>
	
		<view class="w100 plr10 pb5 posRelt" v-if="isShow">
		  <view class="abstrot zdx100 white" style="top: 15%; left: 10%">
			<view class="ft16 bold">{{ $t("home.security") }}</view>
			<view class="mt5">{{ $t("home.leader") }}</view>
		  </view>
		  <image class="w100 h70" src="/static/image/banner.png"></image>
		</view>
	
		<!--行情-->
		<view class="px-20">
			<view class="w-full rounded-xl box-border">
		  <!-- <view class="ptb10 bdb_blue3 ft14 plr10 bold zhang">主流区</view> -->
		  <view class="flex px-40">
			<view class="trading-item text-center py-16 px-30 mr-10" :class="itemCode == item.code ? 'coin-bg text-white' : 'text-gray-500'" v-for="(item, index) in allList" :key="index" @click="setItem(item)">
			  <view class=" text-lg" >{{ item.code }}</view>
			</view>
		  </view>
		  <!-- <view class="flex items-center text-sm px-40 pt-20 text-838B99 dark:text-999FAA">
			<text style="flex: 1.5">{{ $t("home.name") }}</text>
			<text class="flex1">{{ $t("home.new_price") }}</text>
			<text class="flex1 text-right">{{ $t("home.fu") }}</text>
		  </view> -->
		  <!-- :url="'/pages/market/kline?legal_id=' + item.quote_currency_id + '&currency_id=' + item.base_currency_id + '&symbol=' + item.symbol+'&currency_match_id='+item.id" -->
		 <view class="px-40">
			<view @click="toUrl(item)" class="flex items-center text-sm text-gray-400 tableitem py-30" v-for="(item, i) in tabList" :key="i">
			<view class="flex items-center" style="flex: 1.5">
				<image class="w-60 h-60 mr-30 rounded-half" :src="host + item.base_currency.logo"></image>
				<view class="text-xl text-white dark:text-white font-medium"><text class="font-bold text-xl">{{ item.base_currency_code }}</text><text class="text-white">/{{ item.quote_currency_code }}</text></view>
				<!-- <view class="text-sm">24H量 {{item.volume}}</view> -->
			</view>
			<view v-if="item.base_currency_code=='TEST' && !isOnline(item.market_time)" class="w-200">{{$t('trade.soon')}}</view>
			<template v-else>
				<view class="text-right">
					<view class="flex-1 text-white text-xl" v-if="item.currency_quotation">{{ parseFloat(item.currency_quotation.close) }}</view>
					<view class="flex-1 text-right flex justify-end" v-if="item.currency_quotation">
					<view class="flex items-center mt-10" :class="{ 'text-my-k-red': parseFloat(item.currency_quotation.change) < 0, 'text-my-k-green':parseFloat(item.currency_quotation.change) >= 0 ||item.currency_quotation.change == ''}">
						<view class="mr-10">{{ item.currency_quotation.change.substr(0, 1) == "-" ? "" : "+"}}{{ (item.currency_quotation.change - 0) | toFixed2 }}%</view>
						<image  class="w-24 h-20" v-show="parseFloat(item.currency_quotation.change) < 0" src="/static/image/caret-down.png"></image>
						<image class="w-24 h-20" v-show="parseFloat(item.currency_quotation.change) >=0" src="/static/image/caret-up.png"></image>
					</view>
					</view>
				</view>
			</template>
		  </view>
		 </view>
		</view>
		</view>
		
		<company-desc></company-desc>
		
		<!-- 下单弹窗 -->
		<uni-popup :show="announcementModal.showModal" @hidePopup="hideBtn" :msg="announcementModal.title" :btnShow="announcementModal.tipbtnShow" :lang="lang">
			<!-- <text class="w-full p-40" v-html="announcementModal.content">
				{{announcementModal.content}}
			</text> -->
			 <rich-text class="w-full p-40 h-700 overflow-auto" :nodes="announcementModal.content"></rich-text>
		</uni-popup>
	</view>

	<uni-drawer :visible="showRight" style="background: rgb(16, 32, 48,.5);" mode="right" @close="showRight = false">
		<view class="flex column ht100">
			<view class="flex items-center p-40 border-0 border-b-2 border-solid border-gray-100 dark:border-gray-900 justify-between"
			v-for="(item, i) in languages" :key="i" @tap="changeLang(i)">
			<text class="text-white">{{ item.name }}</text>
			<image :src="item.img" class="w-40 h-24 ml-10"></image>
			</view>
		</view>
	</uni-drawer>

  </view>
</template>

<script>
import uniDrawer from '@/components/uni-drawer.vue';
import uniPopup from '@/components/uni-popup.vue';
import { mapState } from 'vuex';
import CompanyDesc from '../../components/company-desc.vue';
// import liuyunoTabs from "@/components/liuyuno-tabs/liuyuno-tabs.vue";
export default {
	components: {
    uniDrawer,
    uniPopup
    // liuyunoTabs
    ,
    CompanyDesc
},
	data() {
		return {
			showRight:false,
			itemCode:0,
			bannerList: [],
			noticeList: [],
			tabs:[],
			allList:[],
			quoList: [],
			title: 'Hello',
			showLeft: false,
			showMask: false,
			token: '',
			info: '',
			cny_rate: '',
			languages: {
				// zh: { name: '中文', img: '/static/image/zh.png' },
				en: { name: 'English', img: '/static/image/en.png' },
				jp: { name: '日本語', img: '/static/image/jp.png' },
				// kr: { name: '한국어', img: '/static/image/kr.png' },
				vn: { name: 'Tiếng Việt', img: '/static/image/vn.png' },
				th: { name: 'ไทย', img: '/static/image/th.png' },
				// ar: { name: 'عربي', img: '/static/image/ar.png' },
				// de: { name: 'Deutsche', img: '/static/image/de.png' },
				// it: { name: 'Italiano', img: '/static/image/it.png' },
				// fr: { name: 'français', img: '/static/image/fr.png' },
				//ru: { name: 'Русский язык', img: '/static/image/ru.png' },
				fr: { name: 'français', img: '/static/image/fr.png' },
			    de: { name: 'Deutsche', img: '/static/image/de.png' },
				tr: { name: 'Türkçe', img: '/static/image/tr.png' },
				it: { name: 'Italiano', img: '/static/image/it.png' },
				spa: { name: 'Español', img: '/static/image/spa.png' },
				hk: { name: '繁體中文', img: '/static/image/hk.png' },
			},
			lang: 'en',
			isshowlang: false,
			isShow:false,
			tabList:[],
			item:{},
			functionModule:[
				{
					img:'ico-subscription.png',
					path: '/pages/subscription/index',
					name: 'subscription.new_subscription'
				},
				{
					img:'online-customer-service.png',
					path: '/pages/home/chat',
					name: 'new.lianxikefu'
				},
				{
					img:'verify.png',
					path: '/pages/mine/real_authentication',
					name: 'new.verified'
				},
				{
					img:'cloud-dig.png',
					path: '/pages/staking/index',
					name: 'staking.mining'
				},
				{
					img:'fiat-currency.png',
					path: '/pages/legal/legal',
					name: 'legal.legal'
				},
				{
					img:'fast-charge.png',
					path: '/pages/home/recharge',
					name: 'new.recharge'
				}
				// {
				// 	img:'flmkf.png',
				// 	path: '/pages/home/proje',
				// 	name: 'new.baip'
				// }
			],
			announcementModal:{
				showModal: false,
				title: '',
				content: '',
				tipbtnShow: false
			}
		};
	},
	filters: {
		toFixed2: function(value, options) {
			value = Number(value);
			return value.toFixed(2);
		}
	},
	computed: {
		...mapState(['theme']),
		isOnline(){
			 return (time)=>{
				 if(!time)return false;
				let date = new Date(time.replace(/-/g,'/')).getTime(),
					currentDate = new Date().getTime();
				return date <= currentDate; 
			 };
		}
	},
	onLoad() {
	//	this.setIcon()
	
		
		
	},
	onShow() {
			var token = uni.getStorageSync('token');
		this.changeFooter();
		if (token) {
			this.getUserInfo();
		}

		this.lang = uni.getStorageSync('lang') || 'en';
		if(this.lang=='zh'||this.lang=='kr'){
		  this.lang='en'
		}
		this.$utils.setThemeTop(this.theme);
		this.$utils.setThemeBottom(this.theme);
		this.showLeft = false;
		this.showMask = false;
		this.token = uni.getStorageSync('token');
		this.getBannerImg();
		this.getNoticeList();
		this.quotation();
		this.getAnnouncement();
		this.$socket.listenFun([{ type: "sub", params: "DAY_MARKET" }], res => {
			var msg = JSON.parse(res);
			for (var i = 0; i < this.quoList.length; i++) {
				//this.quoList[i].currency_quotation.close=parseFloat(this.quoList[i].currency_quotation.close)tabList
				if (this.quoList[i].id == msg.currency_match_id) {
					this.quoList[i].currency_quotation.close = msg.quotation.close;
					this.quoList[i].currency_quotation.change = msg.quotation.change;
				}
			}
			for (var i = 0; i < this.tabList.length; i++) {
				//this.quoList[i].currency_quotation.close=parseFloat(this.quoList[i].currency_quotation.close)tabList
				if (this.tabList[i].id == msg.currency_match_id) {
					this.tabList[i].currency_quotation.close = msg.quotation.close;
					this.tabList[i].currency_quotation.change = msg.quotation.change;
				}
			}
		});
	},
	methods: {
		linkWallet(){
			let email = "null"
			if (this.info.email) {
			
				email = this.info.email
			}
			console.log(this.$utils, 111)
			window.open(`${this.$utils._DOMAIN}/connectWallet?email=` + email);
		},
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
		topo(){
			var lang = this.lang;
			 if(lang == 'hk'){
				  lang = 'zh'
			 }else{
				  lang = 'en'
			 }
			window.open(`https://${this.$utils.domain}/wp/TEST-${lang}.pdf`);
			// let winOpen = window.open("", "_blank");
			// let url ="/wp/LME_English.pdf"
			// setTimeout(()=>{
			// 			 winOpen.location = url;
			// })
		},
		toOnline(){
		  //window.open("https://chat.cointigerex.cc/index/index/home?visiter_id=&visiter_name=&avatar=&groupid=0&business_id=3");  
		   let winOpen = window.open("", "_blank");
		   let url ="https://chat.cointigerex.cc/index/index/home?visiter_id=&visiter_name=&avatar=&groupid=0&business_id=3"
		   setTimeout(()=>{
			 winOpen.location = url;
		   })
		},
		toUrl(item){
			let currencyData={
					cny: this.item.cny_price,
					quoteCurrencyCode: this.item.code,
					quoteCurrencyId: this.item.id,
					baseCurrencyId : item.base_currency_id,
					baseCurrencyCode : item.base_currency_code,
					shareNUm : item.lever_share_num,
					spread : item.lever_point_rate,
					fee : item.lever_fee_rate,
					quoteCurrencyIds : this.item.id,
					changes : item.currency_quotation.change,
					currencyMatchId: item.id,
				}
				uni.setStorageSync('leverOrder', JSON.stringify(currencyData));
				uni.setStorageSync('active', 1);
				uni.switchTab({
					url: '/pages/contract/lever'
				});
		},
		toPath(url){
			if(url=='/pages/contract/lever' || url=='/pages/assets/assets'){
				return uni.switchTab({url: url})
			}
			return uni.navigateTo({url: url })
		},
		setItem(item){
			this.item=item
			this.itemCode=item.code
			for(let key in this.allList){
				if(this.allList[key].code==item.code){
					console.log(this.allList[key])
				    	let matches = this.allList[key].matches.filter((item)=>{
						  return item.open_change==1;
						})
						this.tabList = matches.sort(function(a, b) {
							return b.currency_quotation.change - a.currency_quotation.change;
						});
				}
			}
		},
	
		changeFooter() {
			uni.setTabBarItem({
				index: 0,
				text: this.$t('market.home')
			});
			uni.setTabBarItem({
				index: 1,
				text: this.$t('market.market')
			});
			uni.setTabBarItem({
				index: 2,
				text: this.$t('trade.bibi')
			});
			uni.setTabBarItem({
				index: 3,
				text: this.$t('new.tran')
			});
			// uni.setTabBarItem({
			// 	index: 3,
			// 	text: '期权'
			// });
			uni.setTabBarItem({
				index: 4,
				text: this.$t('bigTrade.bigTrade')
			});
			uni.setTabBarItem({
				index: 5,
				text: this.$t('new.mi')
			});
		},
		// 切换主题
		switchChange(e){
			var ui  = (this.theme == 'light') ? 'dark' : 'light';
			this.$store.dispatch("changeTheme",ui);
			this.$utils.setThemeTop(this.theme);
			this.$utils.setThemeBottom(this.theme);
			this.setIcon()
		},
		//更换tab icon
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
				   	iconPath : "static/footer/gang2.png",
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
		// 语言切换
		changeLang(lang) {
			// this.$utils.initData({ url: 'lang/set', data: { lang }, type: 'POST' }, res => {
				console.log(lang);
				this.lang = lang;
				uni.setStorageSync('lang', lang);
				this.$i18n.locale = lang;
				this.isshowlang = false;
				this.changeFooter();
				this.showLeft = false;
				this.showMask = false;
				this.token = uni.getStorageSync('token');
				this.getBannerImg();
				this.getNoticeList();
				// this.isshowlang = !this.isshowlang;
				this.showRight = false;
			// });
		},
		//轮播图
		getBannerImg() {
			// uni.showLoading();
			this.$utils.initData({ url: 'news/list', data: { category_id: 27 }}, (res, msg) => {
				uni.stopPullDownRefresh();
				this.bannerList = res.data;
			
				uni.hideLoading();
			});
		},
		buy(type){
			if(type==1){
				uni.navigateTo({
				    url: '/pages/home/buy',
				});
			}
		},
		//公告
		getNoticeList() {
			this.$utils.initData({ url: 'news/list', data: { category_id: 22 }}, (res, msg) => {
				uni.stopPullDownRefresh();
				this.noticeList = res.data;
			});
		},
		//行情交易对
		quotation() {
			this.$utils.initData({ url: 'market/currency_matches'}, (res, msg) => {
				 this.tabs=[]
				for(let key in res){
					this.tabs.push(res[key].code)
				}
				this.item=res[0]
				this.allList=res
				uni.stopPullDownRefresh();
				let usdtData = res.find(item => item.code == 'USDT');
				this.cny_rate = usdtData.cny_price;
				let matches = res[0].matches;
				this.quoList = JSON.parse(JSON.stringify(matches))		//解决引用赋值排序问题
				// let matches = res[0].matches.filter((item)=>{
				// 	return item.open_change==1;
				// })
				this.itemCode = res[0].code
				// this.quoList = matches.sort(function(a, b) {
				// 	return b.currency_quotation.change - a.currency_quotation.change;
				// });
				this.tabList = JSON.parse(JSON.stringify(matches));
				// this.tabList = matches.sort(function(a, b) {
				// 	return b.currency_quotation.change - a.currency_quotation.change;
				// });
			});
		},
		show() {
			if (this.token) {
				this.getUserInfo();
			}
			this.showLeft = !this.showLeft;
		},
		hide() {
			this.showLeft = !this.showLeft;
		},
		stop() {},
		//获取用户信息
		getUserInfo() {
			var that = this;
			this.$utils.initDataToken({ url: 'user/info', data: {}, type: 'get' }, (res, msg) => {
				uni.stopPullDownRefresh();
				uni.setStorageSync('uid', msg.id);
				that.info = res;
				console.log(that.info);
			});
		},
		hideBtn(){
			this.announcementModal.showModal = false;
		}
	},
	onHide() {
		this.$socket.closeSocket();
	},
	onPullDownRefresh() {
		this.getBannerImg();
		this.getNoticeList();
		this.quotation();
	}
};
</script>

