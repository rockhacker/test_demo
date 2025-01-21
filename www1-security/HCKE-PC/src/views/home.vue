<template>
  <div class="home">
    <div class="block myswiper">
      <el-carousel height="393px">
        <el-carousel-item v-for="(item, i) in swipers" :key="i">
          <!-- <img :src="item" alt="" class="w100 ht200"> -->
          <div class="block w100 h100 swiperhover bgheader">
            <img :src="item.banner" alt="" class="w100 h100" />
          </div>
        </el-carousel-item>
      </el-carousel>
    </div>
	<div class="bgpart bgseca">
		<div class="wt1200 mauto flex jscenter">
		  <div
			class="plr10 markethover ptb15 marbg w23"
			v-for="(item, i) in marketlist"
			:key="i"
			v-if="i < 5 && item.open_change == 1"
		  >
			<div class="flex alcenter between w100">
			  <div class="ft20">
				<span class="pr5">{{ item.name }}</span>
				<span class="">{{ item.symbol }}</span>
			  </div>
			   <span
			  class="ft14"
			  :class="{
				red: parseFloat(item.currency_quotation.change) < 0,
				green:
				  parseFloat(item.currency_quotation.change) >= 0 ||
				  item.currency_quotation.change == '',
			  }"
			  >{{ item.currency_quotation.change >= 0 ? "+" : ""
			  }}{{ (item.currency_quotation.change - 0) | toFixed2 }}%</span>
			</div>
			<div class="c-pd">
			  <span
				class="pl5 ft16"
				:class="{
				  red: parseFloat(item.currency_quotation.change) < 0,
				  green:
					parseFloat(item.currency_quotation.change) >= 0 ||
					item.currency_quotation.change == '',
				}"
				>$ {{ parseFloat(item.currency_quotation.close) }}</span
			  >
			  <!-- <span class="ft12 baselight2">≈ {{ ((item.currency_quotation.close - 0) * (cny_rate - 0)) | toFixed2 }}CNY</span> -->
			</div>
		   
			<!-- <div class="pt15">
			  <span class="ft12 baselight"
				>{{ $t("market.volume") }}
				{{ item.currency_quotation.volume }}</span
			  >
			</div> -->
		  </div>
		</div>
	</div>
	<!-- <div class="notice_box bgf6 flex jscenter ptb15 w100 ft14 basegray">
      <div>
        <span
          class="plr20"
          v-for="(item, index) in noticeList"
          :key="index"
          @click="goDetail(item.id)"
          >{{ item.title }}</span
        >
      </div>
    </div> -->
    <div class="bgwhite contw bggred">
      <!-- <div class="logos">
          <div class="f-right f-item" @click="toLogo('https://www.binance.com')">
            <img src="../assets/images/nav-logo.svg" alt="" >
          </div>
        <div class="f-right f-item"  @click="toLogo('https://www.coinbase.com')">
          <img src="../assets/images/Consumer_Wordmark.svg" alt="" >
        </div>
       
       <div class="f-item" @click="toLogo('https://www.bitflyer.com')">
          <img src="../assets/images/logo_h.png" alt="" >
       </div>
      </div> -->
      <p class="tc ft24 bold">{{ $t("new.shijie") }}</p>
      <p class="tc mt14 ft14">
        {{ $t("new.all") }}
      </p>
      <div class="mt50 flex alcenter jscenter mauto tc">
        <div class="f-item f-right">
          <img src="../assets/images/qwrqwr.png" alt="" class="wt50" />
          <div class="mt5">
            <p class="bold ft16 mb20 title">{{ $t("new.an") }}</p>
            <p class="ft12 mb10">{{ $t("new.zai") }}</p>
            <p class="ft12">{{ $t("new.zhuan") }}</p>
          </div>
        </div>
        <div class="f-item f-right">
          <img src="../assets/images/wfegfbhrf.png" alt="" class="wt50" />
          <div class="mt5">
            <p class="bold ft16 mb20 title">{{ $t("new.shis") }}</p>
            <p class="ft12 mb10">
              {{ $t("new.wo") }}
            </p>
            <p class="ft12">{{ $t("new.zuo") }}</p>
          </div>
        </div>
        <div class="f-item">
          <img src="../assets/images/wegegbefbh.png" alt="" class="wt50" />
          <div class="mt5">
            <p class="bold ft16 mb20 title">{{ $t("new.hu") }}</p>
            <p class="ft12 mb10">{{ $t("new.jian") }}</p>
            <p class="ft12">{{ $t("new.li") }}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="bgwhite contw bgpart contbg">
      <p class="tc ft28 bold">{{ $t("new.kai") }}</p>

      <div class="mt50 flex alcenter jscenter mauto tc">
        <div class="f-item f-right m-item" :class="lang">
          <img src="../assets/images/ghfnghmh.png" alt="" class="wt50" />
          <div class="mt20">
            <p class="bold ft16 mb20 title">{{ $t("new.shou") }}</p>
            <p class="ft12 mb10">{{ $t("new.shi") }}</p>
            <p class="ft12">{{ $t("new.fe") }}</p>
          </div>
        </div>
        <div class="f-item f-right m-item" :class="lang">
          <img src="../assets/images/hmhgm.png" alt="" class="wt50" />
          <div class="mt20">
            <p class="bold ft16 mb20 title">{{ $t("new.you") }}</p>
            <p class="ft12 mb10">{{ $t("new.hui") }}</p>
            <p class="ft12">{{ $t("new.xiang") }}</p>
          </div>
        </div>
        <div class="f-item m-item" :class="lang">
          <img src="../assets/images/gnhmnh.png" alt="" class="wt50" />
          <div class="mt20">
            <p class="bold ft16 mb20 title">{{ $t("new.ke") }}</p>
            <p class="ft12 mb10">{{ $t("new.quan") }}</p>
            <p class="ft12">{{ $t("new.di") }}</p>
          </div>
        </div>
      </div>
      <!-- <button class="k-btn" @click="toPath">{{ $t("new.yi") }}</button> -->
    </div>
    <div class="downinfo bggred pt30 pb90">
      <div class="tc ft24 bold">{{ $t("home.c12") }}</div>
      <div class="mt20 ft14 tc">
        {{ $t("new.gai") }}
      </div>
      <div class="alcenter mt30 w70 mauto">
        <div class="flex jscenter">
          <div class="pl10 flex">
            <el-popover
              placement="top"
              trigger="click">
              <vue-qr
                  :text="downUrl"
                  :margin="0"
                  colorDark="#000000"
                  colorLight="#fff"
                  :size="140"
                />
              <div class="flex alcenter mb30 f-right d-item ngh"
              :class="lang + 1"
              @click="setImg('img1')" slot="reference"> 
                <div class="wt40 ht40 flex alcenter jscenter radius50p tc">
                <img
                  class="item-img"
                  src="../assets/images/Andriod@2x.png"
                  alt=""
                />
              </div>
              <span class="pl10 ft14">Andriod {{ $t("home.downs") }}</span>
              </div>
            </el-popover>
            <!-- <div
              class="flex alcenter mb30 f-right d-item ngh"
              :class="lang + 1"
              @click="setImg('img1')"
            >
              <div
                class="qeImg bdblue plr10 ptb10 bgblue2 inblock"
                v-show="img1"
              >
                <vue-qr
                  :text="downUrl"
                  :margin="0"
                  colorDark="#000000"
                  colorLight="#fff"
                  :size="140"
                ></vue-qr>
              </div>
              <div class="wt40 ht40 flex alcenter jscenter radius50p tc">
                <img
                  class="item-img"
                  src="../assets/images/Andriod@2x.png"
                  alt=""
                />
              </div>
              <span class="pl10 ft14">Andriod {{ $t("home.downs") }}</span>
            </div> -->
            <el-popover
              placement="top"
              trigger="click">
              <vue-qr
                  :text="downUrl"
                  :margin="0"
                  colorDark="#000000"
                  colorLight="#fff"
                  :size="140"
                />
              <div class="flex alcenter mb30 f-right d-item ngh"
              :class="lang + 1"
              @click="setImg('img2')" slot="reference"> 
                <div class="wt40 ht40 flex alcenter jscenter radius50p tc">
                <img
                  class="item-img"
                  src="../assets/images/iOS@2x.png"
                  alt=""
                />
              </div>
              <span class="pl10 ft14">IOS {{ $t("home.downs") }}</span>
              </div>
            </el-popover>
            <div
              class="flex alcenter mb30 f-right d-item ngh"
              :class="lang + 1"
              @click="downLoad"
            >
              <span class="pl10 ft14">{{ $t("login.downApp") }}</span>
            </div>
            <!-- <el-popover
              placement="top"
              trigger="click">
              <vue-qr
                  :text="downUrl"
                  :margin="0"
                  colorDark="#000000"
                  colorLight="#fff"
                  :size="140"
                />
              <div class="tc d-item ngh"
              :class="lang + 1"
              @click="setImg('img3')" slot="reference"> 
                <p class="ft14">{{ $t("new.zhai") }}</p>
              </div>
            </el-popover> -->
            <!-- <div
              class="tc d-item ngh"
              :class="lang + 1"
              @click="setImg('img3')"
            >
              <div
                class="qeImg bdblue plr10 ptb10 bgblue2 inblock"
                v-show="img3"
              >
                <vue-qr
                  :text="downUrl"
                  :margin="0"
                  colorDark="#000000"
                  colorLight="#fff"
                  :size="140"
                ></vue-qr>
              </div>

              <p class="ft14">{{ $t("new.zhai") }}</p>
            </div> -->
          </div>
        </div>
        <div class="flex1 tc posRelt">
          <img src="../assets/images/image@2x.png" alt="" class="w80" />
          <!-- <div class="abstort rt0" style="top: 35%">
            <img src="../assets/images/exmobile.png" alt="" class="wt160" />
          </div> -->
        </div>
      </div>
	  <div class="jieshao">
	         <h1 class="title">{{$t('new.jies')}}</h1>
	         <div class="content" v-html="$t('new.jiec')"></div>
           <!-- <img class="w80 mt50" style="height: auto;" src="../../static/imgs/pz.jpg" alt=""> -->
			<!-- <video id="myVideo" class="mt50 w100" src="https://exchange-hk.oss-cn-hongkong.aliyuncs.com/MetaUniverseGlobalcoin/upload/qly_1640247993000.MP4" controls="controls" ></video> -->
	  </div>
    </div>
    <footerComponet></footerComponet>
  </div>
