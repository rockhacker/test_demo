<template>
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20">
			<el-card class="box-card mb20 dark-bg-1C2532">
				<el-breadcrumb separator="/">
				  <el-breadcrumb-item :to="{ path: '/subscription' }"><span class="dark-text-white">{{$t('subscription.new_subscription')}}</span></el-breadcrumb-item>
				  <el-breadcrumb-item v-if="subscription.currency_name"><span class="dark-text-white">{{`${subscription.currency_name}${$t('subscription.shenggou')}`}}</span></el-breadcrumb-item>
				</el-breadcrumb>
			</el-card>
			
			<el-card class="box-card mb20 ft20 dark-bg-1C2532 dark-text-white">
				<div class="ft18 mlr20 mtb20 plr70 ptb30 radius10">
					<div class="ptb20"  v-if="coin.list[coin.active]">
						<div class="ft18 mb10">{{$t('subscription.balance')}}</div>
						<div class="bold">{{ coin.list[coin.active].change_account.balance }} {{ coin.list[coin.active].code }}</div>
					</div>
					<div class="bdbea2 ptb20">
						<div class="ft18 mb10">{{$t('subscription.faxingjia')}}</div>
						<div class="yellow bold">1{{subscription.currency_name}} = {{subscription.sub_price}} USDT</div>
					</div>
					<div class="bdbea2 ptb20">
						<div class="mb10 flex between">
							<div class="">{{$t('subscription.faxingshuliang')}}</div>
							<div class="yellow bold">{{subscription.issue_number}} {{subscription.currency_name}}</div>
						</div>
						<div class="flex between">
							<div class="">{{$t('subscription.shengyushuliang')}}</div>
							<div class="yellow bold">{{subscription.issue_number - subscription.subscribed || ''}} {{subscription.currency_name}}</div>
						</div>
					</div>
					<div class="flex ft16 ptb20">
						<div class="flex1">
							<div class="mb10">
								{{$t('subscription.shenggoubizhong')}}
							</div>
							<div class="">
								{{subscription.currency_name}}
							</div>
						</div>
						<div class="flex1">
							<div class="mb10">
								{{$t('subscription.yjsxsj')}}
							</div>
							<div class="">
								{{subscription.market_time}}
							</div>
						</div>
					</div>
					<div class="flex ft16 ptb20">
						<div class="flex1">
							<div class="mb10">
								{{$t('subscription.kssgsj')}}
							</div>
							<div class="">
								{{subscription.start_time}}
							</div>
						</div>
						<div class="flex1">
							<div class="mb10">
								{{$t('subscription.jssgsj')}}
							</div>
							<div class="">
								{{subscription.finish_time}}
							</div>
						</div>
					</div>
					<div class="flex mauto ptb50">
						
						<div class="wt200 mr20">
							<el-select v-model="coin.active">
							    <el-option
							      v-for="item,index in coin.list"
							      :key="index"
							      :label="item.code"
							      :value="index">
							    </el-option>
							  </el-select>
						</div>
						
						<div class="flex1 bdbea2">
							<input type="number" :placeholder="$t('subscription.qsrje')" class="w100 h100 ft18 plr20 black dark-text-white" v-model="amount">
						</div>
						
					</div>
					<el-button class="w100 mb50 bg-main-liner white" @click="submit">{{$t('subscription.lijishenggou')}}</el-button>
					
					<div v-if="subscription.currency && subscription.currency.desc" class="mb50">
						<div class="ft16 black dark-text-white mb20">{{$t('subscription.bizhongjieshao')}}</div>
						<div class="flex1 word-wrap">{{subscription.currency.desc}}</div>
					</div>
				</div>
			</el-card>
		</div>
	</div>
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
		},
		created() {
			this.id = this.$route.query.id;
			this.getDetails()
			this.getCoinList()
		},
		methods:{
			// 产品详情
			getDetails() {
				try {
					const that=this;
					that.$http.initDataToken({ 
						url: "subscription/sub_info",
						data:{id: that.id},
					},false).then(res => {
						that.$set(that, 'subscription', res );
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
					that.$http.initDataToken({
						url: "subscription/getPayableCurrencies",
						type: "POST"
					},false).then(res => {
						if (res.length) that.$set(that.coin, 'list', res);
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
						that.$utils.layerMsg(that.$t('subscription.qsrje'));
						return false;
					}
					
					if (parseFloat(that.amount) > parseFloat(that.coin.list[that.coin.active].change_account.balance)) {
						that.$utils.layerMsg(that.$t('subscription.yuebuzhu'));
						return false;
					}
					
					that.$http.initDataToken({
						url: "subscription/submit",
						data:{
							sub_id: that.id,
							amount: that.amount,
							pay_currency_id: that.coin.list[that.coin.active].id
						},
					},false).then( res => {
						that.$message({
						  message: that.$t('subscription.success'),
						  type: 'success'
						});
						setTimeout(()=>{
							that.$router.push({path:'/subscriptionOrders'});
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