<template>
	<view :class="theme">
		<view class="bg-my-grey dark:bg-my-black text-white" style="min-height: calc(100vh - 50px - var(--status-bar-height));">
			<view class="p-30 pb-100 box-border">
				<view class="flex flex-col border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700 py-10" v-for="(item,i) in logList" :key="i" v-if="logList.length>0">
					<view class="w-full py-10">{{item.title}}</view>
					<view class="w-full py-10 text-danger text-lg" v-if="item.reply==null">{{$t('feed.noreply')}}</view>	
					<view class="w-full py-10 " v-else>{{$t('feed.reply')}}: {{item.reply}}</view>	
					<view class="w-full py-10 text-right">{{item.created_at}}</view>
				</view>
				<view class="flex-col flex justify-center items-center p-100" v-if="logList.length==0">
					<image src="../../static/image/anonymous.png" class="w-120 h-120"></image>
					<view class="mt-20 text-lg">{{$t('home.norecord')}}</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
    import {mapState} from 'vuex'
	import uniPopup from '@/components/uni-popup.vue';
	export default{
		components: {
			uniPopup
		},
		data(){
			return {
				page:1,
				logList:[],
			}
		},
		onLoad() {
			this.$utils.setThemeTop(this.theme)
			uni.setNavigationBarTitle({
				title:this.$t('assets').record
			})
			this.getLog();
		},
		computed:{
		   ...mapState(['theme']),//获取当前UI颜色
		},
		methods:{
			getLog(){
				this.$utils.initDataToken({url:'feedback/list',type:'get', data:{page:this.page}},res=>{
					uni.stopPullDownRefresh()
					this.logList=this.logList.concat(res.data);
				})
			},
		},
		onPullDownRefresh() {
			this.page=1;
			this.logList=[];
			this.getLog();
		},
		onReachBottom() {
			this.page++;
			this.getLog();
		},
	}
</script>