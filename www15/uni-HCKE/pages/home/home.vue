<template>
  <view class="bg-my-blue pb-20">
	  <view>

		  <uni-nav-bar fixed>
			<view class="absolute left-0 z-10 h-100">
				<view class="flex flex-1 relative h-full flex items-center justify-center px-20">
					<!-- <view class="flex items-center">
						<text v-if="info.uid">UID: {{info.uid}}</text>
					</view> -->
					<image class="w-100 h-100" src="/static/logo.png"></image>
				</view>
			</view>
			<view class="flex-1 flex justify-center items-center text-2xl h-100" style="background-color:#005845; ">
				
			</view>
			<view class="absolute right-0 top-0 z-10 h-100 flex items-center">
				<image @click="toPath('/pages/home/chat')" src="/static/image/kefu.png" class="w-50 h-50"></image>
				<view class="flex flex-1 relative h-full flex items-center justify-center px-20">
					<view class="flex items-center" @tap="isshowlang = !isshowlang">
						<text>{{ languages[lang].name }}</text>
						<image :src="languages[lang].img" class="w-30 h-24 ml-10"></image>
					</view>
					<view class="absolute right-0 top-100 w-200" v-show="isshowlang">
						<view class="bggray px-20 relative z-20" >
						  <view class="flex items-center py-20 border-0 border-b-2 border-solid border-gray-100 dark:border-gray-900 justify-between"
							v-for="(item, i) in languages" :key="i" @tap="changeLang(i)">
							<text>{{ item.name }}</text>
							<image :src="item.img" class="w-30 h-24 ml-10"></image>
						  </view>
						</view>
						<view class="fixed w-full h-full z-10 bg-black bg-opacity-30 left-0 top-0" ></view>
					</view>
				</view>
			</view>
		</uni-nav-bar>

		<view class="w-full bg-primary h-300 w-full relative mb-40" style="border-radius: 0 0 50rpx 50rpx;">
			<!-- <image class="w-full h-300 absolute" src="/static/image/home_mask.png"></image> -->
			<view class="h-300 w-full px-20 absolute overflow-hidden" style="bottom:-40rpx;border-radius:32rpx">
				<swiper active-class="activeClass" class="h-300 w-full" :indicator-dots="true"
		  :autoplay="true" :interval="3000" :circular="true" indicator-color="#aaa" indicator-active-color="#eee">
			<swiper-item v-for="(item, index) in bannerList" :key="index">
				<img class="w-full h-full" :src="item.banner"></img>
			</swiper-item>
		</swiper>
			</view>
		</view>
	  	
		
		
		<!--轮播-->
		
		
		
		<view class="flex py-40">
			<view class="flex items-center flex-1 justify-center flex-col text-center" @click="toPath('/pages/subscription/index')">
			<image class="w-40 h-60" style="width: 35px !important;" src="/static/image/position.png"></image>
			<view class="text-lg mt-20">{{ $t("subscription.new_subscription") }}</view>
		  </view>
		  <view class="flex items-center flex-1 justify-center flex-col text-center" @click="toPath(item.path)" v-for="item,index in functionModule" :key="index">
			<image class="w-60 h-60" :src="`/static/image/${item.img}`"></image>
			<view class="text-lg mt-20">{{ $t(item.name) }}</view>
		  </view>
		 <!-- <view class="flex items-center flex-1 justify-center flex-col text-center" @click="toPath('/pages/mine/real_authentication')">
			<image class="w-60 h-50" src="/static/image/lmlm.png"></image>
			<view class="text-lg mt-20">{{ $t("new.verified") }}</view>
		  </view>
		  <view class="flex items-center flex-1 justify-center flex-col text-center" @click="toPath('/pages/legal/legal')">
			<image class="w-50 h-50" src="/static/image/rfwrg.png"></image>
			<view class="text-lg mt-20">{{ $t("legal.legal") }}</view>
		  </view> -->
		 <view class="flex items-center flex-1 justify-center flex-col text-center" @click="topo(lang=='hk'?'bitstamp_zh.pdf':'bitstamp_en.pdf')">
			<image class="w-50 h-50" src="/static/image/whitepaper.png"></image>
			<view class="text-lg mt-20">{{ $t("new.baip") }}</view>
		  </view>
		</view>
	
		<!-- <view class="w-full my-20 h-120 flex justify-between bg-white dark:bg-floor items-icon">
			<view class="w-full px-40 flex items-center" @click="toPath('/pages/home/recharge')">
				<view class="flex flex-1 flex-col">
					<view class="font-bold text-lg">{{ $t("new.recharge") }}</view>
					<text class="pt-10 text-sm font-light">{{ $t("new.clickre") }}</text>
				</view>
				<view class="w-60 h-60 rounded-half flex items-center justify-center bg-primary">
					<image src="../../static/image/wegfwe.png" class="w-24 h-24" style="transform: rotate(180deg);"></image>
				</view>
			</view>
		</view> -->
	
		<view class="w100 plr10 pb5 posRelt" v-if="isShow">
		  <view class="abstrot zdx100 white" style="top: 15%; left: 10%">
			<view class="ft16 bold">{{ $t("home.security") }}</view>
			<view class="mt5">{{ $t("home.leader") }}</view>
		  </view>
		  <image class="w100 h70" src="/static/image/banner.png"></image>
		</view>
	
		<!--涨幅榜-->
		<swiper display-multiple-items="3" class="w-full h-200" v-if="quoList.length > 2">
		  <swiper-item class="flex items-start justify-around"  v-for="(item, i) in quoList" :key="i">
			<view @click="toUrl(item)" class="flex flex-col items-start pl-20 w-200 h-170 justify-center rounded-10 relative" style="background:#0b4d3f;">
				<text class="white mb-20" style="font-size: 28rpx;">{{ item.base_currency_code }}/{{ item.quote_currency_code }}</text>
				<text class="text-xl text-my-yellow" v-if="item.currency_quotation" 
				:class="{'text-danger': parseFloat(item.currency_quotation.change) < 0,'text-success':parseFloat(item.currency_quotation.change) >= 0 ||item.currency_quotation.change == '',}">
					{{ parseFloat(item.currency_quotation.close) }}
				</text>
				<text class="text-sm text-my-yellow" v-if="item.currency_quotation" 
				:class="{'text-danger': parseFloat(item.currency_quotation.change) < 0,'text-success':parseFloat(item.currency_quotation.change) >= 0 ||item.currency_quotation.change == '',}">
					{{ item.currency_quotation.change.substr(0, 1) == "-" ? "" : "+"}}{{ (item.currency_quotation.change - 0) | toFixed2 }}%
				</text>
				<image class="absolute" style="bottom:-36rpx;right:-20rpx;width: 230rpx;height: 200rpx;" src="/static/image/hq_bg.png"></image>
			</view>
		  </swiper-item>
		</swiper>
		
		<swiper class="w-full h-200" v-else>
		  <swiper-item class="flex items-center justify-around" v-for="(item, i) in quoList" :key="i" >
			<!-- :url="'/pages/market/kline?legal_id=' + item.quote_currency_id + '&currency_id=' + item.base_currency_id + '&symbol=' + item.base_currency_code + '/' + item.quote_currency_code+'&currency_match_id='+item.id" -->
			<view @click="toUrl(item)" class="flex column items-center">
				<text class="text-sm">{{ item.base_currency_code }}/{{ item.quote_currency_code }}</text>
				<text class="ft16 bold" v-if="item.currency_quotation" :class="{
				  red2: parseFloat(item.currency_quotation.change) < 0,
				  green:parseFloat(item.currency_quotation.change) >= 0 || item.currency_quotation.change == ''}">{{ item.currency_quotation.close }}</text>
				<text class="text-sm" v-if="item.currency_quotation" :class="{
				  red2: parseFloat(item.currency_quotation.change) < 0,
				  green: parseFloat(item.currency_quotation.change) >= 0 || item.currency_quotation.change == ''}">
					{{ item.currency_quotation.change.substr(0, 1) == "-" ? "" : "+"}}{{ (item.currency_quotation.change - 0) | toFixed2 }}%
				</text>
			  <!-- <text class="text-sm text-gray-400" v-if="item.currency_quotation">≈ {{ ((item.currency_quotation.close - 0) * (cny_rate - 0)) | toFixed2 }} CNY</text> -->
			</view>
		  </swiper-item>
		</swiper>

		 <view class="flex px-30 justify-between">
      <view
        class="w-330 rounded-10 h-90 flex items-center justify-center"
		style="background:#005845"
        @click="toPath('/pages/home/recharge')"
      >
	  	<image src="/static/image/kscz.png" class="w-40 h-40 mr-10"></image>
        <view class="text-white">{{ $t("new.recharge") }}</view>
        <!-- <tex class="text-black">{{ $t("new.clickre") }}</tex	t> -->
      </view>
      <!-- <view
        class="item"
        :class="theme == 'light' ? 'b1' : 'b'"
        @click="toPath('/pages/assets/assets')"
      >
        <view class="max text-bb">{{ $t("new.withdrawal") }}</view>
        <text class="min">{{ $t("new.clickwit") }}</text>
      </view> -->
      <!-- <view class="w-200 rounded-10 h-90 flex flex-col items-center justify-center relative"
		style="background:#0a9d87">
        <view>
          <view class="flex alcenter jscenter" @tap="isshowlang = !isshowlang">
            <text class="text-black">{{ languages[lang].name }}</text>
            <image :src="languages[lang].img" class="wt15 h12 ml5"></image>
          </view>
          <view
            class="abstrot bggray plr8 wt100 radius4"
            style="right: 0; top: 90rpx"
            v-show="isshowlang"
          >
            <view
              class="flex alcenter ptb10 between bdb1f langs"
              v-for="(item, i) in languages"
              :key="i"
              @tap="changeLang(i)"
            >
              <text>{{ item.name }}</text>
              <image :src="item.img" class="wt15 h12 ml5"></image>
            </view>
          </view>
        </view>
      </view> -->
      <view
        class="w-330 rounded-10 h-90 flex items-center justify-center"
		style="background:#005845"
        
        @click="toPath('/pages/legal/legal')"
      >
	  		<image src="/static/image/fb.png" class="w-40 h-40 mr-10"></image>
        <text class="text-center text-white">{{ $t("assets.legal") }}</text>
      </view>
    </view>
    
	
		<!--行情-->
		<view class="pb-100 bg-black mx-30 mt-20" style="border-radius: 20rpx;">
		  <!-- <view class="ptb10 bdb_blue3 ft14 plr10 bold zhang">主流区</view> -->
		  <view class="flex px-40 pt-20">
			<view class="trading-item text-center mr-40" v-for="(item, index) in allList" :key="index" @click="setItem(item)">
			  <view class="pb-10 text-lg" :class="itemCode == item.code ? 'text-primary active-currency' : ''">{{ item.code }}</view>
			  <view class="w-80 h-6" :class="itemCode == item.code ? 'bg-primary' : ''"></view>
			</view>
		  </view>
		  <view class="flex items-center text-lg px-40 pt-20">
			<text style="flex: 1.5;font-size: 26rpx;">{{ $t("home.name") }}</text>
			<text class="flex1" style="font-size: 26rpx;">{{ $t("home.new_price") }}</text>
			<text class="flex1 text-right" style="font-size: 26rpx;">{{ $t("home.fu") }}</text>
		  </view>
		  <!-- :url="'/pages/market/kline?legal_id=' + item.quote_currency_id + '&currency_id=' + item.base_currency_id + '&symbol=' + item.symbol+'&currency_match_id='+item.id" -->
		  <view @click="toUrl(item)" class="flex items-center text-sm text-gray-400 tableitem px-40 py-30" v-for="(item, i) in tabList" :key="i">
			<view class="flex items-center" style="flex: 1.5">
				<image class="w-40 h-40 mr-16 rounded-half bg-white" :src="host + item.base_currency.logo"></image>
				<view class="text-sm text-primary"><text class="text-sm text-primary">{{ item.base_currency_code }}</text>/{{ item.quote_currency_code }}</view>
				<!-- <view class="text-sm">24H量 {{item.volume}}</view> -->
			</view>
			<view v-if="item.base_currency_code=='MUT' && !isOnline(item.market_time)" class="w-200">{{$t('trade.soon')}}</view>
			<template v-else>
				<view class="flex-1 text-white text-sm text-my-yellow" v-if="item.currency_quotation">{{ parseFloat(item.currency_quotation.close) }}</view>
				<view class="flex-1 text-right flex justify-end" v-if="item.currency_quotation">
				  <view class="w-140 h-60 flex justify-center items-center rounded-8 text-center text-white text-sm" :class="{ 'bg-danger': parseFloat(item.currency_quotation.change) < 0, 'bg-success':parseFloat(item.currency_quotation.change) >= 0 ||item.currency_quotation.change == ''}">
					{{ item.currency_quotation.change.substr(0, 1) == "-" ? "" : "+"}}{{ (item.currency_quotation.change - 0) | toFixed2 }}%
				  </view>
				</view>
			</template>
		  </view>
		   <view class="flex px-20 mt-30 bg-black pt-20" @click="dow" style="border-top: 2rpx solid #666;">
				<view class="flex items-center" >
					<!-- <image v-if="theme !== 'light'" class="down-logo" src="/static/image/icon pc@3x.png"></image> -->
					<image   class="h30 w-50 mr-10" src="/static/image/android.png"></image>
					<text class="text">Android</text>
				</view>
				<view class="flex items-center ml-40">
					<!-- <image  v-if="theme !== 'light'" class="down-logo" src="/static/image/icon app@3x.png"></image> -->
					<image  class="h30 w-60" src="/static/image/ios.png"></image>
					<text class="text">IOS</text>
				</view>
		</view>
		</view>

		
		
		<!-- 下单弹窗 -->
		<uni-popup :show="announcementModal.showModal" @hidePopup="hideBtn" :closeBtn="true" :msg="announcementModal.title" :btnShow="announcementModal.tipbtnShow" :lang="lang">
			<!-- <text class="w-full p-40" v-html="announcementModal.content">
				{{announcementModal.content}}
			</text> -->
			 <rich-text class="w-full p-40 h-700 overflow-auto" :nodes="announcementModal.content"></rich-text>
		</uni-popup>
	</view>
  </view>
