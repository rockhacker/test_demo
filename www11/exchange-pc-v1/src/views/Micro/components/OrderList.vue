<template>
    <div class="min-h-300" v-loading="loading">
        <type-bar v-model="orderType" :list="orderTypeList" @onChange="onRefresh" />
        <div class="text-14 mb-10 pt-10" v-infinite-scroll="onLoad" :infinite-scroll-disabled="finished">
            <div class="flex items-center justify-between">
                <div class="flex-1">{{ $t('public.trade_match') }}</div>
                <div class="flex-1 text-center">{{ $t('trade.quantity') }}</div>
                <div class="flex-1 text-center">{{ $t('trade.buy_price') }}</div>
                <!-- 仅交易中显示字段 -->
                <template v-if="orderType === 1">
                    <div class="flex-1 text-center">{{ $t('trade.current_price') }}</div>
                    <div class="flex-1 text-center">{{ $t('trade.will_profit') }}</div>
                    <div class="flex-1 text-right">{{ $t('trade.count_down') }}</div>
                </template>
                <!-- 仅已平仓显示字段 -->
                <template v-else>
                    <div class="flex-1 text-center">{{ $t('trade.deal_price') }}</div>
                    <div class="flex-1 text-right">{{ $t('trade.profit') }}</div>
                </template>
            </div>
            <micro-order-item class="mt-12" v-for="item in orderList" :key="item.id" :order="item" />

            <Empty v-if="orderList.length === 0" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useMicroOrder } from '../hooks';
import MicroOrderItem from './MicroOrderItem.vue';


const { orderType, orderTypeList, orderList, loading, finished, onRefresh, onLoad } = useMicroOrder()

const init = () => {
    orderType.value = 1
    onRefresh()
}

defineExpose({
    init
})
</script>