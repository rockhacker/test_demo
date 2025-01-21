<template>
<div class="bgpart">
    <div class="recharge">
        <!-- <image class="b-logo"  src="../../static/image/cz-bg.60812fb6.jpg" ></image> -->
       <!-- <div class="recharge-header f-item baselight2">
            <div class="one text">1:{{$t('feed.onlinepayment')}}</div>
            <div class="two text">2:{{$t('feed.transferamount')}}</div>
        </div> -->
        <div class="recharge-content f-item baselight2">
            <div class="title">{{$t('feed.following')}}</div>
            <div class="items">
                <div class="item" v-for="(item,index) in wallet_data" :key="index">
                   <div class="left">
                      <img class="logo"  :src="item.currency.logo" />
                      <span class="text">{{item.currency_code_protocol}}</span>
                   </div> 
                   <!-- <img src="../../assets/images/arrowRight.png" alt class="wt40" /> -->
                   <div class="ft16 flex">
                        <div
                        class="plr10 ptb5 bg-main-liner white radius6 tc"
                        @click="detail(item)"
                        style="cursor:pointer;width:90px;margin-right:10px"
                        >{{ $t('rechargeTransfer.linkTranster') }}</div
                        >
                        <div
                        v-if="is_show_transfer"
                        class="plr10 ptb5 bg-main-liner white radius6 tc"
                        @click="$router.push('/rechargeTransfer')"
                        style="cursor:pointer;width:90px"
                        >{{ $t('rechargeTransfer.cardTranster') }}</div
                        >
                    </div>
                </div>
            </div>
        </div>
        <div v-if="false" class="footer">
            <div class="f-logo f-item" @click="recharge('https://banxa.com/')">
                 <div class="">
					 <img class="imgtwo bgwhite" src="../../assets/images/banxa-logo.svg" />
            		 <div class="text"></div>
            	 </div>
            	 <p class="flex1">{{$t('new.hez')}}</p>
            	 <p class=""></p>
            </div>
			<div class="f-logo f-item" @click="recharge('https://c2c.binance.com/en/?fiat=USD')">
			     <div class="">
					 <img class="logo"   src="../../../static/imgs/binance.png" />
					 <div class="text">Binance.us</div>
				 </div>
				 <p class="flex1">{{$t('new.hez')}}</p>
				 <p class=""></p>
			</div>
          <!-- <div class="f-logo f-item" @click="recharge('https://www.okex.com/buy-crypto')" >
                <div>
					<img class="logo"  src="../../../static/imgs/okex.png" ></img>
					<div class="text">OKEX</div>
				</div>
				 <p>{{$t('new.hez')}}</p>
            </div>
           <div class="f-logo f-item" @click="recharge('https://c2c.huobi.com/en-us/one-trade/buy')" >
                <div>
					<img class="logo"   src="../../../static/imgs/huobipro.png" ></img>
					<div class="text">Huobi</div>
				</div>
				 <p>{{$t('new.hez')}}</p>
           </div> -->
           <div class="f-logo f-item" @click="recharge('https://www.coinbase.com')" >
                <div class="">
                    <img class="imgtwo" style="width: 127px;" src="../../assets/images/Consumer_Wordmark.svg" alt="" >
                    <div class="text"></div>
                </div>
                    <p class="flex1">{{$t('new.hez')}}</p>
					<p class=""></p>
            </div>
            <div class="f-logo f-item" @click="recharge('https://crypto.com/')" >
                <div class="">
                    <img class="imgtwo" style="width: 127px;" src="../../assets/images/crypto-blue.jpg" alt="" >
                    <div class="text"></div>
                </div>
                    <p class="flex1">{{$t('new.hez')}}</p>
					<p class=""></p>
            </div>
            <div class="f-logo f-item" @click="recharge('https://www.bitbank.com/')" >
                <div class="">
                    <img class="imgtwo" style="width: 127px;" src="../../assets/images/bitbank.png" alt="" >
                    <div class="text"></div>
                </div>
                    <p class="flex1">{{$t('new.hez')}}</p>
					<p class=""></p>
            </div>
            <div class="f-logo f-item" @click="recharge('https://kraken.com/')" >
                <div class="">
                    <img class="imgtwo" style="width: 127px;" src="../../assets/images/kraken1.jpg" alt="" >
                    <div class="text"></div>
                </div>
                    <p class="flex1">{{$t('new.hez')}}</p>
					<p class=""></p>
            </div>
            <div class="f-logo f-item" @click="recharge('https://www.kucoin.com/assets/payments?lang=en_US')" >
                <div class="">
                    <img class="imgtwo" style="width: 127px;" src="../../assets/images/mmmmm.png" alt="" >
                    <div class="text"></div>
                </div>
                    <p class="flex1">{{$t('new.hez')}}</p>
					<p class=""></p>
            </div>
            <!-- <div class="f-logo f-item" @click="recharge('https://www.bitflyer.com')" >
                <div class="">
                    <img class="imgtwo" style="width: 127px;" src="../../assets/images/logo_h.png" alt="" >
                    <div class="text"></div>
                </div>
                    <p class="flex1">{{$t('new.hez')}}</p>
					<p class=""></p>
            </div> -->
            <!-- <div class="f-logo f-item red" @click="recharge(`https://direct.lc.chat/13513200/`)">
			   <div class="left">
				  <span class="text">{{$t('new.lxkfcz')}}</span>
			   </div> 
			   <img src="../../assets/images/arrowRight.png" alt class="wt40" />
            </div> -->
     </div>
   </div>
