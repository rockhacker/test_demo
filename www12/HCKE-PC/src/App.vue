<template>
  <div id="app">
    <div
      class="flex alcenter between plr20  ft14 white"
      style="height:60px;"
    >
      <div class="flex alcenter between h48 lh48 app">
		<div  class="pointer mr50 ht50 plr10 mt16 ">
			<img src="../static/imgs/wewe.png" style="width: 36px;height: auto;" @click="goHome"/>
		</div>

    <el-popover
      placement="bottom"
      trigger="hover"
      popper-class="bg-new-blue white border-none"
      :visible-arrow="false"
      v-model="show1"
      >
   <div  style="width:300px">
      <div class="tc ptb10 pointer flex between alcenter hbg plr20" @click="changeRouter(item)" v-for="item in transaction" :key="item.label">
        <div class="flex  alcenter">
         <img class="wt20 mr10" :src="item.img" alt="">
        <span>{{item.label}}</span>
       </div>
       <img src="./assets/images/arrow-right.png" style="width:20px" alt="" />
      </div>
    </div>
  <div class="mr25 white pointer flex alcenter" :class="{'routeractive':selectA!=''}" slot="reference">
    <span class="white">{{selectA || $t('add.jiaoyi')}}</span>
    <img class="pl10" :class="{'rotate':show1}" src="./assets/images/arrow-dowm.png" alt="" srcset="">
  </div>
</el-popover>

 <el-popover
      placement="bottom"
      trigger="hover"
      popper-class="bg-new-blue white border-none"
      :visible-arrow="false"
      v-model="show2"
      >
   <div style="width:300px">
              <div class="tc ptb10 pointer  flex between alcenter hbg plr20" @click="changeRouter(item)" v-for="item in lever" :key="item.label">
                 <div class="flex  alcenter">
                    <img style="width:16px" class="mr10" :src="item.img" alt="">
                    <span>{{item.label}}</span>
                 </div>
                 <img src="./assets/images/arrow-right.png" style="width:20px" alt="">
              </div>
          </div>
  <div class="mr25 white pointer flex alcenter" :class="{'routeractive':selectB!=''}" slot="reference">
    <span class="white">{{selectB || $t('assets.lever')}}</span>
    <img class="pl10"  :class="{'rotate':show2}" src="./assets/images/arrow-dowm.png" alt="" srcset="">
  </div>
