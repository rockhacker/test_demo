<template>
	<view :class="theme" class="bg-white">
		<view class="flex bg-white fixed w-full left-0" >
			<view class="flex-1 flex h-80 justify-center items-center text-lg text-center" :class="{'border-primary border-0 border-b-2 border-solid': tabs==0}" @click="changeTabs(0)">一级</view>
			<view class="flex-1 flex h-80 justify-center items-center text-lg text-center" :class="{'border-primary border-0 border-b-2 border-solid': tabs==1}" @click="changeTabs(1)">二级</view>
			<view class="flex-1 flex h-80 justify-center items-center text-lg text-center" :class="{'border-primary border-0 border-b-2 border-solid': tabs==2}" @click="changeTabs(2)">三级</view>
		</view>
		<view class="pt-80 bg-white">
			<view class="flex justify-between items-center py-30 bg-gray-200 p-30">
				<view class="text-xl font-bold">团队人数：624</view>
				<view class="flex">
					<picker :value="accounts.active" :range="accounts.list" class="flex-1" @change="changeCoin" range-key="currency_code">
						<view class="text-xl text-center" v-if="accounts.list.length">{{ accounts.list[accounts.active].currency_code }}</view>
					</picker>
					<uni-icons class="text-black dark:text-white ml-10 font-bold" type="arrowdown" size="18" ></uni-icons>
				</view>
			</view>
			<view class="px-30">
				<view class="py-20 border-0 border-b-2 border-solid border-gray-200" v-for="item,index in list" :key="index">
					<view class="flex items-center justify-between mb-10">
						<view class="text-lg">
							用户名称：name
						</view>
						<view class="text-lg">
							ID：565656
						</view>
					</view>
					<view class="flex items-center justify-between mb-10">
						<view class="text-lg">
							余额：25626
						</view>
					</view>
				</view>
				<view class="py-20 border-0 border-b-2 border-solid border-gray-200">
					<view class="flex items-center justify-between mb-10">
						<view class="text-lg">
							用户名称：name
						</view>
						<view class="text-lg">
							ID：565656
						</view>
					</view>
					<view class="flex items-center justify-between mb-10">
						<view class="text-lg">
							余额：25626
						</view>
					</view>
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
			};
		},
		computed:{
		   ...mapState(['theme']),
		},
		onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('team.team')
			})
			this.getAccountList();
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
		},
		methods:{
			changeTabs(e) {
				this.tabs = e;
				this.getTeamCommList();
			},
			changeCoin(e){
				console.log(e)
				this.$set(this.accounts,'active',e.detail.value);
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
							this.getTeamCommList();
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
							currency_id: this.accounts.list[this.accounts.active].currency_id,
							class: this.tabs+1
						}
					}, res => {
						console.log(res);
						if (res.data && res.data.length) {
							this.$set(this, 'list', res.data);
						}
					});
				} catch (e) {
					console.log(e);
					// TODO handle the exception
				}
			},
		}
	}
</script>