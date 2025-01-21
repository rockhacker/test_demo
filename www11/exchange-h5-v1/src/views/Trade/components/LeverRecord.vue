<template>
    <div>
        <lever-order-item v-for="item in orders" :key="item.id" :order="item" />
    </div>
</template>

<script lang="ts" setup>
import { Transaction } from '@/interface/market';
import LeverOrderItem from './LeverOrderItem.vue';

const props = defineProps<{
    orders: Transaction[]
}>()

const { orders } = toRefs(props)
</script>