</el-popover>
     

        <router-link
          :to="{ name: item.page }"
          class="mr25 white"
          style="white-space:nowrap;"
          v-for="(item, i) in listLeft"
          :key="i"
          v-if="item.show"
          >{{ item.name }}</router-link
        >
      </div>
      <div class="flex alcenter between">
        <!-- <a href="#" class="mr25" @click="toMoonPay">{{$t('header.moonPayRecharge')}}</a> -->
        <router-link
          :to="{ name: 'login' }"
          class="plr20 radius2 white login-btn"
          v-if="!account"
          >{{ $t("login.login") }}</router-link
        >
        <div class="plr20 pointer" style="white-space:nowrap;" v-else>
          <el-dropdown @command="personalLink">
            <span class="el-dropdown-link white">
              <i class="iconfont icon-zhanghao ft16" ></i>
              {{ account }}
              <i class="el-icon-arrow-down el-icon--right"></i>
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
          :to="{ name: 'register' }"
          class="ml10 plr20 radius2  login-btn bg-new-blue white"
          v-show="!account"
          >{{ $t("register.register") }}</router-link
        >
        <div class="pointer sepoi radius2  login-btn white" style="width: 100px;">
          <el-select v-model="langname" class="flex1 white" @change="changeLang">
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
      show1:false,
      show2:false,
      transaction:[
        // {
        //   label:this.$t('header.legal'),
        //   page:"/legalIndex/legal",
        //    img: require("./assets/images/fbjy.png")
        // },
        {
          label: this.$t('header.trade'),
          page: "/trade",
          img: require("./assets/images/bbjy.png")
        }
      ],
      lever:[
        {
          label:this.$t('new.jiao'),
          page: "/second",
           img: require("./assets/images/jghy.png")
        },
        {
          label: this.$t('new.yong'),
          page: "/lever",
          img: require("./assets/images/yxhy.png")
        },
        // {
        //   label: this.$t('new.contract'),
        //   page: "/optionct",
        //   img: require("./assets/images/qqhy.png")
        // },
      ],
      selectA:"",
      selectB:"",
      listLeft: [
        // {
        //   name: "首页",
        //   page: "home",
        //   show: true
        // },
        // {
        //   name:this.$t('new.jiao'),
        //   page: "second",
        //   show: true
        // },
        //   {
        //   name: this.$t('new.bigTrade'),
        //   page: "bigTrade",
        //   show: true
        // },
        {
          name: this.$t('staking.mining'),
          page: "staking",
          show: true
        },
        {
          name: this.$t('market.market'),
          page: "market",
          show: false
        },
        // {
        //   name: this.$t('header.legal'),
        //   page: "legalIndex",
        //   show: true
        // },
        // {
        //   name: this.$t('header.trade'),
        //   page: "trade",
        //   show: true
        // },
        // {
        //   name: this.$t('new.yong'),
        //   page: "lever",
        //   show: true
        // },
        // {
        //   name: this.$t('new.contract'),
        //   page: "optionct",
        //   show: true
        // },
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
        {
          name: this.$t('new.wdtg'),
          page: "invite",
          show: true
        },
        {
          name: this.$t('subscription.new_subscription'),
          page: "subscription",
          show: true
        },
        {
          name: this.$t('new.choz'),
          page: "recharge",
          show: true
        }
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
        { 
          name: "한국어",
          img: require("./assets/images/kr.png"), 
          value: "kr"
        },
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
		 { 
		  name: "عربي",
		  img: require("./assets/images/ar.png"), 
		  value: "ar"
		},
      {
      name: "Deutsche",
      img: require("./assets/images/de.png"),
      value: "de"
    },
      {
      name: "Italiano",
      img: require("./assets/images/it.png"),
      value: "it"
    },
      {
      name: "français",
      img: require("./assets/images/fr.png"),
      value: "fr"
    },
    {
      name: "繁體中文",
      img: require("./assets/images/xin.jpg"),
      value: "hk"
    },
    {
      name: "Türkçe",
      img: require("./assets/images/tr.png"),
      value: "tr"
    },
    {
      name: "Portugal",
      img: require("./assets/images/pt.png"),
      value: "pt"
    },
    // {
    //   name: "हिन्दी",
    //   img: require("./assets/images/hi.png"),
    //   value: "hi"
    // }
      ],
      lang: "en",
      langname: "",
      value:false,
      isShow:true,
      isHome:true,
      isLogin:false
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
          this.isLogin = newVal === '/login' || newVal === '/register'
          if(newVal ==='/legalIndex/legal' || newVal==='/trade'){
            this.selectA = this.transaction.find(item=>item.page===newVal).label
          }else{
            this.selectA=''
          }
           if(newVal ==='/second' || newVal==='/lever' || newVal==='/optionct'){
            this.selectB = this.lever.find(item=>item.page===newVal).label
          }else{
            this.selectB=''
          }
          console.log(this.isLogin,newVal);
          console.log(this.isHome,111)
	}
  },
  async created() {
    let theme = localStorage.getItem('theme') || 'dark';
    this.value= theme == 'light'?false:true;
    this.$utils.theme(theme);
    this.$store.commit('changeTheme',theme);
    await this.checkLogin()
    this.isHome = this.$route.path === '/home'
    console.log(this.isHome,222);
     this.isLogin = this.$route.path === '/login' || this.$route.path === '/register'

     if(this.$route.path ==='/legalIndex/legal' || this.$route.path==='/trade'){
            this.selectA = this.transaction.find(item=>item.page===this.$route.path).label
          }else{
            this.selectA=''
          }
           if(this.$route.path ==='/second' || this.$route.path==='/lever' || this.$route.path==='/optionct'){
            this.selectB = this.lever.find(item=>item.page===this.$route.path).label
          }else{
            this.selectB=''
          }
    window.addEventListener('setItem', ()=> {
          console.log(11)
          this.isShow=false
          this.$nextTick(function(){ 
          this.isShow=true 
        }) 
    })
    this.token = localStorage.getItem("token");
    console.log(this.token,222);
    console.log(localStorage.getItem("token"));

   

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
    else if(lang == "de"){
      this.langname = "Deutsche";
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
    }else if(lang == "tr"){
      this.langname = "Türkçe";
    }else if(lang == "pt"){
      this.langname = "Portugal";
    }
    else {
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
    async checkLogin(){
      await this.$http.initDataToken({
          url: 'check_login'
      },false).then(res=>{
        if(res.status ==0){
          localStorage.removeItem('token')
        }
      })
    },
    changeRouter(item){
      this.$router.push({path:item.page})
    },
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
				
				// this.loadScript("https://chat.cointigerex.cc/assets/layer/ai_service_diy_3.js");
						
				// this.$router.push({ name: "home" });
				console.log(page);
				if (page) {
				   this.$router.push({ path: page });
				  //this.$router.go(-1)
				}

        	// 客服参数
				// if(res && res.uid){
				// 	window.LiveChatWidget && window.LiveChatWidget.call('set_customer_name',res.uid)
				// }
        //  else {
				//   this.$router.push({ path: "/home" });
				// }
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

  },
  mounted(){
    if (this._isMobile()) {

	  window.location.href = `${location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, "//m.")}`;
    } else {

     //pc
    }
	if(this.token){
    this.getinfo();
  }
  }
};
</script>

