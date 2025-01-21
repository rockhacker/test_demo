<template>
	<view :class="theme">
        <!-- <div class="header">
                <div class="header plr15 flex alcenter between bgHeader white fixed ">
                    <img src="../../static/image/return.png" class="header-img" @click="goback" />
                    <div class="white ft18 bold ">最新成交</div>
                    <img src="../../static/image/record1.png" alt="" class="icon-right" style="visibility: hidden;">
                </div>
        </div> -->
        <div class="" >
            <div class="plr10">
                <div class="flex alcenter ptb5 ft12">
                    <div class="flex1 text-black dark:text-white">{{$t('trade.num')}}</div>
                    <div class="flex1 tc text-black dark:text-white">{{$t('trade.price')}}</div>
                    <div class="flex1 tr text-black dark:text-white">{{$t('trade.price')}}</div>
                </div>
                <div class="">
                    <div class="flex alcenter ptb5" :class="[item.way==1?'red':'green']" v-for="(item,i) in complete" :key="i">
                        <div class="flex1">{{item.amount |fixed4(that)}}</div>
                        <div class="flex1 tc">{{item.price}}</div>
                        <div class="flex1 tr">{{item.time}}</div>
                    </div>
                </div>
            </div>
        </div>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return{
				list:[],
                complete:[],
                symbol:'',
                that:this
			}
		},
        filters: {
            fixed4(vals,that) {
                var values = that.iTofixed(vals, 4);
                return values;
            }
        },
        computed:{
			...mapState(['theme']),
		},
		onLoad(e) {
           this.symbol=e.symbol
           uni.setNavigationBarTitle({
				title:this.$t('new.deal')
			})
            this.$utils.setThemeTop(this.theme);
		},
        onShow() {
			this.$utils.setThemeTop(this.theme)
			this.$utils.setThemeBottom(this.theme)
			if(!uni.getStorageSync('token')){
				uni.navigateTo({
					url: '/pages/mine/login',
				});
				return;
			}
			this.socketData();
		},
		methods:{
            goback(){
                this.$socket.closeSocket();//关闭socket
                uni.switchTab({
					url: '/pages/trade/trade',
				});
            },
            iTofixed(values, numbers) {
                let val = Number(values);
                let num = Number(numbers);
                let nums = Number(numbers - 0 + 1);
                let base = '10';
                let decimal = base.padEnd(nums, 0) - 0;
                var vals = (Math.floor(val * decimal) / decimal).toFixed(num);
                return vals;
            },
            socketData(){//socket连接
                console.log(11111)
				var that = this;
				var tokens = uni.getStorageSync('token');
				// let symbol = this.currency_name+'/'+this.legal_name;
				that.$socket.listenFun([
                    {type: "login", params: tokens},
                    {type: "sub",params: "KLINE." + that.symbol},
                    {type: "sub",params: "DAY_MARKET"},
                    {type: "sub",params: "GLOBAL_TX." + that.symbol}
                    ],(res)=>{
					let resmsg = JSON.parse(res);
				 
                    if (resmsg.type == 'GLOBAL_TX') {
                            var comdata = resmsg.completes;
                            for (var i in comdata) {
                                comdata[i].time = that.timestampToTime(comdata[i].timestamp).substr(11)
                                that.complete.unshift(comdata[i])
                            }
                            that.complete.slice(0, 30);
                            if (that.complete.length > 30) {
                                that.complete.pop()
                            }
                            // console.log(JSON.stringify(that.complete))
                        }
				
				})
			},
            timestampToTime(timestamp) {
							var time = ''
							if (timestamp.toString().length > 11) {
								time = timestamp
							} else {
								time = timestamp * 1000
							}
							var now = new Date(time),
								y = now.getFullYear(),
								m = now.getMonth() + 1,
								d = now.getDate();
							return y + "-" + (m < 10 ? "0" + m : m) + "-" + (d < 10 ? "0" + d : d) + " " + now.toTimeString().substr(0,
								8);
						},
		},
		computed:{
		   ...mapState(['theme']),
		},
        onHide() {
            console.log('hide')
			this.$socket.closeSocket();//关闭socket
		},
	}
</script>

<style>
	.header-img{
        width: 50upx;
        height: 46upx;
    }
</style>