</template>

<script>
const CryptoJS = require("crypto-js");	
import uniPopup from '@/components/uni-popup.vue';
import { mapState } from 'vuex';
// import liuyunoTabs from "@/components/liuyuno-tabs/liuyuno-tabs.vue";
export default {
	components: {
		uniPopup
        // liuyunoTabs
    },
	data() {
		return {
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
				kr: { name: '한국어', img: '/static/image/kr.png' },
				vn: { name: 'Tiếng Việt', img: '/static/image/vn.png' },
				th: { name: 'ไทย', img: '/static/image/th.png' },
				ar: { name: 'عربي', img: '/static/image/ar.png' },
				// de: { name: 'Deutsche', img: '/static/image/de.png' },
				// it: { name: 'Italiano', img: '/static/image/it.png' },
				// fr: { name: 'français', img: '/static/image/fr.png' },
				hk: { name: '繁體中文', img: '/static/image/hk.png' },
				spa: { name: 'Español', img: '/static/image/spa.jpeg' },
			},
			lang: 'en',
			isshowlang: false,
			isShow:false,
			tabList:[],
			item:{},
			functionModule:[
				// {
				// 	img:'ppmp.png',
				// 	path: '/pages/subscription/index',
				// 	name: 'subscription.new_subscription'
				// },

				// {
				// 	img:'ppmp.png',
				// 	path: '/pages/subscription/index',
				// 	name: 'subscription.new_subscription'
				// },
				// {
				// 	img:'kefu.png',
				// 	path: '/pages/home/chat',
				// 	name: 'new.lianxikefu'
				// },
				{
					img:'lmlm.png',
					path: '/pages/mine/real_authentication',
					name: 'new.verified'
				},
				{
					img:'lockMining.png',
					path: '/pages/staking/index',
					name: 'staking.mining'
				}
				// {
				// 	img:'rfwrg.png',
				// 	path: '/pages/legal/legal',
				// 	name: 'legal.legal'
				// },
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
		var token = uni.getStorageSync('token');
		this.lang = uni.getStorageSync('lang') || 'en';
		if(this.lang=='zh'||this.lang=='kr'){
		  this.lang='en'
		}
		this.changeFooter();
		if (token) {
			this.getUserInfo();
		}
		
		
	},
	onShow() {
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
		topo(name){
		
			 window.open(`${this.$utils._DOMAIN}/wp/${name}`);

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
			// uni.setTabBarItem({
			// 	index: 1,
			// 	text: this.$t('market.market')
			// });
			uni.setTabBarItem({
				index: 1,
				text: this.$t('trade.bibi')
			});
			uni.setTabBarItem({
				index: 2,
				text: this.$t('new.tran')
			});
			uni.setTabBarItem({
				index: 3,
				text: this.$t('bigTrade.whjy')
			});
			uni.setTabBarItem({
				index: 4,
				text: this.$t('assets.assets')
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
					uni.setTabBarItem({
						index: 3,
					    iconPath :  "static/footer/big0.png",
					});
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
				   	iconPath : "static/footer/gang2.png",
				   });
				   uni.setTabBarItem({
				   	index: 3,
				   	iconPath :  "static/footer/big0.png",
				   });
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
				// this.isshowlang = false;
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
			});
		},
		//退出登录
		logout() {
			this.$utils.initDataToken({ url: 'user/logout', data: {}, type: 'post' }, (res, msg) => {
				uni.clearStorageSync();
				this.$utils.showLayer(msg);
				uni.reLaunch({
					url: '/pages/mine/login'
				})
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

<style scoped>
.active-currency{
	background: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(3, 140, 81, 1) 100%);
	border-radius: 20px;
}
</style>