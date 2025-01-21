<template>
  <div id="app">
    <div
      class="flex alcenter between plr20 bgheader ft14 bdbheader basebg headerbase"
      style="height:60px;"
      :class="{'isHome':isHome}"
    >
      <div class="flex alcenter between h48 lh48 app">
		<div :class="!value?'bghome':''" class="pointer mr50 ht50 plr10 flex alcenter">
			<img src="../static/logo.png" class="h100" @click="goHome" v-if="!value"/>
			<img src="../static/logo.png"  class="h100" @click="goHome" v-else/>
		</div>
        <router-link
          :to="{ name: item.page }"
          class="mr25"
          :class="{'homeTitle':isHome}"
          style="white-space:nowrap;"
          v-for="(item, i) in listLeft"
          :key="i"
          v-if="item.show"
          >{{ item.name }}</router-link
        >
      </div>
      <div class="flex alcenter between">
        <div class="pointer sepoi radius2 radbg login-btn" style="width: 100px;">
          <el-select v-model="langname" class="flex1" @change="changeLang">
            <el-option
              class="flex alcenter between"
              v-for="item in languages"
              :key="item.value"
              :name="item.name"
              :value="item"
            >
              <span class="fl">{{ item.name }}</span>
              <img
                :src="item.img"
                alt
                class="ml10"
                style="height: 20px; width: 30px"
              />
            </el-option>
          </el-select>
        </div>

        <!-- <a href="#" class="mr25" @click="toMoonPay">{{$t('header.moonPayRecharge')}}</a> -->
        <router-link
          :to="{ name: 'login' }"
          class="plr20 radius2"
          v-if="!account"
          >{{ $t("login.login") }}</router-link
        >
        <div class="plr20 pointer" style="white-space:nowrap;" v-else>
          <el-dropdown @command="personalLink">
            <span class="el-dropdown-link" :class="{'homeTitle':isHome}">
              <i class="iconfont icon-zhanghao ft16" :class="{'homeTitle':isHome}"></i>
              {{ account }}
              <i class="el-icon-arrow-down el-icon--right" :class="{'homeTitle':isHome}"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item
                v-for="(item, index) in accountList"
                :command="item"
                :key="index"
                >{{ item.title }}</el-dropdown-item
              >
            </el-dropdown-menu>
          </el-dropdown>
        </div>

        <router-link
          style="border:0 solid rgba(255,255,255,0.3);border-left-width:1px;"
          :to="{ name: 'register' }"
          class="ml10 plr20"
          v-show="!account"
          >{{ $t("register.register") }}</router-link
        >
        
        <!-- <div class="ml10">
          <el-switch
            :width="40"
            v-model="value"
            active-icon-class="el-icon-moon"
            inactive-icon-class="el-icon-sunny"
            @change="changeUI"
          ></el-switch>
        </div> -->
      </div>
    </div>
    <router-view @getUserinfo="getinfo" v-if="isShow"></router-view>
  </div>
</template>
<script>
// import utils from '@/lib/helper.js'

