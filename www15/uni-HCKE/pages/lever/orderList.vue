<template>
	<view :class="theme">
		<uni-nav-bar backIcon fixed>
			<view class="flex justify-between items-center py-20 pr-20 w-full bg-white dark:bg-floor">
				<view>
					<view>{{$t('lever.risk')}}：{{ risk || '0.00' | toFixed2 }} %</view>
					<view class="pt5">
						{{$t('lever.totalyk')}}：<text :class="totalRisk < 0?'text-danger':'text-success'">{{ totalRisk || '0.0000' |toFixed4 }}</text>
					</view>
				</view>
				<view class="bg-primary text-white py-20 text-center rounded-10 w-200" @tap="allClose.shows=true">{{$t('lever.yijian')}}</view>
			</view>
		</uni-nav-bar>
		
		<view class="list text-xl px-30 bg-white dark:bg-floor mt-20" style="min-height: calc(100vh - 70px - var(--status-bar-height));">
			
			<view class="text-center text-gray-400 dark:text-gray-400 py-40" v-show="isBottom">{{$t('home.loading')}}...</view>
			<view class="text-center text-gray-400 dark:text-gray-400 py-40" v-show="!hasMore && orderList.length > 10">{{$t('home.nomore')}}</view>
			<view class="text-center py-100" v-if="orderList.length == 0">
				<image src="/static/image/nodata.png" class="w-100 h-100"></image>
				<view class="gray7">{{$t('home.norecord')}}</view>
			</view>
			<template v-else>
				<view v-for="(item, index) in orderList" :key="index" class="py-30 border-0 border-solid border-b-2 border-gray-100 dark:border-gray-900">
					<view class="flex justify-between mb-20">
						<view class="">
							<text class="text-lg" :class="item.type == 1 ? 'text-success' : 'text-danger'">{{ item.type == 1 ? $t('trade.buy') : $t('trade.sell') }}</text>
							<text class="ml-10">{{ item.symbol }}</text>
							<text class="ml-10">x{{ item.share }}{{$t('trade.hand')}}</text>
						</view>
						<view :class="item.profits < 0 ? 'text-danger' : 'text-success'">{{ item.profits || '0.0000' | toFixed4 }}</view>
					</view>
					<view class="flex mb-20">
						<view class="flex-1">
							<view class="text-gray-400 mb-10">
								{{$t('trade.price_cang')}}
							</view>
							<view class="text-black dark:text-white text-lg">
								{{ item.price || '0.0000' | toFixed4 }}
							</view>
						</view>
						<view class="flex-1 text-center">
							<view class="text-gray-400 mb-10">
								{{$t('trade.price_zhiying')}}
							</view>
							<view class="text-black dark:text-white text-lg">
								{{ item.target_profit_price || '0.0000' | toFixed4 }}
							</view>
						</view>
						<view class="flex-1 text-right">
							<view class="text-gray-400 mb-10">
								{{$t('trade.price_cur')}}
							</view>
							<view class="text-black dark:text-white text-lg">
								{{ item.update_price || '0.0000' | toFixed4 }}
							</view>
						</view>
					</view>
					<view class="flex mb-20">	
						<view class="flex-1">
							<view class="text-gray-400 mb-10">
								{{$t('trade.price_lose')}}
							</view>
							<view class="text-black dark:text-white text-lg">
								{{ item.stop_loss_price || '0.0000' | toFixed4 }}
							</view>
						</view>
						<view class="flex-1 text-center">
							<view class="text-gray-400 mb-10">
								{{$t('trade.money')}}
							</view>
							<view class="text-black dark:text-white text-lg">
								{{ item.caution_money || '0.0000' | toFixed4 }}
							</view>
						</view>
					     <view class="flex-1 text-right">
							<view class="text-gray-400 mb-10">
								{{$t('bigTrade.profitRate')}}
							</view>
							<view class="text-black dark:text-white text-lg">
								{{ item.profits/item.caution_money*100 || '0.0000' | toFixed4 }}%
							</view>
						</view>
					</view>
					<view class="flex mb-20">
						<view class="flex-1">
							<view class="text-gray-400 mb-10">
								{{$t('trade.fee')}}
							</view>
							<view class="text-black dark:text-white text-lg">
								{{ item.trade_fee || '0.0000' | toFixed4 }}
							</view>
						</view>
						<view class="flex-1 text-center">
							<view class="text-gray-400 mb-10">
								{{$t('trade.time_start')}}
							</view>
							<view class="text-black dark:text-white text-sm">
								{{ item.time }}
							</view>
						</view>
						<view class="flex-1 text-right">
							<view class="text-gray-400 mb-10">
								{{$t('trade.geye_fee')}}
							</view>
							<view class="text-black dark:text-white text-lg">
								{{ item.overnight_money || '0.0000' | toFixed4 }}
							</view>
						</view>
					</view>
					
					<!-- 按钮 -->
					<view class="flex text-right mt-30 justify-end">
						<view class="bg-blue-500 dark:bg-primary px-40 py-20 rounded-8 text-black" @tap="loss(item,index)">{{$t('lever.setys')}}</view>
						<view class="bg-blue-500 dark:bg-primary px-40 py-20 rounded-8 text-black ml-20" @tap="closes(item.id,index)">{{$t('trade.pingcang')}}</view>
					</view>
				</view>
			</template>
		</view>
		<!-- 平仓弹窗 -->
		<uni-popup :show="closeTrades.closeTradeShow" @hidePopup="hideBtn" @comfirmPopup="comfirmClose" :msg="closeTrades.title" :lang="langs">
			<view class="p-30 flex-1 text-xl">{{$t('trade.confrim_ping')}}</view>
		</uni-popup>
		<!-- 设置止盈止损 -->
		<uni-popup :show="lossData.shows" @hidePopup="hideBtn" @comfirmPopup="lossClose" :msg="lossData.title" :lang="langs">
			<view class="p-30 flex-1 text-xl">
				<view class="flex items-center mb-40">
					<view class="text-lg">
						{{$t('lever.price_zhiying')}}：
					</view>
					<view class="text-black">
						<uni-number-box class="text-black" :value="lossData.profitPrice" :max="100000000000000" @change="profitChange" />
					</view>
				</view>
				<view class="text-lg mb-20 text-center">
					{{$t('lever.profit')}}：{{lossData.expectedProfit || '0.00' | toFixed2}}
				</view>
				<view class="flex items-center mb-40">
					<view class="text-lg">
						{{$t('lever.price_lose')}}：
					</view>
					<view class="text-black">
						<uni-number-box class="text-black" :value="lossData.lossPrice" :max="100000000000000" @change="lossChange" />
					</view>
				</view>
				<view class="text-lg text-center">
					{{$t('lever.lose')}}：{{lossData.expectedLoss || '0.00'|toFixed2}}
				</view>
			</view>
		</uni-popup>
		<!-- 一键平仓 -->
		<uni-popup :show="allClose.shows" @hidePopup="hideBtn" @comfirmPopup="totalCloses" :msg="allClose.title" :lang="langs">
			<view class="p-40 flex-1 flex">
				<view class="py-10 px-20 rounded-10 text-lg border-2 border-solid border-blue-500" :class="closeType==0?'bg-blue-500 text-white':'text-blue-500'" @tap="closeType=0">{{$t('lever.all_ping')}}</view>
				<view class="ml-20 py-10 px-20 rounded-10 text-lg border-2 border-solid border-success" :class="closeType==1?'bg-success text-white':'text-success'" @tap="closeType=1">{{$t('lever.duo_ping')}}</view>
				<view class="ml-20 py-10 px-20 rounded-10 text-lg border-2 border-solid border-danger" :class="closeType==2?'bg-danger text-white':'text-danger'" @tap="closeType=2">{{$t('lever.kong_ping')}}</view>
			</view>
		</uni-popup>
	</view>
