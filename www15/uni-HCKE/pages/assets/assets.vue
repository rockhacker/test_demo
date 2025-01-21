<template>
	<view :class="theme">
		<view class="text-black dark:text-white">
				
			<uni-nav-bar fixed>
				<view class="w-full h-100 flex justify-center items-center bg-white dark:bg-floor text-center px-40 border-0 border-solid border-b-2 border-gray-200 dark:border-gray-900">
					<view class="flex justify-center items-center rounded-10 flex-1 h-60" style="word-break: keep-all;" :class="{'bg-primary':index==tabIndex}" hover-class="opacity-50"
					 v-for="(item,index) in wallet_data" :key="index" @click="tapTab(index)">{{item.name}}</view>
				</view>
				
			</uni-nav-bar>
			
			<swiper :current="tabIndex" :duration="300" @change="changeTab" style="min-height: calc(100vh - 50px - var(--status-bar-height));" class="dark:bg-gray-600 dark:bg-opacity-30">
				<swiper-item v-for="(item,index) in wallet_data" :key="index">
					<scroll-view scroll-y class="w-full h-full">
						<view class="py-30 px-40 bg-white dark:bg-floor text-xl text-gray-400 border-0 border-b-2 border-solid border-gray-200 dark:border-gray-900">
							<view class="flex justify-between">
								<view>
									<!-- <text class="text-black dark:text-white text-xl mr-20">{{item.name}}</text> -->
									<text class="text-sm">{{$t('assets.zhehecny')}}（{{sign2}}）</text>
								</view>
								<image src="../../static/image/shows.png" class="w-40 h-40" v-if="!isClose" @tap="isClose=true"></image>
								<image src="../../static/image/hide.png" class="w-40 h-40" v-else @tap="isClose=false"></image>
							</view>
							<view class="text-2xl font-bold mt-20 text-black dark:text-white">{{isClose?closeAccount:item.convert_usd}}</view>
						</view>
						<view class="bg-floor pt-40 px-20 pb-100">
							<navigator class="justify-between rounded-10 bg-my-green px-20 py-30 mb-30" v-for="changeItem,indexs in wallet_data[index].accounts" :key="indexs"
							:url="'tradeAccount?id='+wallet_data[index].id+'&titleName='+wallet_data[index].name+'&type='+wallet_data[index].account_code+'&account_id='+changeItem.id+'&currency_id='+changeItem.currency_id">
								
								<view class="flex justify-between">
									<view class="text-xl font-bold text-my-yellow">{{changeItem.currency_code}}</view>
									<image src="../../static/image/arrrowr.png" class="w-14 h-28"></image>
								</view>
								
								<view class="mt-20 flex items-center">
									<view class="flex-1">
										<view class="text-gray-400">{{$t('trade.use')}}</view>
										<view class="mt-10">{{isClose?closeAccount:changeItem.balance}}</view>
									</view>
									<view class="flex-1">
										<view class="text-gray-400">{{$t('assets.zhehe')}}({{sign2}})</view>
										<view class="mt-10" v-if="isClose">{{closeAccount}}</view>
										<view class="mt-10" v-else>{{changeItem.convert_usd | filterDecimals}}</view>
									</view>
								</view>
								<view class="mt-20 flex items-center">
									<view class="flex-1">
										<view class="text-gray-400">{{$t('assets.underView')}}</view>
										<view class="mt-10">{{isClose?closeAccount:changeItem.lock_balance}}</view>
									</view>
								</view>	
							</navigator>
						</view>
					</scroll-view>
				</swiper-item>
			</swiper>
		</view>

		<uni-popup v-if="false"  :show="announcementModal.showModal" @hidePopup="hideBtn" :closeBtn="true" :msg="announcementModal.title" :btnShow="announcementModal.tipbtnShow">
			<!-- <text class="w-full p-40" v-html="announcementModal.content">
				{{announcementModal.content}}
			</text> -->
			 <rich-text class="w-full p-40 h-700 overflow-auto" :nodes="announcementModal.content"></rich-text>
		</uni-popup>
	</view>
</template>
<script>
	import uniPopup from '@/components/uni-popup.vue';
	import {mapState} from 'vuex'
	export default {
		components: {
		uniPopup
    },
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
				announcementModal:{
				showModal: false,
				title: '',
				content: '',
				tipbtnShow: false
				}
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
			this.getPass()
			this.$utils.setThemeTop(this.theme)
			this.$utils.setThemeBottom(this.theme)
			this.getAssets();
			this.getAnnouncement()
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
		hideBtn(){
			this.announcementModal.showModal = false;
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
			 					    iconPath : "static/footer/trade2.png",
			 					});
			 					// uni.setTabBarItem({
			 					// 	index: 3,
			 					//     iconPath :  "static/footer/gang2.png",
			 					// });
			 					uni.setTabBarItem({
			 						index: 3,
			 					    iconPath :  "static/footer/mine2.png",
			 					});
			 					uni.setTabBarItem({
			 						index: 4,
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
			 				   	iconPath : "static/footer/trade0.png",
			 				   });
			 				   // uni.setTabBarItem({
			 				   // 	index: 3,
			 				   // 	iconPath :  "static/footer/gang0.png",
			 				   // });
			 				   uni.setTabBarItem({
			 				   	index: 3,
			 				   	iconPath :  "static/footer/mine0.png",
			 				   });
			 				   uni.setTabBarItem({
			 				   	index: 4,
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
			},
			getAssets() {
				this.$utils.initDataToken({url:'account/list'},res=>{
					console.log(res)
					uni.stopPullDownRefresh()
					// this.sign= res.quote_symbol;
					// this.sign2= res.quote_symbol_2;
					this.wallet_data = res;
					console.log(this.wallet_data)
				})
			}
		}
	}
</script>