<template>
	<div class="minh100 ft16 s-orders">
		<div class="mauto wt1200 ptb20">
			
			<el-card class="box-card mb20 f-item" style="border:0">
				<el-breadcrumb class="white" separator="/">
				  <el-breadcrumb-item class="white" :to="{ path: '/subscription' }">{{$t('subscription.new_subscription')}}</el-breadcrumb-item>
				  <el-breadcrumb-item class="white">{{$t('subscription.my_subscription')}}</el-breadcrumb-item>
				</el-breadcrumb>
			</el-card>
			<el-card class="box-card mb20 f-item" style="border:0">
				<div class="ft18 mt10 mb20 white">{{$t('subscription.my_subscription')}}</div>
				<el-table :data="tableData" :empty-text="$t('subscription.noRecords')" header-cell-class-name="f-item" row-class-name="f-item" style="width: 100%;">
					<el-table-column prop="created_at" :label="$t('subscription.shenggoushijian')" align="center"></el-table-column>
					<el-table-column prop="subscription.currency_name" :label="$t('subscription.bizhong')" align="center"></el-table-column>
					<el-table-column prop="number" :label="$t('subscription.shenggoushuliang')" align="center"></el-table-column>
					<el-table-column prop="winning_lots_number" :label="$t('subscription.zhongqianshuliang')" align="center"></el-table-column>
					<el-table-column prop="subscription.market_time" :label="$t('subscription.shangshishijian')" align="center"></el-table-column>
					<el-table-column prop="statusStr" :label="$t('subscription.status')" align="center"></el-table-column>
				</el-table>
			 </el-card>
		</div>
	</div>
</template>
<script>
export default {
	data() {
		return {
			tableData:[]
		};
	},
	created() {
		this.getProductList();
	},
	methods: {
		// 申购列表
		getProductList() {
			try {
				const that=this;
				that.$http.initDataToken({url: "subscription/mySubList" , data:{limit:100,page:0}},false).then(res => {
					const statusStr = [this.$t("subscription.daichouqian"), this.$t("subscription.weizhongqian"), this.$t("subscription.yizhongqian") ,this.$t("subscription.yifabi") ,this.$t("subscription.yituikuan")];
					const data = res.data.map((item) => {
						item.status = item.status-1;
						return {
							...item,
							statusStr: statusStr[item.status] + (item.is_return==2?that.$t('subscription.bufentuikuan'):'')
						}
					})
					that.$set(that,'tableData', data);
				});
			} catch (e) {
				console.log(e);
				//TODO handle the exception
			}	
		},
  }
};
</script>

<style lang="scss">
.s-orders{
.el-breadcrumb__inner a, .el-breadcrumb__inner.is-link{
	color:white !important;
}
.el-breadcrumb__item:last-child .el-breadcrumb__inner, .el-breadcrumb__item:last-child .el-breadcrumb__inner a, .el-breadcrumb__item:last-child .el-breadcrumb__inner a:hover, .el-breadcrumb__item:last-child .el-breadcrumb__inner:hover{
	color: white;
}
}

</style>