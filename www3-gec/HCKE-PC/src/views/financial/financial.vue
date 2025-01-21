<template>
  <div class="minh100 ft16 bgblack">
    <div class="mauto pt20 wt1200 pb80">
      <el-card class="ft18 mb20 f-item" style="border:0;">
        <span class="white">{{ $t('financial.financial') }}</span>
        <!-- <el-link
          style="float: right; padding: 3px 0"
          class="text-primary"
          @click="$router.push({ path: '/financialRule' })"
          >{{ $t('financial.rule') }}</el-link
        > -->
      </el-card>

      <el-card class="ft18 mb20 f-item white" style="border:0;">
        <div
          class="mt-30 mx-30 rounded-xl h-174 flex alcenter between overflow-hidden"
        >
          <div class="flex justify-around flex2">
            <div class="flex1">
              <div
                class="tc font-medium mt-60"
                style="font-size: 60rpx;"
              >
                 {{ base.total_amount }}
              </div>
              <div class="tc div-base mt-30">
                {{ $t('financial.zztgdd') }}(USDT)
              </div>
            </div>
            <div class="flex1">
              <div class="tc">{{ base.day_profit }}</div>
              <div class="tc">{{ $t('financial.rsy') }}</div>
            </div>
            <div class="flex1">
              <div class="tc">{{ base.total_profit }}</div>
              <div class="tc">{{ $t('financial.ljsy') }}</div>
            </div>
          </div>
          <div
            class="h-36 w-1"
            style="background: rgba(255, 255, 255, .2);"
          ></div>
          <div class="flex1">
            <div class="tc">{{ base.total_in }}</div>
            <div class="tc">{{ $t('financial.tgzdd') }}</div>
          </div>
          <img src="../../assets/images/arrowRight.png" @click="$router.push('/financialWdtg')" alt class="wt40" />
        </div>
      </el-card>

      <el-card class="ft18 mb20 f-item white" style="border:0;">
        <div v-for="(item,index) in list" class="pb20 mt20"  style="border:0 solid rgba(255, 255, 255, .2);border-bottom-width: 1px;" :key="index" @click="$router.push({path:'/financialBuy',query:{id:item.id}})">
          <div class="flex alcenter between pb-20">
            <div class="flex alcenter">
              <img class="ht40 mr20" style="width:40px" src="@/assets/images/lc_item.png"></img>
              <div>{{item.title}}</div>
            </div>
            <div class="flex alcenter">
              <div class="plr10 ptb6 text-my-orange" style="border-radius: 20px;background: rgba(255, 178, 22, .1);">{{$t('financial.rsyl')}}{{item.dividend_percentage}}%</div>
              <img src="../../assets/images/arrowRight.png" style="width:30px;height:30px;"></img>
            </div>
          </div>
          <div class="mt-30" style="color:#979797">
            <div>{{$t('financial.dbxe')}}:
              <span class="pl-10 white">{{item.staring_sub_amount}}-{{item.max_sub_amount}}</span>
            </div>
            <!-- <div class="mt-10">{{$t('financial.gq')}}:
              <span class="pl-10 white">{{item.expire}}</span>
            </div> -->
          </div>
        </div>
      </el-card>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return {
      base:{},
      list:[]
    }
  },
  created(){
    this.getData()
    this.getProductList()
  },
  methods:{
    getData() {
      this.$http
          .initDataToken({ url: 'matter/list' }, false).then((res) => {
        console.log(res)
        this.base = res.info
      })
    },
    getProductList() {
      try {
        const that = this
        this.$http
          .initDataToken(
          {
            url: 'matter/list',
            data: {
              limit: 100,
            }
          },
          false
        ).then((res) => {
            this.list = res.outs.data
            
            console.log(this.list,222);
          })
      } catch (e) {
        console.log(e)
        //TODO handle the exception
      }
    }
  }
}
</script>

<style></style>
