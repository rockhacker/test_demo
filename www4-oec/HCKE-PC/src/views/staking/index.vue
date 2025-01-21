<template>
	<div class="minh100 ft16 bgpart">
		<div>
			<div class="mauto wt1300">
				<div class="flex alcenter">
					<img class="wt300 ht300" src="../../assets/images/c-cover.png" >
					<div class="flex1 ml40">
						<div class="ft50 bold">{{$t('staking.mining')}}</div>
						<div class="coverTag  mt40">
							<p class="mb20">{{$t('new.newdescribe1')}}</p>
							<p>{{$t('staking.newdescribe2')}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		

		<div class="mauto pt20 wt1300 pb80">
			<div class="mb-30" v-if="list.length">
				<div class="flex alcenter pb-10 bdbea2 pb10">
					<div class="wt150">{{ $t('new.mingzi') }}</div>
					<div class="wt100 tc">{{ $t('legal.coin') }}</div>
					<div class="wt200 tc">{{ $t('new.zhangfu') }}</div>
					<!-- <div class="wt200 tc">{{ $t('new.shizhi') }}</div> -->
					<div class="wt200 tc">{{ $t('new.gjl') }}</div>
					<div class="tc">{{ $t('addressList.address') }}</div>
				</div>
				<div v-for="item in list" :key="item.id" class="flex items-center ptb10 bdbea2">
					<div class="wt150">{{ item.name }}</div>
					<div class="wt100 tc">{{ item.symbol }}</div>
					<div class="wt200 tc" :class="[item.quote.USD.percent_change_24h<0?'red':'green']">{{ item.quote.USD.percent_change_24h }}%</div>
					<!-- <div class="wt200 tc">{{ item.quote.USD.market_cap }}</div> -->
					<div class="wt200 tc">{{ item.total_supply }}</div>
					<div class="tc">{{ item.platform && item.platform.token_address }}</div>
				</div>
			</div>
			
			<div>
				<div class="mauto wt1200 ptb20">
					<div>
						<el-link class="sgbtn plr5 ptb5 radius10 black" style="float: right;" @click="$router.push({path:'/stakingOrders'})">{{$t('staking.shengouliebiao')}}</el-link>
					</div>
				</div>
			</div>
			
			<div class="flex wraps alcenter between">
				<div v-for="item,index in stakingData" :key="index" class="savingCard">
					<div class="flex">
						<img class="wt80 ht80" :src="`${item.icon}`" />
						<div class="ml20">
							<div class="black ft20 bold">{{item.title}}</div>
							<div class="savingCardTag">{{item.code}}</div>
							<div class="black ft16">{{$t('staking.meiqipaixi')}}:<span class="pl10 new-main-text">{{item.dividend_percentage}}%</span></div>
						</div>
					</div>
					<div class="flex mt20 between gray7 gt16">
						<div>{{$t('staking.suocangtianshu')}}：<span class="black bold">{{item.lock_dividend_days}}/day</span></div>
						<div>
							<div class="tr">
								{{$t('staking.qigoujine')}}：<span class="black">{{item.staring_sub_amount}}</span>
							</div>
							<div class="tr mt10">
								{{$t('staking.zuigaoshengou')}}：<span class="black">{{item.max_sub_amount}}</span>
							</div>
						</div>
					</div>

					<div class="savingProgressBar posRelt mt20">
						<div class="savingRunBar abstort" :style="`width:${item.speed}%`"></div>
					</div>

					<div class="flex jsend">
						<div class="sgbtn plr5 ptb5 black radius10" @click="$router.push({path:`/stakingDetails?id=${item.id}`})">{{$t('staking.shengou')}}</div>
					</div>
				</div>
			</div>
		</div>
		<footerComponet></footerComponet>
	</div>
</template>
<script>
import footerComponet from '@/components/footer'
export default {
	components:{footerComponet},
  data() {
    return {
          stakingData: [],
		  list: []
    };
  },
  created() {
    // if(!localStorage.getItem('token')){
    //   this.$utils.layerMsg(this.$t('second.p_loginandtrade'));
    //   this.$router.push({name:'login'})
    //   return;
    // }
	this.getList()
	this.getProductList()
  },
  methods: {
	getList(){
		const that = this;
		that.$http.initDataToken({ 
			url: "/defi"}, false).then(res => {
				that.list = res.data
		});
	},
    // 产品列表
    getProductList() {
		try {
			const that = this;
			that.$http.initDataToken({ 
				url: "/fund/list",
				data:{
					limit:100,
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
								max_sub_amount:item.max_sub_amount,
								speed:item.speed*100
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
		color:#4fe6ff;
	}
	.el-slider__button{
		border-color: #4fe6ff;
	}
	.el-slider__bar{
		background-color: #4fe6ff;
	}
	.el-input-group__append button.el-button,
	.el-button:focus, .el-button:hover{
		color: #FFF;
		background-color: #4fe6ff;
		border-color: #4fe6ff;
	}

	.coverTag {
    font-size: 20px;
    font-weight: 400;
    margin-bottom: 50px;
    /* color: rgb(175, 175, 175); */
}

.sgbtn{
  background: #4fe6ff;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
}
.sgbtn .el-link--inner{
color: black !important;
}

.savingCard {
    width: 560px;
	min-width: 560px;
    /* background: rgb(0,0,0); */
	background-color: #f3f3f3;
    padding: 30px;
    border-radius: 30px;
    margin: 20px;
    font-family: "Lato";
}

.savingCardTag {
    font-size: 26px;
    margin-bottom: 5px;
    /* color: rgb(180,180,180); */
    letter-spacing: 1px;
    font-weight: 800;
}

.savingProgressBar{
    width: 100%;
    height: 2px;
    background: rgb(95, 95, 95);
    margin-bottom: 20px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    font-size: 10px;
}

.savingRunBar{
    border-radius: 20px;
    background: linear-gradient(90deg, rgb(79,230,255) 70%, rgb(0, 217, 255) 30%);
    box-shadow: 0px 0px 10px rgb(30, 106, 120);
    background-size: 50px;
    height: 6px;
    font-size: 8px;
    color: black;
    text-align: right;
    font-weight: 600;
    letter-spacing: 1px;
    animation: flash 0.9s linear infinite;
}
@keyframes flash {
    100%{
        background-position: 50px 0px;
    }
}
</style>