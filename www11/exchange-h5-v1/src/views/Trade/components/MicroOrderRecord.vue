<template>
    <div>
        <type-bar v-model="orderType" :list="orderTypeList" @onChange="onRefresh" />
        <van-pull-refresh v-model="refreshing" @refresh="onRefresh">
            <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
                <micro-order-item class="mt-12" v-for="item in orderList" :key="item.id" :order="item" />
            </van-list>
        </van-pull-refresh>
    </div>
</template>

<script lang="ts" setup>
import { useMicroOrder } from '../hooks/useMicro';
import MicroOrderItem from './MicroOrderItem.vue';

const { orderType, orderTypeList, orderList, refreshing, loading, finished, onRefresh, onLoad } = useMicroOrder()

const init = () => {
    orderType.value = 1
    onRefresh()
}

defineExpose({
    init
})
</script>