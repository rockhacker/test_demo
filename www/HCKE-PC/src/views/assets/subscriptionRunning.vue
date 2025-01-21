<template>
  <div class="plr20 ptb20">
    <div class=" plr15 ">
		<ul>
			<li class="flex alcenter ptb10">
			  <span class="flex1">{{$t('assets.currency')}}</span>
			  <span class="flex1 tc">{{$t('assets.numbers')}}</span>
			  <span class="flex1 tc">{{$t('assets.record')}}</span>
			  <span class="flex1 tr">{{$t('assets.times')}}</span>
			</li>
			<li class="flex alcenter ptb10" v-for="item in list" :key="item.id">
			  <span class="flex1">{{item.currency.code}}</span>
			  <span class="flex1 tc">{{item.value}}</span>
			  <span class="flex1 tc">{{item.memo}}</span>
			  <span class="flex1 tr">{{item.created_at}}</span>
			</li>
		</ul>
      <!-- 分页 -->
      <div v-if="total > pageInfo.pageSize" class="w100 tc pages mb40 mt20">
			<el-pagination
			  :total="total"
			  layout="prev, pager, next"
			  @current-change="handleCurrentChange"
			></el-pagination>
      </div>
      <div>
        <div class="tc ptb40" v-if="total==0">
          <img src="../../assets/images/nodata.png" alt class="wt70" />
          <p>{{$t('assets.noData')}}</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
	data() {
		return {
			pageInfo:{
				pageSize:15,
				pageNumber:1
			},
			list: [],
			total: 0
		};
	},
	created() {
		var that = this;
		that.getSubAccountLog();
	},
	methods: {
		getSubAccountLog(){
			
			try {
				
				const that=this;
				
				that.$http.initDataToken({
					url: "/subscription/SubAccountLog",
					data:{
						limit: that.pageInfo.pageSize,
						page: that.pageInfo.pageNumber,
					}},false).then(res => {
						that.$set(this,'list',res.data);
						that.$set(this,'total',res.total);
					});
			} catch (e) {
				console.log(e);
				//TODO handle the exception
			}
				
		},
		handleCurrentChange(val) {
			
			var that = this;
			
			that.list = [];
			
			that.pageInfo.pageNumber = val;
			
			that.getSubAccountLog();
			
		}
	}
};
</script>
<style>
.pages .el-dialog,
.el-pager li {
  background: transparent;
}

.pages .el-pagination button {
  background: transparent !important;
  color: #b0b8db !important;
}

.pages .el-pagination button:disabled {
  color: #5a5a5a !important;
}

.pages .el-pagination {
  color: #b0b8db;
}
</style>