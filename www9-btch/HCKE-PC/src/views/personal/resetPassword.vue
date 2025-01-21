<template>
<div class="forget-box">
    <div class="contentBK ">
        <div class="content-wrap">
            <div class="account">
                <div class="main" >
                    <div class="main_title baselight fColorn">{{$t('login.e_pwd')}}</div>
                    <div class="register-input">
                        <span class="register-item">{{$t('login.old')}}</span>
                        <input type="password" autocomplete="new-password" class="input-main input-content bgpart bd nwhite"  v-model="old_password" id="pwd">
                    </div>
                    <div class="register-input">
                        <span class="register-item">{{$t('login.p_pwd')}}</span>
                        <input type="password" autocomplete="new-password" class="input-main input-content bgpart bd nwhite"  v-model="password" id="pwd">
                    </div>
                    <div class="register-input">
                        <span class="register-item">{{$t('register.enterPassword2')}}</span>
                        <input type="password" autocomplete="new-password" class="input-main input-content bgpart bd nwhite"  v-model="re_password" id="repwd">
                    </div>
                    <div class="register-input input-main" style="padding:0;">
                      <span class="register-item">{{$t('add.plats')}}</span>
                      <el-radio-group v-model="radio" @input="getradio">
                        <el-radio label="1">{{$t('add.sjyz')}}</el-radio>
                        <el-radio label="2">{{$t('add.yxyz')}}</el-radio>
                        <el-radio label="3">{{$t('add.ggyzm')}}</el-radio>
                      </el-radio-group>
                    
                        <div class="mt20 border-b-EEEEEE ht50 lh50 flex alcenter bdinput"  >
                          <input type="text" autocomplete="new-password" class="input-main input-content bgpart bd nwhite"  v-model="sms_code" id="repwd">
                          <div  class="w20 bdr bg-main-liner tc  pointer" @click="sendcode" v-show="!hassend &&radio!=3">{{$t('login.send')}}</div>
                          <div class="w20 bdr bg-main-liner tc  "  v-show="hassend&&radio!=3">{{second}}s</div>
                </div>
                    </div>
                    <button class="register-button curPer bg-main-liner" type="button" @click="resetPass" style="margin-top:20px;width: 520px;">{{$t('login.e_confrim')}}</button>
                </div>
            </div>
        </div>
    </div>
    
</div>

</template>

<script>

