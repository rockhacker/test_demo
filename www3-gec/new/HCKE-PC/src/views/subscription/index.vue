<template>
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20">
			
			<el-card class="ft22 mb20 f-item white" style="border:0;">
				{{$t('subscription.new_subscription')}}
				<el-link style="float: right; padding: 3px 0" class="text-primary" @click="$router.push({path:'/subscriptionOrders'})">{{$t('subscription.my_subscription')}}</el-link>
			</el-card>
			
			<el-card class="box-card mb20 f-item" style="border:0;" @click="$router.push({path:'/subscriptionDetails?id=0'})" hover-class="opacity-50" v-for="(item,index) in list" :key="index">
				<div class="flex between">
					<div class="ft22 bold white">{{item.currency_name}} / {{$t('subscription.new_subscription')}}</div>
					<el-button  type='primary' class="wt100 mr10 bg-primary" style="border-radius: 0;" @click="$router.push({path:`/subscriptionDetails?id=${item.id}`})">{{$t('subscription.canjiahuodong')}}</el-button>
				</div>
				<div v-if="statusFormatting(item.start_time,item.finish_time,item.market_time).index">
					<el-tag :type="`${
							statusFormatting(item.start_time,item.finish_time,item.market_time).index == 1?
							'info':statusFormatting(item.start_time,item.finish_time,item.market_time).index == 2?
							'success':statusFormatting(item.start_time,item.finish_time,item.market_time).index == 3?
							'warning':''}`">
							{{statusFormatting(item.start_time,item.finish_time,item.market_time).name}}</el-tag>
				</div>
				<div class="ft16 flex between ptb20 alcenter">
					<div class="flex">
						<span class="white bold">{{item.subscribed}} {{item.currency_name}} </span>
						<span class="mlr10">/</span>
						<span class="gray7">{{item.issue_number}} {{item.currency_name}}</span>  
					</div>
					<div class="flex gray7">
						{{$t('subscription.shengyu')}}: {{ remainingRatio(item.subscribed,item.issue_number)}}%
					</div>
				</div>
				<div class="w100 ht30 radius40 bgf6 posRelt overxy">
					<div class="abstort lf0 h100 lh30 bg-my-orange white ft14 tr" :style="`width: ${remainingRatio(item.subscribed,item.issue_number)}%;`">
						<span class="mlr10">{{remainingRatio(item.subscribed,item.issue_number)}}%</span>
					</div>
				</div>
			</el-card>
			<el-card class="box-card mb20 tc ptb40 f-item" style="border:0" v-if="list.length==0">
				<img src="../../assets/images/nodata.png">
				<p class="white">{{$t('legal.norecord')}}</p>
			</el-card>
		</div>
	</div>
</template>
<script>
	import { mapState } from 'vuex';
	export default{
		computed: {
			...mapState(['theme']),
			// 计算剩余百分比
			remainingRatio(amount,sum){
				return (amount,sum)=>{
					return ((((sum-amount) / sum) * 100) || 0).toFixed(2);
				}
			},
			statusFormatting(start,end,market){
				return (start,end,market)=>{
					
					let statusStr = [0,this.$t('subscription.weikaishi'),this.$t('subscription.jinxingzhong'),this.$t('subscription.chouqianzhong'),this.$t('subscription.yishangshi')],
						index = 0,
						startTime = new Date(start).getTime(),
						endTime = new Date(end).getTime(),
						marketTime = new Date(market).getTime(),
						currentTime = new Date().getTime() - 28800000;
							
					if(currentTime < startTime)index = 1;
					if(currentTime >= startTime && currentTime < endTime)index = 2;
					if(currentTime >= endTime && currentTime < marketTime)index = 3;
					if(currentTime >= marketTime)index = 4;
					return {name:statusStr[index],index:index};
				}
			}
		},
		data(){
			return {
                list:[]
			}
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
		},
		created() {
           this.getSubscriptionList();
		},
		methods: {
			// 申购列表
			getSubscriptionList() {
				try {
					const that = this;
					that.$http.initDataToken({
						url: "/subscription/subscription_list",
						data: {
							limit: 20,
							page: 0,
						}
					},false).then(res => {
						if (res.data.length)that.$set(this, 'list', res.data);
					});
				} catch (e) {
					console.log(123,e);
					//TODO handle the exception
				}
			}
		}
	}
</script>