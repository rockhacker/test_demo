<template>
    <div class="authentication" >
      <div class="google radius4 pb20 pt20 bg-white dark:bg-1C2532 px-40" v-if="!verified">
          <steps  v-show="$route.query.isReg == 1" style="margin: 0 auto;" :active="2"></steps>
          <div class="tc">
              <div class="bold mt10 ft24 pb20">{{$t('add.ggyzq')}}</div>
              <div class="p20 qrcode auto w">
                 <img class="w-full h-full " :src="qrObj.google_auth_url" alt="">
              </div>
              <div class="flex alcenter jscenter pt20 auto">
                 <div class="pr10 ft16">{{ qrObj.google_auth_secret }}</div>
                 <img @click="getComputedStyle" class="pointer" style="width: 15px; height: 15px;" src="../../assets/images/sx.png" alt="">
              </div>
              <div class="pt10 pb20 gray9">{{ $t('add.ts') }}</div>
              <div class="btn auto pointer" @click="copy">{{ $t('add.fz') }}</div>
          </div>
          <div class="flex alcenter between mt40">
             <div>{{ $t('add.ggyzm') }}</div>
             <div class="flex alcenter ">
                 <!-- <div class="pr20 text-success" @click="clear">{{$t('add.qc')}}</div>
                 <div class="text-success" @click="paste">{{ $t('add.zt') }}</div> -->
             </div>
          </div>
          <div class="flex alcenter between  mt10" @click="toggle('bottom')">
             <div class="flex alcenter ">
                <div class="n-item ft18 mr20" :class="isKey&& passwordArr[item-1] ? 'bd':''" v-for="item in 6" @click="isKey=true">{{ passwordArr[item-1]}}</div>
             </div>
             <div class="pr20 ft16 text-success flex alcenter pointer green" @click="clear">{{$t('add.qc')}}</div>
          </div>
          <div class="title-text mt30 px">
              <div>{{ $t('add.zysx') }}</div>
              <div class="mt10">1.{{$t('add.one')}}</div>
              <div class="mt10">2.{{ $t('add.two') }}</div>
          </div>
          
          <div  class="bg-main-liner pointer wt200 ht40 flex alcenter jscenter mt40 white radius6 ft16" @click="confirm">{{ $t("login.e_confrim") }}</div>
          <li class="flex alcenter jscenter mt20"  v-if="$route.query.isReg == 1">
              <div class="pointer pointer  wt200 ht40 flex alcenter jscenter  radius6 ft16"
            @click="tiaog">
            {{ $t("add.tiaog") }}
              </div>
          </li>
     
        </div>
      <div class="min-h-screen pb20 pt20 bg-white dark:bg-1C2532 px-40" v-else>
        <div class="flex alcenter jscenter">
           <image src="../../assets/images/google2.png" style="width: 200rpx;height: 200rpx;"  mode="widthFix"></image>
        </div>
        <div class="tc mt20 ft14 color1">{{$t('add.ggtt')}}</div>
      </div>
    </div>
  </template>
  
  <script>
      import steps from '@/components/step.vue';
      export default{
          components: {
             steps
          },
          data(){
              return{
                passwordArr:[],
                qrObj:{},
                isReg:'',
                verified:false,
                isKey:false
              }
          },
          mounted() {
            this.getComputedStyle()
             this.keyDown()
          },
          methods:{
            tiaog(){
            this.$router.push('/finish?isReg=1')
          },
            keyDown() {
              document.onkeydown = (e) => {
                //事件对象兼容
                let el = e || event || window.event || arguments.callee.caller.arguments[0]
                if(el.key == 'Backspace'){
                    if(this.passwordArr.length<1){
                      return
                    }
                    this.passwordArr.splice(this.passwordArr.length-1, 1)
                    return
                }
                if(this.passwordArr.length>=6){
                  return
                }
                if(el.key>=0 && this.isKey){
                  this.passwordArr.push(el.key)
                }
               
              }

            },
            toPath(){
              uni.navigateTo({url: '/pages/mine/finish' })
             // uni.switchTab({url: '/pages/home/home' })
            },
            confirm(){
              if(this.passwordArr.length<6){
               
                this.$message({

                  message:this.$t('add.plats')
              });
                return;
              }
             
              this.$http
              .initDataToken(
                {
                  url: "user/bind_verify_method",
                  data: {
                    type:'google_secret',
                    code:this.passwordArr.join(''),
                    account:this.qrObj.google_auth_secret
                  },
                  type:"post"
                },
                true
              )
              .then(res => {
                if(this.$route.query.isReg == 1){
                    this.$router.push('/finish?isReg=1')
                  }else{
                    this.$router.go(-1)
                  }
                    
              });
            },
            copy(){
                var that = this;
                if (!document.queryCommandSupported('copy')) {
                  // 不支持
                  this.$message(that.$t('assets.copy_err'));
                }
                
                let textarea = document.createElement("textarea")
                textarea.value = that.qrObj.google_auth_secret
                textarea.readOnly = "readOnly"
                document.body.appendChild(textarea)
                textarea.select() // 选择对象
                textarea.setSelectionRange(0, that.qrObj.google_auth_secret.length) //核心
                let result = document.execCommand("copy") // 执行浏览器复制命令
                textarea.remove()
              this.$message({
                  type:'success',
                  message:this.$t('assets.copy_success')
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
         
           
          },
            getComputedStyle(){
               this.$http.initDataToken({ url: "user/get_google_secret" }, false).then(res => {
                   this.qrObj =  res
				       })
            },


          }
      }
  </script>
    <style lang="scss" scoped>
    .google{
      width: 600px;
      background: #fff;
      margin:0 auto;
      padding:20px 20px;
    }
   .qrcode{

    padding: 25px;
    border: 1px solid #e5e7ed;
  }
  .auto{
    margin:0 auto;
  }
  .btn{
    border: 2px solid #e5e7ed;
    box-sizing: content-box;
    width: 130px;
    height: 40px;  
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .n-item{
    width: 47px;
    height: 47px;
    background: #f5f5f5;
    text-align: center;
    line-height: 47px;
  }
  .title-text{
    background: #f5f5f5;
  }
  .p20{
    padding: 20px;
  }
  .w{
    width: max-content;
  }
  .px{
    padding:20px 30px;
  }
  .bg-main-liner{
    margin:20px auto;
  }
  .bd{
    border:1px solid #51Bc86;
  }
  .authentication{
  min-height: calc(100vh - 60px);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}
  </style>
  