<template>
  <div class="home bgwhite">
    <div class="block myswiper">
      <el-carousel height="601px">
        <el-carousel-item v-for="(item, i) in swipers" :key="i">
          <!-- <img :src="item" alt="" class="w100 ht200"> -->
          <div class="block w100 h100 swiperhover bgheader">
            <img :src="item.banner" alt="" class="w100 h100" @click="toPage(item)" />
          </div>
        </el-carousel-item>
      </el-carousel>
    </div>
    <div class="pb40 posRelt" style="top:-60px;z-index:999" v-if="marketlist.length">
		<div class="wt1200 mauto bgwhite black" style="box-shadow: 0px 0px 51px 0px rgba(128,193,152,0.3400);border-radius: 20px;">
      <div class="flex ht50 alcenter text-858E82">
        <div class="flex1 tc ft16">{{$t('trade.currency')}}</div>
        <div class="flex1 tc ft16">{{$t('lever.price')}}</div>
        <div class="flex1 tc ft16">{{$t('trade.changes')}}</div>
        <!-- <div class="flex1 tc ft16">{{$t('market.high')}}</div>
        <div class="flex1 tc ft16">{{$t('market.low')}}</div> -->
        <div class="flex1 tc ft16">{{$t('market.market')}}</div>
        <!-- <div class="flex1 tc ft16">24H{{$t('trade.cj_total')}}(USDT)</div> -->
        <div class="flex1"></div>
      </div>

      <div>
        <div class="flex ptb20" v-for="(item,index) in marketlist" :key="index">
          <div class="flex1 tc ft16">
            {{item.symbol}}
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
          <div class="flex1 tc">
            <span class="pointer ft16 border-2DBD96 text-2DBD96 plr10 radius6" @click="toUrl(item)">
              {{$t('trade.buy1')}}/{{$t('trade.sell1')}}
            </span>
          </div>
        </div>
      </div>


    <template v-if="false">
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
    </template>

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
    <div class="bgwhite contw bg-main-liner flex column jscenter alcenter" style="margin-top:-130px;">
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
      <p class="tc ft24 bold text-clip-yellow">{{ $t("new.shijie") }}</p>
      <p class="tc mt14 ft14 white">
        {{ $t("new.all") }}
      </p>
      <div class="flex alcenter">
        <div>
              <div class="text-clip-yellow ft24 tr">{{ $t("new.an") }}</div>
              <p class="ft12 mb10 white tr">{{ $t("new.zai") }}</p>
          </div>
          <img class="mt20" src="/static/imgs/jieshao1.png" alt="">
           <div class="ml20">
              <div class="text-clip-yellow ft24">{{ $t("new.shis") }}</div>
              <p class="ft12 mb10 white"> {{ $t("new.wo") }}</p>
              <p class="ft12 white">{{ $t("new.zuo") }}</p>
          </div>
      </div>
        <div style="margin-right: 300px;">
            <div class="text-clip-yellow ft24 tc">{{ $t("new.hu") }}</div>
            <p class="ft12 mb10 white">{{ $t("new.jian") }}</p>
            <p class="ft12 white">{{ $t("new.li") }}</p>
        </div>
    </div>


    <div class="bgwhite contw contbg">
      <div class="flex alcenter jscenter">
        <img src="/static/imgs/green-line.png" alt="" srcset="">
        <span class="tc ft28 bold plr20 text-clip-green">{{ $t("new.kai") }}</span>
         <img style="transform: rotateY(180deg);" src="/static/imgs/green-line.png" alt="" srcset="">
      </div>

      <div class="mt50 flex alcenter jscenter mauto tc">
        <div class="border-2DBD96 f-right m-item radius8 pt20">
          <img src="../assets/images/ghfnghmh.png" alt="" class="wt50" />
          <div class="mt20">
            <p class="bold ft16 mb20 black">{{ $t("new.shou") }}</p>
            <p class="ft12 mb10 gray7">{{ $t("new.shi") }}</p>
            <p class="ft12 gray7">{{ $t("new.fe") }}</p>
          </div>
        </div>
        <div class="f-right m-item border-2DBD96 radius8 pt20">
          <img src="../assets/images/hmhgm.png" alt="" class="wt50" />
          <div class="mt30">
            <p class="bold ft16 mb20 black">{{ $t("new.you") }}</p>
            <p class="ft12 mb10 gray7">{{ $t("new.hui") }}</p>
            <p class="ft12 gray7">{{ $t("new.xiang") }}</p>
          </div>
        </div>
        <div class="m-item border-2DBD96 radius8 pt20">
          <img src="../assets/images/gnhmnh.png" alt="" class="wt50" />
          <div class="mt20">
            <p class="bold ft16 mb20 black">{{ $t("new.ke") }}</p>
            <p class="ft12 mb10 gray7">{{ $t("new.quan") }}</p>
            <p class="ft12 gray7">{{ $t("new.di") }}</p>
          </div>
        </div>
      </div>
      <!-- <button class="k-btn" @click="toPath">{{ $t("new.yi") }}</button> -->
    </div>
    <div class="bg-main-liner pt30 pb30">
    
     <div class="flex  jscenter">
     <div class="flex column between">
        <div class="pt60">
          <div class="tc ft24 bold text-clip-yellow">{{ $t("home.c12") }}</div>
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
              <span class="pt10 ft14 black">Andriod {{ $t("home.downs") }}</span>
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
              <span class="pt10 ft14 black">IOS {{ $t("home.downs") }}</span>
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
              <span class="pt10 ft14 black">{{ $t("login.downApp") }}</span>
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

     <img src="../assets/images/image@2x.png" />

     </div>


   

	 
    </div>

    <div class="bgwhite contw">
      <div class="jieshao" style="margin-top:0px">
         <p class="tc ft24 bold text-clip-green">{{ $t("new.jgxk") }}</p>
       <p class="tc mt14 ft14 black">
        {{ $t("new.jgjs") }}
      </p>
      <div class="mt50 flex alcenter jscenter mauto tc">
        <div class="f-item f-right m-item border-2DBD96" style="padding-top:20px;background: transparent;margin-right: 60px;">
          <img src="../assets/images/financial.png" alt="" class="wt50" />
          <div class="mt20 mb20 black">
            <p>{{$t('new.meiguo')}}({{$t('new.jgz')}})</p>
              <div class="flex between pt20">
                <div class="tl mr20 black">
                <div>{{$t('new.jgzh')}}</div>
                <div>234234234</div>
              </div>
              <div class="tr">
                <div>{{$t('new.fzrq')}}</div>
                <div>2021-11-10</div>
              </div>
              </div>

              <div class=" plr15 radius4 border-2DBD96 ptb10 mt10"><a href="https://www.fincen.gov/msb-state-selector" target="_blank">{{$t('new.mgyzwz')}}</a></div>
          </div>
        </div>
        <!-- <div class="f-item f-right m-item border-2DBD96" style="background: transparent;">
          <img src="../assets/images/services-business.png" alt="" class="wt50" />
          <div class="mt20">
            <p>{{$t('new.jianada')}}({{$t('new.jgz')}})</p>
            <div class="flex between pt20">
                <div class="tl mr20">
                <div>{{$t('new.jgzh')}}</div>
                <div>M21813989</div>
              </div>
              <div class="tr">
                <div>{{$t('new.fzrq')}}</div>
                <div>2021/07/14</div>
              </div>
              </div>

              <div class="bdheader plr15 radius4 bdblue ptb10 mt10"><a href="https://www10.fintrac-canafe.gc.ca/msb-esm/public/msb-search/search-by-name/" target="_blank">{{$t('new.jndyzwz')}}</a></div>
          </div>
        </div> -->
        <div class="f-item m-item border-2DBD96" style="background: transparent;">
          <img src="../assets/images/commission.png" alt="" class="wt50" />
          <div class="mt20 black">
            <p>{{$t('new.meiguo')}}({{$t('new.jgz')}})</p>
            <div class="flex between pt20 black">
                <div class="tl mr20 black">
                <div>{{$t('new.jgzh')}}</div>
                <div>123123123</div>
              </div>
              <div class="tr black">
                <div>{{$t('new.fzrq')}}</div>
                <div>2022-4-21</div>
              </div>
              </div>

              <div class=" plr15 radius4  ptb10 mt10 border-2DBD96"><a href="https://www.coloradosos.gov/biz/BusinessEntityCriteriaExt.do" target="_blank">{{$t('new.mgyzwz')}}</a></div>
          </div>
        </div>
      </div>
      </div>
      
    </div>

    <div class="bgwhite pt30 pb30">
      <div class="flex wt1000 mauto between alcenter black">
        <img src="../assets/images/fktx.png" class="wt360" />
        <div>
          <div class="ft32 bold">
            {{$t('new.fk')}}
          </div>
          <div class="ft14 mt20">
            {{$t('new.fksm')}}
          </div>
          <div class="flex mt20 ft16 bold">
            <div>
              <img src="../assets/images/cbj.svg" alt="" srcset="">
              <div class="mt10">
                20,000BTC
              </div>
              <div>
                {{$t('new.cbj')}}
              </div>
            </div>
            <div style="margin-left:100px">
              <img src="../assets/images/safe.svg" alt="">
              <div class="mt10">
                {{$t('new.wsg')}}
              </div>
              <div>
                {{$t('new.djaq')}}
              </div>
            </div>
          </div>
        </div>
      </div>
     
       <!-- <div> -->
         <!-- <div class="flex alcenter jscenter">
        <img src="/static/imgs/green-line.png" alt="" srcset="">
        <span class="tc ft28 bold plr20 text-clip-green">{{$t('new.jies')}}</span>
         <img style="transform: rotateY(180deg);" src="/static/imgs/green-line.png" alt="" srcset="">
      </div> -->
	         <!-- <h1 class="title">{{$t('new.jies')}}</h1> -->
	    <!-- <div class="content mauto mt30 black" style="width:900px" v-html="$t('new.jiec')"></div> -->
           <!-- <img class="w80 mt50" style="height: auto;" src="../../static/imgs/pz.jpg" alt=""> -->
			<!-- <video id="myVideo" class="mt50 w100" src="https://exchange-hk.oss-cn-hongkong.aliyuncs.com/MetaUniverseGlobalcoin/upload/qly_1640247993000.MP4" controls="controls" ></video> -->
	  <!-- </div> -->
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
  width: 260px;
  height: 300px;
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