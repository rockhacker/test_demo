<template>
  <view class="wdtg text-white" :class="theme">
    <!-- <uni-nav-bar fixed backIcon>
      <view class="flex-1 p-30 flex justify-center items-center text-2xl">
        {{ $t('financial.wdtg') }}
      </view>
      <slot name="right">
        <view @click="topo" class="pr-30">{{
          $t('financial.rule')
        }}</view>
      </slot>
    </uni-nav-bar> -->

    <view class="mx-30 mb-30 p-30 rounded-xl flex mt-50 bg-gray-600" style="word-break: break-all;">
      <view>{{ $t('financial.tglj') }}: {{extension_url}}</view>
      <view v-if="extension_url" class="text-warn pl-20" style="word-break: break-word;" @click="copyText(extension_url,$t('assets.copy_success'))">{{$t('assets.coypaddr')}}</view>
    </view>

    <!-- <view class="mx-30 mb-30 p-30 rounded-xl flex mt-50 bg-gray-600" style="word-break: break-all;">
      <div>{{ $t('financial.fygz') }}: <text class="pl-10" v-if="rule[1]">{{$t('financial.yjfy')+ rule[1]}}% ,{{$t('financial.ejfy')+ rule[2]}}% ,{{$t('financial.sjfy')+ rule[3]}}%</text>
        </div>
    </view> -->

    <view class="text-center text-black dark:text-white" style="font-size: 60rpx">
      {{ base.people_all }}
    </view>

    <view class="text-center mt-30 text-black dark:text-white">
      {{ $t('financial.tgzrs') }}
    </view>

    <view v-if="false" class="mx-30 p-30 rounded-xl flex mt-50 bg-gray-600">
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
      >
        <view class="text-2xl">{{ base.people_three }}</view>
        <view class="mt-20">{{ $t('financial.sdrs') }}</view>
      </view>
      <!-- <view class="flex flex-col flex-1 items-center">
        <view class="text-2xl">{{ base.people_four }}</view>
        <view class="mt-20">{{ $t('financial.sid') }}</view>
      </view> -->
    </view>

    <view v-if="base.comm_total!=undefined"  class="text-base mx-30 p-30 rounded-xl flex mt-50 bg-gray-600">
      {{$t('new.fyzj')}}: {{base.comm_total}}
    </view>

    <view class="p-30">
      <view class="text-xl mt-30 text-black dark:text-white">{{ $t('financial.wdtg') }}</view>

      <view class="w-690 rounded-xl mt-30 bg-gray-600">
        <view v-if="false" class="flex">
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
          >
            {{ $t('financial.sd') }}
          </view>
          <!-- <view
            class="flex-1 text-center p-20"
            :class="{ type: active == 4 }"
            @click="change(4)"
          >
            {{ $t('financial.sid') }}
          </view> -->
        </view>
        <view>
          <view v-for="(item,index) in list" :key="index">
            <view
              class="p-30"
              style="border-bottom;: 1rpx solid rgba(255, 255, 255, .2)"
            >
              <view class="flex justify-between">
                <view class="flex items-center">
                  <text class="text-lg" 
                    >UID:
                  </text>
                  <view class="flex items-center">
                    <text class="text-lg pl-10">{{item.uid}}</text>
                    <view class="ml-10 w-26 h-26 rounded-half border-4 border-solid" :class="[item.is_sign?'border-primary':'border-gray-400']"></view>
                  </view>
                </view>
                <view>
                  <text class="text-lg" 
                    >{{ $t('financial.zrs') }}:
                  </text>
                  <text class="text-lg pl-10"
                    >{{item.lower_num}} {{ $t('financial.ren') }}</text
                  >
                </view>
              </view>
              <view class="mt-16 flex justify-between">
                <view class="text-lg">
                    <text>{{$t('financial.fyje')}}</text>: {{item.comm_sum}}
                </view>
                <view>
                  <text class="text-lg" 
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
	  list:[],
    extension_url:'',
    rule:{}
    }
  },
  computed: {
    ...mapState(['theme'])
  },
  mounted() {
    this.getData()
    this.getList()
    // this.getRule()
    this.uerInfo()
    // financial.wdtg
  },
  onPullDownRefresh() {
    console.log('onPullDownRefresh');
    
	  this.getData()
	  this.page = 1;
	  this.getList()
	  setTimeout(function () {
			uni.stopPullDownRefresh();
		}, 1000);
  },
  // onReachBottom() {
	//   if(!this.hasMore){
	// 	  return
	//   }
	//   this.page++
	//   this.getList()
  // },
  methods: {
    getMoreData(){
      if(!this.hasMore){
		  return
	  }
	  this.page++
	  this.getList()
    },
    copyText(value, title, icon = 'none') {
				// uni.setClipboardData({
				// 	data: value,
				// 	success: () => {
				// 		uni.showToast({
				// 			icon,
				// 			title
				// 		})
				// 	}
				// });
				 let textarea = document.createElement("textarea")
				 textarea.value = value
				 textarea.readOnly = "readOnly"
				 document.body.appendChild(textarea)
				 textarea.select() // 选择对象
				 textarea.setSelectionRange(0, value.length) //核心
				 let result = document.execCommand("copy") // 执行浏览器复制命令
				 textarea.remove()
				 uni.showToast({
							icon,
							title
						})
			},
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
    getRule(){
      this.$utils.initDataToken(
        { url: 'user/comm_rule'},
        (res) => {
          this.rule = res
        }
      )
    },
    uerInfo(){
      this.$utils.initDataToken(
        { url: 'user/info'},
        (res) => {
          this.extension_url = `${window.location.origin}/h5/#/pages/mine/register?invite_code=${res.invite_code}`; 
        }
      )
    },
    getList() {
      this.$utils.initDataToken(
        {
          url: 'user/advert',
          data: {
            type: 1,
            // level: this.active,
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
			window.open(`https://api.gexcoin.me/wp/gonggao_${lang}.pdf`);
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
    color: #ffb115;
    border-bottom: 2rpx solid #ffb115;
  }
}
</style>
