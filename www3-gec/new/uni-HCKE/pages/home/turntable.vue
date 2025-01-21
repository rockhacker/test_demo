<template>
	<div class="lottery">
          <div class="mt-80">
               <div class="flex-img mb10">
                    <img class="cs" src="../../static/image/cs.png" alt="">
                    <div class="bold text-center ml20 mr20" :class="lang=='jp' ? 'ft12' : 'ft18' ">{{$t('home.bf')}}</div>
                    <img class="cs" src="../../static/image/cs.png" alt="">
               </div>
               <div class="flex-title">
                    <div class="tb mr10" v-if="lang != 'vn' && lang != 'th'">
                        <div class="spacing">{{$t('home.psq')}}</div>
                    </div>
                   <img v-if="lang != 'vn' && lang != 'th'" class="caret-right" src="../../static/image/caret-right.png" alt="">
                   <div  v-if="lang != 'vn' && lang != 'th'"  class="bold text-center max" :class="lang=='jp' ? 'ft40 pl50 pr50' :'ft50' ">{{$t('home.qy')}}</div>
                   <img  v-if="lang == 'vn'" style="width: 100%;" class="bold text-center max pl30 pr30"  src="../../static/image/h1_vn.png" alt="">
                   <img  v-if="lang == 'th'" style="width: 100%;" class="bold text-center max pl30 pr30"  src="../../static/image/h1_th.png" alt="">
                </div>
                <div class="label" v-if="lang == 'vn' || lang == 'th'">
                    <div class="label-text">{{$t('home.psq')}}</div>
                    <img class="label-img" :class="lang" src="../../static/image/caret-right.png" alt="">
               </div>
          </div>
          <div class="turntable" :style="lang == 'vn'  || lang == 'th' ? 'margin-top:-40upx;' : ''">
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
                <div class="ft23 bold flex-img">
                    <img class="cs" src="../../static/image/cs.png" alt="">
                    <div class="mr20 ml20">
                         {{$t('home.jl')}}
                    </div>
                    <img class="cs" src="../../static/image/cs.png" alt="">
                </div>
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
                <div class="pagesize">
                    <div class="ft16 pg-text" v-if="page > 1" @click="superior">{{$t('home.syy')}}</div>
                    <div class="ft16 pg-text" v-if="totalPage > page" @click="down">{{$t('home.xyy')}}</div>
                </div>
                <div class="ft12 bt-text">{{$t('home.bc')}}</div>
          </div>
          <uni-popup ref="popup" type="center" :mask-click="false">
              <div class="winning">
                  <div class="win-top win-text ft16">{{$t('home.gx')}}</div>
                   <div class="win-center">
                      <img class="win-img" :src="item.img" alt="">
                      <div class="ft14 text-center pl10 pr10">{{$t('home.cz')}}{{item.name}}{{$t('home.lx')}}</div>
                   </div>
                   <div class="sure" @click="sub">{{$t('home.qd')}}</div>
              </div>
          </uni-popup>
	</div>
</template>

