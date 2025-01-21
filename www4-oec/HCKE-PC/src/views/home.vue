<template>
  <div class="home">
    <div class="block myswiper">
      <el-carousel height="620px">
        <el-carousel-item v-for="(item, i) in swipers" :key="i">
          <!-- <img :src="item" alt="" class="w100 ht200"> -->
          <div class="block w100 h100 swiperhover bgheader">
            <img :src="item.banner" alt="" class="w100 h100" />
          </div>
        </el-carousel-item>
      </el-carousel>
    </div>
    
    <div class="bgpart ptb60">
      <div v-if="marketlist.length" class="rateWrapper">
		<div class="wt1200 mauto flex jscenter">
		  <div
			class="plr10 markethover ptb15 new-balck3 w23"
			v-for="(item, i) in marketlist"
			:key="i"
			v-if="i < 5 && item.open_change == 1"
      @click="toUrl(item)"
		  >
			<div class="flex alcenter between w100">
			  <div class="ft20 flex  alcenter">
          <img class="wt30 radius50p mlr10" :src="item.base_currency.logo" alt="" srcset=""></img>
				<span class="">{{ item.symbol }}</span>
			  </div>
			</div>
			<div class="c-pd">
			  <div
				class="pl5 ft16  pt10 ml10 mb10"
				>USD {{ parseFloat(item.currency_quotation.close) }}</div
			  >

			  <!-- <span class="ft12 baselight2">≈ {{ ((item.currency_quotation.close - 0) * (cny_rate - 0)) | toFixed2 }}CNY</span> -->
			</div>

      <div class="flex jsend flexend w100">
        <span
			  class="ft14  radius8 plr10 ptb5"
			  :class="{
				bgred: parseFloat(item.currency_quotation.change) < 0,
				bggreen:
				  parseFloat(item.currency_quotation.change) >= 0 ||
				  item.currency_quotation.change == '',
			  }"
			  >{{ item.currency_quotation.change >= 0 ? "+" : ""
			  }}{{ (item.currency_quotation.change - 0) | toFixed2 }}%</span>
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
    </div>
	

  <div class="bgpart">
    <div class="wt1200 mauto">
      <div class="flex ht30 alcenter  marketRackHeaders">
        <div class="flex1 tc ft16">#</div>
        <div class="flex1 tc ft16">{{$t('trade.currency')}}</div>
        <div class="flex1 tc ft16">{{$t('lever.price')}}</div>
        <div class="flex1 tc ft16">{{$t('trade.changes')}}</div>
        <!-- <div class="flex1 tc ft16">{{$t('market.high')}}</div>
        <div class="flex1 tc ft16">{{$t('market.low')}}</div> -->
        <div class="flex1 tc ft16">{{$t('market.market')}}</div>
        <!-- <div class="flex1 tc ft16">24H{{$t('trade.cj_total')}}(USDT)</div> -->
        <div class="flex1"></div>
      </div>
      <div class="flex pb20  hover-item marketRack" v-for="(item,index) in marketlist" :key="index"  >
        <div class="flex1 tc ft16">
            {{index+1}}
          </div>
          <div class="flex1 tc ft16 flex jscenter alcenter">
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
            <span class="new-trade-btn pointer" @click="toUrl(item)">
              {{$t('new.jy')}}
            </span>
          </div>
        </div>
    </div>
  </div>

  <div class="bgpart">
    <div class="wt1300 mauto flex alcenter ptb40">
      <img src="../assets/images/image@2x.png" alt="" class="w60" style="height:430px" />
      <div class="">
        <div class="ft40 bold">{{$t('new.wcoec')}}</div>

        <div class="mt20">
          <div class="flex alcenter">
            <img class="wt30 mr10" src="../assets/images/gou.png" alt="">
            <span class="ft22">{{$t('new.top')}}</span>
          </div>
          <div class="aboutText">
            {{$t('new.topdesc')}}
          </div>
        </div>

        <div class="mt20">
          <div class="flex alcenter">
            <img class="wt30 mr10" src="../assets/images/gou.png" alt="">
            <span class="ft22">{{$t('new.securicy')}}</span>
          </div>
          <div class="aboutText">
            {{$t('new.securicydesc')}}
          </div>
        </div>

        <div class="mt20">
          <div class="flex alcenter">
            <img class="wt30 mr10" src="../assets/images/gou.png" alt="">
            <span class="ft22">{{$t('new.pop')}}</span>
          </div>
          <div class="aboutText">
            {{$t('new.popdesc')}}
          </div>
        </div>

        <div class="mt20">
          <div class="flex alcenter">
            <img class="wt30 mr10" src="../assets/images/gou.png" alt="">
            <span class="ft22">{{$t('new.team')}}</span>
          </div>
          <div class="aboutText">
            {{$t('new.tempdesc')}}
          </div>
        </div>

        <div class="mt20">
          <div class="flex alcenter">
            <img class="wt30 mr10" src="../assets/images/gou.png" alt="">
            <span class="ft22">{{$t('new.safe')}}</span>
          </div>
          <div class="aboutText">
            {{$t('new.safedesc')}}
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="bgpart ptb40">
    <div class="wt1300 mauto flex alcenter pb20">
      <div class=" mr40">
        <div class="ft40 bold">{{$t('new.help')}}</div>
        <div class="flex alcenter mt20">
            <img class="wt30 mr10" src="../assets/images/gou.png" alt="">
            <span class="ft22">{{$t('new.raise')}}</span>
          </div>
          <div class="flex alcenter mt20">
            <img class="wt30 mr10" src="../assets/images/gou.png" alt="">
            <span class="ft22">{{$t('new.increase')}}</span>
          </div>
          <div class="flex alcenter mt20">
            <img class="wt30 mr10" src="../assets/images/gou.png" alt="">
            <span class="ft22">{{$t('new.grow')}}</span>
          </div>
          <div class="flex alcenter mt20">
            <img class="wt30 mr10" src="../assets/images/gou.png" alt="">
            <span class="ft22">{{$t('new.gain')}}</span>
          </div>
          <div v-if="false" class="mt20">
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
            <img class="wt120 mr10" style="height:40px;" src="../assets/images/googlePlay.png" @click="setImg('img1')" slot="reference">
            </el-popover>
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
                <img class="wt120 mr10" style="height:40px;" src="../assets/images/appleStore.png"  @click="setImg('img2')" slot="reference">
            </el-popover>
          </div>
      </div>
      <img src="../assets/images/phone-i.png" alt="" class="w50" style="height:530px" />
    </div>
  </div>
   
  <div class="new-balck3  ptb30">
    <div class="tc ft40">{{$t('new.addition')}}</div>
    <div class="tc railTagged mtb30">{{$t('new.engaged')}}</div>
    <div class="flex alcenter jscenter">
      <div class="wt340 flex column alcenter">
        <img src="../assets/images/qiqiu.png"  style="height:140px" />
        <div class="railTag">1</div>
        <div class="railHead">{{$t('new.airdrop')}}</div>
        <div class="railText">{{$t('new.aridropdesc')}}</div>
      </div>

      <div class="wt340 flex column alcenter">
        <img src="../assets/images/flower.png"  style="height:140px" />
        <div class="railTag">2</div>
        <div class="railHead">{{$t('staking.mining')}}</div>
        <div class="railText">{{$t('new.stakingdesc')}}</div>
      </div>

      <div class="wt340 flex column alcenter">
        <img src="../assets/images/yiyi.png"  style="height:140px" />
        <div class="railTag">3</div>
        <div class="railHead">{{$t('new.trading')}}</div>
        <div class="railText">{{$t('new.tradingdesc')}}</div>
      </div>
    </div>
  </div> 

  <div class="bgpart ptb40 flex column jscenter alcenter">
    <div class="wt1300   flex alcenter">
        <div class="flex1">
          <div class="ft40">{{$t('new.distribute')}}</div>
          <div class="customerTag mtb20">{{$t('new.fees')}}</div>
          <div class="customerText">{{$t('new.clients')}}</div>
        </div>
        <div class="flex1 testimonialCard ml90">
          <div class="testimonialText">
            {{$t('new.existing')}}
          </div>
          <div class="testimindesc">{{$t('new.monitor')}}</div>
          
          <div class="testimonialText">
            {{$t('new.incentive')}}
          </div>
          <div class="testimindesc">{{$t('new.decade')}}</div>

          <div class="testimonialText">
            {{$t('new.databse')}}
          </div>
          <div class="testimindesc">{{$t('new.lead')}}</div>

          <div class="testimonialText">
            {{$t('new.hnw')}}
          </div>
          <div class="testimindesc">{{$t('new.investor')}}</div>
        </div>
      </div>
    <div class="wt1300   flex alcenter between flexend mt40">
      <div>
        <div class="ft40">{{$t('new.multiplatform')}}</div>
        <div class="customerTag mt20">{{$t('new.platformdesc')}}</div>
      </div>
      <div class="accountActionBtn pointer" @click="$router.push({
        name:'register'
      })">
        {{$t('new.register')}}
      </div>
    </div>
  </div>
  
    <footerComponet></footerComponet>
  </div>
