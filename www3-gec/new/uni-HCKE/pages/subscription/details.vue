<template>
	<view :class="theme">
		<view class="p-30">
			<view class="bg-my-gray p-20 mb-20 rounded-8">
				
				<view class="flex flex-col text-xl py-20" v-if="coin.list[coin.active]">
					<text class="mr-10 text-white">{{ $t('subscription.balance')}}</text>
					{{ coin.list[coin.active].change_account.balance }} {{ coin.list[coin.active].code }}
				</view>
				
				<view class="border-0 border-b-2 border-solid border-gray-200 py-30">
					<view class="text-white text-lg">
						{{$t('subscription.faxingjia')}}
					</view>
					<view class="text-2xl font-bold text-primary">
						1{{subscription.currency_name}} = {{subscription.sub_price}} USDT
					</view>
				</view>
				
				<view class="border-0 border-b-2 border-solid border-gray-200 py-30">
					<view class="flex justify-between text-lg mb-10">
						<text class="text-white">{{$t('subscription.faxingshuliang')}}</text>
						<text class="text-primary">{{subscription.issue_number}} {{subscription.currency_name}}</text>
					</view>
					<view class="flex justify-between text-lg">
						<text class="text-white">{{$t('subscription.shengyushuliang')}}</text>
						<text class="text-primary">{{subscription.issue_number - subscription.subscribed || ''}} {{subscription.currency_name}}</text>
					</view>
				</view>
				
				<view class="flex text-lg text-white my-40">
					<view class="flex-1">
						<view class="mb-10 text-lg">
							{{$t('subscription.shenggoubizhong')}}
						</view>
						<view class="text-lg">
							{{subscription.currency_name}}
						</view>
					</view>
					<view class="flex-1">
						<view class="mb-10 text-lg">
							{{$t('subscription.yjsxsj')}}
						</view>
						<view class="text-lg">
							{{subscription.market_time}}
						</view>
					</view>
				</view>
				<view class="flex text-lg text-white my-40">
					<view class="flex-1">
						<view class="mb-10 text-lg">
							{{$t('subscription.kssgsj')}}
						</view>
						<view class="text-lg">
							{{subscription.start_time}}
						</view>
					</view>
					<view class="flex-1">
						<view class="mb-10 text-lg">
							{{$t('subscription.jssgsj')}}
						</view>
						<view class="text-lg">
							{{subscription.finish_time}}
						</view>
					</view>
				</view>
				
				<view class="flex h-80 my-40">
					<view class="w-120 mr-20 text-white border-0 border-b-4 border-solid border-my-orange h-full flex justify-center items-center">
						<picker :value="coin.active" :range="coin.list" class="flex-1" @change="changeCoin" range-key="code">
							<view class="text-xl text-center" v-if="coin.list.length">{{ coin.list[coin.active].code }}</view>
						</picker>
					</view>
					<view class="flex-1 border-0 border-b-4 border-solid border-my-orange h-full">
						<input type="number" :placeholder="$t('legal.p_amout')" class="h-full text-xl px-20 text-white" v-model="amount">
					</view>
				</view>
				
				<view class="mt-20 rounded-10 p-20 text-white text-lg text-center bg-my-orange my-40" @tap="submit">{{$t('subscription.lijishenggou')}}</view>
				<view v-if="subscription.currency && subscription.currency.desc">
					<view class="text-xl mb20 text-white">{{$t('subscription.bizhongjieshao')}}</view>
					<view class="flex1 text-white break-all">{{subscription.currency.desc}}</view>
				</view>
			</view>
		</view>
    </view>
</template>

<script>
	import { mapState } from 'vuex';
	export default{
		data(){
			return {
				coin:{
					list:[],
					active:0
				},
				subscription:{},
				amount: ''
			}
		},
		computed: {
			...mapState(['theme'])
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
			uni.setLocale(this.$i18n.locale=='ht'?'zh-Hant':'en');
			
		},
		onLoad(options) {
			this.id = options.id;
			this.getDetails()
			this.getCoinList()
		},
		methods:{
			// 修改支付币种
			changeCoin(e){
				this.$set(this.coin,'active',e.detail.value)
			},
			// 产品详情
			getDetails() {
				try {
					const that=this;
					that.$utils.initDataToken({ 
						url: "subscription/sub_info",
						data:{id: this.id},
					}, res => {
						this.$set(this, 'subscription', res );
						uni.setNavigationBarTitle({
							title: `${this.subscription.currency_name}`
						});
					});
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}	
			},
			// 获取币种列表
			getCoinList(){
				try {
					const that = this;
					that.$utils.initDataToken({
						url: "subscription/getPayableCurrencies",
						type: "POST"
					}, res => {
						if (res.length) that.$set(this.coin, 'list', res);
					});
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}
			},
			submit(){
				try {
					const that = this;
					
					if (!that.amount) {
					  that.$utils.showLayer(that.$t('subscription.qsrje'));
					  return false;
					}
					if (parseFloat(that.amount) > parseFloat(that.coin.list[that.coin.active].change_account.balance)) {
					  that.$utils.showLayer(that.$t('subscription.yuebuzhu'));
					  return false;
					}
					
					that.$utils.initDataToken({
						url: "subscription/submit",
						data:{
							sub_id: this.id,
							amount: this.amount,
							pay_currency_id: that.coin.list[that.coin.active].id
						},
					}, res => {
						that.$utils.showLayer(that.$t('subscription.success'));
						setTimeout(()=>{
							that.$router.push({path:'/pages/subscription/orders'});
						},1000)
					});
					
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}
				
			}
		}
	}
</script>