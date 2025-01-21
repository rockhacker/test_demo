<template>
	<view :class="theme">
		
		<view class="bg-white dark:bg-floor p-40">
		     <view class="relative rounded-10 overflow-hidden" v-if="isvideo">
		        <image class="w-full" :src="obj.banner" mode="widthFix"></image>
				<view class="absolute w-300 h-160 flex items-end justify-center text-lg pb-20 text-white" :class="{'bg-success':current!=2,'bg-gray-500':current==2}" style="transform: rotate(-45deg);top:-24px;left:-60px">
				 	<text v-if="current==0">{{$t('new.started')}}</text>
				 	<text v-if="current==1">{{$t('new.progress')}}</text>
				 	<text v-if="current==2">{{$t('new.over')}}</text>
				 </view>
		     </view>
			 <video v-else :controls="true" src="https://m.ncp-ex.com/uploads/20210412/1a3e73b37ae014c0c3114a61fb564e31.mp4" style="width: 100%;"></video>
		     <view class="text-xl py-20">{{obj.title}}</view>
		     <view class="text-lg text-gray-500 leading-44">{{obj.introduction}}</view>
		     <view class="text-xl py-20">{{$t('new.Target')}}: {{obj.project_number}}  </view>
			 
			 <view class="mt-40 flex justify-between items-center bg-gray-200 dark:bg-gray-700 rounded-lg p-30" v-for="(item,index) in obj.matches" :key="index">
			       <view>  
			            <view class="text-lg text-black dark:text-white">{{$t('new.Targetty')}}：<text class="text-xl">{{item.base_currency_code}}</text></view>
			            <view class="text-lg text-gray-400 mt-20">{{$t('new.ratio')}}： 1 : {{item.currency_quotation.close}}</view>
			       </view>
			       <view class="bg-primary w-160 h-60 flex justify-center items-center rounded-3xl text-black" @click="open(item)">{{$t('new.participate')}}</view>
			 </view>
			 
			<view class="text-lg text-black dark:text-white mt-40" v-if="current!=2">
				<text v-if="current==0">{{$t('new.beforstr')}}</text>
				<text v-if="current==1">{{$t('new.beforeend')}}</text>
			</view>

			 <view class="mt-20 rounded-3xl h-80 flex justify-center items-center text-black text-sm text-center bg-primary" hover-class="opacity-50" v-if="current!=2">
				 <text v-if="current==0">{{obj.strt}}</text>
				 <text v-if="current==1">{{obj.strt}}</text>
			 </view>
			 
			 <view class="text-black dark:text-white mt-40 text-sm">{{$t('new.tosubscribe')}}：{{obj.start_time}}</view>
			 <view class="text-black dark:text-white mt-20 text-sm"> {{$t('new.endsubbe')}}：{{obj.end_time}}</view>
		</view>
		
		<view class="w-full bg-white dark:bg-gray-700 flex text-gray-500">
			<view class="flex-1 flex justify-center items-center text-lg rounded-10 relative z-10 relative p-30" style="transition:all .5s" 
				:class="{'text-primary':current2==index}" v-for="item,index in tabs" :key="index" @click="current2 = index" >
				{{item}}
				<view class="w-80 h-6 bg-primary rounded-10 absolute bottom-0" v-if="current2==index"></view>
			</view>
		</view>
		<view class="p-40 text-sm text-gray-500 leading-44" v-html="obj[current==0?'detail_introduction':'participation_conditions']"></view>
		<wyb-popup :bgColor="theme=='dark'?'#11141e':'#fff'" ref="popup" type="center" height="600" width="600" radius="6" :showCloseIcon="true">
			<view class="text-center p-40">
				 <view class="mt-40 text-xl font-bold">{{$t('new.participation')}}</view>
				 <view class="mt-40">
					 <view class="flex justify-between text-gray-500 dark:text-white">
						 <view class="text-lg">{{$t('trade.use')}}：{{balance}}</view>
						 <view class="text-lg" @click="setAll">{{$t('trade.all')}}</view>
					 </view>
					 <input :class="isNumber?'number':''" v-model="number" class="bg-gray-200 dark:bg-gray-800 mt-20 text-left h-80 pl-20 rounded-10" type="text" :placeholder="$t('new.plenumber')">
					 <input type="password" :class="isPwd?'pwd':''" v-model="pwd" class="bg-gray-200 dark:bg-gray-800 mt-30 text-left h-80 pl-20 rounded-10"  :placeholder="$t('new.plepwd')">
					 <!-- <input class="pop-input" type="text"> -->
					 <view class="msg" v-show="msg">{{msg}}</view>
					 <view class="w-full h-80 mt-40 flex justify-center items-center text-black text-lg rounded-3xl bg-primary" @click="sub()" hover-class="opacity-50">{{$t('new.participate')}}</view>
				 </view>
			</view>
		</wyb-popup>
    </view>
