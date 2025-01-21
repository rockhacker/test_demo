<template>
	<view :class="theme">
		<view class="bg-white dark:bg-floor min-h-screen text-gray-700 dark:text-gray-100">
			
			<view class="flex items-center justify-between text-sm border-0 border-b-2 border-solid border-gray-100 dark:border-gray-700">
				<view class="px-40 py-20" :class="status == item.id ? 'text-my-green border-0 border-b-2 border-solid border-my-green' : ''" v-for="item in tabs" :key="item.id" @tap="selectType(item.id)">{{ item.texts }}</view>
			</view>
			
			<view class="px-40">
				<view v-for="(item, index) in orderList" :key="index" class=" border-0 border-b-2 border-solid border-gray-100 dark:border-gray-700 py-20">
					<view class="flex justify-between mb-20">
						<view class="">
							<text class="text-lg" :class="item.OrderType == 1 ? 'text-success' : 'text-danger'">{{ item.OrderType == 1 ? $t('trade.buy') : $t('trade.sell') }}</text>
							<text class="ml-10">{{ item.ForexTradeLists.Code }}</text>
							<text class="ml-10">x{{ item.Quantity }}{{ $t('bigTrade.zhang') }}</text>
						</view>
						<view :class="item.FactProfits < 0 ? 'text-danger' : 'text-success'">{{ item.FactProfits || '0.0000' | toFixed4 }}</view>
					</view>
					<view class="flex flex-col">
						<view class="flex mb-20">
							<view class="flex-1">
								<view class="text-gray-500">{{ status == 0 ? $t('trade.delegate_price') : $t('trade.price_cang') }}</view>
								<view class="mt-10 text-lg">{{ status == 0 ? item.OriginPrice : item.Price || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-center">
								<view class="text-gray-500">{{ $t('trade.price_zhiying') }}</view>
								<view class="mt-10 text-lg">{{ item.TargetProfitPrice || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-right">
								<view class="text-gray-500">{{ $t('trade.times') }}</view>
								<view class="mt-10 text-lg">{{ item.Multiple }}</view>
							</view>
						</view>
						<view class="flex mb-20">
							<view class="flex-1">
								<view class="text-gray-500">{{ $t('trade.price_cur') }}</view>
								<view class="mt-10 text-lg">{{ item.UpdatePrice || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-center">
								<view class="text-gray-500">{{ $t('trade.price_lose') }}</view>
								<view class="mt-10 text-lg">{{ item.TargetLossPrice || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-right">
								<view class="text-gray-500">{{ $t('trade.can_money') }}</view>
								<view class="mt-10 text-lg">{{ item.CautionMoney || '0.0000' | toFixed4 }}</view>
							</view>
						</view>
						<view class="flex mb-20">
							<view class="flex-1">
								<view class="text-gray-500">{{ $t('trade.money') }}</view>
								<view class="mt-10 text-lg">{{ item.OriginCautionMoney || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-center">
								<view class="text-gray-500">{{ $t('trade.fee') }}</view>
								<view class="mt-10 text-lg">{{ item.TradeFee || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-right">
								<view class="text-gray-500">{{ $t('bigTrade.profitRate') }}</view>
								<view class="mt-10" :class="item.FactProfits < 0 ? 'text-danger' : 'text-success'">
									{{((parseFloat(item.FactProfits)/parseFloat(item.CautionMoney))*100).toFixed(2)}}%
								</view>
							</view>
						</view>
						<view class="flex mb-20">
							<view class="flex-1 text-left">
								<view class="text-gray-500">{{ $t('trade.time_start') }}</view>
								<view class="mt-10">{{ item.CreateTimeHandler }}</view>
							</view>
							<view class="" v-if="item.CompleteTime">
								<view class="text-gray-500">{{ $t('trade.time_end') }}</view>
								<view class="mt-10">{{ item.CompleteTime }}</view>
							</view>
						</view>
					</view>
					<!-- 按钮 -->
					<view class="flex text-right mt-30 justify-end" v-if="status == 0 || status == 1">
						<view class="bg-primary px-30 py-20 rounded-8 text-black" @tap="loss(item,index)">{{$t('lever.setys')}}</view>
						<view class="bg-primary px-30 py-20 rounded-8 text-black ml-20" @tap="closes(item.Id, index)">{{ status == 0 ? $t('trade.chedan') : $t('trade.pingcang') }}</view>
					</view>
				</view>
			</view>
			<view class="text-center p-100" v-if="orderList.length == 0">
				<image src="/static/image/nodata.png" class="w-100 h-100"></image>
				<view class="text-gray-500 mt-20">{{ $t('home.norecord') }}</view>
			</view>
			<view class="text-center text-gray-500 py-40" v-show="isBottom">{{ $t('home.loading') }}...</view>
			<view class="text-center text-gray-500 py-40" v-show="!hasMore && orderList.length > 10">{{ $t('home.nomore') }}</view>
			<!-- 平仓弹窗 -->
			<uni-popup :show="closeTrades.closeTradeShow" @hidePopup="hideBtn" @comfirmPopup="comfirmClose" :msg="closeTrades.title" :lang="langs">
				<view class="p-30 flex-1 text-xl">{{ status == 0 ? $t('trade.confrim_chedan') : $t('trade.confrim_ping') }}</view>
			</uni-popup>
			<!-- 设置止盈止损 -->
			<uni-popup :show="lossData.shows" @hidePopup="hideBtn" @comfirmPopup="lossClose" :msg="lossData.title" :lang="langs">
				<view class="p-30 flex-1 text-xl">
					<view class="flex items-center">
						<view class="text-lg">
							{{$t('lever.price_zhiying')}}：
						</view>
						<view class="text-gray-500">
							<uni-number-box class="text-gray-500" :value="lossData.profitPrice" :max="100000000000000" @change="profitChange" />
						</view>
					</view>
					<view class="text-lg mt-40 text-center">
						{{$t('lever.profit')}}：{{lossData.expectedProfit || '0.00' | toFixed2}}
					</view>
					<view class="flex items-center mt-20">
						<view class="text-lg">
							{{$t('lever.price_lose')}}：
						</view>
						<view class="text-gray-500">
							<uni-number-box class="text-gray-500" :value="lossData.lossPrice" :max="100000000000000" @change="lossChange" />
						</view>
					</view>
					<view class="text-lg mt-40 text-center">
						{{$t('lever.lose')}}：{{lossData.expectedLoss || '0.00'|toFixed2}}
					</view>
				</view>
			</uni-popup>
		</view>
	</view>
</template>
<script>
import uniIcons from '../../components/uni-icon.vue';
import uniPopup from '@/components/uni-popup.vue';
import {mapState} from 'vuex'
export default {
	components: {
		uniIcons,
		uniPopup
	},
	data() {
		return {
			uid: '',
			current: 0, //全部/历史
			popType: '', //底部弹窗
			enType: 'in', //全部委托类型
			orderList: [], //当前委托
			hisList: [], //历史委托
			page: 1,
			status: 0,
			legalId: '',
			currencyId: '',
			isBottom: false,
			hasMore: true,
			tabs: [
				{
					id: 0,
					texts: this.$t('lever.delegating')
				},
				{
					id: 1,
					texts: this.$t('lever.dealing')
				},
				// {
				// 	id:2,
				// 	texts:this.$t('lever.pingcanging')
				// },
				{
					id: 3,
					texts: this.$t('lever.hasping')
				},
				{
					id: 4,
					texts: this.$t('lever.hasback')
				}
			],
			lossData:{
				shows:false,
				title:this.$t('lever.setys'),
				datas:{},
				expectedProfit:'0.00',
				expectedLoss:"0.00",
				lossPrice:'',
				profitPrice:'',
				indexs:""
			},
			// 平仓弹窗
			closeTrades: {
				closeTradeShow: false,
				title: '',
				orderId: '',
				indexs: ''
			},
			colors: '#ffffff',
			langs: '',
			currencyMatchId:''
		};
	},
	filters: {
		toFixed2: function(value, options) {
			value = Number(value);
			return value.toFixed(2);
		},
		toFixed4: function(value) {
			value = Number(value);
			return value.toFixed(4);
		}
	},
	computed:{
	   ...mapState(['theme']),
	},
	onLoad(e) {
		if(e.active){
			this.status=e.active
		}
	},
	onUnload(){
		this.$newSocket.closeSocket();
	},
	onShow() {
		this.$utils.setThemeTop(this.theme)
		this.$utils.setThemeBottom(this.theme)
		uni.setNavigationBarTitle({
			title: ''
		});
		this.uid = uni.getStorageSync('uid');
		this.init();
		this.langs = uni.getStorageSync('lang') || 'hk';
	},
	methods: {
		init() {
			//委托
			let that = this;
			that.$utils.httpDataToken(
				{
					url: 'forex/my_deal',
					data: {
						page: that.page,
						status: that.status,
						// currency_id: that.currencyId,
						// legal_id: that.legalId
						// currency_match_id:that.currencyMatchId
					},
					type: 'get'
				},
				res => {
					var data = res.data;
					console.log(data,333);
					uni.stopPullDownRefresh();
					that.isBottom = false;
					if (that.page == 1) {
						that.orderList = data;
					} else {
						that.orderList = that.orderList.concat(data);
					}
					if (that.status == 0 || that.status == 1) {
						that.orderTrade();
					}
					if (res.total > that.orderList.length) {
						that.hasMore = true;
					} else {
						that.hasMore = false;
					}
					console.log(that.hasMore);
				}
			);
		},
		selectType(types) {
			var that = this;
			that.status = types;
			that.orderList = [];
			that.page = 1;
			that.$newSocket.closeSocket();
			that.init();
		},
		// 平仓
		closes(ids, indexs) {
			var that = this;
			that.closeTrades.orderId = ids;
			that.closeTrades.indexs = indexs;
			that.closeTrades.closeTradeShow = true;
		},
		hideBtn() {
			var that = this;
			that.closeTrades.closeTradeShow = false;
			that.lossData.shows = false;
		},
		comfirmClose() {
			var that = this;
			var urls = '';
			that.closeTrades.closeTradeShow = false;
			if (that.status == 0) {
				urls = 'forex/cancel_trade';
			} else if (that.status == 1) {
				urls = 'forex/close';
			}
			that.$newSocket.closeSocket();
			that.$utils.httpDataToken(
				{
					url: urls,
					type: 'get',
					data: {
						id: that.closeTrades.orderId
					}
				},
				res => {
					that.$utils.showLayer(res);
					
					setTimeout(function() {
						that.closeTrades.orderId = '';
						that.orderList.splice(that.closeTrades.indexs, 1);
					}, 1000);
				}
			);
		},
		// 设置止盈止损
		loss(options,indexs){
			var that = this;
			that.lossData.datas = options;
			that.lossData.shows = true;
			that.lossData.indexs = indexs;
			if (options.TargetProfitPrice > 0) {
				that.lossData.profitPrice =  Number(options.TargetProfitPrice);;
				if(options.OrderType == 1){
					if(that.lossData.profitPrice > options.Price){
						that.lossData.expectedProfit = (that.lossData.profitPrice - options.Price) * options.Quantity * options.ForexContNum;
					}else {
						that.lossData.expectedProfit = '0.00';
					}
					
				}else{
					if(options.Price > that.lossData.profitPrice){
						that.lossData.expectedProfit = (options.Price -that.lossData.profitPrice) * options.Quantity * options.ForexContNum;
					}else{
						that.lossData.expectedProfit = '0.00'
					}
					
				}
			}else{
				that.lossData.profitPrice = Number(options.UpdatePrice);
			}
			if(options.TargetLossPrice > 0){
				that.lossData.lossPrice = Number(options.TargetLossPrice);
				if(options.OrderType == 1){
					if(options.Price > that.lossData.lossPrice){
						that.lossData.expectedLoss = (options.Price -that.lossData.lossPrice) * options.Quantity * options.ForexContNum;
					}else{
						that.lossData.expectedLoss = '0.00'
					}
					
				}else{
					if(that.lossData.lossPrice > options.Price){
						that.lossData.expectedLoss = (that.lossData.lossPrice -options.Price) * options.Quantity * options.ForexContNum;
					}
					
				}
				 
			}else{
				that.lossData.lossPrice =Number(options.UpdatePrice);
			}
			console.log(options,that.lossData);
			
		},
		profitChange(value){
			var that = this;
			that.lossData.profitPrice = value;
			if(that.lossData.datas.OrderType == 1){
				if(that.lossData.profitPrice > that.lossData.datas.Price){
					that.lossData.expectedProfit = (that.lossData.profitPrice - that.lossData.datas.Price) * that.lossData.datas.Quantity * that.lossData.datas.ForexContNum;
				}else{
					that.lossData.expectedProfit = '0.00';
				}
				
			}else{
				if(that.lossData.datas.Price > that.lossData.profitPrice){
					that.lossData.expectedProfit = (that.lossData.datas.Price -that.lossData.profitPrice) * that.lossData.datas.Quantity * that.lossData.datas.ForexContNum;
				}else{
					that.lossData.expectedProfit ='0.00';
				}
				
			}
			
		},
		lossChange(value){
			var that = this;
			that.lossData.lossPrice = value;
			if(that.lossData.datas.OrderType == 1){
				if(that.lossData.datas.Price > that.lossData.lossPrice){
					that.lossData.expectedLoss = (that.lossData.datas.Price -that.lossData.lossPrice) * that.lossData.datas.Quantity * that.lossData.datas.ForexContNum;
				}else{
					that.lossData.expectedLoss = '0.00';
				}
				
			}else{
				if(that.lossData.lossPrice > that.lossData.datas.Price){
					that.lossData.expectedLoss = (that.lossData.lossPrice - that.lossData.datas.Price) * that.lossData.datas.Quantity * that.lossData.datas.ForexContNum;
				}else{
					that.lossData.expectedLoss = '0.00';
				}
				
			}
		},
		lossClose(){
			var that = this;
			// if(that.lossData.datas.type == 1){
			// 	if(that.lossData.expectedProfit == 0){
			// 		that.$utils.showLayer('设置的止盈价需要高于开仓价');
			// 		return false;
			// 	}
			// 	if(that.lossData.expectedLoss == 0){
			// 		that.$utils.showLayer('设置的止损价不能高于开仓价');
			// 		return false;
			// 	}
			// }else{
			// 	
			// }
			that.$utils.httpDataToken(
				{
					url: 'forex/set_stop_price',
					type: 'get',
					data: {
						id: that.lossData.datas.Id,
						target_profit_price: that.lossData.profitPrice,
						stop_loss_price: that.lossData.lossPrice
					}
				},
				res => {
					that.lossData.shows = false;
					that.$utils.showLayer(res);
					that.orderList[that.lossData.indexs].TargetProfitPrice = that.lossData.profitPrice;
					that.orderList[that.lossData.indexs].TargetLossPrice = that.lossData.lossPrice;
				}
			);
			
			
		},
		onPullDownRefresh() {
			this.page = 1;
			this.init();
		},
		onReachBottom() {
			console.log('onReachBottom2');
			if (!this.hasMore) return;
			this.page++;
			this.init();
		},
		backs() {
			this.$newSocket.closeSocket();
			uni.navigateBack({
				delta: 1
			});
		},
		// 订单socket
		orderTrade() {
			var that = this;
			var tokens = uni.getStorageSync('token');
			that.$newSocket.listenFun([{ type: 'login', params: tokens }, { type: 'sub', params: 'FOREX_TRADE' },
			 { type: 'sub', params: 'FOREX_CLOSED' }
			], 
			res => {
				let msg = JSON.parse(res);
				var datas = that.orderList;
				if (msg.type == 'FOREX_TRADE') {
					var data1 = msg.TransOrder;
					// if (that.currencyMatchId == msg.currency_match_id) {
					// 	that.risk = msg.hazard_rate;
					// 	that.totalRisk = msg.profits_all;
					// }
					data1.forEach((item, index) => {
						datas.forEach((itm, inx) => {
							if (item.Id == itm.Id) {
								that.orderList.splice(inx, 1, item);
							}
						});
					});
				}
				if (msg.type == 'FOREX_CLOSED') {
					var data2 = msg.id;
					data2.forEach((item, index) => {
						datas.forEach((itm, inx) => {
							if (item == itm.Id) {
								that.orderList.splice(inx, 1);
							}
						});
					});
				}
			});
		}
	}
};
</script>