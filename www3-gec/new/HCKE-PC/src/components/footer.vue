<template>
  <div class="bgblack" style="padding:50px 200px;">
    <div class="flex around">
        <div>
      <p class="ft18">{{$t('new.about')}}</p>
      <!-- <p class="textitem flex1" @click="toPath">{{$t('new.baipi')}}</p> -->
      <!-- <p class="textitem flex1" @click="toPathPDF('dailizhengming')">{{$t('new.dailizhengming')}}</p> -->
      <!-- <p class="textitem flex1" @click="toPathPDF('zhucezhengshu')">{{$t('new.zhucezhengshu')}}</p> -->
    </div>
    <!-- <div class="ft18" style=" cursor: pointer;" @click="websize">{{$t('home.web_size')}}</div> -->
    <div>
      <p class="ft18">{{$t('add.service')}}</p>
      <p class="textitem flex1" @click="goTicket()">
          {{ $t("about.submitTicket") }}
      </p>
      <!-- <p class="textitem flex1" @click="toPath2">{{$t('new.zhidaoshouce')}}</p> -->
    </div>
    <!-- <div>
      <div class="ft18">{{$t('add.lxwm')}}</div>  
      <div class="textitem">{{$t('login.e_email')}}: info@m-easyex.com</div>
    </div>    -->
    </div> 
         <div class="tc mt30">
        <p class="ft24 bold">Test</p>
        <p class="baselight">
           ©Copyright 2022 Test. All rights reserved.
       </p>
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
      websize(){
        window.open('https://gexcnce.xyz/')
      },
		toPath(){
			var lang = localStorage.getItem("lang");
			if(lang == 'hk'){
			  lang = 'tw'
			}else{
			  lang = 'en'
			}
			window.open(`${this.$http._DOMAIN}/wp/white-wp-${lang}.pdf`);
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
                data: { category_id: 25 }
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
    color: #989898;
    margin-top: 15px;
    font-size: 14px;
    cursor: pointer;
  }
</style>


//  <div class="w60 mauto ptb40">
//       <div class="flex basecolor ft16 jscenter alb tc">
//         <!-- <div class="flex1">{{ $t("about.abt") }}</div> -->
//         <!-- <div class="flex1 tc">{{ $t("about.support") }}</div> -->
//         <!-- <div class="flex1"></div> -->
        
		
		
// 		<p class="textitem flex1" @click="toPathPDF('lhztzm')">{{$t('new.lhztzm')}}</p>
		
// 		<!-- <p class="textitem flex1" @click="govideo">{{$t('new.introdu')}}</p> -->
//         <!-- <div class="flex1">
//             <p>{{$t('new.about')}}</p>
//             <p class="textitem" @click="toPath">{{$t('new.baipi')}}</p>
//             <p class="textitem" @click="govideo">{{$t('new.introdu')}}</p>
//         </div> -->
//         <!-- <div class="flex1 tr">{{ $t("about.concat") }}</div> -->
//       </div>
// 		<!-- <div class="flex basecolor ft16 jscenter alb tc">
// 			<p class="textitem flex1" @click="toPathPDF('gupiao')">{{$t('new.gupiao')}}</p>
// 			<p class="textitem flex1" @click="toPathPDF('gupiaodizhang')">{{$t('new.gupiaodizhang')}}</p>
// 			<p class="textitem flex1" @click="toPathPDF('huiyijilu')">{{$t('new.huiyijilu')}}</p>
// 			<p class="textitem flex1" @click="toPathPDF('zhangcheng')">{{$t('new.zhangcheng')}}</p>
			
// 		</div>  -->
// 		<div class="flex basecolor ft16 jscenter alb tc">
		
// 		</div>
//       <!-- <div class="flex baselight ft14">
//         <div class="flex1">
//           <div
//             class="mt10 pointer"
//             v-for="(item, index) in List1"
//             :key="index"
//             @click="goDetail(item.id, 25)"
//           >
//             {{ item.title }}
//           </div>
//         </div>
//         <div class="flex1 tc">
//           <div
//             class="mt10 pointer"
//             v-for="(item, index) in List2"
//             :key="index"
//             @click="goDetail(item.id, 26)"
//           >
//             {{ item.title }}
//           </div>
//         </div>
//         <div class="flex1 tr">
//           <div class="mt10 pointer" @click="goTicket()">
//             {{ $t("about.submitTicket") }}
//           </div>
//           <div class="mt10 pointer" @click="goline">
//             {{ $t("new.kefu") }}
//           </div>
//           <div class="mt10" v-show="mobile">{{$t('about.mobile')}}：{{mobile}}</div>
//                     <div class="mt10" v-show="email">{{$t('about.email')}}：{{email}}</div>
//         </div>
//       </div> -->

//     </div>
