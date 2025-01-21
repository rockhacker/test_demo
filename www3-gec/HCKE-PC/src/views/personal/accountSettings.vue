<template>
  <div class="account-main pb20">
    <div class="clear mb50">
      <div class="fl">
        <img src="@/assets/images/accountSecurity.png" />
      </div>
      <div class="fl ml30">
        <div class="ft16 white flex between">
			<div class="flex alcenter">
				{{$t('authentication.security')}}
				<span class="ml10">{{lever}}</span>
			</div>
			<div class="ft14 mr20">
				<div style="color:#ffffff" v-if="level">
					{{level}}
				</div>
				<div style="color:#ffffff" v-if="credit">
					{{$t('home.credit')}}:{{credit}}
				</div>
			</div>
        </div>
		
        <div class="bar-bottom">
          <div class="bar-top" :style="widthBar"></div>
        </div>
        <p class="fColor2 ft14">{{$t('authentication.security')}}： {{lever}}，{{$t('authentication.safe')}}</p>
      </div>
    </div>
    <ul>
      <li>
        <img src="@/assets/images/success.png" />
        <span class="ml20">{{$t('authentication.invite')}}</span>
        <p class="fl">
          <span class="fColor1">{{extension_code}}</span>
        </p>
        <span class="fr base ml25 mouseDefault"></span>
        <span class="fr base mouseDefault pointer" id="copy" @click="copy">{{$t('authentication.copyinvitationcode')}}</span>
      </li>
      <li>
        <img src="@/assets/images/success.png" />
        <span class="ml20">{{$t('authentication.invite_url')}}</span>
        <p class="fl">
          <span class="fColor1">{{extension_url}}</span>
        </p>
        <span class="fr base ml25 mouseDefault"></span>
        <span class="fr base mouseDefault pointer" id="copy2" @click="copy2">{{$t('authentication.copy')}}</span>
      </li>
      <li v-if="account">
        <img :src="psrc" />
        <span class="ml20">{{$t('authentication.bindphone')}}</span>
        <p class="fl">
          <span class="fColor1">{{account}}</span>
        </p>
        <span class="fr base ml25 mouseDefault"></span>
        <span class="fr base mouseDefault"></span>
      </li>
      <li v-if="email">
        <img :src="esrc" />
        <span class="ml20">{{$t('authentication.bindEmail')}}</span>
        <p class="fl">{{email}}</p>
        <span class="fr base ml25 mouseDefault"></span>
        <span class="fr base mouseDefault"></span>
        
        <span class="fr base" v-if="email">{{$t('authentication.haveBind')}}</span>
        <router-link class="fr base pointer" to="/BindAccount" v-else>{{$t('authentication.goBind')}}</router-link>
      </li>
      <li>
        <img src="@/assets/images/success.png" />
        <span class="ml20">{{$t('authentication.s_loginpwd')}}</span>
        <p class="fl">{{$t('authentication.modifyPassword')}}</p>
        <span class="fr base ml25 mouseDefault"></span>
        <span class="fr base mouseDefault" @click="goPwd()">{{$t('authentication.modify')}}</span>
      </li>
      <li>
        <img :src="msrc" />
        <span class="ml20">{{$t('authentication.s_dealpwd')}}</span>
        <p class="fl">{{$t('authentication.setDealpwd')}}</p>
        <span class="fr ml25 mouseDefault"></span>
        <router-link class="fr base mouseDefault" to="/tradePassword">{{$t('authentication.goSet')}}</router-link>
      </li>
      <li>
        <img :src="msrc" />
        <span class="ml20">{{$t('authentication.authCode')}}</span>
        <p class="fl">
          <span class="fColor1">{{authCode}}</span>
        </p>
        <span class="fr base ml25 mouseDefault"></span>
        <span class="fr base mouseDefault pointer" id="copy3" @click="copy3">{{$t('authentication.copy')}}</span>
      </li>
    </ul>
  </div>
