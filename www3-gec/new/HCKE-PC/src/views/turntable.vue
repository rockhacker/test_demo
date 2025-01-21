<template>
	<div class="lottery">
          <div class="mt-80">
               <div class="flex-img mb10 ">
                  <img src="../../static/image/cs.png" alt="">
                  <div class="bold text-center ml20 mr20" :class="lang=='jp' ? 'ft12' : 'ft20' ">{{$t('home.bf')}}</div>
                  <img src="../../static/image/cs.png" alt="">
               </div>
               <div class="flex-title">
                   <div class="flex-center" v-if="lang != 'vn' && lang != 'th'">
                        <div class="tb mr10"  :style=" lang=='en' ? 'left:42px;' : ''">
                            <div class="spacing">{{$t('home.psq')}}</div>
                        </div>
                        <img :style=" lang=='en' ? 'left:20px;' : ''"  class="caret-right" src="../../static/image/caret-right.png" alt="">
                   </div>
                 
                   <img  v-if="lang == 'jp'" style="width: 70%;" class="bold text-center max pl30 pr30"  src="../../static/image/h1_jp.png" alt="">
                   <img  v-else-if="lang == 'vn'" style="width: 100%;" class="bold text-center max pl30 pr30"  src="../../static/image/h1_vn.png" alt="">
                   <img  v-else-if="lang == 'th'" style="width: 100%;" class="bold text-center max pl30 pr30"  src="../../static/image/h1_th.png" alt="">
                   <div  v-else  class="bold text-center max ft60" :class="lang=='en' ? 'oblique' :'' ">{{$t('home.qy')}}</div>
                </div>
                <div class="label" v-if="lang == 'vn' || lang == 'th'">
                    <div class="label-text">{{$t('home.psq')}}</div>
                    <img :style="lang == 'th' ? 'left:33px;' :''" class="label-img" :class="lang" src="../../static/image/caret-right.png" alt="">
               </div>
          </div>
          <div class="turntable" :style="lang == 'vn'  || lang == 'th' ? 'margin-top:-40px;' : ''">
                <div class="dz">
                    <div class="dz-text ft16">{{$t('home.qdj')}}</div>
                </div>
                <div class="zj"></div>
                <!-- <div class="prize" :class="lang"></div> -->
                <div class="content">
                    <div class="btn ft24 bold" @click="getStart">GO</div>
                    <div class="bg"  ref="turnt" >
                        <div class="cont" style="color:#fff;">
                            <div :style="{transform: 'rotate('+ item.deg +'deg)'}" class="cont-item" v-for="(item,index) in list" :key="index">
                                 <div class="item-deg">
                                    <div class="item-text bold ft13">{{item.name}}</div>
                                    <img class="item-img" :src="item.img" alt="">
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
          <div class="record">
                <div class="flex-img ft28 mt20 bold">
                    <img src="../../static/image/cs.png" alt="">
                    <div class="ml20 mr20">
                        {{$t('home.jl')}}
                    </div>
                    <img src="../../static/image/cs.png" alt="">
                </div>
                <div class="icon-list">
                    <i class="el-icon-arrow-left pointer"  v-if="page > 1" @click="superior"></i>
                    <i class="el-icon-arrow-left pointer" style="color: transparent;"  v-else></i>
                    <div class="list">
                        <div class="item item-title">
                            <div class="item-text ft16">{{$t('home.sj')}}</div>
                            <div class="item-text ft16">{{$t('home.jp')}}</div>
                        </div>
                        <div v-if="recordList.length>0" class="item" v-for="(item,index) in recordList" :key="index">
                            <div class="item-text ft12">{{item.created_at}}</div>
                            <div class="item-text ft12">{{item.name}}</div>
                        </div>
                        <div class="item" v-if="recordList.length == 0">
                            <div class="item-text ft12" style="color: #999;">{{$t('home.wjl')}}</div>
                        </div>
                    </div>
                    <i class="el-icon-arrow-right pointer" v-if="totalPage > page" @click="down"></i>
                    <i class="el-icon-arrow-left pointer" style="color: transparent;"  v-else></i>
                </div>
                <!-- <div class="pagesize">
                    <div class="ft16 pg-text" v-if="page > 1" @click="superior">{{$t('home.syy')}}</div>
                    <div class="ft16 pg-text" v-if="totalPage > page" @click="down">{{$t('home.xyy')}}</div>
                </div> -->
                <div class="ft12 bt-text text-center">{{$t('home.bc')}}</div>
          </div>
          <el-dialog
            title=" "
            :visible.sync="centerDialogVisible"
            width="300px"
            top="35vh"
            :show-close="false"
            :close-on-click-modal="false"
            center>
            <div class="winning">
                <div class="win-top win-text ft16">{{$t('home.gx')}}</div>
                 <div class="win-center">
                    <img class="win-img" :src="item.img" alt="">
                    <div class="ft14 text-center pl10 pr10">{{$t('home.cz')}}{{item.name}}{{$t('home.lx')}}</div>
                 </div>
                 <div class="sure pointer" @click="sub">{{$t('home.qd')}}</div>
            </div>
        </el-dialog>
	</div>
