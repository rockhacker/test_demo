<template>
  <view class="wdtg" :class="theme">
    <uni-nav-bar fixed backIcon>
      <view class="flex-1 p-30 flex justify-center items-center text-2xl">
        {{ $t('financial.wdtg') }}
      </view>
      <!-- <slot name="right">
        <view @click="topo" class="pr-30">{{
          $t('financial.rule')
        }}</view>
      </slot> -->
    </uni-nav-bar>

    <view class="text-center mt-60" style="font-size: 60rpx">
      {{ base.people_all }}
    </view>

    <view class="text-center mt-30">
      {{ $t('financial.tgzrs') }}
    </view>

    <view class="mx-30 p-30 rounded-xl flex mt-50" style="background: #272727">
      <view class="flex flex-col flex-1 items-center">
        <view class="text-2xl">{{ base.people_one }}</view>
        <view class="mt-20">{{ $t('financial.ydrs') }}</view>
      </view>
      <view
        class="flex flex-col flex-1 items-center px-30"
        style="
          border: 0 solid rgba(255, 255, 255, 0.2);
          border-left-width: 1rpx;
          border-right-width: 1rpx;
        "
      >
        <view class="text-2xl">{{ base.people_two }}</view>
        <view class="mt-20">{{ $t('financial.edrs') }}</view>
      </view>
      <view
        class="flex flex-col flex-1 items-center"
        style="border-right: 1rpx solid rgba(255, 255, 255, 0.2)"
      >
        <view class="text-2xl">{{ base.people_three }}</view>
        <view class="mt-20">{{ $t('financial.sdrs') }}</view>
      </view>
      <view class="flex flex-col flex-1 items-center">
        <view class="text-2xl">{{ base.people_four }}</view>
        <view class="mt-20">{{ $t('financial.sid') }}</view>
      </view>
    </view>

    <view class="p-30">
      <view class="text-xl mt-30">{{ $t('financial.wdkh') }}</view>

      <view class="w-690 rounded-xl mt-30" style="background: #272727">
        <view class="flex">
          <view
            class="flex-1 text-center p-20"
            :class="{ type: active == 1 }"
            @click="change(1)"
          >
            {{ $t('financial.yd') }}
          </view>
          <view
            class="flex-1 text-center p-20"
            :class="{ type: active == 2 }"
            @click="change(2)"
            style="
              border-left: 1rpx solid rgba(255, 255, 255, 0.2);
              border-right: 1rpx solid rgba(255, 255, 255, 0.2);
            "
          >
            {{ $t('financial.ed') }}
          </view>
          <view
            class="flex-1 text-center p-20"
            :class="{ type: active == 3 }"
            @click="change(3)"
            style="border-right: 1rpx solid rgba(255, 255, 255, 0.2)"
          >
            {{ $t('financial.sd') }}
          </view>
          <view
            class="flex-1 text-center p-20"
            :class="{ type: active == 4 }"
            @click="change(4)"
          >
            {{ $t('financial.sid') }}
          </view>
        </view>
        <view>
          <view v-for="(item,index) in list" :key="index">
            <view
              class="p-30"
              style="border-bottom;: 1rpx solid rgba(255, 255, 255, .2)"
            >
              <view class="flex justify-between">
                <view>
                  <text class="text-lg" style="color: #8b8b8b"
                    >{{ $t('financial.yhm') }}:
                  </text>
                  <text class="text-lg pl-10">{{item.email?item.email:item.mobile}}</text>
                </view>
                <view>
                  <text class="text-lg" style="color: #8b8b8b"
                    >{{ $t('financial.zrs') }}:
                  </text>
                  <text class="text-lg pl-10"
                    >{{item.lower_num}} {{ $t('financial.ren') }}</text
                  >
                </view>
              </view>
              <view class="mt-16">
                <text class="text-lg" style="color: #8b8b8b"
                  >{{ $t('financial.rq') }}:
                </text>
                <text class="text-lg pl-10">{{item.created_at}}</text>
              </view>
            </view>
          </view>
        </view>
      </view>
    </view>
  </view>
</template>

<script>
import { mapState } from 'vuex'
export default {
  data() {
    return {
      active: 1,
      base: {},
      page: 1,
      limit: 20,
	  hasMore:true,
	  list:[]
    }
  },
  computed: {
    ...mapState(['theme'])
  },
  onLoad() {
    this.getData()
    this.getList()
  },
  onPullDownRefresh() {
	  this.getData()
	  this.page = 1;
	  this.getList()
	  setTimeout(function () {
			uni.stopPullDownRefresh();
		}, 1000);
  },
  onReachBottom() {
	  if(!this.hasMore){
		  return
	  }
	  this.page++
	  this.getList()
  },
  methods: {
    change(index) {
      this.active = index
	  this.page = 1;
	  this.getList()
    },
    getData() {
      this.$utils.initDataToken(
        { url: 'user/advert', data: { type: 2 } },
        (res) => {
          console.log(res)
          this.base = res
        }
      )
    },
    getList() {
      this.$utils.initDataToken(
        {
          url: 'user/advert',
          data: {
            type: 1,
            level: this.active,
            page: this.page,
            limit: this.limit
          }
        },
        (res) => {
		  if(this.page == 1){
			  this.list = res.data
		  }else{
			  this.list.push(...res.data)
		  }
		  this.hasMore = this.list.length < res.total
          console.log(res, 222)
        }
      )
    },
    topo(){
			const lang=uni.getStorageSync('lang') || 'en';
			window.open(`${this.$utils._DOMAIN}/wp/gonggao_${lang}.pdf`);
			// let winOpen = window.open("", "_blank");
			// let url ="/wp/LME_English.pdf"
			// setTimeout(()=>{
			// 			 winOpen.location = url;
			// })
		},
  }
}
</script>

<style lang="scss">
.wdtg {
  .type {
    color: #37b6ff;
    border-bottom: 2rpx solid #37b6ff;
  }
}
</style>
