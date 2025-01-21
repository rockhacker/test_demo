<template>
    <nav-bar :title="match!.symbol" />

    <div class="px-12 text-#888 text-12">
        <match-base-data :match="match!" />

        <KlineChart ref="KLineChartRef" height="280px" width="100%" :id="match!.id" :symbol="match!.symbol" />

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
import useMatch from '@/hooks/useMatch';
import { MatchType } from '@/interface';
import { Complete, GlobalTx } from '@/interface/socket';
import { useWebsocketStore } from '@/store';
import dayjs from 'dayjs'
import utc from "dayjs/plugin/utc";
import timezone from 'dayjs/plugin/timezone'
import useGlobalTx from '@/hooks/useGlobalTx';

dayjs.extend(timezone)
dayjs.extend(utc)

const route = useRoute()

const KLineChartRef = ref()

const type = route.query.type as MatchType
const { match } = useMatch(type)

const { txList } = useGlobalTx(match.value!.symbol)

onMounted(()=>{
    KLineChartRef.value.init()
})
</script>