</template>
<script>
import footerComponet from '@/components/footer'
import vueQr from "vue-qr";
export default {
    components:{footerComponet,vueQr},
    data(){
        return{
            swipers:[],
            marketlist:[
                // {name:'比特币',symbol:'BTC/USDT',change:'-2.0',close:'123',cny:'23434',volume:'773777'},
                // {name:'以太坊',symbol:'ETH/USDT',change:'2.0',close:'222',cny:'555',volume:'33333'},
                // {name:'柚子',symbol:'EOS/USDT',change:'-6.0',close:'123',cny:'23434',volume:'666666666'}
            ],
            cny_rate:'',
            usd_rate:'',
            noticeList:[],
            downUrl:'',
            img1:false,
            img2:false,
            img3:false,
            lang:'en',
			announcementModal:{}
        }
    },
    filters: {
		toFixed2: function(value, options) {
			value = Number(value);
			return value.toFixed(2);
		}
	},
    created(){
       this.quotation()
       this.bindSocket()
       this.getNoticeList()
       this.getBanner()
       this.getDownurl()
       this.setApp()
	   this.downUrl=`${location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, "//m2.")}/app`;
       this.lang = localStorage.getItem("lang")||'en';
	   this.getAnnouncement()
    },
    methods:{
		getAnnouncement() {
			try {
				const that = this;
				that.$http.initDataToken({
					url: "news/list?category_id=0"
				},false).then( res => {
					if (res.data.length && res.data[0].content) {
						that.$alert(res.data[0].content, res.data[0].title,{
							showConfirmButton:false,
							center:true,
							dangerouslyUseHTMLString:true,
							customClass:'announcement'
						});
					}
				});
			} catch (e) {
				console.log(e);
				//TODO handle the exception
			}
		},
      toLogo(val){
        window.open(val)
      },
      toUrl(item){
         localStorage.setItem(
        "leverData",
        JSON.stringify(item)
      );
         this.$router.push({
           path:'/lever',
         })
      },
        toPath(){
          this.$router.push('/lever')
        },
        setImg(val){
           this[val]=this[val]?false:true;
        },
        setApp(){
            let lang=localStorage.getItem('lang')
            if(lang=='jp'){
                // this.downUrl='//api.5global.com/app/japanapp/'
            }else{
                // this.downUrl='//api.mql5global.com/app/app/'
            }
        },
		downLoad(){
			location.href=`${location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, "//m2.")}/app`;
		},
        //行情交易对
		quotation() {
            this.$http.initDataToken({
                url: 'market/currency_matches'
            },false).then(res=>{
                console.log(res)
                let usdtData = res.find(item => item.code == 'USDT');
                this.cny_rate = usdtData.cny_price;
				this.usd_rate = usdtData.usd_price;
				this.marketlist = usdtData.matches;
				// this.marketlist = usdtData.matches.sort(function(a, b) {
				// 	return b.currency_quotation.change - a.currency_quotation.change;
    //             });
                console.log(this.marketlist)
            })
        },
        // 链接socket
        bindSocket(){
            var that=this;
            that.$socket.connected((socket)=>{
                socket.send({type: "sub", params: "DAY_MARKET"});
                socket.on('DAY_MARKET',msg=>{
                    for (var i = 0; i < this.marketlist.length; i++) {
                        if (this.marketlist[i].id == msg.currency_match_id) {
                            this.marketlist[i].currency_quotation.close = msg.quotation.close;
                            this.marketlist[i].currency_quotation.change = msg.quotation.change;
                        }
                    }
                })
            })
        },
        //公告
		getNoticeList() {
             this.$http.initDataToken({
                url: 'news/list',
                data: { category_id: 22 }
            },false).then(res=>{
               this.noticeList = res.data;
            })
        },
         // 公告详情
        goDetail(id) {
            this.$router.push({
                name: "notice",
                query: { 
                    id: id,
                    category_id: 22
                }
            });
        },
        buy(type){
            console.log(type)
            if(type==1){
                this.$router.push({
                    name: "buy",
                    query: { 
                        // id: id,
                        // category_id: category_id
                    }
                });
            }
        },
         //轮播图
		getBanner() {
             this.$http.initDataToken({
                url: 'news/list',
                data: { category_id: 23 }
            },false).then(res=>{
               this.swipers = res.data;
            })
        },
         getDownurl(){
            this.$http.initDataToken({url:'default/setting',data:{key:'app_download_url'}},false)
            .then(res=>{
                this.downUrl=res;
            })
        },
        unbindSocket(){
            this.$socket.send({type: "unsub", params: "DAY_MARKET"});
        },
    },
    beforeRouteLeave(to, from, next){
        next();
        this.unbindSocket();
    }
}
</script>
<style lang="scss" scoped>
/* .el-carousel__container{
    min-height: 460px;
} */
/* .myswiper img{
        min-height: 460px;
    } */