<style lang="scss">
.rotate{
  transform: rotateX(180deg)
}

.hbg:hover{
  background-color: #8080803b;
}

.isHome{
background: none !important;position: absolute;z-index: 999;width:100%;top:0;
border-width: 0 !important;
}

.homeTitle{
  color: hsla(0,0%,100%,.8) !important;
}

.el-switch__label.is-active{
  color: #0066FC;
}

.el-switch.is-checked .el-switch__core{
  background: #0066FC !important;
  border-color:#0066FC !important;
}
.el-loading-spinner i {
    color:#0066FC !important;
}
.el-loading-spinner .el-loading-text {
  color:#0066FC !important;
}
.el-button--primary,.el-button--primary:active,.el-button--primary:focus,.el-button--primary:hover{
  color: white;
  background: #0066FC;
  border-color:#0066FC;
}
.el-button--primary.is-disabled{
  color: white;
  background: #0065fcbf;
  border-color:#0065fcbf;
}
.el-button--primary.is-disabled:focus,.el-button--primary.is-disabled:hover{
  color: white;
  background: #0065fcbf;
  border-color:#0065fcbf;
}
.el-checkbox__input.is-checked .el-checkbox__inner, 
.el-checkbox__input.is-indeterminate .el-checkbox__inner{
	background-color: #0066FC;
    border-color: #0066FC;
}
.el-checkbox__input.is-focus .el-checkbox__inner,
.el-checkbox__inner:hover{
	border-color: #0066FC;
}
.el-button:focus, .el-button:hover{
	color: white;
	/* border-color: #0066FC; */
	background-color: #0065fc31;
}
.el-dropdown-menu__item:focus, .el-dropdown-menu__item:not(.is-disabled):hover{
	background-color: #0066FC;
	color: white;
}
.el-checkbox__input.is-checked+.el-checkbox__label,
.el-select-dropdown__item.selected{
	color: #0066FC;
}
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  min-width: 1200px;
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
/* .el-input.is-active .el-input__inner, .el-input__inner:focus{
	border-color:#f5dab1;
.el-input__inner {
  border: none !important;
}
} */
.el-pagination.is-background .btn-next,
.el-pagination.is-background .btn-prev,
.el-pagination.is-background .el-pager li {
  background-color: #e5ebf5;
}
.el-pagination.is-background .el-pager li:not(.disabled).active {
    background-color: #0066FC;
    color: #FFF !important;
}
.el-pagination .el-pager li.active,
.el-pagination .el-pager li:hover{
	color: #0066FC !important;
}
.el-radio__input.is-checked+.el-radio__label {
    color: #0066FC;
}
.el-radio__input.is-checked .el-radio__inner {
    border-color: #0066FC;
    background: #0066FC;
}
.el-radio__inner:hover{
	border-color: #f0d535;
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
  color: black;
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
.el-card,.el-tag{
  border:0;
}

.dark{
  .el-table__body tr.hover-row>td {
    background-color: #16171C !important;
}
}
.dark{
.el-table--enable-row-hover .el-table__body tr:hover>td{
  background-color: #16171C !important;
}
.el-dialog__header,.el-dialog__body,.el-dialog__footer{
   background-color: #16171C !important;
   color: white;
}
.el-dialog__title{
  color: white;
}
}
.isLogin{
  position: absolute;
  top: 0;
  min-width: 100%;
  background: transparent !important;
}
.router-select{
  .el-input__inner{
    text-align: center;
    color: white;
    font-size: 14px;
  }
  // WebKit 谷歌
input::-webkit-input-placeholder {
    color: white;
}
// Mozilla Firefox 4 - 18 适配火狐
input:-moz-placeholder { 
    color: white;
}
// Mozilla Firefox 19+ 适配火狐
input::-moz-placeholder {
    color: white;
}
// IE 10+  
input:-ms-input-placeholder { 
    color: white;
}
.popper__arrow{
  display: none;
}
.el-scrollbar__wrap,.el-select-dropdown__item.hover, .el-select-dropdown__item:hover{
  color: white;
  background: linear-gradient(175deg, #67E1AB, #28C2C8) !important;
}
.el-select-dropdown__item{
  color: white;
}
.el-select-dropdown{
  border: none;
}
.el-select__caret{
  color: white;
}
.el-input__inner{
  border:none;
  padding-right: 0 !important;
}
}
</style>
