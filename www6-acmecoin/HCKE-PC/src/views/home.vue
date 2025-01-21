<template>
  <div class="home">
    <div class="block myswiper">
      <el-carousel height="501px">
        <el-carousel-item v-for="(item, i) in swipers" :key="i">
          <!-- <img :src="item" alt="" class="w100 ht200"> -->
          <div class="block w100 h100 swiperhover bgheader">
            <img :src="item.banner" alt="" class="w100 h100" @click="toPage(item)" />
          </div>
        </el-carousel-item>
      </el-carousel>
    </div>
    <div class="ptb50 bg-box" v-if="marketlist.length">
		<div class="wt1200 mauto  black border-liner">
    

      <div class="flex">
        <div class="flex1" v-for="(list,oIndex) in marketlist" :key="oIndex">
      
        <div class="text-96A1C2 ptb20 pointer posRelt"  @click="toUrl(list.matches[0])">
          <div class="flex alcenter plr20">
            <img class="wt30 radius50p" :src="list.matches[0].base_currency.logo" alt="" srcset="">
            <div class="ft18 ml20"> {{list.matches[0].symbol}}</div>
          </div>
          <div class="flex ml50">
            <div class="ft38"> {{parseFloat(list.matches[0].currency_quotation.close)}}</div>
           <div class="ft38 ml40 ">
            {{ list.matches[0].currency_quotation.change >= 0 ? "+" : ""}}{{ (list.matches[0].currency_quotation.change - 0) | toFixed2 }}%
          </div>
          </div>
          <div class="flex betwewn ft14 bold">
            <div class="flex1 tc">{{$t('market.high')}}:{{ list.matches[0].currency_quotation.high }}</div>
            <div class="flex1 tc">{{$t('market.latest')}}:{{ list.matches[0].currency_quotation.low }}</div>
            <div class="flex1 tc">{{$t('trade.changes')}}:{{ list.matches[0].currency_quotation.change >= 0 ? "+" : ""}}{{ (list.matches[0].currency_quotation.change - 0) | toFixed2 }}%</div>
            <div class="flex1 tc">{{$t('market.volume')}}:{{ list.matches[0].currency_quotation.volume || "0.00" | filterDecimals }}</div>
          </div>
          <min-chart class="wt1200 ht20 mauto abstort btm0" transparent :symbol="list.matches[0].lower_symbol" color="#2C4A6B" :id="-1" />
        </div>
          <div class="bg-box2 ptb10 plr10">
          <span class="active2px ft20">{{oIndex==1? $t('new.ysqhq'):list.code}}</span>
        </div>
          <div class="flex ht30 alcenter  white ptb10" style="border-bottom: 1px solid #2C4A6B;">
        <div class="flex1 tc ft16">{{$t('trade.currency')}}</div>
        <div class="flex1 tc ft16">{{$t('lever.price')}}</div>
        <div class="flex1 tc ft16">{{$t('trade.changes')}}</div>
        <!-- <div class="flex1 tc ft16">{{$t('market.high')}}</div>
        <div class="flex1 tc ft16">{{$t('market.low')}}</div> -->
        <div class="flex1 tc ft16">{{$t('market.market')}}</div>
        <!-- <div class="flex1 tc ft16">24H{{$t('trade.cj_total')}}(USDT)</div> -->
        <!-- <div class="flex1"></div> -->
      </div>
           <div class="flex ptb20 pointer white" style="border-bottom: 1px solid #2C4A6B;" v-for="(item,index) in list.matches.length<4?list.matches:list.matches.slice(0,4)" :key="index"  @click="toUrl(item)">
          <div class="flex1 tc ft16 flex alcenter">
             <img class="wt30 radius50p mlr10" :src="item.base_currency.logo" alt="" srcset=""></img>
            <span>{{item.symbol}}</span>
          </div>
          <div class="flex1 tc ft16">
            {{parseFloat(item.currency_quotation.close)}}
          </div>
          <div class="flex1 tc ft16">
            <span
			  :class="{
				red: parseFloat(item.currency_quotation.change) < 0,
				green:
				  parseFloat(item.currency_quotation.change) >= 0 ||
				  item.currency_quotation.change == '',
			  }"
			  >{{ item.currency_quotation.change >= 0 ? "+" : ""
			  }}{{ (item.currency_quotation.change - 0) | toFixed2 }}%</span>
         <img v-if="item.currency_quotation.change >= 0" src="../assets/images/up.png" alt="">
         <img v-else src="../assets/images/down.png" alt="">
          </div>
          <!-- <div class="flex1 tc ft16">
            {{item.currency_quotation.high}}
          </div>
          <div class="flex1 tc ft16">
            {{item.currency_quotation.low}}
          </div> -->
           <div class="flex1 tc">
           <min-chart class="wt120 ht20 mauto" :symbol="item.lower_symbol" :color="parseFloat(item.currency_quotation.change) < 0?'#E95463':'#00AB86'" :id="index" />
          </div>
           <!-- <div class="flex1 tc ft16">
            {{item.currency_quotation.volume}}
          </div> -->
          <!-- <div class="flex1 tc">
            <span class="pointer ft16 border-2DBD96 text-2DBD96 plr10 radius6">
              {{$t('trade.buy1')}}/{{$t('trade.sell1')}}
            </span>
          </div> -->
        </div>
        </div>
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
    <div class="bg-box2 mt50  contw  wt1200 mauto  black flex column jscenter alcenter mb20" style="border-radius: 20px 20px 0px 0px;">
       <div class="flex alcenter jscenter">
        <img class="wt120" src="/static/imgs/red-line.png" alt="" srcset="">
        <span class="tc ft28 bold plr20 white">{{ $t("new.shijie") }}</span>
         <img class="wt120" style="transform: rotateY(180deg);" src="/static/imgs/red-line.png" alt="" srcset="">
      </div>
      <p class="tc mt14 ft16 text-96A1C2">
        {{ $t("new.all") }}
      </p>
    </div>

    <div class="bg-box2  contw  wt1200 mauto  black flex column jscenter alcenter mt30 mb50" style="border-radius: 0px 0px 20px 20px;">
      <div class="flex alcenter">
        <div class="posRelt pb90">
              <div class="white ft24 tr">{{ $t("new.an") }}</div>
              <p class="ft12 mb10 white tr">{{ $t("new.zai") }}</p>
              <div class="abstort bg-blue2 radius50p wt80 ht80 flex alcenter jscenter" style="right:-100px;top:-10px">
                <img class="" src="/static/imgs/aqkk.png" alt=""/>
              </div>
          </div>
          <img class="mt20" src="/static/imgs/jieshao1.png" alt="">
           <div class="ml20 posRelt">
              <div class="white ft24">{{ $t("new.shis") }}</div>
              <p class="ft12 mb10 white"> {{ $t("new.wo") }}</p>
              <p class="ft12 white">{{ $t("new.zuo") }}</p>
               <div class="abstort bg-blue2 radius50p wt80 ht80 flex alcenter jscenter" style="left:-100px;top:-10px">
                <img class="" src="/static/imgs/sjst.png" alt=""/>
              </div>
          </div>
      </div>
        <div class="posRelt" style="margin-right: 300px;">
            <div class="white ft24 tc">{{ $t("new.hu") }}</div>
            <p class="ft12 mb10 white">{{ $t("new.jian") }}</p>
            <p class="ft12 white">{{ $t("new.li") }}</p>
            <div class="abstort bg-blue2 radius50p wt80 ht80 flex alcenter jscenter" style="right:-100px;top:-10px">
                <img class="" src="/static/imgs/yhzs.png" alt=""/>
              </div>
        </div>
    </div>


    <div class="bg-box contw contbg">
      <div class="flex alcenter jscenter">
        <img src="/static/imgs/green-line.png" alt="" srcset="">
        <span class="tc ft28 bold plr20 white">{{ $t("new.kai") }}</span>
         <img style="transform: rotateY(180deg);" src="/static/imgs/green-line.png" alt="" srcset="">
      </div>

      <div class="mt50 flex alcenter jscenter mauto tc">
        <div class="bg-box2 f-right m-item radius8 pt20">
          <img src="../assets/images/ghfnghmh.png" alt="" class="wt50" />
          <div class="mt20">
            <p class="bold ft16 mb20 white">{{ $t("new.shou") }}</p>
            <p class="ft12 mb10 text-96A1C2">{{ $t("new.shi") }}</p>
            <p class="ft12 text-96A1C2">{{ $t("new.fe") }}</p>
          </div>
        </div>
        <div class="f-right m-item bg-box2 radius8 pt20">
          <img src="../assets/images/hmhgm.png" alt="" class="wt50" />
          <div class="mt30">
            <p class="bold ft16 mb20 white">{{ $t("new.you") }}</p>
            <p class="ft12 mb10 text-96A1C2">{{ $t("new.hui") }}</p>
            <p class="ft12 text-96A1C2">{{ $t("new.xiang") }}</p>
          </div>
        </div>
        <div class="m-item bg-box2 radius8 pt20">
          <img src="../assets/images/gnhmnh.png" alt="" class="wt50" />
          <div class="mt20">
            <p class="bold ft16 mb20 white">{{ $t("new.ke") }}</p>
            <p class="ft12 mb10 text-96A1C2">{{ $t("new.quan") }}</p>
            <p class="ft12 text-96A1C2">{{ $t("new.di") }}</p>
          </div>
        </div>
      </div>
      <!-- <button class="k-btn" @click="toPath">{{ $t("new.yi") }}</button> -->
    </div>
    <div class="bg-box2 pt30 pb30" style="background-image: url(/static/imgs/download-bg.png);">
    
     <div class="flex  jscenter">
     <img src="../assets/images/image@2x.png" />
     <div class="flex column between">
        <div class="pt60">
          <div class="tc ft24 bold white">{{ $t("home.c12") }}</div>
       <div class="mt20 ft14 tc white">
        {{ $t("new.gai") }}
      </div>
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
              <div class="flex column alcenter mb30 f-right d-item"
              :class="lang + 1"
              @click="setImg('img1')" slot="reference"> 
                <div class="wt40 ht40 flex alcenter jscenter radius50p tc">
                <img
                  class="item-img"
                  src="../assets/images/Andriod@2x.png"
                  alt=""
                />
              </div>
              <span class="pt10 ft14 white">Andriod {{ $t("home.downs") }}</span>
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
              <div class="flex column alcenter mb30 f-right d-item"
              :class="lang + 1"
              @click="setImg('img2')" slot="reference"> 
                <div class="wt40 ht40 flex alcenter jscenter radius50p tc">
                <img
                  class="item-img"
                  src="../assets/images/iOS@2x.png"
                  alt=""
                />
              </div>
              <span class="pt10 ft14 white">IOS {{ $t("home.downs") }}</span>
              </div>
            </el-popover>
            <div
              class="flex column alcenter mb30 f-right d-item"
              :class="lang + 1"
              @click="downLoad"
            >
               <img
                  class="item-img"
                  src="../assets/images/download.png"
                  alt=""
                />
              <span class="pt10 ft14 white">{{ $t("login.downApp") }}</span>
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
      </div>
     </div>
     </div>

	 
    </div>
    <div class="bg-box pt50 pb30">
     
       <div>
         <div class="flex alcenter jscenter">
        <img src="/static/imgs/green-line.png" alt="" srcset="">
        <span class="tc ft28 bold plr20 white">{{$t('new.jies')}}</span>
         <img style="transform: rotateY(180deg);" src="/static/imgs/green-line.png" alt="" srcset="">
      </div>
	         <!-- <h1 class="title">{{$t('new.jies')}}</h1> -->
	    <div class="content mauto mt30 text-96A1C2" style="width:900px" v-html="$t('new.jiec')"></div>
        <!-- <div class="flex column alcenter jscenter">
          <img class="mt50" style="height: 600px;width: 500px;" src="../../static/imgs/pz.jpg" alt=""></img>
        </div> -->
			
	  </div>
    <div class="flex alcenter mt40">
      <video id="myVideo" class="mb20 w70 mauto" src="https://api.TESTltd.com/wp/TEST.mp4" controls="controls" ></video>
    </div>
    </div>
    <footerComponet></footerComponet>
  </div>
