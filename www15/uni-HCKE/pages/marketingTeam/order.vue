<template>
	<view :class="theme" class="bgPart" style="min-height: calc(100vh - 44px);">
		<view class="flex bgPart fixed w-full left-0" >
			<view class="flex-1 flex h-80 justify-center items-center text-lg text-center" :class="{'border-green-500 border-0 border-b-2 border-solid': tabs==0}" @click="changeTabs(0)">{{$t('team.yiji')}}</view>
			<view class="flex-1 flex h-80 justify-center items-center text-lg text-center" :class="{'border-green-500 border-0 border-b-2 border-solid': tabs==1}" @click="changeTabs(1)">{{$t('team.erji')}}</view>
			<!-- <view class="flex-1 flex h-80 justify-center items-center text-lg text-center" :class="{'border-green-500 border-0 border-b-2 border-solid': tabs==2}" @click="changeTabs(2)">{{$t('team.sanji')}}</view> -->
		</view>
		<view class="pt-80 bgPart" style="min-height: calc(100vh - 44px);">
			<view class="flex justify-between items-center py-30 dark:bg-gray-700 p-30">
				<view class="flex">
					<picker :value="accounts.active" :range="accounts.list" class="flex-1" @change="changeCoin" range-key="currency_code">
						<view class="text-xl text-center" v-if="accounts.list.length">{{ accounts.list[accounts.active].currency_code }}</view>
					</picker>
					<uni-icons class="text-black dark:text-white ml-10 font-bold" type="arrowdown" size="18" ></uni-icons>
				</view>
			</view>
			<view class="px-30">
				<view class="py-20 border-0 border-b-2 border-solid border-gray-200" v-for="item,index in list" :key="index">
					<view class="flex items-center justify-between mb-20">
						<view class="text-lg">
							UID: {{item.get_user_info.uid}}
						</view>
						<view class="text-lg">
							{{$t('team.dingdangjine')}}: {{parseFloat(item.order_amount).toFixed(2)}} {{ accounts.list[accounts.active].currency_code }}
						</view>
					</view>
					<view class="flex items-center justify-between">
						<view class="text-lg">
							{{$t('team.fanyongshijian')}}：<view>{{item.comm_time}}</view>
						</view>
						<view class="text-lg">
							{{$t('team.fanyongjine')}}：{{parseFloat(item.comm_amount).toFixed(2)}} {{ accounts.list[accounts.active].currency_code }}
						</view>
					</view>
				</view>
				
				<view class="pt-100 text-center" v-if="list.length == 0">
					<image src="../../static/image/anonymous.png" class="w-120 h-120"></image>
					<view>{{ $t('team.noRecords') }}</view>
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
				accounts:{
					list:[],
					active:0
				},
				list: [],
				tabs:0,
				page: 1,
				last:false,
				limit: 10,
			};
		},
		computed:{
		   ...mapState(['theme']),
		},
		onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('team.tuanduidingdan')
			})
			this.getAccountList();
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
		},
		methods:{
			changeTabs(e) {
				this.tabs = e;
				this.page = 1;
				this.getTeamCommList();
			},
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
							that.$set(that.accounts, 'list', res.accounts);
							that.getTeamCommList();
						}
					});
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}
			},
			// 获取返佣列表
			getTeamCommList(){
				try {
					const that = this;
					that.$utils.initDataToken({
						url: "commission/team_comm_list",
						type: "GET",
						data: {
							currency_id: that.accounts.list[that.accounts.active].currency_id,
							class: that.tabs+1,
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
			this.getTeamCommList();
			setTimeout(() => {
				uni.stopPullDownRefresh();
			}, 1000);
		},
		onReachBottom() {
			if (this.last) return this.$utils.showLayer(this.$t('team.noRecords'));
			this.page++;
			this.getTeamCommList()
		}
	}
</script>