<template>
    <div class="flex items-center justify-between" v-if="getCurrentTradeItem">
        <div class="flex items-center" @click="setShowMatchPopup(true)">
            <svg-icon class="w-24 h-24" name="menu"></svg-icon>
            <span class="px-4 text-20 ml-4">{{ getCurrentTradeItem.Code }}</span>
            <img v-if="getCurrentTradeItem.ForexQuotations.Change >= 0" class="w-16 h-16" src="@images/up.png">
            <img v-else class="w-16 h-16" src="@images/down.png">
            <span class="whitespace-nowrap"
                :class="[getCurrentTradeItem.ForexQuotations.Change >= 0 ? 'text-up' : 'text-down']">
                {{ getCurrentTradeItem.ForexQuotations.Change >= 0 ? '+' : '' }}
                {{ getCurrentTradeItem.ForexQuotations.Change }}%
            </span>
        </div>
        <slot name="right"></slot>
    </div>

    <forex-list-popup v-model="showMatchPopup" @onChange="emits('onChange')" />
</template>

<script lang="ts" setup>
import { useForexStore } from '@/store';
import ForexListPopup from './ForexListPopup.vue';

const { getCurrentTradeItem } = storeToRefs(
    useForexStore()
);

const emits = defineEmits(['onChange'])

const [showMatchPopup, setShowMatchPopup] = useToggle(false)
</script>