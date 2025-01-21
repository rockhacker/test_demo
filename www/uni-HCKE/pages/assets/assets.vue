<template>
	<view :class="theme">
		<view class="text-333333 dark:text-white bg-my-grey dark:bg-my-black">
				
			<uni-nav-bar fixed>
				<scroll-view  class="scroll-view_H h-100 leading-100" scroll-x="true" scroll-with-animation :scroll-left="scrollLeft">
					<view class="tab-scroll_item scroll-view-item_H  h-60 rounded-10" :class="{'bg-main-linear text-white dark:text-white':index==tabIndex,'text-333333 dark:text-999FAA':index!=tabIndex}" hover-class="opacity-50"
					 v-for="(item,index) in wallet_data" :key="index" @click="tapTab(index)" :id="item.name">{{item.name}}</view>
				</scroll-view>
			</uni-nav-bar>
			
			<swiper :current="tabIndex" :duration="300" @change="changeTab" style="min-height: calc(100vh - 50px - var(--status-bar-height));" class="dark:bg-gray-600 dark:bg-opacity-30">
				<swiper-item v-for="(item,index) in wallet_data" :key="index">
					<scroll-view scroll-y class="w-full h-full">
						<view class="py-30 px-40 bg-white dark:bg-1C2532 text-xl">
							<view class="flex justify-between">
								<view>
									<text class="text-33333 dark:text-white text-lg mr-20">{{item.name}}</text>
									<text class="text-838B99 dark:text-999FAA text-xs">{{$t('assets.zhehecny')}}（{{sign2}}）</text>
								</view>
								<image src="../../static/image/shows.png" class="w-40 h-40" v-if="!isClose" @tap="isClose=true"></image>
								<image src="../../static/image/hide.png" class="w-40 h-40" v-else @tap="isClose=false"></image>
							</view>
							<view class="mt-20 text-#333333 text-xl dark:text-white">{{isClose?closeAccount:item.convert_usd}}</view>
						</view>
						<view class="pt-40 px-20 pb-100">
							<navigator class="justify-between rounded-10 bg-white dark:bg-1C2532 px-20 py-30 mb-30" v-for="changeItem,indexs in wallet_data[index].accounts" :key="indexs"
							:url="'tradeAccount?id='+wallet_data[index].id+'&titleName='+wallet_data[index].name+'&type='+wallet_data[index].account_code+'&account_id='+changeItem.id+'&currency_id='+changeItem.currency_id">
								
								<view class="flex justify-between">
									<view class="text-xl text-333333 dark:text-white font-bold">{{changeItem.currency_code}}</view>
									<image src="../../static/image/arrrowr.png" class="w-30 h-30"></image>
								</view>
								
								<view class="mt-20 flex items-center">
									<view class="flex-1">
										<view class="text-838B99 dark:text-999FAA text-xs">{{$t('trade.use')}}</view>
										<view class="mt-10 text-333333 dark:text-white">{{isClose?closeAccount:changeItem.balance}}</view>
									</view>
									<view class="flex-1">
										<view class="text-838B99 dark:text-999FAA text-xs">{{$t('assets.zhehe')}}({{sign2}})</view>
										<view class="mt-10 text-333333 dark:text-white" v-if="isClose">{{closeAccount}}</view>
										<view class="mt-10 text-333333 dark:text-white" v-else>{{changeItem.convert_usd | filterDecimals}}</view>
									</view>
								</view>
								<view class="mt-20 flex items-center">
									<view class="flex-1">
										<view class="text-838B99 dark:text-999FAA text-xs">{{$t('assets.underView')}}</view>
										<view class="mt-10 text-333333 dark:text-white">{{isClose?closeAccount:changeItem.lock_balance}}</view>
									</view>
								</view>	
							</navigator>
						</view>
					</scroll-view>
				</swiper-item>
			</swiper>
		</view>
	</view>
