<template>
	<view :class="theme">
		<view class="text-black dark:text-white bg-my-grey dark:bg-my-black min-h-screen">
			<uni-nav-bar backIcon :left-text="$t('legal.list')" >
				<view class="flex-1 flex justify-end relative" slot="right">
					<image src="/static/image/screen1.png" mode="aspectFit" class="w-100 h-100 p-30" @click="isshow()"></image>
					<view class="absolute right-0 top-100 w-screen" v-show="show">
						<view class="bg-white dark:bg-gray-800 relative z-20">
							<view class="p-30">
								<view class="text-lg mb-20">{{$t('trade.dealtype')}}</view>
								<view class="flex mb-30">
									<view class="w-200 h-60 flex justify-center items-center mr-40 rounded-10 text-center" :class="way=='BUY'?'bg-primary text-black':'bg-gray-100 dark:bg-gray-700'" @click="changetype('BUY')">{{$t('legal.buy')}}</view>
									<view class="w-200 h-60 flex justify-center items-center mr-40 rounded-10 text-center" :class="way=='SELL'?'bg-primary text-black':'bg-gray-100 dark:bg-gray-700'" @click="changetype('SELL')">{{$t('legal.sell')}}</view>
								</view>
								<view class="text-lg mb-20">{{$t('store.orderstatus')}}</view>
								<view class="flex mb-20">
									<view class="w-200 h-60 flex justify-center items-center mr-30 rounded-10 text-center" :class="status===0?'bg-primary text-black':'bg-gray-100 dark:bg-gray-700'" @click="changestatu(0)">{{$t('store.notdone')}}</view>
									<view class="w-200 h-60 flex justify-center items-center mr-30 rounded-10 text-center" :class="status===1?'bg-primary text-black':'bg-gray-100 dark:bg-gray-700'" @click="changestatu(1)">{{$t('trade.has_pay')}}</view>
									<view class="w-200 h-60 flex justify-center items-center mr-30 rounded-10 text-center" :class="status===2?'bg-primary text-black':'bg-gray-100 dark:bg-gray-700'" @click="changestatu(2)">{{$t('store.yanqi')}}</view>
								</view>
								<view class="flex mb-20">
									<view class="w-200 h-60 flex justify-center items-center mr-30 rounded-10 text-center" :class="status===3?'bg-primary text-black':'bg-gray-100 dark:bg-gray-700'" @click="changestatu(3)">{{$t('store.protection')}}</view>
									<view class="w-200 h-60 flex justify-center items-center mr-30 rounded-10 text-center" :class="status===4?'bg-primary text-black':'bg-gray-100 dark:bg-gray-700'" @click="changestatu(4)">{{$t('trade.has_cancel')}}</view>
									<view class="w-200 h-60 flex justify-center items-center mr-30 rounded-10 text-center" :class="status===5?'bg-primary text-black':'bg-gray-100 dark:bg-gray-700'" @click="changestatu(5)">{{$t('store.done')}}</view>
								</view>
							</view>
							<view class="flex border-0 border-t-2 border-solid border-gray-200 dark:border-gray-700">
								<view class="flex-1 h-80 flex justify-center items-center text-lg" @click="reset()">{{$t('store.chongzhi')}}</view>
								<view class="flex-1 h-80 flex justify-center items-center bg-main-linear text-white text-lg" @click="confirm">{{$t('login.e_confrim2')}}</view>
							</view>
						</view>
						<view class="fixed w-full h-full z-10 bg-black bg-opacity-30 left-0 top-100" @click="isshow()" v-show="show"></view>
					</view>
				</view>
			</uni-nav-bar>
			
			<view>
				<view>
					<view class="gray75 flex column w100 plr15 ptb15 bdb27" v-for="(item,index) in orderlist" :key="index" @click="goDetail(item.id,item.is_sure)">
						<view class="flex between">
							<view class=" flex alcenter ft13 bold">
								<text :class="['text-new-blue mr5 ft14',{'redColor':item.way=='SELL'}]">{{item.way=='SELL' ? $t('legal.sell'):$t('legal.buy')}}</text>
								<text>{{item.currency_name}}</text>
							</view>
							<view class="flex alcenter">
								<!-- 0 交易中 1已付款 2延期确认 3维权 4取消 5确认 -->
								<text class="" v-if="item.status==0">{{$t('store.notdone')}}</text>
								<text class="" v-if="item.status==5">{{$t('store.done')}}</text>
								<text class="" v-if="item.status==4">{{$t('trade.has_cancel')}}</text>
								<text class="" v-if="item.status==1">{{$t('trade.has_pay')}}</text>
								<text class="" v-if="item.status==3">{{$t('store.protection')}}</text>
								<text class="" v-if="item.status==2">{{$t('store.yanqi')}</text>
								<image src="../../static/image/mores.png" mode="aspectFit" class="wt15 h15"></image>
							</view>
						</view>
						<view class="flex between mt10">
							<view class="flex column flexstart">
								<text>{{$t('trade.time')}}</text>
								<text class="text-333333 ft13 mt5 dark:text-white">{{item.created_at}}</text>
							</view>
							<view class="flex column flexstart">
								<text>{{$t('trade.num')}}({{item.currency_name}})</text>
								<text class="text-333333 ft13 mt5 dark:text-white">{{item.number | filterDecimals(4)}}</text>
							</view>
							<view class="flex column flexend">
								<text v-if="item.area_info">{{$t('legal.allmoney')}}({{item.area_info.currency}})</text>
								<text class="text-333333 ft13 mt5 dark:text-white">{{item.amount | filterDecimals(4)}}</text>
							</view>
						</view>
						<view class="flex mt10">
							<text class="ft14 ">{{item.seller_name}}</text>
						</view>
					</view>
					<view :class="['tc pt30 pt100 pb100 hidden',{'block':orderlist.length==0&&over}]">
						<image src="/static/image/nodata.png" class="w-100 h-100"></image>
						<view class="gray7">{{$t('home.norecord')}}</view>
					</view>
					<view class="tc gray7 ptb20" v-show="!hasMore && orderlist.length>10">{{$t('home.nomore')}}</view>
				</view>
			</view>
			
		</view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default {
		data() {
			return {
			   id:'',
	           show: false,
			   way:'',
			   status: -1,
			   orderlist:[],
			   page: 1,
			   hasMore: true,
			   over: false,
			};
		},
		onLoad(e) {
			this.id = e.id;
		},
		onShow() {
			this.$utils.setThemeTop(this.theme)
			this.getData();
		},
		computed:{
		   ...mapState(['theme']),
		},
		methods: {
			getData() {
				let that = this;
				let way = (!this.way) ? '' :this.way;
				// let status = (!this.status&&this.status!==0) ? '-1' :this.status;
				that.$utils.initDataToken({url: 'otc/user_details',
					data: {
						page:that.page,
						currency_id: that.id,
						way:way,
						status:this.status
					}
				}, res => {
					var data = res.data;
					uni.stopPullDownRefresh();
					that.orderlist = (that.page == 1) ? data : that.orderlist.concat(data);
					that.over = true;
					that.hasMore = (res.current_page == res.last_page) ? false : true;
					console.log(that.hasMore)
				});
			},
			back(){
				uni.navigateBack();
			},
			goDetail(id,sure){
				uni.navigateTo({
				    url: '/pages/legal/order?id='+id
				});
			},
			detail(){
				uni.navigateTo({
				    url: '/pages/legal/finished'
				});
			},
			isshow(){
				this.show = !this.show;
			},
			changetype(way){
				this.way= (this.way==way) ? (this.way = !this.way) : (this.way = way);
			},
			changestatu(status){
				this.status= (this.status===status) ? (this.status = -1) : (this.status = status);
			},
			reset(){
				this.status = -1;
				this.way = '';
				this.show = !this.show;
				this.page = 1;
				this.hasMore = true,
				this.over = false,
				this.getData();
			},
			confirm(){	
				this.show = false;
				this.page = 1;
				this.hasMore = true,
				this.over = false,
				this.getData();
			},
			onPullDownRefresh() {
				this.page = 1;
				this.getData();
			},
			onReachBottom() {
				if (!this.hasMore) return;
				this.page++;
				this.getData();
			},
		}
	};
</script>

<style>
		page {
	    background-color: #131f30;
	}
	.sx_show{
		position: fixed;
		top: calc(var(--status-bar-height) + 100upx);
		width: 100%;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(0, 0, 0, .7);
	}
	.sx_box{
	    background-color: #131f30;
	}
	.select view{
		width: 30%;
		height: 60upx;
		margin-bottom: 20upx;
		text-align: center;
		margin: 10upx 10upx 20upx;
		/* color: #d7e8f5; */
		/* background: #0b1726; */
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.select .active{
		background: none;
		border: 1px solid #217dc1;
		color: #217dc1;
		border-radius: 4upx;
	}
</style>
