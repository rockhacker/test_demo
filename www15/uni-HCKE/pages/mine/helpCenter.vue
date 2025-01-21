<template>
	<view :class="theme">
		<view class="bg-white dark:bg-floor py-20 px-40 text-black dark:text-white">
			<text class="text-lg leading-40 mb-30">{{$t('new.jiec')}}</text>
			<!-- <image src="/static/image/pz.jpg" class="mb-30 w-full"></image> -->
			<!-- <video id="myVideo" style="width: 100%;" :src="videourl" @error="videoErrorCallback" ></video> -->
		</view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return{
				list:[],
				videourl:'https://exchange-hk.oss-cn-hongkong.aliyuncs.com/MetaUniverseGlobalcoin/upload/qly_1640247993000.MP4',
			}
		},
		onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('new.jies')
			})
		},
		mounted(){
			
		},
		methods:{
			toPath(val){
				uni.navigateTo({
				    url: `/pages/mine/helpCentent?val=${val.content}&title=${val.title}`,
				});
			},
		   getList(){
				this.$utils.initDataToken({ url: 'news/list', data: { category_id: 26  } }, res => {
					  this.list=res.data
				});
		   }
		},
		onShow() {
		   this.$utils.setThemeTop(this.theme)
		  // this.getList()
		},
		computed:{
		   ...mapState(['theme']),
		},
	}
</script>