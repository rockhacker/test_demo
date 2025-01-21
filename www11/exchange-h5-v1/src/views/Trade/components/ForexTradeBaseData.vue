<template>
    <div class="flex mt-20">
        <div class="flex-1">
            <div class="text-main text-20">{{ data.ForexQuotations.Close }}</div>
            <div class="flex items-center">
                <img v-if="isUp" class="w-12 h-12" src="@images/up.png">
                <img v-else class="w-12 h-12" src="@images/down.png">
                <span class="text-12" :class="[isUp ? 'text-up' : 'text-down']">
                    {{ isUp ? '+' : '' }}
                    {{ data.ForexQuotations.Change }}%
                </span>
            </div>
        </div>
        <div class="flex-1 ml-10 text-12">
            <div class="flex justify-between">
                <div class="flex-1 flex justify-between">
                    <div class="text-[#888]">{{ $t('trade.high') }}</div>
                    <div>{{ data.ForexQuotations.High }}</div>
                </div>
            </div>
            <div class="flex justify-between my-4">
                <div class="flex-1 flex justify-between">
                    <div class="text-[#888]">{{ $t('trade.low') }}</div>
                    <div>{{ data.ForexQuotations.Low }}</div>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="flex-1 flex justify-between">
                    <div class="text-[#888]">{{ $t('trade.24h_volume') }}</div>
                    <div>{{ data.ForexQuotations.Volume }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { TradeItem } from '@/interface/forex';


const props = defineProps<{
    match: TradeItem
}>()

const { match: data } = toRefs(props);

const isUp = computed(() => {
    if (!data.value) return false
    return +data.value.ForexQuotations.Change >= 0
})
</script>