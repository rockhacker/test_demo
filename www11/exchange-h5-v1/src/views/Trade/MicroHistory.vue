<template>
    <nav-bar :title="$t('trade.order_history')" />

    <micro-order-record key="MircoOrderHistory" class="p-12" />
</template>

<script lang="ts" setup>
import MicroOrderRecord from './components/MicroOrderRecord.vue';
</script>