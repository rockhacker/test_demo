<template>
    <div class="mt-12" v-if="payableCurrency.length">
        <div class="ml-5 text-14">{{ $t('trade.mode') }}</div>
        <div class="flex overflow-x-auto pb-10 mt-10 text-12">
            <div v-for="item in payableCurrency" :key="item.id"
                class="bg-[#3F423A] rounded-10 min-w-110 text-center mr-12 py-6"
                :class="{ 'selected-badge': item.id === value?.id }" @click="value = item">
                <div :class="item.id === value?.id ? 'text-white' : 'text-[#888]'">
                    {{ item.code }}
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import type { PayableCurrency } from '@/interface';


const props = defineProps<
    {
        payableCurrency: PayableCurrency[],
        modelValue: PayableCurrency | undefined
    }>()

const emits = defineEmits(["update:modelValue"]);

const value = useVModel(props, "modelValue", emits);
</script>