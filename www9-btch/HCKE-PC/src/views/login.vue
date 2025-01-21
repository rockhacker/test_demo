<template>
    <div class="flex alcenter jscenter  minvh100 bg-main-liner login-page">
        <div class="bgwhite radius4 plr60 ptb40 mb50 w25 mwidth">
            <div class="tc ft20 text-333333">{{$t('login.welcome')}}</div>
            <div class="mt40 ">
                <div class="bold">
                    <span v-show="i!=0" class=" ft14 pointer" @click='changeMethod(i)' :class="{'active2px text-2DBD96':index==i,'mr20':i!=2}" v-for="(item,i) in infos" :key="i"><span>{{$t(item)}}</span></span>
                </div> 
                <div class="mt20 radius2 ht50 lh50 flex alcenter border-b-EEEEEE">
                    <!-- <div class="w20 bdr tc">+86</div> -->
                   <el-select v-model="country_code" :placeholder="$t('add.guoj')"  class="w25 black" @change='changeCountry' v-show="index==1">
                        <el-option 
                            v-for="(item,index) in countries"
                            :key="index"
                            :label="'+'+item.global_code"
                            :value="item.id">
                            <span class="fl">{{ item.trans_name }}</span>
                            <span  class="fr ft14">+{{ item.global_code }}</span>
                        </el-option>
                     </el-select>
                    <input type="text" class="flex1 h100  pl20 black ft14" v-model="account" @change="changeAccount" :placeholder="index == 1 ? $t('register.enterPhone') : index == 0 ? $t('add.playhm') : $t('register.enterEmail')">
                </div>
                <div class="mt20 border-b-EEEEEE radius2 ht50 lh50 flex alcenter">
                    <input type="password" class="flex1 h100  pl20 black ft14" v-model="password" :placeholder="$t('register.enterPassword')">
                </div>
                <!-- <div class="mt20 bde7 radius2 ht50 lh50 flex alcenter" v-if="isshowCode">
                    <input type="text" class="flex1 h100 bdre7 pl20 nwhite" v-model="sms_code">
                    <div class="w20 bdr tc blue pointer" @click="sendcode" v-show="!hassend">{{$t('login.send')}}</div>
                    <div class="w20 bdr tc blue "  v-show="hassend">{{second}}s</div>
                </div> -->
                <div class="flex between alcenter mt10">
                    <p class="flex alcenter">
                        <!-- <input type="checkbox" v-model="remember"  name="" id="">
						<span class="pl5 ft16 gray9">{{$t('login.rem_pwd')}}</span> -->
						<el-checkbox v-model="remember" text-color="#fff" fill="#FCD535">{{$t('login.rem_pwd')}}</el-checkbox>
                    </p>
                    <router-link to="/forgetPassword" class="ft16"><span class="text-clip-green">{{$t('login.forget_pwd')}}</span></router-link>
                </div>
                <div class="mt40 bg-main-liner white tc h48 lh48 radius2 pointer ft20" @click='login'>{{$t('login.login')}}</div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            // infos:['login.phoneLogin','login.emailLogin'],
            infos:['add.login_yhm','login.l_mobile','login.l_email'],
            index:2,
            account:'',
            password:'',
            countries: [],
            country_code: '',
            sms_code:'',
            isshowCode:true,
            hassend:false,
            second:60,
            interid:'',
            countryCodeId:"",
            isok:false,
            remember:false
        }
    },
    created(){
        // var types = this.$route.query.type;
        // if(types == 1){
        //     window.location.reload();
        //     type = 2;
        // }
        // this.index = localStorage.getItem('actives') || 1;
        this.remember = localStorage.getItem('remember')=='true' ? true:false;
        if(this.remember===true){
            this.password = localStorage.getItem('password');
            this.account = localStorage.getItem('accountNumber');
        }
        // 获取国家
        this.$http.initDataToken({url:'default/area_list'},false)
        .then(res=>{
           this.countries=res;
        //    if(res.length>0){
        //        this.country_code='+'+res[0].global_code;
        //        this.countryCodeId = res[0].id;
        //    }
        })
        // this.country_code='+00';
        // this.countryCodeId = 1;
        // 获取是否显示验证码框
        this.$http.initDataToken({url:'default/setting',data:{key:'login_use_sms'}},false)
        .then(res=>{
            this.isshowCode=res==1?true:false;
        })
        let that = this;
        document.onkeypress = function(e) {
            var keycode = document.all ? event.keyCode : e.which;
            if (keycode == 13) {
                that.login();
                return false;
            }
        };
    },
    methods:{
        changeCountry(e){
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
            // var loginindex = localStorage.getItem('actives');        
            // this.index=e;
            // this.hassend=false;
            // if(loginindex!=''){
            //     if(this.remember===true){
            //         if(loginindex==this.index){
            //             this.password = localStorage.getItem('password');
            //             this.account = localStorage.getItem('accountNumber');
            //         }else{
            //             this.password = '';
            //             this.account = '';
            //         }
            //     }
            // }
            // if(this.interid){
            //     clearInterval(this.interid)
            // }
        },
        // 发送验证码
        sendcode(){
            if(this.hassend){
                return ;
            }
            // 手机
            if(this.index==1){
                this.verifyAccount(this.index);
                this.$http.initDataToken({url:'notify/send_sms',type:'POST',data:{
                    to:this.account,
                    type:5,
                    area_id:this.countryCodeId
                }}).then(res=>{
                    this.hassend=true;
                    this.interid=setInterval(()=>{
						if(this.second>=1){
							this.second--;
						}else{
                            this.hassend=false;
                            this.second = 60;
							clearInterval(this.interid);
						}
					},1000)
                })
            }else{
                // 邮箱验证码
                this.verifyAccount(this.index);
                this.$http.initDataToken({url:'notify/send_email',type:'POST',data:{
                    to:this.account,
                    type:5,
                    area_id:this.countryCodeId-0
                }}).then(res=>{
                    this.hassend=true;
                    this.interid=setInterval(()=>{
						if(this.second>=1){
							this.second--;
						}else{
                            this.hassend=false;
                            this.second = 60;
							clearInterval(this.interid);
						}
					},1000)
                })
            }
            // 邮箱
        },
        // 登录
        login(){
            this.verifyAccount(this.index);
            if(!this.isok){
                return;
            }
            let login_type =  this.index==1 ? 'mobile': this.index== 0? 'account': 'email';
            var data={
                account: this.account,
                password: this.password,
                sms_code: this.sms_code,
                login_type:login_type,
                area_id:this.countryCodeId,
            }
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
            this.index==0?data.country_code=this.country_code-0:'';
            if(!this.password){
                return  this.$utils.layerMsg(this.$t('register.emptyPassword'))
            }
            // if(this.isshowCode&&!this.sms_code){
            //     return  this.$utils.layerMsg(this.$t('register.emptyCode'))
            // }
            this.$http.initDataToken({url:'user/login',data,type:'POST'})
            .then(res=>{
                console.log(res);
                localStorage.setItem('token',res);
                localStorage.setItem('accountNumber',this.account);
                localStorage.setItem('codeId',this.countryCodeId);
                localStorage.setItem('remember',this.remember);
                localStorage.setItem('actives',this.index);
                if(this.remember){
                    localStorage.setItem('password',this.password);
                }
                const page =
                    this.$route.query.page &&!this.$route.query.page.includes('/login') 
                    ? this.$route.query.page
                    : '/home'
                this.$emit('getUserinfo', page)

                // alert(this.$route.query.redirect);
                // setTimeout(() => {
                //      this.$router.push({path:this.$route.query.page})
                // }, 200);
               
            })
        },
        verifyAccount(ismobile){
            if(ismobile==1){
                if(!this.account){
                    this.isok = false;
                    return  this.$utils.layerMsg(this.$t('register.emptyPhone'))
                }
                // if(!this.$utils.checkMobile(this.account)){
                //     this.isok = false;
                //     return  this.$utils.layerMsg(this.$t('register.pRightPhone'))
                // }
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
                    this.$utils.layerMsg(this.$t('register.emptyEmail'))
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
        
    },
   
}
</script>
<style lang="scss">
.login-page{
 .el-input__inner{
        border: none;
    }
    .mwidth{
        min-width: 440px;
    }
}
</style>
<style scoped>
.mt20 >>> .el-input__inner{
        color: #000 !important;
}
</style>