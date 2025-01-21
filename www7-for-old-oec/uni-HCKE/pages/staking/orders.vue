<template>
	<view :class="theme">
		<uni-nav-bar fixed backIcon>
			<view class="flex-1 p-30 bg-white dark:bg-new-black flex justify-center items-center text-2xl">
				{{$t('staking.shengouliebiao')}}
			</view>
			<slot name="right">
				<view class="w-100"></view>
				<navigator url="/pages/staking/commission" 
					class="px-10 py-10 border-2 rounded-10 absolute top-24 right-20 z-10" >
					<image src="/static/image/record1.png" mode="aspectFit" class="w-30 h-30" ></image>
				</navigator>
			</slot>
		</uni-nav-bar>

		<view v-if="tableData.length" class="text-black dark:text-white dark:bg-gray-600 dark:bg-opacity-30 w-full overflow-hidden p-40">

			<view v-for="(item, index) in tableData" :key="index"
					class="rounded-3xl bg-new-black text-whte px-40 py-30 mb-30">
					<view class="flex items-center">
						<image :src="`${item.get_fund.image}`" class="w-120 h-120 mr-40"></image>
						<view>
							<view class="text-base mb-8">{{item.get_fund.title}}</view>
							<view class="text-3xl">{{item.get_fund.currency_code}}</view>
						</view>
					</view>

					<view class="savingProgressBar relative my-40">
						<view class="savingRunBar absolute max-w-full"  :style="`width:${item.is_go*100}%`"></view>
						</view>

					<!-- <view class="text-center text-xl font-bold border-0 border-b-2 border-solid border-gray-200 pb-20">
						{{item.get_fund.title}}
					</view>

					<view class="flex justify-between p-20 mb-20">
						<view class="text-xl">{{ item.get_fund.currency_code }}</view>
						<view>{{ item.statusStr }}</view>
					</view> -->

					<view class="my-20 flex items-center text-center">
						<view class="flex-1">
							<view class="my-10">{{item.sub_time}}</view>
							<view class="text-gray-500">{{$t('staking.shengoushijian')}}</view>
						</view>
						<view class="flex-1">
							<view class="my-10">{{item.end_time}}</view>
							<view class="text-gray-500">{{$t('financial.dqsj')}}</view>
						</view>
					</view>

					<view class="my-20 flex items-center text-center">
						<view class="flex-1">
							<view class="my-10">{{item.share_amount}}</view>
							<view class="text-gray-500">{{$t('staking.shengoushuliang')}}</view>
						</view>
						<view class="flex-1">
							<view class="my-10">{{item.all_free}}</view>
							<view class="text-gray-500">{{$t('financial.yjsy')}}</view>
						</view>
					</view>

					<navigator :url="`/pages/staking/income?id=${item.id}`"
						class="mt-20 rounded-3xl p-20 text-sm text-center"
						:class="item.status!==3 &&item.status!==4?'bg-primary text-black':'bg-danger text-white'">
						{{ $t("staking.chakanshouyi") }}
					</navigator>

					<view class="mt-20 rounded-3xl p-20 text-sm text-center"
					    v-if="item.status!==3 &&item.status!==4"
						:class="item.status!==3 &&item.status!==4?'bg-primary text-black':'bg-danger text-white'"
						@tap="item.status!==3 &&item.status!==4?applyRefund(item):''">
						{{ $t("staking.weiyueshuhui") }}
					</view>

					
			</view>

		</view>
	</view>
</template>

<script>
	import {
		mapState
	} from 'vuex'
	export default {
		data() {
			return {
				tableData: []
			};
		},
		computed: {
			...mapState(['theme']),
		},
		onLoad(options) {
			uni.setNavigationBarTitle({
				title: this.$t("staking.shengouliebiao")
			})
			this.getProductList();
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
		},
		methods: {
			// 产品详情
			getProductList() {
				try {
					const that = this;
					that.$utils.initDataToken({
						url: "fund/subList",
						data: {
							limit: 100,
							page: 0
						}
					}, res => {
						const statusStr = [this.$t("staking.shengouliebiao"), this.$t(
							"staking.shengqingtuikuanzhong"), this.$t("staking.yituikuan"), this.$t(
							"staking.yijieshu")];
						const data = res.data.map((item) => {
							// item.status = item.status - 1;
							return {
								...item,
								// statusStr: statusStr[item.status]
							}
						})
						// console.log(data,33);
						
						that.$set(that, 'tableData', data);
					});
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}
			},

			// 申请赎回
			applyRefund(item) {
				try {
					const that = this;
					// let penalSum = item.share_amount * ((item.get_fund.liquidated_damages / 100) * item.surplus_period)
					let penalSum = item.share_amount * (item.get_fund.liquidated_damages / 100)
					uni.showModal({
						title: that.$t('staking.hint'),
						content: `${that.$t('staking.pay')} ${penalSum}${item.get_fund.currency_code} ${that.$t('staking.payPenalSumRedemption')}`,
						showCancel: true,
						cancelText: that.$t('staking.fanhui'),
						confirmText: that.$t('staking.shuhui'),
						confirmColor: '#999999',
						success: res => {
							if (res.confirm) {
								that.$utils.initDataToken({
									url: "fund/applyRefund",
									data: {
										sub_id: item.id
									}
								}, (res, msg) => {
									that.$utils.showLayer(msg);
									setTimeout(() => {
										that.getProductList();
									}, 1000)
								});
							}

						},
						fail: () => {},
						complete: () => {}
					});

				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}
			},
			// 查看收益列表
			getInsList(id) {
				try {
					const that = this;
					that.$utils.initDataToken({
						url: "fund/insList",
						data: {
							sub_id: id
						}
					}, (res, msg) => {
						// that.$utils.showLayer(msg);
						console.log(res.data);
					});
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}
			},
		}
	}
</script>
<style lang="scss" scope>
	.el-breadcrumb__inner a:hover,
	.el-breadcrumb__inner.is-link:hover {
		color: #fcd435e5;
	}
</style>
