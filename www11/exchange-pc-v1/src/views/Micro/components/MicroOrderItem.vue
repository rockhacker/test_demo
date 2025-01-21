<template>
    <div class="flex items-center justify-between">
        <div class="flex-1">{{ microOrder.symbol_name }}({{ microOrder.seconds }})s</div>
        <div class="flex-1 text-center">{{ microOrder.number }}</div>
        <div class="flex-1 text-center">{{ microOrder.open_price }}</div>
        <!-- 仅交易中显示字段 -->
        <template v-if="microOrder.status === 1">
            <!-- 当前价 -->
            <div class="flex-1 text-center">{{ currentMicroMatch?.currency_quotation.close }}</div>
            <!-- 预计盈亏 -->
            <div class="flex-1 text-center" :class="[profit < 0 ? 'text-down' : 'text-up']">{{ profit }}</div>
            <!-- 倒数计时 -->
            <div class="flex-1 text-right">{{ microOrder.remain_milli_seconds }}</div>
        </template>
        <!-- 仅已平仓显示字段 -->
        <template v-else>
            <!-- 成交价 -->
            <div class="flex-1 text-center">{{ microOrder.end_price }}</div>
            <!-- 盈亏 -->
            <div class="flex-1 text-right">{{ microOrder.fact_profits }}</div>
        </template>
    </div>
</template>

<script lang="ts" setup>
import { MicroOrder } from '@/interface'
import { useMarketStore } from '@/store';
const props = defineProps<
    { order: MicroOrder }
>()

const { order: microOrder } = toRefs(props)

const { currentMicroMatch } = storeToRefs(useMarketStore())

const profit = computed(() => {
    if (microOrder.value.status !== 1) {
        return +microOrder.value.fact_profits;
    }
    if (!currentMicroMatch.value) return 0

    const buy = parseFloat(microOrder.value.open_price);
    const current = +currentMicroMatch.value.currency_quotation.close
    const number = parseFloat(microOrder.value.number);
    // 买涨
    if (microOrder.value.type === 1) {
        if (current > buy) {
            return number * (+microOrder.value.profit_ratio);
        } else if (current < buy) {
            return number * (+microOrder.value.profit_ratio) * -1;
        } else {
            return 0;
        }
    } else {
        if (current < buy) {
            return number * (+microOrder.value.profit_ratio);
        } else if (current > buy) {
            return number * (+microOrder.value.profit_ratio) * -1;
        } else {
            return 0;
        }
    }
})
</script>