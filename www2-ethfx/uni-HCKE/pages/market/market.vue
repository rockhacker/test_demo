<template>
	<view :class="theme" class="flex flex-col">
		<view class="bg-white dark:bg-my-black">
		
		<view class="w-full flex flex-col">
			<scroll-view scroll-x class="w-full h-100 whitespace-nowrap" :show-scrollbar="false">
				<view class="w-180 h-100 flex-col justify-center items-center text-xl font-bold inline-flex rounded-none" 
					hover-class="opacity-50"
					:class="isActive==i?'text-new-blue':'text-838B99'" v-for="(item,i) in marketLists" :key="i" 
					@click="changeTab(i,item.code,item)">
					{{item.code}}
					<view class="w-70 h-6 mt-10" :class="{'bg-new-blue':isActive==i}"></view>
				</view>
			</scroll-view>
			
			<view class="bg-white dark:bg-1C2532 text-838B99 dark:text-9BA4AD px-36 rounded-tl-3xl rounded-tr-3xl">
				<view class="h-100 flex border-0 border-solid border-b-2 border-EEEEEE dark:border-9BA4AD">
					<view class="flex items-center flex-2" @tap="tapFilters(1,'currency_name')">
					{{$t('home.name')}}
					<view class="ml-10">
						<image src="/static/image/updown0.png" class="w-16 h-20" v-if="isfilter1==0"></image>
						<image src="/static/image/updown1.png" class="w-16 h-20" v-else-if="isfilter1==1"></image>
						<image src="/static/image/updown2.png" class="w-16 h-20" v-else></image>
					</view>
				</view>
				<view class="flex items-center flex-1" @tap="tapFilters(2,'now_price')">
					{{$t('home.new_price')}}
					<view class="ml-10">
						<image src="/static/image/updown0.png" class="w-16 h-20" v-if="isfilter2==0"></image>
						<image src="/static/image/updown1.png" class="w-16 h-20" v-else-if="isfilter2==1"></image>
						<image src="/static/image/updown2.png" class="w-16 h-20" v-else></image>
					</view>
				</view>
				<view class="flex items-center flex-1 justify-end" @tap="tapFilters(3,'change')">
					{{$t('home.fu')}}
					<view class="ml-10">
						<image src="/static/image/updown0.png" class="w-16 h-20" v-if="isfilter3==0"></image>
						<image src="/static/image/updown1.png" class="w-16 h-20" v-else-if="isfilter3==1"></image>
						<image src="/static/image/updown2.png" class="w-16 h-20" v-else></image>
					</view>
				</view>
				</view>
			</view>
		</view>
		
			
		<view class="bg-white dark:bg-1C2532 pb-100" style="min-height: calc(100vh - 100px);">
			<view @click="toPath(item)" class="flex items-center px-40 h-120" v-for="(item,i) in matches" v-if="marketLists[isActive]" :key="i" v-show="marketLists&&marketLists[isActive]&&item.open_change==1">
				<view class="flex-2">
					<view class="text-lg text-1A222B dark:text-white font-medium"><text class="font-bold text-xl">{{item.base_currency_code}}</text><text class="text-838B99">/{{item.quote_currency_code}}</text></view>
					<view class="text-838B99 dark:text-999FAA pt-6 text-sm" v-if="item.currency_quotation">{{$t('trade.cj_vol')}} {{item.currency_quotation.volume | toFixed4}}</view>
				</view>
				
				<view v-if="item.base_currency_code=='ETHFX' && !isOnline(item.market_time)" class="w-200">{{$t('trade.soon')}}</view>
				<template v-else>
					<view class="flex-1">
						<view v-if="item.currency_quotation"> 
							<text class="text-1A222B text-lg dark:text-9BA4AD">{{item.currency_quotation.close}}</text>
						</view>
					</view>
					<view class="flex flex-1 justify-end text-white">
						<view class="flex justify-center items-center w-140 h-60 rounded-8"  v-if="item.currency_quotation" :class="[(item.currency_quotation.change.substr(0,1))=='-'?'bg-k-red':'bg-k-green']">{{(item.currency_quotation.change.substr(0,1))=='-' ? '' : '+'}}{{(item.currency_quotation.change-0) | toFixed2}}%</view>
					</view>	
				</template>
			</view>
		</view>
		
		</view>
		
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				isActive:0,
				marketLists:[],
				fiat_convert_cny:6.8,
				legal_name:'',
				isfilter1:0,
				isfilter2:0,
				isfilter3:0,
				matches:[],
				item:{},
				info: '',
				lang: 'en',
				isshowlang: false,
				languages: {
				// zh: { name: '中文', img: '/static/image/zh.png' },
				en: { name: 'English', img: '/static/image/en.png' },
				jp: { name: '日本語', img: '/static/image/jp.png' },
				// kr: { name: '한국어', img: '/static/image/kr.png' },
				vn: { name: 'Tiếng Việt', img: '/static/image/vn.png' },
				th: { name: 'ไทย', img: '/static/image/th.png' },
				// ar: { name: 'عربي', img: '/static/image/ar.png' },
				// de: { name: 'Deutsche', img: '/static/image/de.png' },
				// it: { name: 'Italiano', img: '/static/image/it.png' },
				// fr: { name: 'français', img: '/static/image/fr.png' },
				hk: { name: '繁體中文', img: '/static/image/hk.png' },
			},
			}
		},
		computed:{
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
		filters:{
			toFixed2: function (value) {
				value = Number(value);
				return value.toFixed(2);
			},  
			toFixed3: function (value) {
				value = Number(value);
				return value.toFixed(3);
			},  
			toFixed4: function (value) {
				value = Number(value);
				return value.toFixed(4);
			},  
		},
		onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('market').marketv
			})
		//	this.setIcon()
		},
		onShow() {
			this.lang = uni.getStorageSync('lang') || 'en';
			this.$utils.setThemeTop(this.theme);
			this.$utils.setThemeBottom(this.theme);
			this.getList();
			var token = uni.getStorageSync('token');
			if (token) {
				this.getUserInfo();
			}
			this.$socket.listenFun([{type: "sub", params: "DAY_MARKET"}],(res)=>{
				var res=JSON.parse(res);
				// console.log(this.marketLists)
				if(res.symbol){ //首次连接成功数据
					let legal_name = res.symbol.split('/')[1];
					if(legal_name==this.legal_name){
						// console.log(this.marketLists[this.isActive].matches);
						var currencyQuotation=this.marketLists[this.isActive].matches? this.marketLists[this.isActive].matches:[];
						for(var i in currencyQuotation){
							if(currencyQuotation[i].id==res.currency_match_id){
								// console.log(res.quotation.change)
								currencyQuotation[i].currency_quotation.volume=res.quotation.volume-0;
								currencyQuotation[i].currency_quotation.close=res.quotation.close-0;
								currencyQuotation[i].currency_quotation.change=res.quotation.change;
							}
						}
					}
				}
				
			})
		},
		onHide() {
			this.$socket.closeSocket();
		},
		onPullDownRefresh() {
			this.getList();
		},
		methods:{
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
		// 语言切换
		changeLang(lang) {
			// this.$utils.initData({ url: 'lang/set', data: { lang }, type: 'POST' }, res => {
				console.log(lang);
				this.lang = lang;
				uni.setStorageSync('lang', lang);
				this.$i18n.locale = lang;
				this.isshowlang = false;
				this.changeFooter();
				// this.showLeft = false;
				// this.showMask = false;
				this.token = uni.getStorageSync('token');
				// this.getBannerImg();
				// this.getNoticeList();
				this.isshowlang = !this.isshowlang;
			// });
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
			toPath(item){
				console.log(item);
				
				// let currencyData={
				// 	cny: this.item.cny_price,
				// 	quoteCurrencyCode: this.item.code,
				// 	quoteCurrencyId: this.item.id,
				// 	baseCurrencyId : item.base_currency_id,
				// 	baseCurrencyCode : item.base_currency_code,
				// 	shareNUm : item.lever_share_num,
				// 	spread : item.lever_point_rate,
				// 	fee : item.lever_fee_rate,
				// 	quoteCurrencyIds : this.item.id,
				// 	changes : item.currency_quotation.change,
				// 	currencyMatchId: item.id,
				// }
				// uni.setStorageSync('leverOrder', JSON.stringify(currencyData));
				// uni.setStorageSync('active', 0);

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
			
			},
			// 过滤
			filterList(name,isflag){
				if(this.marketLists[this.isActive].matches){
					this.marketLists[this.isActive].matches.sort(function(i,j){
						if(name=='currency_name'){
							if(isflag==1){
								return i['base_currency_code'].charCodeAt(0) - j['base_currency_code'].charCodeAt(0);
							}else{
								return j['base_currency_code'].charCodeAt(0) - i['base_currency_code'].charCodeAt(0);
							}
						}else{
							if(name=='now_price'){
								if(isflag==1){
									return i['currency_quotation'].close-j['currency_quotation'].close;
								}else{
									return j['currency_quotation'].close-i['currency_quotation'].close;
								}
							}else{
								if(isflag==1){
									return i['currency_quotation'].change-j['currency_quotation'].change;
								}else{
									return j['currency_quotation'].change-i['currency_quotation'].change;
								}
							}
						}
					})
				}
				
			},
			// 点击切换
			tapFilters(e,name){
				console.log(e,name);
				if(e==1){
					this.isfilter2=0;
					this.isfilter3=0;
					this.isfilter1=this.isfilter1==1?2:1;
					this.filterList(name,this.isfilter1);
				}
				if(e==2){
					this.isfilter1=0;
					this.isfilter3=0;
					this.isfilter2=this.isfilter2==1?2:1;
					this.filterList(name,this.isfilter2);
				}
				if(e==3){
					this.isfilter2=0;
					this.isfilter1=0;
					this.isfilter3=this.isfilter3==1?2:1;
					this.filterList(name,this.isfilter3);
				}
				
			},
			getList(){
				this.$utils.initData({url:'market/currency_matches'},res=>{
					uni.stopPullDownRefresh();
					this.marketLists=res;
					this.matches = this.marketLists[this.isActive].matches?this.marketLists[this.isActive].matches:[];//zzy
					if(res.length>0){
						this.legal_name=res[0].code;
						this.fiat_convert_cny=res[0].cny_price-0;
						// this.legal_price=res[0].legal_price;
					}
					this.item=this.marketLists[0]
				})
			},
			changeTab(e,name,item){
				this.item=item
				this.isfilter3=0;
				this.isfilter2=0;
				this.isfilter1=0;
				this.fiat_convert_cny=this.marketLists[e].cny_price-0;
				// this.legal_price=this.marketLists[e].legal_price-0;
				this.isActive=e;
				this.legal_name = name;
				this.matches = this.marketLists[this.isActive].matches?this.marketLists[this.isActive].matches:[]
			}
		}
	}
</script>
