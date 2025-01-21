<template>
    
	<view class="recharge pb-20">
        <!-- <image class="b-logo"  src="../../static/image/cz-bg.60812fb6.jpg" ></image> -->
		<!-- <view class="recharge-header">
             <view class="one text">1:{{$t('feed.onlinepayment')}}</view>
             <view class="two text">2:{{$t('feed.transferamount')}}</view>
         </view> -->
         <view class="recharge-content">
             <view class="title">{{$t('feed.following')}}</view>
             <view class="items">
                 <view class="item" @click="detail(item)" v-for="(item,index) in wallet_data" :key="index">
                    <view class="left">
                       <image class="logo"  :src="host+item.currency.logo" ></image>
                       <text class="text">{{item.currency_code_protocol}}</text>
                    </view> 
                    <image class="icon"  src="/static/image/arrrowr.png" ></image>
                 </view>
             </view>
         </view>
		 
		<view class="footer">
                <view class="f-logo" @click="recharge('https://banxa.com/')">
                    <view class="fast">
						<image class="logos" src="/static/image/banxa-logo.svg" ></image>
					</view>
					<view class="texts">{{$t('new.hez')}}</view>
                </view>
                <view class="f-logo" @click="recharge('https://c2c.binance.com/en/?fiat=USD')">
                    <view class="fast">
						<image class="logo" src="/static/image/binance.png" ></image>
						<view class="text text-white">Binance</view>
					</view>
					<view class="texts">{{$t('new.hez')}}</view>
                </view>
			   <view class="f-logo" @click="recharge('https://www.coinbase.com')" >
			        <view class="fast">
						  <image class="logos"   src="/static/image/ppp.svg" ></image>
					</view>
			         <view class="texts">{{$t('new.hez')}}</view>
			   </view>
			   <view class="f-logo" @click="recharge('https://crypto.com/')" >
			        <view class="fast">
						  <image class="logos"   src="/static/image/crypto-blue.jpg" ></image>
					</view>
			         <view class="texts">{{$t('new.hez')}}</view>
			   </view>
			  <view class="f-logo" @click="recharge('https://kraken.com/')" >
			       <view class="fast">
			  						  <image class="logos"   src="/static/image/kraken1.jpg" ></image>
			  					</view>
			        <view class="texts">{{$t('new.hez')}}</view>
			  </view>
			  <view class="f-logo" @click="recharge('https://www.bitbank.com/')" >
			       <view class="fast">
			  						  <image class="logos"   src="/static/image/bitbank.png" ></image>
			  					</view>
			        <view class="texts">{{$t('new.hez')}}</view>
			  </view>
			   <view class="f-logo" @click="recharge('https://www.kucoin.com/assets/payments?lang=en_US')" >
			        <view class="fast">
						 <image class="logos"   src="/static/image/ppppp.png" ></image>
					</view>
			         <view class="texts">{{$t('new.hez')}}</view>
			   </view>
			   <!-- <view class="f-logo" @click="recharge('https://www.bitflyer.com')" >
			        <view class="fast">
						 <image class="logos"   src="/static/image/pppp.png" ></image>
					</view>
			        <view class="texts">{{$t('new.hez')}}</view>
			   </view> -->
         </view>
		
		
		<navigator class="recharge-content" url="/pages/home/chat">
		  <!-- <view class="left">
			  <view class="text">{{$t('new.lxkfcz')}}</view>
		   </view> -->
		   <view class="items">
			   <view class="item">
				  <view class="left">
					 <text class="text">{{$t('new.lxkfcz')}}</text>
				  </view> 
				  <image class="icon"  src="/static/image/arrrowr.png" ></image>
			   </view>
		   </view>
		</navigator>
		
	</view>
</template>

<script>
	export default{
		data(){
			return{
                wallet_data:[]
			}
		},
		onLoad() {
            this.$utils.setThemeTop(this.theme)
			this.getAssets()
            uni.setNavigationBarTitle({
				title:this.$t('feed.sub')
			})
		},
        methods:{
            recharge(url){
				try {
					plus.runtime.openURL(url, function(res) {
						console.log(res);
					});
				} catch(err){
					window.open(url,"_blank");
				}
            },
            detail(item){
                uni.navigateTo({
					url:`/pages/home/rechargeOpen?b=${JSON.stringify(item)}`
			    })
            },
            getAssets() {
				this.$utils.initDataToken({url:'quickCharge/info'},res=>{
					this.wallet_data=res
                    console.log(res)
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
           display: flex;
		   
		   flex-direction: column;
           // height: 100upx;
           width: 100%;
           // align-items:center;
           /* background: #fff; */
            background-color: #272727;
            color: #303133;
            border-radius: 10px;
            padding: 10px 15px;
            margin-bottom:10px;
			.fast{
				display: flex;
				align-items: center;
				
			}
           .logo{
               width: 60upx;
               height: 60upx;
               margin-right:40upx;
           }
           .text{
               font-size: 16px;
           }
		   .texts{
			   font-size: 14px;
			   padding-top:10px;
			   /* color:#00AB86; */
               color: white;
		   }
       }
    }
  .recharge{
	  padding-top:20px;
	  min-height: 100vh;
	  /* background: url('../../static/image/cz-bg.60812fb6.jpg') no-repeat left top /100% 100%; */
      .b-logo{
          position:absolute;
          top:0;
          left:0;
          z-index:-1;
          width:100vw;
          height:100%;
      }
      .recharge-header{
		 
          width:90%;
          background:#fff;
          color:#303133;
          border-radius:10px;
          padding:40upx 30upx;
          margin:20upx auto 40upx;
          .text{
              font-size:28upx;
          }
          .one{
              padding-bottom:10upx;
          }
      }
      .recharge-content{
            width:90%;
            margin:0 auto;
            /* background:#fff; */
            background: #272727;
            color:white;
            border-radius:10px;
            padding:0upx 30upx;
            .left{
               .logo{
                   width:50upx;
                   height:50upx;
                   margin-right:20upx;
               }
               .text{
                   font-size:32upx;
               }
            }
            .icon{
                width:30upx;
                height:30upx;
            }
            .item{
                display:flex;
                align-items:center;
                justify-content: space-between;
                padding:25upx 0upx;
                .left{
                    display:flex;
                    align-items:center;
                }
            }
            .title{
                font-size:28upx;
                padding:30upx 0upx;
            }
      }
      .footer{
          width:90%;
          margin:0 auto;
          margin-top:40upx;
          display:flex;
          flex-direction: column;
          align-items: center;
          .f-logo{
              /* width:400upx;
              height:80upx;
              margin-bottom:20upx; */
          }
		  .logos{
			  width: 100px;
			  height: 20px;
		  }
      }
  }
  
</style>