</template>

<script>
import uniIcon from '../../components/uni-icon.vue';
import uniPopup from '@/components/uni-popup.vue';
import uniNumberBox from '@/components/uni-number-box/uni-number-box.vue'
import {mapState} from 'vuex'
export default {
	components: {
		uniIcon,
		uniPopup,
		uniNumberBox
	},
	data() {
		return {
			risk: '0.00',
			totalRisk: '0.00',
			legalId: '',
			currencyId: '',
			orderList: [],
			page: 1,
			// 平仓弹窗
			closeTrades: {
				closeTradeShow: false,
				title: '',
				orderId: '',
				indexs: ''
			},
			isBottom:false,
			hasMore:true,
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
			allClose:{
				shows:false,
				title:this.$t('trade.confrim_ping'),
			},
			closeType:0,
			langs:'',
			currencyMatchId:''
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
		uni.setNavigationBarTitle({
			title:this.$t('trade').all_delegate
		})
		var that = this;
		if (e.currencyMatchId) {
			// that.legalId = e.legalId;
			// that.currencyId = e.currencyId;
			that.currencyMatchId = e.currencyMatchId;
		}
	},
	onShow() {
		var that = this;
		that.orderList = [];
		that.$utils.setThemeTop(that.theme);
		that.init();
		that.langs = uni.getStorageSync('lang') || 'hk';
	},
	onHide() {
		this.$socket.closeSocket();
	},
	onUnload(){
		this.$socket.closeSocket();
	},
	computed:{
	   ...mapState(['theme']),
	},
	methods: {
		init() {
			var that = this;
			that.$utils.initDataToken(
				{
					url: 'lever/dealall',
					type: 'POST',
					data: {
						// legal_id: that.legalId,
						// currency_id: that.currencyId,
						currency_match_id:that.currencyMatchId,
						page: that.page
					}
				},
				res => {
					console.log(res);
					if (res.order.data.length > 0) {
						that.orderList = that.orderList.concat(res.order.data);
						if(that.page == 1){
							that.orderTrade();
						}
					}
				}
			);
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
			that.allClose.shows = false;
		},
		comfirmClose() {
			var that = this;
			that.closeTrades.closeTradeShow = false;
            that.$socket.closeSocket();
			that.$utils.initDataToken(
				{
					url: 'lever/close',
					type: 'POST',
					data: {
						id: that.closeTrades.orderId
					}
				},
				res => {
					that.$utils.showLayer(res);
					that.orderTrade();
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
			if(options.target_profit_price > 0){
				that.lossData.profitPrice = Number(options.target_profit_price);
				if(options.type == 1){
					if(that.lossData.profitPrice > options.price){
						that.lossData.expectedProfit = (that.lossData.profitPrice - options.price) * options.share;
					}else {
						that.lossData.expectedProfit = '0.00';
					}
					
				}else{
					if(options.price > that.lossData.profitPrice){
						that.lossData.expectedProfit = (options.price -that.lossData.profitPrice) * options.share;
					}else{
						that.lossData.expectedProfit = '0.00'
					}
					
				}
			}else{
				that.lossData.profitPrice = Number(options.update_price);
			}
			if(options.stop_loss_price > 0){
				that.lossData.lossPrice = Number(options.stop_loss_price);
				if(options.type == 1){
					if(options.price > that.lossData.lossPrice){
						that.lossData.expectedLoss = (options.price -that.lossData.lossPrice) * options.share;
					}else{
						that.lossData.expectedLoss = '0.00'
					}
					
				}else{
					if(that.lossData.lossPrice > options.price){
						that.lossData.expectedLoss = (that.lossData.lossPrice -options.price) * options.share;
					}
					
				}
				 
			}else{
				that.lossData.lossPrice =Number(options.update_price);
			}
			console.log(options,that.lossData);
			
		},
		profitChange(value){
			var that = this;
			that.lossData.profitPrice = value;
			if(that.lossData.datas.type == 1){
				if(that.lossData.profitPrice > that.lossData.datas.price){
					that.lossData.expectedProfit = (that.lossData.profitPrice - that.lossData.datas.price) * that.lossData.datas.share;
				}else{
					that.lossData.expectedProfit = '0.00';
				}
				
			}else{
				if(that.lossData.datas.price > that.lossData.profitPrice){
					that.lossData.expectedProfit = (that.lossData.datas.price -that.lossData.profitPrice) * that.lossData.datas.share;
				}else{
					that.lossData.expectedProfit ='0.00';
				}
				
			}
			
		},
		lossChange(value){
			var that = this;
			that.lossData.lossPrice = value;
			if(that.lossData.datas.type == 1){
				if(that.lossData.datas.price > that.lossData.lossPrice){
					that.lossData.expectedLoss = (that.lossData.datas.price -that.lossData.lossPrice) * that.lossData.datas.share;
				}else{
					that.lossData.expectedLoss = '0.00';
				}
				
			}else{
				if(that.lossData.lossPrice > that.lossData.datas.price){
					that.lossData.expectedLoss = (that.lossData.lossPrice - that.lossData.datas.price) * that.lossData.datas.share;
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
			that.$utils.initDataToken(
				{
					url: 'lever/setstop',
					type: 'POST',
					data: {
						id: that.lossData.datas.id,
						target_profit_price: that.lossData.profitPrice,
						stop_loss_price: that.lossData.lossPrice
					}
				},
				res => {
					that.lossData.shows = false;
					that.$utils.showLayer(res);
					that.orderList[that.lossData.indexs].target_profit_price = that.lossData.profitPrice;
					that.orderList[that.lossData.indexs].stop_loss_price = that.lossData.lossPrice;
				}
			);
			
			
		},
		
		//一键平仓
		totalCloses(){
			var that = this;
			that.$utils.initDataToken(
				{
					url: 'lever/batch_close',
					type: 'POST',
					data: {
						type: that.closeType,
						currency_match_id:that.currencyMatchId
					}
				},
				res => {
					that.allClose.shows = false;
					that.$utils.showLayer(res);
					that.page=1;
					that.orderList = [];
					that.init();
					
				}
			);
		},
		onPullDownRefresh() {
			this.page = 1;
			this.init();
		},
		onReachBottom() {
			if (!this.hasMore) return;
			this.page++;
			this.init();
		},
		// 订单socket
		orderTrade(){
			var that = this;
			var tokens = uni.getStorageSync('token')
			that.$socket.listenFun([{type: "login", params: tokens},{type: "sub",params: "LEVER_TRADE"},{type: "sub",params: "LEVER_CLOSED"}],(res)=>{
				// that.$socket.listenFun([{event: "login", params: tokens}],(res)=>{
				let msg = JSON.parse(res);
				var datas = that.orderList;
				if (msg.type == "LEVER_TRADE") {
					var data1= msg.trades_all;
					if(that.currencyMatchId == msg.currency_match_id){
						that.risk= msg.hazard_rate;
						that.totalRisk=msg.profits_all;
					}
					data1.forEach((item,index)=>{
						datas.forEach((itm,inx)=>{
							if(itm.base_currency_id == item.base_currency_id && itm.quote_currency_id == item.quote_currency_id &&item.id == itm.id){
								that.orderList.splice(inx, 1, item);
							}
						})
					})
				}
				if(msg.type == "LEVER_CLOSED"){
					var data2 = msg.id;
					data2.forEach((item,index)=>{
						datas.forEach((itm,inx)=>{
							if(item == itm.id){
								that.orderList.splice(inx, 1);
							}
						})
					})
				}
				
			})
		}
	}
};
</script>

<style>
	.uni-input-input{
		color: #333;
	}
</style>
