<template>
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20">
			
			<el-card class="box-card mb20 f-item white" style="border:0;">
				<el-breadcrumb separator="/">
				  <el-breadcrumb-item :to="{ path: '/financial' }"><span class="white">{{$t('financial.financial')}}</span></el-breadcrumb-item>
				  <el-breadcrumb-item><span class="white">{{$t('staking.shouyiliebiao')}}</span></el-breadcrumb-item>
				</el-breadcrumb>
			</el-card>
			<el-card class="box-card mb20 f-item white" style="border:0;">
				<div class="ft18 mt10 mb20">{{$t('staking.shouyiliebiao')}}</div>
				<el-table :data="tableData" :empty-text="$t('staking.noRecords')"  header-cell-class-name="f-item white" row-class-name="f-item white" style="width: 100%">
					<el-table-column prop="interest" :label="$t('staking.lixi')" align="center"></el-table-column>
					<el-table-column prop="created_at" :label="$t('staking.time')" align="center"></el-table-column>
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
				that.$http.initDataToken({url: "matter/insList" , data:{sub_id:id} },false).then(res => {
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