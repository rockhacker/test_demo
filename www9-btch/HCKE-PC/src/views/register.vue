<template>
    <div class="flex column alcenter jscenter bg-main-liner minvh100 register-page">
        <div class="bgwhite  ptb40 w25 mwidth">
            <step style="margin:0 auto;"></step>
            <div class="tc mt10 ft20 text-333333">{{$t('register.welcome')}}</div>
            <div class="mt30 plr60">
                <div class=" flex alcenter bold">
                    <div  v-show="i!=0"  class="pb10 mr20 pointer" :class="{'active2px text-2DBD96':index==i}" v-for="(item,i) in infos" :key="i" @click='changeMethod(i)'>{{$t(item)}}</div>
                </div>
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
                    <el-select v-model="country_code" :placeholder="$t('add.guoj')"  filterable  class="w30" @change='changeCountry' v-if="index == 1">
                        <el-option
                            v-for="item in countries"
                            :key="item.id"
                            :label="'+'+item.global_code"
                            :value="item.id">
                            <span class="fl">{{ item.trans_name }}</span>
                            <span  class="fr ft14">+{{ item.global_code }}</span>
                        </el-option>
                     </el-select>
                    <input type="text" class="flex1 h100  pl20 black" v-model="account" @change="changeAccount" :placeholder="index == 1 ? $t('register.enterPhone') : index == 0 ? $t('add.plauser') : $t('register.enterEmail')">
                </div>
                <!-- <p class="mt20">
                      {{$t('login.fixedemail1')}} <span class="blue"></span> {{$t('login.fixedemail2')}}
                </p> -->
                <div class="mt20 border-b-EEEEEE ht50 lh50 flex alcenter" v-if="index == 2">
                    <input type="text" class="flex1 h100 bdre7 pl20 black" v-model="sms_code" :placeholder="$t('register.enterCode')">
                    <div class="w20 bdr tc text-clip-green pointer" @click="sendcode" v-show="!hassend">{{$t('login.send')}}</div>
                    <div class="w20 bdr tc text-clip-green "  v-show="hassend">{{second}}s</div>
                </div>
                <div class="mt20 border-b-EEEEEE ht50 lh50 flex alcenter">
                    <input type="password" class="flex1 h100  pl20 black" v-model="password" :placeholder="$t('register.enterPassword')">
                </div>
                <div class="mt20 border-b-EEEEEE ht50 lh50 flex alcenter">
                    <input type="password" class="flex1 h100  pl20 black" v-model="re_password" :placeholder="$t('register.enterPassword2')">
                </div>
                <div class="mt20 border-b-EEEEEE ht50 lh50 flex alcenter">
                    <input type="text" class="flex1 h100  pl20 black" v-model="invite_code" :placeholder="$t('register.invitationCode')">
                </div>
                <template v-if="is_quick_register">
                    <div class="mt20 border-b-EEEEEE ht50 lh50 flex alcenter">
                    <input type="text" class="flex1 h100  pl20 black" v-model="realName" :placeholder="$t('collect.pleaseenteraname')">
                    </div>
                    <div class="mt20 border-b-EEEEEE ht50 lh50 flex alcenter">
                        <input type="text" class="flex1 h100  pl20 black" v-model="idaccount" :placeholder="$t('collect.p_cardno')">
                    </div>

                    <div class="mt20">
                        <div class="">{{ $t("collect.upImg") }}</div>
                        <div class="flex column">
                            <div class="flex1">
                            <div class="uploads wt240 ht130 posRelt pointer" style="margin:0 auto">
                                <img :src="src1" class="w100 h100" alt />
                                <input
                                type="file"
                                class="w100 h100 abstort lf0 btm0"
                                accept="image/*"
                                name="file"
                                @change="upload(1)"
                                />
                            </div>
                            </div>
                            <div class="flex1">
                            <div class="uploads wt240 ht130 posRelt pointer" style="margin:0 auto">
                                <img :src="src2" class="w100 h100" alt />
                                <input
                                type="file"
                                class="w100 h100 abstort lf0 btm0 black"
                                accept="image/*"
                                name="file"
                                @change="upload(2)"
                                />
                            </div>
                            </div>
                        </div>
                    </div>

                </template>
                 

                <div class="flex alcenter mt10">
					<el-checkbox v-model="read">{{$t('login.p_private')}}</el-checkbox>
					<!-- <input type="checkbox" v-model="read"> -->
                   <!-- <p class="pl5 ft16 gray9 flex alcenter">
                        <span class="blue pl5 pointer" @click="goDetail(95,26)" >{{$t('login.p_private')}}</span>
                    </p> -->
                </div>
                <div class="mt40 bg-main-liner white tc h48 lh48 radius2 pointer" @click='register'>{{$t('register.register')}}</div>
            </div>
        </div>
    </div>
