<template>
  <div class="forget-box">
    <div class="contentBK">
      <div class="content-wrap">
        <div class="account">
          <div class="main">
            <div class="main_title fColorn">{{$t('authentication.setDealpwd')}}</div>

            <div class="register-input">
              <span class="register-item">{{$t('login.e_pdeal')}}</span>
              <input
                type="password"
                class="input-main input-content bgpart bd nwhite"
                v-model="password"
                id="pwd"
              />
            </div>
            <div class="register-input">
              <span class="register-item">{{$t('login.p_againpdeal')}}</span>
              <input
                type="password"
                class="input-main input-content bgpart bd nwhite"
                v-model="re_password"
                id="repwd"
              />
            </div>
            <div class="register-input input-main" style="padding:0;" v-if="!$route.query.isReg == 1 &&ver_info.is_set_pay_password">
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
             <!-- <div class="mt20  flex alcenter">
                      {{$t('login.fixedemail1')}} <span class="blue"></span> {{$t('login.fixedemail2')}}
                </div> -->
            <!-- <div class="register-input code-input">
              <span class="register-item">{{$t('login.p_vcode')}}</span>
              <div class="code-box bg-part bd">
                <input
                  type="text"
                  class="input-main input-content bgpart nwhite"
                  maxlength="16"
                  v-model="phoneCode"
                  id="pwd"
                />
                <button type="button" class="pointer bgpart bdl" @click="setTime">{{codeText}}</button>
              </div>
            </div> -->
            <button
              class="register-button curPer bg-main-liner"
              type="button"
              @click="resetPass"
              style="margin-top:20px;width: 520px;"
            >{{$t('login.e_confrim')}}</button>
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
      account_number: "",
      phoneCode: "",
      password: "",
      re_password: "",
      codeId: "",
      codeText: this.$t('login.get_code'),
      lang:'',
      radio:'',
      second:60,
      sms_code:'',
      ver_info:{},
      info:{},
    };
  },
  created() {
    this.account_number = localStorage.getItem("accountNumber");
    this.codeId = localStorage.getItem("codeId");
    this.lang = localStorage.getItem("lang")
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
    
    // sendCode(url) {
    //   this.$http
    //     .initDataToken({
    //       url: url,
    //       type: "post",
    //       data: {
    //         to: this.account_number,
    //         area_id: this.codeId,
    //         type: 3
    //       }
    //     })
    //     .then(res => {

    //     });
    // },
    setTime(e) {
      var that = this;
      if (e.target.disabled) {
        return;
      } else {
        var url = "";
        if (that.account_number.indexOf("@") != -1) {
          url = "notify/send_email";
        } else {
          url = "notify/send_sms";
        }
        that.sendCode(url);
        var time = 60;
        var timer = null;
        timer = setInterval(function() {
          that.codeText = time + "s";
          console.log(that.codeText)
          e.target.disabled = true;
          if (time == 0) {
            clearInterval(timer);
            that.codeText = that.$t('addressList.send');
            e.target.disabled = false;
            return;
          }
          time--;
        }, 1000);
      }
    },
    resetPass() {
      var that = this;
      if (that.password == "") {
        that.$utils.layerMsg(this.$t('register.enterPassword'));
        return;
      } else if (that.re_password == "") {
        that.$utils.layerMsg(this.$t('register.enterPassword2'));
        return;
      } else if (that.password !== that.re_password) {
        that.$utils.layerMsg(this.$t('login.p_t_notpwd'));
        return;
      } else  if(!that.sms_code&&!this.$route.query.isReg == 1){
        that.$utils.layerMsg(this.$t('add.plats'));
        return;
      }else {
        let data = {
          password: this.password,
          auth_code: this.phoneCode,
          code:that.sms_code,
            verify_type:that.radio == 1 ? 'mobile' : that.radio == 2 ? 'email' :that.radio == 3 ? 'google_secret' :''
        };
        this.$http
          .initDataToken({
            url: "user/amend_pay_password",
            type: "post",
            data: data
          })
          .then(res => {
            setTimeout(() => {
              if(this.$route.query.isReg == 1){
                that.$router.push("/authentication?isReg=1");
              }else{
                that.$router.go(-1);
              }
              // that.$router.push("/login");
            
            }, 500);
          });
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
  /* border-right: 1px solid #2e3753; */
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
  /* border: 1px solid #4e5b85; */
  /* background: #1e2235; */
}
.code-box .input-main {
  width: 419px;
  border: none;
}
.code-box button {
  border: none;
  /* border-left: 1px solid #4e5b85; */
  line-height: 46px;
  color: #7a98f7;
  /* background: #1e2235; */
  border-radius: 4px;
  width: 94px;
}
</style>
