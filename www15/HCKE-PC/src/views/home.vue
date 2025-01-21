<template>
	<div>
		<div class="posRelt">
			<el-carousel height="675px">
				<el-carousel-item v-for="(item, i) in swipers" :key="i">
					<img :src="item.banner" class="w100 h100" />
				</el-carousel-item>
			</el-carousel>
			<div class="w100 abstort btm0 zindex flex ptb20" style="background-color: rgba(13,32,35,0.8);border:1px solid rgba(13,32,35,1)">
				
				
				<div class="flex1 plr40 ptb10 bdre7" style="border-right:1px solid #1a2d3a" v-for="(item, i) in marketlist" :key="i" v-if="i < 5 && item.open_change == 1">
					<div class="flex alcenter between w100">
						<div class="flex1">
							<div class="ft16 white">
								<span>{{ item.base_currency_code }}</span>
								<span class="ft14" :class="{ red: parseFloat(item.currency_quotation.change) < 0, green: parseFloat(item.currency_quotation.change) >= 0 || item.currency_quotation.change == ''}">
									{{ item.currency_quotation.change >= 0 ? "+" : ""}}{{ (item.currency_quotation.change - 0) | toFixed2 }}%
								</span>
							</div>
							<div class="ptb10 ft18 white">
								$ {{ parseFloat(item.currency_quotation.close) }}
							</div>
						</div>
						<min-chart class="wt170 ht60" :symbol="item.lower_symbol" :color="parseFloat(item.currency_quotation.change) < 0?'#E95463':'#028065'" :id="i" />
					</div>
				</div>
			</div>
		</div>
		<div>
			<div class="ft24 tc ptb70">
				<div class="ptb30">
					<div class="white bg-main inblock plr60 ptb15 radius4" style="transform: skew(-30deg, 0deg);">
						<div style="transform: skew(30deg, 0deg)">
							{{ $t("new.shijie") }}
						</div>
					</div>
					
					<div class="ft12 gray9 ptb30">{{ $t("new.all") }}</div>
				</div>
				
				<div class="flex jscenter alcenter">
					<div class="wt400 ht200 mlr10 posRelt">
						<div class="w100 h100 posRelt zindex plr20 ptb20">
							<div class="ft16 white tl ptb10">{{ $t("new.an") }}</div>
							<div class="ft12 white tl ptb10">{{ $t("new.zai") }}</div>
							<div class="ft12 white tl ptb10 mt10">{{ $t("new.zhuan") }}</div>
						</div>
						<img class="w100 h100 abstort lf0 top0" src="../assets/images/bg_secure.png" >
					</div>
					<div class="wt400 ht200 mlr10 posRelt">
						<div class="w100 h100 posRelt zindex plr20 ptb20">
							<div class="ft16 white tl ptb10">{{ $t("new.shis") }}</div>
							<div class="ft12 white tl ptb10">{{ $t("new.wo") }}</div>
							<div class="ft12 white tl ptb10 mt10">{{ $t("new.zuo") }}</div>
						</div>
						<img class="w100 h100 abstort lf0 top0" src="../assets/images/bg_ecology.png" >
					</div>
					<div class="wt400 ht200 mlr10 posRelt">
						<div class="w100 h100 posRelt zindex plr20 ptb20">
							<div class="ft16 white tl ptb10">{{ $t("new.hu") }}</div>
							<div class="ft12 white tl ptb10">{{ $t("new.jian") }}</div>
							<div class="ft12 white tl ptb10 mt10">{{ $t("new.li") }}</div>
						</div>
						<img class="w100 h100 abstort lf0 top0" src="../assets/images/bg_user.png" >
					</div>
				</div>
				
			</div>
		</div>
		<div  class="w100 posRelt">
			<div class="abstort lf0 top0 zindex w100 ptb50">
				<div class="wt1200 mauto flex jscenter alcenter white ft26 mtb50">
					<div class="wt200 bgwhite" style="height: 1px;"></div>
					<div class="mlr50 flex1 tc bold">{{ $t("home.c12") }}</div>
					<div class="wt200 bgwhite" style="height: 1px;"></div>
				</div>
				<div class="wt1200 mauto flex jscenter alcenter white ft18">
					<div class="mlr50 flex1 tc">{{ $t("new.gai") }}</div>
				</div>
			</div>
			<div class="abstort zindex wt340" style="right: 340px;bottom: 130px;">
				<el-popover placement="top" trigger="click">
					<vue-qr :text="downUrl" :margin="0" colorDark="#000000" colorLight="#fff" :size="140" />
					<div class="flex alcenter mb40 ptb15 radius10" style="background-color: rgb(21,41,54,1);" :class="lang + 1" @click="setImg('img1')" slot="reference">
						<div class="bg-main wt5 ht50 radius8"></div>
						<img  class="wt40 mlr30" src="../assets/images/icon_andriod.png"/>
						<span class="ft14 mr30 white">Andriod {{ $t("home.downs") }}</span>
					</div>
				</el-popover>
				
				<el-popover placement="top" trigger="click">
					<vue-qr :text="downUrl" :margin="0" colorDark="#000000" colorLight="#fff" :size="140" />
					<div class="flex alcenter mb40 ptb15 radius10" style="background-color: rgb(21,41,54,1);" :class="lang + 1" @click="setImg('img2')" slot="reference"> 
						<div class="bg-main wt5 ht50 radius8"></div>
						<img  class="wt40 mlr30" src="../assets/images/icon_ios.png"/>
						<span class="ft14 white mr30">IOS {{ $t("home.downs") }}</span>
					</div>
				</el-popover>
				
				<div class="flex alcenter ptb15 radius10" style="background-color: rgb(21,41,54,1);" :class="lang + 1" @click="downLoad" >
					<div class="bg-main wt5 ht50 radius8"></div>
					<span class="ft14 white mlr30">{{ $t("login.downApp") }}</span>
				</div>
			</div>
			<img src="../assets/images/bg_down_app.png" class="w100" />
		</div>
		<div class="wt800 mauto flex jscenter alcenter black ft26 mtb50">
			<div class="wt200 bgfooter" style="height: 1px;"></div>
			<div class="mlr50 flex1 tc bold">{{ $t("new.jies") }}</div>
			<div class="wt200 bgfooter" style="height: 1px;"></div>
		</div>
		<div class="flex bgwhite">
			<div class="flex1 tr">
				<img style="height: 800px;" src="../../static/imgs/pz.jpg">
			</div>
			<div class="flex1 posRelt">
				<div class="abstort zindex lf0 plr50 ptb50 ft20 w70 white lh30"  style="overflow: auto;max-height: 760px;" v-html="$t('new.jiec')"></div>
					
				<img style="height: 800px;" src="../assets/images/bg_jiesao.png">

				<div class="flex alcenter mb40 ptb15 radius10" style="background-color: rgb(21,41,54,1);" @click="topo" slot="reference"> 
					<div class="bg-main wt5 ht50 radius8"></div>
						<img  class="wt40 mlr30" style="margin-left: 370px;" src="../assets/images/shuben.png"/>
					<span class="ft18 white "><font style="color: #007FB9;">{{ $t("new.baipi") }}</font></span>
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
    components:{MinChart,footerComponet,vueQr},
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
	   this.$getAnnouncement()
    },
    methods:{
		topo(){
			let lang=localStorage.getItem('lang')
            if(lang=='hk'){
				lang = 'zh'
                // this.downUrl='//api.5global.com/app/japanapp/'
            }else{
				lang = 'en'
                // this.downUrl='//api.mql5global.com/app/app/'
            }
			window.open(`${this.$http._DOMAIN}/wp/bitstamp_${lang}.pdf`);
		},
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
/* .el-carousel__container{
    min-height: 460px;
} */
/* .myswiper img{
        min-height: 460px;
    } */
.w80 {
  width: 650px;
  height: 325px;
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