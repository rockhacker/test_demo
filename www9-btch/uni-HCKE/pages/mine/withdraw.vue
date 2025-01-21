<template>
	<view :class="theme">
		<view class="min-h-screen text-black dark:text-white bg-white dark:bg-1C2532">
			<view class="flex items-center justify-between p-30 border-0 border-b-2 border-solid border-gray-100 dark:border-gray-900" v-if="item.currency.open_draw==1" v-for="(item,index) in coinList" :key="index" @click="toUrl(item)">
				 <view class="flex items-center">
					<image :src="item.currency.logo" class="w-60 h-60"></image>
					<view class="ml-20 text-lg">{{item.currency.code}} {{$t('assets.mention')}}</view>
				 </view>
				<image src="../../static/image/arrrowr.png" alt="" class="w-32 h-32"></image>
			</view>
	  </view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				coinList:[]
			}
		},
		computed:{
			...mapState(['theme']),
		},
		onLoad() {
			uni.setNavigationBarTitle({
                title: this.$t('new.zhuan')
            });
		},
		onShow() {
			this.$utils.setThemeTop(this.theme)
            //this.getCoinList()
		   this.getList()
		},
		methods:{
			getList(){
				var that = this;
				that.$utils.initDataToken({ url: 'account/list' }, res => {
				     that.coinList = res[0].accounts;
				    // console.log( that.coinList)
					console.log(res[0].accounts)
				});
			},
			getCoinList() {
                var that = this;
                that.$utils.initDataToken({ url: 'block_chain/currency_protocols' }, res => {
                   // that.coinList = res;
                    console.log( res)
                });
            },
			toUrl(item){
                this.getDetail(item)
            },
            getDetail(item) {
                var that = this;
                //account_type_id: 1  1为币币账户
				console.log(item,"1111")
                that.$utils.initDataToken({ url: 'account/detail', data: { account_type_id: 1, id: item.id } }, res => {
                    uni.stopPullDownRefresh();
                    let url='/pages/assets/mention?currency=' + (item.currency.currency_protocols[0] ? item.currency.currency_protocols[0].currency_id: item.currency_id) + '&name=' + item.code + '&id=' + item.id +'&account_type_id='+res.account_type_id + '&currency_id=' + item.currency_id
                    uni.navigateTo({url: url })
                });
		},
		}
	}
</script>