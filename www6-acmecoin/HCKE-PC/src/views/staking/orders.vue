<template>
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20">
			
			<el-card class="box-card mb20 bg-box2">
				<el-breadcrumb separator="/">
				  <el-breadcrumb-item :to="{ path: '/staking'}"><span class="dark-text-white">{{$t('staking.mining')}}</span></el-breadcrumb-item>
				  <el-breadcrumb-item><span class="dark-text-white">{{$t('staking.shengouliebiao')}}</span></el-breadcrumb-item>
				</el-breadcrumb>
			</el-card>
			<el-card class="box-card mb20 bg-box2">
				<div class="ft18 mt10 mb20 dark-text-white">{{$t('staking.shengouliebiao')}}</div>
				<el-table :highlight-current-row="false" :data="tableData" :empty-text="$t('staking.noRecords')" style="width: 100%" header-cell-class-name="bg-box2"  cell-class-name="bg-box2">
					<el-table-column class-name="dark-text-white" prop="get_fund.title" :label="$t('staking.mingcheng')" align="center"></el-table-column>
					<el-table-column class-name="dark-text-white" prop="get_fund.currency_code" :label="$t('staking.bizhong')" align="center"></el-table-column>
					<el-table-column class-name="dark-text-white" prop="share_amount" :label="$t('staking.shengoushuliang')" align="center"></el-table-column>
					<el-table-column class-name="dark-text-white" prop="statusStr" :label="$t('staking.zhuantai')" align="center"></el-table-column>
					<el-table-column class-name="dark-text-white" prop="sub_time" :label="$t('staking.shengoushijian')" align="center"></el-table-column>
					<el-table-column
							class-name="dark-text-white"
							fixed="right"
							align="center"
							:label="$t('staking.caozuo')"
							width="300">
					      <template slot-scope="scope">
								<div class="flex w100 jscenter">
									<el-button
											 class="bg-main-liner white"
											  size="mini"
											   @click="$router.push({path:`/stakingIncome?id=${tableData[scope.$index].id}`})">{{$t('staking.chakanshouyi')}}</el-button>
											   <!-- :disabled="!!tableData[scope.$index].status" -->
									<!-- <el-button
												class="bg-main-liner white"
											  size="mini"
											  :type="tableData[scope.$index].status?'info':''"
											  :disabled="!!tableData[scope.$index].status"
											  @click="applyRefund(tableData[scope.$index])">{{$t('staking.weiyueshuhui')}}</el-button> -->
								</div>
					      </template>
					    </el-table-column>
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
		// 产品详情
		getProductList() {
			try {
				const that=this;
				that.$http.initDataToken({url: "/fund/subList" , data:{limit:100,page:0}}, false).then(res => {
						const statusStr = [this.$t('staking.jinxingzhong'),this.$t('staking.shengqingtuikuanzhong'), this.$t('staking.yituikuan'), this.$t('staking.yijieshu')];
						const data = res.data.map((item) => {
							item.status = item.status-1;
							return {
								...item,
								statusStr: statusStr[item.status]
							}
						})
						that.$set(that,'tableData',data);
				});
			} catch (e) {
				console.log(e);
				//TODO handle the exception
			}	
		},
		// 申请赎回
		applyRefund(item) {
			try {
				const that=this;
				// let penalSum = item.share_amount * ((item.get_fund.liquidated_damages / 100) * item.surplus_period)
				let penalSum = item.share_amount * (item.get_fund.liquidated_damages / 100)
				that.$confirm(that.$t('new.tqsh'), that.$t('staking.hint'), {
				        //   confirmButtonText: that.$t('staking.tqsh'),
				          cancelButtonText: that.$t('staking.fanhui'),
						  closeOnClickModal:false,
						  showConfirmButton:false,
						  confirmButtonClass:'bg-main-liner white',
						  cancelButtonClass:'bg-main-liner white'
				        }).then(() => {
							  that.$http.initDataToken({url: "/fund/applyRefund" , data:{sub_id:item.id}}).then(res => {
									setTimeout(()=>{
										that.getProductList();
									},1000)
							  });
				        }).catch(() => {
							console.log('已取消')         
						});
				
			} catch (e) {
				console.log(e);
				//TODO handle the exception
			}	
       },
  }
};
</script>
<style lang="scss" scope>
	.el-breadcrumb__inner a:hover, .el-breadcrumb__inner.is-link:hover{
		color: #fcd435e5;
	}
</style>