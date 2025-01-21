<template>
    <div>
        <div class="bgwhite dark-bg-111727 optionct">
            <div class="cont">
                 <div class="tabs nwhite">
                     <div class="tab-item" :class="index==active?'text-clip-green':''" @click="setActive(index,item)" v-for="(item,index) in list" :key="index">
                        <div>{{item.symbol}}{{$t('new.contract')}}</div>
                        <div v-if="index==active" class="bg-main-liner" style="height:3px;width:140px;margin-top: 6px;"></div>
                     </div>
                 </div>
                 <div class="tab-content conbg dark-bg-1C2532">
                       <div class="tab-time">
                           <p class="time-item" :class="timeAc==index?'active':''" @click="setAc(index,item)" v-for="(item, index) in timeList" :key="index">{{secondsFormat(item.seconds)}}</p>
                          
                       </div>  
                       <div class="tab-cont bg-F3F3F3 dark-bg-111727">
                             <div class="tab-header white">
                                    <div class="header-item mr30 flex column" :class="isTitle==0?'text-clip-green':'text-7F7F7F'" @click="isTitle=0">
                                        <div>{{$t('new.pastres')}}</div>
                                        <div v-if="isTitle==0" class="bg-main-liner" style="height:3px;width:80px;margin-top: 6px;"></div>
                                    </div>
                                    <div class="header-item flex column" :class="isTitle==1?'text-clip-green':'text-7F7F7F'" @click="()=>{isShow=true;isTitle=1}">
                                        <div>{{$t('new.realime')}}</div>
                                        <div v-if="isTitle==1" class="bg-main-liner" style="height:3px;width:80px;margin-top: 6px;"></div>
                                    </div>
                             </div>
                             <div class="period" v-show="isTitle==0">
                                    <div class="period-item textcl" v-for="(item,index) in historyLis" :key="index">
                                           <span>{{$t('new.first')}}</span>
                                           <span>{{item.period}}</span>
                                           <span>{{$t('new.period')}}</span>
                                           <img v-if="item.result==1" src="../../assets/images/red@2x.png" alt="">
                                           <img v-else src="../../assets/images/wegergb.png" alt="">
                                    </div>
                             </div>
                             <div class="period link" :class="isTitle==0?'pop':''">
                                    <linkComponet @getClose="getClose" class="flex1" :currency_matchInfo=currency_matchInfo></linkComponet>
                             </div>
                       </div>
                       <div class="bgDetail" v-if="show">
                            <p class="text1 white">{{$t('new.first')}}{{working.period}}{{$t('new.period')}}</p>
                            <p class="text2 none">{{$t('new.purchase')}}: 0 USDT</p>
                            <p class="text3 none">{{$t('new.buydown')}}: 0 USDT</p>
                            <p class="text4 none">{{$t('new.position')}}: 0 USDT</p>
                            <div class="text5">
                                <span>{{$t('new.progress')}}：</span>
                                <el-progress :percentage="timePer" ></el-progress>
                            </div>    
                            <div class="text6">
                                <div>
                                    <div class="item1">
                                        <span class="cl white">{{$t('new.opening')}}:</span>
                                        <span class="cl white">{{working.open_price}} USDT</span>
                                    </div>
                                    <div class="item2">
                                        <span class="cl white">{{$t('new.current')}}:</span>
                                        <span class="clos">{{close}} USDT</span>
                                    </div>
                                </div>
                                    <p v-if="percent>=0" class="bg white">{{percent}}%</p>
                                    <p v-else class="red white">{{percent}}%</p>
                            </div>
                       </div>
                       <div class="bgDetail showbg" v-else>
                            <h1>{{$t('new.settlement')}}</h1>
                       </div>
                       <div class="qidetail bg-F3F3F3 dark-bg-111727">
                                <div class="loading" v-if="!show">{{$t('new.settlement')}}</div>
                                <h1 class="cl textcl">{{$t('new.first')}}{{not.period}}{{$t('new.period')}}</h1>
                                <!-- <p class="cl textcl">本期预测周期：2021-04-15 14:05 ~ 2021-04-15 14:10</p> -->
                                <!-- <div class="q-flex">
                                     <div class="item1">
                                         <h2>0.00USDT</h2>
                                         <p>买涨总额</p>
                                     </div>
                                     <div class="item2">
                                        <h2>0.00USDT</h2>
                                        <p>买跌总额</p>
                                    </div>
                                    <div class="item3">
                                        <h2>0.00USDT</h2>
                                        <p>我的开仓</p>
                                    </div>
                                </div> -->
                                <div class="tab-time flcenter">
                                    <p class="time-item" :class="item.id==currencyId?'active':''" @click="setCurrency(item)" v-for="(item,index) in currencyList" :key="index">{{parseFloat(item.number)}} {{item.currency_code}}</p>
                                </div> 
                                <p class="yue" v-if="token">{{$t('new.balance')}}: {{balance.balance}} USDT</p>
                                <div class="btn">
                                     <button v-if="token" class="zhang bg-main-liner" @click="submit(1)">{{$t('new.bullish')}}</button>
                                     <button v-if="token" class="die" @click="submit(2)">{{$t('new.bearish')}}</button>
                                       <div v-if="!token" style="width:300px" class="bg-main-liner mauto tc ht40 lh40 radius2 blue mt20 ft16">
                                            <router-link :to="{name:'login'}">{{$t('login.login')}}</router-link>
                                            <span class="baselight2">{{$t('lever.or')}}</span>
                                            <router-link :to="{name:'register'}">{{$t('login.register')}}</router-link>
                                        </div>
                                </div>
                       </div>
                     
                 </div>
                 <div class="tabs">
                    <div class="tab" :class="tabAc==1?'border-b-2FA079 text-clip-green':''" @click="getData(1)">{{$t('lever.current')}}</div>
                    <div class="tab" :class="tabAc==3?'border-b-2FA079 text-clip-green':''" @click="getData(3)">{{$t('store.orderlist')}}</div>
                 </div>
                 <div class="list conbg">
                       <ul class="list-header bdbheader hdbg">
                           <li>{{$t('new.cperiod')}}</li>
                           <li>{{$t('new.openam')}}</li>
                           <li>{{$t('new.orderst')}}</li>
                           <li>{{$t('new.direction')}}</li>
                           <li>{{$t('new.forecast')}}</li>
                           <!-- <li>奖金数量</li> -->
                           <li>{{$t('new.fee')}}</li>
                           <li v-show="tabAc==3">{{$t('new.loss')}}</li>
                           <li>{{$t('new.sttime')}}</li>
                       </ul>
                       <ul class="list-content bdbheader" v-for="(item,index) in orderList" :key="index">
                            <li>{{item.currency_match.symbol}} - {{$t('new.first')}}{{item.period.period}}{{$t('new.period')}}</li>
                            <li>{{parseFloat(item.number)}}</li>
                            <li>{{item.status==1?$t('lever.dealing'):item.status==2?$t('lever.pingcanging'):item.status==3?$t('lever.hasping'):''}}</li>
                            <li v-if="item.type==1" class="zhang">{{$t('new.bullish')}}</li>
                            <li v-else class="die">{{$t('new.bearish')}}</li>
                            <li v-if="item.type==item.result" class="zhang">{{$t('new.success')}}</li>
                            <li v-else-if="item.type!=item.result && item.result" class="die">{{$t('new.failure')}}</li>
                            <li v-else-if="item.status==0">{{$t('new.started')}}</li>
                            <li  v-else-if="item.status==1">{{$t('new.running')}}</li>


                            <li  v-else-if="item.status==2">{{$t('new.jies')}}</li>
                            <!-- <li>0</li> -->
                            <li>{{item.fee}}</li>
                            <li v-show="tabAc==3">{{item.result_amount}}</li>
                            <li>{{item.period.created_time}}</li>
                        </ul>
                 </div>
                 <div class="page">
                        <el-pagination
                            :page-size="10"
                            layout="prev, pager, next"
                            :total="total"
                            @prev-click="prevClick"
                            @next-click="prevClick"
                            @current-change="prevClick"
                            >
                        </el-pagination>
                 </div>
                
            </div>
        </div>
        <el-dialog :title="type==1?$t('new.bullish'):$t('new.bearish')" :visible.sync="orderShow" >
            <div class="mb15 flex">
              <div class="flex1 tc">
                <p>{{$t('legal.num')}}</p>
                <p class="mt10">1</p>
              </div>
              <div class="flex1 tc">
                <p>{{$t('store.times')}}</p>
                <p class="mt10" >1</p>
              </div>
              <div class="flex1 tc">
                <p>{{$t('second.profitRate')}}</p>
                <p class="mt10">1</p>
              </div>
            </div>
            <span slot="footer" class="dialog-footer">
              <el-button class="radius4" size="small" @click="orderShow=false">{{$t('trade.cancel')}}</el-button>
              <el-button type="primary" size="small" @click="orderSubmit" class="radius4">{{$t('lever.e_confrim2')}}</el-button>
            </span>
          </el-dialog>
        <footerComponet class="footer"></footerComponet>
    </div>
    </template>
    <script>
    import footerComponet from '@/components/footer'
    import linkComponet from './link'
    export default {
        components:{
            footerComponet,
            linkComponet
        },
        data(){
            return {
                isTitle:0,
                active:0,
                timeAc:0,
                currency_matchInfo:{
                    currency_quotation:{}
                },
                isShow:false,
                list:[],
                timeList:[],
                historyLis:[],
                cyId:'',
                timeId:'',
                t:0,
                not:{},
                working:{},
                close:'',
                percent:'',
                timeItem:{},
                timePer:0,
                show:true,
                currencyList:[],
                currencyId:'',
                orderShow:false,
                type:'',
                currencyItem:{},
                orderList:[],
                balance:{},
                total:0,
                limit:10,
                page:1,
                tabAc:1,
                token:""
            }
        },
        created() {
            this.token = localStorage.getItem('token')
           // this.getmathes()
            this.getList()
            this.getTime()
            this.getAmount()
        },
        watch:{
            t(val){
               if(val==2){
                 //  console.log(111)
                   this.getHistory()
                   this.getChoosePeriods(1)//1  正在运作
                   this.getChoosePeriods(0)//0  未开始
                   this.t=0
               }
            }
        },
        methods:{ 
            getData(val){
                this.tabAc=val
                this.getcyList(false,val)
            },
            orderSubmit(){
               
            },
            prevClick(val){
                var that = this;
                that.$http
                .initDataToken({ url: "optionTrade/history",type:'POST',data:{
                    limit:this.limit,
                    page:val,
                    second_id:this.timeItem.id,
					status: this.tabAc||1
                }}, false,false)
                .then(res => {
                   this.total=res.total
                   this.orderList=res.data
                })
            },
            getSupportBalance(bool){
                if(!this.token){
                    return
                }
                var that = this;
                that.$http
                .initDataToken({ url: "optionTrade/getSupportBalance",type:'POST',data:{
                    currency_id: that.currencyItem.currency_id ||   that.currencyList[0].currency_id
                }}, false,bool)
                .then(res => {
                    console.log(res)
                    that.balance=res
                })
            },
            getcyList(bool,status){
                if(!this.token){
                    return
                }
                var that = this;
                that.$http
                .initDataToken({ url: "optionTrade/history",type:'POST',data:{
                    limit:this.limit,
                    page:this.page,
                    second_id:this.timeItem.id,
					status:status||1
                }}, false,bool)
                .then(res => {
                   this.total=res.total
                   this.orderList=res.data
                })
            },
            submit(type){
                if(!this.currencyId){
                    this.$message({
                        type:'warning',
                        message:'请选择开仓数量'
                    })
                }else{
                    //this.type=type
                   // this.orderShow=true
                    var that = this;
                    let mId = that.cyId  || that.list[0].id
                    let sId = that.timeId  || that.timeList[0].id
                    that.$http
                    .initDataToken({ url: "optionTrade/submit",type:'POST',data:{
                        type:type,
                        match_id:that.not.currency_match_id,
                        currency_id:that.currencyItem.currency_id,
                        period_id:that.not.id,
                        number_id:that.currencyId
                    } }, true)
                    .then(res => {
                         if(res){
                             this.getcyList()
                             this.getSupportBalance()
                         }
                    })
                }
            },
            setCurrency(val){
               this.currencyId=val.id  
               this.currencyItem=val
            },
            getAmount(){
                var that = this;
                that.$http
                .initDataToken({ url: "option/getAmount",type:'POST' }, false)
                .then(res => {
                    if(res.length){
                        this.currencyList=res
                        this.currencyId=this.currencyList[0].id  
                        this.currencyItem=this.currencyList[0]
                        this.getSupportBalance()
                    }
                })
            },
            getClose(val){
               this.close=val.toFixed(4)

               //求百分比
               this.percent = ((this.close-this.working.open_price)/this.working.open_price*100).toFixed(4)

               //求时间进度
               let time = new Date().getTime()
               let newTime =new Date(this.working.start_time).getTime()
               let t = time - newTime
               this.timePer = parseInt(t/(this.timeItem.seconds*1000)*100)
               if( this.timePer>=100){
                    this.timePer = 100
                    this.show=false
                    let time = setTimeout(()=>{
                        this.show=true
                        this.getHistory(false)
                        this.getChoosePeriods(1,false)//1  正在运作
                        this.getChoosePeriods(0,false)//0  未开始
                        this.getcyList(false)
                        this.getSupportBalance(false)
                        clearTimeout(time)
                    },3000)
               }
            },
            setActive(val,item){
                this.currency_matchInfo=this.list[val]
                this.cyId=item.id
                this.active=val               
                this.getHistory()
                this.getChoosePeriods(1)//1  正在运作
                this.getChoosePeriods(0)//0  未开始
            },
            setAc(val,item){
               this.timeId=item.id
               this.timeAc=val
               this.timeItem = item
               this.getHistory()
               this.getChoosePeriods(1)//1  正在运作
               this.getChoosePeriods(0)//0  未开始
               this.page=1
               this.getcyList(false,this.tabAc)
            },
            getHistory(bool){
                var that = this;
                let mId = that.cyId  || that.list[0].id
                let sId = that.timeId  || that.timeList[0].id
                that.$http
                .initDataToken({ url: "option/getPeriods",type:'POST',data:{
                    match_id : mId,
                    sec_id : sId,
                    limit:32
                }}, false , bool)
                .then(res => {
                   if(res.length){
                       this.historyLis=res
                   }
                })
            },
            sortTime(a,b){  
                return a.seconds-b.seconds  
            },
            getChoosePeriods(status,bool){
                var that = this;
                let mId = that.cyId  || that.list[0].id
                let sId = that.timeId  || that.timeList[0].id
                that.$http
                .initDataToken({ url: "option/getChoosePeriods",type:'POST',data:{
                    match_id : mId,
                    sec_id : sId,
                    status
                }}, false , bool)
                .then(res => {
                    //0未开始 1正在运行 2结算中 3已结束
                   if(status==0){
                       this.not=res
                   }else if(status==1){
                      res.open_price=Number(res.open_price).toFixed(4)
                      this.working=res
                   }
                })
            },
            getTime(){
                var that = this;
                that.$http
                .initDataToken({ url: "option/getOrderTime",type:'POST' }, false)
                .then(res => {
                   if(res.length){
                      this.timeList= res.sort(this.sortTime)
                      this.timeItem= this.timeList[0]
                      this.t+=1
                      this.getcyList()
                   }
                })
            },
            getList(){
                var that = this;
                that.$http
                .initDataToken({ url: "option/getOptionMatches",type:'POST' }, false)
                .then(res => {
                   if(res.length){
                       this.list=res
                       this.currency_matchInfo = res[0]
                       this.t+=1
                   }
                })
            },
            secondsFormat(s) { 
                var day = Math.floor( s/ (24*3600) ); // Math.floor()向下取整 
                var hour = Math.floor( (s - day*24*3600) / 3600); 
                var minute = Math.floor( (s - day*24*3600 - hour*3600) /60 ); 
                var second = s - day*24*3600 - hour*3600 - minute*60; 
                return day > 0 ? day + this.$t('new.day') : hour > 0 ? hour + this.$t('new.xiaoshi') : minute > 0 ? minute + this.$t('new.fenz') :second + this.$t('new.miao')
            },
            getmathes() {
            var that = this;
            that.$http
                .initDataToken({ url: "market/currency_matches" }, false)
                .then(res => {
                  
                // 判断支持合约交易的法币
                that.list = res.filter(item => item.is_quote == 1 && item.code=='USDT');
                // that.list = res;
                // 判断是否存储过信息
                var localStatus = false;
                var data3 = [];
                var data1 = [];
                var data2 = [];
                if (that.list.length > 0) {
                    if (
                    localStorage.getItem("secondData") &&
                    localStorage.getItem("secondData") != 'undefined'
                    ) {
                    var secondData = localStorage.getItem("secondData") || "";
                    console.log('secondData')
                    console.log(secondData)

                    data1 = JSON.parse(secondData);
                    data2 = res.filter(item => item.id == data1.quote_currency_id);
                    if (data2.length>0) {
                        data3 = data2[0].matches.filter(
                        item =>
                            item.open_microtrade == 1 &&
                            item.base_currency_id == data1.base_currency_id
                        );

                        localStatus = true;
                    }
                    }
                    if (localStatus) {
                    that.cny_usd = data2[0].cny_price;
                    that.currency_matchInfo = data3[0];
                    } else {
                    that.cny_usd = res[0].cny_price;
                    var datas = that.list[0].matches.filter(
                        item => item.open_microtrade == 1
                    )[0];
                    that.currency_matchInfo = datas;
                    }
                    localStorage.setItem(
                    "secondData",
                    JSON.stringify(that.currency_matchInfo)
                    );
                    console.log(that.currency_matchInfo)
                    // that.getcurmatchinfo(that.currency_matchInfo);
                    // that.bindSocket();
                }
                });
                }
           }
    }
    </script>
    <style lang="scss">
     .optionct{
         display: flex;
         justify-content: center;
         .el-progress__text{
            color:white;
         }
         .cont{
             padding-top:25px;
             width: 80%;
             min-width: 1000px;
             .tabs{
                 display: flex;
                
                 .tab-item{
                     margin-right:48px;
                     font-size: 16px;
                     padding:0 5px;
                     padding-bottom:7px;
                     cursor: pointer;
                     &.active{
                         border-bottom: 4px solid #0d9d87;
                         /* color:#0d9d87; */
                     }
                     &:first-child{
                      margin-left:13px;
                 }
                 }
             }
             .tab-content{
                 padding:13px;
                 padding-bottom:17px;
                 margin-top:8px;
                
                 .tab-time{
                      display: flex;
                     .time-item{
                        margin-right:31px;
                        cursor: pointer;
                        width: 57px;
                        text-align: center;
                        height: 26px;
                        line-height: 26px;
                        border: 1px solid #b0b8db;
                        border-radius: 4px;
                        &.active{
                            border-color:#0d9d87;
                            color:#0d9d87;
                        }
                     }
                 }
                 .tab-cont{
                     width: 100%;
                     /* border: 2px solid #4068B1; */
                     margin-top:9px;
                    
                     .tab-header{
                        padding-top:15px;
                        display:flex;
                        justify-content: center;
                        .header-item{
                            font-size: 20px;
                            border-bottom:4px solid transparent;
                            padding:0 5px 8px;
                            cursor: pointer;
                            &.active{
                                color:#0d9d87;
                                border-color: #0d9d87;
                            }
                        }
                       
                     }
                     .link{
                         margin-top:0 !important;
                     }
                     .period{
                         display: flex;
                         flex-wrap: wrap;
                         margin-top:25px;
                         .period-item{
                             margin-bottom:38px;
                             display: flex;
                             flex-direction: column;
                             align-items: center;
                             /* color:#D5D2CF; */
                             line-height:20px;
                             width: 6.25%;
                             border-right: 1px dashed #2c3038;
                             font-size:12px;
                             img{
                                 width: 24px;
                                 height: 24px;
                                 margin-top:5px;
                             }
                         }
                     }
                 }
                 .bgDetail{
                     display: flex;
                     align-items: center;
                     justify-content: space-between;
                     padding:0 10px;
                     height: 40px;
                     /* background: linear-gradient(90deg, #982F1E, #711E43, #400083, #550C68); */
                     background: linear-gradient(175deg, #67E1AB, #28C2C8) !important;
                     border-radius: 2px;
                     margin:15px 0 15px;
                     .text1{
                         font-size: 14px;
                     }
                     .text2{
                         background: #4F1629;
                         font-size: 12px;
                         color:#00B275;
                         padding:2px 4px;
                         box-shadow: 0px 2px 4px 0px rgba(20, 1, 1, 0.34);
                        border-radius: 4px;     
                     }
                     .text3{
                         background: #4F1629;
                         font-size: 12px;
                         color:#FF3959;
                         padding:2px 4px;
                         box-shadow: 0px 2px 4px 0px rgba(20, 1, 1, 0.34);
                        border-radius: 4px;     
                     }
                     .text4{
                         background: #4F1629;
                         font-size: 12px;
                         color:#DE9733;
                         padding:2px 4px;
                         box-shadow: 0px 2px 4px 0px rgba(20, 1, 1, 0.34);
                         border-radius: 4px;     
                         margin-right: 10%;
                     }
                     .text5{
                         display: flex;
                         align-items: center;
                         span{
                             font-size: 12px;
                             color:#FF8100;
                         }
                         .el-progress-bar__outer{
                            height:14px !important;
                            width: 117px;
                            border-radius: 0;
                            background: #5D491F;
                            .el-progress-bar__inner{
                                border-radius: 0;
                                background:#FF8100;
                            }
                         }
                         .el-progress__text{
                             margin-left:20px;
                         }
                     }
                     .text6{
                         display: flex;
                         align-items: center;
                         font-size: 12px;
                         .clos{
                             /* color:#00B172; */
                             color: white;
                         }
                         .bg{
                             margin-left:30px;
                             background: #00B275;
                             border-radius: 2px;
                             padding:2px 4px;
                         }
                         .red{
                            margin-left:30px;
                             background: #F2334F;
                             border-radius: 2px;
                             padding:2px 4px;
                         }
                     }
                 }
                 .qidetail{
                     position: relative;
                     /* border: 2px solid #4068B1; */
                     border-radius: 4px;
                     text-align: center;
                     padding-bottom: 20px;;
                     >h1{
                        padding:16px 0 14px; 
                        font-size:20px;
                     }
                     p{
                         font-size: 12px;
                     }
                     .q-flex{
                         display: flex;
                         justify-content:space-around;
                         margin:27px 0 25px;
                         h2{
                             font-size: 16px;
                         }
                         p{
                             font-size: 12px;
                         }
                         .item1{
                             color:#00B275;
                         }
                         .item2{
                             color:#F2334F;
                         }
                         .item3{
                             color:#FDAF07;
                         }
                     }
                 }
                 .flcenter{
                     justify-content: center;
                     margin-top:32px;
                     .time-item{
                         width: 85px;
                     }
                 }
                 .yue{
                     text-align: center;
                     padding:25px 0 21px;
                     font-size: 12px;
                 }
                 .btn{
                     padding:0 80px;
                     display: flex;
                     justify-content: space-between;
                     position: relative;
                     z-index: 1000;
                     button{
                         width: 45%;
                         height:40px;
                         min-width: 200px;
                         border-radius: 4px;
                         color:#fff;
                         cursor: pointer;
                         &.zhang{
                             background: #00B275;
                         }
                         &.die{
                             background: #F15157;
                         }
                     }
                 }
             }
             .list{
                   /* background: #1A2330; */
                   /* margin-top:11px; */
                   .list-header{
                       display: flex;
                       justify-content: space-between;
                       /* background: #28303E; */
                       height:34px;
                       line-height:34px;
                       li{
                         &:first-child{
                             padding-left:16px;
                             flex:1.5;
                         }
                       }
                   }
                   .list-content{
                       display: flex;
                       justify-content: space-between;
                       height:40px;
                       line-height:40px;
                       li{
                         /* border-bottom: 1px solid #28303E; */
                         &:first-child{
                             padding-left:16px;
                             flex:1.5;
                         }
                       }
                   }
                   li{
                       /* width: 12.5%; */
                    flex:1;
                   }
             }
             .page{
                 width: 100%;
                 display: flex;
                 justify-content: flex-end;
                 .el-pager li{
                     background: transparent;
                     color:#b0b8db;
                     &.active{
                         color:#FDAF07;
                     }
                 }
                 .el-pagination button:disabled,.el-pagination .btn-next, .el-pagination .btn-prev{
                    background: transparent;
                    color:#b0b8db;
                 }
             }
         }
         .showbg{
             justify-content: center !important;
             h1{
                 font-size: 22px;
             }
         }
         .cl{
             /* color:#C3C3C3; */
         }
         .zhang{
             color: #00B275;
         }
         .die{
             color: #F2334F;
         }
         .pop{
             position: absolute;
             opacity: 0;
         }
         .none{
             opacity: 0;
         }
         .active{
             /* color:#0d9d87 !important; */
             border-color:#0d9d87 !important;
         }
         .tabs{
             display: flex;
             padding-left:16px;
             margin:11px 0;
             position: relative;
             z-index: 1000;
            
             .tab{
                 margin-right:10px;
                 border-bottom: 4px solid transparent ;
                 font-size:16px;
                 padding-bottom:8px;
                 cursor: pointer;
             }
             .tab.active{
                    color:#0d9d87 !important;
                    border-color:#0d9d87 !important;
                }
             
         }
         .loading{
            position: absolute;
            z-index: 1001;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
     }
    </style>