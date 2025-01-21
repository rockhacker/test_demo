<template>
    <div class="authentication" >
      <steps  v-show="$route.query.isReg == 1" style="margin: 0 auto;" :active="3"></steps>
      <div class="google  pb20 pt20 bg-white dark:bg-1C2532 px-40" v-if="!verified">
          <div class="bold ft24 tc">{{ $t('add.zccg') }}</div>
          <div class="flex item mt20" @click="path('/trade')">
              <div class="text">
                 <div class="ft18">{{$t('add.wxy')}}</div>
                 <div class="ft14 flex alcenter">{{$t('add.qjy') }} <span class="ft18 pl10">➯</span></div>
              </div>
              <img src="../../assets/images/mb.png" class="item-img" alt="">
          </div>
          <div class="flex item mt20"  @click="path('/legalIndex/legal')">
              <div class="text">
                 <div class="ft18">{{$t('add.xycz')}}</div>
                 <div class="ft14 flex alcenter">{{$t('add.qjy') }}  <span class="ft18 pl10">➯</span></div>
              </div>
              <img src="../../assets/images/cz.png" class="item-img"  alt="">
          </div>
          <div  class="bg-main-liner pointer w-full ht40 flex alcenter jscenter mt40 white radius6 ft16" @click="path('/home')">{{ $t("login.e_confrim") }}</div>
      </div>
    </div>
  </template>
  
  <script>
      import steps from '@/components/step.vue';
      export default{
          components: {
             steps
          },
          data(){
              return{
                passwordArr:[],
                qrObj:{},
                isReg:'',
                verified:false,
                isKey:false
              }
          },
          mounted() {
           
             
          },
          methods:{
            path(url){
                this.$router.push(url)
            }
          }
      }
  </script>
    <style lang="scss" scoped>
    .google{
      width: 440px;
      background: #fff;
      margin:0 auto;
      padding:20px 20px;
    }
  .authentication{
    min-height: calc(100vh - 60px);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    }
    .item{
    background: #f6f6f6;
    padding:15px 20px;
    justify-content: space-between;
    border-radius: 5px;
    .text{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .item-img{
        width: 66px;
        height: 72px;
    }
   }
   .mt20  .checklist-text{
    font-size: 12px;
   }
  </style>
  