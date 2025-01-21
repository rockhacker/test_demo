<template>
	<view :class="theme">
		<view class="bg-floor">
			
			<view class="flex items-center justify-between text-sm border-0 border-b-2 border-solid border-gray-100 dark:border-gray-700">
				<uni-nav-bar backIcon ></uni-nav-bar>
				<view class="px-40 py-20" :class="status == item.id ? 'text-primary' : 'text-my-gray'" v-for="item in tabs" :key="item.id" @tap="selectType(item.id)">{{ item.texts }}</view>
			</view>
			
			<view class="px-20">
				<view  @click="showDesc(item,index)" v-for="(item, index) in orderList" :key="index" class="p-20 mt-20 rounded-10" style="background: linear-gradient(180deg, rgba(33, 113, 100, 1) 0%, rgba(0, 49, 41, 1) 100%);">
					<view class="flex justify-between mb-20">
						<view class="">
							<text class="text-lg text-my-yellow">{{ item.type == 1 ? $t('trade.buy') : $t('trade.sell') }}</text>
							<!-- <text class="text-lg" :class="item.type == 1 ? 'text-success' : 'text-danger'">{{ item.type == 1 ? $t('trade.buy') : $t('trade.sell') }}</text> -->
							<text class="ml-10">{{ item.symbol }}</text>
							<text class="ml-10">x{{ item.share }}{{ $t('trade.hand') }}</text>
						</view>
						<!-- <view :class="item.profits < 0 ? 'text-danger' : 'text-success'">{{ item.profits || '0.0000' | toFixed4 }}</view> -->
						<view class="text-my-yellow">{{ item.profits || '0.0000' | toFixed4 }}</view>
					</view>
					<view class="flex flex-col">
						<view class="flex mb-20">
							<view class="flex-1">
								<view class="text-my-gray">{{ status == 0 ? $t('trade.delegate_price') : $t('trade.price_cang') }}</view>
								<view class="mt-10 text-lg">{{ status == 0 ? item.origin_price : item.price || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-center">
								<view class="text-my-gray">{{ $t('trade.price_zhiying') }}</view>
								<view class="mt-10 text-lg">{{ item.target_profit_price || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-right">
								<view class="text-my-gray">{{ $t('trade.num_zhehe') }}</view>
								<view class="mt-10 text-lg">{{ item.number || '0.0000' | toFixed4 }}</view>
							</view>
						</view>
						<view class="flex mb-20">
							<view class="flex-1">
								<view class="text-my-gray">{{ $t('trade.price_cur') }}</view>
								<view class="mt-10 text-lg">{{ item.update_price || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-center">
								<view class="text-my-gray">{{ $t('trade.price_lose') }}</view>
								<view class="mt-10 text-lg">{{ item.stop_loss_price || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-right">
							<view class="text-gray-400 mb-10">
								{{$t('bigTrade.profitRate')}}
							</view>
							<view class="text-black dark:text-white text-lg">
								<template v-if="item.status ==1 || item.status ==3">
									{{ item.profits/item.caution_money*100 || '0.0000' | toFixed4 }}%
								</template>
								<template v-else>
									0%
								</template>
							</view>
						</view>
						</view>
						<view class="flex mb-20">
							<view class="flex-1">
								<view class="text-my-gray">{{ $t('trade.money') }}</view>
								<view class="mt-10 text-lg">{{ item.origin_caution_money || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-center">
								<view class="text-my-gray">{{ $t('trade.fee') }}</view>
								<view class="mt-10 text-lg">{{ item.trade_fee || '0.0000' | toFixed4 }}</view>
							</view>
							<view class="flex-1 text-right">
								<view class="text-my-gray">{{ $t('trade.geye_fee') }}</view>
								<view class="mt-10 text-lg">{{ item.overnight_money || '0.0000' | toFixed4 }}</view>
							</view>
						</view>
						<view class="flex mb-20 justify-between">
							<view class="">
								<view class="text-my-gray">{{ $t('trade.time_start') }}</view>
								<view class="mt-10">{{ item.time }}</view>
							</view>
							<view class="" v-if="item.handle_time">
								<view class="text-my-gray">{{ $t('trade.time_end') }}</view>
								<view class="mt-10">{{ item.handle_time }}</view>
							</view>
						</view>
					</view>
					<!-- 按钮 -->
					<view class="flex text-right mt-30 justify-end" v-if="status == 0 || status == 1">
						<view class="bg-primary px-30 py-20 rounded-8 text-white flex-1 text-center" @tap.stop="loss(item,index)">{{$t('lever.setys')}}</view>
						<view class="bg-primary px-30 py-20 rounded-8 text-white text-center ml-20 flex-1" @tap.stop="closes(item.id, index)">{{ status == 0 ? $t('trade.chedan') : $t('trade.pingcang') }}</view>
					</view>
				</view>
			</view>
			<view class="text-center p-100" v-if="orderList.length == 0">
				<image src="/static/image/nodata.png" class="w-100 h-100"></image>
				<view class="text-my-gray mt-20">{{ $t('home.norecord') }}</view>
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
		<div v-show="showInfo" style="position: fixed;top:0px;bottom:0;right:0;left:0;background: #0000008f;display: flex;flex-direction: column;align-items: center;justify-content: center;">
			<div style="margin-top:360upx;color:#000;position: relative;background: white;width:86%;padding: 40px 20px 20px;border-radius: 10px;">
			  <img @click="closeDesc" style="width:30px;position: absolute;top: 6px;right:10px" src="data:image/png;base64,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" />
			  <div class="dank">
				<div style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ $t('home.loss')}}</view>
					<view class="mt-10 text-lg">{{ +item.profits > 0 ? '+':'' }} {{  item.profits  || '0.0000' | toFixed4 }}</view>
				</div>
				<div style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ status == 0 ? $t('trade.delegate_price') : $t('trade.price_cang') }}</view>
					<view class="mt-10 text-lg">{{ status == 0 ? item.origin_price : item.price || '0.0000' | toFixed4 }}</view>
				</div>
				<div style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ $t('trade.price_zhiying') }}</view>
					<view class="mt-10 text-lg">{{ item.target_profit_price || '0.0000' | toFixed4 }}</view>
				</div>
				<div style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ $t('trade.num_zhehe') }}</view>
					<view class="mt-10 text-lg">{{ item.number || '0.0000' | toFixed4 }}</view>
				</div>
				<div style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ $t('trade.price_cur') }}</view>
					<view class="mt-10 text-lg">{{ orderList[index] ? orderList[index].update_price :'0.0000' || '0.0000' | toFixed4 }}</view>
				</div>
				<div style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ $t('trade.price_lose') }}</view>
					<view class="mt-10 text-lg">{{ item.stop_loss_price || '0.0000' | toFixed4 }}</view>
				</div>
				<div style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ $t('trade.can_money') }}</view>
					<view class="mt-10 text-lg">{{ item.caution_money || '0.0000' | toFixed4 }}</view>
				</div>
				<div style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ $t('trade.money') }}</view>
					<view class="mt-10 text-lg">{{ item.origin_caution_money || '0.0000' | toFixed4 }}</view>
				</div>
				<div style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ $t('trade.fee') }}</view>
					<view class="mt-10 text-lg">{{ item.trade_fee || '0.0000' | toFixed4 }}</view>
				</div>
				<div style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ $t('trade.geye_fee') }}</view>
					<view class="mt-10 text-lg">{{ item.overnight_money || '0.0000' | toFixed4 }}</view>
				</div>
				<div style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ $t('trade.time_start') }}</view>
					<view class="mt-10">{{ item.time }}</view>
				</div>
				<div v-if="item.handle_time" style="display: flex;justify-content: space-between;">
					<view class="text-my-gray">{{ $t('trade.time_end') }}</view>
					<view class="mt-10">{{ item.handle_time }}</view>
				</div>
			  </div>
			  <!-- <template v-if="status==1">
				<div style="display: flex;justify-content: space-between;">
				  <div>
					<span>{{info.symbol_name}}</span>
					<span>{{secondsFormat(info.seconds)}}</span>
				  </div>
				</div>
				  <div style="display: flex;justify-content: space-between;margin-top: 10px;">
					<span>{{$t('home').quantity}}</span>
					<span>{{parseInt(info.number)}}</span>
				  </div>
				  <div style="display: flex;justify-content: space-between;margin-top: 10px;">
					<span>{{$t('home').puprice}}</span>
					<span>{{info.open_price}}</span>
				  </div>
				  <div style="display: flex;justify-content: space-between;margin-top: 10px;">
					<span>{{$t('home').cuPrice}}</span>
					<span>{{price||0.0000}}</span>
				  </div>
				  <div style="display: flex;justify-content: space-between;margin-top: 10px;">
					<span>{{$t('home').profitLoss}}</span>
					<span>{{info.ploss | tofixedFour}}</span>
				  </div>
				 <div style="display: flex;justify-content: space-between;margin-top: 10px;">
					  <span>{{$t('home').Countdown}}</span>
					  <span style="display:block;">{{secondsFormat(info.remain_milli_seconds||0)}}</span>
				 </div>
			  </template> -->
			</div>
		  </div>
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
			currencyMatchId:'',
			item:{},
			showInfo:false,
			index:0
		};
	},
	filters: {
		tofixedFour: function (val) {
          if (val >= 0) {
            val = val.toFixed(4)
          } else if (val < 0) {
            val = '-' + (val * -1).toFixed(4)
          }
          return val
        },
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
	onShow() {
		this.$utils.setThemeTop(this.theme)
		this.$utils.setThemeBottom(this.theme)
		this.uid = uni.getStorageSync('uid');
		this.init();
		this.langs = uni.getStorageSync('lang') || 'hk';
	},
	onHide() {
		this.$socket.closeSocket();
	},
	methods: {
		closeDesc(){
			this.showInfo = false
		},
		showDesc(item,i){
		  this.item = item
		  this.index = i
          this.showInfo = true
        },
		secondsFormat(s) { 
          var day = Math.floor( s/ (24*3600) ); // Math.floor()向下取整 
          var hour = Math.floor( (s - day*24*3600) / 3600); 
          var minute = Math.floor( (s - day*24*3600 - hour*3600) /60 ); 
          var second = s - day*24*3600 - hour*3600 - minute*60; 
          let d = day > 0 ? day + this.$t('home').tian :'';
          let h = hour > 0 ? hour + this.$t('home').shi:'';
          let m = minute > 0 ? minute + this.$t('home').fenz : '';
          let se = second > 0 ? second + this.$t('home').miao : '';
          return  d + h + m + se
      },
		init() {
			//委托
			let that = this;
			that.$utils.initDataToken(
				{
					url: 'lever/my_trade',
					data: {
						page: that.page,
						status: that.status,
						// currency_id: that.currencyId,
						// legal_id: that.legalId
						currency_match_id:that.currencyMatchId
					},
					type: 'POST'
				},
				res => {
					var data = res.data;
					console.log(data);
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
					if (res.per_page == data.length) {
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
			that.$socket.closeSocket();
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
				urls = 'lever/cancel';
			} else if (that.status == 1) {
				urls = 'lever/close';
			}
			that.$socket.closeSocket();
			that.$utils.initDataToken(
				{
					url: urls,
					type: 'POST',
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
		onPullDownRefresh() {
			this.page = 1;
			this.init();
		},
		onReachBottom() {
			if (!this.hasMore) return;
			this.page++;
			this.init();
		},
		backs() {
			this.$socket.closeSocket();
			uni.navigateBack({
				delta: 1
			});
		},
		// 订单socket
		orderTrade() {
			var that = this;
			var tokens = uni.getStorageSync('token');
			that.$socket.listenFun([{ type: 'login', params: tokens }, { type: 'sub', params: 'LEVER_TRADE' }, { type: 'sub', params: 'LEVER_CLOSED' }], res => {
				let msg = JSON.parse(res);
				var datas = that.orderList;
				if (msg.type == 'LEVER_TRADE') {
					var data1 = msg.trades_all;
					if (that.currencyMatchId == msg.currency_match_id) {
						that.risk = msg.hazard_rate;
						that.totalRisk = msg.profits_all;
					}
					data1.forEach((item, index) => {
						datas.forEach((itm, inx) => {
							if (itm.base_currency_id == item.base_currency_id && itm.quote_currency_id == item.quote_currency_id && item.id == itm.id) {
								that.orderList.splice(inx, 1, item);
							}
						});
					});
				}
				if (msg.type == 'LEVER_CLOSED') {
					var data2 = msg.id;
					data2.forEach((item, index) => {
						datas.forEach((itm, inx) => {
							if (item == itm.id) {
								that.orderList.splice(inx, 1);
							}
						});
					});
				}
				// console.log(that.orderList[0].profits)
			});
		}
	}
};
</script>


<style>
.text-my-gray{
	color: #868b81;
}
.dank>div{
	padding:10upx 0;
}
</style>