<template>
  <view class="overflow-x-hidden" :class="theme">
	  <view class="bg-white dark:bg-my-black">
	  	
		  <uni-nav-bar>
			<view class="absolute left-0 z-10 h-100">
				<view class="flex flex-1 relative h-full flex items-center justify-center px-20">
					<view class="flex items-center text-primary">
						<text v-if="info.uid">UID: {{info.uid}}</text>
					</view>
					<!-- <image class="w-80 h-80" src="/static/logo.png"></image> -->
				</view>
			</view>
			<view class="flex-1 flex justify-center items-center text-2xl h-100">
				
			</view>
			<view class="absolute right-0 top-0 z-10 h-100 flex items-center px-20">
				<view class="flex items-center" @tap="showRight = true">
						<text class="text-primary">{{ languages[lang].name }}</text>
						<image :src="languages[lang].img" class="w-30 h-24 ml-10"></image>
					</view>
				<!-- <view class="py-10 px-20 bg-k-red rounded-full text-white" @tap="showRight = true">
					{{$t('new.yy')}}
				</view>
				<navigator  open-type="switchTab" url="/pages/assets/assets" class="py-10 px-20 mx-20 bg-primary rounded-full text-white">
					{{$t('authentication.person')}}
				</navigator> -->
				<!-- <image @click="toPath('/pages/home/chat')" src="/static/image/kefu.png" class="w-50 h-50"></image>
				<view class="flex flex-1 relative h-full flex items-center justify-center px-20">
					<view class="flex items-center" @tap="isshowlang = !isshowlang">
						<text class="text-my-black">{{ languages[lang].name }}</text>
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
				</view> -->
			</view>
		</uni-nav-bar>
		
		<!--轮播-->
		<swiper active-class="activeClass" class="h-300 w-full" :indicator-dots="true"
		  :autoplay="true" :interval="3000" :duration="200" :circular="true" indicator-color="#747D99" indicator-active-color="#010309">
			<swiper-item v-for="(item, index) in bannerList" :key="index">
				<img class="w-full h-full" :src="item.banner"></img>
			</swiper-item>
			</swiper>
		
			<uni-notice-bar @click="toPath('/pages/home/notice')" showIcon scrollable single :text="noticeText" :speed="3"></uni-notice-bar>


		<view class="flex flex-wrap pt-30 text-white dark:bg-box my-30">
		  <view class="flex items-center justify-center flex-col text-center pb-40" style="width: 25%;" @click="toPath(item)" v-for="item,index in functionModule" :key="index">
			<image class="w-84 h-84" :src="`/static/image/${item.img}`"></image>
			<view class="text-lg">{{ $t(item.name) }}</view>
		  </view>
		</view>

		<!--涨幅榜-->
		<swiper v-if="quoList.length" :display-multiple-items="quoList.length>2?3:quoList.length" class="w-full h-170 bg-white dark:bg-box pl-20 pr-20">
		  <swiper-item class="flex items-start justify-around"  v-for="(item, i) in quoList" :key="i">
			<view @click="toUrl(item,allList[1])" class="flex flex-col items-center w-200 h-170 justify-center rounded-10 relative">
				<text class="text-white mb-20" style="font-size: 28rpx;">{{ item.base_currency_code }}/{{ item.quote_currency_code }}</text>
				<text class="text-xl" v-if="item.currency_quotation" 
				:class="{'text-k-red': parseFloat(item.currency_quotation.change) < 0,'text-k-green':parseFloat(item.currency_quotation.change) >= 0 ||item.currency_quotation.change == '',}">
					{{ parseFloat(item.currency_quotation.close) }}
				</text>
				<text class="text-sm" v-if="item.currency_quotation" 
				:class="{'text-k-red': parseFloat(item.currency_quotation.change) < 0,'text-k-green':parseFloat(item.currency_quotation.change) >= 0 ||item.currency_quotation.change == '',}">
					{{ item.currency_quotation.change.substr(0, 1) == "-" ? "" : "+"}}{{ (item.currency_quotation.change - 0) | toFixed2 }}%
				</text>
			</view>
		  </swiper-item>
		</swiper>
		
		<view class="px-60 mt-30">
      <view
        class="w-full rounded-full h-90 flex items-center justify-between px-60 dark:bg-box"
        @click="toPath('/pages/home/recharge')"
      >
	  	<view class="flex items-center">
			<image src="/static/image/kscz.png" class="w-80 h-80 mr-10"></image>
        	<view class="text-white text-lg">{{ $t("new.recharge") }}</view>
		</view>
		<image src="/static/image/arrow-white.png" class="w-20 h-36"></image>
      </view>
      <view
        class="mt-20 w-full rounded-full h-90 flex items-center justify-between px-60 dark:bg-box"
        @click="toPath('/pages/legal/legal')"
      >
	  	<view class="flex items-center">
			<image src="/static/image/fb.png" class="w-80 h-80 mr-10"></image>
        <text class="text-center text-white">{{ $t("assets.legal") }}</text>
		</view>
		<image src="/static/image/arrow-white.png" class="w-20 h-36"></image>
      </view>
    </view>
	
		<!-- <view class="w100 plr10 pb5 posRelt" v-if="isShow">
		  <view class="abstrot zdx100 white" style="top: 15%; left: 10%">
			<view class="ft16 bold">{{ $t("home.security") }}</view>
			<view class="mt5">{{ $t("home.leader") }}</view>
		  </view>
		  <image class="w100 h70" src="/static/image/banner.png"></image>
		</view>
	 -->
		<!--行情-->

	<view class="pb-180">
		 <view  v-for="(list, index) in allList" :key="index">
			 <view class="text-white text-center text-44 py-30">
			 {{ index==1?$t('new.ysqhq'):list.code }}
		  	</view>

			  <view @click="toUrl(allList[index].matches[0],allList[index])" class="flex items-center text-sm text-gray-400 tableitem mx-40 mb-30 py-30 bg-my-blue px-20">
			<view class="flex items-center" style="flex: 1.5">
				<image class="w-40 h-40 mr-16 rounded-half bg-white" :src="host +  allList[index].matches[0].base_currency.logo"></image>
				<view class="text-sm text-white"><text class="text-lg text-white">{{   allList[index].matches[0].base_currency_code }}</text>/{{ allList[index].matches[0].quote_currency_code }}</view>
			</view>
			<view v-if="  allList[index].matches[0].base_currency_code=='MUT' && !isOnline(  allList[index].matches[0].market_time)" class="w-200">{{$t('trade.soon')}}</view>
			<template v-else>
				<view class="flex-1 text-white text-lg" v-if="  allList[index].matches[0].currency_quotation">{{ parseFloat(  allList[index].matches[0].currency_quotation.close) }}</view>
				<view class="flex-1 text-right flex justify-end" v-if="  allList[index].matches[0].currency_quotation">
				  <view class="w-140 h-60 flex justify-center items-center rounded-8 text-center text-white text-3xl">
					{{   allList[index].matches[0].currency_quotation.change.substr(0, 1) == "-" ? "" : "+"}}{{ (  allList[index].matches[0].currency_quotation.change - 0) | toFixed2 }}%
				  </view>
				</view>
			</template>
		  </view>
			
		  <view class="flex items-center text-gray1 text-lg mx-20 px-18 py-20 bg-box mb-18">
			<text style="flex: 1.5;font-size: 24rpx;">{{ $t("home.name") }}</text>
			<text class="flex1" style="font-size: 24rpx;">{{ $t("home.new_price") }}</text>
			<text class="flex1 text-right" style="font-size: 24rpx;">{{ $t("home.fu") }}</text>
		  </view>
		  <view @click="toUrl(item,allList[index])" class="flex items-center text-sm text-gray1 tableitem mx-20 px-18 py-30 bg-box" style="border-bottom: 2rpx dashed #111727;" v-for="(item, i) in list.matches" :key="i">
			<view class="flex items-center" style="flex: 1.5">
				<image class="w-40 h-40 mr-16 rounded-half bg-white" :src="host + item.base_currency.logo"></image>
				<view class="text-sm text-white"><text class="text-sm text-mg-black">{{ item.base_currency_code }}</text>/{{ item.quote_currency_code }}</view>
			</view>
			<view v-if="item.base_currency_code=='MUT' && !isOnline(item.market_time)" class="w-200">{{$t('trade.soon')}}</view>
			<template v-else>
				<view class="flex-1 text-gray1 text-sm" v-if="item.currency_quotation">{{ parseFloat(item.currency_quotation.close) }}</view>
				<view class="flex-1 text-right flex justify-end" v-if="item.currency_quotation">
				  <view class="w-140 h-60 flex justify-center items-center rounded-8 text-center text-white text-sm" :class="{ 'bg-k-red': parseFloat(item.currency_quotation.change) < 0, 'bg-k-green':parseFloat(item.currency_quotation.change) >= 0 ||item.currency_quotation.change == ''}">
					{{ item.currency_quotation.change.substr(0, 1) == "-" ? "" : "+"}}{{ (item.currency_quotation.change - 0) | toFixed2 }}%
				  </view>
				</view>
			</template>
		  </view>
		 </view>
		</view>
		
		
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
			<text class="">{{ item.name }}</text>
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
// import liuyunoTabs from "@/components/liuyuno-tabs/liuyuno-tabs.vue";
export default {
	components: {
		uniDrawer,
		uniPopup
        // liuyunoTabs
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
				//	ru: { name: 'Русский язык', img: '/static/image/ru.png' },
				fr: { name: 'français', img: '/static/image/fr.png' },
			    de: { name: 'Deutsche', img: '/static/image/de.png' },
				tr: { name: 'Türkçe', img: '/static/image/tr.png' },
				it: { name: 'Italiano', img: '/static/image/it.png' },
				spa: { name: 'Español', img: '/static/image/spa.png' },
				// ar: { name: 'عربي', img: '/static/image/ar.png' },
				// de: { name: 'Deutsche', img: '/static/image/de.png' },
				// it: { name: 'Italiano', img: '/static/image/it.png' },
				// fr: { name: 'français', img: '/static/image/fr.png' },
				hk: { name: '繁體中文', img: '/static/image/hk.png' },
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
				{
					img:'kefu.png',
					path: '/pages/home/chat',
					name: 'new.lianxikefu'
				},
				{
					img:'lmlm.png',
					path: '/pages/mine/real_authentication',
					name: 'new.verified'
				},
				{
					img:'lockMining.png',
					path: '/pages/staking/index',
					name: 'staking.mining'
				},
				{
					img:'spjs.png',
					name: 'new.spjs',
					link:'https://api.coinsultra.com/wp/acmecoin.mp4'
				},
				{
					img:'bps.png',
					open: true,
					name: 'new.baip'
				},
				{
					img:'wdtg.png',
					isInvite:true,
					name: 'new.wdtg'
				},
				{
					img:'tixian.png',
					path: '/pages/mine/withdraw',
					name: 'new.zhuan'
				},
				{
					img:'bbjy.png',
					path: '/pages/trade/trade',
					name: 'trade.trade'
				}
			],
			announcementModal:{
				showModal: false,
				title: '',
				content: '',
				tipbtnShow: false
			},
			current:0,
			mode: 'dot',
			dotsStyles:{
				width:10,
				height:10,
				border:'none',
				selectedBorder:'none',
				backgroundColor:'#CCCCCC',
				selectedBackgroundColor:'#0066FC',
				bottom:-20
			},
			noticeText: ''
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
	   console.log(1111)
		
	},
	onShow() {
		this.getAnnouncement()	
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
		// this.getAnnouncement();
		this.$socket.listenFun([{ type: "sub", params: "DAY_MARKET" }], res => {
			var msg = JSON.parse(res);
			for (var i = 0; i < this.quoList.length; i++) {
				//this.quoList[i].currency_quotation.close=parseFloat(this.quoList[i].currency_quotation.close)tabList
				if (this.quoList[i].id == msg.currency_match_id) {
					this.quoList[i].currency_quotation.close = msg.quotation.close;
					this.quoList[i].currency_quotation.change = msg.quotation.change;
				}
			}
			this.allList.forEach(element => {
				for (var i = 0; i < element.matches.length; i++) {
				//this.quoList[i].currency_quotation.close=parseFloat(this.quoList[i].currency_quotation.close)tabList
				if (element.matches[i].id == msg.currency_match_id) {
					element.matches[i].currency_quotation.close = msg.quotation.close;
					element.matches[i].currency_quotation.change = msg.quotation.change;
				}
			}
			});
			// for (var i = 0; i < this.tabList.length; i++) {
			// 	//this.quoList[i].currency_quotation.close=parseFloat(this.quoList[i].currency_quotation.close)tabList
			// 	if (this.tabList[i].id == msg.currency_match_id) {
			// 		this.tabList[i].currency_quotation.close = msg.quotation.close;
			// 		this.tabList[i].currency_quotation.change = msg.quotation.change;
			// 	}
			// }
		});
	},
	methods: {
		toLink(link){
			if(link){
				// window.open(link);
				uni.navigateTo({
			    	url:`/pages/home/web?url=${link}`
			    })
			}
		},
		change(e){
			this.current = e.detail.current
		},
		linkWallet(){
			let email = "null"
			if (this.info.email) {
			
				email = this.info.email
			}
			console.log(this.$utils, 111)
			window.open(`${this.$utils._DOMAIN}/connectWallet?email=` + email);
		},
		getAnnouncement() {
			this.noticeText = ''
			try {
				const that = this;
				that.$utils.initDataToken({
					url: "news/list?category_id=0"
				}, res => {
					console.log(res)
					res.data.length && res.data.forEach((item,index)=> ( this.noticeText += `${index+1}.${item.title}   `) )
					console.log(this.noticeText)
					// if (res.data.length ) {
					// 	this.$set(this.announcementModal,'title', res.data[0].title);
					// 	this.$set(this.announcementModal,'content', res.data[0].content);
					// 	this.$set(this.announcementModal,'showModal', true);
					// }
				});
			} catch (e) {
				console.log(e);
				//TODO handle the exception
			}
		},
		topo(){
			// var lang = this.lang;
			//  if(lang == 'hk'){
			// 	  lang = 'zh'
			//  }else{
			// 	  lang = 'en'
			//  }
			window.open('https://api.acmecoinltd.com/wp/acmecoin.html');
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
		toUrl(item,target){
			let currencyData={
					legal_name:item.quote_currency_code,
					legal_id:item.quote_currency_id,
					currency_id:item.base_currency_id,
					currency_name:item.base_currency_code,
					fee:item.change_fee_rate,
					market_time:item.market_time,
					match_id:item.id
				}
				uni.setStorageSync('tradeData', JSON.stringify(currencyData));

				uni.switchTab({
					url: '/pages/trade/trade'
				});
			// this.setItem(target)
			// let currencyData={
			// 		cny: this.item.cny_price,
			// 		quoteCurrencyCode: this.item.code,
			// 		quoteCurrencyId: this.item.id,
			// 		baseCurrencyId : item.base_currency_id,
			// 		baseCurrencyCode : item.base_currency_code,
			// 		shareNUm : item.lever_share_num,
			// 		spread : item.lever_point_rate,
			// 		fee : item.lever_fee_rate,
			// 		quoteCurrencyIds : this.item.id,
			// 		changes : item.currency_quotation.change,
			// 		currencyMatchId: item.id,
			// 	}
			// 	uni.setStorageSync('leverOrder', JSON.stringify(currencyData));
			// 	uni.setStorageSync('active', 1);
			// 	uni.switchTab({
			// 		url: '/pages/contract/lever'
			// 	});
		},
		toPath(item){
			if(typeof item == 'string'){
				if(item=='/pages/contract/lever' || item=='/pages/assets/assets'){
					return uni.switchTab({url: item})
				}
				return uni.navigateTo({url: item })
			}else if(item.path){
				return item.path === '/pages/trade/trade' ? uni.switchTab({url: item.path }) : uni.navigateTo({url: item.path })
			}else if(item.link){
				this.toLink(item.link)
			}else if(item.isInvite){
				uni.navigateTo({url: `/pages/mine/invite?code=${this.info.invite_code}`})
			}else if(item.open){
				this.topo()
			}
			
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
				if(lang=='hk'){
					uni.setLocale('zh-Hant')
				}else{
					uni.setLocale('en')
				}
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
				// this.allList=res.reverse()
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