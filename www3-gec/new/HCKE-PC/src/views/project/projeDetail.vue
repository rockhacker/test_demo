<template>
    <div class="proje-detail">
          <!-- <div class="head bgheader">
              <p>{{$t('new.project')}}</p>
              <p class="to" @click="go"> << {{$t('store.returns')}}</p>
          </div> -->
		  <div class="head bgheader">
		  	<span class="pointer" @click="$router.go(-1)">{{$t('new.project')}}</span >
		  	<span class="mlr10">/</span>
		  	<span v-if="active==0" class="blue">{{$t('new.inprogress')}}</span>
		  	<span v-if="active==1" class="blue">{{$t('new.sover')}}</span>
		  	<span v-if="active==2" class="blue">{{$t('new.started')}}</span>
		  </div>
          <div class="content bgheader">
                 <!-- <div class="cont-head bggred">
                     <p :class="active==0?'active headerbase':''" @click="setAC(0)">正在进行</p>
                     <p :class="active==1?'active headerbase':''" @click="setAC(1)">已经结束</p>
                 </div> -->
                 <div class="cont-item">
                    <div class="left"  v-if="!isvideo" >
                            <img :src="obj.banner">
							<div class="abstort wt150 ht80 flex flexend jscenter ft14 pb10 white" :class="{'bggreen':active!=1,'bagray':active==1}" style="transform: rotate(-45deg);top:-15px;left:-50px">
							 	<span v-if="active==0">{{$t('new.inprogress')}}</span>
							 	<span v-if="active==1">{{$t('new.sover')}}</span>
							 	<span v-if="active==2">{{$t('new.started')}}</span>
							 </div>
                           <!-- <div class="bg"  v-if="active==0"></div>
                            <div class="default-bg" v-else></div>
                            <div class="bg-text" v-if="active==0">{{$t('new.inprogress')}}</div>
                             <div class="bg-text" v-else-if="active==2">{{$t('new.started')}}</div>
                            <div class="bg-text " v-else>{{$t('new.sover')}}</div> -->
                            <!-- <img class="bof" src="../../assets/images/qweasd.png" alt=""> -->
                    </div>
                
                    <div class="right">
                        <p class="max headerbase">{{obj.title}}</p>
                        <p class="min ptb20">{{obj.introduction}}</p>
                        <p class="max headerbase ptb20">{{$t('new.target')}}: {{obj.project_number}} </p>
                        <button class="btn"  v-if="active==0">{{$t('new.theend')}}：{{obj.ent}}</button>
                         <button class="btn"  v-else-if="active==2">{{$t('new.beginning')}}：{{obj.strt}}</button>
                        <button class="btn defalu" v-else>{{$t('new.sover')}}</button>
						
						<div class="cont-item">
						   <div class="right">
							  <p class="max">{{$t('new.subscribe')}}：{{obj.start_time}}</p>
							  <p class="max mt">{{$t('new.ofsubscription')}}：{{obj.end_time}}</p>
						   </div>
						</div>
						<div @click='dialog(item)' v-for="(item,index) in obj.matches" :key="index">
							<div class="flex-cy">
								   <div class="flex-item mauto tc">
										 <p class="max headerbase">{{$t('new.targetcy')}}：{{item.base_currency_code}}</p>
										 <p class="min">{{$t('new.ratio')}}：1:{{item.currency_quotation.close}}</p>
										 <button class="item-btn">{{$t('new.participate')}}</button>
								   </div>
								   <!-- <div class="flex-item">
										 <p class="max headerbase">目标币种：USDT</p>
										 <p class="min">兑换比例：1:0.7523</p>
										 <button class="item-btn">参与</button>
								   </div>
								   <div class="flex-item">
										 <p class="max headerbase">目标币种：USDT</p>
										 <p class="min">兑换比例：1:0.7523</p>
										 <button class="item-btn">参与</button>
								   </div> -->
								   
							</div>
							
							<div data-v-1c2d6a12="" class="list" style="margin-top: 30px;">
								<p data-v-1c2d6a12="" class="headerbase list-title">{{$t('new.projectIn')}}:</p>
								<div v-html="obj.detail_introduction"></div> 
								<p data-v-1c2d6a12="" class="headerbase list-title">{{$t('new.conditions')}}:</p>
								<div v-html="obj.participation_conditions"></div>
							</div>
						</div>
                    </div>
                 </div>
          </div>
            <el-dialog
                :title="$t('new.participation')"
                :visible.sync="dialogVisible"
                :close-on-click-modal="false"
                :center="true"
                width="400px"
                top="30vh"
                :show-close="true"
                :before-close="handleClose">
                    <div class="head-text">
                        <p>{{$t('new.available')}}：<span>{{balance}}</span></p>
                        <p class="all" @click="setAll">{{$t('trade.all')}}</p>
                    </div>
                    <div class="dialog-cont">
                        <el-input type="number" v-model="number" :placeholder="$t('new.plenumber')"></el-input>
                        <el-input v-model="pwd" class="mt20" :placeholder="$t('new.plepwd')" type="password"></el-input>
                    </div>
                    <span slot="footer" class="dialog-footer">
                        <el-button class="btn" type="primary" @click="sub">{{$t('login.e_confrim2')}}</el-button>
                    </span>
                </el-dialog>
        </div>
