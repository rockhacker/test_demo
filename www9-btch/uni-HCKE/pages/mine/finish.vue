<template>
    <view class="min-h-screen " :class="theme">
      <view class="min-h-screen pb20 pt20 bg-white dark:bg-1C2532 px-40">
          <steps :status="3" class="bg-white dark:bg-1C2532  pb50"></steps>
          <view class="tc bold ft24">{{$t('add.zccg')}}</view>
          <view class="tc bold ft22 mt10">{{ $t('add.kqnd') }}</view>
          <view class="">
                <view class="mt30 pl20">
                    <uni-data-checkbox selectedColor="#3d80ce" selectedTextColor="#999" multiple v-model="checkbox1" :localdata="hobby"></uni-data-checkbox>
                </view>
                <view class="mt10 pl20">
                    <uni-data-checkbox selectedColor="#3d80ce" selectedTextColor="#999" multiple v-model="checkbox2" :localdata="hobby2"></uni-data-checkbox>
                </view>
          </view>
          <view class="flex item mt20" @click="path('/pages/trade/trade',true)">
              <view class="text">
                 <view class="ft18">{{$t('add.wxy')}}</view>
                 <view class="ft14 flex items-center">{{$t('add.qjy') }} <text class="ft18 pl10">➯</text></view>
              </view>
              <image src="../../static/image/mb.png" class="item-img" mode="widthFix"></image>
          </view>
          <view class="flex item mt20"  @click="path('/pages/home/recharge')">
              <view class="text">
                 <view class="ft18">{{$t('add.xycz')}}</view>
                 <view class="ft14 flex items-center">{{$t('add.qjy') }}  <text class="ft18 pl10">➯</text></view>
              </view>
              <image src="../../static/image/cz.png" class="item-img" mode="widthFix"></image>
          </view>
          <view  class="mt20 h-80 flex justify-center items-center text-center bg-main-linear text-white text-lg rounded-10" @click="path('/pages/home/home',true)">{{ $t("login.e_confrim") }}</view>
      </view>

    </view>
  </template>
  
  <script>
      import steps from '@/components/step.vue';
      import {mapState} from 'vuex'
      export default{
          components: {
             steps
          },
          data(){
            
              return{
                checkbox1: [0],
                checkbox2: [0],
                hobby: [{
					text: this.$t('add.wty'),
					value: 0
				}],
                hobby2: [{
					text: this.$t('add.wyty'),
					value: 0
				}],
              }
          },
          onLoad(e) {
              uni.setNavigationBarTitle({
                  title:this.$t('add').aqbd
              })
          },
          computed:{
             ...mapState(['theme']),
          },
          onShow() {
              this.$utils.setThemeTop(this.theme);
              
          },
          methods:{
            // confirm(){
            //     uni.switchTab({
			// 		url:'/pages/home/home'
			// 	})
            // },
            path(url,bool){
                if(bool){
                    uni.switchTab({url: url })
                }else{
                    uni.navigateTo({url: url })
                }
            }

          }
      }
  </script>
  <style lang="scss" scoped>
   .item{
    background: #f6f6f6;
    padding:30rpx 40rpx;
    justify-content: space-between;
    border-radius: 10rpx;
    .text{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .item-img{
        width: 132rpx;
        height: 144rpx;
    }
   }
   .mt20  .checklist-text{
    font-size: 12px;
   }
  </style>
  