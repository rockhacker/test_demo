<template>
  <div class="flex alcenter jsend vh100"  :style="{'background-image': `url(${require('../../assets/images/register.png')})`}">
    <div class="bgpart radius4 plr60 ptb40 mb50 w25 mwidth" style="margin-right:80px;">
      <div class="tc ft20">{{$t('login.forget_pwd')}}</div>
      <div class="mt40">
        <div class="bdbea2 flex alcenter bold">
          <div
            class="pb10 mr20 pointer"
            v-show="i!=0"
            :class="{'active2px':index==i}"
            v-for="(item,i) in infos"
            :key="i"
            @click="changeMethod(i)"
          >{{$t(item)}}</div>
        </div>
        <div class="mt20 radius4 h46 flex alcenter">
          <!-- <div class="w20 bdr tc">+86</div> -->
          <!-- <el-select v-model="country_code" class="w25" @change="changeCountry" v-show="index==0">
            <el-option
              v-for="item in countries"
              :key="item.name"
              :label="'+'+item.global_code"
              :value="item.id"
            >
              <span class="fl">{{ item.name }}</span>
              <span class="fr ft14">+{{ item.global_code }}</span>
            </el-option>
          </el-select> -->
          <input
            type="text"
            class="flex1 h46 pl20 nwhite my-input-border"
            :class="index == 0 ?'':''"
            v-model="account"
            @change="changeAccount"
            :placeholder="index == 0 ? $t('login.p_mobile') : $t('login.p_email')"
          />
        </div>
       <!-- <p class="mt20">
                {{$t('login.fixedemail1')}} <span class="blue"></span> {{$t('login.fixedemail2')}}
          </p> -->
        <!-- <div class="mt20 bde7 radius2 ht50 lh50 flex alcenter">
          <input type="text" class="flex1 h100 bdre7 pl20 nwhite" v-model="sms_code" :placeholder="$t('login.p_vcode')" />
          <div class="w20 bdr tc blue pointer" @click="sendcode" v-show="!hassend">{{$t('login.r_send')}}</div>
          <div class="w20 bdr tc blue" v-show="hassend">{{second}}s</div>
        </div> -->
        <div class="mt20 radius4  h46 flex alcenter">
                    <input type="text" class="flex1 h46 my-input-border  pl20 nwhite" v-model="sms_code" :placeholder="$t('register.enterCode')">
                    <div class="w20 my-input-border radius4 h46 pointer tc text-my-orange" style="border-left-width:0;line-height: 46px;border-radius: 0 4px 4px 0;" @click="sendcode" v-show="!hassend">{{$t('login.send')}}</div>
                    <div class="w20 my-input-border radius4 h46 tc blue text-my-orange" style="line-height:46px;border-left-width:0;border-radius: 0 4px 4px 0;"  v-show="hassend">{{second}}s</div>
        </div>
        <div class="mt20 radius4 h46 flex alcenter">
          <input
            type="password"
            autocomplete="new-password"
            class="flex1 my-input-border h46 pl20 nwhite"
            v-model="password"
            :placeholder="$t('login.p_pwd')"
          />
        </div>
        <div class="mt20 radius4 h46 flex alcenter">
          <input
            type="password"
            autocomplete="new-password"
            class="flex1 my-input-border h46 pl20 nwhite"
            v-model="re_password"
            :placeholder="$t('register.enterPassword2')"
          />
        </div>
        <div class="mt20 white tc h46 lh46 radius2 pointer ft18" style="line-height:46px;background: linear-gradient(90deg, #FFB216, #FF9D12);" @click="submsits">{{$t('login.e_confrim')}}</div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      infos: ['login.f_mobile','login.f_email'],
      index: 1,
      account: "",
      password: "",
      re_password: "",
      countries: [],
      country_code: "",
      sms_code: "",
      hassend: false,
      second: 60,
      interid: "",
      countryCodeId: ""
    };
  },
  created() {
    // 获取国家
    // this.$http.initDataToken({ url: "default/area_list" },false).then(res => {
    //   this.countries = res;
    //   if (res.length > 0) {
    //     this.country_code = "+" + res[0].global_code;
    //     this.countryCodeId = res[0].id;
    //   }
    // });
  },
  methods: {
    changeCountry(e) {
      console.log(e);
      this.countryCodeId = e;
    },
    changeMethod(e) {
      this.index = e;
      this.hassend = false;
      if (this.interid) {
        clearInterval(this.interid);
      }
    },
    // 发送验证码
    sendcode() {
      if (this.hassend) {
        return;
      }
      // 手机
      if (this.index == 0) {
		if (!this.account) {
			this.$utils.layerMsg(this.$t('register.emptyPhone'));
			return false;
		}
		// if (!this.$utils.checkMobile(this.account)) {
		//   this.$utils.layerMsg(this.$t('login.p_taccount'));
		//   return false;
		// }
        this.$http
          .initDataToken({
            url: "notify/send_sms",
            type: "POST",
            data: {
              to: this.account,
              type: 2,
              area_id: this.countryCodeId
            }
          })
          .then(res => {
            this.hassend = true;
            this.interid = setInterval(() => {
              if (this.second >= 1) {
                this.second--;
              } else {
                this.hassend = false;
                clearInterval(this.interid);
              }
            }, 1000);
          });
      } else {
        // 邮箱验证码
        if (this.account.indexOf("@") == -1) {
          this.$utils.layerMsg(this.$t('login.p_temail'));
          return false;
        }
        this.$http
          .initDataToken({
            url: "notify/send_email",
            type: "POST",
            data: {
              to: this.account,
              type: 2,
              area_id: this.countryCodeId
            }
          })
          .then(res => {
            this.hassend = true;
            this.interid = setInterval(() => {
              if (this.second >= 1) {
                this.second--;
              } else {
                this.hassend = false;
                clearInterval(this.interid);
              }
            }, 1000);
          });
      }
      // 邮箱
    },
    // 提交
    submsits() {
      var types ="";
      if(this.index == 0){
         if (!this.account) {
           this.$utils.layerMsg(this.$t('register.emptyPhone'));
           return false;
         }
		// if (!this.$utils.checkMobile(this.account)) {
  //         this.$utils.layerMsg(this.$t('login.p_taccount'));
  //         return false;
  //       }
      }else{
         if (this.account.indexOf("@") == -1) {
          this.$utils.layerMsg(this.$t('login.p_temail'));
          return false;
        }
      }
      // this.index == 0 ? (types = "mobile") : "email";
      if (!this.sms_code) {
        return this.$utils.layerMsg(this.$t('register.emptyCode'));
      }
      if (!this.password) {
        return this.$utils.layerMsg(this.$t('register.emptyPassword'));
      }
      if (!this.$utils.checkPassword(this.password)) {
        return this.$utils.layerMsg(this.$t('register.length'));
      }
      if (!this.re_password) {
        return this.$utils.layerMsg(this.$t('register.enterPassword2'));
      }
      if (this.password != this.re_password) {
        return this.$utils.layerMsg(this.$t('register.unlike'));
      }
      var data = {
        account: this.account,
        new_password: this.password,
        secondary_password: this.re_password,
        type: this.index == 0 ?'mobile':'email',
        auth_code: this.sms_code
      };
      this.$http
        .initDataToken({ url: "user/forget_password", data, type: "POST" })
        .then(res => {
          console.log(res);
          setTimeout(() => {
            this.$router.push({ name: "login" });
          }, 500);
        });
    },


    verifyAccount(ismobile) {
      if (ismobile == 0) {
        if (!this.account) {
          return this.$utils.layerMsg(this.$t('register.emptyPhone'));
        }
        // if (!this.$utils.checkMobile(this.account)) {
        //   return this.$utils.layerMsg(this.$t('register.pRightPhone'));
        // }
      } else {
        if (!this.account) {
          this.$utils.layerMsg(this.$t('register.emptyEmail'));
        }
        if (!this.$utils.checkEmail(this.account)) {
          return this.$utils.layerMsg(this.$t('register.pRightEmail'));
        }
      }
    },
    // 改变账号
    changeAccount() {
      this.hassend = false;
      if (this.interid) {
        clearInterval(this.interid);
      }
    }
  }
};
</script>
<style lang="">
.el-input__inner {
  border: none;
}
.mwidth {
  min-width: 440px;
}
</style>
