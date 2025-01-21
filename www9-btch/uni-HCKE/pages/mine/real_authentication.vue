<template>
  <view class="min-h-screen " :class="theme">
	
	<view class="min-h-screen pb20 pt20 bg-white dark:bg-1C2532">
		<steps v-if="isReg==1" :status="1" class="bg-white dark:bg-1C2532 pl20 pr20 pb50"></steps>
		 <view class="px-40 py-20 ft14" v-if="authStatus == 1">{{ $t('authentication.bhly')}}:{{remark}}</view>
		  <view  class="px-40">
			 <!--<view class="flex h-100  alcenter between mr10 border-0 border-b-2 border-solid border-gray-200">
			 	<picker :disabled="authStatus ==0 || authStatus == 2" :value="index" :range="array" class=" flex1"  @change="bindPickerChange" range-key="code">
			 		
			 		<view class="ft14" v-if="array[index]">{{array[index].code}}</view>
					<view class="ft14" v-else>{{$t('add.p_guoj')}}</view>
			 	</picker>
			 	<image src="/static/image/trade_arrow_down.png" class="wt10 h8 ml5"></image>
			 </view> -->
      <view class="flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-800">
        <text class="text-lg" >{{ $t("add.guoj") }}：</text>
        <input type="text" @click="showpopup" :disabled="authStatus ==0 || authStatus == 2" readonly v-model="item.trans_name" class="flex-1 h-100 pr-20 text-lg text-right" :placeholder="$t('add.p_guoj')"/>
      </view>
      <view class="flex items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-800">
        <text class="text-lg">{{ $t("authentication.name") }}：</text>
        <input type="text" :disabled="authStatus ==0 || authStatus == 2" v-model="name" class="flex-1 h-100 pr-20 text-lg text-right" :placeholder="$t('collect.p_name')"/>
      </view>
      <view class="flex bgwhite items-center border-0 border-b-2 border-solid border-gray-200 dark:border-gray-800">
        <text class="text-lg">{{ $t("collect.cardno") }}：</text>
        <input type="text" :disabled="authStatus ==0 || authStatus == 2" v-model="card_id" class="flex-1 h-100 pr-20 text-lg text-right" :placeholder="$t('collect.p_cardno')"/>
      </view>
      <view class="mt-30 text-lg">{{$t('collect.up_card')}}</view>
			<view class="mt-20 flex">
				<view class="w-full rounded-8 py-40 flex1 text-center" @tap="uploadImg(1)">
					<view v-if="!hasUp1">
						<image :src="img" class="w-200 h-200"></image>
					</view>
					<image :src="img1" class="w-200 h-200" mode="widthFix" v-else></image>
					<view class="mt-20 text-center">{{$t('collect.up_cardz')}}</view>
				</view>
				<view class="w-full rounded-8  py-40 flex1 text-center" @tap="uploadImg(2)">
					<view v-if="!hasUp2">
						<image :src="img" class="w-200 h-200" ></image>
					</view>
					<image :src="img2" class="w-200 h-200" mode="widthFix" v-else></image>
					<view class="mt10 text-center">{{$t('collect.up_cardf')}}</view>
				</view>
                <view class="w-full rounded-8  py-40 flex1 text-center" @tap="uploadImg(3)">
					<view class="" v-if="!hasUp3">
						<image :src="img" class="w-200 h-200" ></image>
						
					</view>
					<image :src="img3" class="w-200 h-200" mode="widthFix" v-else></image>
					<view class="mt10 text-center">{{$t('collect.up_cardhand')}}</view>
				</view>

			</view>
			<view>
				<view class="mb10">{{$t('authentication.sl')}}</view>
				<img class="w-full" src="../../static/image/sl.png" alt="">
			</view>
			<view v-if="authStatus != 0 && authStatus != 2" class="mt-100 h-80 flex justify-center items-center text-center bg-main-linear text-white text-lg rounded-10" @tap="confirm">{{ $t("login.e_confrim") }}</view>
			<view v-if="isReg == 1" class="mt-20 h-80 flex justify-center items-center text-center bg-main-linear text-white text-lg rounded-10" @tap="toPath">{{ $t("add.tiaog") }}</view>
    </view>
    <!-- <view class="text-2xl text-center pt-200" v-if="authStatus == 0">
      {{ $t("authentication.ing") }}
    </view>
    <view class="text-2xl text-center pt-200" v-if="authStatus == 2">
      {{ $t("authentication.has") }}
    </view> -->
	<uni-popup ref="popup" background-color="#fff" @change="change">
			<view class="uni-padding-wrap">
				  <view class="ft14 text-black" @click="cancel">{{$t('trade.cancel')}}</view>
				  <view>
					 <input @input="oninput" type="text" v-model="search" class="tc h40 lh40  flex1 search text-black"  :placeholder="$t('add.gjss')">
				  </view>
				  <view class="ft14 text-black" @click="sub">{{$t('login.e_confrim')}}</view>
			</view>
			<picker-view :indicator-style="indicatorStyle" :value="value" @change="bindChange" class="picker-view">
				<picker-view-column>
					<view class="item text-black" v-for="(item,index) in searchArray" :key="index">{{item.trans_name}}({{item.global_code}})</view>
				</picker-view-column>
			</picker-view>
		</uni-popup>
	</view>
  </view>
</template>

