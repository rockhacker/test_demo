<template>
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20 mb60">
			<el-card class="ft18 mb20" style="background-color: #F7F9FA;">
				{{$t('team.team')}}
				<el-link style="float: right; padding: 3px 0" type="primary" @click="$router.push({path:'/marketingTeam/order'})">{{$t('team.tuanduidingdan')}} > </el-link>
			</el-card>
			<el-card class="box-card mb20 bg white" v-if="accounts.list.length">
				<div class="mb20">
					<div class="flex between mb10">
						<div>{{$t('team.zhanghujine')}} ({{accounts.list[accounts.active].currency_code}})</div>
						<div>{{$t('team.tdljls')}}</div>
					</div>
					<div class="flex between bold">
						<div>{{accounts.list[accounts.active].balance || '0'}}</div>
						<div>{{accounts.list[accounts.active].team_all_comm_amount || '0'}}</div>
					</div>
				</div>
				<div class="mb20">
					<div class="flex between mb10">
						<div>{{$t('team.leijiyongjin')}}</div>
						<div>{{$t('team.dangriyongjin')}}</div>
					</div>
					<div class="flex between bold">
						<div>{{accounts.list[accounts.active].all_comm_amount || '0'}}</div>
						<div>{{accounts.list[accounts.active].day_comm_amount || '0'}}</div>
					</div>
				</div><div class="mb20">
					<div class="flex between mb10">
						<div>{{$t('team.leijiliushui')}}</div>
						<div>{{$t('team.dangriliushui')}}</div>
					</div>
					<div class="flex between bold">
						<div>{{accounts.list[accounts.active].all_amount || '0'}}</div>
						<div>{{accounts.list[accounts.active].day_amount || '0'}}</div>
					</div>
				</div>
			</el-card>
			<el-card v-if="accounts.list.length">
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
				
				<el-table :data="list" :empty-text="$t('team.noRecords')" style="min-height: 300px;">
					<el-table-column prop="comm_amount" :label="$t('team.fanyongjine')" align="center"></el-table-column>
					<el-table-column prop="get_user_info.email" :label="$t('team.youxiang')" align="center"></el-table-column>
					<el-table-column prop="comm_time" :label="$t('team.shijian')" align="center"></el-table-column>
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
		<footerComponet class="footer"></footerComponet>
    </div>
</template>
<script>
import footerComponet from '@/components/footer'
export default {
	components:{
		footerComponet
	},
    data(){
        return{
            accounts:{
            	list:[],
            	active:0
            },
            list:[],
			total:0,
			limit:10,
			page:1
        }
    },
    created(){
		this.getAccountList();
    },
    methods:{
		// 修改支付币种
		changeCoin(e){
			// console.log(e);
			this.getAccountList();
		},
		getAccountList(){
		   try {
				this.$http.initDataToken({
					url: "commission/account_list",
					type: "POST"
				},false).then(res => {
					if (res.accounts && res.accounts.length) {
						this.$set(this.accounts, 'list', res.accounts);
						this.getTotalData();
						this.getMyCommList();
					}
				});
		   } catch (e) {
				console.log(e);
				//TODO handle the exception
		   }
		},
		handleCurrentChange(val) {
		  this.list = [];
		  this.page = val;
		  this.getMyCommList();
		},
		// 获取团队详情
		getTotalData(){
			try {
				const that = this;
				that.$http.initDataToken({
					url: "commission/total_data",
					type: "GET",
					data: {
						currency_id: this.accounts.list[this.accounts.active].currency_id
					}
				},false).then(res => {
					if (res) {
						let data = {
							...res,
							...this.accounts.list[this.accounts.active]
						};
						this.accounts.list[this.accounts.active] = data;
						this.$forceUpdate();
					}
				});
			} catch (e) {
				console.log(e);
				// TODO handle the exception
			}
		},
		// 获取返佣列表
		getMyCommList(){
			try {
				const that = this;
				that.$http.initDataToken({
					url: "commission/my_comm_list",
					type: "GET",
					data: {
						currency_id: this.accounts.list[this.accounts.active].currency_id,
						page: that.page,
						limit: that.limit
					}
				},false).then( res => {
					that.total = res.total;
					if (res.data) {
						let data = res.data.map(item=>{
							return {
								...item,
								comm_amount: `${parseFloat(item.comm_amount).toFixed(2)} ${this.accounts.list[this.accounts.active].currency_code}`, 
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
    }
}
</script>
<style type="text/css">
	.bg{
		background-image: linear-gradient(to right, #41D8dd, #5583ee) !important
	}
	.el-input__inner{
		border: 1px solid #DCDFE6 !important;
	}
</style>