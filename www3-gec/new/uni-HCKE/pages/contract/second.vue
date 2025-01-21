<template>
  <view class="pb-300 bg-white dark:bg-floor">
    <view class="flex items-center p-20 justify-between" v-if="currencyMatch">
      <view
        class="text-3xl pl-30"
        :class="[
          currencyMatch.currency_quotation.change < 0
            ? 'text-danger'
            : 'text-success',
        ]"
      >
        {{ currencyMatch.currency_quotation.close }}
      </view>
      <view class="">
        <view class="flex justify-between">
          <text>{{ $t("second.high") }}</text>
          <text class="pl-10">{{ currencyMatch.currency_quotation.high }}</text>
        </view>
        <view class="flex justify-between mt-6">
          <text>{{ $t("second.low") }}</text>
          <text class="pl-10">{{ currencyMatch.currency_quotation.low }}</text>
        </view>
        <view class="flex justify-between mt-6">
          <text>{{ $t("second.volume") }}</text>
          <text class="pl-10">
            {{ currencyMatch.currency_quotation.volume }}
          </text>
        </view>
      </view>
    </view>
    <view
      class="flex items-center border-0 border-y-2 border-solid border-gray-400"
    >
      <view
        class="flex1 text-center py-20 border-0 border-solid border-primary"
        :class="{ 'border-b-2': active == index }"
        v-for="(item, index) in typeBar"
        :key="index"
        @click="changeType(item, index)"
      >
        {{ item.label }}
      </view>
    </view>
    <kLine ref="kline"></kLine>
    <view class="px-30 mt-20">
      <view class="flex flex-wrap">
        <view
          class="secondCard relative mb-20"
          v-for="(item, index) in secondList"
          :key="index"
          @click="setTimeTtem(item)"
        >
          <view class="text-gray-600">
            {{ item.seconds }}{{ $t("second.miao") }}
          </view>
          <view style="transform: scale(0.8); color: #e27046">
          {{ accMul(item.profit_ratio ,100) }}%
          </view>
          <image
            v-if="item == second"
            class="w-30 h-30 absolute bottom-0 right-0"
            src="/static/image/icon.png"
            alt=""
          />
        </view>
      </view>

      <view class="mt-30">
        <view class="dark:text-white">{{ $t("second.tranMode") }}</view>

        <view class="flex overflow-x-auto mt-30">
          <view
            class="secondCard relative"
            v-for="(item, index) in currencyList"
            :key="index"
            @click="setMicroItem(item)"
          >
            <view class="text-gray-600">{{ item.code }}</view>
            <image
              v-if="item == currencyItem"
              class="w-30 h-30 absolute bottom-0 right-0"
              src="/static/image/icon.png"
              alt=""
            />
          </view>
        </view>
      </view>

      <view class="mt-30">
        <view>{{ $t("second.numOpen") }}</view>

        <view
          class="mt-20 border-solid border-2 border-gray-300 dark:border-gray-600 rounded-xl p-20 flex items-center"
        >
          <input class="flex1" v-model="num" type="text" :placeholder="$t('home.md') + second.limit_amount" />
          <picker
            @change="bindPickerChange"
            :value="index"
            :range="microNumbers"
          >
            <image src="/static/image/mores.png" class="w-40 h-40 ml-10 p-4" />
          </picker>
        </view>
      </view>

      <view class="flex items-center justify-between my-20">
        <view class="flex items-center">
          <image class="w-40 h-40" src="/static/image/moy.png" />
          <text>{{ $t("second.contract") }}</text>
        </view>
        <view> {{ balance }} </view>
      </view>

      <view class="flex items-center justify-start mb-20">
        <view
          class="flex1 mr-10 bg-success text-white rounded-default py-20 text-center text-xl"
          @click="submitOrder(1)"
        >
          {{ $t("second.buy") }}
        </view>
        <view
          class="flex1 ml-10 bg-danger text-white rounded-default py-20 text-xl text-center"
          @click="submitOrder(2)"
        >
          {{ $t("second.sell") }}
        </view>
      </view>
    </view>

    <view class="border-0 border-t-2 border-solid border-gray-300 dark:border-gray-600">
      <view class="flex m-20">
        <view
          class="text-base border-0 border-solid border-primary py-10"
          :class="{ 'border-b-2': orderType == 1 }"
          @click="chageOrderType(1)"
        >
          {{ $t("second.inTransaction") }}
        </view>
        <view
          class="text-base ml-40 border-0 border-solid border-primary py-10"
          :class="{ 'border-b-2': orderType == 3 }"
          @click="chageOrderType(3)"
        >
          {{ $t("second.closed") }}
        </view>
      </view>

      <template v-if="orderType == 1">
        <order v-for="(item,index) in list" :key="item.id" :info="item" @update="handleFinish"></order>
      </template>
      <template v-else>
        <order v-for="item in list" :key="item.id" :info="item"></order>
      </template>
      <view class="text-center py-100" v-if="list.length == 0">
				<image src="/static/image/nodata.png" class="w-100 h-100"></image>
				<view class="gray7">{{$t('home.norecord')}}</view>
			</view>
    </view>

    <uni-popup  :show="showInfo" :btnShow="false" :msg="info.symbol_name" @hidePopup="showInfo=false">
				<view class="text-52 py-16" v-if="info.status ==3" :class="info.fact_profits < 0 ? 'text-danger': 'text-success'">{{ info.fact_profits >=0? '+':'' }} {{ info.fact_profits }}</view>

				<view class="py-60 w-full mt-30">
					<view class="flex justify-between w-full px-30 mb-20">
					<view class="text-base">{{$t('trade.types')}}</view>
					<view class="text-base">{{info.type==1? $t('trade.rise'): $t('trade.fall')}}</view>
				</view>

				<view class="flex justify-between w-full px-30 mb-20">
					<view class="text-base">{{$t('trade.num')}}</view>
					<view class="text-base">{{info.number}}</view>
				</view>

				<template v-if="info.status==3">
          <view  class="flex justify-between w-full px-30 mb-20">
					<view class="text-base">{{$t('trade.price_cang')}}</view>
					<view class="text-base">{{info.open_price}}</view>
				</view>

        <view  class="flex justify-between w-full px-30 mb-20">
					<view class="text-base">{{$t('trade.real_num')}}</view>
					<view class="text-base">{{info.end_price}}</view>
				</view>	
        <view  class="flex justify-between w-full px-30 mb-20">
					<view class="text-base">{{$t('trade.time')}}</view>
					<view class="text-base">{{info.seconds}}{{ $t('second.miao') }}</view>
				</view>	
        </template>
				</view>

			</uni-popup>
  </view>
