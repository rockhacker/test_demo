<template>
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20">
			
			<el-card class="box-card mb20 dark-bg-1C2532">
				<el-breadcrumb separator="/">
				  <el-breadcrumb-item :to="{ path: '/subscription' }"><span class="dark-text-white">{{$t('subscription.new_subscription')}}</span></el-breadcrumb-item>
				  <el-breadcrumb-item><span class="dark-text-white">{{$t('subscription.my_subscription')}}</span></el-breadcrumb-item>
				</el-breadcrumb>
			</el-card>
			<el-card class="box-card mb20 dark-bg-1C2532">
				<div class="ft18 mt10 mb20 dark-text-white">{{$t('subscription.my_subscription')}}</div>
				<el-table :data="tableData" :highlight-current-row="false" :empty-text="$t('subscription.noRecords')" style="width: 100%" header-cell-class-name="dark-bg-1C2532"  cell-class-name="dark-bg-1C2532">
					<el-table-column class-name="dark-text-white" prop="created_at" :label="$t('subscription.shenggoushijian')" align="center"></el-table-column>
					<el-table-column class-name="dark-text-white" prop="subscription.currency_name" :label="$t('subscription.bizhong')" align="center"></el-table-column>
					<el-table-column class-name="dark-text-white" prop="number" :label="$t('subscription.shenggoushuliang')" align="center"></el-table-column>
					<el-table-column class-name="dark-text-white" prop="winning_lots_number" :label="$t('subscription.zhongqianshuliang')" align="center"></el-table-column>
					<el-table-column class-name="dark-text-white" prop="subscription.market_time" :label="$t('subscription.shangshishijian')" align="center"></el-table-column>
					<el-table-column class-name="dark-text-white" prop="statusStr" :label="$t('subscription.status')" align="center"></el-table-column>
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