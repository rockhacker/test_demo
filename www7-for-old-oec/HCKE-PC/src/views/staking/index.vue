<template>
	<div class="minh100 ft16 new-balck2">
		<div>
			<div class="mauto wt1300">
				<div class="flex alcenter">
					<img class="wt300 ht300" src="../../assets/images/c-cover.png" >
					<div class="flex1 ml40">
						<div class="ft50 bold white">{{$t('staking.mining')}}</div>
						<div class="coverTag  mt40">
							<p class="mb20">{{$t('new.newdescribe1')}}</p>
							<p>{{$t('staking.newdescribe2')}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div>
			<div class="mauto wt1200 ptb20">
				<div>
					<el-link class="sgbtn plr5 ptb5 radius10 black" style="float: right;" @click="$router.push({path:'/stakingOrders'})">{{$t('staking.shengouliebiao')}}</el-link>
				</div>
			</div>
		</div>

		<div class="mauto pt20 wt1200 pb80">
			<div class="mb-30" v-if="list.length">
				<div class="flex alcenter pb-10 bdbea2 pb10">
					<div class="flex1">{{ $t('new.mingzi') }}</div>
					<div class="flex1">{{ $t('legal.coin') }}</div>
					<div class="flex1">{{ $t('new.zhangfu') }}</div>
					<div class="flex1 tr">{{ $t('new.shizhi') }}</div>
				</div>
				<div v-for="item in list" :key="item.id" class="flex items-center ptb10 bdbea2">
					<div class="flex1">{{ item.name }}</div>
					<div class="flex1">{{ item.symbol }}</div>
					<div class="flex1">{{ item.quote.USD.percent_change_24h }}</div>
					<div class="flex1 tr">{{ item.quote.USD.market_cap }}</div>
				</div>
			</div>
			<div class="flex wraps alcenter between">
				<div v-for="item,index in stakingData" :key="index" class="savingCard">
					<div class="flex">
						<img class="wt80 ht80" :src="`${item.icon}`" />
						<div class="ml20">
							<div class="white ft20 bold">{{item.title}}</div>
							<div class="savingCardTag">{{item.code}}</div>
							<div class="white ft16">{{$t('staking.meiqipaixi')}}:<span class="pl10 new-main-text">{{item.dividend_percentage}}%</span></div>
						</div>
					</div>
					<div class="flex mt20 between gray7 gt16">
						<div>{{$t('staking.suocangtianshu')}}：<span class="white bold">{{item.lock_dividend_days}}/day</span></div>
						<div>
							<div class="tr">
								{{$t('staking.qigoujine')}}：<span class="white">{{item.staring_sub_amount}}</span>
							</div>
							<div class="tr mt10">
								{{$t('staking.zuigaoshengou')}}：<span class="white">{{item.max_sub_amount}}</span>
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
	// this.getList()
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
		color:#e6a23c;
	}
	.el-slider__button{
		border-color: #e6a23c;
	}
	.el-slider__bar{
		background-color: #e6a23c;
	}
	.el-input-group__append button.el-button,
	.el-button:focus, .el-button:hover{
		color: #FFF;
		background-color: #E6A23C;
		border-color: #E6A23C;
	}

	.coverTag {
    font-size: 20px;
    font-weight: 400;
    margin-bottom: 50px;
    color: rgb(175, 175, 175);
}

.sgbtn{
  background: rgb(255,200,0);
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
    background: rgb(0,0,0);
    padding: 30px;
    border-radius: 30px;
    margin: 20px;
    font-family: "Lato";
}

.savingCardTag {
    font-size: 26px;
    margin-bottom: 5px;
    color: rgb(180,180,180);
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
    background: linear-gradient(90deg, rgb(230, 149, 0) 70%, rgb(255,200,0) 30%);
    box-shadow: 0px 0px 10px rgb(255,200,0);
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