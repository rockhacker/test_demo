<template>
	<view class="bg-floor" style="min-height:100%" :class="theme">
		<view class=" py-20 px-40 text-black dark:text-white">
			<text class="text-lg leading-40 mb-30">{{$t('home.gsjs')}}</text>
			<!-- <image src="/static/image/pz.jpg" class="mb-30 w-full"></image> -->
			<iframe class="mt-30" width="100%"  src="https://www.youtube.com/embed/4oB6BnYtxbk" title="Blockchain Explained" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
		</view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return{
				list:[],
				videourl:'https://exchange-hk.oss-cn-hongkong.aliyuncs.com/MetaUniverseGlobalcoin/upload/fzL_1652450368000.mp4',
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