<template>
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20">
			
			<el-card class="box-card mb20 dark-bg-1C2532">
				<el-breadcrumb separator="/">
				  <el-breadcrumb-item :to="{ path: '/staking' }"><span class="dark-text-white">{{$t('staking.mining')}}</span></el-breadcrumb-item>
				  <el-breadcrumb-item :to="{ path: '/stakingOrders' }"><span class="dark-text-white">{{$t('staking.shengouliebiao')}}</span></el-breadcrumb-item>
				  <el-breadcrumb-item><span class="dark-text-white">{{$t('staking.shouyiliebiao')}}</span></el-breadcrumb-item>
				</el-breadcrumb>
			</el-card>
			<el-card class="box-card mb20 dark-bg-1C2532">
				<div class="ft18 mt10 mb20 dark-text-white">{{$t('staking.shouyiliebiao')}}</div>
				<el-table :data="tableData" :empty-text="$t('staking.noRecords')" style="width: 100%" header-cell-class-name="dark-bg-1C2532"  cell-class-name="dark-bg-1C2532">
					<el-table-column class-name="dark-text-white" prop="interest" :label="$t('staking.lixi')" align="center"></el-table-column>
					<el-table-column class-name="dark-text-white" prop="created_at" :label="$t('staking.time')" align="center"></el-table-column>
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
		this.getInsList();
  },
  methods: {
		// 查看收益列表
		getInsList() {
			try {
				const that=this,id = this.$route.query.id;
				that.$http.initDataToken({url: "fund/insList" , data:{sub_id:id} },false).then(res => {
					if(res.data && res.data.length){
						this.$set(this,'tableData',res.data)
					}
				});
			} catch (e) {
				console.log(e);
				//TODO handle the exception
			}	
		}
  }
};
</script>
<style lang="scss" scope>
	.el-breadcrumb__inner a:hover, .el-breadcrumb__inner.is-link:hover{
		color: #fcd435e5;
	}
</style>