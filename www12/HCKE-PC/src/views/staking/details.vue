<template>
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20">
			
			<el-card class="box-card mb20 dark-bg-1C2532">
				<el-breadcrumb separator="/">
				  <el-breadcrumb-item :to="{ path: '/staking' }"><span class="dark-text-white">{{$t('staking.mining')}}</span></el-breadcrumb-item>
				  <el-breadcrumb-item><span class="dark-text-white">{{$t('staking.shengouliebiao')}}</span></el-breadcrumb-item>
				</el-breadcrumb>
			</el-card>
			<el-card class="box-card mb20 dark-bg-1C2532">
				<div slot="header" class="clearfix">
					<div class="flex">
						<img class="wt80 ht80" :src="`${staking.icon}`">
						<div class="flex1 ml20">
							 <div class="text-333333 dark-text-white bold mb30">{{staking.title}}</div>
							  <div class="flex flexend">
								<span class="ft30 mr20 text-333333 dark-text-white">{{staking.code}}</span>
								<el-tag size="mini" class="bg-main-liner black">{{$t('staking.meiqipaixi')}} {{staking.dividend_percentage}}%</el-tag>
							 </div>
						 </div>
					</div>
				</div>
				<div class="flex2 ft18 mlr20 mtb20 flex jscenter bgf6 plr30 ptb30 radius10 dark-bg-1C2532">
					 <div class="w100 mt20 plr20 ptb20">
						<div class="w70 flex column mtb20 mauto">
							<div class="flex alcenter between mb30">
								<div class="gray7 dark-text-white">{{$t('staking.qigoujine')}}</div>
								<div class="ml10 black dark-text-white">{{staking.staring_sub_amount}}</div>
							</div>
							<div class="flex alcenter between mb30">
								<span class="gray7 dark-text-white">{{$t('staking.suocangtianshu')}}</span>
								<span class="ml10 black dark-text-white">{{staking.lock_dividend_days}}</span>
							</div>
							<div class="flex alcenter between mb30">
								<span class="gray7 dark-text-white">{{$t('staking.zuigaoshengou')}}</span>
								<span class="ml10 black dark-text-white">{{staking.max_sub_amount}}</span>
							</div>
							<!-- <div class="flex alcenter between mb30">
								<span class="gray7">{{$t('staking.shuhui')}}</span>
								<span class="ml10 black">{{staking.liquidated_damages}}%</span>
							</div> -->
							
							 <div class="flex mb60">
								<el-input v-model="amount" type="number" class="wt340 bgwhite dark-text-white dark-bg-1C2532">
									<template slot="append"><el-button class="wt100 ml20 bg-main-liner black" style="border-radius: 0;" @click="buyProduct">{{$t('staking.shengou')}}</el-button></template>
								</el-input>
							 </div>
							 
							 <div class="ft22 mb20 dark-text-white">{{$t('staking.chanpinjieshao')}}</div>
							 <div class="flex1 dark-text-white">{{staking.desc}}</div>
						</div>
					 </div>
					 
				</div>
			</el-card>
		</div>
	</div>
</template>
<script>
export default {
  data() {
    return {
		staking:{},
		amount:''
    };
  },
  created() {
    // if(!localStorage.getItem('token')){
    //   this.$utils.layerMsg(this.$t('second.p_loginandtrade'));
    //   this.$router.push({name:'login'})
    //   return;
    // }
    this.getProductDetails();
  },
	methods: {
       // 产品详情
       getProductDetails() {
   		try {
			const that=this,id = this.$route.query.id;
   			that.$http.initDataToken({ 
   				url: "/fund/info",
   				data:{
   					id: id,
   				}}, false).then(res => {
					console.log(res);
					const data = {
						id: res.id,
						icon: res.image,
						title: res.title,
						code: res.currency_code,
						staring_sub_amount:res.staring_sub_amount,
						lock_dividend_days:res.lock_dividend_days,
						liquidated_damages:res.liquidated_damages,
						dividend_percentage:res.dividend_percentage,
						max_sub_amount:res.max_sub_amount,
						desc:res.desc
					}
					console.log(data);
					that.$set(that,'staking',data);
   			});
   		} catch (e) {
   			console.log(e);
   			//TODO handle the exception
   		}	
       },
       // 申购
       buyProduct() {
		   
			try {
				
				const that=this,id = this.$route.query.id;
				
				if (!that.amount) {
				  that.$utils.layerMsg(this.$t('staking.qsrscsl'));
				  return false;
				}
				
				that.$http.initDataToken({url: "/fund/buy",data:{id: id,amount:that.amount}}).then(res => {
					this.$router.push({path:'/stakingOrders'})
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
	/* .el-breadcrumb__inner a:hover, .el-breadcrumb__inner.is-link:hover{
		color: #fcd435e5;
	}
	.el-input-group__append button.el-button,
	.el-button:focus, .el-button:hover{
		color: #FFF;
		background-color: #E6A23C;
		border-color: #E6A23C;
	} */
</style>