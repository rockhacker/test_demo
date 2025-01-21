<template>
	<view :class="theme">
		<view class="bg-floor">
			<uni-nav-bar fixed>
				<view class="w-full flex flex-col p-40 border-0 border-solid border-b-2 border-gray-100 dark:border-gray-900">
					<view class="w-full flex justify-center">
						<view class="flex w-500 h-60 bg-gray-100 dark:bg-gray-600 dark:bg-opacity-30 rounded-2xl overflow-hidden">
							<view class="flex-1 flex justify-center items-center text-center" :class="active==1?'bg-primary text-white':'text-primary bg-white'" @click="setActive(1)">{{$t('new.leverAll')}}</view>
							<view class="flex-1 flex justify-center items-center text-center" :class="active==0?'bg-primary text-white':'text-primary bg-white'" @tap="setActive(0)">{{$t('new.leverLes')}}</view>
							<view class="flex-1 flex justify-center items-center text-center" :class="active==2?'bg-primary text-white':'text-primary bg-white'" @tap="setActive(2)">{{$t('qqjy.qqjy')}}</view>
						</view>
					</view>
					
					<view class="flex justify-between items-center mt-20" v-if="active!=2">
						<view class="flex items-center" @tap="leftStatus = true">
							<image src="/static/image/list.png" mode="aspectFit" class="w-40 h-40"></image>
							<view class="mx-20 text-lg font-bold">{{ baseCurrencyCode }} / {{ quoteCurrencyCode }}</view>
							<!-- <view class="text-my-yellow text-lg">{{ changes || '0.00' | filterDecimals }}%</view> -->
							<view :class="changes < 0 ? 'text-danger': 'text-success'">{{ changes || '0.00' | filterDecimals }}%</view>
						</view>
						<view class="flex justify-center items-center">
							<image v-if="active==1 && !soon" src="/static/image/datamap.png" mode="aspectFit" class="w-40 h-40" @tap="linkKline"></image>
							<image src="/static/image/record1.png" mode="aspectFit" class="w-30 h-30" style="margin-left:30rpx" @tap="linkLever"></image>
						</view>
					</view>
				</view>
				
			</uni-nav-bar>
			
			<view class="flex justify-center items-center text-3xl h-600" v-if="soon">{{$t('trade.soon')}}</view>
			<view v-if="active==1 && !soon" class="min-h-screen bg-gray-100 dark:bg-floor">
				<!-- <view class="flex justify-center items-center text-3xl h-600" v-if="soon">{{$t('trade.soon')}}</view> -->
				<view class="flex justify-between p-20">
					<view class="w-3_5">
						<view class="overflow-hidden flex justify-between text-white">
							<view class="rounded-10 text-center flex justify-center items-center flex-1 h-66 relative mr-20 text-xl" :class="leverTradeType == 'buy' ? 'bg-primary text-white' : 'bg-black text-primary'" @tap="tradeType('buy')">
								{{ $t('trade.buy') }}
								<!-- <view class="w-0 h-0 absolute right-0 bottom-0" 
								:style="`border-top: 16px solid #${ theme == 'light'?'f3f4f6':'272f39' };border-left: 16px solid transparent;border-bottom: 18px solid #${ theme == 'light'?'f3f4f6':'272f39' };`"></view> -->
							</view>
							
							<view class="rounded-10 text-center flex justify-center items-center flex-1 h-66 relative ml-20 text-xl" :class="leverTradeType == 'sell' ? 'bg-red-500 text-white' : 'bg-black text-primary'" @tap="tradeType('sell')">
								{{ $t('trade.sell') }}
								<!-- <view class="w-0 h-0 absolute left-0 bottom-0" 
								:style="`border-top: 16px solid #${ theme == 'light'?'f3f4f6':'272f39' };border-right: 16px solid transparent;border-bottom: 18px solid #${ theme == 'light'?'f3f4f6':'272f39' };`"></view> -->
							</view>
						</view>
						<view class="flex item-center justify-between mt-20">
							<view class="flex items-center justify-between border-2 border-solid border-gray-400 dark:border-gray-600 flex-2 h-60 pr-10 rounded-8" @tap="tradeTypes.shows = true">
								<view class="flex-1 text-center">{{ priceStatus == 1 ? $t('trade.shi') : $t('trade.limit') }}</view>
								<image src="../../static/image/pull.png" mode="aspectFit" class="w-30 h-30"></image>
							</view>
							<view class="flex-1 h-60 ml-10">
								<view class="border-2 border-solid border-gray-400 dark:border-gray-600 h-60 flex items-center justify-between pr-10 rounded-8" @tap="mults.shows = true">
									<text class="flex-1 text-center">{{ leverOrder.mult }}</text>
									<image src="../../static/image/pull.png" mode="aspectFit" class="w-30 h-30"></image>
								</view>
							</view>
							<!-- <view class="flex1 content-left-price radius6" :class="priceStatus == 1 ? 'bgBlue bor2' : 'border-2 border-solid border-gray-600 dark:border-gray-400'" @tap="priceTab(1)">市价</view>
							<view class="flex1 content-left-price radius6 ml20" :class="priceStatus == 0 ? 'bgBlue bor2' : 'border-2 border-solid border-gray-600 dark:border-gray-400'" @tap="priceTab(0)">限价</view> -->
						</view>
						<view class="border-2 border-solid border-gray-400 dark:border-gray-600 h-70 flex items-center mt-20 px-20 rounded-8">
							<input class="text-black dark:text-white text-sm" type="text" :class="priceStatus == 1 ? 'text-gray-600' : ''" v-model="priceValue" :disabled="priceStatus == 1 ? true : false" />
						</view>
						<view class="mt-20">{{ leverOrder.shareNUm | toFixed2 }} {{ baseCurrencyCode }}</view>
						<view class="mt-20 text-lg">
							<view class="">{{ $t('trade.handnum') }}</view>
										 
							<view class="flex justify-between items-center my-20 border-2 border-solid border-gray-400 dark:border-gray-600 px-20 rounded-8">
								<view class="flex-1 h-60 flex items-center">
									<input class="text-black dark:text-white text-sm" placeholder-class="text-gray-600 flex-1" type="number" v-model="leverOrder.share" :placeholder="$t('trade.p_handnum')" />
								</view>
								<image src="../../static/image/pull.png" mode="aspectFit" class="w-30 h-30 ml-20" @tap="shares.shows = true" v-if="multShare.share && multShare.share.length > 0"></image>
							<!-- 	<view class="">
									<view class="border-2 border-solid border-gray-600 dark:border-gray-400 h-60 flex items-center justify-between px-10 ml-10 rounded-8">
										<text>{{ leverOrder.share }}</text>
									</view>
								</view> -->
								
							</view>
						</view>
						<view class="mt-20 text-sm">{{ $t('trade.balance') }}：{{ leverBalance | toFixed4 }} {{ quoteCurrencyCode }}</view>
						<view class="h-70 flex justify-center items-center mt-30 rounded-10" :class="leverTradeType == 'buy' ? 'bg-primary' : 'bg-red-500'" @tap="submits">
							<view class="flex-1 text-center text-white text-xl">{{ leverTradeType == 'buy' ? $t('trade.buy_duo') : $t('trade.sell_kong') }}</view>
						</view>
					</view>
					<view class="w-2_5 flex flex-col ml-20">
						<view class="flex justify-between">
							<!-- <view class="">{{$t('trade.pankou')}}</view> -->
							<view class="">{{ $t('trade.price') }}</view>
							<view class="">{{ $t('trade.num') }}</view>
						</view>
						<view class="flex-1 flex flex-col" v-if="ptype != 1">
							<view class="relative h-46 items-center flex justify-between text-black dark:text-white" v-for="(item,index) in sellList"
							 :key="index" @click="plateEvent(item)" v-if="ptype == 0 ? index < 5 : index < 10">
								<view class="h-full bg-opacity-20 absolute right-0 z-0 bg-danger max-w-full" :style="{'width':parseInt((item.amount / sellMax) * 100) + '%'}" style="transition: 0.5s;"></view>
								<view class="text-danger">{{ item.price || '--' }}</view>
								<view>{{ item.amount || '--' }}</view>
							</view>
						</view>
						<view>
							<view class="text-2xl">{{ newPrice }}</view>
							<!-- <view class="mt5">≈{{ (newPrice * cny) | toFixed4 }}CNY</view> -->
						</view>
						<view class="flex1 flex flex-col" v-if="ptype != 2">
							<view class="relative h-46 items-center flex justify-between text-black dark:text-white" v-for="(item,index) in buyList"
							 :key="index" @click="plateEvent(item)" v-if="ptype == 0 ? index < 5 : index < 10">
								<view class="h-full bg-opacity-20 absolute right-0 z-0 bg-success max-w-full" :style="{'width':parseInt((item.amount / buyMax) * 100) + '%'}" style="transition: 0.5s;"></view>
								<view class="text-success">{{ item.price || '--' }}</view>
								<view>{{ item.amount || '--' }}</view>
							</view>
						</view>
						<view class="flex">
							<view :class="['w-40 h-40 flex items-center justify-center rounded-4 border-2 border-solid border-gray-400', { 'border-primary': ptype == 0 }]" @click="ptype = 0">
								<image src="/static/image/pan1.png" mode="aspectFit" class="w-30 h-30"></image>
							</view>
							<view :class="['w-40 h-40 flex items-center justify-center rounded-4 border-2 border-solid border-gray-400 ml-10', { 'border-primary': ptype == 1 }]" @click="ptype = 1">
								<image src="/static/image/pan2.png" mode="aspectFit" class="w-30 h-30"></image>
							</view>
							<view :class="['w-40 h-40 flex items-center justify-center rounded-4 border-2 border-solid border-gray-400 ml-10', { 'border-primary': ptype == 2 }]" @click="ptype = 2">
								<image src="/static/image/pan3.png" mode="aspectFit" class="w-30 h-30"></image>
							</view>
						</view>
					</view>
				</view>
				
				<view class="h-20 w-full" style="background-color: #373737;"></view>



				<!-- 当前委托列表 -->
				<view class="pb-120 min-h-half">
					<view class="p-20 flex justify-between">
						<view class="text-xl">{{ $t('trade.delegate') }}</view>
						<view class="flex items-center" @tap="totalOrder">
							<image src="../../static/image/record1.png" mode="aspectFit" class="w-40 h-40"></image>
							<view class="mx-10 text-lg">{{ $t('trade.chicang') }}</view>
						</view>
					</view>
					<view class="">
						<view class="flex justify-between bg-primary p-20 text-sm">
							<view class="flex-1 text-left">{{ $t('trade.types') }}</view>
							<view class="flex-2 text-center">{{ $t('trade.time') }}</view>
							<view class="flex-2 text-center">{{ $t('trade.price') }}</view>
							<view class="flex-2 text-center">{{ $t('trade.amout') }}</view>
							<view class="flex-1 text-center">{{ $t('trade.operate') }}</view>
						</view>
						<view class="p-20" v-if="orderList.length > 0">
							<view v-for="(item, index) in orderList" :key="index" class="flex justify-between items-center mt-10 bg-my-green p-20 rounded-10">
								<view class="flex-1 text-left text-my-yellow">{{ item.type_name }}</view>
								<view class="flex-2 text-center">{{ item.time }}</view>
								<view class="flex-2 text-center">{{ item.price || '0.0000' | toFixed4 }}</view>
								<view class="flex-2 text-center">{{ item.number || '0.00' | toFixed2 }}</view>
								<view class="flex-1 text-center bg-primary py-10 rounded-8 ml-20 text-white" @tap="closeTrade(item.id)">{{ $t('trade.pingcang') }}</view>
							</view>
						</view>
						<view class="text-center p-200" v-if="orderList.length == 0">
							<image src="../../static/image/anonymous.png" mode="aspectFit" class="w-160 h-160"></image>
							<view class="text-center">{{ $t('home.norecord') }}</view>
						</view>
					</view>
				</view>
			</view>
			<view v-if="active==0 && !soon" >
				<!-- <view class="pt80"></view> -->
				<web-view :src="url"></web-view>
			</view>
			<view v-if="active==2 && !soon" >
				<qqjy ref="qqjy" :quoteCurrencyId="quoteCurrencyId" :quoteCurrencyCode="quoteCurrencyCode"></qqjy>
			</view>
			
			<!-- 头部左边币种列表内容 -->
			<uni-drawer :visible="leftStatus" @close="leftStatus = false" v-if="quotationList.length > 0">
				<view class="pt-bar">
					<scroll-view scroll-x class="w-full h-100 whitespace-nowrap" :show-scrollbar="false">
						<view class="w-180 h-100 flex-col justify-center items-center text-xl font-bold inline-flex rounded-none" 
							hover-class="opacity-50"
							:class="{'text-primary dark:text-primary':quoteCurrencyIds == item.id}" v-for="(item,i) in quotationList" :key="i" 
							@tap="selectedLegal(item.id)">
							{{item.code}}
							<view class="w-60 h-6 mt-10" :class="{'bg-primary':quoteCurrencyIds == item.id}"></view>
						</view>
					</scroll-view>
				</view>
					
				<scroll-view scroll-y="true" style="height:calc(100% - 50px)" v-if="quotationList.length > 0">
					<view class="pb-60">
						<view class="border-0 border-b-2 border-solid border-gray-100 dark:border-gray-700 text-black dark:text-white" v-for="(item, index) in quotationList[quoteIndex].matches" :key="index" v-if="item.open_lever == 1">
							<view
								class="flex items-center justify-between px-20 py-40"
								:class="quoteCurrencyId == item.quote_currency_id && baseCurrencyId == item.base_currency_id ? 'bg-gray-200 dark:bg-gray-600' : ''"
								@tap="selectCurrency(item)"
							>
								<view class="">
									<text class="text-2xl">{{ item.base_currency_code }}</text>
									<text class="text-gray-400">/{{ item.quote_currency_code }}</text>
								</view>
								<view v-if="item.base_currency_code=='MUT' && !isOnline(item.market_time)">{{$t('trade.soon')}}</view>
								<view :class="item.change < 0 ? 'text-danger' : 'text-success'" v-else>{{ item.currency_quotation.close || '0.00' }}</view>
								<!-- <view :class="item.change < 0 ? 'red' : 'green'">{{ item.currency_quotation.change || '0.00' }}</view> -->
							</view>
						</view>
					</view>
				</scroll-view>
			</uni-drawer>
			
			<!-- 下单弹窗 -->
			<uni-popup :show="showModal" @hidePopup="hideBtn" @comfirmPopup="confirmBtn" :msg="title" :btnShow="tipbtnShow" :key="timer" :lang="langs">
				<view class="w-full p-40 ">
					<view class="text-lg">
						<view class="">{{ baseCurrencyCode }}/{{ quoteCurrencyCode }}</view>
						<view class="flex justify-between mt-20 ">
							<view class="text-lg">{{ $t('trade.types') }}</view>
							<view class="text-lg">{{ leverTradeType == 'buy' ? $t('trade.duo') : $t('trade.kong') }}</view>
						</view>
						<view class="flex justify-between mt-20">
							<view class="text-lg">{{ $t('trade.hands') }}</view>
							<view class="text-lg">{{ leverOrder.share }}</view>
						</view>
						<view class="flex justify-between mt-20">
							<view class="text-lg">{{ $t('trade.times') }}</view>
							<view class="text-lg">{{ leverOrder.mult }}</view>
						</view>
						<view class="flex justify-between mt-20">
							<view class="text-lg">{{ $t('trade.fee') }}</view>
							<view class="text-lg">{{ leverOrder.fees }}</view>
						</view>
						<view class="flex justify-between mt-20">
							<view class="text-lg">{{ $t('trade.money') }}</view>
							<view class="text-lg">{{ leverOrder.bonds }}</view>
						</view>
						<view class="mt-20 border-solid border-2 border-gray-300 p-20 rounded-10">
							<input type="text" class="text-black" password v-model="leverOrder.passwords" :placeholder="$t('login.e_pdeal')" />
						</view>
					</view>
				</view>
			</uni-popup>
			
			<!-- 平仓弹窗 -->
			<uni-popup :show="closeTrades.closeTradeShow" @hidePopup="hideBtn" @comfirmPopup="comfirmClose" :msg="closeTrades.title" :lang="langs">
				<view class="p-40 flex-1 text-xl">{{ $t('trade.confrim_ping') }}？</view>
			</uni-popup>
			
			<!-- 交易类型 -->
			<uni-popup :show="tradeTypes.shows" @hidePopup="hideBtn" :type="tradeTypes.types" :btnShow="false" :bgColor="false" :lang="langs">
				<view class="w-full bg-white dark:bg-floor text-black dark:text-white fixed bottom-0 left-0">
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30" @tap="priceTab(1)">{{ $t('trade.shi') }}</view>
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30" @tap="priceTab(0)">{{ $t('trade.limit') }}</view>
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30 border-0 border-t-2 border-solid border-gray-200 dark:border-gray-900" @tap.stop="hideBtn">{{ $t('trade.cancel') }}</view>
				</view>
			</uni-popup>
			
			<!-- 倍数弹窗 -->
			<uni-popup :show="mults.shows" @hidePopup="hideBtn" :type="mults.types" :btnShow="false" :bgColor="false" :lang="langs">
				<view class="w-full bg-white dark:bg-floor text-black dark:text-white fixed bottom-0 left-0">
					<view class="flex1 text-lg w-full flex items-center justify-center py-30" v-for="(item, index) in multShare.muit" :key="index" @tap="selectmult(item.value)">
						{{ item.value }}
					</view>
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30 border-0 border-t-2 border-solid border-gray-200 dark:border-gray-900" @tap.stop="hideBtn">{{ $t('trade.cancel') }}</view>
				</view>
			</uni-popup>
			
			<!-- 手数弹窗 -->
			<uni-popup class="bt-pop" :show="shares.shows" @hidePopup="hideBtn" :type="shares.types" :btnShow="false" :bgColor="false" :lang="langs">
				<view class="w-full bg-white dark:bg-floor text-black dark:text-white fixed bottom-0 left-0">
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30" v-for="(item, index) in multShare.share" :key="index" @tap="selectShare(item.value)">
						{{ item.value }}
					</view>
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30 border-0 border-t-2 border-solid border-gray-200 dark:border-gray-900" @tap.stop="hideBtn">{{ $t('trade.cancel') }}</view>
				</view>
			</uni-popup>
		</view>

		<uni-popup v-if="false"  :show="announcementModal.showModal" @hidePopup="hideBtn1" :closeBtn="true" :msg="announcementModal.title" :btnShow="announcementModal.tipbtnShow">
			<!-- <text class="w-full p-40" v-html="announcementModal.content">
				{{announcementModal.content}}
			</text> -->
			 <rich-text class="w-full p-40 h-700 overflow-auto" :nodes="announcementModal.content"></rich-text>
		</uni-popup>
	</view>
