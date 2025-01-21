<template>
    <div class="max-h-450 overflow-auto w-360">
        <div class="flex justify-between items-center text-14">
            <span class="flex-1">{{ $t('public.coin_type') }}</span>
            <span class="flex-1 text-center">{{ $t('match.last_price') }}</span>
            <span class="flex-1 text-right">{{ $t('match.increase') }}</span>
        </div>
        <div class="flex justify-between text-14 items-center py-2 mt-4 cursor-pointer" v-for="item in matchList" :key="item.id" @click="setMatch(item.id)">
            <span class="flex-1">{{ item.symbol }}</span>
            <span class="flex-1 text-center">{{ item.currency_quotation.close }}</span>
            <span class="flex-1 text-right" :class="[+item!.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
                {{ +item.currency_quotation.change >= 0 ? '+' : '' }} {{ item.currency_quotation.change }}
            </span>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useMarketStore } from '@/store';
import useMatch from '@/hooks/useMatch'
import { MatchType } from '@/interface';

const props = defineProps<{
    type: MatchType
}>();

const emits = defineEmits(["update:modelValue", "onChange"]);

const { currencyMatches,
    tradeCurrencyId, tradeMatchId,
    leverCurrencyId, leverMatchId,
    microCurrencyId, microMatchId, } = storeToRefs(useMarketStore())

const type = props.type

const { match } = useMatch(props.type)

const tempCurrencyId = ref<number>()

const activeCurrencyId = computed(() => {
    if (tempCurrencyId.value) {
        return tempCurrencyId.value
    }
    return match.value?.quote_currency_id
})

const matchList = computed(() => {
    const target = currencyMatches.value.find((item) => item.id === activeCurrencyId.value)
    if (target) {
        switch (type) {
            case 'trade':
                return target.matches.filter((item) => item.open_change === 1)
            case 'lever':
                return target.matches.filter((item) => item.open_lever === 1)
            case 'micro':
                return target.matches.filter((item) => item.open_microtrade === 1)
        }
    }
    return []
})

const setCurrencyId = (id: number) => {
    tempCurrencyId.value = id
}

const setMatch = (id: number) => {
    if (id === match.value!.id) {
        return
    }
    const oldValue = match.value?.symbol
    if (type === 'micro') {
        microCurrencyId.value = activeCurrencyId.value
        microMatchId.value = id
    }
    else if (type === 'lever') {
        leverCurrencyId.value = activeCurrencyId.value
        leverMatchId.value = id
    } else {
        tradeCurrencyId.value = activeCurrencyId.value
        tradeMatchId.value = id
    }
    emits('onChange', oldValue);
}

</script>