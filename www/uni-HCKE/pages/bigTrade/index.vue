<template>
	<view :class="theme">
		<view class="text-black dark:text-white">
			<view class="w-full flex flex-col py-20 px-40 border-0 border-solid border-b-2 border-gray-100 bg-white dark:bg-gray-600 dark:bg-opacity-30">
					
					<view class="flex justify-between items-center">
						<view class="flex items-center" @tap="leftStatus = true">
							<image src="/static/image/list.png" mode="aspectFit" class="w-40 h-40"></image>
							<view class="mx-20 text-lg font-bold">{{ currentMatch.Code}}</view>
							<view v-if="currentMatch.ForexQuotations && currentMatch.MarketStatus==1"  :class="currentMatch.ForexQuotations.Change < 0 ? 'text-danger': 'text-success'">{{ currentMatch.ForexQuotations.Change || '0.00' | filterDecimals }}%</view>
						</view>
						<view v-if="currentMatch.MarketStatus && currentMatch.MarketStatus!=1" class="py-10 px-20 rounded-10 border-2 border-solid" style="border-color:rgba(246, 70, 93,1);color:rgba(246, 70, 93,1);">{{$t('bigTrade.closed')}}</view>
						<view class="flex justify-center items-center">
							<image v-if="active==1 && !soon" src="/static/image/datamap.png" mode="aspectFit" class="w-40 h-40" @tap="linkKline"></image>
							<image src="/static/image/record1.png" mode="aspectFit" class="w-30 h-30 ml-10" @tap="linkLever"></image>
						</view>
					</view>
				</view>
			
			<view class="flex justify-center items-center text-3xl h-600" v-if="soon">{{$t('trade.soon')}}</view>
			<view v-if="!soon" class="min-h-screen bg-gray-100 dark:bg-floor">
				<!-- <view class="flex justify-center items-center text-3xl h-600" v-if="soon">{{$t('trade.soon')}}</view> -->
				<view class="flex justify-between p-20 bg-white dark:bg-gray-600 dark:bg-opacity-30">
					<view class="w-3_5">
						<view class="overflow-hidden flex justify-between rounded-10 bg-gray-100 dark:bg-gray-600 dark:bg-opacity-30 dark:text-white">
							<view class="text-center flex justify-center items-center flex-1 h-66 relative" :class="leverTradeType == 'buy' ? 'bg-success text-white' : ''" @tap="tradeType('buy')">
								{{ $t('trade.buy') }}
								<view class="w-0 h-0 absolute right-0 bottom-0" 
								:style="`border-top: 16px solid #${ theme == 'light'?'f3f4f6':'272f39' };border-left: 16px solid transparent;border-bottom: 18px solid #${ theme == 'light'?'f3f4f6':'272f39' };`"></view>
							</view>
							<view class="text-center flex justify-center items-center flex-1 h-66 relative" :class="leverTradeType == 'sell' ? 'bg-danger text-white' : ''" @tap="tradeType('sell')">
								{{ $t('trade.sell') }}
								<view class="w-0 h-0 absolute left-0 bottom-0" 
								:style="`border-top: 16px solid #${ theme == 'light'?'f3f4f6':'272f39' };border-right: 16px solid transparent;border-bottom: 18px solid #${ theme == 'light'?'f3f4f6':'272f39' };`"></view>
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
						<view class="mt-20">
							1{{$t('bigTrade.zhang')}} = {{currentMatch.ForexContNum}}{{currentMatch.Code}}
						</view>
						<view class="mt-20 text-lg">
							<view class="">{{ $t('bigTrade.mrsl') }}</view>
										 
							<view class="flex justify-between items-center my-20 border-2 border-solid border-gray-400 dark:border-gray-600 px-20 rounded-8">
								<view class="flex-1 h-60 flex items-center">
									<input class="text-black dark:text-white text-sm" placeholder-class="text-gray-600 flex-1" type="number" v-model="leverOrder.share" :placeholder="$t('bigTrade.enterNumber')" />
								</view>
								<image src="../../static/image/pull.png" mode="aspectFit" class="w-30 h-30 ml-20" @tap="shares.shows = true" v-if="multShare.share && multShare.share.length > 0"></image>							<!-- 	<view class="">
									<view class="border-2 border-solid border-gray-600 dark:border-gray-400 h-60 flex items-center justify-between px-10 ml-10 rounded-8">
										<text>{{ leverOrder.share }}</text>
									</view>
								</view> -->
								
							</view>
						</view>
						<view class="mt-20 text-lg flex items-center justify-between">
							<text>{{ $t('trade.balance') }}：{{ leverBalance | toFixed4 }} {{ quoteCurrencyCode }}</text>
							<navigator url="/pages/bigTrade/exchange" class="mt-8 px-10 bg-my-green text-white rounded-8 py-4 mr-10">{{$t('new.duih')}}</navigator>
						</view>
						<view class="h-70 flex justify-center items-center mt-30 rounded-10" :class="[currentMatch.MarketStatus!=1 ?'bg-gray-500': leverTradeType == 'buy' ? 'bg-success' : 'bg-danger']" @tap="submits">
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
							<view class="text-2xl" v-if="currentMatch.ForexQuotations">{{ currentMatch.ForexQuotations.Close }}</view>
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
								<image src="/static/image/pan1.svg" mode="aspectFit" class="w-30 h-30"></image>
							</view>
							<view :class="['w-40 h-40 flex items-center justify-center rounded-4 border-2 border-solid border-gray-400 ml-10', { 'border-primary': ptype == 1 }]" @click="ptype = 1">
								<image src="/static/image/pan2.svg" mode="aspectFit" class="w-30 h-30"></image>
							</view>
							<view :class="['w-40 h-40 flex items-center justify-center rounded-4 border-2 border-solid border-gray-400 ml-10', { 'border-primary': ptype == 2 }]" @click="ptype = 2">
								<image src="/static/image/pan3.svg" mode="aspectFit" class="w-30 h-30"></image>
							</view>
						</view>
					</view>
				</view>
				<!-- 当前委托列表 -->
				<view class="mt-20 p-20 bg-white dark:bg-gray-600 dark:bg-opacity-30 pb-120 min-h-half">
					<view class="flex justify-between">
						<view class="text-xl">{{ $t('trade.delegate') }}</view>
						<view class="flex items-center" @tap="totalOrder">
							<image src="../../static/image/record1.png" mode="aspectFit" class="w-40 h-40"></image>
							<view class="mx-10 text-lg">{{ $t('trade.chicang') }}</view>
						</view>
					</view>
					<view class="mt-40">
						<view class="flex justify-between">
							<view class="flex-1 text-left">{{ $t('trade.types') }}</view>
							<view class="flex-2 text-center">{{ $t('trade.time') }}</view>
							<view class="flex-2 text-center">{{ $t('trade.price') }}</view>
							<view class="flex-2 text-center">{{ $t('trade.amout') }}</view>
							<view class="flex-1 text-center">{{ $t('trade.operate') }}</view>
						</view>
						<view class="" v-if="orderList.length > 0">
							<view v-for="(item, index) in orderList" :key="index" class="flex justify-between items-center mt-20">
								<view class="flex-1 text-left">{{ item.OrderType ==1 ? $t('trade.buy'): $t('trade.sell') }}</view>
								<view class="flex-2 text-center">{{ item.CreateTimeHandler }}</view>
								<view class="flex-2 text-center">{{ item.Price || '0.0000' | toFixed4 }}</view>
								<view class="flex-2 text-center">{{ item.Quantity || '0.00' | toFixed2 }}</view>
								<view class="flex-1 text-center bg-primary py-10 rounded-8 ml-20 text-black" @tap="closeTrade(item.Id)">{{ $t('trade.pingcang') }}</view>
							</view>
						</view>
						<view class="text-center p-200" v-if="orderList.length == 0">
							<image src="../../static/image/anonymous.png" mode="aspectFit" class="w-160 h-160"></image>
							<view class="text-center">{{ $t('home.norecord') }}</view>
						</view>
					</view>
				</view>
			</view>
			
			<!-- 头部左边币种列表内容 -->
			<uni-drawer :visible="leftStatus" @close="leftStatus = false" v-if="quotationList.length > 0">
				<!--  
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
				-->
					
				<scroll-view scroll-y="true" style="height:calc(100% - 50px)" v-if="quotationList.length > 0">
					<view class="pb-60">
						<view class="border-0 border-b-2 border-solid border-gray-100 dark:border-gray-700 text-black dark:text-white" v-for="(item, index) in quotationList" :key="index">
							<view
								class="flex items-center justify-between px-20 py-40"
								:class="currentMatch.Id == item.Id ? 'bg-gray-200 dark:bg-gray-600' : ''"
								@tap="selectCurrency(item)"
							>
								<view class="">
									<text class="text-2xl">{{ item.Code }}</text>
								</view>
								<view v-if="item.MarketStatus!=1">{{$t('bigTrade.closed')}}</view>
								<view :class="item.ForexQuotations.Change < 0 ? 'text-danger' : 'text-success'" v-else>{{ item.ForexQuotations.Close || '0.00' }}</view>
								<!-- <view :class="item.ForexQuotations.Change < 0 ? 'red' : 'green'">{{ item.ForexQuotations.Close || '0.00' }}</view> -->
							</view>
						</view>
					</view>
				</scroll-view>
			</uni-drawer>
			
			<!-- 下单弹窗 -->
			<uni-popup :show="showModal" @hidePopup="hideBtn" @comfirmPopup="confirmBtn" :msg="title" :btnShow="tipbtnShow" :key="timer" :lang="langs">
				<view class="w-full p-40 ">
					<view class="text-lg">
						<view class="">{{ currentMatch.Code }}</view>
						<view class="flex justify-between mt-20 ">
							<view class="text-lg">{{ $t('trade.types') }}</view>
							<view class="text-lg">{{ leverTradeType == 'buy' ? $t('trade.duo') : $t('trade.kong') }}</view>
						</view>
						<view class="flex justify-between mt-20">
							<view class="text-lg">{{ $t('bigTrade.mrsl') }}</view>
							<view class="text-lg">{{ leverOrder.share }}</view>
						</view>
						<view class="flex justify-between mt-20">
							<view class="text-lg">{{ $t('bigTrade.ggbs') }}</view>
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
						<!-- <view class="mt-20 border-solid border-2 border-gray-300 p-20">
							<input type="text" class="text-black" password v-model="leverOrder.passwords" :placeholder="$t('login.e_pdeal')" />
						</view> -->
					</view>
				</view>
			</uni-popup>
			
			<!-- 平仓弹窗 -->
			<uni-popup :show="closeTrades.closeTradeShow" @hidePopup="hideBtn" @comfirmPopup="comfirmClose" :msg="closeTrades.title" :key="timers" :lang="langs">
				<view class="p-40 flex-1 text-xl">{{ $t('trade.confrim_ping') }}？</view>
			</uni-popup>
			
			<!-- 交易类型 -->
			<uni-popup :show="tradeTypes.shows" @hidePopup="hideBtn" :type="tradeTypes.types" :btnShow="false" :bgColor="false" :lang="langs">
				<view class="w-full bg-white dark:bg-floor text-black dark:text-white fixed bottom-0 left-0 pb-180">
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30" @tap="priceTab(1)">{{ $t('trade.shi') }}</view>
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30" @tap="priceTab(0)">{{ $t('trade.limit') }}</view>
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30 border-0 border-t-2 border-solid border-gray-200 dark:border-gray-900" @tap.stop="hideBtn">{{ $t('trade.cancel') }}</view>
				</view>
			</uni-popup>
			
			<!-- 倍数弹窗 -->
			<uni-popup :show="mults.shows" @hidePopup="hideBtn" :type="mults.types" :btnShow="false" :bgColor="false" :lang="langs">
				<view class="w-full bg-white dark:bg-floor text-black dark:text-white fixed bottom-0 left-0 pb-180">
					<view class="flex1 text-lg w-full flex items-center justify-center py-30" v-for="(item, index) in currentMatch.HasForexMultiple" :key="index" @tap="selectmult(item.Value)">
						{{ item.Value }}
					</view>
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30 border-0 border-t-2 border-solid border-gray-200 dark:border-gray-900" @tap.stop="hideBtn">{{ $t('trade.cancel') }}</view>
				</view>
			</uni-popup>
			
			<!-- 手数弹窗 -->
			<uni-popup class="bt-pop" :show="shares.shows" @hidePopup="hideBtn" :type="shares.types" :btnShow="false" :bgColor="false" :lang="langs">
				<view class="w-full bg-white dark:bg-floor text-black dark:text-white fixed bottom-0 left-0 pb-180">
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30" v-for="(item, index) in multShare.share" :key="index" @tap="selectShare(item.value)">
						{{ item.value }}
					</view>
					<view class="flex-1 text-lg w-full flex items-center justify-center py-30 border-0 border-t-2 border-solid border-gray-200 dark:border-gray-900" @tap.stop="hideBtn">{{ $t('trade.cancel') }}</view>
				</view>
			</uni-popup>
		</view>
	</view>