</template>

<script>
	import wybPopup from '@/components/wyb-popup/wyb-popup.vue'
	import { mapState } from 'vuex';
	export default{
		components: {
            wybPopup
		},
		data(){
			return {
				current: 0,
                tabs: [this.$t('new.ProjectIn'), this.$t('new.conditions')],
                time:'0',
                isvideo:true,
                current2:0,
                obj:{},
                number:'',
                pwd:'',
                isNumber:false,
                isPwd:false,
                item:{},
                msg:'',
                balance:''
			}
		},
		onLoad(option) {
			this.obj=JSON.parse(option.obj)
            this.current=parseInt(option.current)
			uni.setNavigationBarTitle({
				title:this.$t('new.prodetails')
			})
            setInterval(()=>{
                 //this.obj.ent=this.getTime(this.obj.end_time)
                 let time = this.getTime(this.obj.end_time)
                 this.$set(this.obj,'ent',time)
                 let time2 = this.getTime(this.obj.start_time)
                 this.$set(this.obj,'strt',time2)
            },1000)
		},
		
		methods:{
            setAll(){
                this.number=this.balance
            },
            getList(item){
                this.$utils.initDataToken({url:'account/list'},(res,msg)=>{
                        if(res.length){
                             if(item.quote_currency_id==res[0].accounts[0].currency_id){
                                this.balance=res[0].accounts[0].balance
                            }
                        }
                    })
            },
            sub(){
                if(!this.number){
                   this.isNumber=true
                }else if(!this.pwd){
                    this.isPwd=true
                }else{
                    //initDataToken
                       this.$utils.initDataToken({url:'project/submit',msg:true,type:'POST',data:{
                            currency_match_id:this.item.id,
                            password:this.pwd,
                            project_id:this.obj.id,
                            number:this.number
                       }},(res,msg)=>{
                           console.log(res)
                           if(res===0){
                               this.msg=msg
                           }else{
                                this.number=''
                                this.pwd=''
                                this.msg=''
                                this.$refs.popup.close()
                                uni.showToast({
                                     title: this.$t('new.subsee'),
                                     duration:2000
                                });
                           }
                           
                    })
                }
            },
            open(item){
                this.item=item
                this.$refs.popup.show()
                this.getList(item)
            },
            changeTab(index) {
               // console.log('当前选中的项：' + index)	
            },
            getTime(time){
				let date = time.replace(/-/g,'/');
                let t = new Date(date).getTime().toString()
            // setInterval(()=>{
                    let a= this.computedTime(t)
                    return a
            //  },1000)
            },
                //获取time距当前时间之后 (time需小于当前时间)
            computedTime(time) {
              //  let time = (new Date().getTime()+20*60*1000).toString()
            
                //返回 天、小时、分钟 向下取整中的某一个值 
                //time格式 （三种）//2020-08-25 16:06:54  //2020/08/25 16:06:54  //毫秒数
                let reg = new RegExp("-", "g")
                let stTime = new Date(time.replace(reg, "/")).getTime() || time
                let endTime = new Date().getTime()
                //相差毫秒数
                let differ = stTime - endTime 
               
                return this.getBefore(differ)
            },
            getBefore(my_time) {
                //将毫秒数转成天数  天数向下取整    1.9 -> 1   
                var days = my_time / 1000 / 60 / 60 / 24
                var daysRound = Math.floor(days)
                 
                //将毫秒数转成小时  小时向下取整
                var hours = my_time / 1000 / 60 / 60 - daysRound * 24
                
                var hoursRound = Math.floor(hours)
                
                //将毫秒数转成分钟  分钟向下取整
                var minutes =
                    my_time / 1000 / 60 - 24 * 60 * daysRound - 60 * hoursRound
             
                var minutesRound = Math.floor(minutes)
               //将毫秒数转成秒  秒钟向下取整
                var second =
                    my_time / 1000 - daysRound * 24 * 60 * 60 -  hoursRound * 60 * 60 -  minutesRound * 60
                var secondRound = Math.floor(second)
                var d = daysRound > 0 ? daysRound + this.$t('new.day') : "0"+this.$t('new.day')
                var h = hoursRound > 0 ? hoursRound + this.$t('new.s') : "0"+this.$t('new.s')
                var m = minutesRound > 0 ? minutesRound + this.$t('new.f') : "0"+this.$t('new.f')
                var s = secondRound > 0 ? secondRound + this.$t('new.m') : "0"+this.$t('new.m')
                return d +h + m + s
            },
        },
		onPullDownRefresh() {

		},
		computed: {
			...mapState(['theme'])
		},
		onShow() {
			this.$utils.setThemeTop(this.theme);
		},
		onReachBottom() {
		
		},
	}
</script>