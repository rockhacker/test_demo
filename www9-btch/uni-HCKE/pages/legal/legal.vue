<template>
	<view :class="theme">
		<view class="text-black dark:text-white dark:bg-101625 min-h-screen">
			<view class="bg-white dark:bg-1C2532">
				<view class="flex justify-between items-center w-full py-30 px-30">
					<view class="flex items-baseline justify-center font-bold">
						<view class="mr-30" :class="Type=='sell'?'text-3xl text-clip-green':'text-gray-500 text-lg'" @click="changetype('sell')">{{$t('legal.ibuy')}}</view>
						<view :class="Type=='buy'?'text-3xl text-clip-green':'text-gray-500 text-lg'" @click="changetype('buy')">{{$t('legal.isell')}}</view>
					</view>
					<navigator :url="'/pages/legal/recordlist?id='+currency_id">
						<image src="../../static/image/record1.png" mode="aspectFit" class="w-40 h-40"></image>
					</navigator>
				</view>
				<view class="w-full border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
					<scroll-view scroll-x class="w-full h-100 whitespace-nowrap" :show-scrollbar="false">
						<view class="w-140 h-100 flex-col justify-center items-center text-lg inline-flex rounded-none" 
							hover-class="opacity-50"
							:class="{'text-clip-green':coinindex==index}" v-for="(item,index) in legal_list" :key="index" 
							 @click="changeCoin(index,item.id)">
							{{item.code}}
							<view class="w-60 h-6 mt-20" :class="{'bg-main-linear':coinindex==index}"></view>
						</view>
					</scroll-view>
				</view>
			</view>
			<view class="bg-my-grey dark:bg-101625 mt-20">
				<view class="gray75 flex column w100 plr20 ptb10 bdb27 bg-white dark:bg-1C2532" v-for="item in orderlist" :key="item.id">
					<view class="flex justify-between mt5">
						<view class=" flex items-center">
							<view class="logo bgBlue2 ft12 flex items-center jscenter white" v-if="false && item.seller_name">{{item.seller_name || '' | chart0}}</view>
							<text class="dark:text-white text-333333 ft14">{{item.seller_name}}</text>
						</view>
						<!-- <view class="flex items-center">
							<text class="">1455</text>
							<text class="mlr10">|</text>
							<text class="">94%</text>
						</view> -->
					</view>
					<view class="flex justify-between mt10">
						<view class="flex items-center">
							<text class="">{{$t('trade.num')}}</text>
							<text class="mlr5">{{item.remain_qty | toFixed4}}</text>
							<text class="" v-if="legal_list&&legal_list.length">{{legal_list[coinindex].code}}</text>
						</view>
						<view class="flex items-center">
							<text class="">{{$t('legal.price')}}</text>
						</view>
					</view>
					<view class="flex justify-between mt5">
						<view class="flex items-center">
							<text class="">{{$t('legal.limit')}}</text>
							<text class="pl5">{{(item.min_number-0)*(item.price-0) | toFixed2}} {{item.area_currency}}-{{(item.max_number-0)*(item.price-0) | toFixed2}} {{item.area_currency}}</text>
						</view>
						<view class="flex items-center">
							<text class="text-clip-green ft16">{{item.price | toFixed2}}{{item.area_currency}}</text>
						</view>
					</view>
					<view class="flex justify-between mt5">
						<view class="flex items-center">
							<view class=""  v-for="(itm,inx) in item.payways" :key="inx">
								<image src="../../static/image/zhi.png" mode="aspectFit" class="wt15 h15 mr5" v-if="itm.code=='alipay'"></image>
								<image src="../../static/image/wechat.png" mode="aspectFit" class="wt15 h15 mr5" v-else-if="itm.code=='wxpay'"></image>
								<image src="../../static/image/card.png" mode="aspectFit" class="wt15 h15 mr5" v-else></image>
							</view>
						</view>
						<view class="flex items-center jscenter h25 plr20 bg-main-linear radius2" @click="getinfo(item)">
							<text class="text-clip-yellow ft14 ">{{Type=='sell'?$t('legal.buy'):$t('legal.sell')}}</text>
						</view>
					</view>
				</view>
				<view class="flex justify-center items-center flex-col p-100" v-if="orderlist.length===0">
					<image src="/static/image/nodata.png" class="h-100 w-100"></image>
					<view class="text-gray-500 mt-20">{{$t('home.norecord')}}</view>
				</view>
				<view class="text-center text-gray-500 p-40 text-lg" v-show="!hasMore && orderlist.length>10">{{$t('home.nomore')}}</view>
			</view>
			<view class="layer_box" v-show="box1" @click="isshow">
				<view class="layer_opeation bgHeader" @click.stop>
					<view class="bggray flex justify-between items-center plr15 ptb10">
						<view class=" flex column">
							<view class="ft20 ft16"><text>{{Type=='sell'?$t('legal.buy'):$t('legal.sell')}}</text><text v-if="legal_list.length">{{legal_list[coinindex].code}}</text></view>
							<view class="mt5 ft14">
								<text>{{$t('legal.price')}}</text>
								<text class="text-clip-green price pl5" v-if="Data.price"> {{Data.price | toFixed2}} </text> 
								<text class="text-clip-green price pl5">{{Data.area_currency}}</text>
							</view>
						</view>
						<view class="tc" v-if="Data.currency_logo">
							<image :src="Data.currency_logo" mode="aspectFit" class="wt30 h30 mr5"></image>
						</view>
					</view>
					<view class="mtb10 tab flex column plr15">
						<view class="num_price flex items-center gray75 ft14">
							<!-- <view @click="msg=0" :class="{'cur':msg==0}">{{$t('legal.anprice')}}{{Type=='sell'?$t('legal.buy'):$t('legal.sell')}}</view> -->
							<view @click="msg=1" :class="{'cur':msg==1}">{{$t('legal.annum')}}{{Type=='sell'?$t('legal.buy'):$t('legal.sell')}}</view>
						</view>
						<view class="flex justify-between items-center Ipt ft13 pl10 mt10 bd3a" v-if="msg==0">
							<input type="number" class="flex1  h25" :placeholder="$t('legal.pl') + Type=='sell'?$t('legal.sell'):$t('legal.buy')+$t('legal.amount')" value="" v-model='money' />
							<view class="ptb10 flex w40 jscenter w40">
								<text class="white coin_code flex1 pr10 tr bdr_input">{{Data.area_currency}}</text>
								<text class="plr10 text-clip-green tc" @click="all(0)">{{$t('trade.all')}}{{Type=='sell'?$t('trade.sell'):$t('trade.buy')}}</text>
							</view>
						</view>
						<view class="flex justify-between items-center Ipt ft13 pl10 mt10 bd3a" v-if="msg==1">
							<input type="number" class="flex1  h25" :placeholder="$t('legal.pl') + Type=='sell'?$t('legal.sell'):$t('legal.buy')+$t('legal.num')" value="" v-model='number' />
							<view class="ptb10 flex w40 jscenter w40">
								<text class="white coin_code flex1 pr10 tr bdr_input" v-if="legal_list.length">{{legal_list[coinindex].code}}</text>
								<text class="plr10 text-clip-green tc" @click="all(1)">{{$t('trade.all')}}{{Type=='sell'?$t('trade.buy'):$t('trade.sell')}}</text>
							</view>
						</view>
						<view class="gray75 mt5">
							<text>{{$t('legal.limit')}}</text>
							<text class="limit pl5" v-if="legal_list.length">{{Data.min_number}} {{legal_list[coinindex].code}}-{{Data.max_number}} {{legal_list[coinindex].code}}</text>
							</view>
						<view class="ft14 flex items-center justify-between mt10">
							<text class="gray75">{{$t('legal.allmoney')}}</text>
							<text class="text-clip-green ft16 total">{{totalPrice | toFixed2}} {{Data.area_currency}}</text>
							<!-- <text class="text-clip-green ft16 total" v-if="msg==0">￥{{money | toFixed2}}</text>
							<text class="text-clip-green ft16 total" v-if="msg==1">￥{{(number*Data.price) | toFixed2}}</text> -->
						</view>
					</view>
					<view class="flex justify-between items-center  plr15 ft14 ptb10">
						<view class="bgGray radius2 ptb10 flex1 tc mr10 gray3">
							<text class="cutdown">{{time}}</text>
							<text>s{{$t('legal.autocancel')}}</text>
						</view>
						<view class="bg-main-linear radius2 ptb10 flex1 tc doit pointer ml5 white" @click="pay(Data.id)">{{$t('legal.do')}}</view>
					</view>
				</view>
			</view>
			<!-- 底部密码弹窗 -->
			<uni-popup ref="share" :type="type" :custom="true">
				<view class="uni-share bgPart">
					<view class="uni-share-content">
						<view class="uni-share-title tc h40 lh40 bdb_1e ft16">{{$t('login.s_dealpwd')}}</view>
						<view class="flex items-center ptb20 plr20">
							<text>{{$t('login.s_dealpwd')}}</text>
							<input type="password" class="h40 flex1 plr15 ml10 bd_input radius2" v-model="password" :placeholder="$t('login.e_pdeal')" />
						</view>
						<view class="bgBlue tc h40 lh40 white" @click="submit">{{$t('login.e_confrim')}}</view>
					</view>
				</view>
			</uni-popup>
		</view>
	</view>