export default {
  name: "App",
  data() {
    return {
      listLeft: [
        // {
        //   name: "首页",
        //   page: "home",
        //   show: true
        // },

        {
          name: this.$t('header.legal'),
          page: "legalIndex",
          show: true
        },
        {
          name: this.$t('header.trade'),
          page: "trade",
          show: true
        },
        {
          name:this.$t('new.jiao'),
          page: "second",
          show: true
        },
        {
          name: this.$t('new.yong'),
          page: "lever",
          show: true
        },
        {
          name: this.$t('staking.mining'),
          page: "staking",
          show: true
        },

        {
          name: this.$t('subscription.new_subscription'),
          page: "subscription",
          show: true
        },
        {
          name:this.$t('financial.financial'),
          page: "financial",
          show: true
        },
        {
          name: this.$t('new.choz'),
          page: "recharge",
          show: true
        },

        {
          name:this.$t('financial.yqjl'),
          page: "invite",
          show: true
        },
        {
          name: this.$t('market.market'),
          page: "market",
          show: false
        },
        
        // {
        //   name: this.$t('header.iso'),
        //   page: "isolever",
        //   show: true
        // },
        {
          name: this.$t('header.myshop'),
          page: "myshop",
          show: false
        },
        {
          name: this.$t('header.assets'),
          page: "assets",
          show: true
        },
      ],
      account: "",
      token: "",
      is_seller: false,
      showPersonal: false,
      accountList: [
        {
          title: this.$t('header.account'),
          type: 1,
          page: "accountSettings"
        },
        {
          title: this.$t('header.assets'),
          type: 1,
          page: "assets"
        },
        // {
        //   title: "交易日志",
        //   type:1,
        //   page: "transactionLog"
        // },
        // {
        //   title: this.$t('header.pays'),
        //   type: 1,
        //   page: "collectionSettings"
        // },
        {
          title: this.$t('header.auth'),
          type: 1,
          page: "authentication"
        },
        {
          title: this.$t('feed.feed'),
          type: 1,
          page: "feedback"
        },
        {
          title: this.$t('header.login'),
          type: 2,
          page: "login"
        }
      ],
      languages: [
        // { 
        //   name: "中文", 
        //   img: require("./assets/images/zh.png"), 
        //   value: "zh" 
        // },
        {
          name: "English",
          img: require("./assets/images/en.png"),
          value: "en"
        },
        { 
          name: "日本語",
          img: require("./assets/images/jp.png"), 
          value: "jp"
        },
        // { 
        //   name: "한국어",
        //   img: require("./assets/images/kr.png"), 
        //   value: "kr"
        // },
        { 
          name: "Tiếng Việt",
          img: require("./assets/images/vn.png"), 
          value: "vn"
        },
		 { 
		  name: "ไทย",
		  img: require("./assets/images/th.png"), 
		  value: "th"
		},
		//  { 
		//   name: "عربي",
		//   img: require("./assets/images/ar.png"), 
		//   value: "ar"
		// },
  //     {
  //     name: "Deutsche",
  //     img: require("./assets/images/de.png"),
  //     value: "de"
  //   },
  //     {
  //     name: "Italiano",
  //     img: require("./assets/images/it.png"),
  //     value: "it"
  //   },
  //     {
  //     name: "français",
  //     img: require("./assets/images/fr.png"),
  //     value: "fr"
  //   },
    {
      name: "繁體中文",
      img: require("./assets/images/xin.jpg"),
      value: "hk"
    },
      ],
      lang: "en",
      langname: "",
      value:false,
      isShow:true,
      isHome:true
    };
  },
  watch: {
    is_seller: {
      //监听我的商铺
      handler(newInfo) {
		newInfo = JSON.parse(newInfo);
        let index;
        this.listLeft.map(function(item, i) {
          if (item.page == "myshop") {
            return (index = i);
          }
        });
        if(this.listLeft[index])this.listLeft[index].show = newInfo;
      },
      immediate: true
    },
    deep: true,
    '$route.path': function (newVal, oldVal) {
          this.isHome = newVal === '/home'
          console.log(this.isHome)
	}
  },
  created() {
    this.isHome = this.$route.path === '/home'
    window.addEventListener('setItem', ()=> {
          console.log(11)
          this.isShow=false
          this.$nextTick(function(){ 
          this.isShow=true 
        }) 
    })
    this.token = localStorage.getItem("token");
    console.log(localStorage.getItem("token"));

    // let theme = localStorage.getItem('theme') || 'dark';
    let theme = 'dark'
    this.value= theme == 'light'?false:true;
    this.$utils.theme(theme);
    this.$store.commit('changeTheme',theme);

    if (this.token) {
      this.account = localStorage.getItem("account") || "";
      this.is_seller = localStorage.getItem("is_seller") || false;
    }
    var lang = localStorage.getItem("lang");
    // if (lang == "zh") {
    //   this.langname = "中文";
    // } else 
    if (lang == "en") {
      this.langname = "English";
    }
     else if (lang == "hk") {
      this.langname = "繁體中文";
    }
	else if (lang == "th") {
	  this.langname = "ไทย";
	}
	else if (lang == "ar") {
	    this.langname = "عربي";
	}
    else if (lang == "kr") {
      this.langname = "한국어";
    } else if (lang == "vn") {
      this.langname = "Tiếng Việt";
    } else if (lang == "jp"){
      this.langname = "日本語";
    }else if (lang == "Deutsche"){
      this.langname = "日本語";
    }else if (lang == "it"){
      this.langname = "Italiano";
    }else {
      this.langname = "français";
    }
    // 创建链接
    // this.$utils.initSocket();

    // this.$http.initDataToken({url:'currency/quotation_new'})
    // .then(res=>{
    //   console.log(res,'0000');
    // })
    // .catch(err=>{
    //   console.log(err)
    // })

    //  this.$http.initDataToken({url:'transaction/in',type:'POST',data:{currency_id:1,legal_id:3,num:'0.0001',password: "123456",price: "7737.17"}})
    //     .then(res=>{
    //       console.log(res);
    //     })
  },

  methods: {
		// 动态加载客服js
		loadScript(src, callback) {
			var script = document.createElement('script'),
				cointigerex=document.getElementById("cointigerex"),
				head = document.getElementsByTagName('head')[0];
			if(cointigerex)cointigerex.remove();
				script.type = 'text/javascript';
				script.charset = 'UTF-8';
				script.id = 'cointigerex';
				script.src = src;
				if (script.addEventListener) {
				  script.addEventListener('load', function () {
					  callback && callback();
				  }, false);
				} else if (script.attachEvent) {
				  script.attachEvent('onreadystatechange', function () {
					  var target = window.event.srcElement;
					  if (target.readyState == 'loaded') {
						  callback && callback();
					  }
				  });
			}
			head.appendChild(script);
		},
		_isMobile() {
		  let flag = navigator.userAgent.match(/(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i)
		  return flag;
		},
		//黑白切换
		changeUI(){
		  // this.value=!this.value;
		  let theme = 'light';
		  if(this.value){
			theme = 'dark'
		  }
		  this.$utils.theme(theme);
		  this.$store.commit('changeTheme',theme);
		},
		// 切换语言
		changeLang(e) {
		  console.log(e);
		  var that = this;
		  that.langname = e.name;
		  that.lang = e.value;
		  window.localStorage.setItem("locale", that.lang);
		  window.localStorage.setItem("lang", that.lang);
		  this.$i18n.locale = that.lang;
		  window.location.reload();
		},
		getinfo(page) {
		   let path=sessionStorage.getItem('path')
			this.$http.initDataToken({ url: "user/info" },false).then(res => {
				console.log(res);
				localStorage.setItem("uid", res.id);
				localStorage.setItem("is_seller", res.is_seller);
				let account = res.email || res.mobile;
				localStorage.setItem("account", account);
				this.account = account;
				this.is_seller = res.is_seller;
				
				// 客服参数
				if(res && res.uid){
					window.ai_service = {
						visiter_id:'',
						visiter_name:res.uid || '',
						avatar: ''
					}
					localStorage.setItem("visiter_name", res.uid);
          window.LiveChatWidget.call('set_customer_name',res.uid)
				}
				// this.loadScript("https://chat.cointigerex.cc/assets/layer/ai_service_diy_3.js");
						
				// this.$router.push({ name: "home" });
				// console.log(page,4234);
				if (page) {
				   this.$router.push({ path: page });
				  //this.$router.go(-1)
				} else {
				  // this.$router.push({ path: "/home" });
				}
			});
		},
		personalLink(command) {
		  var that = this;
		  if (command.type == 2) {
			that.$http
			  .initDataToken({ url: "user/logout", type: "post" })
			  .then(res => {
				// localStorage.clear();
				 localStorage.removeItem('token');
				this.token = "";
				this.account = "";
				this.is_seller = false;
				var lang = 'jp';
				setTimeout(function() {
				  that.$router.push({ path: '/login', query: { type: 1 } });
				}, 1000);
			  });
		  } else {
			that.$router.push({ name: command.page });
		  }
		  // console.log(command);
		},
		goHome(){
		  this.$router.push({name:'home'})
		},
		// toMoonPay(){
		//   var that = this;
		//   that.$http
		//       .initDataToken({ url: "user/getUSDTAddress", type: "get" }).then(res => {

		//         if(res){
						
		//           window.location.href='//moonpay.btcusdtbank.com?walletAddress=' + res;
		//         }
		//       })
		  
		// }
  },
  mounted(){
    if (this._isMobile()) {
      const index = location.host.match(/\d+/g)? location.host.match(/\d+/g)[0] : ''
	  window.location.href = `${location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, `//m${index}.`)}`;
    } else {

     //pc
    }
	this.getinfo();
  }
};
</script>

<style lang="scss">
.isHome{
background: rgba(0,0,0,.5) !important;position: absolute;z-index: 999;width:100%;top:0;
border-width: 0 !important;
}

.homeTitle{
  color: hsla(0,0%,100%,.8) !important;
}

.el-switch__label.is-active{
  color: #37b6ff;
}

.el-switch.is-checked .el-switch__core{
  background: #37b6ff !important;
  border-color:#37b6ff !important;
}
.el-loading-spinner i {
    color:#37b6ff !important;
}
.el-loading-spinner .el-loading-text {
  color:#37b6ff !important;
}
.el-button--primary,.el-button--primary:active,.el-button--primary:focus,.el-button--primary:hover{
  color: #fff;
  background: #37b6ff;
  border-color:#37b6ff;
}
/* .el-button--primary.is-disabled{
  color: #212833;
  background: #fcd435c9;
  border-color:#fcd435c9;
} */
/* .el-button--primary.is-disabled:focus,.el-button--primary.is-disabled:hover{
  color: #212833;
  background: #fcd435c9;
  border-color:#fcd435c9;
} */
.el-checkbox__input.is-checked .el-checkbox__inner, 
.el-checkbox__input.is-indeterminate .el-checkbox__inner{
	background-color: #37b6ff;
    border-color: #37b6ff;
}
.el-checkbox__input.is-focus .el-checkbox__inner,
.el-checkbox__inner:hover{
	border-color: #37b6ff;
}
/* .el-button:focus, .el-button:hover{
	color: #000;
	border-color: #37b6ff;
	background-color: #f7f3e2;
} */
.el-dropdown-menu__item:focus, .el-dropdown-menu__item:not(.is-disabled):hover{
	background-color: #37b6ff;
	color: white;
}
.el-checkbox__input.is-checked+.el-checkbox__label,
.el-select-dropdown__item.selected{
	/* color: #37b6ff; */
  color: #000;
}
#app {
  height: auto;
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  min-width: 1200px;
  background: black;
}
.showline .router-link-exact-active {
  border-bottom: 2px solid #357ce1;
}
input[type="number"] {
  -moz-appearance: textfield;
}
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
/* .el-input__inner{
    border: 0 !important;
    color: white !important;
  } */

