<template>
  <div class="minh100 ft16 bgblack financial-wdtg">
    <div class="mauto wt1200 ptb20">
      <el-card class="ft18 mb20 f-item white" style="border:0;">
        <div class="flex mt-40 px-60">
          <div
            class="text-xl"
            style="margin-right:40px"
            :class="{ type: active == 1 }"
            @click="change(1)"
          >
            {{ $t('financial.tgz') }}
          </div>
          <div
            class="text-xl"
            :class="{ type: active == 2 }"
            @click="change(2)"
          >
            {{ $t('financial.ysh') }}
          </div>
        </div>
        <div>

          <el-table :data="list" :empty-text="$t('staking.noRecords')" header-cell-class-name="f-item white" row-class-name="f-item white" style="width: 100%">
					<el-table-column prop="get_matter.title" :label="$t('staking.mingcheng')" align="center"></el-table-column>
					<el-table-column prop="get_matter.currency_code" :label="$t('staking.bizhong')" align="center"></el-table-column>
					<el-table-column prop="share_amount" :label="$t('staking.shengoushuliang')" align="center"></el-table-column>
					<el-table-column prop="get_matter.status_str" :label="$t('staking.zhuantai')" align="center"></el-table-column>
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
											  type="primary"
											   @click="$router.push({path:`/financialIncome?id=${list[scope.$index].id}`})">{{$t('staking.chakanshouyi')}}</el-button>
											   <!-- :disabled="!!list[scope.$index].status" -->
									<el-button
											  size="mini"
											  :type="list[scope.$index].status?'info':'primary'"
											  :disabled="list[scope.$index].status!=1"
											  @click="applyRefund(list[scope.$index])">{{$t('staking.weiyueshuhui')}}</el-button>
								</div>
					      </template>
					    </el-table-column>
				</el-table>


        </div>
      </el-card>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      active: 1,
      list:[]
    }
  },
  created(){
    this.getData()
  },
  methods: {
    change(index) {
      this.active = index
      this.getData()
    },
    getData() {
      this.$http
        .initDataToken(
          {
            url: 'matter/subList',
            data: {
              limit: 100,
              type: this.active
            }
          },
          false
        )
        .then((res) => {
          console.log(res, 44)
          this.list = res.data
        })
    },
    // 申请赎回
		applyRefund(item) {
			try {
				const that=this;
				// let penalSum = item.share_amount * ((item.get_fund.liquidated_damages / 100) * item.surplus_period)
					let penalSum = item.share_amount * (item.get_matter.liquidated_damages / 100)
				that.$confirm(`${that.$t('staking.pay')} ${penalSum}${item.get_matter.currency_code} ${that.$t('staking.payPenalSumRedemption')}`, that.$t('staking.hint'), {
				          confirmButtonText: that.$t('staking.shuhui'),
				          cancelButtonText: that.$t('staking.fanhui'),
				          type: 'warning',
						  closeOnClickModal:false
				        }).then(() => {
							  that.$http.initDataToken({url: "/matter/applyRematter" , data:{sub_id:item.id}}).then(res => {
									setTimeout(()=>{
										that.getData();
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
}
</script>

<style lang="scss">
.financial-wdtg {
  .type {
    border: 0 solid #37b6ff;
    border-bottom-width: 4px;
  }
  .el-table__empty-text,.el-table__empty-block{
    background: #181A20 !important;
  }
  .hover-row{
    background: #181A20 !important;
  }
  .el-table__body tr.hover-row>td{
     background: #181A20 !important;
  }
}
</style>
