<template>
    <div class="flex alcenter jscenter  vh100 ">
        <div class="bgpart radius4 plr60 ptb40 mb50 w25 mwidth">
            <div class="tc ft20">{{$t('login.welcome')}}</div>
            <div class="mt40 ">
                <div class="bdbea2 flex alcenter bold">
                    <div v-show="i==1" class="pb10 mr20 pointer ft14" :class="{'active2px':index==i}" v-for="(item,i) in infos" :key="i" @click='changeMethod(i)'>{{$t(item)}}</div>
                </div>
                <div class="mt20 bde7 radius2 ht50 lh50 flex alcenter">
                    <!-- <div class="w20 bdr tc">+86</div> -->
                   <el-select v-model="country_code"  class="w25" @change='changeCountry' v-show="index==0">
                        <el-option 
                            v-for="(item,index) in countries"
                            :key="index"
                            :label="item.global_code"
                            :value="item.id">
                            <span class="fl">{{ item.name }}</span>
                            <span  class="fr ft14">+{{ item.global_code }}</span>
                        </el-option>
                     </el-select>
                    <input type="text" class="flex1 h100 bdle7 pl20 nwhite ft14" v-model="account" @change="changeAccount" :placeholder="index == 0 ? $t('register.enterPhone') : $t('register.enterEmail')">
                </div>
                <div class="mt20 bde7 radius2 ht50 lh50 flex alcenter">
                    <input type="password" class="flex1 h100 bdle7 pl20 nwhite ft14" v-model="password" :placeholder="$t('register.enterPassword')">
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
                    <router-link to="/forgetPassword" class="blue ft16">{{$t('login.forget_pwd')}}？</router-link>
                </div>
                <div class="mt40 bgblue white tc h48 lh48 radius2 pointer ft20" @click='login'>{{$t('login.login')}}</div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            infos:['login.phoneLogin','login.emailLogin'],
            index:1,
            account:'',
            password:'',
            countries: [],
            country_code: ' ',
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
        this.$http.initDataToken({url:'default/area_list'},false)
        .then(res=>{
            res.sort(function (s1, s2) {
						const x1 = s1.code.toUpperCase();
						const x2 = s2.code.toUpperCase();
						if (x1 < x2) {
							return -1;
						}
						if (x1 > x2) {
							return 1;
						}
						return 0;
					}); 
           this.countries=res;
           if(res.length>0){
               this.country_code=res[0].global_code;
               this.countryCodeId = res[0].id;
           }
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
    computed:{
        getCountryCode(){
            return this.countries.find((item)=> item.id == this.countryCodeId).global_code;
        }
    },
    methods:{
        changeCountry(e){
            console.log(e);
            this.countryCodeId = e;
            console.log(this.getCountryCode,22);
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
            let login_type = this.index==0?'mobile':'email';
            var data={
                account: this.index==0?`${this.getCountryCode}${this.account}`:this.account,
                password: this.password,
                sms_code: this.sms_code,
                login_type:login_type
            }
            // this.index==0?data.country_code=this.country_code-0:'';
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