.downinfo {
  min-height: 700px;
}
.notice_box {
  > div {
    overflow: hidden;
    word-break: keep-all;
    text-align: center;
    span {
      display: inline-block;
      position: relative;
      padding: 0 2em 0 1.5em;
      cursor: pointer;
    }
    span:before {
      content: "/";
      position: absolute;
      left: -0.5em;
      color: #54748f;
    }
    span:nth-child(1):before {
      content: "";
    }
    span:hover {
      color: #357ce1;
    }
  }
}
.markethover {
  // width: 166px;
  // height: 144px;

  border-radius: 10px;
  margin-right: 18px;
  display: flex;
  justify-content: center;
  flex-direction: column;
  align-items: flex-start;
  cursor: pointer;
}
.bgseca>.markethover:last-child{
  margin-right:0;
}
.baselight2 {
  font-size: 18px;
  border: 1px solid #EEEEEE;
  width:116px;
  height:30px;
  text-align:center;
  line-height:30px;
}
.base1 {
  font-size: 28px;
  font-weight:bold;
}
.contbg {
  text-align: center;
}
.contw {
  padding: 48px 0 57px;
}
.f-item {
  width: 289px;
  height: 226px;
  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  padding: 0 10px;
}
.f-item img{
  width:90px;
  height:90px;
}
.f-right {
  margin-right: 20px;
}
.f-right.m-item{
   margin-right: 14px;
}
.m-item {
  width: 226px;
  height: 260px;
}
.k-btn {
  width: 178px;
  height: 56px;
  line-height:56px;
  border-radius: 20px;
  text-align: center;
  position: relative;
  font-size:20px;
  top: 28px;
  cursor: pointer;
  color:#fff;
  background: url('../assets/images/hmghmjh.png') no-repeat left top /100% 100%;
}
.d-item {
  width: 188px;
  height: 68px;

  border-radius: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
  position: relative;
}
.qeImg {
  position: absolute;
  top: -168px;
}
.item-img {
  width: 46px;
  height: 46px;
}
.w80 {
  width: 650px;
  height: 325px;
}
.en {
  width: 326px !important;
}
.en1 {
  width: 250px;
}
.jp {
  width: 326px !important;
}
.jp1 {
  width: 250px;
}
.c-pd{
  padding:8px 0 5px;
}
.bgseca{
  padding:44px 20px;
}
.mt14{
  margin-top:14px;
}
.title{
  font-weight:bold;
  background: linear-gradient(55deg, #8161FF 43%, #24AEFF 48.24219%, #6A74FF 57.16992%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-size:18px;
  }
  .logos {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100px;
    margin:0 0 50px;
  }
  .logos .f-item{
    width: 289px;
    height: 100px;
    border-radius: 0;
    cursor: pointer;
  }
  .logos img{
    width: 80%;
    height: auto;
  }
  .jieshao{
    width: 907px;
    margin:0 auto;
    text-align: center;
    margin-top:50px;
  }
  .jieshao>.title{
    padding-bottom:50px;
  }
</style>
<style type="text/css">
	.announcement {
		width: 600px;
	}
	.announcement .el-message-box__content{
		max-height: 480px;
		overflow-y: auto;
	}
</style>