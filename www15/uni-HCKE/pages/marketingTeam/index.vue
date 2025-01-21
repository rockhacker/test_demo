<template>
	<view class="bg-floor">
		<view class="p-20" v-if="accounts.list.length">
			<view class="rounded-10 p-30 text-white">
				<view class="flex justify-between mb-30">
					<view>{{$t('team.zhanghujine')}} ({{accounts.list[accounts.active].currency_code}})</view>
					<view>{{$t('team.tdljls')}}</view>
				</view>
				<view class="flex justify-between mb-30 font-bold">
					<view class="text-xl">{{accounts.list[accounts.active].balance || '0'}}</view>
					<view class="text-xl">{{accounts.list[accounts.active].team_all_comm_amount || '0'}}</view>
				</view>
				<view class="flex justify-between mb-30">
					<view>{{$t('team.leijiyongjin')}}</view>
					<view>{{$t('team.dangriyongjin')}}</view>
				</view>
				<view class="flex justify-between mb-30 font-bold">
					<view class="text-xl">{{accounts.list[accounts.active].all_comm_amount || '0'}}</view>
					<view class="text-xl">{{accounts.list[accounts.active].day_comm_amount || '0'}}</view>
				</view>
				<view class="flex justify-between mb-30">
					<view>{{$t('team.leijiliushui')}}</view>
					<view>{{$t('team.dangriliushui')}}</view>
				</view>
				<view class="flex justify-between font-bold">
					<view class="text-xl">{{accounts.list[accounts.active].all_amount || '0'}}</view>
					<view class="text-xl">{{accounts.list[accounts.active].day_amount || '0'}}</view>
				</view>
			</view>
		</view>
		<view class="" style="min-height: calc(100vh - 275px)">
			<view class="border-0 border-b-2 border-solid border-gray-300 p-30 font-bold flex items-center justify-between">
				<view class="flex">
					<picker :value="accounts.active" :range="accounts.list" class="flex-1" @change="changeCoin" range-key="currency_code">
						<view class="text-xl text-center text-my-yellow" v-if="accounts.list.length">{{ accounts.list[accounts.active].currency_code }}</view>
						<!-- <view class="text-xl text-center text-my-yellow" v-if="accounts.list.length">USDT</view> -->
					</picker>
					<uni-icons class="text-white ml-10" type="arrowdown" size="18" ></uni-icons>
				</view>
				
				<navigator url="/pages/marketingTeam/order">
					{{$t('team.tuanduidingdan')}}
					<uni-icons class="text-white" type="arrowright" size="14"></uni-icons>
				</navigator>
			</view>
			<view class="flex p-20 font-bold">
				<view class="flex-1 ">
					{{$t('team.fanyongjine')}}
				</view>
				<view class="flex-1 text-center">
					{{$t('team.youxiang')}}
				</view>
				<view class="w-200 text-right">
					{{$t('team.shijian')}}
				</view>
			</view>
			<view class="flex p-20 items-center" v-for="item,index in list" :key="index">
				<view class="flex-1">
					{{parseFloat(item.comm_amount).toFixed(2)}} {{ accounts.list[accounts.active].currency_code }}
				</view>
				<view class="flex-1 text-center">
					{{item.get_user_info.email}}
				</view>
				<view class="w-200 text-right">
					{{item.comm_time}}
				</view>
			</view>
			<view class="pt-100 text-center" v-if="list.length == 0">
				<image src="../../static/image/anonymous.png" class="w-120 h-120"></image>
				<view>{{ $t('team.noRecords') }}</view>
			</view>
		</view>
	</view>
</template>
<script>
	import { mapState } from 'vuex';
	export default{
		computed: {
			...mapState(['theme']),
		},
		data(){
			return {
				accounts:{
					list:[],
					active:0
				},
                list:[],
				page: 1,
				last:false,
				limit: 10,
			}
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
			uni.setNavigationBarTitle({
				title:this.$t('team.team')
			})
		},
		mounted() {
			// console.log(123)
			this.getAccountList();
		},
		methods: {
			// 修改支付币种
			changeCoin(e){
				this.$set(this.accounts,'active',e.detail.value);
				this.page = 1;
				this.getAccountList();
			},
			// 获取账户金额
			getAccountList() {
				try {
					const that = this;
					that.$utils.initDataToken({
						url: "commission/account_list",
						type: "POST"
					}, res => {
						if (res.accounts && res.accounts.length) {
							that.$set(this.accounts, 'list', res.accounts);
							this.getTotalData();
							this.getMyCommList();
						}
					});
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}
			},
			// 获取团队详情
			getTotalData(){
				try {
					const that = this;
					that.$utils.initDataToken({
						url: "commission/total_data",
						type: "GET",
						data: {
							currency_id: that.accounts.list[that.accounts.active].currency_id
						}
					}, res => {
						if (res) {
							let data = {
								...res,
								...that.accounts.list[that.accounts.active]
							};
							that.accounts.list[that.accounts.active] = data;
							that.$forceUpdate();
						}
					});
				} catch (e) {
					console.log(e);
					// TODO handle the exception
				}
			},
			// 获取返佣列表
			getMyCommList(){
				try {
					const that = this;
					that.$utils.initDataToken({
						url: "commission/my_comm_list",
						type: "GET",
						data: {
							currency_id: that.accounts.list[that.accounts.active].currency_id,
							page: that.page,
							limit: that.limit
						}
					}, res => {
						that.last = !res.data.length; //已加载完 禁止触底
						that.$set(that, 'list', that.page == 1 ? res.data : that.list.concat(res.data));
					});
				} catch (e) {
					console.log(e);
					// TODO handle the exception
				}
			},
		},
		onPullDownRefresh() {
			this.page = 1;
			this.getMyCommList();
			setTimeout(() => {
				uni.stopPullDownRefresh();
			}, 1000);
		},
		onReachBottom() {
			if (this.last) return this.$utils.showLayer(this.$t('team.noRecords'));
			this.page++;
			this.getMyCommList()
		}
	}
</script>
<style>
	.bg{
		background-image: linear-gradient(to right, #41D8dd, #5583ee) !important
	}
</style>