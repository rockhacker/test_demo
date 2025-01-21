<template>
    <div>
        <div class="flex justify-between items-center text-14 px-4">
            <span class="flex-1">{{ $t('public.coin_type') }}</span>
            <span class="flex-1 text-center">{{ $t('match.last_price') }}</span>
            <span class="flex-1 text-right">{{ $t('match.increase') }}</span>
        </div>
        <div v-for="item in tradeList" :key="item.Id">
            <div class="flex items-center justify-between py-16 text-14 px-4 cursor-pointer"
                :class="{ 'bg-#4a4a4a': item === getCurrentTradeItem }" @click="handleClick(item.Id)">
                <div class="flex-1">{{ item.Code }}</div>
                <div class="flex flex-1 items-center justify-center scale-90 text-center">
                    <span :class="[item.ForexQuotations.Change >= 0 ? 'text-up' : 'text-down']">
                        {{ item.ForexQuotations.Close }}
                    </span>
                </div>
                <div class="flex-1 text-right">
                    <span v-if="item.MarketStatus === 1"
                        :class="[item.ForexQuotations.Change >= 0 ? 'text-up' : 'text-down']">{{
                            item.ForexQuotations.Change }}%
                    </span>
                    <span v-else>{{ $t('trade.closed') }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useForexStore } from "@/store";

const { tradeList, getCurrentTradeItem } = storeToRefs(useForexStore());
const { setCurrentTradeItem } = useForexStore();

const emits = defineEmits(["onChange"]);

const handleClick = (Id: number) => {
    setCurrentTradeItem(Id);
    nextTick(() => {
        emits("onChange", Id);
    })
};
</script>