</div>
	
</template>

<script>
	export default{
		data(){
			return{
                wallet_data:[],
                is_show_transfer:false
			}
		},
		created() {
			this.getAssets()
			console.log(window.ai_service)
            this.$http
            .initDataToken({url:'default/setting?key=is_show_transfer'},false).then(res=>{
                    this.is_show_transfer = res == 1
            })
		},
		computed:{
			visiter_name(){
				return localStorage.getItem("visiter_name") || '';
			}
		},
        methods:{
            recharge(url){
				// window.LiveChatWidget.call()
				// console.log(parent.document)
				url=='livechatinc'?console.log(window.LiveChatWidget):window.open(url,"_blank")
            },
            detail(item){
               this.$router.push({
					path:'/rechargeOpen',
                    query:{
                        obj:JSON.stringify(item)
                    }
			    })
            },
            getAssets() {
                this.$http
                    .initDataToken({url:'quickCharge/info'},false).then(res=>{
                         this.wallet_data=res
                    })
			}
        }
	}
</script>

<style lang="scss" scoped>
     .footer{
        width: 90%;
        margin: 0 auto;
       .f-logo{
           cursor: pointer;
           display: flex;
		   justify-content: space-between;
           height: 60px;
           width: 100%;
           align-items:center;
            border-radius: 10px;
            padding: 20px 40px;
            margin-bottom:10px;
			>p{
				text-align: center;
				font-size: 24px;
				color:#00AB86;
			}
			>p:last-child{
				width: 200px;
			}
			>div{
				width: 150px;
			}
           .logo{
               width: 30px;
               height: 30px;
               margin-right:20px;
           }
           .text{
               font-size: 16px;
           }
       }
    }
    .bgpart{
        min-height: 100vh;

    }
  .recharge{
      padding-top:40px;
      width: 1000px;
      margin:0 auto;
      .b-logo{
          position:absolute;
          top:0;
          left:0;
          z-index:-1;
          width:100vw;
          height:100vh;
      }
      .recharge-header{
          width:90%;
         
          border-radius:10px;
          padding:40px 30px;
          margin:0 auto 40px;
          .text{
              font-size:16px;
          }
          .one{
              padding-bottom:10px;
          }
      }
      .recharge-content{
            width:90%;
            margin:0 auto;
           
            border-radius:10px;
            padding:0px 30px;
            .left{
               .logo{
                   width:50px;
                   height:50px;
                   margin-right:20px;
               }
               .text{
                   font-size:16px;
               }
            }
            .icon{
                width:30px;
                height:30px;
            }
            .item{
                display:flex;
                align-items:center;
                justify-content: space-between;
                padding:25px 0px;
                cursor: pointer;
                .left{
                    display:flex;
                    align-items:center;
                }
            }
            .title{
                font-size:16px;
                padding:30px 0px;
            }
      }
      .footer{
          width:90%;
          margin:0 auto;
          margin-top:40px;
          display:flex;
          flex-direction: column;
          align-items: center;
          .f-logo{
              /* width:400px;
              height:80px;
              margin-bottom:20px; */
          }
      }
	  .f-logo>div{
             display: flex;
			 align-items:center;
	  }
  }
</style>
