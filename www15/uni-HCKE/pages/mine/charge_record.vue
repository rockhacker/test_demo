<template>
  <view class="p-20" :class="theme">
     <view class="flex justify-between mb-20">
         <view class="flex-1 text-center">{{$t('legal.coin')}}</view>
         <view class="flex-1 text-center">{{$t('home.czsl')}}</view>
         <view class="flex-1 text-center">{{$t('home.czsj')}}</view>
         <view class="flex-1 text-center">{{$t('home.czfs')}}</view>
     </view>
     <view>
         <view class="flex justify-between mb-30" v-for="(item,index) in list" :key="index">
             <view class="flex-1 text-center">{{item.currency_code}}</view>
              <view class="flex-1 text-center">{{item.number}}</view>
              <view class="flex-1 text-center">{{item.created_at}}</view>
              <!-- 0表示链上充值，1表示电汇 -->
              <view class="flex-1 text-center">{{item.type==0? $t('rechargeTransfer.linkTranster'):$t('rechargeTransfer.cardTranster')}}</view>
         </view>
     </view>
  </view>
</template>

<script>
import {mapState} from 'vuex'
export default {
    data(){
        return {
            list:[],
			page: 1,
			last:false,
			limit: 10,
        }
    },
    computed:{
			...mapState(['theme']),
	},
    onLoad() {
        this.$utils.setThemeTop(this.theme)
        uni.setNavigationBarTitle({
            title: this.$t('home.czjl')
        });
        this.getData()
	},
    onPullDownRefresh() {
			this.page = 1;
			this.getData();
			setTimeout(() => {
				uni.stopPullDownRefresh();
			}, 1000);
		},
		onReachBottom() {
			if (this.last) return this.$utils.showLayer(this.$t('team.noRecords'));
			this.page++;
			this.getData()
		},
    methods:{
        getData(){
            var that = this;
				that.$utils.initDataToken({ url: 'quickCharge/quick_ist',data:{
                    page: that.page,
					limit: that.limit
                } }, res => {
                    if(that.page == 1){
                        that.list = res.data
                    }else{
                        this.list.push(...res.data)
                    }
					console.log(res)
                    that.last = res.total == that.list.length; //已加载完 禁止触底
				});
        }
    }
}
</script>

<style>

</style>