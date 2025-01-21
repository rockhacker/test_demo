<template>
  <div class="baselight">
    <div class="flex between baselight2 ptb20 plr20 ft16 bgwhite dark-bg-1C2532">
      <div class="flex alcenter">
        <div class="w-3 h-14 bg-main-liner mr10"></div>
        <span>{{$t('assets.allAssets')}}: <span class="text-clip-green">${{changeData.convert_usd}}</span></span>
      </div>
      <router-link :to="{name:'dealRecords',query:{types:changeData.account_code}}" class="text-333333 dark-text-white">{{$t('assets.records')}}</router-link>
    </div>
    <div class="ptb10">
      <div class="flex alcenter baselight mb10 plr20">
        <span class="flex1">{{$t('assets.currency')}}</span>
        <span class="flex1 tc">{{$t('assets.use')}}</span>
        <span class="flex1 tc">{{$t('assets.UnderReview')}}</span>
        <span class="flex1 tc">{{$t('assets.zhehe')}}($)</span>
        <span class="flex1 tr" v-if="changeData.is_recharge==1">{{$t('assets.operate')}}</span>
      </div>
      <div v-for="(item,i) in coinlist" :key="i" v-if="item.currency.open_draw==1">
        <div class="flex alcenter ptb10 bdbheader plr20">
          <span class="flex1">{{item.currency_code}}</span>
          <span class="flex1 tc">{{item.balance}}</span>
          <span class="flex1 tc">{{item.lock_balance}}</span>
          <span class="flex1 tc">{{item.convert_usd}}</span>
          <div class="flex1 tr baselight2" v-if="changeData.is_recharge==1">
            <!-- <el-button   class="bg-main-liner white" style="padding: 4px" size="mini" @click="showInfo(item,i,'charge')" :disabled="!(item.currency&&item.currency.open_recharge==1)">{{$t('assets.charge')}}</el-button> -->
            <!-- <span
              class="pointer"
              @click="showInfo(item,i,'charge')"
              v-if="item.currency&&item.currency.open_recharge==1"
            >{{$t('assets.charge')}} </span>
            <span class="gray9" disabled v-else>{{$t('assets.charge')}}</span> -->
            <el-button class="bg-main-liner white" style="padding: 4px" size="mini" @click="showInfo(item,i,'mention')" :disabled="!(item.currency&&item.currency.open_draw==1)">{{$t('assets.mention')}}</el-button>
            <!-- <span
              class="pointer"
              @click="showInfo(item,i,'mention')"
              v-if="item.currency&&item.currency.open_draw==1"
            >{{$t('assets.mention')}}</span>
            <span class="gray9" disabled v-else>{{$t('assets.mention')}}</span> -->
            <!-- <span
              v-if="item.currency&&item.currency.is_recharge_account&&item.currency.account_types.length >1"
            >划转</span>-->
          </div>
        </div>
        <!-- 充币 -->
        <div class="mlr20 mtb20 radius2 bdheader ptb20 plr20" v-show="curindex==i&&infotype=='charge'">
          <div
            class="mb20"
            v-if="chargeInfo.chargeData&&chargeInfo.chargeData.wallets&&chargeInfo.chargeData.wallets.length >1"
          >
            <p>{{$t('assets.chainName')}}</p>
            <ul class="flex mt10">
              <li
                class="mr20 bdheader ptb5 plr15 radius4"
                :class="chargeInfo.chargeType==item.chain_protocol.code?'border-2FA079 text-2FA079':''"
                v-for="(item,index) in chargeInfo.chargeData.wallets"
                :key="index"
                @click="selectChargeType(item,'charge')"
              >{{item.chain_protocol.code}}</li>
            </ul>
          </div>
          <div class="flex alcenter" v-if="chargeInfo.chargeText">
            <p>{{chargeInfo.chargeText}}</p>
            <p
              class="text-2FA079 ml30 pointer copyLabel"
              @click="copy(chargeInfo.chargeText,'.copyLabel')"
            >{{$t('assets.label')}}</p>
          </div>
          <div class="mt10">
            <p class="ft14">{{$t('assets.addr_charge')}}</p>
            <div class="mt10 flex alcenter">
              <p class="ft16">{{chargeInfo.chargeAddress}}</p>
              <p
                class="text-2FA079 ml30 pointer copy"
                @click="copyContent(chargeInfo.chargeAddress,'.copy')"
              >{{$t('assets.copy')}}</p>
              <div class="posRelt">
                <p class="text-2FA079 ml30 pointer" @click="chargeInfo.codeShow=!chargeInfo.codeShow">{{$t('assets.qrCode')}}</p>
                <div class="inblock plr10 ptb10 bgwhite abstort mt10" v-show="chargeInfo.codeShow">
                  <vue-qr
                    :text="chargeInfo.chargeAddress"
                    :margin="0"
                    colorDark="#000000"
                    colorLight="#fff"
                    :size="100"
                  ></vue-qr>
                </div>
              </div>
            </div>
          </div>
          <div class="mt20">
            <p>{{$t('assets.reminder')}}</p>
            <!-- <p class="mt5">• {{$t('assets.c_tip2_1')}}{{chargeInfo.chargeData.code}}{{$t('assets.c_tip2_2')}}，{{$t('assets.c_tip2_3')}}。</p> -->
            <p class="mt5">• {{chargeInfo.chargeData.code}}{{$t('assets.c_tip3')}}。</p>
            <p class="mt5">• {{$t('assets.c_tip4')}}。</p>
            <p class="mt5">• {{$t('assets.c_tip7')}}。</p>
            <p class="mt5">• {{$t('assets.c_tip8')}}。</p>
          </div>
        </div>
        <!-- 提币 -->
        <div class="mlr20 mtb20 radius2 bdheader ptb20 plr20" v-show="curindex==i&&infotype=='mention'">
          <div
            class="mb20"
            v-if="mentionInfo.mentionData.currency&&mentionInfo.mentionData.currency.currency_protocols&&mentionInfo.mentionData.currency.currency_protocols.length >1"
          >
            <p>{{$t('assets.chainName')}}</p>
            <ul class="flex mt10">
              <li
                class="mr20 bdheader ptb5 plr15 radius4"
                :class="mentionInfo.chargeType==item.chain_protocol.code?'border-2FA079 text-2FA079':''"
                v-for="(item,index) in mentionInfo.mentionData.currency.currency_protocols"
                :key="index"
                @click="selectChargeType(item,'mention')"
              >{{item.chain_protocol.code}}</li>
            </ul>
          </div>
          <div>
            <p>{{$t('assets.mentionaddr')}}</p>
            <input
              type="text"
              v-model="mentionInfo.address"
              :placeholder="$t('assets.pstwaf')"
              class="ht40 lh40 plr20 bdinput w100 mt10 baselight2"
              disabled
            />
          </div>

          <div class="mt20">
            <div class="flex between alcenter" v-if="mentionInfo.mentionData.currency">
              <p>{{$t('assets.mentionNumber')}}</p>
              <p>{{$t('assets.use')}}：{{mentionInfo.balance}}{{mentionInfo.mentionData.currency.code}}</p>
            </div>
            <input
              type="number"
              v-model="mentionInfo.numbers"
              :placeholder="$t('assets.minnum')+mentionInfo.mentionMin"
              class="ht40 lh40 plr20 bdinput mt10 w100 baselight2"
            />
          </div>
          <div class="flex mt20">
            <div class="flex1">
              <p>{{$t('assets.fee')}}</p>
              <p class="ht40 lh40 plr20 bdinput mt10 w100 baselight2">{{mentionInfo.rate *100}}%</p>
            </div>
            <div class="flex1 ml30">
              <p>{{$t('assets.recivenum')}}</p>
              <p
                class="ht40 lh40 plr20 bdinput mt10 w100 baselight2"
              >{{mentionInfo.numbers *(1-mentionInfo.rate)}}</p>
            </div>
          </div>

          <!-- <div class="mt20">
            <p>meno</p>
            <input
              type="text"
              v-model="mentionInfo.meno"
              class="ht40 lh40 plr20 bdinput w100 mt10 baselight2"
            />
          </div> -->
          <div class="mt20">
            <p>{{$t('assets.s_dealpwd')}}</p>
            <input
              type="password"
              autocomplete="new-password"
              v-model="mentionInfo.tradePassword"
              class="ht40 lh40 plr20 bdinput mt10 w100 baselight2"
            />
          </div>
          <div class="mt20">
            <p>
              <el-radio-group v-model="radio" @input="getradio">
                <el-radio label="1">{{$t('add.sjyz')}}</el-radio>
                <el-radio label="2">{{$t('add.yxyz')}}</el-radio>
                <el-radio label="3">{{$t('add.ggyzm')}}</el-radio>
              </el-radio-group>
            </p>
            <!-- <input
              type="password"
              autocomplete="new-password"
              v-model="code"
              class="ht40 lh40 plr20 bdinput mt10 w100 baselight2"
              :placeholder="$t('add.plats')"
            /> -->
            <div class="mt20 border-b-EEEEEE ht50 lh50 flex alcenter bdinput"  >
                    <input type="text" class="flex1 h100 bdre7 pl20 black" v-model="sms_code" :placeholder="$t('register.enterCode')">
                    <div  class="w20 bdr tc text-clip-green pointer" @click="sendcode" v-show="!hassend &&radio!=3">{{$t('login.send')}}</div>
                    <div class="w20 bdr tc text-clip-green "  v-show="hassend&&radio!=3">{{second}}s</div>
                </div>
          </div>
          <!-- <p class="mb20">可用：{{mentionInfo.balance}}USDT</p>
          <p>手续费：{{mentionInfo.rate *100}}%</p>-->
          <div class="mt30 radius2 tc ht48 lh48 white bg-main-liner" @click="mentionSubmit">{{$t('assets.mention')}}</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import vueQr from "vue-qr";