.account-choose {
  // display: none;
  cursor: default;
  position: absolute;
  top: 48px;
  right: -60px;
  z-index: 999;
  width: 160px;
  line-height: 40px;
  background-color: #fff;
  z-index: 5000;
  border-radius: 3px;
  // box-shadow: 0 0 2px 4px rgba(0, 0, 0, 0.2);
  p {
    padding-left: 20px;
    img {
      width: 14px;
      vertical-align: middle;
      margin-right: 8px;
      display: inline-block;
    }
    img:nth-child(2) {
      display: none;
    }
  }
  p:hover {
    color: #5697f4;
    // background-color: #1a243b;
  }
  p:hover img:nth-child(2) {
    display: inline-block;
  }
  p:hover img:nth-child(1) {
    display: none;
  }
}
.el-input__icon {
  line-height: 26px !important;
}
.el-scrollbar__wrap {
  // overflow-x: hidden;
  overflow: auto !important;
}
.el-input.is-active .el-input__inner, .el-input__inner:focus{
	border-color:#f5dab1;
.el-input__inner {
  border: none !important;
}
}
.el-pagination.is-background .btn-next,
.el-pagination.is-background .btn-prev,
.el-pagination.is-background .el-pager li {
  background-color: #e5ebf5;
}
.el-pagination.is-background .el-pager li:not(.disabled).active {
    background-color: #37b6ff;
    color: #FFF;
}
.el-pagination .el-pager li.active,
.el-pagination .el-pager li:hover{
	color: #37b6ff !important;
}
.el-radio__input.is-checked+.el-radio__label {
    color: #37b6ff;
}
.el-radio__input.is-checked .el-radio__inner {
    border-color: #37b6ff;
    background: #37b6ff;
}
.el-radio__inner:hover{
	border-color: #37b6ff;
}
.basebg {
  height: 92px;
}
.radbg {
  border-radius: 4px;
  padding: 0;

  text-align: center;
  line-height: 34px;
  height: 34px;
}
.plr20 {
  padding-left: 20px;
  padding-right: 20px;
}
.sepoi {
  margin-left: 29px;
}
.sepoi .el-input__inner {
  color: #fff;
  height: 26px;
  line-height: 26px;
  font-size: 12px;
  border:0;
}
.login-btn {
  height: 26px;
  line-height: 26px;
  font-size: 12px;
}
.el-table__empty-text,.el-table__empty-block{
    background: #181A20 !important;
  }
  .hover-row{
    background: #181A20 !important;
  }
  .el-table__body tr.hover-row>td{
     background: #181A20 !important;
  }
</style>
