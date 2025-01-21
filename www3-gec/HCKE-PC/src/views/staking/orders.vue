<template>
	<div class="minh100 ft16 staking-orders">
		<div class="mauto wt1200 ptb20">
			
			<el-card class="box-card mb20 f-item" style="border:0;">
				<el-breadcrumb separator="/">
				  <el-breadcrumb-item :to="{ path: '/staking' }">{{$t('staking.mining')}}</el-breadcrumb-item>
				  <el-breadcrumb-item>{{$t('staking.shengouliebiao')}}</el-breadcrumb-item>
				</el-breadcrumb>
			</el-card>
			<el-card class="box-card mb20 f-item" style="border:0;">
				<div class="ft18 mt10 mb20 white">{{$t('staking.shengouliebiao')}}</div>
				<el-table :data="tableData" :empty-text="$t('staking.noRecords')" header-cell-class-name="f-item" row-class-name="f-item" style="width: 100%">
					<el-table-column prop="get_fund.title" :label="$t('staking.mingcheng')" align="center"></el-table-column>
					<el-table-column prop="get_fund.currency_code" :label="$t('staking.bizhong')" align="center"></el-table-column>
					<el-table-column prop="share_amount" :label="$t('staking.shengoushuliang')" align="center"></el-table-column>
					<el-table-column prop="statusStr" :label="$t('staking.zhuantai')" align="center"></el-table-column>
					<el-table-column prop="sub_time" :label="$t('staking.shengoushijian')" align="center"></el-table-column>
					<el-table-column
							fixed="right"
							align="center"
							:label="$t('staking.caozuo')"
							width="300">
					      <template slot-scope="scope">
								<div class="flex w100 jscenter">
									<el-button
											  size="mini"
											  type="warning"
											   @click="$router.push({path:`/stakingIncome?id=${tableData[scope.$index].id}`})">{{$t('staking.chakanshouyi')}}</el-button>
											   <!-- :disabled="!!tableData[scope.$index].status" -->
									<el-button
											  size="mini"
											  :type="tableData[scope.$index].status?'info':'warning'"
											  :disabled="!!tableData[scope.$index].status"
											  @click="applyRefund(tableData[scope.$index])">{{$t('staking.weiyueshuhui')}}</el-button>
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
				that.$confirm(`${that.$t('staking.pay')} ${penalSum}${item.get_fund.currency_code} ${that.$t('staking.payPenalSumRedemption')}`, that.$t('staking.hint'), {
				          confirmButtonText: that.$t('staking.shuhui'),
				          cancelButtonText: that.$t('staking.fanhui'),
				          type: 'warning',
						  closeOnClickModal:false
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
	.el-breadcrumb__inner{
		color: white !important;
	}
	.el-breadcrumb__inner a:hover, .el-breadcrumb__inner.is-link:hover{
		color: #fcd435e5;
	}

	.el-table__empty-block{
		background: #181A20;
	}
</style>