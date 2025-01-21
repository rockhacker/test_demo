<template>
	<div class="minh100 ft16 bgblack">
		<div class="bgblack">
			<div class="mauto wt1200 ptb20">
				<div class="flex between">
					<div class="flex1">
						<div class="ft40 bold white">{{$t('staking.kuanjishangcheng')}}</div>
						<div class="ft16  mtb20" style="width:500px">
							{{$t('staking.describe1')}}
						</div>
						<div class="ft18 mt40">{{$t('staking.chanpinyoushi')}}</div>
						<div class="flex wt200 green mt20">
							<div class="flex1 flex alcenter"><div class="wt5 ht5 bggreen radius50p mr10"></div>{{$t('staking.suicunsuiqu')}}</div>
							<div class="flex1 flex alcenter"><div class="wt5 ht5 bggreen radius50p mr10"></div>{{$t('staking.meirixiafa')}}</div>
						</div>
						<div class="flex wt200 green mt10">
							<div class="flex1 flex alcenter"><div class="wt5 ht5 bggreen radius50p mr10"></div>{{$t('staking.suocangzhouqi')}}</div>
							<div class="flex1 flex alcenter"><div class="wt5 ht5 bggreen radius50p mr10"></div>{{$t('staking.suishikongtou')}}</div>
						</div>
						<!-- <div class="ft16 gray7 mtb20" style="width:500px">
							{{$t('staking.describe2')}}
							 
							{{$t('staking.describe3')}}
							 
							{{$t('staking.describe4')}}
						</div> -->
					</div>
					<img class="wt300 ht300" src="../../assets/images/staking.png" >
				</div>
			</div>
		</div>
		<div class="mauto pt20 wt1200 pb80">
			<el-card class="ft18 mb20 f-item" style="border:0;">
				<span class="white">{{$t('staking.chanpinliebiao')}}</span>
				<el-link class="text-primary" style="float: right; padding: 3px 0"  @click="$router.push({path:'/stakingOrders'})">{{$t('staking.shengouliebiao')}}</el-link>
			</el-card>
			<el-card class="box-card f-item mb20" v-for="item,index in stakingData" :key="index">
				<div class="flex between plr10 ptb10">
					 <div class="flex2">
						 <div class="flex">
							<img class="wt80 ht80" :src="`${item.icon}`">
							<div class="flex1 ml20">
								 <div class="gray3 bold mb30">{{item.title}}</div>
								  <div class="flex flexend">
									<span class="ft30 mr20">{{item.code}}</span>
									<el-tag size="mini" type="warning">{{$t('staking.meiqipaixi')}} {{item.dividend_percentage}}%</el-tag>
								 </div>
							 </div>
						 </div>
						 
						 <div class="mt20 ft14 flex">
						 	<div class="flex1">
						 		<span class="wt140 gray7">{{$t('staking.qigoujine')}}：</span>
						 		<span class="ml10">{{item.staring_sub_amount}}</span>
						 	</div>
						 	<div class="flex1">
						 		<span class="wt140 gray7">{{$t('staking.suocangtianshu')}}：</span>
						 		<span class="ml10">{{item.lock_dividend_days}}</span>
						 	</div>
						 </div>
					 </div>
					 <div class="flex1 flex column between">
						 <div class="flex jsend">
							<el-button type="warning" class="wt100 mr10" style="border-radius: 0;" @click="$router.push({path:`/stakingDetails?id=${item.id}`})">{{$t('staking.shengou')}}</el-button>
						 </div>
						<!-- <div class="flex ft16 gray7 tc mt20">
							<div class="flex1">
								<span class="warning">{{item.max_sub_amount}}</span>
								<div class="mt10">{{$t('staking.zuidishengou')}}</div>
							</div>
							<div class="flex1">
								<span class="warning">{{item.liquidated_damages}}%</span>
								<div class="mt10">{{$t('staking.shuhui')}}</div>
							</div>
						 </div> -->
					 </div>
			 </div>
		  </el-card>
			<el-card class="box-card mb20 tc ptb40  f-item" style="border:0;" v-if="stakingData.length==0">
				<img src="../../assets/images/nodata.png">
				<p class="white">{{$t('legal.norecord')}}</p>
			</el-card>
		</div>
	</div>
</template>
<script>
export default {
  data() {
    return {
          stakingData: []
    };
  },
  created() {
    // if(!localStorage.getItem('token')){
    //   this.$utils.layerMsg(this.$t('second.p_loginandtrade'));
    //   this.$router.push({name:'login'})
    //   return;
    // }
	this.getProductList()
  },
  methods: {
    // 产品列表
    getProductList() {
		try {
			const that = this;
			that.$http.initDataToken({ 
				url: "/fund/list",
				data:{
					limit:20,
					page:0,
				}}, false).then(res => {
					console.log(res);
					if(res.data.length){
						const data = res.data.map((item) => {
							return {
								id: item.id,
								icon: item.image,
								title: item.title,
								code: item.currency_code,
								staring_sub_amount:item.staring_sub_amount,
								lock_dividend_days:item.lock_dividend_days,
								liquidated_damages:item.liquidated_damages,
								dividend_percentage:item.dividend_percentage,
								max_sub_amount:item.max_sub_amount
							}
						})
						that.$set(this,'stakingData',data);
					}
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
	.warning{
		color:#37b6ff;
	}
	.el-slider__button{
		border-color: #37b6ff;
	}
	.el-slider__bar{
		background-color: #37b6ff;
	}
	.el-input-group__append button.el-button,
	.el-button:focus, .el-button:hover{
		color: #FFF;
		background-color: #37b6ff;
		border-color: #37b6ff;
	}
</style>