</template>
<script>
export default {
    data(){
        return {
            active:0,
            time:123123,
            isvideo:false,
            dialogVisible:false,
            form:'',
            obj:{},
            item:{},
            number:'',
            pwd:'',
            id:'',
            balance:''
        }
    },
    
    created(){
        this.obj=JSON.parse(this.$route.query.obj)
        this.active=this.$route.query.active
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
              this.number= this.balance
          },
          getList(item){
               this.$http
                .initDataToken({ url: "account/list" }, false)
                .then(res => {
                     if(item.quote_currency_id==res[0].accounts[0].currency_id){
                         this.balance=res[0].accounts[0].balance
                     }
                });
          },
          getTime(time){
       
            let t = new Date(time).getTime().toString()
           // setInterval(()=>{
                 let a= this.computedTime(t)
                 return a
          //  },1000)
        },
        sub(){
            if(!this.number){
               this.$message({
                   message:this.$t('new.plenumber'),
                   type:'warning'
               })
            }else if(!this.pwd){
                this.$message({
                   message:this.$t('new.plepwd'),
                   type:'warning'
               })
            }else{
                this.$http
                .initDataToken({ url: "project/submit",type:'POST',data:{
                    currency_match_id:this.item.id,
                    password:this.pwd,
                    project_id:this.obj.id,
                    number:this.number
                } })
                .then(res => {
                     console.log(res)
                      this.dialogVisible = false
                });
            }
        },
        handleClose(){
            this.dialogVisible=false
        },
        dialog(item){
            this.getList(item)
            this.dialogVisible=true
            this.item=item
        },
        go(){
            this.$router.go(-1)
        },
        toPath(){
            //this.$router.push('/project/projeDetail')
        },
        setAC(val){
            this.active=val
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
                var d = daysRound > 0 ? daysRound + this.$t('new.day') : "0" + this.$t('new.day')
                var h = hoursRound > 0 ? hoursRound + this.$t('new.xiaoshi') : "0"+ this.$t('new.xiaoshi')
                var m = minutesRound > 0 ? minutesRound + this.$t('new.fenz') : "0"+this.$t('new.fenz')
                var s = secondRound > 0 ? secondRound + this.$t('new.miao') : "0"+this.$t('new.miao')
                return d +h + m + s
            },
    },
    destroyed(){
       
    }
}
</script>
<style lang="scss" scoped>
  .proje-detail{
      width: 1100px;
      margin: 0 auto;
      /deep/ .el-dialog{
          // box-shadow: 0 2px 30px 0 #507ed7;
          background: #081828;
          .el-dialog__close{
              font-weight: bold;
              font-size: 20px;
              color:#fff;
          }
          .el-dialog__title{
              color:#fff;
              font-weight: bold;
          }
          .btn{
                padding: 0;
                height: 44px;
                border-radius: 20px;
                line-height: 44px;
                width: 320px;
                margin: 0 auto;
                // background: linear-gradient(90deg,#fa7400,#f03007);
                border:none;
          }
          .dialog-cont{
              .el-input__inner{
                    // box-shadow: inset 0 0 20px 0 #375b9b;
                    width: 100%;
                    min-height: 46px;
                    padding: 0 20px;
                    color: #c7cce6;
                    font-size: 14px;
                    border-radius: 3px;
                    background: #272732;
              }
              .mt20{
                  margin-top:20px;
              }
          }
          .head-text{
             display: flex;
             justify-content: space-between;
             margin-bottom: 10px;
             p{
                 color:rgb(141, 165, 197);
                 font-size: 14px;
             }
             span{
                 color:#f22c08;
             }
             .all{
                 color:#37b6ff;
                 cursor: pointer;
             }
          }
          .el-dialog__body{
              padding:25px 40px;
          }
      }
      .head{
          height: 60px;
          line-height: 60px;
          font-size: 16px;
          margin-top:20px;
          padding:0 30px;
          display: flex;
          .to{
              cursor: pointer;
          }
      }
      .content{
          padding:30px;
          margin-top:20px;
          .cont-head{
              display: flex;
              width: 500px;
              height: 48px;
              line-height: 48px;
              p{
                  margin:0 15px;
                  font-size: 14px;
                  height: 100%;
                  cursor: pointer;
                  color:#87a2cd;
                  &.active{
                      border-bottom: 2px solid #f22c08;
                    
                  }
                  &:hover{
                      border-bottom: 2px solid #f22c08;
                    
                  }
              }
              
          }
          .flex-cy{
             display: flex;
             justify-content: space-between;
             margin-top:50px;
             .min{
                 margin:10px 0;
             }
             .item-btn{
                 height: 32px;
                 line-height: 32px;
                 background: linear-gradient(90deg,#fa7400,#f03007);
                 width: 200px;
                 color:#fff;
                 border-radius: 20px;
                 cursor: pointer;
             }
          }
          .cont-item{
              display: flex;
              margin-top:10px;
              cursor: pointer;
              .left{
                  flex: 2 1 0%;
                  position: relative;
                  margin:0 20px 0 0;
                  border-radius: 10px;
                  overflow: hidden;
                  // height: 239px;
                  
                  img{
                      width: 100%;
                      // height: 239px;
                       border-radius: 10px;
                       &.bof{
                            position: absolute;
                            left: 10px;
                            bottom: 15px;
                            width: 40px;
                            height: 40px;
                       }
                  }
                  .bg{
                        width: 0;
                        height: 0;
                        position: absolute;
                        top:0;
                        left:0;
                        z-index: 10;
                        border-left: 35px solid #03ca8e;
                        border-right: 35px solid transparent;
                        border-top: 35px solid #03ca8e;
                        border-bottom: 35px solid transparent;
                  }
                  .default-bg{
                        width: 0;
                        height: 0;
                        position: absolute;
                        top:0;
                        left:0;
                        z-index: 10;
                        border-left: 35px solid #666;
                        border-right: 35px solid transparent;
                        border-top: 35px solid #666;
                        border-bottom: 35px solid transparent;
                  }
                  .bg-text{
                        color:#fff;
                        position: absolute;
                        top:12px;
                        left:0;
                        z-index: 11;
                        font-size: 16px;
                        transform:rotate(-45deg);
                        -ms-transform:rotate(-45deg); 	/* IE 9 */
                        -moz-transform:rotate(-45deg); 	/* Firefox */
                        -webkit-transform:rotate(-45deg); /* Safari 和 Chrome */
                        -o-transform:rotate(-45deg); 	/* Opera */
                    }
              }
              .right{
                  flex: 3 1 0%;
                  display: flex;
                  flex-direction: column;
                  align-content: center;
                  justify-content: space-between;
                  .mt{
                      margin-top:10px;
                  }
                  .btn{
                      cursor: pointer;
                      background: linear-gradient(90deg,#fa7400,#f03007);
                      height: 44px;
                      width: 100%;
                      border-radius: 5px;
                      line-height: 44px;
                      text-align: left;
                      padding-left:10px;
                      color:#fff;
                      font-size: 16px;
                      &.defalu{
                          background: #666;
                      }
                  }
              }
          }
      }
      .max{
            font-size: 15px;
       }
       .min{
            font-size: 14px;
            line-height: 20px;
        }
        .list{
            font-size: 16px;
            line-height: 25px;
            .list-title{
                margin:10px 0;
            }
        }
  }
</style>