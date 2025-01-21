<template>
    <div class="flex items-center">
        <div class="ml-20 text-18" :class="[+match!.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
            {{ +match.currency_quotation.change >= 0 ? "+" : "" }}{{
            +match.currency_quotation.close }}
        </div>

        <div class="flex flex-col items-center justify-center ml-40">
            <div>{{ $t('match.increase') }}</div>
            <div :class="[+match!.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
                {{ +match.currency_quotation.change >= 0 ? "+" : "" }}
                {{+match.currency_quotation.change }}%
            </div>
        </div>

        <div class="flex flex-col items-center justify-center ml-40">
            <div>{{ $t('match.highest_price') }}</div>
            <div>{{ match.currency_quotation.high }}</div>
        </div>

        <div class="flex flex-col items-center justify-center ml-40">
            <div>{{ $t('match.lowest_price') }}</div>
            <div>{{ match.currency_quotation.low }}</div>
        </div>

        <div class="flex flex-col items-center justify-center ml-40">
            <div>{{ $t('match.24h_volume') }}</div>
            <div>{{ match.currency_quotation.volume }}</div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Match } from '@/interface';

const props = defineProps<{
    match: Match
}>()

const { match } = toRefs(props)
</script>