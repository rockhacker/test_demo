<template>
  <div class="home">
    <div class="block myswiper">
      <img style="width: 100%;height: auto;" src="../assets/images/new-banner.png" alt="">
      <!-- <el-carousel height="540px">
        <el-carousel-item v-for="(item, i) in swipers" :key="i">
          <div class="block w100 h100 swiperhover bgheader">
            <img :src="item.banner" alt="" class="w100 h100" />
          </div>
        </el-carousel-item>
      </el-carousel> -->
    </div>
    <div class="mauto" style="border-radius: 10px;" v-if="marketlist.length">
      <swiper :options="swiperOption">
        <swiper-slide class="ptb40" 	v-for="(item, i) in marketlist" v-if="item.open_change == 1" :key="i">
          <div class="flex1">
			  <div class="ft20 tc">
				<span class="pr5">{{ item.name }}</span>
				<span class="">{{ item.symbol }}</span>
			  </div>
        <div class="c-pd tc">
          <span
				class="pr5 ft16"
				:class="{
				  red: parseFloat(item.currency_quotation.change) < 0,
				  green:
					parseFloat(item.currency_quotation.change) >= 0 ||
					item.currency_quotation.change == '',
				}"
				>$ {{ parseFloat(item.currency_quotation.close) }}</span
			  >

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
			 <i class=" ft14"  :class="{
				'red el-icon-caret-bottom': parseFloat(item.currency_quotation.change) < 0,
				'green el-icon-caret-top':
				  parseFloat(item.currency_quotation.change) >= 0 ||
				  item.currency_quotation.change == '',
			  }"></i>
			  <!-- <span class="ft12 baselight2">≈ {{ ((item.currency_quotation.close - 0) * (cny_rate - 0)) | toFixed2 }}CNY</span> -->
			</div>
			  
			</div>
        </swiper-slide>
      </swiper>
    </div>

    <div class="new-main contw">
      <p class="tc ft24 bold white">{{ $t("new.shijie") }}</p>
      <p class="tc mt14 ft14 white">
        {{ $t("new.all") }}
      </p>
      <div class="mt50 flex alcenter jscenter mauto tc">
        <div class="f-item f-right card-bg">
          <img src="../assets/images/qwrqwr.png" alt="" class="wt50" />
          <div class="mt5">
            <p class="bold ft16 mb20  white">{{ $t("new.an") }}</p>
            <!-- <p class="ft12 mb10 white">{{ $t("new.zai") }}</p> -->
            <!-- <p class="ft12">{{ $t("new.zhuan") }}</p> -->
          </div>
        </div>
        <div class="f-item f-right card-bg">
          <img src="../assets/images/wfegfbhrf.png" alt="" class="wt50" />
          <div class="mt5">
            <p class="bold ft16 mb20  white">{{ $t("new.shis") }}</p>
            <!-- <p class="ft12 mb10 white">
              {{ $t("new.wo") }}
            </p> -->
            <!-- <p class="ft12">{{ $t("new.zuo") }}</p> -->
          </div>
        </div>
        <div class="f-item card-bg">
          <img src="../assets/images/wegegbefbh.png" alt="" class="wt50" />
          <div class="mt5">
            <p class="bold ft16 mb20  white">{{ $t("new.hu") }}</p>
            <!-- <p class="ft12 mb10 white">{{ $t("new.jian") }}</p> -->
            <!-- <p class="ft12">{{ $t("new.li") }}</p> -->
          </div>
        </div>
      </div>
    </div>

    <div class="new-content-bg">
      
      <div class="mauto" style="width: 800px;">
        <div class="white ft30 bold" style="margin-top: 120px;">{{ $t("new.kai") }}</div>

        <div style="border:1px solid #0EB378; margin-top: 300px;border-radius: 8px;overflow: hidden;" class="flex w100">
          <div class="flex1 p20" style="background: rgba(1,21,13,0.9);">
            <p class="bold ft20 mb20 white">{{ $t("new.shou") }}</p>
          </div>
          <div class="bl1 flex1 p20" style="background: rgba(1,21,13,0.9);">
            <p class="bold ft20 white">{{ $t("new.you") }}</p>
          </div>
          <div class="bl1 flex1 p20" style="background: rgba(1,21,13,0.9);">
            <p class="bold ft20 white">{{ $t("new.ke") }}</p>
          </div>
        </div>

      </div>
      
    </div>

  

    <div class="downinfo pt30">
     
      <div class="flex alcenter mauto" style="width: 1000px;margin-top: 80px;">
        <div class="app-card">
          <div style="width: 60%;">
            <div class="ptb20 tc ft30">{{ $t("login.downApp") }}</div>
          <div class="tc ft14">{{ $t("home.c12") }}</div>

         <div class="card2-bg mlr20 pb40 mt20 radius10">
          <div class="flex alcenter jscenter pb10 mb20">
          
          <div style="background: linear-gradient(-26deg, #0E414E, #22414C);margin-right: 40px;" class="flex1 flex alcenter jscenter pt10" :class="{'new-main3':downType!=1}" @click="downType=1">
            <img
                class="item-img"
                src="../assets/images/Andriod@2x.png"
                alt=""
              />
              <span class="pl10 ft14">Andriod {{ $t("home.downs") }}</span>
            </div>

        <div style="background: linear-gradient(-26deg, #0E414E, #22414C);" class="flex1 flex alcenter jscenter pt10" :class="{'new-main3':downType!=2}" @click="downType=2">
          <img
                class="item-img"
                src="../assets/images/iOS@2x.png"
                alt=""
              />
              <span class="pl10 ft14">IOS {{ $t("home.downs") }}</span>
        </div>
       </div>

       <div class="flex jscenter">
        <vue-qr
        v-show="downType==1"
            text="https://needdown.youdao2kj.cc/bsetcoin/app.html"
            :margin="0"
            colorDark="#000000"
            colorLight="#fff"
            :size="140"
          />

              <vue-qr
              v-show="downType!=1"
                text="https://needdown.youdao2kj.cc/bsetcoin/app.html"
                :margin="0"
                colorDark="#000000"
                colorLight="#fff"
                :size="140"
              />

             
       </div>
       <div class="mt20 ft14 tc">
        {{ $t("new.gai") }}
      </div>
         </div>
          </div>

         <div  class="abstort" style="right: 0;top: -120px;">
          <img src="../assets/images/image@2x.png" style="width: 400px;border-radius: 17px;" alt="" />
          <!-- <div class="abstort rt0" style="top: 35%">
            <img src="../assets/images/exmobile.png" alt="" class="wt160" />
          </div> -->
        </div>
        </div>
        
      </div>
	 <div class="new-main2 pt10 pb20 new-company-bg">
    <div class="jieshao">
	         <span class="black ft20 bold plr20" style="background: #3DEBA1;">
              {{$t('new.jies')}}
           </span>
	         <div style="width: 600px;" class="content mtb20" v-html="$t('new.jiec')"></div>
           <!-- <img class="w80 mt50" style="height: auto;" src="../../static/imgs/pz.jpg" alt=""> -->
			<!-- <video id="myVideo" class="mt50 w100" src="https://exchange-hk.oss-cn-hongkong.aliyuncs.com/MetaUniverseGlobalcoin/upload/qly_1640247993000.MP4" controls="controls" ></video> -->
	  </div>
   </div>
    </div>
    
    <footerComponet></footerComponet>
  </div>