import "@/lib/clipboard.min.js";
export default {
  components: {
    vueQr
  },
  data() {
    return {
      second:60,
      sms_code:'',
      hassend:false,
      coinlist: [],
      code:'',
      curindex: 0,
      infotype: "",
      changeData: {},
      currency: "",
      radio:'',
      chargeInfo: {
        chargeAddress: "",
        chargeData: {},
        chargeText: "",
        chargeType: "",
        codeShow: false,
        chargeCurrencyCode: ""
      },
      mentionInfo: {
        accountTypeId: "",
        ids: "",
        userId: "",
        coinName: "",
        contract_address: "",
        address: "",
        balance: "",
        rate: "",
        tradePassword: "",
        numbers: "",
        mentionMin: "",
        mentionMax:"",
        mentionData: {},
        meno: "",
        chargeType: "",
        currencyProtocolId: "",
      },
      ver_info:{},
    };
  },
  created() {
    var that = this;
    that.mentionInfo.userId = localStorage.getItem("uid");
    that.init();
    that.getInfo()
    that.verified_info()
  },
  methods: {
    getradio(e){
      if(e== 1){
          if(!this.ver_info.mobile_verified){
					return   this.$utils.layerMsg(this.$t('add.bdsj'));
					
				}
			}
			if(e==2){
				if(!this.ver_info.email_verified){
          return   this.$utils.layerMsg(this.$t('add.bdyx'));
					
				}
			}
			if(e==3){
				if(!this.ver_info.google_secret_verified){
          return   this.$utils.layerMsg(this.$t('add.bdgg'));
					
				}
			}
    },
    verified_info(){
      	this.$http.initDataToken({ url: "user/verified_info" },false).then(res => {
          this.ver_info = res
        })
    },
    getInfo(){
      	this.$http.initDataToken({ url: "user/info" },false).then(res => {
          this.info = res
        })
    },
    sendcode(){
         if(!this.radio){
          
          this.$utils.layerMsg(this.$t('add.quzyz'));
         }
          // 手机
          if(this.radio==1){
             
            
             
              this.$http.initDataToken({url:'notify/send_sms',type:'POST',data:{
                  to:this.info.mobile,
                  type:4,
                
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
            }else if(this.radio==2){
                // 邮箱验证码
              
               
                this.$http.initDataToken({url:'notify/send_email',type:'POST',data:{
                    to:this.info.email,
                    type:4,
                  
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
    init() {
      var that = this;
      that.$http.initDataToken({ url: "account/list" }, false).then(res => {
        res.forEach(item => {
          if (item.account_code == "change_account") {
            that.coinlist = item.accounts;
            that.changeData = item;
          }
        });
      });
    },
    // 充币,提币
    showInfo(options, e, infotype) {
      var that = this;
      that.curindex = e;
      that.infotype = infotype;
      that.currency = options.currency_id;
      that.changeAddress = "";
      that.chargeInfo.chargeData = {};
      that.chargeInfo.chargeText = "";
      that.chargeInfo.chargeType = "";
      that.chargeInfo.codeShow = false;
      if (infotype == "charge") {
        //   充币
  
        that.getCharge();
      } else {
        //   提币
        console.log(options);
        that.mentionInfo.accountTypeId = options.currency_id;
        that.mentionInfo.ids = options.id;
        // that.mentionInfo.coinName = options.currency.
        that.getMention();
      }
    },
    // 获取充币信息
    getCharge() {
      var that = this;
      that.$http
        .initDataToken(
          { url: "wallet/wallet", data: { currency_id: that.currency } },
          false
        )
        .then(res => {
          that.chargeInfo.chargeData = res;
          that.chargeInfo.chargeAddress = "";
          if (res.wallets.length > 0) {
            
            that.chargeInfo.chargeAddress = res.wallets[0].address;
            that.chargeInfo.chargeText = res.wallets[0].memo;
            that.chargeInfo.chargeType = res.wallets[0].chain_protocol.code;
          }else{

            that.chargeInfo.chargeText = "";
            that.chargeInfo.chargeType = "";
          }
        });
    },
    // 选择充币链名称
    selectChargeType(options, types) {
      var that = this;

      if (types == "charge") {
        that.chargeInfo.chargeAddress = options.address;
        that.chargeInfo.chargeText = options.memo;
        that.chargeInfo.chargeType = options.chain_protocol.code;
      } else {
        that.mentionInfo.coinName = options.chain_protocol.code;
        that.mentionInfo.contractAddress = options.token_address;
        that.mentionInfo.chargeType = options.chain_protocol.code;
        that.mentionInfo.address = "";
        that.mentionInfo.currencyProtocolId = options.id;
        that.getMentionAddress();
      }
    },
    // 复制
    copyContent(contents, className) {
      var that = this;
      var flag = false;
      var clipboard = new Clipboard(className, {
        text: function() {
          return contents;
        }
      });

      clipboard.on("success", function(e) {
        if (!flag) {
          flag = true;
          that.$utils.layerMsg(that.$t('assets.copy_success'), "success");
        }
      });
      clipboard.on("error", function(e) {
        if (!flag) {
          flag = true;
          that.$utils.layerMsg(that.$t('assets.copy_err'));
        }
      });
      return false;
    },

    // 获取提币信息
    getMention() {
      var that = this;
      that.$http
        .initDataToken(
          {
            url: "account/detail",
            data: {
              currency_id:that.mentionInfo.accountTypeId,
              account_type_id: 1,
              id: that.mentionInfo.ids
            }
          },
          false
        )
        .then(res => {
          that.mentionInfo.mentionData = res;
          that.mentionInfo.coinName =
            res.currency.currency_protocols[0].chain_protocol.code;
          that.mentionInfo.contractAddress =
            res.currency.currency_protocols[0].token_address;
          that.mentionInfo.userId = res.user_id;
          that.mentionInfo.balance = res.balance;
          that.mentionInfo.rate = res.currency.draw_rate;
          that.mentionInfo.mentionMin = res.currency.draw_min;
          that.mentionInfo.mentionMax = res.currency.draw_max;
          that.mentionInfo.chargeType =
            res.currency.currency_protocols[0].chain_protocol.code;
          that.mentionInfo.currencyProtocolId =
            res.currency.currency_protocols[0].id;
          that.mentionInfo.currency_id = res.currency_id;
          that.getMentionAddress();
        });
    },
    getMentionAddress() {
      var that = this;
      that.$http
        .initDataNoapi(
          {
            url: "GetDrawAddress",
            data: {
              user_id: that.mentionInfo.userId,
              coin_name: that.mentionInfo.coinName,
              contract_address: that.mentionInfo.contractAddress,
              currency_id: that.mentionInfo.currency_id,
              currency_protocol_id: that.mentionInfo.currencyProtocolId
            }
          },
          false
        )
        .then(res => {
          if (res && res.address) {
            that.mentionInfo.address = res.address;
          } else {
            that.mentionInfo.address = "";
          }
        });
    },
    // 提币提交
    mentionSubmit() {
      var that = this;
      if (!that.mentionInfo.address) {
        that.$utils.layerMsg(this.$t('assets.pbtwaf'));
        return false;
      }
      if (!that.mentionInfo.numbers) {
        that.$utils.layerMsg(this.$t('assets.p_minnum'));
        return false;
      }
      if (!that.mentionInfo.tradePassword) {
        that.$utils.layerMsg(this.$t('assets.payPassword'));
        return false;
      }
      if(!that.sms_code){
        that.$utils.layerMsg(this.$t('add.plats'));
        return false;
      }
      that.$http
        .initDataToken({
          url: "account/draw",
          data: {
            currency_id: that.mentionInfo.mentionData.currency_id,
            number: that.mentionInfo.numbers,
            address: that.mentionInfo.address,
            pay_password: that.mentionInfo.tradePassword,
            memo: that.mentionInfo.memo,
            currency_protocol_id: that.mentionInfo.currencyProtocolId,
            code:that.sms_code,
            verify_type:that.radio == 1 ? 'mobile' : that.radio == 2 ? 'email' :that.radio == 3 ? 'google_secret' :''
          },
          type: "POST"
        })
        .then(res => {
          this.sms_code=''
        });
    }
  }
};
</script>
