<template>
    <div v-loading="!!marketInitPromise" class="flex micro-page">
        <template v-if="currentMicroMatch">
            <div class="flex-1">
                <div class="bg-#1D1E1E h-66 my-4 flex items-center px-40">
                    <el-popover placement="bottom" :width="380" trigger="hover">
                        <MatchList type="micro" @onChange="changeMatch" />
                        <template #reference>
                            <div class="flex items-center cursor-pointer text-18">
                                <span class="pr-10">{{ currentMicroMatch.symbol }}</span>
                                <el-icon>
                                    <CaretBottom />
                                </el-icon>
                            </div>
                        </template>
                    </el-popover>

                    <MatchBaseData :match="currentMicroMatch" />
                </div>
                <div class="flex klinecharts-pro h-672">
                    <template v-if="render">
                        <div id="left"></div>
                        <div class="flex-1">
                            <div id="top" />
                            <div id="container" class="h-620" />
                        </div>
                    </template>
                </div>

                <OrderList ref="OrderListRef" class="p-20" v-if="isLogin && render" />
            </div>
            <SubmitOrder ref="SubmitOrderRef" class="w-420 ml-4" @onRefresh="onRefresh" />
        </template>
    </div>
</template>

<script lang="ts" setup>
import { useMarketStore, useUserStore } from '@/store';
import SubmitOrder from './components/SubmitOrder.vue';
import OrderList from './components/OrderList.vue'
import useMatchDataFeed from '@/hooks/useMatchDataFeed';
import useKLineChartPro from '@/hooks/useKLineChartPro';

const { isLogin } = storeToRefs(useUserStore())
const { currentMicroMatch, marketInitPromise } = storeToRefs(useMarketStore())
const { datafeed } = useMatchDataFeed(currentMicroMatch)
const { init, chart } = useKLineChartPro(currentMicroMatch, datafeed)

const [render, setRender] = useToggle(false)

const SubmitOrderRef = ref()
const OrderListRef = ref()

const changeMatch = () => {
    chart.value?.setSymbol({
        ticker: currentMicroMatch.value!.symbol,
        pricePrecision: currentMicroMatch.value!.currency_quotation.close.toString().split('.')[1]?.length || 4,
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
})
</script>

<style lang="scss">
.micro-page {

    .selected-badge {
        background-image: url(../../assets/images/selected.png);
        background-repeat: no-repeat;
        background-size: contain;
        background-position: top right;
        background-size: 20px 20px;
    }
}
</style>