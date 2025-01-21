<template>
	<view :class="theme" class="rechargeOpen">
         <view class="bg-white dark:bg-floor flex justify-center items-center flex-col p-30">
              <image class="w-300 h-300 p-30"  :src="qr" @click="TanPreviewImage(qr)" mode="" ></image>
              <!-- <button class="btn" @click="save(qr)">{{$t('feed.qr')}}</button> -->
              <view class="text-xl my-40">{{$t('feed.address')}}</view>
              <view class="text-lg mb-40">{{obj.address}}</view>
			  <button class="w-full rounded-10 bg-primary text-black text-xl" @click="setCopy">{{$t('feed.copyadd')}}</button>
			  <view class="open-form w-full">
			       <text class="text">{{$t('feed.depositsAddress')}}</text>
			       <input class="uni-input"  v-model="depositsAddress" :placeholder="$t('feed.depositsAddressUp')"/>
				   <text class="text">{{$t('feed.deposits')}}</text>
				   <input class="uni-input"  v-model="deposits" :placeholder="$t('feed.depositsUp')"/>
			      <!-- <text class="text">chain address</text>
			        <view class="items">
			            <view class="item" @click="setActive('ERC20')" :class="active=='ERC20'?'bg-primary text-black':''">ERC20</view>
			            <view class="item" @click="setActive('TRC20')" :class="active=='TRC20'?'bg-primary text-black':''">TRC20</view>
			            <view class="item" @click="setActive('OMNI')" :class="active=='OMNI'?'bg-primary text-black':''">OMNI</view>
			        </view> -->
					<text class="text text-lg my-40">{{$t('feed.upload')}}</text>
			        <view class="w48 ptb5 plr5 bd_dashed radius4 tc mb10" @tap="uploadImg(1)">
						 <view v-if="!hasUp1">
							 <image :src="img" class="wt80 h80" ></image>
						 </view>
						 <image :src="img1" class="w95" mode="widthFix" v-else style="max-height: 100px;"></image>
					</view>
			        <text class="upload-text">{{$t('feed.pictures')}}</text>
			  </view>
			  <button class="w-full rounded-10 bg-primary text-black text-xl" @click="submit">{{$t('feed.submit_transaction_screenshot')}}</button>
			  
		 </view>
	</view>
</template>

