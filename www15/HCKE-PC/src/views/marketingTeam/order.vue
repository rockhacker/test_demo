<template>
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20">
			<el-card class="box-card mb20">
				<div class="flex between w-100 alcenter">
					<el-breadcrumb separator="/">
					  <el-breadcrumb-item :to="{ path: '/marketingTeam/index' }">{{$t('team.team')}}</el-breadcrumb-item>
					  <el-breadcrumb-item>{{$t('team.tuanduidingdan')}}</el-breadcrumb-item>
					</el-breadcrumb>
					
					<div class="flex alcenter">
						<div class="mlr10">{{$t('team.bizhong')}}:</div>
						<el-select v-model="accounts.active" @change="changeCoin">
							<el-option
							  v-for="item,index in accounts.list"
							  :key="index"
							  :label="item.currency_code"
							  :value="index"
							  >
							</el-option>
						</el-select>
					</div>
				</div>
			</el-card>
			
			<el-card class="box-card mb20">
				<div class="flex bdb30">
					<div class="w-100 mr40 ptb20 pointer" :class="{'bdbgreen':tabs==0}" @click="handleClick(0)">{{$t('team.yiji')}}</div>
					<div class="w-100 mr40 ptb20 pointer" :class="{'bdbgreen':tabs==1}" @click="handleClick(1)">{{$t('team.erji')}}</div>
					<!-- <div class="w-100 mr40 ptb20 pointer" :class="{'bdbgreen':tabs==2}" @click="handleClick(2)">{{$t('team.sanji')}}</div> -->
				</div>
				<el-table :data="list" :empty-text="$t('team.noRecords')" style="min-height: 300px;" class="mt20">
					<el-table-column prop="get_user_info.uid" label="UID" align="center"></el-table-column>
					<el-table-column prop="order_amount" :label="$t('team.dingdangjine')" align="center"></el-table-column>
					<el-table-column prop="comm_time" :label="$t('team.fanyongshijian')" align="center"></el-table-column>
					<el-table-column prop="comm_amount" :label="$t('team.fanyongjine')" align="center"></el-table-column>
				</el-table>
				<!-- 分页 -->
				<div v-if="total > limit" class="w100 tc pages mb40 mt20">
				  <el-pagination
				    :total="total"
				    layout="prev, pager, next"
				    @current-change="handleCurrentChange"
				  ></el-pagination>
				</div>
			</el-card>
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				accounts:{
					list:[],
					active:0
				},
				list: [],
				tabs:0,
				activeName:["first","second","third"],
				total:0,
				limit:10,
				page:1
			};
		},
		created() {
			this.getAccountList();
		},
		methods: {
			handleClick(index) {
				this.tabs = index;
				this.getTeamCommList();
			},
			// 修改支付币种
			changeCoin(e){
				this.getAccountList();
			},
			// 获取账户金额
			getAccountList() {
				try {
					const that = this;
					that.$http.initDataToken({
						url: "commission/account_list",
						type: "POST"
					},false).then(res => {
						if (res.accounts && res.accounts.length) {
							that.$set(this.accounts, 'list', res.accounts);
							this.getTeamCommList();
						}
					});
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}
			},
			// 获取返佣列表
			getTeamCommList(){
				try {
					const that = this;
					that.$http.initDataToken({
						url: "commission/team_comm_list",
						type: "GET",
						data: {
							currency_id: this.accounts.list[this.accounts.active].currency_id,
							class: this.tabs+1,
							page: that.page,
							limit: that.limit
						}
					},false).then(res => {
						console.log(res);
						that.total = res.total;
						if (res.data) {
							let data = res.data.map(item=>{
								return {
									...item,
									order_amount: `${parseFloat(item.order_amount).toFixed(2)} ${this.accounts.list[this.accounts.active].currency_code}`, 
									comm_amount: `${parseFloat(item.comm_amount).toFixed(2)} ${this.accounts.list[this.accounts.active].currency_code}`
								}
							})
							this.$set(this, 'list', data);
						}
					});
				} catch (e) {
					console.log(e);
					// TODO handle the exception
				}
			},
			handleCurrentChange(val) {
			  this.list = [];
			  this.page = val;
			  this.getTeamCommList();
			},
	  }
	};
</script>
<style type="text/css">
	.el-input__inner{
		border: 1px solid #DCDFE6 !important;
	}
</style>