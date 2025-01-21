<template>
  <div class="bg-main-liner">
    <div class="w80 mauto ptb40">
      <div class=" flex basecolor ft16 jscenter alb flex between" style="width:100%;justify-content: space-around;">

       <div class="flex column alcenter">
        <img src="../../static/imgs/wewe.png" class="mauto wt50" />
        <div style="width:650px" class="black" v-html="$t('new.jiec')"></div>
       </div>
        <!-- <div class="flex1">{{ $t("about.abt") }}</div> -->
        <!-- <div class="flex1 tc">{{ $t("about.support") }}</div> -->
        <!-- <div class="flex1"></div> -->
      
         <div class="flex" v-if="List1.length">
        <div class="black" >

		      <p class="tc">{{$t('new.tiaokuan')}}</p>
          <div
            class="mt10 pointer tc baselight"
            v-for="(item, index) in List1"
            :key="index"
            @click="goDetail(item.id, 31)"
          >
            {{ item.title }}
          </div>
        </div>
        <!-- <div class="flex1 tc">
          <div
            class="mt10 pointer"
            v-for="(item, index) in List2"
            :key="index"
            @click="goDetail(item.id, 26)"
          >
            {{ item.title }}
          </div>
        </div> -->
        <!-- <div class="flex1 tr">
          <div class="mt10 pointer" @click="goTicket()">
            {{ $t("about.submitTicket") }}
          </div>
          <div class="mt10 pointer" @click="goline">
            {{ $t("new.kefu") }}
          </div>
          <div class="mt10" v-show="mobile">{{$t('about.mobile')}}：{{mobile}}</div>
                    <div class="mt10" v-show="email">{{$t('about.email')}}：{{email}}</div>
        </div> -->
      </div>
        <p class="black" @click="goTicket()">
          {{ $t("about.submitTicket") }}
        </p>

        <div class="black">
          <div>{{$t("new.jrwm")}}</div>
          <div class="mt20">{{$t('about.email')}}:info@TEST.com</div>
          <!-- <div class="mt20">
            <a href="https://www.facebook.com/OEC-Open-Exchange-Crypto-111990511568166" target="_blank">
              <img src="../assets/images/facebook.png" class="wt20 mr5" alt="" srcset="" />
            </a>
            <a href="https://instagram.com/openexchangecrypto?r=nametag" target="_blank">
              <img src="../assets/images/instagram.png" class="wt20 mr5" alt="" srcset="" />
            </a>
            <a href="https://t.me/OEC_Exchange" target="_blank">
              <img src="../assets/images/telegram.png" class="wt20 mr5" alt="" srcset="" />
            </a>
            <a href="https://twitter.com/OECexchange" target="_blank">
              <img src="../assets/images/twitter.png" class="wt20" alt="" srcset="" />
            </a>
          </div> -->
        </div>
		<!-- <p class="textitem flex1" @click="toPath">{{$t('new.baipi')}}</p>
		<p class="textitem flex1" @click="toPathPDF('lhztzm')">{{$t('new.lhztzm')}}</p>
		<p class="textitem flex1" @click="toPathPDF('dailizhengming')">{{$t('new.dailizhengming')}}</p> -->
		<!-- <p class="textitem flex1" @click="govideo">{{$t('new.introdu')}}</p> -->
        <!-- <div class="flex1">
            <p>{{$t('new.about')}}</p>
            <p class="textitem" @click="toPath">{{$t('new.baipi')}}</p>
            <p class="textitem" @click="govideo">{{$t('new.introdu')}}</p>
        </div> -->
        <!-- <div class="flex1 tr">{{ $t("about.concat") }}</div> -->
      </div>
		<!-- <div class="flex basecolor ft16 jscenter alb tc">
			<p class="textitem flex1" @click="toPathPDF('gupiao')">{{$t('new.gupiao')}}</p>
			<p class="textitem flex1" @click="toPathPDF('gupiaodizhang')">{{$t('new.gupiaodizhang')}}</p>
			<p class="textitem flex1" @click="toPathPDF('huiyijilu')">{{$t('new.huiyijilu')}}</p>
			<p class="textitem flex1" @click="toPathPDF('zhangcheng')">{{$t('new.zhangcheng')}}</p>
			<p class="textitem flex1" @click="toPathPDF('zhucezhengshu')">{{$t('new.zhucezhengshu')}}</p>
		</div>  -->
		<!-- <div class="flex basecolor ft16 jscenter alb tc">
			<p class="textitem flex1" @click="toPath2">{{$t('new.zhidaoshouce')}}</p>
		</div> -->
     
      <div class="tc mt30">
          <p class="ft24 bold black">TEST</p>
        
        <p class="black">
          ©Copyright 2021 TEST. All rights reserved.
        </p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    data(){
        return {
          List1:[],
          List2:[],
          mobile:'',
          email:''
        }
    },
    created() {
        this.getList1()
        this.getList2()
        this.getConnect()
        this.getConnect2()
    },
    methods:{
		toPath(){
			var lang = localStorage.getItem("lang");
			if(lang == 'hk'){
			  lang = 'zh'
			}else{
			  lang = 'en'
			}
			window.open(`${this.$http._DOMAIN}/wp/oec-${lang}.pdf`);
		},
		toPathPDF(urls){
			let path = `../../static/${urls}.pdf`
		   window.open(path);
		},
      toPath2(){
         window.open(`../../static/guide_book.pdf`);
      },
      goline(){
        window.open('https://direct.lc.chat/12827847/')
      },
      govideo(){
        window.open('https://exchange-hk.oss-cn-hongkong.aliyuncs.com/MetaUniverseGlobalcoin/upload/qly_1640247993000.MP4')
      },
		getList1() {
            this.$http.initDataToken({
                url: 'news/list',
                data: { category_id: 31 }
            },false).then(res=>{
              console.log(res.data)
               this.List1 = res.data;
            })
        },
        getList2() {
            this.$http.initDataToken({
                url: 'news/list',
                data: { category_id: 26 }
            },false).then(res=>{
               this.List2 = res.data;
            })
        },
        // 详情
        goDetail(id,category_id) {
            this.$router.push({
                name: "notice",
                query: {
                    id: id,
                    category_id: category_id
                }
            });
        },
        getConnect() {
            this.$http.initDataToken({
                url: 'default/setting',
                data: { key:'contact_mobile' }
            },false).then(res=>{
               this.mobile = res;
            })
        },
        getConnect2() {
            this.$http.initDataToken({
                url: 'default/setting',
                data: { key:'contact_email' }
            },false).then(res=>{
               this.email = res;
            })
        },
        goTicket(){
            console.log(11111)
            this.$router.push({
                name:'feedback'
            })
        }
    }
}
</script>
<style scoped>
  .alb{
    align-items: baseline;
  }
  .textitem{
    margin-top: 15px;
    cursor: pointer;
  }
</style>