</template>

<script>
import uniDrawer from '@/components/uni-drawer.vue';
import uniIcon from '../../components/uni-icon.vue';
import uniPopup from '@/components/uni-popup.vue';
import qqjy from './qqjy.vue'
import { mapState } from 'vuex';
export default {
	components: {
		uniDrawer,
		uniIcon,
		uniPopup,
		qqjy
	},
	data() {
		return {
			url:'',
			active:1,
			leftStatus: false,
			quoteCurrencyId: '',
			quoteCurrencyIds: '',
			quoteCurrencyCode: '',
			baseCurrencyId: '',
			baseCurrencyCode: '',
			leverTradeType: 'buy',
			priceValue: this.$t('trade.best'),
			priceStatus: 1,
			quotationList: [],
			quoteIndex: 0,
			baseIndex: 0,
			linkStatus: false,
			minShare: 0,
			maxShare: 0,
			changes: '',
			currencyMatchId: 1,
			ptype: 0,
			leverOrder: {
				shareNUm: 0,
				mult: 0,
				share: 1,
				fee: '',
				spread: '',
				fees: '',
				bonds: '',
				passwords: '',
				marketPrice: ''
			},
			multShare: {},
			leverBalance: '0',
			sellList: [],
			buyList: [],
			newPrice: 0,
			cny: 1,
			orderList: [],
			showModal: false,
			tipbtnShow: true,
			title: this.$t('trade.confrim_order'),
			// 平仓弹窗
			closeTrades: {
				closeTradeShow: false,
				title: '',
				orderId: ''
			},
			tradeTypes: {
				shows: false,
				types: 'bottom'
			},
			mults: {
				shows: false,
				types: 'bottom'
			},
			shares: {
				shows: false,
				types: 'bottom'
			},
			timer: '',
			timers: '',
			langs: '',
			soon:false,
				announcementModal:{
				showModal: false,
				title: '',
				content: '',
				tipbtnShow: false
			}
		};
	},
	filters: {
		toFixed2: function(value) {
			value = Number(value);
			return value.toFixed(2);
		},
		toFixed4: function(value) {
			value = Number(value);
			return value.toFixed(4);
		}
	},
	onLoad(e) {
		let type = e.type || '';
		var that = this;
		if (e.quoteCurrencyId) {
			that.quoteCurrencyId = e.quoteCurrencyId;
			that.baseCurrencyId = e.baseCurrencyId;
			that.linkStatus = true;
		}
	//	this.setIcon()
	},
	onPullDownRefresh() {
		this.init();
	},
	onShow() {
		if(uni.getStorageSync('active')){
			this.active= JSON.parse(uni.getStorageSync('active'))
			uni.removeStorageSync('active')
		}
		
		var that = this;
		let tradeType = uni.getStorageSync('tradeType');//leverActive
		// this.active=uni.getStorageSync('leverActive')
		// if(this.active==0){
		// 	this.active=0
		// }else{
		// 	this.active=1
		// }
		if(tradeType){
			that.leverTradeType= tradeType
			uni.removeStorageSync('tradeType')
		}
		this.init();
		if(this.active==1){
			that.getTime();
		}
		if(that.active == 2){
			this.$refs.qqjy.setup()
		}
		that.langs = uni.getStorageSync('lang') || 'hk';
		console.log(that.langs,333);
		that.$utils.setThemeTop(that.theme);
		that.$utils.setThemeBottom(that.theme);
		this.getAnnouncement();
	},
	onHide() {
		this.$socket.closeSocket();
		// this.url=''
		this.leftStatus = false;	//关闭头部左边币种列表
	},
	computed: {
		...mapState(['theme']),
		buyMax() {
			//买盘最大数量
			let list = [],
				data = this.buyList;
			data.map(item => {
				list.push(item.amount);
			});
			return Math.max.apply(null, list);
		},
		sellMax() {
			//卖盘最大数量
			let list = [],
				data = this.sellList;
			data.map(item => {
				list.push(item.amount);
			});
			return Math.max.apply(null, list);
		},
		isOnline(){
			 return (time)=>{
				 if(!time)return false;
				let date = new Date(time.replace(/-/g,'/')).getTime(),
					currentDate = new Date().getTime();
				return date <= currentDate; 
			 };
		}
	},
	methods: {
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
		hideBtn1(){
			this.announcementModal.showModal = false;
		},
		setActive(val){

			uni.pageScrollTo({
				scrollTop:0,
				duration:0
			})
			let that = this
			that.active = val;
			uni.setStorageSync('leverActive', val);
			if(val==0){
				// var ui  = 'dark'
				// this.$store.dispatch("changeTheme",ui);
				this.$socket.closeSocket()
				that.url=`/hybrid/html/index.html?legal_id=${that.quoteCurrencyId}&currency_id=${that.baseCurrencyId}&symbol=${that.baseCurrencyCode + '/' + that.quoteCurrencyCode}&currency_match_id=${that.currencyMatchId}&type=lever`
			}else if(val==1){
				that.url=''
				this.init()
			}else if(val ==2){
				this.$socket.closeSocket()
			}
		},
		getTime() {
			var that = this;
			that.timer = new Date().getTime();
			that.timers = new Date().getTime() + 1000;
		},
		shows() {
			return;
		},
		init() {
			var that = this;
			if (!that.linkStatus) {
				if (uni.getStorageSync('leverOrder')) {
					var leverOrderData = JSON.parse(uni.getStorageSync('leverOrder'));
					that.quoteCurrencyId = leverOrderData.quoteCurrencyId;
					that.baseCurrencyId = leverOrderData.baseCurrencyId;
				}
			}
			that.$utils.initDataToken({ url: 'market/currency_matches' }, res => {
				uni.stopPullDownRefresh();
				if (res.length > 0) {
					var datas = res.filter(function(item, index) {
						return item.is_quote == 1;
					});
					that.quotationList = datas;
					if (that.quoteCurrencyId) {
						that.quoteCurrencyIds = that.quoteCurrencyId;
						datas.forEach(function(item, index) {
							if (that.quoteCurrencyId == item.id) {
								that.quoteCurrencyCode = item.code;
								that.quoteIndex = index;
								that.cny = item.cny_price;
								var data1 = item.matches;
								var lists = data1.filter(function(items, index) {
									return items.open_lever == 1;
								});
								if (lists.length > 0) {
									lists.forEach(function(itm, inx) {
										if (that.baseCurrencyId == itm.base_currency_id) {
											that.baseIndex = inx;
											that.baseCurrencyCode = itm.base_currency_code;
											that.soon = itm.base_currency_code=='MUT' && !that.isOnline(itm.market_time)
											that.leverOrder.shareNUm = itm.lever_share_num;
											that.leverOrder.spread = itm.lever_point_rate;
											that.leverOrder.fee = itm.lever_fee_rate;
											that.changes = itm.currency_quotation.change;
											that.currencyMatchId = itm.id;
											if(that.active==0){
												that.url=`/hybrid/html/index.html?legal_id=${that.quoteCurrencyId}&currency_id=${that.baseCurrencyId}&symbol=${that.baseCurrencyCode + '/' + that.quoteCurrencyCode}&currency_match_id=${that.currencyMatchId}&type=lever`
											}
											if(that.active==1){
												that.handicap();
											}
											
											that.deals();
											return false;
										}
									});
								}
							}
						});
					} else {
						var list = datas[0].matches.filter(function(item, index) {
							return item.open_lever == 1;
						});
                        console.log(list)
						console.log(datas)
						console.log(list)
						that.cny = datas[0].cny_price;
						that.quoteCurrencyCode = datas[0].code;
						that.quoteCurrencyId = datas[0].id;
						that.baseCurrencyId = list[0].base_currency_id;
						that.baseCurrencyCode = list[0].base_currency_code;
						that.soon = list[0].base_currency_code=='MUT' && !this.isOnline(list[0].market_time)
						that.leverOrder.shareNUm = list[0].lever_share_num;
						that.leverOrder.spread = list[0].lever_point_rate;
						that.leverOrder.fee = list[0].lever_fee_rate;
						that.quoteCurrencyIds = datas[0].id;
						that.changes = list[0].currency_quotation.change;
						that.currencyMatchId = list[0].id;
						if(that.active==0){
							that.url=`/hybrid/html/index.html?legal_id=${that.quoteCurrencyId}&currency_id=${that.baseCurrencyId}&symbol=${that.baseCurrencyCode + '/' + that.quoteCurrencyCode}&currency_match_id=${that.currencyMatchId}&type=lever`
						}
						that.handicap();
						that.deals();
					}
				}
			});
		},
		deals() {
			var that = this;
			that.$utils.initDataToken({ url: 'lever/deal', type: 'POST', data: { currency_match_id: that.currencyMatchId } }, res => {
				that.multShare = res.multiple;
				that.buyList = [];
				that.sellList = [];
				that.minShare = res.lever_share_limit.min;
				that.maxShare = res.lever_share_limit.max;

				that.newPrice = res.last_price;
				if (res.multiple.muit.length > 0) {
					that.leverOrder.mult = res.multiple.muit[0].value;
				}
				// if (res.multiple.share.length > 0) {
				// 	that.leverOrder.share = res.multiple.share[0].value;
				// }
				that.orderList = res.my_transaction;
				that.leverBalance = res.user_lever;
			});
		},
		// 交易类型切换
		tradeType(vals) {
            console.log(111)
			var that = this;
			that.leverTradeType = vals;
			that.leverOrder.share = '';
		},
		// 价格类型切换
		priceTab(vals) {
			var that = this;
			that.priceStatus = vals;
			that.tradeTypes.shows = false;
			if (vals == 1) {
				that.priceValue = this.$t('trade.best');
			} else {
				that.priceValue = (that.newPrice - 0).toFixed(4);
			}
		},
		selectmult(vals) {
			var that = this;
			that.leverOrder.mult = vals;
			that.mults.shows = false;
		},
		// 选择手数
		selectShare(vals) {
			var that = this;
			that.leverOrder.share = vals;
			that.shares.shows = false;
		},
		// 下单计算
		calculation(prices) {
			// 价格+或者-点差  * 手数 * 每手数量  /倍数
			var that = this;
			var spreadPrices = parseFloat((prices * that.leverOrder.spread) / 100);
			var pricesTotal = 0;
			if (that.leverTradeType == 'sell') {
				pricesTotal = parseFloat(prices - spreadPrices);
			} else {
				pricesTotal = parseFloat(prices + spreadPrices);
			}
			console.log(that.leverOrder.fee);
			var shareNum = parseFloat(that.leverOrder.shareNUm); //每手数量
			var totalPrice = parseFloat(pricesTotal * that.leverOrder.share * shareNum); //保证金
			that.leverOrder.bonds = parseFloat((totalPrice - 0) / (that.leverOrder.mult - 0)).toFixed(4);
			that.leverOrder.fees = parseFloat(totalPrice * that.leverOrder.fee).toFixed(4); //合约市值
			that.leverOrder.marketPrice = parseFloat(pricesTotal * that.leverOrder.share * shareNum).toFixed(4);
		},
		// 下单
		submits() {
			var that = this;
			if (!that.leverOrder.mult) {
				that.$utils.showLayer(this.$t('trade.p_times'));
				return false;
			}
			if (!that.leverOrder.share) {
				that.$utils.showLayer(this.$t('trade.p_hands'));
				return false;
			}
			if (that.priceStatus == 0) {
				if (!that.priceValue) {
					that.$utils.showLayer(this.$t('trade.p_delprice'));
					return false;
				} else {
					that.calculation(that.priceValue);
				}
			} else {
				that.calculation(that.newPrice);
			}
			if (that.leverOrder.share < that.minShare) {
				that.$utils.showLayer(this.$t('trade.p_notless') + that.minShare);
				return false;
			}
			if (that.leverOrder.share > that.maxShare) {
				that.$utils.showLayer(this.$t('trade.p_notmore') + that.maxShare);
				return false;
			}

			that.showModal = true;
			that.shows = false;
			that.title = that.$t('trade.confrim_order');
			that.getTime();
			that.leverOrder.passwords = '';
		},
		// 取消弹窗
		hideBtn() {
			console.log(111111)
			var that = this;
			that.shares.shows = false;
			that.showModal = false;
			that.closeTrades.closeTradeShow = false;
			that.shows = true;
			that.tradeTypes.shows = false;
			that.mults.shows = false;
		},
		// 确定下单
		confirmBtn() {
			var that = this;
			if (!that.leverOrder.passwords) {
				that.$utils.showLayer(this.$t('login.e_pdeal'));
				return false;
			}
			that.showModal = false;
			that.$utils.initDataToken(
				{
					url: 'lever/submit',
					type: 'POST',
					data: {
						share: that.leverOrder.share,
						multiple: that.leverOrder.mult,
						currency_match_id: that.currencyMatchId,
						type: that.leverTradeType == 'buy' ? 1 : 2,
						status: that.priceStatus,
						target_price: that.priceValue,
						password: that.leverOrder.passwords
					}
				},
				(res,msg) => {
					console.log(222,res,222);
					
					that.$utils.showLayer(msg);
					that.deals();

					// setTimeout(function() {
					// 	if (that.priceStatus == 0) {
					// 		uni.navigateTo({
					// 			url: 'leverList'
					// 		});
					// 	} else {
					// 		uni.navigateTo({
					// 			// url: 'orderList?quoteCurrencyId=' + that.quoteCurrencyId + '&baseCurrencyId=' + that.baseCurrencyId
					// 			url: 'orderList?currencyMatchId=' + that.currencyMatchId
					// 		});
					// 	}
					// }, 1000);
				}
			);
		},
		// 选择法币
		selectedLegal(ids) {
			var that = this;
			that.quoteCurrencyIds = ids;
			for (var i = 0; i < that.quotationList.length; i++) {
				if (that.quotationList[i].id == ids) {
					that.quoteIndex = i;
				}
			}
		},
		// 选择交易对
		selectCurrency(options) {
			var that = this;
			console.log(options);
			that.$socket.closeSocket();
			that.quoteCurrencyCode = options.quote_currency_code;
			that.quoteCurrencyId = options.quote_currency_id;
			that.baseCurrencyId = options.base_currency_id;
			that.baseCurrencyCode = options.base_currency_code;
			that.soon = options.base_currency_code=='MUT' && !this.isOnline(options.market_time)
			that.leverOrder.shareNUm = options.lever_share_num;
			that.leverOrder.spread = options.lever_point_rate;
			that.leverOrder.fee = options.lever_fee_rate;
			that.quoteCurrencyIds = options.quote_currency_id;
			that.changes = options.currency_quotation.change;
			that.currencyMatchId = options.id;
			that.leftStatus = false;
			var data = {
				quoteCurrencyId: that.quoteCurrencyId,
				baseCurrencyId: that.baseCurrencyId
			};
			that.url=`/hybrid/html/index.html?legal_id=${that.quoteCurrencyId}&currency_id=${that.baseCurrencyId}&symbol=${that.baseCurrencyCode + '/' + that.quoteCurrencyCode}&currency_match_id=${that.currencyMatchId}&type=lever`
			uni.setStorageSync('leverOrder', JSON.stringify(data));
			if(that.active==1){
				that.handicap();
			}
			that.deals();
		},
		// 平仓弹窗
		closeTrade(ids) {
			var that = this;
			that.closeTrades.orderId = ids;
			that.closeTrades.closeTradeShow = true;
			that.getTime();
			that.shows = false;
		},
		// 确定平仓
		comfirmClose() {
			var that = this;
			that.closeTrades.closeTradeShow = false;
			that.$utils.initDataToken(
				{
					url: 'lever/close',
					type: 'POST',
					data: {
						id: that.closeTrades.orderId
					}
				},
				(res,msg)=> {
					that.$utils.showLayer(msg);
					setTimeout(function() {
						that.closeTrades.orderId = '';
						that.deals();
					}, 1000);
				}
			);
		},
		// 跳转k线
		linkFutures() {
			var that = this;
			var symbols = that.baseCurrencyCode + '/' + that.quoteCurrencyCode;
			uni.navigateTo({
				url: '/pages/contract/futures?legal_id=' + that.quoteCurrencyId + '&currency_id=' + that.baseCurrencyId + '&symbol=' + symbols +'&currency_match_id='+that.currencyMatchId+'&type=lever'
			});
		},
		// 跳转k线
		linkKline() {
			var that = this;
			var symbols = that.baseCurrencyCode + '/' + that.quoteCurrencyCode;
			uni.navigateTo({
				url: '/pages/market/kline?legal_id=' + that.quoteCurrencyId + '&currency_id=' + that.baseCurrencyId + '&symbol=' + symbols +'&currency_match_id='+that.currencyMatchId
			});
		},
		// 跳转合约订单记录
		linkLever() {
			var that = this;
			var symbols = that.baseCurrencyCode + '/' + that.quoteCurrencyCode;
			if(this.active==0){
				uni.navigateTo({
					url: `/pages/market/order?currency_id=${that.baseCurrencyId}&currency_match_id=${that.currencyMatchId}&symbol=${symbols}`                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       

				})
			}else if(this.active==1){
				uni.navigateTo({
					url: '/pages/lever/leverList'
				});
			}
			
		},
		// 跳转全部委托
		totalOrder() {
			var that = this;
			uni.navigateTo({
				// url: 'orderList?quoteCurrencyId=' + that.quoteCurrencyId + '&baseCurrencyId=' + that.baseCurrencyId
				url: '/pages/lever/orderList?currencyMatchId=' + that.currencyMatchId
			});
		},
		bindChange() {},
		// 盘口socket
		handicap() {
			var that = this;
			var tokens = uni.getStorageSync('token');
			var symbols = that.baseCurrencyCode + '/' + that.quoteCurrencyCode;
			var datas = {};
			that.$socket.listenFun([{ type: 'login', params: tokens }, { type: 'sub', params: 'MARKET_DEPTH.' + symbols }, { type: 'sub', params: 'DAY_MARKET' }], res => {
				let msg = JSON.parse(res)
				if (msg.type == 'MARKET_DEPTH') {
					that.buyList = msg.depth.in;
					that.sellList = msg.depth.out.reverse();
				}
				if (msg.type == 'DAY_MARKET') {
					if (that.currencyMatchId == msg.currency_match_id) {
						that.newPrice = msg.quotation.close;
					}
					that.quotationList.forEach((item, index) => {
						var datas = item.matches;
						datas.forEach((itm, inx) => {
							if (itm.currency_id == msg.currency_id && itm.legal_id == msg.legal_id) {
								return (that.quotationList[index].matches[inx].now_price = msg.now_price);
							}
						});
					});
				}
			});
		}
	}
};
</script>