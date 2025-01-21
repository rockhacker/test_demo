<template>
  <div class="home-page pb-100">
    <van-nav-bar>
      <template #left>
        <div class="bg-[#383838] rounded-14 p-8">
          <van-icon name="manager" size="1.4rem" color="#888888" @click="router.push('/mine')" />
        </div>
      </template>
      <!-- <template #right>
        <div class="p-4" @click="setShowRight(true)">
          <van-icon name="wap-nav" size="1.8rem" color="#9FEF4E" />
        </div>
      </template> -->
    </van-nav-bar>
    <!-- 顶部轮播图位置 -->
    <img class="w-full h-210" src="@images/home-banner.png">

    <div class="flex items-center justify-between mt-20">
      <div class="flex flex-col flex-1 justify-center items-center text-center" @click="router.push('/user/chat')">
        <van-icon name="chat-o" size="1.8rem" color="#9FEF4E" />
        <span class="pt-4 text-12">{{ $t('func.chat') }}</span>
      </div>
      <div class="flex flex-col flex-1 justify-center items-center text-center" @click="router.push('/user/auth')">
        <van-icon name="certificate" size="1.8rem" color="#9FEF4E" />
        <span class="pt-4 text-12">{{ $t('auth.real_name') }}</span>
      </div>
      <div class="flex flex-col flex-1 justify-center items-center text-center" @click="router.push('/user/recharge')">
        <van-icon name="peer-pay" size="1.8rem" color="#9FEF4E" />
        <span class="pt-4 text-12">{{ $t('recharge.fast_recharge') }}</span>
      </div>
      <div class="flex flex-col flex-1 justify-center items-center text-center" @click="router.push('/otc/list')">
        <van-icon name="shop-o" size="1.8rem" color="#9FEF4E" />
        <span class="pt-4 text-12">{{ $t('legal.legal_trade') }}</span>
      </div>
    </div>

    <!-- 行情预览图 -->
    <div class="hide-scroll py-20 flex flex-nowrap overflow-x-auto">
      <QuotaPreview v-for="item in previewList?.slice(0, 5) || []" :key="item.id" :match="item"
        @click="toCoinPage(item)" />
    </div>


    <div class="px-12">
      <!-- 行情列表 -->
      <div>
        <!-- title -->
        <van-tabs v-model:active="activeTab" line-width="40px" swipe-threshold=1 line-height="3px"
          title-active-color="#9fef4e" @change="changeTab">
          <van-tab v-for="item in tabList" :title="item.title" :name="item.id">
          </van-tab>
        </van-tabs>
        <!-- <div class="flex items-center justify-between text-18">
          <span v-for="item in currencyMatches" :key="item.id">{{ item.code }}</span>
          <span class="text-main">{{ $t('public.more') }} >></span>
        </div> -->
        <!-- main -->
        <QuotaItem v-if="activeTab !== -1" v-for="item in tradeMatchList" :key="item.id" :match="item"
          @click="toCoinPage(item)" />
        <ForexTradeItem v-else v-for="item in tradeList" :key="item.Id" :match="item" @click="toForexPage(item)" />
      </div>

      <!-- 公司介绍 -->
      <CompanyInfo class="mt-20" />
    </div>

    <!-- <van-popup v-model:show="showRight" class="h-full w-60% p-10" position="right">
      <div class="flex items-center py-10" @click="router.push('/user/recharge')">
        <svg-icon class="w-30 h-30" name="recharge" />
        <span class="pl-10">{{ $t('recharge.fast_recharge') }}</span>
      </div>
      <van-divider />
      <div class="flex items-center py-10" @click="router.push('/otc/list')">
        <svg-icon class="w-30 h-30" name="legal-trade" />
        <span class="pl-10">{{ $t('legal.legal_trade') }}</span>
      </div>
      <van-divider />
      <div class="flex items-center py-10" @click="router.push('/user/auth')">
        <svg-icon class="w-30 h-30" name="auth" />
        <span class="pl-10">{{ $t('auth.real_name') }}</span>
      </div>
    </van-popup> -->
  </div>
</template>

<script lang="ts" setup name="home">
import { Match } from '@/interface';
import { TradeItem } from '@/interface/forex';
import { useForexStore, useMarketStore } from '@/store'
import { useI18n } from 'vue-i18n';

const router = useRouter()
const { t } = useI18n()

const { currencyMatches, tradeCurrencyId, tradeMatchId, currentMarket } = storeToRefs(useMarketStore())
const { tradeList } = storeToRefs(useForexStore())
const { setCurrentTradeItem } = useForexStore()

// 显示币币交易的交易对
const previewList = computed(() => {
  return currencyMatches.value[0]?.matches.filter((item) => item.open_change === 1)
})

const tradeMatchList = computed(() => {
  if (tradeCurrencyId.value) {
    const target = currencyMatches.value.find((item) => item.id === tradeCurrencyId.value)
    if (target) {
      return target.matches.filter((item) => item.open_change === 1)
    }
  }
  return currencyMatches.value[0]?.matches.filter((item) => item.open_change === 1) || []
})

const tabList = computed(() => {
  const res = currencyMatches.value.map((item) => {
    return {
      title: item.code,
      id: item.id
    }
  })

  res.push({
    title: t('trade.block_trading'),
    id: -1
  })

  return res
})

const [showRight, setShowRight] = useToggle(false)

const activeTab = ref(tradeCurrencyId.value)

const changeTab = (id: number) => {
  if (id !== -1) {
    tradeCurrencyId.value = id
  }
}

// 跳转币币交易页面
const toCoinPage = (match: Match) => {
  tradeCurrencyId.value = match.quote_currency_id
  tradeMatchId.value = match.id
  router.push('/coin')
}

const toForexPage = (match: TradeItem) => {
  setCurrentTradeItem(match.Id)
  currentMarket.value = 3 // 选择衍生品交易
  router.push('/trade')
}

</script>
