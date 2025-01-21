<template>
	<view  :class="theme">
	     <view class="px-30 min-h-screen">
               <view class="flex py-40" v-if="show==1">
                     <view class="flex-1 bg-my-gray rounded-xl w-full h-80 flex justify-center items-center">
                        <picker @change="bindPickerChange" :value="index" :range="arr" range-key="currency_code">
                            <view class="text-xl">{{arr[index].currency_code}}</view>
                        </picker>
                    </view>
                    <view class="w-100 flex justify-center items-center">
						  <!-- <image @click="setCy(2)" class="w-60 h-60" src="../../static/image/qweqwekkk.png"></image> -->
                          <image class="w-30 h-30" @click="setCy(2)" src="/static/image/icon_zh.png"></image>
                    </view>
                    <view class="flex-1 bg-my-gray rounded-xl w-full h-80 flex justify-center items-center">
                        <picker @change="bindPickerChangeTwo" :value="index" :range="nArr" range-key="currency_code">
							<view class="text-xl">{{nArr[nIndex].currency_code}}</view>
                        </picker>
                    </view>
               </view>
               <view class="flex py-40" v-else-if="show==2">
                    <view class="flex-1 bg-my-gray rounded-xl w-full h-80 flex justify-center items-center">
                        <picker @change="bindPickerChangeTwo" :value="index" :range="nArr" range-key="currency_code">
                            <view class="text-xl">{{nArr[nIndex].currency_code}}</view>
                        </picker>
                    </view>
                    <view class="w-100 flex justify-center items-center">
                         <image class="w-30 h-30" @click="setCy(1)" src="/static/image/icon_zh.png"></image>
						<!-- <image @click="setCy(1)" class="w-60 h-60" src="../../static/image/qweqwekkk.png"></image> -->
                    </view>
                    <view class="flex-1 bg-my-gray rounded-xl w-full h-80 flex justify-center items-center">
                        <picker @change="bindPickerChange" :value="index" :range="arr" range-key="currency_code">
                            <view class="text-xl">{{arr[index].currency_code}}</view>
                        </picker>
                    </view>
                </view>
				
				 <view class="bg-my-gray rounded-xl p-20">
                     <view class="py-20 title text-xl">{{$t('new.dhs')}}</view>
				 <view class="w-full flex items-center">
					<input class="flex-1 h-80 text-xl" type="number" v-model="num" placeholder="0.00">
					<view class="text-xl px-20 border-0 border-r-2 border-solid border-gray-200 dark:border-gray-600" v-if="show==1">{{arr[index].currency_code}}</view>
					<view class="text-xl px-20 border-0 border-r-2 border-solid border-gray-200 dark:border-gray-600" v-else-if="show==2">{{nArr[nIndex].currency_code}}</view>
					<view class="ml-20 text-my-orange" @click="setAll">{{$t('new.quanb')}}</view>
				 </view>
                 </view>
				 
				<view class="py-20" style="color:#A6A6A6">
					<view v-if="show==1">
						<view  class="flex my-30 justify-between" >
                             <view class="">{{$t('new.dangq')}}</view>
                            <view class="">{{(rate*1).toFixed(2)}}</view>
                        </view>
                        <view class="flex my-30 justify-between" >
                            <view>{{$t('new.keyong')}}{{arr[index].currency_code}}</view>
                            <view >{{(arr[index].balance*1).toFixed(8)}}</view>
                        </view>
                        <view  class="flex my-30 justify-between">
                            <view>{{$t('new.ked')}}{{nArr[nIndex].currency_code}}</view>
                            <view>{{(num/rate).toFixed(8)||'-'}}</view>
                        </view>
						 <!-- <view class="flex-1 text-center">{{$t('new.keyong')}}{{arr[index].currency_code}}</view>
						 <view class="flex-1 text-right">{{$t('new.ked')}}{{nArr[nIndex].currency_code}}</view> -->
					</view>
					<view  v-else-if="show==2">
						<view class="flex my-30 justify-between">
                            <view >{{$t('new.dangq')}}</view>
                            <view class="">{{(rate*1).toFixed(2)}}</view>
                        </view>
                        <view class="flex my-30 justify-between">
                            <view >{{$t('new.keyong')}}{{nArr[nIndex].currency_code}}</view>
                            <view >{{(nArr[nIndex].balance*1).toFixed(8)}}</view>
                        </view>
                         <view class="flex my-30 justify-between">
                             <view>{{$t('new.ked')}}{{arr[index].currency_code}}</view>
                             <view >{{(num*rate).toFixed(8)||'-'}}</view>
                         </view>
						<!-- <view class="flex-1 text-center">{{$t('new.keyong')}}{{nArr[nIndex].currency_code}}</view>
						<view class="flex-1 text-right">{{$t('new.ked')}}{{arr[index].currency_code}}</view> -->
					</view>
                    <view>

                    </view>
					<!-- <view class="flex my-30">
						<view class="flex-1">{{(rate*1).toFixed(2)}}</view>
						<view class="flex-1 text-center" v-if="show==1">{{(arr[index].balance*1).toFixed(8)}}</view>
						<view class="flex-1 text-center" v-else-if="show==2">{{(nArr[nIndex].balance*1).toFixed(8)}}</view>
						<view class="flex-1 text-right" v-if="show==1">{{(num/rate).toFixed(8)||'-'}}</view>
						<view class="flex-1 text-right" v-if="show==2">{{(num*rate).toFixed(8)||'-'}}</view>
					</view> -->
				</view>
               <!-- <view class="m-text">
                    <view class="t-text">
                        <text>手续费比列</text>
                        <text>手续费</text>
                     
                    </view>
                    <view class="t-text">
                        <text>1</text>
                        <text>1</text>
                    </view>
               </view> -->
               <button class="w-full rounded-10 bg-my-orange text-white text-xl mt-100" @click="sub">{{$t('new.duih')}}</button>
         </view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				array:[],
                index:0,
                nIndex:0,
                arr:[{}],
                nArr:[{}],
                show:1,
                num:'',
				rate:0
			}
		},
		computed:{
			...mapState(['theme']),
		},
		onLoad() {
			uni.setNavigationBarTitle({
                title: this.$t('new.duih')
            });
		},
		onShow() {
			this.$utils.setThemeTop(this.theme)
            this.getAssets()
		},
		methods:{
            getRa(msg){
                this.$utils.initDataToken({url:'exchange/lastPrice',type:'POST',data:{
                     base_id:this.nArr[this.nIndex].currency_id,
                     quote_id:this.arr[this.index].currency_id
                    }},res=>{
						 this.rate=res.last_price
                         if(msg){
                            this.$utils.showLayer(msg)
                            this.num=''
                         }
					})
            },
            setAll(){
                if(this.show==1){
                    this.num=this.arr[this.index].balance
                }else if(this.show==2){
                    this.num=this.nArr[this.nIndex].balance
                }
            },
            setCy(val){
                console.log(val)
				this.num=''
                this.show=val
				
            },
            bindPickerChangeTwo(val){
                this.nIndex=val.target.value
                this.getRa()
            },
            bindPickerChange(val){
                this.index=val.target.value
                this.getRa()
            },
            getAssets(msg) {
				this.$utils.initDataToken({url:'account/list'},res=>{
					 if(res.length>0){
							this.arr=res[0].accounts.filter((item)=>{
								return item.currency.is_quote==1;
							})
							console.log(this.arr)
							this.nArr=res[0].accounts.filter((item)=>{
								return item.currency.is_quote==0;
							})
							this.getRa(msg)
					 }
				})
		    },
            sub(){
				console.log(this.num)
				if(this.num<=0||!this.num){
					this.$utils.showLayer(this.$t('new.err'))
					return
				}
                this.$utils.initDataToken({url:'exchange/submit',type:'POST',data:{
                     base_id:this.nArr[this.nIndex].currency_id,
                     quote_id:this.arr[this.index].currency_id,
                     amount:this.num,
                     type:this.show
                    }},(res,msg)=>{
                          this.getAssets(msg)
					})
            }
		
		}
	}
</script>