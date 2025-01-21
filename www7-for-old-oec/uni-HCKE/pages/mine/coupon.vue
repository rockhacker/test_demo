<template>
  <view class="pt-20" :class="theme">
    <div class="mb10 flex  relative" :class="{'expire-base-coupons' :item.status!=0,'base-coupons pointer':item.status==0}" v-for="(item,index) in couponList" :key="index" @click="setCoupon(item)">
      
        <div class="flex column jscenter pl10" style="width:80px;">
          <div class="ft28">{{parseFloat(item.amount)}}</div>
          <div class="ft16 mt10">{{item.currency.code}}</div>
        </div>
        <div class=" ml30 ptb10 flex1 black">
          <div class="ft24">{{item.title}}</div>
          <div class="">{{$t('new.gqsj')}}:{{item.exp_time}}</div>
          <div class="">{{$t('new.fqsj')}}:{{item.created_at}}</div>
           <div class="">{{$t('new.syxz')}}:{{$t('new.ddmz')}}<span>{{parseFloat(item.min_amount)}}</span>{{item.currency.code}}</div>
        <div class="flex jsend mr-60">
          <span class="plr10 white radius10" style="background:gray;" v-if="item.status==0">{{$t('new.wsy')}}</span>
           <span class="plr10 white radius10" style="background:gray;" v-if="item.status==1">{{$t('new.ysy')}}</span>
            <span class="plr10 white radius10" style="background:gray;"  v-if="item.status==-1">{{$t('new.ygq')}}</span>
        </div>
      </div>
      <image src="../../static/image/selects.png"  v-if="id==item.id" alt="" class="absolute btm0 w-48 h-28" style="right:0;bottom: 0;" />
    </div>
  </view>
</template>

<script>
import {mapState} from 'vuex'
export default {
    data(){
        return {
            couponList:[],
            id:null,
            currency_id:'',
            isTab:false
        }
    },
    computed: {
			...mapState(['theme']),
	},
    onLoad(options) {
        uni.setNavigationBarTitle({
            title: this.$t("new.xzzjq")
        })
        this.currency_id = options.currency_id
        this.isTab = options.from == 'tab'
        this.id = options.id
        this.getCoupon()
    },
    onShow() {
        this.$utils.setThemeTop(this.theme);
    },
    methods:{
        setCoupon(item){
        if(item.status !=0){
            return
        }
        if(this.id==item.id){
           uni.setStorageSync('couponInfo', '-1');
            this.id = null
            return
        }
        this.id = item.id
        uni.setStorageSync('couponInfo', JSON.stringify(item));
        !this.isTab? uni.navigateBack(): uni.switchTab({
                url: '/pages/contract/lever'
            });
        // this.dialogVisible = false
        },
        getCoupon(){
            this.$utils.initDataToken({
					url: 'coupon/check_coupon',
					data: {
                        currency_id:this.currency_id
                    },
					type: 'post'
				}, (res, msg) => {
                    res.forEach(item => {
                        if(item.status==0){
                        if(new Date(item.exp_time).getTime()<= new Date().getTime()){
                            item.status = -1 // 过期
                        }
                        } 
                    });
                    this.couponList = res
					console.log(this.couponList);
				});
        }
    }
}
</script>

<style>
.base-coupons {
    margin: 0 auto 20rpx;
    width: 700rpx;
    height: 240rpx;
    position: relative;
    background: radial-gradient(circle at right top, transparent 10px,  #fcca35 0) top left / 200rpx 51% no-repeat,
      radial-gradient(circle at right bottom, transparent 10px,  #fcca35 0) bottom left /200rpx 51% no-repeat,
      radial-gradient(circle at left top, transparent 10px, white 0) top right /500rpx 51% no-repeat,
      radial-gradient(circle at left bottom, transparent 10px, white 0) bottom right /500rpx 51% no-repeat;
       color: black;
    /* filter: drop-shadow(3px 3px 3px rgba(0,0,0,.3)); */
  }

  .expire-base-coupons {
    margin: 0 auto 20rpx;
    width: 700rpx;
    height: 240rpx;
    position: relative;
    background: radial-gradient(circle at right top, transparent 10px,  grey 0) top left / 200rpx 51% no-repeat,
      radial-gradient(circle at right bottom, transparent 10px,  grey 0) bottom left /200rpx 51% no-repeat,
      radial-gradient(circle at left top, transparent 10px, white 0) top right /500rpx 51% no-repeat,
      radial-gradient(circle at left bottom, transparent 10px, white 0) bottom right /500rpx 51% no-repeat;
       color: black;
    /* filter: drop-shadow(3px 3px 3px rgba(0,0,0,.3)); */
  }
</style>