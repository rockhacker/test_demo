<template>
    <div v-loading="!!marketInitPromise">
        <template v-if="currentTradeMatch">
            <div class="bg-#1D1E1E h-66 my-4 flex items-center px-40">

                <el-popover placement="bottom" :width="360" trigger="hover">
                    <MatchList type="trade" @onChange="changeMatch" />
                    <template #reference>
                        <div class="flex items-center cursor-pointer text-18">
                            <span class="pr-10">{{ currentTradeMatch.symbol }}</span>
                            <el-icon>
                                <CaretBottom />
                            </el-icon>
                        </div>
                    </template>
                </el-popover>


                <MatchBaseData :match="currentTradeMatch" />

            </div>
            <div class="flex">
                <div class="flex-1 flex klinecharts-pro">
                    <template v-if="render">
                        <div id="left"></div>
                        <div class="flex-1">
                            <div id="top" />
                            <div id="container" class="h-620" />
                        </div>
                    </template>
                </div>

                <MatchHandicap class="w-420 ml-4" :buyList="buyList" :sellList="sellList" :globalList="globalList"
                    :match="currentTradeMatch" />

                <SubmitOrder ref="SubmitOrderRef" class="w-420 ml-4" :match="currentTradeMatch" @refresh="onRefresh" />
            </div>
            <OrderList ref="OrderListRef" v-if="isLogin" class="mt-20"></OrderList>
        </template>
    </div>
</template>

<script lang="ts" setup>
import { useMarketStore, useUserStore } from '@/store';
import MatchBaseData from '@/components/MatchBaseData/index.vue'
import useKLineChartPro from '@/hooks/useKLineChartPro';
import useMatchDataFeed from '@/hooks/useMatchDataFeed';
import MatchHandicap from '@/components/MatchHandicap/index.vue'
import SubmitOrder from './components/SubmitOrder.vue'
import OrderList from './components/OrderList.vue'
import useDepth from '@/hooks/useDepth';

const { currentTradeMatch, marketInitPromise } = storeToRefs(useMarketStore())
const { datafeed } = useMatchDataFeed(currentTradeMatch)
const { init, chart } = useKLineChartPro(currentTradeMatch, datafeed)
const { buyList, sellList, globalList, startDepth, stopDepth } = useDepth()
const { isLogin } = storeToRefs(useUserStore())

const SubmitOrderRef = ref()
const OrderListRef = ref()

const changeMatch = () => {
    stopDepth()
    startDepth(currentTradeMatch.value!.symbol)
    SubmitOrderRef.value.getBalance()
    chart.value?.setSymbol({
        ticker: currentTradeMatch.value!.symbol,
        pricePrecision: currentTradeMatch.value!.currency_quotation.close.toString().split('.')[1]?.length || 4,
    });
    onRefresh()
}

const onRefresh = () => {
    OrderListRef.value?.changeOrderType(0)
}

const [render, setRender] = useToggle(false)

onMounted(async () => {
    if (marketInitPromise.value) {
        await marketInitPromise.value
    }
    setRender(true)
    nextTick(() => {
        init()
    })
    startDepth(currentTradeMatch.value!.symbol)
})

onUnmounted(() => {
    stopDepth()
})
</script>