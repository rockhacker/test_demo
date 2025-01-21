<template>
	<div class="minh100 ft16">
		<div class="mauto wt1200 ptb20">
			
			<el-card class="box-card mb20">
				<el-breadcrumb separator="/">
				  <el-breadcrumb-item :to="{ path: '/staking' }">{{$t('staking.mining')}}</el-breadcrumb-item>
				  <el-breadcrumb-item>{{$t('staking.shengouliebiao')}}</el-breadcrumb-item>
				</el-breadcrumb>
			</el-card>
			<el-card class="box-card mb20">
				<div slot="header" class="clearfix">
					<div class="flex">
						<img class="wt80 ht80" :src="`${staking.icon}`">
						<div class="flex1 ml20">
							 <div class="gray3 bold mb30">{{staking.title}}</div>
							  <div class="flex flexend">
								<span class="ft30 mr20">{{staking.code}}</span>
								<el-tag size="mini" type="warning">{{$t('staking.meiqipaixi')}} {{staking.dividend_percentage}}%</el-tag>
							 </div>
						 </div>
					</div>
				</div>
				<div class="flex2 ft18 mlr20 mtb20 flex jscenter bgf6 plr30 ptb30 radius10">
					 <div class="w100 mt20 plr20 ptb20">
						<div class="w70 flex column mtb20 mauto">
							<div class="flex alcenter between mb30">
								<div class="gray7">{{$t('staking.qigoujine')}}</div>
								<div class="ml10 black">{{staking.staring_sub_amount}}</div>
							</div>
							<div class="flex alcenter between mb30">
								<span class="gray7">{{$t('staking.suocangtianshu')}}</span>
								<span class="ml10 black">{{staking.lock_dividend_days}}/day</span>
							</div>
							<div class="flex alcenter between mb30">
								<span class="gray7">{{$t('staking.zuigaoshengou')}}</span>
								<span class="ml10 black">{{staking.max_sub_amount}}</span>
							</div>
							<div class="flex alcenter between mb30 pointer" @click="getCoupon()">
								<span class="gray7">{{$t('new.xzzjq')}}</span>
								 <div>
									<span v-if="selectedCoupon">{{parseFloat(selectedCoupon.amount)}}{{selectedCoupon.currency.code}}</span>
								 <img class="wt15" src="../../assets/images/arrow-right.png" alt=""></img>
								 </div>
							</div>
							<!-- <div class="flex alcenter between mb30">
								<span class="gray7">{{$t('staking.shuhui')}}</span>
								<span class="ml10 black">{{staking.liquidated_damages}}%</span>
							</div> -->
							
							 <div class="flex mb20">
								<el-input v-model="amount" type="number" class="wt340 bgwhite">
									<template slot="append"><el-button type="warning" class="wt100 ml20" style="border-radius: 0;" @click="buyProduct">{{$t('staking.shengou')}}</el-button></template>
								</el-input>
							 </div>

							<div class="mb30">
								<span class="black">{{$t('trade.balance')}}:</span>
								<span class="ml10 black">{{staking.balance}}</span>
							</div>
							 
							 <div class="ft22 mb20">{{$t('staking.chanpinjieshao')}}</div>
							 <div class="flex1" style="white-space: pre-line">{{staking.desc}}</div>
						</div>
					 </div>
					 
				</div>
			</el-card>
		</div>


    <el-dialog
    class="coupon-dialog"
  :title="$t('new.kqlb')"
  :visible.sync="dialogVisible"
  width="440px">
  
  <div class="overyauto" style="max-height:450px">


    <div class="mb10 flex  posRelt" :class="{'expire-base-coupons' :item.status!=0,'base-coupons pointer':item.status==0}" v-for="(item,index) in couponList" :key="index" @click="setCoupon(item)">
      
        <div class="flex column jscenter pl10" style="width:80px;">
          <div class="ft28">{{parseFloat(item.amount)}}</div>
          <div class="ft16 mt10">{{item.currency.code}}</div>
        </div>
        <div class=" ml30 ptb20 flex1 black">
          <div class="ft24">{{item.title}}</div>
          <div class="">{{$t('new.gqsj')}}:{{item.exp_time}}</div>
          <div class="">{{$t('new.fqsj')}}:{{item.created_at}}</div>
           <div class="">{{$t('new.syxz')}}:{{$t('new.ddmz')}}<span>{{parseFloat(item.min_amount)}}</span>{{item.currency.code}}</div>
        <div class="flex jsend mr40">
          <span class="plr10 white radius10" style="background:gray;" v-if="item.status==0">{{$t('new.wsy')}}</span>
           <span class="plr10 white radius10" style="background:gray;"  v-if="item.status==1">{{$t('new.ysy')}}</span>
            <span class="plr10 white radius10" style="background:gray;"  v-if="item.status==-1">{{$t('new.ygq')}}</span>
        </div>
      </div>
      <img src="../../assets/images/pitch_on.png" v-if="selectedCoupon && selectedCoupon.id==item.id" alt="" class="abstort btm0 rt0" />
    </div>
  </div>
  
  <!-- <span slot="footer" class="dialog-footer">
    <el-button @click="dialogVisible = false">取 消</el-button>
    <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
  </span> -->
</el-dialog>
	</div>
</template>
<script>
export default {
  data() {
    return {
		staking:{},
		amount:'',
      dialogVisible:false,
      couponList:[],
      selectedCoupon:null
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
		setCoupon(item){
      if(item.status !=0){
        return
      }
      if(this.selectedCoupon&& this.selectedCoupon.id==item.id){
        this.selectedCoupon = null
        return
      }
      this.selectedCoupon = item
      this.dialogVisible = false
    },
    getCoupon(){
      this.dialogVisible = true
      var that = this;
      that.$http
        .initDataToken({
          url: "/coupon/check_coupon",
          type: "POST",
          data: {
            currency_id:that.staking.currency_id,
          }
        },false)
        .then(res => {
          res.forEach(item => {
            if(item.status==0){
              if(new Date(item.exp_time).getTime()<= new Date().getTime()){
                item.status = -1 // 过期
              }
            } 
          });
          that.couponList = res
          console.log(res);
        });
    },
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
						desc:res.desc,
						currency_id:res.currency_id,
						balance:res.balance
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
				
				that.$http.initDataToken({url: "/fund/buy",data:{id: id,amount:that.amount,coupon_id:that.selectedCoupon? that.selectedCoupon.id: 0}}).then(res => {
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
	.el-breadcrumb__inner a:hover, .el-breadcrumb__inner.is-link:hover{
		color: #fcd435e5;
	}
	.el-input-group__append button.el-button,
	.el-button:focus, .el-button:hover{
		color: #FFF;
		background-color: #4fe6ff;
		border-color: #4fe6ff;
	}
</style>