<script>
	import steps from '@/components/step.vue';
	import {mapState} from 'vuex'
	export default{
		components: {
		   steps
	    },
		data(){
			return{
				indicatorStyle: `height: 50px;`,
				value:[0],
				search:'',
				codeIndex:0,
				item:{
					trans_name:''
				},
				searchArray:[],
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
				array: [],
				index: '',
				area_code:'',
				nationality:'',
				isReg:0,
				remark:''
			}
		},
		onLoad(e) {
			this.isReg = e.isReg
			this.init();
			uni.setNavigationBarTitle({
				title:this.$t('authentication').renzheng
			})
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
			this.init();
		    this.$utils.setThemeTop(this.theme);
		},
		methods:{
			cancel(){
				this.search= ''
				this.codeIndex = 0
				this.searchArray = this.array
				this.$refs.popup.close()
			},
			sub(){
				this.item = this.searchArray[this.codeIndex]
				this.area_code= this.item.id;
				this.search= ''
				this.codeIndex = 0
				this.searchArray = this.array
				this.$refs.popup.close()
			},
			oninput(e){
				console.log(e)
			 let val = e.detail.value
			 this.searchArray = this.array.filter((item)=>{
				if(item.global_code.search(val) != -1 || item.trans_name.search(val) != -1){
                    return item
				}
			 })
			},
			bindChange(e){
              this.codeIndex = e.detail.value[0]
			},
			change(){},
			showpopup(){
				console.log(333333)
				if(this.authStatus == 0 || this.authStatus == 2)return;
				this.$refs.popup.open('bottom')
			},
			toPath(){
				uni.navigateTo({url: '/pages/mine/google?isReg=1' })
				//uni.switchTab({url: '/pages/home/home' })
			},
			//获取国家列表
			getCountry(){
				this.$utils.initData({url:'default/area_list'},(res,msg)=>{
					console.log(res)
					this.array = res;
					this.searchArray = res
					this.area_code = res[0].id;
					this.item = res[0]
					console.log(this.item)
					// if(this.card_id){
					// 	this.array.forEach((item,index) => {
					// 		  if(item.id == this.area_code){
					// 			this.index = index
					// 		  }
					// 	});
					// }
					//this.area_code = res[0].id;
				})
			},
			bindPickerChange(e){
				console.log(e)
				this.index=e.target.value;
				let item=this.array[this.index];
				this.area_code=item.global_code;
				this.nationality=item.code;
				this.area_code=item.id;
			},
			init(){
				var that = this;
				that.$utils.initDataToken({url:'user_real/center'},(res,msg)=>{
					that.authStatus = res.review_status;
					if(that.authStatus != -1){
						that.hasUp1 = true
						that.hasUp2 = true
						that.hasUp3 = true
						that.remark = res.remark;
						that.name = res.name
						that.card_id=res.card_id
						that.img1 = res.front_pic
						that.img2 = res.reverse_pic
						that.area_code = res.area_id
						that.img3 = res.hand_pic
					}
			        let status;
					if(that.authStatus == 0){
						status = `${this.$t('authentication.ing')}`
					}else if(that.authStatus == 1){
						status = `${this.$t('authentication.ff')}`
					}else if(that.authStatus == 2){
						status = `${this.$t('authentication.has')}`
					}
					uni.setNavigationBarTitle({
						// title:`${this.$t('authentication').renzheng}${status? status :''}`
						title:`${status? status :this.$t('authentication').renzheng}`
					})
					this.getCountry()
				})
			},
			uploadImg(i){
				var that=this;
				if(that.authStatus == 0 || that.authStatus == 2)return;
				uni.chooseImage({
					count: 1,
					sizeType: ['compressed'],
					success: (chooseImageRes) => {
						// this.ossFileUpload(chooseImageRes.tempFiles[0],res=>{
						// 			var img='img'+i;
						// 			var hsup='hasUp'+i;
								
						// 			that[img]=res.url;
						// 			that[hsup]=true;
											
						// })
						const tempFilePaths = chooseImageRes.tempFilePaths;
						uni.uploadFile({
							url: this.$utils._DOMAIN+'/api/common/image_upload', //仅为示例，非真实的接口地址
							// #ifdef APP-PLUS
							url:this.$utils._DOMAIN+'/api/common/image_upload',
							// #endif
							filePath: tempFilePaths[0],
							name: 'file',
							formData: {
								'user': 'test'
							},
							success: (uploadFileRes) => {
								console.log(typeof uploadFileRes.data);
								var data=JSON.parse(uploadFileRes.data);
								if(data.code==1){
									var img='img'+i;
									var hsup='hasUp'+i;
									console.log(data)
									that[img]=data.data.url;
									that[hsup]=true;
								}
							}
						});
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
					area_id: this.item.id,
				    hand_pic:this.img3,
				}},(res,msg)=>{
					this.$utils.showLayer(msg);
					setTimeout(()=>{
						if(this.isReg == 1){
						  uni.navigateTo({url: '/pages/mine/google?isReg=1' })
						}else{
						  uni.navigateBack();
						}
						
					},1500)
				})
			}
		}
	}
</script>
<style>
	.light{
		min-height: initial;
	}
	.picker-view {
		width: 750rpx;
		height: 600rpx;
		margin-top: 20rpx;
	}
	.item {
		line-height: 100rpx;
		text-align: center;
	}
	.uni-padding-wrap{
		display: flex;
		justify-content: space-between;
		padding-top:30rpx;
		align-items: center;
	}
	.search{
        background: #F5F5F5 !important;
		padding:20rpx;
		height: 60rpx;
	}
</style>
