<template>
	<view :class="theme" class="light_white px-30">
		<view class="tc mt-40">{{$t('add.ykje')}}</view>
        <view class="tc mt-30 ft20" :class="item.profits < 0 ? 'text-danger' : 'text-success'">{{ item.profits<0?'':'+' }}{{ item.profits || '0.0000' | toFixed4 }}({{ (item.profits / item.caution_money *100) | toFixed2 }}%)</view>
		<view class="flex between mt-80 items-center">
			<view class="text-gray-400">{{ $t('add.ddh') }}</view>
			<view class="text-black dark:text-white text-lg">{{ item.order_number }}</view>
		</view>
		<view class="flex between mt-60 items-center">
			<view class="text-gray-400">
				{{$t('assets.currency')}}
			</view>
			<view class="text-black dark:text-white text-lg">
				{{ item.symbol }}
			</view>
		</view>
		<view class="flex between mt-60 items-center">
            <view class="text-gray-400">{{$t('trade.types')}}</view>
			<view class="" :class="item.type == 2 ? 'text-danger' : 'text-success'">{{ item.type == 1 ? $t('trade.buy') : $t('trade.sell') }}</view>
        </view>
		<view class="flex between mt-60 items-center">
			<view class="text-gray-400">
				{{$t('store.orderstatus')}}
			</view>
			<view class="text-black dark:text-white text-lg">
				{{ item.status === 1 ? $t('lever.dealing') : item.status === 3 ? $t('lever.hasping') : '' }}
			</view>
		</view>
		<view class="flex between mt-60 items-center">
			<view class="text-gray-400">
				{{$t('trade.price_cang')}}
			</view>
			<view class="text-black dark:text-white text-lg">
				{{ item.price || '0.0000' | toFixed4 }}
			</view>
		</view>
		<view class="flex between mt-60 items-center">
			<view class="text-gray-400" v-if="item.status == 3">{{ $t('add.pcj') }}</view>
		    <view class="text-gray-400" v-else>{{ $t('trade.price_cur') }}</view>
			<view class="text-black dark:text-white text-lg">
				{{ item.update_price || '0.0000' | toFixed4 }}
			</view>
		</view>
		<view class="flex between mt-60 items-center">
			<view class="text-gray-400">
				{{$t('trade.price_zhiying')}}
			</view>
			<view class="text-black dark:text-white text-lg">
				{{ item.target_profit_price || '0.0000' | toFixed4 }}
			</view>
		</view>
		<view class="flex between mt-60 items-center">
			<view class="text-gray-400">
				{{$t('trade.price_lose')}}
			</view>
			<view class="text-black dark:text-white text-lg">
				{{ item.stop_loss_price || '0.0000' | toFixed4 }}
			</view>
		</view>
		<view class="flex between mt-60 items-center">
			<view class="text-gray-400">
				{{$t('trade.money')}}
			</view>
			<view class="text-black dark:text-white text-lg">
				{{ item.caution_money || '0.0000' | toFixed4 }}
			</view>
		</view>
		<view class="flex between mt-60 items-center">
			<view class="text-gray-400">
				{{$t('trade.geye_fee')}}
			</view>
			<view class="text-black dark:text-white text-lg">
				{{ item.overnight_money || '0.0000' | toFixed4 }}
			</view>
		</view>
		<view class="flex between mt-60 items-center">
			<view class="text-gray-400">
				{{$t('trade.fee')}}
			</view>
			<view class="text-black dark:text-white text-lg">
				{{ item.trade_fee || '0.0000' | toFixed4 }}
			</view>
		</view>
		<view class="flex between mt-60 items-center">
			<view class="text-gray-400">
				{{$t('trade.time_start')}}
			</view>
			<view class="text-black dark:text-white text-lg">
				{{ item.time }}
			</view>
		</view>
		<view class="flex between mt-60 items-center" v-if="item.handle_time">
			<view class="text-gray-400">{{ $t('trade.time_end') }}</view>
			<view class="text-black dark:text-white text-lg">{{ item.handle_time }}</view>
		</view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				item:{}
			}
		},
		filters: {
			toFixed2: function(value) {
				value = Number(value);
				return parseFloat(value.toFixed(2));
			},
			toFixed4: function(value) {
				value = Number(value);
				return parseFloat(value.toFixed(4));
			}
		},
		computed:{
			...mapState(['theme']),
		},
		onHide() {
			this.$socket.closeSocket();
		},
		onUnload(){
			this.$socket.closeSocket();
		},
		onLoad(e) {
			this.item = JSON.parse(e.item)
			if(this.item.status == 1){
				this.orderTrade()
			}
			uni.setNavigationBarTitle({
                title: this.$t('add.ddxq')
            });
		},
		onShow() {
			this.$utils.setThemeTop(this.theme)
           
		},
		methods:{
			orderTrade(){
			var that = this;
			var tokens = uni.getStorageSync('token')
			that.$socket.listenFun([{type: "login", params: tokens},{type: "sub",params: "LEVER_TRADE"}],(res)=>{
				// that.$socket.listenFun([{event: "login", params: tokens}],(res)=>{
				let msg = JSON.parse(res);
				var itm = that.item;
				if (msg.type == "LEVER_TRADE") {
					var data1= msg.trades_all;
					if(that.currencyMatchId == msg.currency_match_id){
						that.risk= msg.hazard_rate;
						that.totalRisk=msg.profits_all;
					}
					data1.forEach((item,index)=>{
							if(itm.base_currency_id == item.base_currency_id && itm.quote_currency_id == item.quote_currency_id &&item.id == itm.id){
								that.item = item
							}
					})
				}
			})
		}
		}
	}
</script>