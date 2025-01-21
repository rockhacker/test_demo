<template>
  <div class="new-balck2">
    <div class="flex alcenter">
    <div class="footerSubs flex  column alcenter jscenter">
      <img src="../../static/imgs/wewe.png" style="height:80px;" />
      <div class="footerTag">Let's talk! 🤙</div>
      <p class="footerText">info@TEST.com</p>
      <div v-if="false" class="mt20">
        <a
          href="https://www.facebook.com/OEC-Open-Exchange-Crypto-111990511568166"
          target="_blank"
        >
          <img
            src="../assets/images/facebook.png"
            class="wt20 mr5"
            alt=""
            srcset=""
          />
        </a>
        <a
          href="https://instagram.com/openexchangecrypto?r=nametag"
          target="_blank"
        >
          <img
            src="../assets/images/instagram.png"
            class="wt20 mr5"
            alt=""
            srcset=""
          />
        </a>
        <a href="https://t.me/OEC_Exchange" target="_blank">
          <img
            src="../assets/images/telegram.png"
            class="wt20 mr5"
            alt=""
            srcset=""
          />
        </a>
        <a href="https://twitter.com/OECexchange" target="_blank">
          <img
            src="../assets/images/twitter.png"
            class="wt20"
            alt=""
            srcset=""
          />
        </a>
      </div>
    </div>
    <div  class="footerSubs flex white  around" style="padding-top:70px !important;">
      <div>
        <div class="footerListHead">{{$t('new.products')}}</div>
        <div class="footerLinks pointer mt10" v-for="(item,index) in listLeft.filter(item=>item.show)" :key="index" @click="toPage(item.page)">
          {{item.name}}
        </div>
        <div class="footerLinks pointer mt10" @click="handleClick()">
          {{$t('new.sbsq')}}
        </div>
      </div>
      <div class="ml20">
        <div class="footerListHead">{{$t('new.services')}}</div>
        <div class="footerLinks pointer mt10" v-for="(item,index) in listright.filter(item=>item.show)" :key="index" @click="toPage(item.page)">
          {{item.name}}
        </div>
        <div
            class="footerLinks pointer mt10"
            v-for="(item, index) in List2"
            :key="index"
            @click="goDetail(item.id, 31)"
          >
            {{ item.title }}
          </div>
      </div>
    </div>
    <!-- <div class="footerSubs flex2 white">
      <div class="mt20 ft40 bold">{{$t('new.hear')}}</div>
      <div class="footerText mtb20">{{$t('new.inputemail')}}</div>
      <div class="flex alcenter">
        <input class="bgwhite ptb5 plr10 mr10 radius12"  v-model="email" type="text"  :placeholder="$t('new.emailtext')" />
        <div class="footerbtn ptb5 plr10 mr10 radius12 black">{{$t('new.submittext')}}</div>
      </div>
    </div> -->
  </div>
  <div class="tc ptb20 white ft14">
        <p>©2022 TEST | All Rights Reserved. <a href="">Terms Of Service</a> | <a href="">Privacy Terms</a> </p>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      List1: [],
      List2: [],
      mobile: "",
      email: "",
      listLeft: [
        {
          name: this.$t("staking.mining"),
          page: "staking",
          show: true,
        },
        {
          name: this.$t("new.jiao"),
          page: "second",
          show: true,
        },
        {
          name: this.$t("market.market"),
          page: "market",
          show: false,
        },
        {
          name: this.$t("new.choz"),
          page: "recharge",
          show: true,
        },
        // {
        //   // name: this.$t('header.legal'),
        //   name: "OTC",
        //   page: "legalIndex",
        //   show: true
        // },
        {
          name: this.$t("header.trade"),
          page: "trade",
          show: true,
        },
        // {
        //   name: this.$t("new.yong"),
        //   page: "lever",
        //   show: true,
        // },
      ],
      listright: [
        // {
        //   name: this.$t('header.iso'),
        //   page: "isolever",
        //   show: true
        // },
        {
          name: this.$t("header.myshop"),
          page: "myshop",
          show: false,
        },
        {
          name: this.$t("header.assets"),
          page: "assets",
          show: true,
        },
        {
          name: this.$t("subscription.new_subscription"),
          page: "subscription",
          show: true,
        },

        // {
        //   name: this.$t("new.dsfcz"),
        //   page: "rechargeThirdParty",
        //   show: true,
        // },
        // {
        //   name: this.$t("new.fbtx"),
        //   page: "LegalWithdraw",
        //   show: true,
        // },
        // {
        //   name: this.$t('new.flzx'),
        //   page: "welfare",
        //   show: true
        // },
        // {
        //   name: this.$t("new.qd"),
        //   page: "signIn",
        //   show: true,
        // },
      ],
    };
  },
  created() {
    // this.getList1()
    this.getList2()
    // this.getConnect()
    // this.getConnect2()
  },
  methods: {
    handleClick(){
      this.$alert('info@TEST.com', {
          confirmButtonText: this.$t('login.e_confrim2'),
          callback: action => {
            // this.$message({
            //   type: 'info',
            //   message: `action: ${ action }`
            // });
          }
        });
    },
    tozn() {
      var lang = localStorage.getItem("lang");
      if (lang == "hk") {
        lang = "zh";
      } else {
        lang = "en";
      }
      window.open(`${this.$http._DOMAIN}/wp/fanyong_${lang}.pdf`);
    },
    togz() {
      // var lang = localStorage.getItem("lang");
      // if(lang == 'hk'){
      //   lang = 'zh'
      // }else{
      //   lang = 'en'
      // }
      window.open(`${this.$http._DOMAIN}/wp/fy.pdf`);
    },

    toPath() {
      var lang = localStorage.getItem("lang");
      if (lang == "hk") {
        lang = "zh";
      } else {
        lang = "en";
      }
      window.open(`${this.$http._DOMAIN}/wp/oec-${lang}.pdf`);
    },
    toPath() {
      var lang = localStorage.getItem("lang");
      if (lang == "hk") {
        lang = "zh";
      } else {
        lang = "en";
      }
      window.open(`${this.$http._DOMAIN}/wp/oec-${lang}.pdf`);
    },
    toPathPDF(urls) {
      let path = `../../static/${urls}.pdf`;
      window.open(path);
    },
    toPath2() {
      window.open(`../../static/guide_book.pdf`);
    },
    goline() {
      window.open("https://direct.lc.chat/12827847/");
    },
    govideo() {
      window.open(
        "https://exchange-hk.oss-cn-hongkong.aliyuncs.com/MetaUniverseGlobalcoin/upload/qly_1640247993000.MP4"
      );
    },
    getList1() {
      this.$http
        .initDataToken(
          {
            url: "news/list",
            data: { category_id: 31 },
          },
          false
        )
        .then((res) => {
          console.log(res.data);
          this.List1 = res.data;
        });
    },
    getList2() {
      this.$http
        .initDataToken(
          {
            url: "news/list",
            data: { category_id: 32 },
          },
          false
        )
        .then((res) => {
          this.List2 = res.data;
        });
    },
    // 详情
    goDetail(id, category_id) {
      this.$router.push({
        name: "notice",
        query: {
          id: id,
          category_id: category_id,
        },
      });
    },
    getConnect() {
      this.$http
        .initDataToken(
          {
            url: "default/setting",
            data: { key: "contact_mobile" },
          },
          false
        )
        .then((res) => {
          this.mobile = res;
        });
    },
    getConnect2() {
      this.$http
        .initDataToken(
          {
            url: "default/setting",
            data: { key: "contact_email" },
          },
          false
        )
        .then((res) => {
          this.email = res;
        });
    },
    goTicket() {
      console.log(11111);
      this.$router.push({
        name: "feedback",
      });
    },
    toPage(name) {
      console.log(name,22);
      this.$router.push({
        name
      });
    },
  },
};
</script>
<style scoped>
.alb {
  align-items: baseline;
}
.textitem {
  margin-top: 15px;
  cursor: pointer;
}

.footerSubs {
  flex: 1;
  min-height: 320px;
  padding: 40px 50px;
  border: 1px solid rgb(255, 255, 255, 0.1);
}

.footerTag {
  font-size: 22px;
  font-weight: 500;
  color: white;
  margin-bottom: 10px;
}

.footerText {
  font-size: 15px;
  color: rgb(180, 180, 180);
  margin-bottom: 15px;
}

.footerListHead {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
}

.footerLinks {
    font-size: 15px;
    color: rgb(220,220,220);
    font-weight: 400;
}

.footerbtn{
  background: rgb(255,200,0);
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
}
</style>
