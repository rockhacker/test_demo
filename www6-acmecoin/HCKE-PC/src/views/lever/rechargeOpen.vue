<template>
    <div class="">
	<div class="rechargeOpen ">
         <div class="open-header bg-box2">
            <vue-qr
                :text="downUrl"
                :margin="0"
                colorDark="#000000"
                colorLight="#fff"
                :size="140"
            ></vue-qr>
              <!-- <button class="btn" @click="save(qr)">{{$t('feed.qr')}}</button> -->
              <p class="textaddress">{{$t('feed.address')}}</p>
              <p class="address">{{obj.address}}</p>
              <button class="qr-btn bg-main-liner white" @click="setCopy">{{$t('feed.copyadd')}}</button>
         </div>
         <div class="open-form">
				<p class="text">{{$t('feed.depositsAddress')}}</p>
				<input class="uni-input" v-model="depositsAddress" :placeholder="$t('feed.depositsAddressUp')"/>
				<p class="text">{{$t('feed.deposits')}}</p>
				<input class="uni-input" type="number" v-model="deposits" :placeholder="$t('feed.depositsUp')"/>
               <!-- <text class="text">chain address</text>
               <view class="items">
                   <view class="item" @click="setActive('ERC20')" :class="active=='ERC20'?'active':''">ERC20</view>
                   <view class="item" @click="setActive('TRC20')" :class="active=='TRC20'?'active':''">TRC20</view>
                   <view class="item" @click="setActive('OMNI')" :class="active=='OMNI'?'active':''">OMNI</view>
               </view> -->
				<p class="text">{{$t('feed.upload')}}</p>
				<div class="w48 ptb5 plr5 bd_dashed radius4  mb10 flex-a ct">
                <input type="file" class=" input lh20 opacity0  lf0 btm0  pointer" accept="image/*" name="file" @change="uploadImg"/>
					<img src="../../assets/images/addImg.png" alt="" class="poImg" v-if="!img1">
					<img :src="img1" alt="" class="poImg" v-else>
                    <div class="" v-if="!hasUp1">
                        <image :src="img" class="wt80 h80" ></image>
                    </div>
                    <!-- <img :src="img1" alt class="wt80 h80" /> -->
				</div>
               <text class="upload-text">{{$t('feed.pictures')}}</text>
         </div>
        <div class="footer">
            <button class="sub-btn bg-main-liner white" @click="submit">{{$t('feed.submit_transaction_screenshot')}}</button>
        </div>
         
	</div>
</div>
</template>

<script>
    import vueQr from "vue-qr";
	export default{
        components:{
            vueQr
        },
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
                img1:'',
                hasUp1:false,
                img:'../../assets/images/addImg.png',
                downUrl:''
			}
		},
     
		created() {
             this.obj=JSON.parse(this.$route.query.obj)
             this.downUrl=this.obj.address
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
				    this.$message({
				        type:'warning',
				        message:this.$t('feed.depositsAddressUp')
				    });
				  }else if(!this.deposits){
                    this.$message({
                        type:'warning',
                        message:this.$t('feed.depositsUp')
                    });
                  }else if(!this.img1){
                    this.$message({
                        type:'warning',
                        message:this.$t('feed.seupload')
                    });
                  }else{
                        let data={
                        number:this.deposits,
                        proofImg:this.img1,
                        address:this.depositsAddress,
                        // address:this.obj.address,
                        charge_id:this.obj.id
                    }
                    this.$http
                    .initDataToken({ url: 'quickCharge/submit', data: data}).then(res=>{
                        if(res){
                            this.deposits=''
                            this.img1=''
                            this.depositsAddress=''
							this.hasUp1=false;
                        }

                    })
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
			   this.$message(that.$t('assets.copy_err'));
			 }
			 
			 let textarea = document.createElement("textarea")
			 textarea.value = that.obj.address
			 textarea.readOnly = "readOnly"
			 document.body.appendChild(textarea)
			 textarea.select() // 选择对象
			 textarea.setSelectionRange(0, that.obj.address.length) //核心
			 let result = document.execCommand("copy") // 执行浏览器复制命令
			 textarea.remove()
             this.$message({
                 type:'success',
                 message:this.$t('assets.copy_success')
             });
           },
           uploadImg(options){
               console.log(event.target.files)
				var that=this;
				this.ossFileUpload(event.target.files[0],res=>{
					   
						that.img1=res.url;
						that.hsup1=true;
												
				})
				// uni.chooseImage({
				// 	count: 1,
				// 	sizeType: ['compressed'],
				// 	success: (chooseImageRes) => {
                //         this.ossFileUpload(chooseImageRes.tempFiles[0],res=>{
				// 										var img='img'+i;
                //                             			var hsup='hasUp'+i;
                                            			
                //                             			that[img]=res.url;
                //                             			that[hsup]=true;
											
				// 			  })
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
				// 	}
				// });
           },
         
            
            
        }
	}
</script>

<style lang="scss" scoped>
    .marbg{
        border-radius: 10px;
    }
  .rechargeOpen{
      width: 1000px;
      margin:0 auto;
      min-height:100vh;
      padding-top:20px;
      .open-header{
          text-align:center;
          padding:40px 0;
            .b-logo{
                margin:30px 0px;
                width:260px;
                height:260px;
                padding: 30px;
                border: solid 1px #e5e5e5;
                border-radius: 5px;
            }
            .btn{
                padding:0 40px;
                width:max-content;
                height:88px;
                border-radius: 20px;
                border: solid 2px #588bf8;
                background:#FCD535;
                font-size: 32px;
                color:#fff;
                margin:0 auto;
            }
            .max{
                font-size:50px;
                margin-top:60px;
                color:#000;
            }
            .uni-input{
                background:#f7f6fb;
                margin:40px 0 30px;
                 color:#666;
            }
            .qr-btn{
                padding:0 40px;
                width:max-content;
                height:44px;
                border-radius: 20px;
                // border: solid 2px #588bf8;
                margin:0 auto;
                font-size: 16px;
                color:#212833;
                cursor: pointer;
                background: #E5A013;
            }
      }
      .open-form{
          /* padding:30px 0 0 0; */
          .uni-input{
              background:#f7f6fb;
              border-radius:8px;
              height:60px;
              width: 200px;
             
              color:#000;
              width: 100%;
              padding-left:20px;

          }
          .text{
              display:block;
              margin:20px 0 20px;
              font-size:14px;
          }
          .items{
              display:flex;
              justify-content:space-between;
              .item{
                  width:200px;
                  height:80px;
                  line-height:80px;
                  text-align:center;
                  background:#f8f8fb;
                  border-radius:5px;
                  color:#8d9fae;
                  font-size:28px;
                  &.active{
                      border:1px solid #588bf8;
                      color:#588bf8;
                  }
              }
          }
      }
      .upload-text{
          color:#000;
          font-size:28px;
      }
      .sub-btn{
          width:400px;
          border-radius:20px;
          height:40px;
          line-height:40px;
          padding:0;
          margin:0 auto;
          background:#E5A013;
          color:#212833;
          margin-top:50px;
          cursor: pointer;
      }
  }
  .textaddress{
      color:#999;
      margin-top:20px;
  }
  .address{
      margin:20px 0 40px;
      font-size: 24px;
  }
  .input{
      width: 140px;
      height: 140px;
      z-index: 10;
      position: relative;
  }
  .flex-a{
      width: 140px;
      height: 140px;
      position: relative;
      margin:0 auto;
  }
  .poImg{
     position: absolute;
     width: 140px;
      height: 140px;
      top:0;
      left:0;
  }
  .footer{
      text-align: center;
  }
</style>
