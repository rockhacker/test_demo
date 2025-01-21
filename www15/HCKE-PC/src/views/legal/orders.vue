<template>
    <div>
        <!-- <div class="w100 mauto baselight2 mt20 bgpart ptb10 flex alcenter between ft16 plr20 radius2 bian"> -->
            <!-- <p class="ptb10">  <span class="pointer" @click="$router.go(-1)">{{$t('legal.trade')}} <span>/</span> </span > <span class="blue">{{$t('legal.order')}}</span></p> -->
            <!-- <p class="pointer ptb10" @click="$router.back(-1);">&lt;&lt; {{$t('store.returns')}}</p>
            <p class="ptb10 blue">{{$t('legal.order')}}</p> -->
        <!-- </div> -->
        <!-- <div class="ht10 bgline"></div> -->
        <div class="plr20 ptb20">
            <div class="ft16 ptb20 flex alcenter between">
                <div class="flex baselight2 gray6">
                    <span class="bold mr20 pointer gray6" @click="changeType('BUY')" :class="{'text-main':selectType=='BUY'}">{{$t('legal.buy')}}</span>
                    <span class="ht20 bdrfopt25" ></span>
                    <span class="bold ml20 pointer gray6" @click="changeType('SELL')" :class="{'text-main':selectType=='SELL'}">{{$t('legal.sell')}}</span>
                </div>
            </div>
            <div class="flex alcenter ft16 bold  baselight2" style="border:0px solid #eee;border-bottom-width: 1px;padding-bottom: 10px;">
                <div class="ptb8 pointer plr30 ptb5 radius10 tc" style="border:1px solid white;"  v-for="(item,i) in statusList"  :class="[status==item.status?'text-main border-green':'gray6']" @click="changeStatu(item.status)" :key="i">{{item.name}}</div>
            </div>
            <div class="mt20">
                <div class="flex alcenter ptb10 gray6" v-if="orderlist.length>0">
                    <span class="flex1">{{$t('store.orderNumber')}}</span>
                    <span class="flex1 tc">{{$t('legal.price')}}</span>
                    <span class="flex1 tc">{{$t('legal.num')}}</span>
                    <span class="flex1 tc">{{$t('legal.allmoney')}}</span>
                    <span class="flex1 tc">{{$t('store.times')}}</span>
                    <span class="flex1 tr">{{$t('store.orderstatus')}}</span>
                </div>
                <div class="baselight2">
                    <div class="flex alcenter ptb10 pointer gray6" v-for="(item,i) in orderlist" :key="i">
                        <div class="flex1 ">
                            <span :class="['ft14 gray6']">{{item.way=='SELL' ? $t('legal.sell'):$t('legal.buy')}}</span>
                            <span class="gray6">{{item.currency_name}}</span>
                        </div>
                        <span class="flex1 tc gray6" v-if="item.area_info">{{item.price | filterDecimals(4)}} {{item.area_info.currency}}</span>
                        <span class="flex1 tc gray6">{{item.number | filterDecimals(4)}}</span>
                        <span class="flex1 tc gray6" v-if="item.area_info">{{item.amount | filterDecimals(4)}} {{item.area_info.currency}}</span>
                        <span class="flex1 tc gray6">{{item.created_at}}</span>
                        <div class="flex1 tr gray6" @click="goDetail(item.id)">
                            <!-- 0 交易中 1已付款 2延期确认 3维权 4取消 5确认 -->
                            <span class="" v-if="item.status==0">交易中</span>
                            <span class="" v-if="item.status==1">{{$t('store.has_pay')}}</span>
                            <span class="" v-if="item.status==2">{{$t('store.delay')}}</span>
                            <span class="" v-if="item.status==3">{{$t('store.protection')}}</span>
                            <span class="" v-if="item.status==4">{{$t('store.has_cancel')}}</span>
                            <span class="" v-if="item.status==5">{{$t('store.done')}}</span>
                            <img src="../../assets/images/arrowRight.png" alt="" class="wt10">
                        </div>
                    </div>
                    <div class="tc ptb40" v-if="orderlist.length==0">
                        <img src="../../assets/images/nodata.png" alt="" class="wt70">
                        <p class="gray6">{{$t('legal.norecord')}}</p>
                    </div>
                </div>
            </div>
            <div class="abstort w100 tc lf0 btm20 pages mt40" >
                <el-pagination
                    @current-change="handleCurrentChange"
                    :current-page.sync="currentPage"
                    :hide-on-single-page="last"
                    :page-size='per_page'
                    layout="prev, pager, next"
                    :total="total">
                </el-pagination>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            id:'',
            selectType:'BUY',
            statusList:[{name:this.$t('legal.all'),status:'-1'},{name:this.$t('store.notdone'),status:0},{name:this.$t('store.has_pay'),status:1},{name:this.$t('store.delay'),status:2},{name:this.$t('store.protection0'),status:3},{name:this.$t('store.has_cancel'),status:4},{name:this.$t('store.done'),status:5}],
            status:-1,
            currentPage:1,
            per_page:10,
            total:0,
            last:false,
            orderlist:[],
        }
    },
    created(){
        this.id = this.$route.query.id;
        this.getlist();
    },
    methods:{
        // 买入卖出类型
        changeType(e){
            this.selectType=this.selectType==e ? '': e;
            this.currentPage=1;
            this.getlist();
        },
        changeStatu(status){
            this.status=status;
            this.currentPage=1;
            this.getlist();
        },
        getlist(){//获取历史发布列表
            this.$http.initDataToken({url:'otc/user_details',data:{page:this.currentPage,currency_id:this.id,way:this.selectType,status:this.status}},false)
            .then(res=>{
                this.total = res.total;
                this.per_page = res.per_page;
                this.last = res.last_page==1 ? true : false;
                this.orderlist = res.data;
            }) 
        },
        handleCurrentChange(val){//点击页码
            this.getlist();
        },
        // 订单详情页面
        goDetail(id){
            this.$router.push({
                path:'orderdetail',
                query:{id:id}
            })
        }
    }
}
</script>