</template>
<script>
import step from '@/components/step'
export default {
    components:{step},
    data(){
        return {
            infos:['add.yhm','login.r_mobile','login.r_email'],
            index:2,
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
            src1: require("@/assets/images/1614569942(1).jpg"),
            src2: require("@/assets/images/1614588414(1).jpg"),
            src3: require("@/assets/images/real3.png"),
            authStatus: 0,
            src1Status:false,
            src2Status:false,
            src3Status:false,
        }
    },
    created(){
        // 获取国家
        this.$http.initDataToken({url:'default/area_list'},false)
        .then(res=>{
           this.countries=res;
        //    if(res.length>0){
        //     //    this.country_code='+'+res[0].global_code;
        //         this.country_code = res[0].name;
        //         this.countryCodeId = res[0].id;
        //    }
        })
        // this.country_code = "";
        // this.countryCodeId = 1;
        //获取邀请码
        if(this.$route.query.extension_code){
            this.invite_code = this.$route.query.extension_code || '';
            this.diasabledInput = true;
        }
        let that = this;

        this.$http.initDataToken({url:'/default/setting?key=is_quick_register'},false)
        .then(res=>{
           that.is_quick_register = res ==1
           console.log(that.is_quick_register );
        })

        document.onkeypress = function(e) {
            var keycode = document.all ? event.keyCode : e.which;
            if (keycode == 13) {
                that.register();
                return false;
            }
        };
    },
    methods:{
         //   上传图片
    upload(options) {
      let that=this
      this.ossFileUpload(event.target.files[0],res=>{
                  if (options == 1) {
                    that.src1 = res.url;
                    that.src1Status = true;
                  } else if (options == 2) {
                    that.src2 = res.url;
                    that.src2Status = true;
                  } else if (options == 3) {
                    that.src3 = res.url;
                    that.src3Status = true;
                  }
      })
      // var that = this;
      // var datas = new FormData();
      // datas.append("file", event.target.files[0]);
      // that.$http
      //   .initDataToken(
      //     {
      //       url: "common/image_upload",
      //       data: datas,
      //       type: "POST"
      //     },
      //     false,
      //     true,
      //     true
      //   )
      //   .then(res => {
      //     if (options == 1) {
      //       that.src1 = res.url;
      //       that.src1Status = true;
      //     } else if (options == 2) {
      //       that.src2 = res.url;
      //       that.src2Status = true;
      //     } else if (options == 3) {
      //       that.src3 = res.url;
      //       that.src3Status = true;
      //     }
      //   });
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
        changeCountry(e){
            console.log(e);
            this.countryCodeId = e;
        },
        changeMethod(e){
            this.index=e;
            this.hassend=false;
            if(this.interid){
                clearInterval(this.interid)
            }
            this.second = 60;
            this.account='';
            this.password='';
            this.re_password='';
            this.sms_code='';
        },
        // 发送验证码
        sendcode(){
            if(this.hassend){
                return ;
            }

            // 手机
            if(this.index==1){
                this.verifyAccount(this.index);
                if(!this.isok){
                    return;
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
            }else{
                // 邮箱验证码
                this.verifyAccount(this.index);
                if(!this.isok){
                    return;
                }
                this.$http.initDataToken({url:'notify/send_email',type:'POST',data:{
                    to:this.account,
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
            // 邮箱
        },
        // 注册
        register(){
            this.verifyAccount(this.index);
            if(!this.isok){
                return;
            }
             if(!this.read){
                return this.$utils.layerMsg(this.$t('login.p_first'))
            }
            var data={
                account: this.account,
				password: this.password,
				invite_code: this.invite_code,
				re_password:this.re_password,
				area_id:this.countryCodeId,
				sms_code:this.sms_code,
                name: this.realName,
                card_id: this.idaccount,
                front_pic: this.src1,
                reverse_pic: this.src2,
            }
            console.log(data);
            if(this.index == 1){
                //.forEach
                this.countries.forEach(item=>{
             //       console.log(item)
          // console.log(this.countryCodeId)
                   if(item.id == this.countryCodeId){
                     data.account  = `${item.global_code}${this.account}`
                   }
                })
               
            }
            // this.index==0?data.country_code=this.country_code-0:'';
            data.type = this.index==1 ? 'mobile': this.index==0 ? 'account': 'email';
            if(!this.sms_code && this.index == 2){
                return  this.$utils.layerMsg(this.$t('register.emptyCode'))
            };
            if(!this.password){
                return this.$utils.layerMsg(this.$t('register.emptyPassword'))
            };
            if(!this.$utils.checkPassword(this.password)){
                return  this.$utils.layerMsg(this.$t('register.length'))
            };
            if(!this.re_password){
                return this.$utils.layerMsg(this.$t('register.enterPassword2'))
            };
            if(this.password!=this.re_password){
                return this.$utils.layerMsg(this.$t('register.unlike'))
            }

            let that = this;

            if(this.is_quick_register){
                 if(!that.realName){
                    that.$utils.layerMsg(this.$t('collect.p_name'));
                    return false;
                }
                if(!that.idaccount){
                    that.$utils.layerMsg(this.$t('collect.p_cardno'));
                    return false;
                }
                if(!that.src1Status){
                    that.$utils.layerMsg(this.$t('collect.up_cardz'));
                    return false;
                }
                if(!that.src2Status ){
                    that.$utils.layerMsg(this.$t('collect.up_cardf'));
                    return false;
                }
            }

            this.$http.initDataToken({url:'user/register',data,type:'POST'})
            .then(res=>{
                console.log(res);
                setTimeout(() => {
                    //  this.$router.push({name:'login'})
                    localStorage.setItem('token',res.token);
                     this.$emit('getUserinfo', '/tradePassword?isReg=1')
                }, 500);

            })
        },
        verifyAccount(ismobile){
             if(ismobile==1){
                if(!this.account){
                    this.isok = false;
                    return  this.$utils.layerMsg(this.$t('register.emptyPhone'))
                }
                if(!this.$utils.checkMobile(this.account)){
                    this.isok = false;
                    return  this.$utils.layerMsg(this.$t('register.pRightPhone'))
                }
            }else if(ismobile == 0){
                if(!this.account){
                    this.isok = false;
                    return  this.$utils.layerMsg(this.$t('add.playhm'))
                }
                if(!this.$utils.checkUser(this.account)){
                    this.isok = false;
                    return  this.$utils.layerMsg(this.$t('add.plauser'))
                }  
            }else{
                if(!this.account){
                    this.isok = false;
                    this.$utils.layerMsg(this.$t('register.pRightEmail'))
                }
                if(!this.$utils.checkEmail(this.account)){
                    this.isok = false;
                    return  this.$utils.layerMsg(this.$t('register.pRightEmail'))
                }
            }
            this.isok = true;
        },
        // 改变账号
        changeAccount(){
            this.hassend=false;
            if(this.interid){
                clearInterval(this.interid)
            }
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

    },

}
</script>
<style lang="scss">
.register-page{
 .el-input__inner{
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
<style scoped>
.mt20 >>> .el-input__inner{
        color: #000 !important;
}
</style>