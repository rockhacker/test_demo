<template>
    <div class="flex column">
        <div class="flex">
             <div class="bgheader bdbheader flex1 plr10 ht40 lh40 baselight2 ft16">{{$t('lever.pankou')}}</div>
             <!-- <div class="bgheader bdbheader flex1 plr10 ht40 lh40 baselight2 ft16 ml5">全站成交 </div> -->
        </div>
        <div class="flex1 flex">
            <div class="flex column w100 flex1 bgpart">
                <div class="plr10 ptb10 flex1 flex column w100 ft14">
                    <div class="flex alcenter">
                        <!-- <span class="flex1">{{$t('lever.direction')}}</span> -->
                        <span class="flex1">{{$t('lever.price')}}</span>
                        <span class="flex1 tr">{{$t('lever.num')}}</span>
                    </div>
                    <!-- 卖盘 -->
                <div class="flex1 bdbheader  mt10">
                    <!-- 没有socket推送的时候 -->
                    <div  class="asks">
                        <div class="ptb5 flex alcenter pointer lh22"  v-for='(item,i) in outlist' :key="i" :style="'background-size:'+parseInt((item.amount/sellMax)*100)+'% 100%'" style="transition:0.8s" @click="changeSell(item.price)">
                            <!-- <span class="flex1 red">{{$t('trade.sell1')}}{{outlist.length-i}}</span> -->
                            <span class="flex1 baselight2">{{item.price}}</span>
                            <span class="flex1 tr baselight2">{{item.amount}}</span>
                        </div>  
                    </div>
                        
                    <!-- <div v-else class="ptb5 flex alcenter pointer"  v-for='(item,i) in outlistSocket' :key="i"  @click="changeSell(item.price)">
                        <span class="flex1 red">{{item.index}}</span>
                        <span class="flex1 tc baselight2">{{item.price}}</span>
                        <span class="flex1 tr baselight2">{{item.number}}</span>
                    </div>   -->
                </div>
                <div class="ptb10 bdbheader">
                    <div class="bold ft20 mtb10" :class="[currency_matchInfo.Change < 0 ? 'red' : 'green']">{{ currency_matchInfo.ForexQuotations.Close || "0.00"}}</div>
                    <!-- <span class="">≈{{ currency_matchInfo.currency_quotation.close *cny_usd || "0.00" | filterDecimals}}CNY</span> -->
                </div>
                <!-- 买盘 -->
                <div class="flex1 bgpart pt10">
                    <div class="bids">
                        <div class="ptb5 flex alcenter pointer lh22"  v-for='(item,i) in inlist' :key="i"  :style="'background-size:'+parseInt((item.amount/buyMax)*100)+'% 100%'" style="transition:0.8s"  @click="changeBuy(item.price)">
                            <!-- <span class="flex1 green">{{$t('trade.buy1')}}{{i+1}}</span> -->
                            <span class="flex1 baselight2">{{item.price}}</span>
                            <span class="flex1 tr baselight2">{{item.amount}}</span>
                        </div>  
                    </div>
                    <!-- <div class="ptb5 flex alcenter pointer" v-else  v-for='(item,i) in inlistSocket' :key="i" @click="changeBuy(item.price)">
                        <span class="flex1 green">{{item.index}}</span>
                        <span class="flex1 tc baselight2">{{item.price}}</span>
                        <span class="flex1 tr baselight2">{{item.number}}</span>
                    </div>    -->
                </div>
                </div>
            </div>
           
            
        </div>
        
    </div>
</template>
<script>
export default {
    props:['inlist','outlist','currency_matchInfo','cny_usd'],
    data(){
        return {
            
           
        }
    },
  
    created(){
        
    },
    mounted(){
    
    }, 
    computed:{
        sellMax() {
			//卖盘最大数量
			let list = [],
				data = this.outlist;
			data.map(item => {
				list.push(item.amount);
			});
			return Math.max.apply(null, list);
		},
        buyMax() {
			//买盘最大数量
			let list = [],
				data = this.inlist;
			data.map(item => {
				list.push(item.amount);
			});
			return Math.max.apply(null, list);
		},
    },
    methods:{
    //   更新下单
        changeBuy(price){
            eventBus.$emit('changeBuyPrice',price);
        },
        changeSell(price){
            eventBus.$emit('changeSellPrice',price);
        }

    }
}
</script>

<style lang="scss" scoped>
 .asks>div{
		background-image: linear-gradient(rgba(250,82,82,.1),rgba(250,82,82,.1));
	}
	.bids>div{
		background-image: linear-gradient(rgba(18,184,134,.1),rgba(18,184,134,.1));
	}
	.asks>div,.bids>div{
		background-position: 100%;
		background-repeat: no-repeat;
		background-size: 0% 100%;
	}
</style>