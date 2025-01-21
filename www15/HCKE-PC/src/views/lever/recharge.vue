<template>
	<div>
		<img class="w100" src="../../assets/images/bg_recharge.png" />
		<div class="recharge posRelt" style="top:-200px">
			<div class="overx radius4 mb10">
				<div class="ft16 white bg-main inblock plr60 ptb15 radius4" style="transform: skew(30deg, 0deg);margin-left: -30px;">
					<div style="transform: skew(-30deg, 0deg)">
						{{$t('feed.following')}}
					</div>
				</div>
			</div>
			<div class="recharge-content basecolor bgwhite">
				<div class="items">
					<div class="item" :class="{'bdbe7':wallet_data.length-1!=index}" v-for="(item,index) in wallet_data" :key="index">
					   <div class="left">
						  <img class="logo"  :src="item.currency.logo" />
						  <span class="text">{{item.currency_code_protocol}}</span>
					   </div> 
					   <!-- <img src="../../assets/images/arrowRight.png" alt class="wt40" /> -->
                        <div class="ft16 flex">
                        <div
                        class="plr10 ptb5 bgblue white radius6 tc"
                        @click="detail(item)"
                        style="cursor:pointer;width:90px;margin-right:10px"
                        >{{ $t('rechargeTransfer.linkTranster') }}</div
                        >
                        <div
                        v-if="is_show_transfer"
                        class="plr10 ptb5 bgblue white radius6 tc"
                        @click="$router.push('/rechargeTransfer')"
                        style="cursor:pointer;width:90px"
                        >{{ $t('rechargeTransfer.cardTranster') }}</div
                        >
                    </div>
					</div>
				</div>
			</div>

			<div class="overx radius4 mt60 mb10">
				<div class="ft16 white bg-main inblock plr60 ptb15 radius4" style="transform: skew(30deg, 0deg);margin-left: -30px;">
					<div style="transform: skew(-30deg, 0deg)">
						{{$t('new.hez')}}
					</div>
				</div>
			</div>

			<div class="flex bgwhite plr60 ptb30 wraps radius4">
				<div class="w20 bdgray ptb20 plr20 radius4 mlr20 mtb20" @click="recharge('https://banxa.com/')">
					<img class="w100 bgwhite" src="../../assets/images/banxa-logo.svg" />
				</div>
				<div class="w20 bdgray ptb20 plr20 radius4 mlr20 mtb20 flex alcenter jscenter" @click="recharge('https://c2c.binance.com/en/?fiat=USD')">
					<img class="wt30 ht30 mr20" src="../../../static/imgs/binance.png" />
					<div class="ft16 black">Binance.us</div>
				</div>
				<div class="w20 bdgray ptb20 plr20 radius4 mlr20 mtb20 flex alcenter jscenter" @click="recharge('https://www.coinbase.com')">
					<img class="w100 bgwhite" src="../../assets/images/Consumer_Wordmark.svg" />
				</div>
				<div class="w20 bdgray ptb20 plr20 radius4 mlr20 mtb20 flex alcenter jscenter" @click="recharge('https://crypto.com/')">
					<img class="w100 bgwhite" src="../../assets/images/crypto-blue.jpg" />
				</div>
				<div class="w20 bdgray ptb20 plr20 radius4 mlr20 mtb20 flex alcenter jscenter" @click="recharge('https://www.bitbank.com/')">
					<img class="w100 ht30" src="../../assets/images/bitbank.png" />
				</div>
				<div class="w20 bdgray ptb20 plr20 radius4 mlr20 mtb20 flex alcenter jscenter" @click="recharge('https://kraken.com/')">
					<img class="w100 ht30" src="../../assets/images/kraken1.jpg" />
				</div>
				<div class="w20 bdgray ptb20 plr20 radius4 mlr20 mtb20 flex alcenter jscenter" @click="recharge('https://www.kucoin.com/assets/payments?lang=en_US')">
					<img class="w100 ht30" src="../../assets/images/mmmmm.png" />
				</div>
			</div>
			
			
		</div>
		<footerComponet></footerComponet>
	</div>
	
</template>

<script>
import footerComponet from '@/components/footer'
	export default{
        components:{footerComponet},
		data(){
			return{
                wallet_data:[],
                is_show_transfer: false
			}
		},
		created() {
			this.getAssets()
            this.$http
            .initDataToken({url:'default/setting?key=is_show_transfer'},false).then(res=>{
                    this.is_show_transfer = res == 1
            })
            this.$getAnnouncement()

			console.log(window.ai_service)
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
    .triangle-bottomleft {
    width: 0;
    height: 0;
    border-bottom: 36.5px solid #057967;
    border-right: 36.5px solid transparent;
}

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
				color:#028065;
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
          /* flex-direction: column; */
          flex-wrap: wrap;
          align-items: center;
          /* justify-content: space-between; */
          .f-logo{
              width: 23%;
              margin-right: 10px;
              margin-bottom: 10px;
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