</template>
<script>
import MinChart from '@/components/min-chart'
import footerComponet from '@/components/footer'
import vueQr from "vue-qr";
export default {
    components:{footerComponet,vueQr,MinChart},
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
      //  this.getDownurl()
       this.setApp()
	   this.downUrl=`${location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, "//m.")}/app`;
       this.lang = localStorage.getItem("lang")||'en';
	  //  this.getAnnouncement()
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
    toPage(item){
      if(item.link){
         window.open(item.link)
      }
      console.log(item);
    },
      toLogo(val){
        window.open(val)
      },
      toUrl(item){
         localStorage.setItem(
        "tradeinfo",
        JSON.stringify(item)
      );
         this.$router.push({
           path:'/trade',
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
                // console.log(res,'currency_matches')
                // let usdtData = res.find(item => item.code == 'USDT');
                // this.cny_rate = usdtData.cny_price;
				// this.usd_rate = usdtData.usd_price;
				this.marketlist = res;
				// this.marketlist = usdtData.matches.sort(function(a, b) {
				// 	return b.currency_quotation.change - a.currency_quotation.change;
    //             });
                console.log(this.marketlist,333)
            })
        },
        // 链接socket
        bindSocket(){
            var that=this;
            that.$socket.connected((socket)=>{
                socket.send({type: "sub", params: "DAY_MARKET"});
                socket.on('DAY_MARKET',msg=>{
                    for (var i = 0; i < this.marketlist.length; i++) {
                        this.marketlist[i].matches.forEach(element => {
                          if (element.id == msg.currency_match_id) {
                            element.currency_quotation.close = msg.quotation.close;
                            element.currency_quotation.change = msg.quotation.change;
                        }
                        });
                        
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
        //  getDownurl(){
        //     this.$http.initDataToken({url:'default/setting',data:{key:'app_download_url'}},false)
        //     .then(res=>{
        //         this.downUrl=res;
        //     })
        // },
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
  width: 348px;
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