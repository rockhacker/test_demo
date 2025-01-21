<template>
    <div class="flex mt-20">
        <div class="flex-1">
            <div class="text-main text-20">{{ data.currency_quotation.close }}</div>
            <div class="flex items-center">
                <img v-if="isUp" class="w-12 h-12" src="@images/up.png">
                <img v-else class="w-12 h-12" src="@images/down.png">
                <span class="text-12" :class="[isUp ? 'text-up' : 'text-down']">
                    {{ isUp ? '+' : '' }}
                    {{ data.currency_quotation.change }}%
                </span>
            </div>
        </div>
        <div class="flex-1 ml-10 text-12">
            <div class="flex justify-between">
                <div class="flex-1 flex justify-between">
                    <div class="text-[#888]">{{ $t('trade.high') }}</div>
                    <div>{{ data.currency_quotation.high }}</div>
                </div>
            </div>
            <div class="flex justify-between my-4">
                <div class="flex-1 flex justify-between">
                    <div class="text-[#888]">{{ $t('trade.low') }}</div>
                    <div>{{ data.currency_quotation.low }}</div>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="flex-1 flex justify-between">
                    <div class="text-[#888]">{{ $t('trade.24h_volume') }}</div>
                    <div>{{ data.currency_quotation.volume }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Match } from '@/interface';

const props = defineProps<{
    match: Match
}>()

const { match: data } = toRefs(props);

const isUp = computed(() => {
    if (!data.value) return false
    return +data.value.currency_quotation.change >= 0
})
</script>