<template>
  <view class="p-30">
      <view class="bg-cover p-30" style="background: url('./static/image/lc_item_bg.png');height: 256rpx;">
             <view class="flex items-center">
              <!-- <text class="text-2xl mr-24">{{ $t('assets.lc') }}{{ ' '+ info.lock_dividend_days + ' '}}{{ $t('new.day') }}</text> -->
               <text class="text-2xl mr-24">{{info.title}}</text>
              <view class="rounded-xl px-16 py-6 text-my-orange" style="background: rgba(255, 178, 22, .1);">{{$t('financial.rsyl')}} {{info.dividend_percentage}}%</view>
            </view>
             <view class="mt-50" style="color:#979797">
            <view>{{$t('financial.dbxe')}}(USDT):
              <text class="pl-10 white">{{info.staring_sub_amount}}-{{info.max_sub_amount}}</text>
            </view>
            <!-- <view class="mt-16">{{$t('financial.gq')}}:
              <text class="pl-10 white"></text>
            </view> -->
          </view>
      </view>

    <view class="p-30 rounded-xl mt-30" style="background: #272727;">
        <view>   
            <text class="text-lg" style="color:#CACACA">{{$t('financial.pxsj')}}: </text>
            <text class="pl-10 text-lg">{{$t('financial.meitian')}}</text>
        </view>
        <view class="mt-20">
            <text class="text-lg" style="color:#CACACA">{{$t('financial.tgje')}}: </text>
            <text class="pl-10 text-lg">{{$t('financial.dqfh')}}</text>
        </view>
        <view class="mt-20">
            <text class="text-lg" style="color:#CACACA">{{$t('financial.tqsh')}}: </text>
            <text class="pl-10 text-lg">{{info.liquidated_damages}}%</text>
        </view>
        <view class="mt-20">
            <text class="text-lg" style="color:#CACACA">{{$t('financial.yjsy')}}: </text>
            <text class="pl-10 text-lg">{{info.min_profit}}~{{info.max_profit}}</text>
        </view>
    </view>

    <view class="p-30 rounded-xl mt-30" style="background: #272727;">
        <view class="text-2xl">{{$t('financial.tgje')}}</view>
        <view class="flex py-20" style="border:0 solid rgba(255, 255, 255, 0.2);border-bottom-width: 1rpx;">
            <input class="flex-1 text-lg pr-10" v-model="amount" type="number" :placeholder="$t('financial.qsrtgje')">
            <view class="text-lg">USDT</view>
        </view>
        <view class="flex justify-between mt-20">
            <view class="flex  justify-between flex-1 pr-16">
                <view style="color: #FEFEFE;">{{$t('financial.kyzc')}}(USDT)</view>
                <view style="color: #FEFEFE;">{{balance}} USDT</view>
            </view>
            <view @click="amount = balance" class="text-my-orange pl-16" style="border:0 solid rgba(255, 255, 255, 0.2);border-left-width:1rpx;">
                {{$t('trade.all')}}
            </view>
        </view>
    </view>

    <view @click="buy()" class="h-88 w-580 rounded-3xl text-center leading-88 text-2xl mx-auto mt-60 bg-primary">
        {{$t('legal.buy')}}
    </view>

  </view>
</template>

<script>
import {mapState} from 'vuex'
export default {
    data(){
        return {
            info:{},
            amount:'',
            id:"",
            balance: ''
        }
    },
    onLoad(options) {
			uni.setNavigationBarTitle({
				title:this.$t('trade.buy')
			})
            this.id = options.id
            this.getData(options.id)
            this.getBalance()
	},
    onShow() {
		   this.$utils.setThemeTop(this.theme)
		  // this.getList()
		},
    computed:{
        ...mapState(['theme']),
    },
    methods:{
        getData(id){
            this.$utils.initDataToken({ url: 'matter/info',data:{id} }, (res) => {
                this.info = res
                console.log(res,33)
            })
        },
        getBalance(){
            this.$utils.initDataToken({ url: 'account/list' }, (res) => {
                console.log(res,44)
                this.balance = res[0].accounts[0].balance
            })
        },
        buy(){
            let that = this
            if (!that.amount) {
				  that.$utils.showLayer(that.$t('financial.qsrtgje'));
				  return false;
				}
            // uni.navigateTo({
			// 	url: '/pages/financial/confirm',
			// });
            this.$utils.initDataToken({ url: 'matter/buy',data:{
                id:this.id,
                amount:this.amount
            } }, (res,msg) => {
                that.$utils.showLayer(msg)
                this.amount = ''
                console.log(res,55)
            })
        }
    }
}
</script>

<style>

</style>