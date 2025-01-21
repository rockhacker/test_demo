<template>
	<view :class="theme">
		<view class="text-black dark:text-white bg-white  dark:bg-my-black w-full min-h-screen flex flex-col">
			
			<view class="flex p-30">
				<image class="w-140 h-140" :src="`${staking.icon}`">
				<view class="flex-1 ml-40">
					<view class="mb-40 text-2xl">{{staking.title}}</view>
					<view class="flex items-end">
						<view class="text-3xl mr-20 font-bold">{{staking.code}}</view>
						<view class="text-sm rounded-2xl px-10 py-6 bg-primary text-white" style="color: #e6a23c;">{{$t('staking.meiqipaixi')}} {{staking.dividend_percentage}}%</view>
					</view>
				</view>
			</view>
			<view class="mt-10 flex-1">
					
				<view class="text-xl flex rounded-10">
					<view class="w-full flex justify-center p-40">
						<view class="w-full flex flex-col p-40 rounded-10 bg-gray-100 dark:bg-box">
							<view class="flex item-center justify-between mb-60">
								<view class="text-gray-400 text-xl">{{$t('staking.qigoujine')}}</view>
								<view class="text-black dark:text-white text-xl">{{staking.staring_sub_amount}}</view>
							</view>
							<view class="flex alcenter between mb30">
								<view class="text-gray-400 text-xl">{{$t('staking.suocangtianshu')}}</view>
								<view class="text-black dark:text-white text-xl">{{staking.lock_dividend_days}}</view>
							</view>
							<view class="flex alcenter between mb30">
								<view class="text-gray-400 text-xl">{{$t('staking.zuigaoshengou')}}</view>
								<view class="text-black dark:text-white text-xl">{{staking.max_sub_amount}}</view>
							</view>
				<!-- 			<view class="flex alcenter between mb30">
								<view class="text-gray-400 text-xl">{{$t('staking.shuhui')}}</view>
								<view class="text-black text-xl">{{staking.liquidated_damages}}%</view>
							</view> -->
							
							<view class="flex items-center border-0 border-b-2 border-solid border-gray-300">
								<input type="text" v-model="amount" class="h-100 flex-1 text-black dark:text-white" :placeholder="$t('staking.suocangshuliang')" />
							</view>
							
							<view class="mt-20 rounded-3xl p-20 bg-primary text-white text-sm text-center  my-40" hover-class="opacity-50" @tap="buyProduct">{{ $t("staking.shengou") }}</view>
							<view class="text-xl mb20 text-black dark:text-white">{{$t('staking.chanpinjieshao')}}</view>
							<view class="flex1 text-black dark:text-white">{{staking.desc}}</view>
						</view>
					</view>
				
				</view>
			</view>
			
		</view>
		
	</view>
</template>
<script>
import {mapState} from 'vuex'
export default {
	data() {
		return {
			id:null,
			staking:{},
			amount:''
		};
	},
	computed:{
	   ...mapState(['theme']),
	},
	onLoad(options) {
		uni.setNavigationBarTitle({
			title:this.$t("staking.shengou")
		})
		this.id = options.id;
		this.getProductDetails();
	},
	onShow() {
		this.$utils.setThemeTop(this.theme);
	},
	methods: {
       // 产品详情
       getProductDetails(id) {
			try {
				const that=this;
				that.$utils.initDataToken({ 
					url: "fund/info",
					data:{id: this.id},
				}, res => {
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
				})
			} catch (e) {
				console.log(e);
				//TODO handle the exception
			}	
       },
       // 申购
       buyProduct(id) {
		   
			try {
				
				const that=this;
				
				if (!that.amount) {
				  that.$utils.showLayer(that.$t('staking.qsrscsl'));
				  return false;
				}
				
				that.$utils.initDataToken({url: "fund/buy",data:{id: that.id,amount:that.amount}},res => {
					that.$router.push({path:'/pages/staking/orders'})
				});
			} catch (e) {
				console.log(e);
				//TODO handle the exception
			}
			
       },
	}
};
</script>