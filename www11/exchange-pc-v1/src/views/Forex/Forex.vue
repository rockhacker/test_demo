<template>
    <div v-loading="!!getTradeListPromise" class="mt-6">
        <template v-if="!getTradeListPromise">
            <div class="flex">
                <ForexList class="w-340" @on-change="changeForex" />
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
                    <SubmitOrder ref="SubmitOrderRef" class="mt-6" @on-refresh="onRefresh" />
                </div>
                <ForexDepth class="min-w-400" :buy-list="buyDepth" :sell-list="sellDepth"
                    :match="getCurrentTradeItem" />
            </div>
            <OrderList ref="OrderListRef" v-if="isLogin && render" class="p-20" />
        </template>
    </div>
</template>

<script lang="ts" setup>
import { useForexStore, useUserStore } from '@/store';
import SubmitOrder from './components/SubmitOrder.vue'
import useForexDataFeed from '@/hooks/useForexDataFeed';
import useKLineChartPro from '@/hooks/useKLineChartPro';
import { useForex } from './hooks';
import ForexDepth from './components/ForexDepth.vue'
import OrderList from './components/OrderList.vue'

const { getTradeListPromise, getCurrentTradeItem } = storeToRefs(useForexStore())
const { datafeed } = useForexDataFeed(getCurrentTradeItem)
const { init, chart } = useKLineChartPro(getCurrentTradeItem, datafeed)
const { isLogin } = storeToRefs(useUserStore())

const { subDepth, unSubDepth, buyDepth, sellDepth } = useForex()

const [render, setRender] = useToggle(false)

const SubmitOrderRef = ref()
const OrderListRef = ref()

const changeForex = () => {
    unSubDepth()
    subDepth(getCurrentTradeItem.value!.Code)
    if (isLogin.value) {
        SubmitOrderRef.value.getBaseData()
        onRefresh()
    }
    chart.value?.setSymbol({
        ticker: getCurrentTradeItem.value!.Code,
        pricePrecision: getCurrentTradeItem.value!.ForexQuotations.Close.toString().split('.')[1]?.length || 4,
    });
}

const onRefresh = () => {
    OrderListRef.value?.init()
}

onMounted(async () => {
    if (getTradeListPromise.value) {
        await getTradeListPromise.value
    }

    setRender(true)
    nextTick(() => {
        setTimeout(() => {
            init()
        })
    })
    subDepth(getCurrentTradeItem.value!.Code)
})

onUnmounted(() => {
    unSubDepth()
})
</script>