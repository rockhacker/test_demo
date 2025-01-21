<template>
	<view :class="theme">
		<!-- <view class="ptb20 plr10 bdb_blue3 flex alcenter between">
			<text>{{$t('about.concat')}}</text>
			<text>{{email}}</text>
		</view>
		<navigator url="/pages/mine/policy" class="ptb20 plr10 bdb_blue3 flex alcenter between">
			<text>{{$t('about.privat')}}</text> 
			<view>
				<image src="/static/image/mores.png" class="wt20 h20"></image>
			</view>
		</navigator>
		<navigator url="/pages/mine/workOrder" class="ptb20 plr10 bdb_blue3 flex alcenter between">
			<text>{{$t('feed.feed')}}</text> 
			<view>
				<image src="/static/image/mores.png" class="wt20 h20"></image>
			</view>
		</navigator> -->
		<navigator url="/pages/mine/helpCenter" class="bg-white dark:bg-floor p-40 text-lg flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
			<view class="flex items-center">
				<text>{{$t('new.jies')}}</text>
			</view>
			<view class="flex items-center">
				<image src="../../static/image/mores.png" class="w-30 h-30 ml-20"></image>
			</view>
		</navigator>
		<view @click="toPathPDF('gupiao')" class="bg-white dark:bg-floor p-40 text-lg flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
			<view class="flex items-center">
				<text>{{$t('new.gupiao')}}</text>
			</view>
			<view class="flex items-center">
				<image src="../../static/image/mores.png" class="w-30 h-30 ml-20"></image>
			</view>
		</view>
		<view @click="toPathPDF('gupiaodizhang')" class="bg-white dark:bg-floor p-40 text-lg flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
			<view class="flex items-center">
				<text>{{$t('new.gupiaodizhang')}}</text>
			</view>
			<view class="flex items-center">
				<image src="../../static/image/mores.png" class="w-30 h-30 ml-20"></image>
			</view>
		</view>
		<view @click="toPathPDF('huiyijilu')" class="bg-white dark:bg-floor p-40 text-lg flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
			<view class="flex items-center">
				<text>{{$t('new.huiyijilu')}}</text>
			</view>
			<view class="flex items-center">
				<image src="../../static/image/mores.png" class="w-30 h-30 ml-20"></image>
			</view>
		</view>
		<view @click="toPathPDF('zhangcheng')" class="bg-white dark:bg-floor p-40 text-lg flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
			<view class="flex items-center">
				<text>{{$t('new.zhangcheng')}}</text>
			</view>
			<view class="flex items-center">
				<image src="../../static/image/mores.png" class="w-30 h-30 ml-20"></image>
			</view>
		</view>
		<view @click="toPathPDF('zhucezhengshu')" class="bg-white dark:bg-floor p-40 text-lg flex items-center justify-between border-0 border-b-2 border-solid border-gray-200 dark:border-gray-700">
			<view class="flex items-center">
				<text>{{$t('new.zhucezhengshu')}}</text>
			</view>
			<view class="flex items-center">
				<image src="../../static/image/mores.png" class="w-30 h-30 ml-20"></image>
			</view>
		</view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return{
				mobile:'',
				email:''
			}
		},
		onLoad() {
			this.getConnect();
			this.getConnect2();
			uni.setNavigationBarTitle({
				title:this.$t('about').abt
			})
		},
		methods:{
			toPathPDF(urls){
				let path = `/h5/static/${urls}.pdf`
				window.open(path);
			},
			getConnect(){
				var that = this;
				that.$utils.initDataToken({url:'default/setting',type:'GET',data:{key:'contact_mobile'}},(res,msg)=>{
					that.mobile = res;
				})
			},
			getConnect2(){
				var that = this;
				that.$utils.initDataToken({url:'default/setting',type:'GET',data:{key:'contact_email'}},(res,msg)=>{
					that.email = res;
				})
			},
		},
		onShow() {
		   this.$utils.setThemeTop(this.theme)
		},
		computed:{
		   ...mapState(['theme']),
		},
	}
</script>

<style>
</style>