<script>
	import { mapState } from 'vuex';
	import QR from '@/common/qrcode.js';
	export default{
		data(){
			return{
               qr:'',
               deposits:'',
               depositsAddress:'',
               active:'ERC20',
               currency_id:'',
               config:{
                    count:1,                                    // 上传图片张数
                    sizeType: ['original','compressed'],                // original 原图，compressed 压缩图，默认二者都有
                    sourceType: ['album','camera'],                             // album 从相册选图，camera 使用相机，默认二者都有。如需直接开相机或直接选相册，请只使用一个选项
                },
                wallet:"",
                obj:{},
                img:'/static/image/addImg.png',
                hasUp1:false,
                img1:''
			}
		},
		computed: {
			...mapState(['theme'])
		},
		onLoad(e) {
          this.obj=JSON.parse(e.b)
          console.log(this.obj)
			//sthis.currency_id=e.b
            this.getWallet()
            uni.setNavigationBarTitle({
				title:this.$t('feed.sub')
			})
		},
        methods:{
            save(url){
            //   let _this = this;
            //   this.$utils.showLayer("保存中...");
            //     uni.saveImageToPhotosAlbum({
            //         filePath: url,
            //         success: () => {
            //             uni.hideLoading();
            //             this.$utils.showLayer("图片已保存");
            //         },
            //         fail: () => {
            //             uni.hideLoading();
            //             this.$utils.showLayer("保存失败");
            //         },
            //         complete: () => {
                    
            //         }
            //     });
          },
           submit(){
                  if(!this.depositsAddress){
					this.$utils.showLayer(this.$t('feed.depositsAddressUp'))
				  }else if(!this.deposits){
                    this.$utils.showLayer(this.$t('feed.depositsUp'))
                  }else if(!this.img1){
                    this.$utils.showLayer(this.$t('feed.seupload'))
                  }else{
                        let data={
                        number:this.deposits,
                        proofImg:this.img1,
                        address:this.depositsAddress,
                        // address:this.obj.address,	系统提供的充值地址
                        charge_id:this.obj.id,
                    }
                    this.$utils.initDataToken({ url: 'quickCharge/submit', data: data}, (res, msg) => {
                            if(res){
                                this.$utils.showLayer(msg)
                                this.deposits='';
                                this.img1='';
								this.depositsAddress='';
                                this.hasUp1=false;
                            }
					});
                  }
                 
           },
           setActive(val){
               this.active=val
           },
           upImgZ(data){
                console.log(data)
           },
           getWallet(){
                this.qr = QR.createQrCodeImg(this.obj.address);
           },
           setCopy(){
            var that = this;
			 if (!document.queryCommandSupported('copy')) {
			   // 不支持
			   that.$utils.showLayer(that.$t('assets.copy_err'));
			 }
			 
			 let textarea = document.createElement("textarea")
			 textarea.value = that.obj.address
			 textarea.readOnly = "readOnly"
			 document.body.appendChild(textarea)
			 textarea.select() // 选择对象
			 textarea.setSelectionRange(0, that.obj.address.length) //核心
			 let result = document.execCommand("copy") // 执行浏览器复制命令
			 textarea.remove()
			 that.$utils.showLayer(this.$t('assets.copy_success'));
           },
           uploadImg(i){
				var that=this;
				uni.chooseImage({
					count: 1,
					sizeType: ['compressed'],
					success: (chooseImageRes) => {
						console.log(123213,chooseImageRes);
							this.ossFileUpload(chooseImageRes.tempFiles[0],res=>{
									var img='img'+i;
									var hsup='hasUp'+i;
									console.log(res);
									that[img]=res.url;
									that[hsup]=true;
							  })
						// console.log(chooseImageRes.tempFiles[0])
						// 		this.ossFileUpload(chooseImageRes.tempFiles[0],res=>{
						// 					this.img1=res.url
                        //                     this.hasUp1=true
											
						// 	  })
						//const tempFilePaths = chooseImageRes.tempFilePaths;
						// uni.uploadFile({
						// 	url: this.host+'/api/common/image_upload', //仅为示例，非真实的接口地址
						// 	// #ifdef APP-PLUS
						// 	url:this.host+'/api/common/image_upload',
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
            TanPreviewImage(imageUrl){ 
                var images = [];
                images.push(imageUrl);
                uni.previewImage({ // 预览图片  图片路径必须是一个数组 => ["http://192.168.100.251:8970/6_1597822634094.png"]
                    current:0,
                    urls:images,
                    longPressActions: {  //长按保存图片到相册
                        itemList: ['保存图片'],
                        success: (data)=> {
                            uni.saveImageToPhotosAlbum({ //保存图片到相册
                                filePath: payUrl,
                                success: function () {
                                    uni.showToast({icon:'success',title:'保存成功'})
                                },
                                fail: (err) => {
                                    uni.showToast({icon:'none',title:'保存失败，请重新尝试'})
                                }
                            });
                        },
                        fail: (err)=> {
                            console.log(err.errMsg);
                        }
                }
                });
            },
            
        }
	}
</script>

<style lang="scss" scoped>
  .rechargeOpen{
      min-height:100vh;
      .open-header{
          text-align:center;
          background:#f7f6fb;
          padding-bottom:80upx;
            .b-logo{
                margin:30upx 0px;
                width:260upx;
                height:260upx;
                padding: 30upx;
                border: solid 1px #e5e5e5;
                border-radius: 5px;
            }
            .btn{
                padding:0 40upx;
                width:max-content;
                height:88upx;
                border-radius: 20px;
                border: solid 2px #588bf8;
                background:#588bf8;
                font-size: 32upx;
                color:#fff;
                margin:0 auto;
            }
            .max{
                font-size:50upx;
                margin-top:60upx;
                color:#000;
            }
            .uni-input{
                background:#f7f6fb;
                margin:40upx 0 30upx;
                 color:#666;
            }
            .qr-btn{
                padding:0 40upx;
                width:max-content;
                height:88upx;
                border-radius: 20px;
                border: solid 2px #588bf8;
                margin:0 auto;
                font-size: 32upx;
                color:#588bf8;
            }
      }
      .open-form{
          padding:40upx;
          .uni-input{
              background:#f7f6fb;
              border-radius:16upx;
              height:80upx;
              margin-top:10upx;
              color:#000;
          }
          .text{
              display:block;
              margin:20upx 0;
              font-size:28upx;
          }
          .items{
              display:flex;
              justify-content:space-between;
              .item{
                  width:200upx;
                  height:80upx;
                  line-height:80upx;
                  text-align:center;
                  background:#f8f8fb;
                  border-radius:5px;
                  color:#8d9fae;
                  font-size:28upx;
                  &.active{
                      border:1px solid #588bf8;
                      color:#588bf8;
                  }
              }
          }
      }
      .upload-text{
          font-size:28upx;
      }
      .sub-btn{
          width:90%;
          border-radius:40upx;
          height:80upx;
          line-height:80upx;
          padding:0;
          margin:0 auto;
          background:#588bf7;
          color:#fff;
          margin-top:50upx;
      }
  }
  .textaddress{
      color:#999;
      margin-top:10upx;
  }
  .address{
      color:#0f3a4c;
      margin:20upx 0 40upx;
  }
</style>