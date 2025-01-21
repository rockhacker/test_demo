<template>
	<view :class="theme">
		<view class="text-black dark:text-white w-full overflow-hidden">
			
			<view v-if="tableData.length">
				<view class="flex justify-between text-center h-80 items-center text-2xl bg-gray-700 text-white">
					<view class="flex-1">{{ $t('staking.lixi') }}</view>
					<view class="flex-1">{{ $t('staking.time') }}</view>
				</view>
				<view v-if="tableData.length > 0">
					<view v-for="(item, index) in tableData" :key="index" class="flex justify-between items-center text-center h-80 border-0 border-b-2 border-solid border-gray-700 bg-white dark:bg-floor">
						<view class="flex-1">{{ item.interest }}</view>
						<view class="flex-1">{{ item.created_at }}</view>
					</view>
				</view>
				<view class="text-center p-200" v-if="tableData.length == 0">
					<image src="../../static/image/anonymous.png" mode="aspectFit" class="w-160 h-160"></image>
					<view class="text-center">{{ $t('home.norecord') }}</view>
				</view>
			</view>
			<view class="text-center p-200" v-else >
				<image src="../../static/image/anonymous.png" mode="aspectFit" class="w-160 h-160"></image>
				<view class="text-center">{{ $t('home.norecord') }}</view>
			</view>
				
		</view>
	</view>
</template>
<script>
	import {mapState} from 'vuex'
	export default {
		data() {
			return {
				  tableData: []
			};
		},
		computed:{
		   ...mapState(['theme']),
		},
		onLoad(options) {
			uni.setNavigationBarTitle({
				title:this.$t("staking.shouyiliebiao")
			})
			this.getInsList(options.id);
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
		},
		methods:{
			// 查看收益列表
			getInsList(id) {
				try {
					const that=this;
					that.$utils.initDataToken({url: "matter/insList" , data:{sub_id:id} },(res,msg) => {
						if(res.data && res.data.length){
							this.$set(this,'tableData',res.data)
						}
					});
				} catch (e) {
					console.log(e);
					//TODO handle the exception
				}	
			},
		}
	}
</script>
<style lang="scss" scope>
	.el-breadcrumb__inner a:hover, .el-breadcrumb__inner.is-link:hover{
		color: #fcd435e5;
	}
</style>