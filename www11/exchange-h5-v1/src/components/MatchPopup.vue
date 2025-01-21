<template>
    <van-popup v-model:show="showLeft" position="left" class="h-full w-70%">
        <div class="flex overflow-x-auto p-12">
            <div v-for="item in currencyMatches" :key="item.id" class="mr-10 text-18"
                :class="[activeCurrencyId === item.id ? 'text-#9FEF4E' : 'text-#888']" @click="setCurrencyId(item.id)">
                {{ item.code }}
            </div>
        </div>
        <van-divider />
        <div v-for="item in matchList">
            <div class="flex items-center justify-between px-12 py-16" :class="{ 'bg-#4a4a4a': item.id === match!.id }"
                @click="setMatch(item.id)">
                <div>{{ item.symbol }}</div>
                <div class="flex items-center justify-center scale-90">
                    <img v-if="+item.currency_quotation.change >= 0" class="w-16 h-16" src="@images/up.png">
                    <img v-else class="w-16 h-16" src="@images/down.png">
                    <span :class="[+item.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
                        {{ +item.currency_quotation.change >= 0 ? '+' : '' }}
                        {{ item.currency_quotation.change }}%
                    </span>
                </div>
            </div>
            <van-divider />
        </div>
    </van-popup>
</template>

<script lang="ts" setup>
import { useMarketStore } from '@/store';
import useMatch from '@/hooks/useMatch'
import { MatchType } from '@/interface';

const props = defineProps<{
    modelValue: boolean
    type: MatchType
}>();

const emits = defineEmits(["update:modelValue", "onChange"]);

const showLeft = useVModel(props, "modelValue", emits);

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
    showLeft.value = false;
}

</script>