</template>
<script>
	import {mapState} from 'vuex'
	export default {
		data() {
			return {
				scrollLeft: 0,
				isClickChange: false,
				tabIndex: 0,
				wallet_data:[],
				isClose:false,
				tabBg:'bg1',
				closeAccount:'****',
				sign:'CNY',
				sign2:'USDT',
				show:false,
				scrollLeft:0
			}
		},
		onLoad() {
			//this.setIcon()
		},
		onPullDownRefresh() {
			this.getAssets();
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
			// this.getPass()
			this.$utils.setThemeTop(this.theme)
			this.$utils.setThemeBottom(this.theme)
			this.getAssets();
		},
		methods: {
			// 获取标题区域宽度，和每个子元素节点的宽度以及元素距离左边栏的距离
			getScrollW() {
				const query = uni.createSelectorQuery().in(this);
				 query.selectAll('.tab-scroll_item').boundingClientRect(data => {
					
					 let dataLen = this.wallet_data.length;
					  for (let i = 0; i < dataLen; i++) {
						  //  scroll-view 子元素组件距离左边栏的距离
						  this.wallet_data[i].left = data[i].left;
						 //  scroll-view 子元素组件宽度
						 this.wallet_data[i].width = data[i].width
					}
					console.log(this.wallet_data,'this.wallet_data');
				 }).exec()
			},
			scroll(e) {
				console.log(e)
				window.test = e
				// this.old.scrollTop = e.detail.scrollTop
			},
			getPass(){
				this.$utils.initDataToken({url:'user/check_set_pay_password'},res=>{
					if(res.has!=1){
						//uni.showModal({
						// 	title: '',
						// 	content: '设置资金密码',
						// 	showCancel:false,
						// 	success: function (res) {
						// 		if (res.confirm) {
									
						// 			uni.navigateTo({url: '/pages/mine/resetLegalPwd' })
						// 		}
						// 	}
						// });
						uni.navigateTo({url: '/pages/mine/resetLegalPwd?bool=1' })
					}
					
				})
			},
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
			 					    iconPath : "static/footer/trade2.png",
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
			 				   	iconPath : "static/footer/trade0.png",
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
			close(index1, index2) {
				uni.showModal({
					content: '是否删除本条信息？',
					success: (res) => {
						if (res.confirm) {
							this.newsitems[index1].data.splice(index2, 1);
						}
					}
				})
			},
			async changeTab(e) {
				this.tabIndex = e.target.current; //一旦访问data就会出问题
			},
			getElSize(id) { //得到元素的size
				return new Promise((res, rej) => {
					uni.createSelectorQuery().select("#" + id).fields({
						size: true,
						scrollOffset: true
					}, (data) => {
						res(data);
					}).exec();
				})
			},
			async tapTab(index) { //点击tab-bar
				if (this.tabIndex === index) return false;
				this.tabIndex = index;
				this.scrollLeft = 0;
				for (let i = 0; i < index - 1; i++) {
					this.scrollLeft += this.wallet_data[i].width
				};
			},
			getAssets() {
				this.$utils.initDataToken({url:'account/list'},res=>{
					console.log(res)
					uni.stopPullDownRefresh()
					// this.sign= res.quote_symbol;
					// this.sign2= res.quote_symbol_2;
					this.wallet_data = res;
					console.log(this.wallet_data)
					this.$nextTick(()=>{
						this.getScrollW()
					})
				})
			}
		}
	}
</script>


<style>

	.scroll-view_H {
		white-space: nowrap;
		width: 100%;
		padding: 0 20rpx;
	}
	.scroll-view-item {
		height: 300rpx;
		line-height: 300rpx;
		text-align: center;
		font-size: 36rpx;
	}
	.scroll-view-item_H {
		display: inline-block;
		text-align: center;
		height: 60rpx;
		line-height: 60rpx;
		padding: 0 10rpx;
		
	}
	.scroll-view-item_H:not(:last-child){
		margin-right: 20rpx;
	}
</style>