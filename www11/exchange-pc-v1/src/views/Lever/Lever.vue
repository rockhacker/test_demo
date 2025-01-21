<template>
    <div v-loading="!!marketInitPromise" class="mt-6">
        <template v-if="currentLeverMatch">
            <div class="flex">
                <MatchList class="max-h-820 bg-#1D1E1E px-10" type="lever" @onChange="changeMatch" />
                <div class="flex-1 mx-6">
                    <div class="flex klinecharts-pro">
                        <template v-if="render">
                            <div id="left"></div>
                            <div class="flex-1">
                                <div id="top" />
                                <div id="container" class="h-400" />
                            </div>
                        </template>
                    </div>
                    <SubmitOrder ref="SubmitOrderRef" class="mt-6" @onRefresh="onRefresh" />
                </div>
                <MatchHandicap class="w-420" :buyList="buyList" :sellList="sellList" :globalList="globalList"
                    :match="currentLeverMatch" />
            </div>
            <OrderList ref="OrderListRef" v-if="isLogin && render" class="p-20" />
        </template>
    </div>
</template>

<script lang="ts" setup>
import useDepth from '@/hooks/useDepth';
import useKLineChartPro from '@/hooks/useKLineChartPro';
import useMatchDataFeed from '@/hooks/useMatchDataFeed';
import { useMarketStore, useUserStore } from '@/store';
import OrderList from './components/OrderList.vue'
import SubmitOrder from './components/SubmitOrder.vue'

const { isLogin } = storeToRefs(useUserStore())
const { currentLeverMatch, marketInitPromise } = storeToRefs(useMarketStore())
const { datafeed } = useMatchDataFeed(currentLeverMatch)
const { init, chart } = useKLineChartPro(currentLeverMatch, datafeed)
const { buyList, sellList, globalList, startDepth, stopDepth } = useDepth()

const [render, setRender] = useToggle(false)

const SubmitOrderRef = ref()
const OrderListRef = ref()

const changeMatch = () => {
    stopDepth()
    startDepth(currentLeverMatch.value!.symbol)
    chart.value?.setSymbol({
        ticker: currentLeverMatch.value!.symbol,
        pricePrecision: currentLeverMatch.value!.currency_quotation.close.toString().split('.')[1]?.length || 4,
    });
}

const onRefresh = () => {
    OrderListRef.value?.init()
}

onMounted(async () => {
    if (marketInitPromise.value) {
        await marketInitPromise.value
    }
    setRender(true)
    nextTick(() => {
        init()
    })

    startDepth(currentLeverMatch.value!.symbol)
})

onUnmounted(() => {
    stopDepth()
})
</script>