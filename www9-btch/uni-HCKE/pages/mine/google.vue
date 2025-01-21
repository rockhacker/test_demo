<template>
    <view class="min-h-screen " :class="theme">
      <view class="min-h-screen pb20 pt20 bg-white dark:bg-1C2532 px-40" v-if="!verified">
          <steps v-if="isReg==1" :status="2" class="bg-white dark:bg-1C2532  pb50"></steps>
          <view class="tc">
              <view class="p20 qrcode auto">
                 <img class="w-full h-full " :src="qrObj.google_auth_url" alt="">
              </view>
              <view class="flex items-center jscenter pt20 auto">
                 <view class="pr10 ft16">{{ qrObj.google_auth_secret }}</view>
                 <img @click="getComputedStyle" style="width: 26rpx; height: 26rpx;" src="../../static/image/sx.png" alt="">
              </view>
              <view class="pt10 pb20 gray9">{{ $t('add.ts') }}</view>
              <view class="btn auto" @click="copy">{{ $t('add.fz') }}</view>
          </view>
          <view class="flex items-center between mt40">
             <view>{{ $t('add.ggyzm') }}</view>
             <view class="flex items-center ">
                 <view class="pr20 text-success" @click="clear">{{$t('add.qc')}}</view>
                 <view class="text-success" @click="paste">{{ $t('add.zt') }}</view>
             </view>
          </view>
          <view class="flex items-center between mt10" @click="toggle('bottom')">
             <view class="n-item ft18" v-for="item in 6">{{ passwordArr[item-1]}}</view>
          </view>
          <view class="title-text mt30 px-30 py-40">
              <view>{{ $t('add.zysx') }}</view>
              <view class="mt10">1.{{$t('add.one')}}</view>
              <view class="mt10">2.{{ $t('add.two') }}</view>
          </view>
          <view  class="mt-100 h-80 flex justify-center items-center text-center bg-main-linear text-white text-lg rounded-10" @click="confirm">{{ $t("login.e_confrim") }}</view>
          <view v-if="isReg == 1" class="mt-20 h-80 flex justify-center items-center text-center bg-main-linear text-white text-lg rounded-10" @tap="toPath">{{ $t("add.tiaog") }}</view>
      </view>
      <view class="min-h-screen pb20 pt20 bg-white dark:bg-1C2532 px-40" v-else>
        <view class="flex items-center jscenter">
           <image src="../../static/image/google2.png" style="width: 200rpx;height: 200rpx;"  mode="widthFix"></image>
        </view>
        <view class="tc mt20 ft14 color1">{{$t('add.ggtt')}}</view>
      </view>
      <uni-popup class="popo" ref="popup"  background-color="#fff" mask-background-color="rgba(0,0,0,0)">
        <cc-defineKeyboard ref="CodeKeyboard" passwrdType="pay" @KeyInfo="KeyInfo"></cc-defineKeyboard>
			</uni-popup>
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
                passwordArr:[],
                qrObj:{},
                isReg:'',
                verified:false
              }
          },
          onLoad(e) {
            if(e.verified){
              this.verified =  JSON.parse(e.verified)
            }
             
              this.isReg = e.isReg
              if(this.isReg == 1){
                uni.setNavigationBarTitle({
                  title:this.$t('add').aqbd
                })
              }else{
                uni.setNavigationBarTitle({
                  title:this.$t('add').ggyzq
                })
              }
            
              this.getComputedStyle()
             
          },
          computed:{
             ...mapState(['theme']),
          },
          onShow() {
              this.$utils.setThemeTop(this.theme);
              
          },
          methods:{
            toPath(){
              uni.navigateTo({url: '/pages/mine/finish' })
             // uni.switchTab({url: '/pages/home/home' })
            },
            confirm(){
              if(this.passwordArr.length<6){
                this.$utils.showLayer(this.$t('add.plats'))
                return;
              }
              this.$utils.initDataToken({url:'user/bind_verify_method',type:'POST',data:{
                type:'google_secret',
                code:this.passwordArr.join(''),
                account:this.qrObj.google_auth_secret
              }},(res,msg)=>{
                this.$utils.showLayer(msg);
                setTimeout(()=>{
                  if(this.isReg == 1){
                    uni.navigateTo({url: '/pages/mine/finish' })
                  }else{
                    uni.navigateBack();
                  }
                 
                },1500)
              })
            },
            copy(){
              uni.setClipboardData({
                data: this.qrObj.google_auth_secret,
                success: function () {
                  console.log('success');
                }
              });
            },
            paste(){
              if(navigator.clipboard){
                navigator.clipboard.readText()
                  .then(text =>{
                       this.passwordArr = []
                       for(let i=0; i<text.length;i++){
                         if(i<6)
                         this.passwordArr.push(text[i])
                       }
                       console.log(this.passwordArr)
                  })
                  .catch(error => console.log('获取剪贴板内容失败：', error));
              } else {
                 console.log('当前浏览器不支持Clipboard API');
              }
            },
            clear(){
              this.passwordArr = []
            },
            toggle(type) {
         
             this.$refs.popup.open(type)
          },
            getComputedStyle(){
                this.$utils.initDataToken({url:'user/get_google_secret'},(res,msg)=>{
                   this.qrObj =  res
				       })
            },
            onPayUp() {
                this.$refs.CodeKeyboard.show();
            },
            KeyInfo(val) {
              // 关闭
              if (val.keyCode == 190) {
                  this.$refs.popup.close()
                  return
              } 
              //删除
              if (val.keyCode == 8) {
                  if(this.passwordArr.length<1){
                    return
                  }
                  this.passwordArr.splice(this.passwordArr.length-1, 1)
                  return
              } 
              //计数
              if( this.passwordArr.length >=6){
                this.$refs.popup.close()
                console.log(this.passwordArr)
                return
              }
              this.passwordArr.push(val.key);
              if( this.passwordArr.length >=6){
                this.$refs.popup.close()
                console.log(this.passwordArr)
                return
              }
  
            }

          }
      }
  </script>
  <style lang="scss" scoped>
  .qrcode{
    width: 340rpx;
    height: 340rpx;
    padding: 50rpx;
    border: 1px solid #e5e7ed;
  }
  .auto{
    margin:0 auto;
  }
  .btn{
    border: 2px solid #e5e7ed;
    box-sizing: content-box;
    width: 260rpx;
    height: 80rpx;  
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .n-item{
    width: 94rpx;
    height: 94rpx;
    background: #f5f5f5;
    text-align: center;
    line-height: 94rpx;
  }
  .title-text{
    background: #f5f5f5;
  }
  </style>
  