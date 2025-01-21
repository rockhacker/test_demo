<template>
    <div class="flex cursor-pointer items-center p-10">
        <el-image class="w-36 h-36 mr-16" loading="lazy" :src="data.base_currency.logo" />
        <div>
            <div class="text-black">{{ data.symbol }}</div>
            <div class="flex items-center">
                <div class="text-main-black">
                    {{ data.currency_quotation.close }}
                </div>
                <div class="ml-10" :class="[+data.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
                    {{ +data.currency_quotation.change >= 0 ? "+" : "" }}{{ +data.currency_quotation.change }}%
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Match } from "@/interface";

const props = defineProps<{
    data: Match
}>()

const { data } = toRefs(props)
</script>