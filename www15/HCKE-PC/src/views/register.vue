<template>
    <div class="flex column alcenter jscenter  vh100 bg-main">
        <div class="tc ft20 mb20">{{$t('register.welcome')}}</div>
        <div class="bgwhite radius4 plr20 ptb20 mb50 w25 mwidth">
            <div class="">
                <div class="flex alcenter bold">
                    <div class="pb10 mr20 pointer" :class="{'active2px':index==i}" v-for="(item,i) in infos" :key="i" @click='changeMethod(i)'>{{$t(item)}}</div>
                </div>
                <div class="mt20 bdbe7 radius2 ht50 lh50 flex alcenter">
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
                    <!-- <el-select v-model="country_code"  class="w25" @change='changeCountry'>
                        <el-option
                            v-for="item in countries"
                            :key="item.name"
                            :label="item.name"
                            :value="item.id">
                            <span class="fl">{{ item.name }}</span>
                            <span  class="fr ft14">+{{ item.global_code }}</span>
                        </el-option>
                     </el-select> -->
                    <input type="text" class="flex1 h100 pl20 nwhite" v-model="account" @change="changeAccount" :placeholder="index == 0 ? $t('register.enterPhone') : $t('register.enterEmail')">
                </div>
                <!-- <p class="mt20">
                      {{$t('login.fixedemail1')}} <span class="blue"></span> {{$t('login.fixedemail2')}}
                </p> -->
                <div class="mt20 bdbe7 radius2 ht50 flex alcenter">
                    <input type="text" class="flex1 h100 pl20 nwhite" v-model="sms_code" :placeholder="$t('register.enterCode')">
                    <div class="w20 bdr tc blue pointer flex jscenter alcenter" @click="sendcode" v-show="!hassend">
						<span class="bdle7 plr30 ptb5">{{$t('login.send')}}</span>
					</div>
                    <div class="w20 bdr tc blue "  v-show="hassend">{{second}}s</div>
                </div>
                <div class="mt20 bdbe7 radius2 ht50 lh50 flex alcenter">
                    <input type="password" class="flex1 h100 pl20 nwhite" v-model="password" :placeholder="$t('register.enterPassword')">
                </div>
                <div class="mt20 bdbe7 radius2 ht50 lh50 flex alcenter">
                    <input type="password" class="flex1 h100 pl20 nwhite" v-model="re_password" :placeholder="$t('register.enterPassword2')">
                </div>
                <!-- <div class="mt20 bdbe7 radius2 ht50 lh50 flex alcenter">
                    <input type="text" class="flex1 h100 pl20 nwhite" v-model="invite_code" :placeholder="$t('register.invitationCode')">
                </div> -->
                <div class="flex alcenter mt10">
					<el-checkbox v-model="read">{{$t('login.p_private')}}</el-checkbox>
					<!-- <input type="checkbox" v-model="read"> -->
                   <!-- <p class="pl5 ft16 gray9 flex alcenter">
                        <span class="blue pl5 pointer" @click="goDetail(95,26)" >{{$t('login.p_private')}}</span>
                    </p> -->
                </div>
                <div class="mt40 bgblue white tc h48 lh48 radius2 pointer" @click='register'>{{$t('register.register')}}</div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            infos:['','login.r_email'],
            index:1,
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
        }
    },
    created(){
        // 获取国家
        // this.$http.initDataToken({url:'default/area_list'},false)
        // .then(res=>{
        //    this.countries=res;
        //    if(res.length>0){
        //     //    this.country_code='+'+res[0].global_code;
        //         this.country_code = res[0].name;
        //         this.countryCodeId = res[0].id;
        //    }
        // })
        this.country_code = "";
        this.countryCodeId = 1;
        //获取邀请码
        if(this.$route.query.extension_code){
            this.invite_code = this.$route.query.extension_code || '';
            this.diasabledInput = true;
        }
        let that = this;
        document.onkeypress = function(e) {
            var keycode = document.all ? event.keyCode : e.which;
            if (keycode == 13) {
                that.register();
                return false;
            }
        };
    },
    methods:{
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
            if(this.index==0){
                this.verifyAccount(this.index);
                if(!this.isok){
                    return;
                }
                this.$http.initDataToken({url:'notify/send_sms',type:'POST',data:{
                    to:this.account,
                    type:1,
                    area_id:this.countryCodeId
                }}).then(res=>{
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
                }}).then(res=>{
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
				sms_code:this.sms_code
            }
            // this.index==0?data.country_code=this.country_code-0:'';
            data.type = this.index==0 ? 'mobile':'email';
            if(!this.sms_code){
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
            this.$http.initDataToken({url:'user/register',data,type:'POST'})
            .then(res=>{
                console.log(res);
                setTimeout(() => {
                     this.$router.push({name:'login'})
                }, 500);

            })
        },
        verifyAccount(ismobile){
             if(ismobile==0){
                if(!this.account){
                    this.isok = false;
                    return  this.$utils.layerMsg(this.$t('register.emptyPhone'))
                }
                if(!this.$utils.checkMobile(this.account)){
                    this.isok = false;
                    return  this.$utils.layerMsg(this.$t('register.pRightPhone'))
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
<style lang="">
    .el-input__inner{
        border: none;
    }
    .mwidth{
        min-width: 440px;
    }
</style>