</template>

<script>
export default{
    data(){
        return {
           list:[],
           num:10,
           isDisabled:false,
           centerDialogVisible:false,
           recordList:[],
           page:1,
           totalPage:1,
           show:false,
           item:{},
           lang:''
        }
    },
    created() {
       
        this.init()
        this.getList()
        this.lang = localStorage.getItem('lang') || 'en'
        console.log(this.lang)
    },
    methods:{
      sub(){
       this.centerDialogVisible =false
      },
      //上一页
      superior(){
          if(!this.show) return
          this.page-- 
          this.getList()
      },
      //下一页
      down(){
            if(!this.show) return
            this.page++ 
            this.getList()
      },
      //中奖记录
      getList(){
        this.show = false
        this.$http
            .initDataToken(
            {
                url: "prizes/lottery_record",
                data: {
                    page: this.page,
                    limit: 10
                }
            },
            false
            )
            .then(res => {
                if(res.data.length>0){
                    this.recordList = res.data
                }
                this.totalPage = res.last_page
                this.show = true
            });
      },
      //初始化转盘
      init(){
            this.$http
            .initDataToken(
            {
                url: "prizes/list",
                data: {}
            },
            false
            )
            .then(res => {
                if(res.length){
                    this.list = res
                    let num = this.list.length // 转盘数量
                    for(let i = 0; i < this.list.length; i++){  
                        this.list[i].deg = 360 / num * i  
                    }
                }
            });
         
      },
      //获取指定抽奖号码
      getStart(){
        if(this.isDisabled) return
         this.isDisabled = true
        this.$http
            .initDataToken(
            {
                url: "prizes/submit",
                data: {},
                type: 'POST'
            },
            false
            )
            .then(res => {
                if(res.id){
                    this.item = res
                    for(let i = 0; i < this.list.length; i++){  
                        if(this.list[i].id == res.id){
                                this.setStart(i+1)
                        }
                    }
                }
            });
      },
      //指定抽奖号码开始抽奖
      setStart(n){
            let location = n // 指定旋转到数组中第n个
            let rotateItemDeg  =  ( this.list.length - location + 1) * (360 / this.list.length) // 指定的旋转角度
            console.log(rotateItemDeg)
            let rotate = rotateItemDeg + 5 * 360 //指定旋转角度 加上多转5圈
            let rotateSpeed = (rotateItemDeg / 360 * 1 + 5).toFixed(2);  //旋转时间

           //设置旋转动画样式
            this.$refs.turnt.style.transform = ''
            this.$refs.turnt.style.transition = ''
            setTimeout(()=>{
                    this.$refs.turnt.style.transform = `rotate(${rotate}deg)`;
                    this.$refs.turnt.style.transition = `transform ${rotateSpeed}s ease-out`;
            },10)
            
            setTimeout(() => {
                    //旋转完成，显示奖品
                    this.centerDialogVisible = true
                    this.isDisabled = false
                    this.page = 1
                    this.totalPage = 1
                    this.show = false
                    this.getList()
             }, rotateSpeed * 1000)
       }
    },
}
</script>

