<template>
    <nav-bar :title="getCurrentTradeItem?.Code" />
    <div v-if="getCurrentTradeItem" class="px-12 text-#888 text-12">
        <forex-trade-base-data :match="getCurrentTradeItem" />

        <KlineChart ref="KLineChartRef" height="280px" width="100%" forex :id="getCurrentTradeItem.Id"
            :symbol="getCurrentTradeItem.Code" />

        <div class="flex items-center justify-between mt-12">
            <div class="flex-1">{{ $t('trade.quantity') }}</div>
            <div class="flex-1 text-center">{{ $t('trade.price') }}</div>
            <div class="flex-1 text-right">{{ $t('trade.time') }}</div>
        </div>

        <div class="flex items-center justify-between mt-12" v-for="item in txList"
            :class="[item.way === 1 ? 'text-down' : 'text-up']">
            <div class="flex-1">{{ item.amount }}</div>
            <div class="flex-1 text-center">{{ item.price }}</div>
            <div class="flex-1 text-right">{{ dayjs(item.timestamp * 1000).tz(TIMEZONE).format("HH:mm:ss") }}</div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { TIMEZONE } from '@/common';
import { useForexSocketStore, useForexStore } from '@/store';
import ForexTradeBaseData from './components/ForexTradeBaseData.vue'
import { Complete, Forex_GlobalTx } from '@/interface/socket';
import dayjs from 'dayjs'
import utc from "dayjs/plugin/utc";
import timezone from 'dayjs/plugin/timezone'

dayjs.extend(timezone)
dayjs.extend(utc)

const { getCurrentTradeItem } = storeToRefs(useForexStore())
const { updateTradeListData } = useForexStore()
const { addListener } = useForexSocketStore()

const txList = ref<Complete[]>([])

const KLineChartRef = ref()

updateTradeListData()

addListener(`GLOBAL_TX.${getCurrentTradeItem.value!.Code}`, (msg: Forex_GlobalTx) => {
    msg.completes.forEach((item) => {
        txList.value.unshift(item)
        txList.value.length > 30 && txList.value.pop()
    })
})

onMounted(() => {
    KLineChartRef.value.init()
})

</script>