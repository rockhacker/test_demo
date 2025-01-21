<template>
	<view :class="{'light light_white':theme=='light'}" class="bgPart">
		  <!-- <view class="title bdb_blue3">
				<text class="text">{{$t('feed.titel')}}</text>
				<text class="text">{{$t('trade.time')}}</text>
		  </view>
          <view class="items bdb_blue3">
				<view class="item" v-for="(item,index) in list" @click="toPath(item)">
					<text class="text">{{item.title}}</text>
					<text class="text">{{item.updated_at}}</text>
				</view>
		  </view> -->
		 <!-- <div class="content">
                  {{$t('new.jiec')}}
		  </div> -->
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return{
				list:[]
			}
		},
		onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('new.baip')
			})
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

<style>
	.item{
		display: flex;
		justify-content: space-between;
		padding:0 40upx;
		height:80upx;
		line-height: 80upx;
		
	}
	.item .text{
		font-size:32upx;
	}
	.title{
		height: 80upx;
		line-height: 80upx;
		
		display: flex;
		justify-content: space-between;
		padding:0 40upx;
	}
	.title .text{
		font-size: bold;
		font-size: 24upx;
		color:#838B99;
	}
	.content{
		padding:20px 20px 0;
		font-size: 16px;
	}
</style>
