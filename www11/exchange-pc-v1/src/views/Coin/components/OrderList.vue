<template>
    <div class="min-h-300" v-loading="loading">
        <div class="flex items-center justify-between px-20">
            <div class="text-white flex text-center">
                <type-bar v-model="orderType" :list="orderTypeList" @onChange="onRefresh" />
            </div>
            <div class="text-white flex text-center" v-if="orderType !== 2">
                <type-bar v-model="tradeType" :list="tradeTypeList" @onChange="onRefresh" />
            </div>
        </div>

        <div class="px-20 text-14 mb-10 pt-10" v-infinite-scroll="onLoad" :infinite-scroll-disabled="finished">
            <div class="flex items-center justify-between">
                <div class="flex-1">{{ $t('trade.time') }}</div>
                <div class="flex-1 text-center">{{ $t('public.trade_match') }}</div>
                <div class="flex-1 text-center" v-if="orderType === 2">{{ $t('match.direction') }}</div>
                <div class="flex-1 text-center">{{ $t('trade.single_price') }}</div>
                <div class="flex-1 text-center">{{ $t('trade.quantity') }}</div>
                <div class="flex-1 text-center">{{ $t('trade.deal_num') }}</div>
                <div class="flex-1 text-center" v-if="orderType === 2">{{ $t('trade.deal_count_num') }}</div>
                <div class="flex-1 text-right" v-if="orderType === 2">{{ $t('public.status') }}</div>
                <div class="flex-1 text-center" v-if="orderType !== 2">{{ $t('public.operate') }}</div>
            </div>
            <tx-order-item v-for="item in txOrder" :key="item.id" :order="item" :cancelBtn="orderType !== 2"
                @order-close="onRefresh" />

            <Empty v-if="txOrder.length === 0" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import useTxOrder from '../hoos/useTxOrder';
import TxOrderItem from './TxOrderItem.vue';

const { orderType, orderTypeList, tradeTypeList,
    changeOrderType, loading, finished, onLoad,
    tradeType, txOrder, subscribe, changeTradeType, onRefresh, unSubscribe } = useTxOrder()

onMounted(() => {
    subscribe()
})

onUnmounted(() => {
    unSubscribe()
})

defineExpose({
    changeOrderType,
    changeTradeType
})
</script>