export default {
  data() {
    return {
      radio:'',
      second:60,
      sms_code:'',
      hassend:false,
      isMb: true,
      account_number: "",
      phoneCode: "",
      showReset: false,
      old_password:'',
      password: "",
      re_password: "",
      ver_info:{},
      info:{},
    };
  },
  created() {
    this.showReset= this.$route.query.fromSet;
    this.verified_info()
    this.getInfo()

  },
  methods: {
    getradio(e){
      if(e== 1){
          if(!this.ver_info.mobile_verified){
					return   this.$utils.layerMsg(this.$t('add.bdsj'));
					
				}
			}
			if(e==2){
				if(!this.ver_info.email_verified){
          return   this.$utils.layerMsg(this.$t('add.bdyx'));
					
				}
			}
			if(e==3){
				if(!this.ver_info.google_secret_verified){
          return   this.$utils.layerMsg(this.$t('add.bdgg'));
					
				}
			}
    },
    verified_info(){
      	this.$http.initDataToken({ url: "user/verified_info" },false).then(res => {
          this.ver_info = res
        })
    },
    getInfo(){
      	this.$http.initDataToken({ url: "user/info" },false).then(res => {
          this.info = res
        })
    },
    sendcode(){
         if(!this.radio){
          
          this.$utils.layerMsg(this.$t('add.quzyz'));
         }
          // 手机
          if(this.radio==1){
             
            
             
              this.$http.initDataToken({url:'notify/send_sms',type:'POST',data:{
                  to:this.info.mobile,
                  type:5,
                
              }},true,true,false,true).then(res=>{
                  this.hassend=true;
                  this.interid=setInterval(()=>{
          if(this.second>=1){
            this.second--;
          }else{
                          this.hassend=false
                          this.second = 60 ;
            clearInterval(this.interid);
          }
					},1000)
                })
            }else if(this.radio==2){
                // 邮箱验证码
              
               
                this.$http.initDataToken({url:'notify/send_email',type:'POST',data:{
                    to:this.info.email,
                    type:5,
                  
                }},true,true,false,true).then(res=>{
                    this.hassend=true;
                    this.interid=setInterval(()=>{
						if(this.second>=1){
							this.second--;
						}else{
                            this.hassend=false
                            this.second = 60 ;
							clearInterval(this.interid);
						}
					},1000)
                })
            }
            // 邮箱
        },
    resetPass() {
      var that = this;
      if (that.old_password == "") {
        that.$utils.layerMsg(this.$t('login.enterOld'))
        return;
      }
      if (that.password == "") {
        that.$utils.layerMsg(this.$t('login.p_pwd'))
        return;
      } else if (that.password.length <6) {
        that.$utils.layerMsg(this.$t('login.p_simple'))
        return;
      } else if (that.password !== that.re_password) {
        that.$utils.layerMsg(this.$t('login.p_t_notpwd'))
        return;
      } else  if(!that.sms_code){
        that.$utils.layerMsg(this.$t('add.plats'));
        return;
      }else {
        let data = {
          old_password:this.old_password,
					new_password: this.password,
					secondary_password: this.re_password,
          code:that.sms_code,
            verify_type:that.radio == 1 ? 'mobile' : that.radio == 2 ? 'email' :that.radio == 3 ? 'google_secret' :''
        };
         this.$http.initDataToken({url:'user/amend_password',data,type:'POST'})
            .then(res=>{
                // that.$utils.layerMsg(res.msg)
                setTimeout(() => {
                     that.$router.push("/login");
                }, 500);
               
            })
      }
    }
  }
};
</script>

<style scoped>

.account {
  width: 1200px;
  margin: 0 auto;
  padding-top: 93px;
  overflow: hidden;
  min-height: 880px;
}
.main {
  position: relative;
  padding: 0 0 60px 30px;
}
.main_title {
  font-size: 36px;
  /* color: #c7cce6; */
}
.register-item {
  display: block;
  height: 22px;
  color: #61688a;
  font-size: 12px;
}
.register-input {
  position: relative;
  margin-top: 20px;
}
.input-box {
  position: relative;
  margin-top: 40px;
}
.input-main {
  width: 520px;
  min-height: 46px;
  /* border: 1px solid #4e5b85; */
  padding: 0 20px;
  color: #c7cce6;
  font-size: 14px;
  border-radius: 3px;
  /* background-color: #1e2235; */
}
.icon {
  width: 48px;
  height: 48px;
  line-height: 48px;
  border-right: 1px solid #2e3753;
  position: absolute;
  top: 0;
}
.login-btn {
  width: 420px;
  margin-top: 40px;
  background: #5697f4;
  font-size: 16px;
  border-radius: 4px;
  color: #fff;
  line-height: 48px;
  cursor: pointer;
}
.noaccount {
  color: #fff;
}
.register-button {
  width: 200px;
  display: inline-block;
  line-height: 46px;
  background-color: #7a98f7;
  border-radius: 4px;
  color: #fff;
  border: none;
}
.have-account {
  font-size: 14px;
  display: inline-block;
  margin-left: 30px;
}
.right-tip {
  position: absolute;
  left: 620px;
  top: 70px;
  line-height: 24px;
  padding-right: 50px;
  margin-top: 10px;
  font-size: 14px;
  color: #61688a;
}
.code-box {
  width: 520px;
  border: 1px solid #4e5b85;
  background: #1e2235;
}
.code-box .input-main {
  width: 419px;
  border: none;
}
.code-box button {
  border: none;
  border-left: 1px solid #4e5b85;
  line-height: 44px;
  color: #7a98f7;
  background: #1e2235;
  width: 94px;
}
</style>