</template>

<script>
	import uniPopup from '@/components/uni-popup3.vue';
	import {mapState} from 'vuex'
	export default {
		components: {
			uniPopup
		},
		data() {
			return {
				id:'',
				msg: 1,
				box1: false,
				Type: 'sell',
				coinindex: 0,
				legal_list: [],
				orderlist: [],
				currency_id: '',
				time:59,
				page: 1,
				hasMore: true,
				over: false,
				Data: {price:'',coin_code:'--'},
				money: '',
				number: '',
				password:'',
				type:'',
				interval:function(){}
			};
		},
		filters:{
			chart0:function(value){
				return value.charAt(0);
			},
			toFixed2: function (value) {
				value = Number(value);
				return value.toFixed(2);
			},
			toFixed4: function (value) {
				value = Number(value);
				return value.toFixed(4);
			}
		},
		computed:{
			totalPrice(){
				let total = this.msg==0 ? (this.money || 0.00 ) : ((this.number*this.Data.price) || 0.00);
				return total;
			},
			...mapState(['theme']),
		},
		onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('legal').legal
			})
			this.legallist();
		},
		onShow() {
			this.$utils.setThemeTop(this.theme)
		},
		methods: {
			all(msg) {
				var that = this;
				if (msg == 0) {
					that.money = Number(that.Data.limitation.max);
				} else {
					that.number = Number(that.Data.max_number);
				}
			},
			isshow() {
				let that = this;
				clearInterval(that.interval);
				this.box1 = !this.box1;
			},
			changetype(type) {
				let that = this;
				that.Type = type;
				that.page = 1;
				that.hasMore = true,
				that.over = false,
				that.getData();
			},
			changeCoin(index, id) {
				let that = this;
				that.coinindex = index;
				that.currency_id = id;
				that.page = 1;
				that.hasMore = true,
				that.over = false,
				that.getData();
			},
			record() {
				uni.navigateTo({
					url: '/pages/legal/recordlist'
				});
			},
			pay(id) {				
				let that = this;
				that.id = id;
				let value = that.msg == 0 ? that.money : that.number;
				if(that.msg==0&&!value){
					return that.$utils.showLayer(that.$t('legal.p_amout'));
				}
				if(that.msg==1&&!value){
					return that.$utils.showLayer(that.$t('trade.p_num'));
				}
				that.box1 = false;
				that.$utils.initDataToken({ url: 'otc/match_master',data:{master_id:that.id,price:that.Data.price,number:value},type:'post' }, (res,msg)=> {
					that.$utils.showLayer(msg);
					that.cancel('share');
					setTimeout(()=>{
						uni.navigateTo({
							url: '/pages/legal/order?id='+res.id
						});
					},1000)
				});
				// that.togglePopup('bottom', 'share');
			},
			submit(){
				let that = this;
				let means= that.msg == 0 ? 'money' : 'number';
				let value = that.msg == 0 ? that.money : that.number;
				let password = that.password;
				if(password.length<6){
					return that.$utils.showLayer(that.$t('login.e_pdeal'));
				}
				that.$utils.initDataToken({ url: 'do_legal_deal',data:{id:that.id,means,value,password},type:'post' }, res => {
					that.$utils.showLayer(res.msg);
					that.cancel('share');
					setTimeout(()=>{
						uni.navigateTo({
							url: '/pages/legal/order?id='+res.data.id
						});
					},1000)
				});
			},
			legallist() { //币种数据
				let that = this;
				that.$utils.initData({url: 'otc/currencies'}, res => {
					if(res.length>0){
						that.legal_list = res;
						that.currency_id = that.legal_list[0].id;
						that.getData();
					}
				});
			},
			getData() {
				let that = this;
				let type = that.Type=='buy'?'BUY':'SELL';
				that.$utils.initDataToken({url: 'otc/masters',
					data: {
						way: type,
						page: that.page,
						currency_id: that.currency_id
					}
				}, res => {
					var data = res.data;
					uni.stopPullDownRefresh();
					that.orderlist = (that.page == 1) ? data : that.orderlist.concat(data);
					that.over = true;
					that.hasMore = (res.current_page = res.last_page) ? false : true;
					console.log(111,that.orderlist)
				});
			},
			getinfo(item) {
				console.log(item);
				let that = this;
				that.Data = item;
				that.box1 = true;
				that.number='';
				that.money ='';
				that.password='';
				this.msg = 1;
				clearInterval(that.interval)
				that.time = 59;
				that.interval = setInterval(function () {
				    var text = that.time;
				    if (text == 0) {
				        clearInterval(that.interval);
						that.box1 = false;
				    } else {
				        that.time--;
				    }
				}, 1000)
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
			togglePopup(type, open) {//type弹窗位置
				this.type = type;
				if (open === 'tip') {
					this.show = true;
				} else {
					this.$refs[open].open();
				}
			},
			cancel(type) {
				if (type === 'tip') {
					return this.show = false;
				}
				this.$refs[type].close();
			},
		}
	};
</script>
<style>
	.layer_box {
		width: 100%;
		height: 100%;
		background: rgba(0, 0, 0, 0.6);
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		z-index: 100;
	}
	.layer_box .layer_opeation {
		width: 100%;
		position: fixed;
		left: 0;
		bottom: 0;
		/* background-color: #131f30; */
		border-radius: 20upx 20upx 0 0;
		z-index: 101;
	}
</style>