</template>

<script>
import uniDrawer from '@/components/uni-drawer.vue';
import uniIcon from '../../components/uni-icon.vue';
import uniPopup from '@/components/uni-popup.vue';
import { mapState } from 'vuex';
export default {
	components: {
		uniDrawer,
		uniIcon,
		uniPopup
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
				mult: '',
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

			currentMatch:{}
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
        uni.setNavigationBarTitle({
          title:this.$t('bigTrade.bigTrade')
      })
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
		that.langs = uni.getStorageSync('lang') || 'hk';
		that.$utils.setThemeTop(that.theme);
		that.$utils.setThemeBottom(that.theme);
	},
	onHide() {
		this.$newSocket.closeSocket();
		this.url=''
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
			let bigTradeOrderData
			if (!that.linkStatus) {
				if (uni.getStorageSync('bigTradeOrder')) {
					bigTradeOrderData = JSON.parse(uni.getStorageSync('bigTradeOrder'));
					// that.quoteCurrencyId = leverOrderData.quoteCurrencyId;
					// that.baseCurrencyId = leverOrderData.baseCurrencyId;
				}
			}
			that.$utils.httpDataToken({ url: 'forex/trade_list' }, res => {
				uni.stopPullDownRefresh();
				if (res.length > 0) {
					that.quotationList = res;
					if (bigTradeOrderData) {
						const match = that.quotationList.find((item)=>item.Id == bigTradeOrderData.Id)
						that.currentMatch =  match || that.quotationList[0]
					} else {
						that.currentMatch =  that.quotationList[0]
					}
				}
				that.handicap();
				that.deals();
			});
		},
		deals() {
			var that = this;
			that.$utils.httpDataToken({ url: 'forex/deal', type: 'get', data: { forex_id: that.currentMatch.Id } }, res => {
				console.log(res);
				
				// that.multShare = res.multiple;
				that.buyList = [];
				that.sellList = [];
				that.minShare = res.forex_cont_limit.min;
				that.maxShare = res.forex_cont_limit.max;

				// that.newPrice = res.last_price;
				if (that.currentMatch.HasForexMultiple.length > 0) {
					that.leverOrder.mult = that.currentMatch.HasForexMultiple[0].Value;
				}
				// if (res.multiple.share.length > 0) {
				// 	that.leverOrder.share = res.multiple.share[0].value;
				// }
				that.orderList = res.my_transaction;
				that.leverBalance = res.forex_user_balance;
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
				that.priceValue = (that.currentMatch.ForexQuotations.Close).toFixed(4);
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
			// var spreadPrices = Number(
			// 	(prices * that.currentMatch.ForexPointRate) / 100
			// );
			// var pricesTotal = 0;
			// if (that.leverTradeType == 'sell') {
			// 	pricesTotal = parseFloat(prices - spreadPrices);
			// } else {
			// 	pricesTotal = parseFloat(prices + spreadPrices);
			// }
			var shares = parseFloat(that.leverOrder.share); //每手数量
			console.log(shares,'shares');
			
			// 计算保证金的话就是 (张数*每张数量*现在价格)/倍数
			that.leverOrder.bonds = ((shares*that.currentMatch.ForexContNum*prices)/(that.leverOrder.mult - 0)).toFixed(6)
      		that.leverOrder.fees =  (that.leverOrder.bonds *that.currentMatch.ForexFeeRate).toFixed(6)
		},
		// 下单
		submits() {
			if(this.currentMatch.MarketStatus!=1){
				return
			}
			var that = this;
			if (!that.leverOrder.mult) {
				that.$utils.showLayer(this.$t('bigTrade.qxzggbs'));
				return false;
			}
			if (!that.leverOrder.share) {
				that.$utils.showLayer(this.$t('bigTrade.enterNumber'));
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
				that.calculation(that.currentMatch.ForexQuotations.Close);
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
			// if (!that.leverOrder.passwords) {
			// 	that.$utils.showLayer(this.$t('login.e_pdeal'));
			// 	return false;
			// }
			that.showModal = false;
			that.$utils.httpDataToken(
				{
					url: 'forex/submit',
					type: 'get',
					data: {
						cont: that.leverOrder.share,
						multiple: that.leverOrder.mult,
						forex_id: that.currentMatch.Id,
						type: that.leverTradeType == 'buy' ? 1 : 2,
						status: that.priceStatus,
						target_price: that.priceValue,
						// password: that.leverOrder.passwords
					}
				},
				(res,msg) => {
					that.$utils.showLayer(msg);
					that.deals()
					setTimeout(function() {
						if (that.priceStatus == 0) {
							uni.navigateTo({
								url: 'leverList'
							});
						} else {
							uni.navigateTo({
								// url: 'orderList?quoteCurrencyId=' + that.quoteCurrencyId + '&baseCurrencyId=' + that.baseCurrencyId
								url: 'orderList?currencyMatchId=' + that.currencyMatchId
							});
						}
					}, 1000);
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
			if(options.Id == this.currentMatch.Id){
				return
			}
			this.currentMatch = options
			if(this.currentMatch.HasForexMultiple.length){
				this.leverOrder.mult = this.currentMatch.HasForexMultiple[0].Value
			}else{
				this.leverOrder.mult = ''
			}
			uni.setStorageSync('bigTradeOrder', JSON.stringify(options));
			this.leftStatus = false;
			this.$newSocket.closeSocket();
			this.handicap();
			// that.quoteCurrencyCode = options.quote_currency_code;
			// that.quoteCurrencyId = options.quote_currency_id;
			// that.baseCurrencyId = options.base_currency_id;
			// that.baseCurrencyCode = options.base_currency_code;
			// that.soon = options.base_currency_code=='TEST' && !this.isOnline(options.market_time)
			// that.leverOrder.shareNUm = options.lever_share_num;
			// that.leverOrder.spread = options.lever_point_rate;
			// that.leverOrder.fee = options.lever_fee_rate;
			// that.quoteCurrencyIds = options.quote_currency_id;
			// that.changes = options.currency_quotation.change;
			// that.currencyMatchId = options.id;
			// var data = {
			// 	quoteCurrencyId: that.quoteCurrencyId,
			// 	baseCurrencyId: that.baseCurrencyId
			// };
			this.deals();
		},
		// 平仓弹窗
		closeTrade(ids) {
			console.log(ids,'ids');
			
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
			that.$utils.httpDataToken(
				{
					url: 'forex/close',
					type: 'get',
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
			var symbols = that.currentMatch.Code;
			uni.navigateTo({
				url: '/pages/bigTrade/kline?symbol=' + symbols +'&currency_match_id='+that.currentMatch.Id
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
					url: '/pages/bigTrade/tradeList'
				});
			}
			
		},
		// 跳转全部委托
		totalOrder() {
			var that = this;
			uni.navigateTo({
				// url: 'orderList?quoteCurrencyId=' + that.quoteCurrencyId + '&baseCurrencyId=' + that.baseCurrencyId
				url: '/pages/bigTrade/tradeList?currencyMatchId=' + that.currencyMatchId
			});
		},
		bindChange() {},
		// 盘口socket
		handicap() {
			var that = this;
			var tokens = uni.getStorageSync('token');
			var symbols = that.currentMatch.Code
			const topics = [
			{ type: 'login', params: tokens }, 
			{ type: 'sub', params: 'DAY_MARKET' },
			{ type: 'sub', params: 'FOREX_CLOSED' }
			]
			if(that.currentMatch.MarketStatus==1){
				topics.push({ type: 'sub', params: 'MARKET_DEPTH.' + symbols })
			}else{
				that.buyList = []
				that.sellList = []
			}
			that.$newSocket.listenFun(topics, res => {
				let msg = JSON.parse(res)
				
				if (msg.type == 'MARKET_DEPTH') {
					that.buyList = msg.depth.in;
					that.sellList = msg.depth.out;
				}
				if (msg.type == 'DAY_MARKET') {
					if (that.currentMatch.Code == msg.symbol) {
						that.currentMatch.ForexQuotations.Close = msg.quotation.close;
						that.currentMatch.ForexQuotations.Change = msg.quotation.change
					}
					that.quotationList.forEach((item)=>{
						if(item.Code=== msg.symbol ){
						item.ForexQuotations.Close = msg.quotation.close;
						item.ForexQuotations.Change = msg.quotation.change
						}
					})
				}

				if (msg.type == 'FOREX_CLOSED') {
					let closeList = msg.id;
					closeList.map((item)=>{
						const index = that.orderList.findIndex((order)=> order.Id == item)
						if(index != undefined){
							that.orderList.splice(index, 1);
						}
					})
				}
			});
		}
	}
};
</script>