<template>
    <div class="authentication" >
      <div class="google register-page">
        <div class="mt20 border-b-EEEEEE ht50 lh50 flex alcenter">
                    <!-- <div class="w20 bdr tc">+86</div> -->
                    <!-- <el-select v-model="country_code"  class="w25" @change='changeCountry'>
                        <el-option
                            v-for="item in countries"
                            :key="item.name"
                            :label="'+'+item.global_code"
                            :value="item.id">
                            <span class="fl">{{ item.name }}</span>
                            <span  class="fr ft14">+{{ item.global_code }}</span>
                        </el-option>
                     </el-select> -->
                    <el-select v-model="country_code" :placeholder="$t('add.guoj')"  filterable  class="w30" @change='changeCountry' >
                        <el-option
                            v-for="item in countries"
                            :key="item.id"
                            :label="'+'+item.global_code"
                            :value="item.id">
                            <span class="fl">{{ item.trans_name }}</span>
                            <span  class="fr ft14">+{{ item.global_code }}</span>
                        </el-option>
                     </el-select>
                    <input type="text" class="flex1 h100  pl20 black" v-model="account"  :placeholder="$t('register.enterPhone')">
                </div>
                <div class="mt20 border-b-EEEEEE ht50 lh50 flex alcenter" >
                    <input type="text" class="flex1 h100 bdre7 pl20 black" v-model="sms_code" :placeholder="$t('register.enterCode')">
                    <div class="w20 bdr tc text-clip-green pointer" @click="sendcode" v-show="!hassend">{{$t('login.send')}}</div>
                    <div class="w20 bdr tc text-clip-green "  v-show="hassend">{{second}}s</div>
                </div>
                <div class="mt40 bg-main-liner white tc h48 lh48 radius2 pointer" @click='submit'>{{$t('login.e_confrim')}}</div>
      </div>
    </div>
  </template>
  
  <script>
    
      export default{
          
          data(){
              return{
                index:0,
                    account:'',
                    password:'',
                    re_password:'',
                    invite_code:'',
                    countries: [],
                    country_code: '',
                    sms_code:'',
                    hassend:false,
                    second:60,
                    interid:'',
                    countryCodeId:"",
                    isok:false,
                    read:true,
                    diasabledInput:false,
                    is_quick_register:false,
                    realName:'',
                    idaccount:'',
              }
          },
          mounted() {
            this.$http.initDataToken({url:'default/area_list'},false)
            .then(res=>{
            this.countries=res;
            //    if(res.length>0){
            //     //    this.country_code='+'+res[0].global_code;
            //         this.country_code = res[0].name;
            //         this.countryCodeId = res[0].id;
            //    }
            })
          },
          methods:{
            submit(){
                if(!this.account){
                   
                   return  this.$utils.layerMsg(this.$t('register.emptyPhone'))
               }
               if(!this.$utils.checkMobile(this.account)){
                  
                   return  this.$utils.layerMsg(this.$t('register.pRightPhone'))
               }
               if(!this.sms_code ){
                return  this.$utils.layerMsg(this.$t('register.emptyCode'))
                };
                let code;
                this.countries.forEach(item=>{
                   if(item.id == this.countryCodeId){
                      code  = item.global_code
                   }
                })
                this.$http
                .initDataToken(
                    {
                    url: "user/bind_verify_method",
                    data: {
                        type:'mobile',
                        code:this.sms_code,
                        account:`${code}${this.account}`,
                    },
                    type:"post"
                    },
                    true
                )
                .then(res => {
                    this.$router.go(-1)
                        
                });
            },
            changeCountry(e){
              console.log(e);
                this.countryCodeId = e;
            },
           sendcode(){
                if(!this.account){
                   
                    return  this.$utils.layerMsg(this.$t('register.emptyPhone'))
                }
                if(!this.$utils.checkMobile(this.account)){
                   
                    return  this.$utils.layerMsg(this.$t('register.pRightPhone'))
                }
                let code;
                this.countries.forEach(item=>{
                   if(item.id == this.countryCodeId){
                      code  = item.global_code
                   }
                })
                this.$http.initDataToken({url:'notify/send_sms',type:'POST',data:{
                    to:`${code}${this.account}`,
                    type:1,
                    area_id:this.countryCodeId
                }},true,true,false,true).then(res=>{
                    this.hassend=true;
                    this.interid=setInterval(()=>{
						if(this.second>=1){
							this.second--;
						}else{
                            this.hassend=false
                            this.second = 60 ;
							clearInterval(this.interid);
						}
					},1000)
                })
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
.register-page{
 >>> .el-input__inner{
        border: none;
    }
    .mwidth{
        min-width: 440px;
    }
    .uploads input {
  opacity: 0;
}
}
  </style>
  