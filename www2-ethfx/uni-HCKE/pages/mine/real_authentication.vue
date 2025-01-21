<template>
  <view class="min-h-screen" :class="theme">
	<view class="min-h-screen bg-white dark:bg-1C2532">
		 <view v-if="authStatus == 0" class="px-40">
      <view class="flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-800">
        <text class="text-lg">{{ $t("authentication.name") }}：</text>
        <input type="text" v-model="name" class="flex-1 h-100 pr-20 text-lg text-right" :placeholder="$t('collect.p_name')"/>
      </view>
      <view class="flex bgwhite items-center mt-20 border-0 border-b-2 border-solid border-gray-200 dark:border-gray-800">
        <text class="text-lg">{{ $t("collect.cardno") }}：</text>
        <input type="text" v-model="card_id" class="flex-1 h-100 pr-20 text-lg text-right" :placeholder="$t('collect.p_cardno')"/>
      </view>
      <view class="mt-30 text-lg">{{$t('collect.up_card')}}</view>
			<view class="mt-20">
				<view class="w-full rounded-8 text-center py-40" @tap="uploadImg(1)">
					<view v-if="!hasUp1">
						<image :src="img" class="w-160 h-160"></image>
						<view class="mt-20 text-center">{{$t('collect.up_cardz')}}</view>
					</view>
					<image :src="img1" class="w-full h-400" mode="widthFix" v-else></image>
				</view>
				<view class="w-full rounded-8 text-center py-40" @tap="uploadImg(2)">
					<view v-if="!hasUp2">
						<image :src="img" class="w-160 h-160" ></image>
						<view class="mt10 text-center">{{$t('collect.up_cardf')}}</view>
					</view>
					<image :src="img2" class="w-full h-400" mode="widthFix" v-else></image>
				</view>
      <!-- <view class="w48 ptb5 plr5 rounded-8 text-center mb10" @tap="uploadImg(3)">
					<view class="" v-if="!hasUp3">
						<image :src="img" class="w-160 h-160" ></image>
						<view class="mt10 text-center">{{$t('collect.up_cardhand')}}</view>
					</view>
					<image :src="img3" class="w95" mode="widthFix" v-else style="max-height: 100px;"></image>
				</view> -->

			</view>
			<view class="mt-100 h-80 flex justify-center items-center text-center bg-main-linear text-white text-lg rounded-10" @tap="confirm">{{ $t("login.e_confrim") }}</view>
    </view>
    <view class="text-2xl text-center pt-200" v-if="authStatus == 1">
      {{ $t("authentication.ing") }}
    </view>
    <view class="text-2xl text-center pt-200" v-if="authStatus == 2">
      {{ $t("authentication.has") }}
    </view>
	</view>
  </view>
</template>

<script>
	import {domain} from '@/common/domain.js'
	import {mapState} from 'vuex'
	export default{
		data(){
			return{
				name:'',
				card_id:'',
				img:'/static/image/addImg.png',
				hasUp1:false,
				hasUp2:false,
				hasUp3:false,
				img1:'',
				img2:'',
				img3:'',
				authStatus: 0,
			}
		},
		onLoad() {
			this.init();
			uni.setNavigationBarTitle({
				title:this.$t('authentication').renzheng
			})
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
			// this.init();
		    this.$utils.setThemeTop(this.theme);
		},
		methods:{
			init(){
				var that = this;
				that.$utils.initDataToken({url:'user_real/center'},(res,msg)=>{
					that.authStatus = res.review_status;
				})
			},
			uploadImg(i){
				var that=this;
				uni.chooseImage({
					count: 1,
					sizeType: ['compressed'],
					success: (chooseImageRes) => {
						this.ossFileUpload(chooseImageRes.tempFiles[0],res=>{
									var img='img'+i;
									var hsup='hasUp'+i;
								
									that[img]=res.url;
									that[hsup]=true;
											
						})
						// const tempFilePaths = chooseImageRes.tempFilePaths;
						// uni.uploadFile({
						// 	url: domain+'/api/common/image_upload', //仅为示例，非真实的接口地址
						// 	// #ifdef APP-PLUS
						// 	url:domain+'/api/common/image_upload',
						// 	// #endif
						// 	filePath: tempFilePaths[0],
						// 	name: 'file',
						// 	formData: {
						// 		'user': 'test'
						// 	},
						// 	success: (uploadFileRes) => {
						// 		console.log(typeof uploadFileRes.data);
						// 		var data=JSON.parse(uploadFileRes.data);
						// 		if(data.code==1){
						// 			var img='img'+i;
						// 			var hsup='hasUp'+i;
						// 			console.log(data)
						// 			that[img]=data.data.url;
						// 			that[hsup]=true;
						// 		}
						// 	}
						// });
					}
				});
			},
			confirm(){
				if(!this.name){
					return this.$utils.showLayer(this.$t('collect.p_name'))
				}
				if(!this.card_id){
					return this.$utils.showLayer(this.$t('collect.p_cardno'))
				}
				if(!this.img1){
					return this.$utils.showLayer(this.$t('collect.up_cardz'))
				}
				if(!this.img2){
					return this.$utils.showLayer(this.$t('collect.up_cardf'))
				}
				// if(!this.img3){
				// 	return this.$utils.showLayer(this.$t('collect.up_cardhand'))
				// }
				this.$utils.initDataToken({url:'user_real/real_name',type:'POST',data:{
					name:this.name,
					card_id:this.card_id,
					front_pic:this.img1,
					reverse_pic:this.img2,
					// hand_pic:this.img3,
				}},(res,msg)=>{
					this.$utils.showLayer(msg);
					setTimeout(()=>{
						uni.navigateBack({
							delta:1
						})
					},1500)
				})
			}
		}
	}
</script>