<style scoped lang="scss">
  .lottery {
          color:#FFFFFF;
          min-height:calc( 100vh - 44px);
          background: url('../../static/image/bg.png');
          background-size: 100% 100%;
          background-position: center center;
          overflow: hidden;
          padding-top:40px;
          .turntable{
                overflow: hidden;
                position: relative;
                height: 625px;
                .content{
                        margin:0 auto;
                        margin-top:68px;
                        height: 400px;
                        width: 400px;
                        position: relative;
                        overflow: hidden;
                        .bg{
                            position: absolute;
                            z-index: 1;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background: url('../../static/image/zp.png');
                            background-size: 100% 100%;
                            .cont{
                                position: absolute;
                                z-index: 1;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                                transform:rotate(45deg);
                                .cont-item{
                                    position: absolute;
                                    top:0;
                                    left:0;
                                    width: 50%;
                                    height: 50%;
                                    color: red;
                                    transform-origin: right bottom;
                                    .item-deg{
                                            transform:rotate(-45deg);
                                            width: 100%;
                                            height: 100%;
                                            display: flex;
                                            justify-content: flex-end;
                                            align-items: center;
                                            flex-direction: column;
                                            .item-text{
                                               color:#753632;
                                            }
                                            .item-img{
                                                width: 75px;
                                                height: 75px;
                                                margin-bottom: 38px;
                                                margin-top:2px;
                                            }
                                    } 
                                   
                                }
                            }
                        }
                        .btn{
                            position: absolute;
                            z-index: 2;
                            left:50%;
                            top:50%;
                            margin-top:-65px;
                            margin-left:-65px;
                            width: 130px;
                            height: 130px;
                            background: url('../../static/image/an.png');
                            background-size: 100% 100%;
                            text-align: center;
                            line-height: 130px;
                            cursor: pointer;
                            /* transition: all 0.5s; */
                            /* &:hover{
                                width: 110px;
                                height: 110px;
                                margin-top:-55px;
                                margin-left:-55px;
                                line-height: 110px;
                                font-size:28px;
                            } */
                        }
                }
                .dz{
                    position: absolute;
                    left:0;
                    right:0;
                    top:0;
                    bottom:0;
                    z-index: 1;
                    width:500px;
                    height: 625px;
                    background: url('../../static/image/dz.png');
                    background-size: 100% 100%;
                    margin: 0 auto;
                    display: flex;
                    align-items: flex-end;
                    .dz-text{
                        margin:0 auto;
                        text-align:center;
                        display: flex;
                        justify-content: center;
                        align-items:center;
                        color:#753632;
                        height: 200px;
                        width: 80%;
                       
                    }
                }
                .zj{
                    position: absolute;
                    z-index: 3;
                    top:39px;
                    left:50%;
                    margin-left:-85px;
                    width: 170px;
                    height: 50px;
                    background: url('../../static/image/zj.png');
                    background-size: 100% 100%;
                }
                .prize{
                    position: absolute;
                    z-index: 0;
                    right: 40px;
                    top:80px;
                    width: 120px;
                    height: 200px;
                    background-size: 100% 100%;
                    &.hk{
                        background-image: url('../../static/image/jp_hk.png');
                    }
                    &.en{
                        background-image: url('../../static/image/jp_en.png');
                    }
                    &.jp{
                        background-image: url('../../static/image/jp_jp.png');
                    }
                    &.vn{
                        background-image: url('../../static/image/jp_vn.png');
                    }
                    &.th{
                        background-image: url('../../static/image/jp_th.png');
                    }
                }
        }
        .flex-img{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .flex-title{
            width: 470px;
            margin:0 auto;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            .flex-center{
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .tb{
                position: absolute;
                left:40px;
                writing-mode: tb;
                background: #FF3A36;
                padding:6px 5px;
                border-radius: 4px;
                height: max-content;
                z-index: 1;
            }
            .caret-right{
                position: absolute;
                width: 80px;
                height: 80px;
                left:20px;
            }
            .max{
                font-family: YouSheBiaoTiHei;
                /* font-style: oblique; */
                line-height: 60px;
            }
        }
        .label{
            position: relative;
            width:470px;
            margin:10px auto 0;
            /* letter-spacing: 2px; */
            padding:0 30px;
            .label-text{
                position: relative;
                letter-spacing: 1px;
                background: #FF3A36;
                width: max-content;
                padding:6px 8px;
                border-radius: 4px;
                z-index: 2;
            }
            .label-img{
                z-index: 1;
                position: absolute;
                width: 80px;
                height: 80px;
                transform: rotate(-90deg);
                top:-35px;
                left:57px;
                &.th{
                    left:46px;
                }
            }
        }
        .record{
            text-align: center;
            font-size: 46px;
            .icon-list{
                display: flex;
                align-items:center;
                margin:20px auto 0;
                width: max-content;
            }
            .list{
                width: 450px;
                /* margin:40px auto 0; */
                margin:0 20px;
                .item{
                    &:nth-child(2n){
                        background: #fff;
                    }
                    &:nth-child(2n-1){
                        background: #E6E6E6;
                    }
                    &:first-child{
                        border-radius: 6px 6px 0 0;
                    }
                    &:last-child{
                        border-radius: 0 0 6px 6px;
                    }
                    display: flex;
                    justify-content: space-between;
                    align-item:center;
                    height: 30px;
                    .item-text{
                        flex:1;
                        text-align:center;
                        line-height: 30px;
                        color:#292929;
                    }
                }
            }
            .pagesize{
                display: flex;
                width: 600px;
                margin:20px auto 0;
                .pg-text{
                    flex: 1;
                    text-align:center;
                }
             }
             .bt-text{
                 color:#753632;
                 margin:50px 0 40px;
             }
        }
        .winning{
            background: #fff;
            border-radius: 6px;
            width: 300px;
            /* height: 25vh; */
            display: flex;
            flex-direction: column;
            align-items: center;
            /* justify-content: center; */
            .win-center{
                color:#fff;
                background: #ffc670;
                width: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding:20px 0;
                .win-img{
                    width: 60px;
                    height: 60px;
                    margin:10px;
                }
            }
            .win-text{
                color:#ffc670;
            }
            .win-top{
                padding:20px 0;
            }
            .sure{
                margin:20px 0;
                padding:7px 60px;
                background: #ffc670;
                color:#fff;
            }
        }
        .text-center{
            text-align: center;
        }
        .ft60{
            font-size: 60px;
        }
        .pointer{
            cursor: pointer;
        }	
        .spacing{
            letter-spacing: 2px;
        }
        .oblique{
            font-style: oblique;
            line-height: 54px !important;
        }
        >>> .el-dialog__body{
            padding:0;
        }
        >>> .el-dialog__header{
            display: none;
        }
  }
</style>
