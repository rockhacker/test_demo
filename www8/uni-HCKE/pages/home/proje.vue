<template>
	<view :class="theme">
		<uni-nav-bar fixed>
			<view class="w-full p-20 bg-white dark:bg-floor">
				<view class="w-full flex border-2 border-solid border-gray-200 dark:border-gray-700 text-gray-400 rounded-10 p-6 relative">
					<view class="flex-1 flex justify-center items-center text-xl rounded-10 h-70 relative z-10" style="transition:all .5s" :class="{'text-black':current==index}" v-for="item,index in tabs" :key="index" @click="setItem(index)" >
						{{item}}
					</view>
					<view class="w-full absolute left-0 top-0 p-6">
						<view class="bg-primary rounded-10 w-4_12 h-70" style="transition:all .2s" :style="`margin-left:${current * 33}%`"></view>
					</view>
				</view>
			</view>
		</uni-nav-bar>
        <view class="bg-white dark:bg-floor p-40" v-for="(item,index) in list" :key="index">
             <view class="relative rounded-10 overflow-hidden">
                <image class="w-full" :src="item.banner" mode="widthFix"></image>
				<view class="absolute w-300 h-160 flex items-end justify-center text-lg pb-20 text-white" :class="{'bg-success':current!=2,'bg-gray-500':current==2}" style="transform: rotate(-45deg);top:-24px;left:-60px">
				 	<text v-if="current==0">{{$t('new.started')}}</text>
				 	<text v-if="current==1">{{$t('new.progress')}}</text>
				 	<text v-if="current==2">{{$t('new.over')}}</text>
				 </view>
             </view>
             <view class="text-xl py-20">{{item.title}}</view>
             <view class="text-lg text-gray-500 leading-44">{{item.introduction}}</view>
             <view class="text-xl py-20">{{$t('new.Target')}}: {{item.project_number}}  </view>
			 
			 <view class="mt-20 rounded-3xl p-20 text-black text-sm text-center" hover-class="opacity-50" :class="current==2?'bg-gray-600':'bg-primary'"  @click="current?toPath(item):''">
				 <text v-if="current==0">{{$t('new.beginning')}}：{{item.star}}</text>
				 <text v-if="current==1">{{$t('new.toend')}}：{{item.endt}}</text>
				 <text v-if="current==2">{{$t('new.over')}}</text>
			 </view>
			 
            <!-- <view class="btn " @click="toPath(item)" v-if="current==1">{{$t('new.toend')}}：{{item.endt}}</view>
             <view class="btn" @click="toPath(item)" v-else-if="current==0">{{$t('new.beginning')}}：{{item.star}}</view>
             <view class="btn default" v-else>{{$t('new.over')}}</view> -->
        </view>
		<view class="pt-100 text-center bg-white dark:bg-floor" v-if="list.length == 0">
			<image src="../../static/image/anonymous.png" class="w-120 h-120"></image>
			<view>{{ $t('home.norecord') }}</view>
		</view>
	</view>
</template>
<script>
	import uniPopup from '@/components/uni-popup.vue';
	import { mapState } from 'vuex';
	export default{
		components: {
			uniPopup
		},
		data(){
			return {
				current: 1,
                tabs: [this.$t('new.started'),this.$t('new.progress'), this.$t('new.over')],
                time:'0',
                list:[]
			}
		},
		onLoad() {
			
			uni.setNavigationBarTitle({
				title:this.$t('new.inproject')
			})
            setInterval(()=>{
                 this.time=this.computedTime('1630665344657')
            },1000)
            this.getHistory()
		},
		
		methods:{
              getTime(time){
				let date = time.replace(/-/g,'/');
                let t = new Date(date).getTime().toString()
            // setInterval(()=>{
                    let a= this.computedTime(t)
                    return a
            //  },1000)
            },
             getHistory(){
               this.list=[]
               this.$utils.initData({url:'project/getProjects'},(res,msg)=>{
					 if(res.length){
                          for(let key in res){
							let date = res[key].start_time.replace(/-/g,'/');
                            let time=new Date(date).getTime()
                            let t= new Date().getTime()
                            if(this.current==0 && time > t){
                                this.list.push(res[key])
                            }else if(this.current==1 && time < t){
                                this.list.push(res[key])
                            }
                        }
                     }
                     setInterval(()=>{
                         for(let key in this.list){
                           let t= this.list[key].end_time
                           let t2= this.list[key].start_time
                           let obj=this.list[key]
                           obj.endt=this.getTime(t)
                           obj.star=this.getTime(t2)
						   // console.log(obj);
                           this.$set(this.list,key,obj)
                           //this.list[key].endt=this.getTime(t)
                           // console.log( this.list[key].endt)
                        }
                     },1000)
				})
            },
            //结束
             getList(){
                this.list=[]
                this.$utils.initData({url:'project/getHistoryProjects'},(res,msg)=>{
                        if(res.length){
                           this.list=res
                        }
                    })
            },
            setItem(val){
				if(this.current == val)return false;
				this.current = val;
                if(val!=2){
                    this.getHistory()
                }else{
                    this.getList()
                }
            },
            toPath(item){
                console.log(111)
                 uni.navigateTo({url: '/pages/home/projeDetail?obj='+JSON.stringify(item)+'&current='+this.current })
            },
            changeTab(index) {
               // console.log('当前选中的项：' + index)	
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
				// console.log(differ)
               
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
                return d + h + m + s
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