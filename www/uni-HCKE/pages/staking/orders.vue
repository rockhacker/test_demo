<template>
	<view :class="theme">
		<view class="text-black dark:text-white dark:bg-101625 w-full overflow-hidden">

			<view v-if="tableData.length">
				<view v-for="(item, index) in tableData" :key="index"
					class="p-40 m-40 rounded-10 text-xl bg-white dark:bg-1A222B">

					<view class="text-center text-xl font-bold border-0 border-b-2 border-solid border-gray-200 pb-20">
						{{item.get_fund.title}}
					</view>

					<view class="flex justify-between p-20 mb-20">
						<view class="text-xl">{{ item.get_fund.currency_code }}</view>
						<view>{{ item.statusStr }}</view>
					</view>

					<view class="my-20 flex items-center text-center">
						<view class="flex-1">
							<view class="my-10">{{item.share_amount}}</view>
							<view class="text-gray-500">{{$t('staking.shengoushuliang')}}</view>
						</view>
						<view class="flex-1">
							<view class="my-10">{{item.sub_time}}</view>
							<view class="text-gray-500">{{$t('staking.shengoushijian')}}</view>
						</view>
					</view>

					<view class="mt-20 rounded-3xl p-20 text-sm text-center"
						:class="!item.status?'bg-main-linear text-white':'bg-yellow-liner text-black'"
						@tap="!item.status?applyRefund(item):''">
						{{ $t("staking.weiyueshuhui") }}
					</view>

					<navigator :url="`/pages/staking/income?id=${item.id}`"
						class="mt-20 rounded-3xl p-20 text-sm text-center"
						:class="!item.status?'bg-main-linear text-white':'bg-yellow-liner text-black'">
						{{ $t("staking.chakanshouyi") }}
					</navigator>
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
							item.status = item.status - 1;
							return {
								...item,
								statusStr: statusStr[item.status]
							}
						})
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