</template>
<script>
import footerComponet from '@/components/footer'
import MinChart from '@/components/min-chart'
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
       this.getDownurl()
       this.setApp()
	   this.downUrl=`${location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, "//m.")}/app`;
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
        "tradeinfo",
        JSON.stringify(item)
      );
         this.$router.push({
           path:'/CurrencyTransaction',
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

  .rateWrapper {
    width: 95%;
    margin: auto;
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 20px;
    border: 1px solid rgb(255,255,255,0.1);
    border-radius: 20px;
}

.marketRackHeaders {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
    padding-bottom: 20px;
    border-bottom: 3px solid rgb(200,200,200,0.5);
}

.marketRack {
    display: flex;
    align-items: center;
    justify-content: space-between;
    /* margin: 20px 0px; */
    padding: 20px 0px;
    border-bottom: 1px solid rgb(200,200,200,0.5);
}

.new-trade-btn{
  border: 1px solid black;
    border-radius: 15px;
    padding: 5px 10px;
}

.aboutText {
    font-size: 16px;
    margin-top: 20px;
    /* color: rgb(200,200,220); */
    font-family: "Lato";
    line-height: 26px;
}

.railTagged {
    /* color: rgb(200,200,220); */
    font-weight: 400;
    font-size: 18px;
    text-align: center;
    margin-bottom: 60px;
    padding: 0px 20px;
}

.railTag {
    font-size: 12px;
    color: gray;
    font-weight: 600;
    margin-bottom: 10px;
    font-family: "Lato";
    text-transform: uppercase;
}

.railHead {
    font-size: 18px;
    font-weight: 500;
    margin-bottom: 10px;
}

.railText {
    font-size: 15px;
    text-align: center;
    /* color: rgb(200,200,200); */
}

.customerTag {
    font-size: 18px;
    font-weight: 600;
    /* color: rgb(200,200,200); */
    margin-bottom: 10px;
}
.customerText {
    font-size: 15px;
    font-weight: 300;
    /* color: rgb(180,180,180); */
    margin-bottom: 30px;
}

.testimonialCard {
  background: #f3f3f3;
    /* background: rgb(30,30,35); */
    padding: 40px;
    border-radius: 15px;
    margin-right: 50px;
    border-left: 15px solid rgb(255,200,0);
}

.testimonialText {
    font-size: 20px;
    margin-bottom: 5px;
    font-weight: 500;
    /* color: white; */
    line-height: 35px;
}

.testimindesc{
    font-weight: 400;
    font-size: 13px;
    /* color: gray; */
    margin-bottom: 20px;
}

.accountActionBtn {
    display: flex;
    /* background: white; */
    padding: 10px 30px;
    border-radius: 30px;
    font-weight: 600;
    /* color: rgb(40,40,40); */
    transition: 0.3s ease-out;
}
</style>