</template>
<script>
import "@/lib/clipboard.min.js";
export default {
  name: "accountSet",
  data() {
    return {
      routerList: [],
      account: this.$t('authentication.noBind'),
      email: "",
      isbind: this.$t('authentication.bind'),
      extension_code: "",
      extension_url: "",
      user_name: this.$t('authentication.bindaccounttoexchangepoints'),
      lever: this.$t('authentication.low'),
      widthBar: "width: 25%",
      bar: 25,
      authen: 0,
      type: "",
      psrc: require("@/assets/images/error.png"),
      esrc: require("@/assets/images/error.png"),
      bsrc: require("@/assets/images/error.png"),
      msrc: require("@/assets/images/success.png"),
      authCode: "",
	  credit: 0,
	  level: ""
    };
  },
  created() {
    this.type = window.localStorage.getItem("type") || "";
    this.userInfo();
    this.gettlian();
  },
  methods: {
    goPwd() {
      this.$router.push({ path: "/resetPassword", query: { fromSet: true } });
    },
    goBind() {
      this.$router.push("/bindInfo");
    },
    userInfo() {
      this.$http.initDataToken({ url: "user/info" }, false).then(res => {

        if (res.mobile != null) {
          this.account = res.mobile;
          this.psrc = require("@/assets/images/success.png");
          this.bar = this.bar + 25;
        }
        if (res.email != null) {
          this.email = res.email;
          this.esrc = require("@/assets/images/success.png");
          this.bar = this.bar + 25;
        }
        this.extension_code = res.invite_code;
        this.extension_url = `${window.location.origin}/#/register?extension_code=${res.invite_code}`;
        this.authen = res.review_status;
        this.credit = res.credit_score;
        this.level = res.level;
        if (this.authen == 2) {
          this.bar = this.bar + 25;
        }
        if (this.bar == 50) {
          this.lever = this.$t('authentication.middle');
        } else if (this.bar == 75) {
          this.lever = this.$t('authentication.high');
        } else if (this.bar == 100) {
          this.lever = this.$t('authentication.strong');
        }
        this.widthBar = "width:" + this.bar + "%";
      });
    },
    gettlian() {
      this.$http
        .initDataToken({ url: "user/authorization_code" }, false)
        .then(res => {
          console.log(res);
          this.authCode = res;
        });
    },
    copy() {
      var that = this;
      var loc = location.origin;
      var clipboard = new Clipboard("#copy", {
        text: function() {
          return that.extension_code
        }
      });
      clipboard.on("success", function(e) {
        that.$utils.layerMsg(that.$t('authentication.copy_success'),'success');
        clipboard.destroy();
      });
      clipboard.on("error", function(e) {
        that.$utils.layerMsg(that.$t('assets.copy_err'))
        clipboard.destroy();
      });
    },
    // 复制邀請鏈接
    copy2() {
      var that = this;
      var loc = location.origin;
      var clipboard = new Clipboard("#copy2", {
        text: function() {
          return that.extension_url;
        }
      });
      clipboard.on("success", function(e) {
        that.$utils.layerMsg(that.$t('authentication.copy_success'),'success');
        clipboard.destroy();
      });
      clipboard.on("error", function(e) {
        that.$utils.layerMsg(that.$t('assets.copy_err'));
        clipboard.destroy();
      });
    },
    // 复制授权码
    copy3() {
      var that = this;
      var loc = location.origin;
      var clipboard = new Clipboard("#copy3", {
        text: function() {
          return that.authCode;
        }
      });
      clipboard.on("success", function(e) {
        that.$utils.layerMsg(that.$t('authentication.copy_success'),'success');
        clipboard.destroy();
      });
      clipboard.on("error", function(e) {
        that.$utils.layerMsg(that.$t('assets.copy_err'));
        clipboard.destroy();
      });
    }
  }
};
</script>
<style lang="scss" scoped>
$navBack: #1a243b;
$base: #5697f4;
$line: #303b4b;
$fColor2: #637085;
.account-main {
  padding-left: 34px;
  padding-right: 34px;
  padding-top: 34px;
  .bar-bottom {
    width: 320px;
    height: 8px;
    border-radius: 4px;
    background-color: #9c7c00;
    margin: 22px 0 12px 0;
    overflow: hidden;
    .bar-top {
      background-color: #fddd60;
      height: 100%;
      border-radius: 4px;
    }
  }
  ul {
    border-top: 1px solid #303b4b;
    /* color: #637085; */
    color: white;
    font-size: 14px;
    img {
      width: 16px;
      vertical-align: middle;
    }
    li {
      border-bottom: 1px solid #303b4b;
      line-height: 72px;
      position: relative;
      p {
        position: absolute;
        left: 300px;
        top: 0;
      }
    }
  }
}
</style>


