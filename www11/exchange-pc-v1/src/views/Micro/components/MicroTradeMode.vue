<template>
    <div class="mt-20" v-if="payableCurrency.length">
        <div class="ml-5 text-14">{{ $t('trade.mode') }}</div>
        <div class="flex flex-wrap pb-10 mt-10 text-12">
            <div v-for="item in payableCurrency" :key="item.id"
                class="bg-[#3F423A] text-14 rounded-4 mb-6 w-30% text-center mr-12 py-10 cursor-pointer"
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