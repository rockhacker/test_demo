<template>
    <div class="proje">
          <div class="head bgheader">{{$t('new.project')}}</div>
          <div class="content bgheader">
                 <div class="cont-head">
					 <p :class="active==2?'active headerbase':''" @click="setAC(2)">{{$t('new.started')}}</p>
                     <p :class="active==0?'active headerbase':''" @click="setAC(0)">{{$t('new.ongoing')}}</p>
                     <!-- <p :class="active==1?'active headerbase':''" @click="setAC(1)">{{$t('new.sover')}}</p> -->
                 </div>
                 <div class="cont-item" @click="toPath(item)" v-for="(item,index) in list" :key="index">
                    <div class="left posRelt">
                        <img :src="item.banner">
						<div class="abstort wt150 ht80 flex flexend jscenter ft14 pb10 white" :class="{'bggreen':active!=1,'bagray':active==1}" style="transform: rotate(-45deg);top:-15px;left:-50px">
						 	<span v-if="active==0">{{$t('new.inprogress')}}</span>
						 	<span v-if="active==1">{{$t('new.sover')}}</span>
						 	<span v-if="active==2">{{$t('new.started')}}</span>
						 </div>
                           <!-- <div class="bg"  v-if="active==0||active==2"></div>
                            <div class="default-bg" v-else></div> -->
                  <!--          <div class="bg-text" v-if="active==0">{{$t('new.inprogress')}}</div>
                            <div class="bg-text" v-else-if="active==2">{{$t('new.started')}}</div>
                            <div class="bg-text " v-else>{{$t('new.sover')}}</div> -->
                    </div>
                    <div class="right">
                        <p class="max headerbase">{{item.title}} </p>
                        <p class="min ptb20">{{item.introduction}}</p>
                        <p class="max headerbase ptb20">{{$t('new.target')}}: {{item.project_number}} </p>
                        <button class="btn " v-if="active==0">{{$t('new.theend')}}：{{item.endt}}</button>
                        <button class="btn"  v-else-if="active==2">{{$t('new.beginning')}}：{{ item.star}}</button>
                        <button class="btn defalu" v-else>{{$t('new.sover')}}</button>
                    </div>
                </div>
                <div class="tc ptb40" v-if="list.length==0">
					<img src="../../assets/images/nodata.png">
					<p>{{$t('legal.norecord')}}</p>
				</div>
          </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            active:0,
            time:null,
            list:[],
        }
    },
    
    created(){
        this.getList()
    },
    methods:{
        getTime(time){
       
            let t = new Date(time).getTime().toString()
			console.log(t)
           // setInterval(()=>{
                 let a= this.computedTime(t)
                 return a
          //  },1000)
        },
        getList(){
             this.$http
                .initDataToken({ url: "project/getProjects" }, false)
                .then(res => {
                    if(res.length) {
                        for(let key in res){
                           let time=new Date(res[key].start_time).getTime()
                           let t= new Date().getTime()
                           if(this.active==2 && time > t){
                                this.list.push(res[key])
                           }else if(this.active==0 && time < t){
                                this.list.push(res[key])
                           }
                        }
                        this.time = setInterval(()=>{
                         for(let key in this.list){
                           let t= this.list[key].end_time
                           let t2= this.list[key].start_time
                           let obj=this.list[key]
                           obj.endt=this.getTime(t)
                           obj.star=this.getTime(t2)
                           this.$set(this.list,key,obj)
                           //this.list[key].endt=this.getTime(t)
                           console.log( this.list[key].endt)
                        }
                     },1000)
                    }
                });
        },
        getHistory(){
            this.$http
                .initDataToken({ url: "project/getHistoryProjects" }, false)
                .then(res => {
                    if(res.length) {
                         this.list=res
                    }
                });
        },
        toPath(val){
			if(!this.active){
				this.$router.push({
					path:'/projeDetail',
					query:{
						obj:JSON.stringify(val),
						active:this.active
					}
				})
			}
        },
        setAC(val){
            this.list=[]
            this.active=val
            if(val==1){
                this.getHistory()
            }else{
                this.getList()
            }
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
                let differ = Math.abs(stTime - endTime) 
               
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
       clearInterval(this.time); 
    }
}
</script>
<style lang="scss" scoped>
  .proje{
      width: 1100px;
      margin: 0 auto;
      .head{
          height: 60px;
          line-height: 60px;
          font-size: 16px;
          margin-top:20px;
          padding:0 30px;
      }
      .content{
          padding:30px;
          margin-top:20px;
          .cont-head{
              display: flex;
              // width: 500px;
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
          .cont-item{
              display: flex;
              margin-top:20px;
              cursor: pointer;
              .left{
                  flex: 2 1 0%;
                  position: relative;
                  margin:0 20px 0 0;
                  border-radius: 10px;
                  overflow: hidden;
                  img{
						width: 100%;
						// height: 239px;
						border-radius: 10px;
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
                  .max{
                      font-size: 15px;
                  }
                  .min{
                      font-size: 14px;
                      line-height: 20px;
                  }
              }
          }
      }
  }
</style>