</template>
<script>
import footerComponet from '@/components/footer'

import vueQr from "vue-qr";
export default {
    components:{footerComponet,vueQr },
    data(){
        return{

          swiperOption: {
            loop:true,
            slidesPerView:6,
            allowTouchMove:false,
            speed:20000,
          autoplay:{
            delay:0
          }
    		},
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
			announcementModal:{},
      downType:1
        }
    },
    filters: {
		toFixed2: function(value, options) {
			value = Number(value);
			return value.toFixed(2);
		}
	},
  computed:{
    swiper() {
        return this.$refs.mySwiper.swiper
      }
  },
    created(){
       this.quotation()
       this.bindSocket()
       this.getNoticeList()
       this.getBanner()
      //  this.getDownurl()
      //  this.setApp()
	  //  this.downUrl=`${location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, "//m2.")}/app`;
      //  this.downUrl = 'https://needdown.youdao2kj.cc/Bsetcoin/app.html'
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
			location.href=`${location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, "//m.")}/app`;
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
.p20{
 padding: 20px;
 padding-top: 30px;
}

.new-company-bg{
  margin-top: 60px;
  background-image: url(../assets/images/company-desc-bg.png);
  background-repeat: no-repeat;
  background-size: 100% 100%;
  width: 100%;
  height: 400px;
}

.new-content-bg{
  background-image: url(../assets/images/start-digital-bg.png);
  background-repeat: no-repeat;
  background-size: 100% 100%;
  width: 100%;
  height: 600px;
}

.swiper-slide{
  border:1px solid #0EB378;
  border-width: 1.5px 1px;
}

.now-login{
  width: 272px;
height: 50px;
background: #00C162;
border-radius: 35px;
line-height: 50px;
text-align: center;
font-size: 19px;
}

.new-register{
  width: 272px;
height: 50px;
background: #359CD6;
border-radius: 35px;
line-height: 50px;
text-align: center;
font-size: 19px;
}

.app-card{
  position: relative;
  margin-top: 40px;
  width: 100%;
height: 440px;
border: 1px solid #0EB378;
border-radius: 20px;
}

.bl1{
  border-left: 1px solid #0EB378;
}
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
    /* text-align: center; */
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