</template>

<script>
import kLine from "@/components/kline.vue";
import order from "./components/order.vue";
import uniPopup from '@/components/uni-popup.vue';
export default {
  components: {
    kLine,
    order,
    uniPopup
  },
  data() {
    return {
      active: 1,
      typeBar: [
        {
          label: "Time",
          action: "ChangeKLineArea",
        },
        {
          label: "1min",
          period: 4,
        },
        {
          label: "5min",
          period: 5,
        },
        {
          label: "30min",
          period: 7,
        },
        {
          label: "1hour",
          period: 8,
        },
        {
          label: "1day",
          period: 0,
        },
        {
          label: "1week",
          period: 1,
        },
        {
          label: "1mon",
          period: 2,
        },
      ],
      currencyMatch: null,
      secondList: [],
      second: {},
      currencyList: [],
      currencyItem: {},
      num: '',
      index: 0,

      list: [],
      orderType: 1,
      page: 1,
      hasMore: false,
      showDetail:false,
      showInfo:false,
      info:{},
      unhandle:[]
    };
  },
  mounted() {
    this.getSecond();
  },
  computed: {
    microNumbers() {
      if (!this.currencyItem.micro_numbers) {
        return [];
      }
      return this.currencyItem.micro_numbers.map((item) =>
        parseFloat(item.number)
      );
    },
    balance() {
      if (!this.currencyItem.micro_account) {
        return "";
      }
      return `${parseFloat(this.currencyItem.micro_account.balance)}${
        this.currencyItem.code
      }`;
    },
  },
  methods: {
    handleFinish(id){
        const index = this.list.findIndex((item) => item.id == id);
        if (index != -1) {
          this.list.splice(index, 1);
          this.changeData(id)
        }
    },
    changeData(id){
      setTimeout(()=>{
        this.$utils.initDataToken(
        {
          url: "microtrade/lists",
          data: {
            order_id:id
          },
        },
        (res) => {
          if(res.data[0]){
            if(res.data[0].status !=3){
              console.log('未平仓');
              const index = this.unhandle.findIndex((item)=> item.id == id)
              if(index!==-1){
                if(this.unhandle[index].count ===4){
                  this.unhandle.splice(index,1)
                }else{
                  this.unhandle[index].count ++
                }
              }else{
                this.unhandle.push({id,count:0})
              }
            }else{
              const index = this.unhandle.findIndex((item)=>item.id == id)
              if(index!=-1){
                this.unhandle.splice(index,1)
              }
              this.info = res.data[0]
              console.log(this.info);
              this.showInfo =true
            }
            this.checkOrder()
          }
        }
      );
      },1)
    },
    checkOrder(){
      if(this.unhandle.length){
        setTimeout(()=>{
          this.unhandle[0].count++
          this.changeData(this.unhandle[0].id)
      },1000)
      }
    },
    changeType(item, index) {
      if (index == this.active) {
        return;
      }
      console.log(this.$refs.kline.ChangePeriod);
      this.active = index;
      // return
      if (item.action) {
        this.$refs.kline[item.action]();
      } else {
        this.$refs.kline.ChangePeriod(item.period);
      }
    },
    show(data) {
      this.$refs.kline.InitalHQChart()
      const current = this.typeBar[this.active];
      if (current.action) {
        this.$refs.kline[current.action](data);
      } else {
        this.$refs.kline.ChangePeriod(current.period, data);
      }
      this.page = 1;
      this.hasMore = true;
      this.currencyMatch = data.currencyMatch;
      const token = uni.getStorageSync("token");
      if (token) {
        this.getCurrency();
        this.getList();
        this.$ws.sendMessage({ type: "login", params: token });
        // this.$ws.Sub(["MICRO_CLOSED"]);
        // this.$ws.registerCallBack(this.handleCallBack);
      }
    },
    handleCallBack(msg) {
      // if (msg.type == "MICRO_CLOSED") {
      //   const id = msg.order.id;
      //   const index = this.list.findIndex((item) => item.id == id);
      //   if (index != -1) {
      //     this.list.splice(index, 1);
      //   }
      // }
    },
    hide() {
      this.$refs.kline.hide();
      // this.$ws.unSub(["MICRO_CLOSED"]);
      // this.$ws.unRegisterCallBack(this.handleCallBack);
    },
    getSecond() {
      this.$utils.initDataToken(
        {
          url: "microtrade/seconds",
        },
        (res, msg) => {
          this.secondList = res;
          this.second = this.secondList[0];
        }
      );
    },
    setTimeTtem(val) {
      this.second = val;
    },
    getCurrency() {
      this.$utils.initDataToken(
        {
          url: "microtrade/payable_currencies",
        },
        (res, msg) => {
          if (res.length > 0) {
            this.currencyList = res;
            this.currencyItem = this.currencyList[0];
            console.log(this.currencyItem, 33333);
          }
        }
      );
    },
    setMicroItem(item) {
      this.currencyItem = item;
    },
    bindPickerChange(e) {
      this.num = this.microNumbers[e.detail.value];
    },
    submitOrder(type) {
      uni.showLoading({
        mask:true
      });
      this.showDetail = true
      this.$utils.initDataToken(
        {
          url: "microtrade/submit",
          type: "POST",
          data: {
            type,
            currency_id: this.currencyItem.id,
            match_id: this.currencyMatch.id,
            number: this.num,
            seconds: this.second.seconds,
          },
        },
        (res, msg) => {
          console.log(res)
          this.orderType = 1;
          this.page = 1;
          this.getList();
          console.log(res);
        }
      );
    },
    chageOrderType(type) {
      if (this.type == this.orderType) {
        return;
      }
      this.orderType = type;
      this.page = 1;
      this.list = [];
      this.getList();
    },
    getList() {
      uni.showLoading({
        mask:true
      });
      this.$utils.initDataToken(
        {
          url: "microtrade/lists",
          data: {
            match_id: this.currencyMatch.id,
            status: this.orderType || 1, //为1 交易中  为3 已平仓  默认为交易中
            page: this.page,
            limit: 20,
          },
        },
        (res) => {
          uni.hideLoading()
          this.list = this.page == 1 ? res.data : this.list.concat(res.data);
          this.hasMore = res.last_page <= res.current_page ? false : true;
          if(this.showDetail && this.list.length){
            this.list[0].show = true
            this.showDetail = false
          }
          console.log(res);
        }
      );
    },
    loadMore() {
      if (!this.hasMore) {
        return;
      }
      this.page++;
      this.getList();
    },
  },
};
</script>

<style>
.secondCard {
  background: #eee;
  margin-right: 20rpx;
  min-width: 210rpx;
  font-size: 28rpx;
  color: #999;
  text-align: center;
  border-radius: 10rpx;
  position: relative;
  padding: 16rpx 24rpx;
  overflow: hidden;
}
</style>
