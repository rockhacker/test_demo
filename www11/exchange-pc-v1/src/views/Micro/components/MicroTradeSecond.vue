<template>
    <div class="mt-12 ml-5 text-14">{{ $t('trade.trade_time') }}</div>
    <div class="flex flex-wrap pb-10 mt-10 text-12">
        <div v-for="item in tradeSecond" :key="item.id"
            class="bg-[#3F423A] rounded-4 mb-6 w-30% text-center mr-12 py-6 cursor-pointer"
            :class="{ 'selected-badge': item === value }" @click="value = item">
            <div :class="item === value ? 'text-white' : 'text-[#888]'">
                {{ item.seconds }} {{ $t('trade.second') }}
            </div>
            <div :class="item === value ? 'text-#F84F4F' : 'text-[#888]'">
                {{ $t('trade.profit_rate') }} {{ multiply(+item.profit_ratio, 100) }}%
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { multiply } from 'lodash-es'
import type { TradeSecond } from '@/interface';

const props = defineProps<{
    modelValue: TradeSecond | undefined
    tradeSecond: TradeSecond[]
}>()

const emits = defineEmits(["update:modelValue"]);

const value = useVModel(props, "modelValue", emits);

</script>