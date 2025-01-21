<template>
    <div class="flex column alcenter jscenter  vh100 bg-main">
        <div class="tc ft20 mb20 white">{{$t('login.welcome')}}</div>
        <div class="bgwhite radius10 plr20 ptb20 mb50" style="width:450px">
            <div>
                <div class="flex alcenter bold">
                    <div class="pb10 mr20 ft14" :class="{'text-main active2px': i==index}" v-for="(item,i) in infos" :key="i">{{$t(item)}}</div>
                </div>
                <div class="mt20 radius4 ht50 lh50 flex alcenter" style="border:0px solid #eee;border-bottom-width:1px">
                    <div class="black ft14">{{$t('login.e_email')}}:</div>
                    <!-- <div class="w20 bdr tc">+86</div> -->
                   <!-- <el-select v-model="country_code"  class="w25" @change='changeCountry' v-show="index==0">
                        <el-option 
                            v-for="(item,index) in countries"
                            :key="index"
                            :label="'+'+item.global_code"
                            :value="item.id">
                            <span class="fl">{{ item.name }}</span>
                            <span  class="fr ft14">+{{ item.global_code }}</span>
                        </el-option>
                     </el-select> -->
                    <input type="text" class="flex1 h100  pl20 ft14" v-model="account" @change="changeAccount" :placeholder="index == 0 ? $t('register.enterPhone') : $t('register.enterEmail')">
                </div>
                <div class="mt20 radius2 ht50 lh50 flex alcenter" style="border:0px solid #eee;border-bottom-width:1px">
                    <div class="black ft14">{{$t('login.pwd')}}:</div>
                    <input type="password" class="flex1 h100  pl20  ft14" v-model="password" :placeholder="$t('register.enterPassword')">
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
						<el-checkbox v-model="remember" text-color="#057967" fill="#057967">{{$t('login.rem_pwd')}}</el-checkbox>
                    </p>
                    <router-link to="/forgetPassword" class="text-main ft16">{{$t('login.forget_pwd')}}？</router-link>
                </div>
                <div class="mt40 bg-main white tc h48 lh48 radius2 pointer ft20" @click='login'>{{$t('login.login')}}</div>
                 <div class="mt10 bg-main white tc h48 lh48 radius2 pointer ft20" @click='register'>{{$t('register.register')}}</div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            // infos:['login.phoneLogin','login.emailLogin'],
            infos:['','login.emailLogin'],
            index:1,
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
            remember:false,
        }
    },
    created(){
        // var types = this.$route.query.type;
        // if(types == 1){
        //     window.location.reload();
        //     type = 2;
        // }
        this.index = localStorage.getItem('actives') || 1;
        this.remember = localStorage.getItem('remember')=='true' ? true:false;
        if(this.remember===true){
            this.password = localStorage.getItem('password');
            this.account = localStorage.getItem('accountNumber');
        }
        // 获取国家
        // this.$http.initDataToken({url:'default/area_list'},false)
        // .then(res=>{
        //    this.countries=res;
        //    if(res.length>0){
        //        this.country_code='+'+res[0].global_code;
        //        this.countryCodeId = res[0].id;
        //    }
        // })
        this.country_code='+00';
        this.countryCodeId = 1;
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
        register(){
             this.$router.push({ name: "register" });
        },
        changeCountry(e){
            console.log(e);
            this.countryCodeId = e;
        },
        changeMethod(e){
            var loginindex = localStorage.getItem('actives');        
            this.index=e;
            this.hassend=false;
            if(loginindex!=''){
                if(this.remember===true){
                    if(loginindex==this.index){
                        this.password = localStorage.getItem('password');
                        this.account = localStorage.getItem('accountNumber');
                    }else{
                        this.password = '';
                        this.account = '';
                    }
                }
            }
            if(this.interid){
                clearInterval(this.interid)
            }
        },
        // 发送验证码
        sendcode(){
            if(this.hassend){
                return ;
            }
            // 手机
            if(this.index==0){
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
            console.log(this.index);
            let login_type = this.index==0?'mobile':'email';
            var data={
                account: this.account,
                password: this.password,
                sms_code: this.sms_code,
                login_type:login_type
            }
            this.index==0?data.country_code=this.country_code-0:'';
            if(!this.password){
                return  this.$utils.layerMsg(this.$t('register.emptyPassword'))
            }
            if(this.isshowCode&&!this.sms_code){
                return  this.$utils.layerMsg(this.$t('register.emptyCode'))
            }
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
                this.$emit('getUserinfo',this.$route.query.page);

                // alert(this.$route.query.redirect);
                // setTimeout(() => {
                //      this.$router.push({path:this.$route.query.page})
                // }, 200);
               
            })
        },
        verifyAccount(ismobile){
            if(ismobile==0){
                if(!this.account){
                    this.isok = false;
                    return  this.$utils.layerMsg(this.$t('register.emptyPhone'))
                }
                // if(!this.$utils.checkMobile(this.account)){
                //     this.isok = false;
                //     return  this.$utils.layerMsg(this.$t('register.pRightPhone'))
                // }
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
<style lang="">
    .el-input__inner{
        border: none;
    }
    .mwidth{
        min-width: 440px;
    }
</style>