<script>
export default{

    data(){
        return {
           list:[],
           num:10,
           isDisabled:false,
           recordList:[],
           page:1,
           totalPage:1,
           show:false,
           item:{},
           lang:''
        }
    },
    onLoad() {
        uni.setNavigationBarTitle({
            title:this.$t('home.qy')
        })
        this.lang = uni.getStorageSync('lang') ||'en'
        console.log(this.lang)
    },
    methods:{
      sub(){
        this.$refs.popup.close()
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
          this.$utils.initDataToken({
                url: 'prizes/lottery_record',
                data: {
                    page: this.page,
                    limit: 10
                },
                type: 'get'
            }, (res, msg) => {
                if(res.data.length>0){
                    this.recordList = res.data
                }
               this.totalPage = res.last_page
               this.show = true
            });
      },
      //初始化转盘
      init(){
            this.$utils.initDataToken({
                url: 'prizes/list',
                data: {},
                type: 'get'
            }, (res, msg) => {
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
           this.$utils.initDataToken({
					url: 'prizes/submit',
					data: {},
					type: 'post'
            }, (res, msg) => {
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
                    this.$refs.popup.open('center')
                    this.isDisabled = false
                    this.page = 1
                    this.totalPage = 1
                    this.show = false
                    this.getList()
             }, rotateSpeed * 1000)
       }
    },
    onShow() {
        this.init()
        this.getList()
    },
}
</script>

<style scoped lang="scss">
  .lottery {
          min-height:calc( 100vh - 44px);
          background: url('../../static/image/bg.png');
          background-size: 100% 100%;
          background-position: center center;
          overflow: hidden;
          .turntable{
                overflow: hidden;
                position: relative;
                height: 940upx;
                .content{
                        margin:0 auto;
                        margin-top:100upx;
                        height: 600upx;
                        width: 600upx;
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
                                                width: 100upx;
                                                height: 100upx;
                                                margin-bottom: 60upx;
                                                margin-top:4upx;
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
                            margin-top:-100upx;
                            margin-left:-100upx;
                            width: 200upx;
                            height: 200upx;
                            background: url('../../static/image/an.png');
                            background-size: 100% 100%;
                            text-align: center;
                            line-height: 200upx;
                        }
                }
                .dz{
                    position: absolute;
                    left:0;
                    right:0;
                    top:0;
                    bottom:0;
                    z-index: 1;
                    width: 750upx;
                    height: 940upx;
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
                        height: 320upx;
                        width: 80%;
                       
                    }
                }
                .zj{
                    position: absolute;
                    z-index: 3;
                    top:54upx;
                    left:50%;
                    margin-left:-120upx;
                    width: 240upx;
                    height: 80upx;
                    background: url('../../static/image/zj.png');
                    background-size: 100% 100%;
                }
                .prize{
                    position: absolute;
                    z-index: 0;
                    right: 40upx;
                    top:80upx;
                    width: 120upx;
                    height: 200upx;
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
            .cs{
                width:40upx;
                height: 40upx;
            }
        }
        .flex-title{
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            .spacing{
                letter-spacing: 6upx;
            }
            .tb{
                position: absolute;
                left:40upx;
                writing-mode: tb;
                background: #FF3A36;
                padding:10upx 8upx;
                border-radius: 4upx;
                height: max-content;
            }
            .caret-right{
                position: absolute;
                width: 80upx;
                height: 80upx;
                left:50upx;
            }
            .max{
                font-family: YouSheBiaoTiHei;
                font-style: oblique;
                line-height: 90upx;
            }
        }
        .label{
            position: relative;
            background: #FF3A36;
            padding:10upx 14upx;
            border-radius: 4upx;
            width: max-content;
            margin-left:60upx;
            margin-top:10upx;
            letter-spacing: 2upx;
            .label-img{
                position: absolute;
                width: 80upx;
                height: 80upx;
                transform: rotate(-90deg);
                top:-40upx;
                left:76upx;
                &.th{
                    left:46upx;
                }
            }
        }
        .record{
            text-align: center;
            font-size: 46upx;
            .list{
                width: 600upx;
                margin:40upx auto 0;
                .item{
                    &:nth-child(2n){
                        background: #fff;
                    }
                    &:nth-child(2n-1){
                        background: #E6E6E6;
                    }
                    &:first-child{
                        border-radius: 6upx 6upx 0 0;
                    }
                    &:last-child{
                        border-radius: 0 0 6upx 6upx;
                    }
                    display: flex;
                    justify-content: space-between;
                    align-item:center;
                    height: 60upx;
                    .item-text{
                        flex:1;
                        text-align:center;
                        line-height: 60upx;
                        color:#292929;
                    }
                }
            }
            .pagesize{
                display: flex;
                width: 600upx;
                margin:20upx auto 0;
                .pg-text{
                    flex: 1;
                    text-align:center;
                }
             }
             .bt-text{
                 color:#753632;
                 margin:50upx 0 40upx;
             }
        }
        .winning{
            background: #fff;
            border-radius: 6upx;
            width: 60vw;
            /* height: 25vh; */
            display: flex;
            flex-direction: column;
            align-items: center;
            /* justify-content: center; */
            .win-center{
                background: #ffc670;
                width: 100%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding:20upx 0;
                .win-img{
                    width: 120upx;
                    height: 120upx;
                    margin:20upx;
                }
            }
            .win-text{
                color:#ffc670;
            }
            .win-top{
                padding:20upx 0;
            }
            .sure{
                margin:20upx 0;
                padding:14upx 60upx;
                background: #ffc670;
            }
        }	
  }
</style>
