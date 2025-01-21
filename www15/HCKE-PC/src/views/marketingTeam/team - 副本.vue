<template>
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20">
			<el-card class="box-card mb20">
				<el-breadcrumb separator="/">
				  <el-breadcrumb-item :to="{ path: '/marketingTeam/index' }">{{$t('team.team')}}</el-breadcrumb-item>
				  <el-breadcrumb-item>{{$t('team.ckfytd')}}</el-breadcrumb-item>
				</el-breadcrumb>
			</el-card>
			
			<el-card class="box-card mb20">
				<el-tabs v-model="activeName" @tab-click="handleClick">
					<el-tab-pane label="团队1" name="first">
						<div class="w100 bold ptb20">团队人数：624</div>
						<el-table :data="list" :empty-text="$t('team.noRecords')" style="min-height: 300px;">
							<el-table-column prop="number" :label="$t('ID')" align="center"></el-table-column>
							<el-table-column prop="subscription.created_at" :label="$t('用户名称')" align="center"></el-table-column>
							<el-table-column prop="number" :label="$t('余额')" align="center"></el-table-column>
						</el-table>
						<!-- <div class="ptb20 plr20">
							<div class="flex between alcenter mb10">
								<div>用户名称：name</div>
								<div>手机号：name</div>
							</div>
							<div class="flex between alcenter mb10">
								<div>ID：name</div>
								<div>余额：name</div>
							</div>
						</div>
						<div class="ptb20 plr20">
							<div class="flex between alcenter mb10">
								<div>用户名称：name</div>
								<div>手机号：name</div>
							</div>
							<div class="flex between alcenter mb10">
								<div>ID：name</div>
								<div>余额：name</div>
							</div>
						</div> -->
					</el-tab-pane>
					<el-tab-pane label="团队2" name="second">配置管理</el-tab-pane>
					<el-tab-pane label="团队3" name="third">角色管理</el-tab-pane>
				</el-tabs>
			</el-card>
		</div>
	</div>
</template>
<script>
	export default {
		data() {
			return {
				subscription:{},
				activeName:"first"
			};
		},
		created() {
			// this.getProductList();
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
								statusStr:  statusStr[item.status] + (item.is_return==2?that.$t('subscription.bufentuikuan'):'')
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