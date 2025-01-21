<template>
    <div ref="QuotaItemRef" class="quota-item flex items-center justify-between px-16">
        <img class="h-44 w-44 rounded-[50%]" :src="match.base_currency.logo">
        <div class="flex-1 ml-10">
            <div class="flex justify-between text-14">
                <div>{{ match.base_currency_code }}</div>
                <div>{{ match.currency_quotation.close }}</div>
            </div>

            <div class="flex justify-between text-12">
                <div>{{ match.symbol }}</div>
                <div class="flex items-center">
                    <div class="w-40 h-10">
                        <area-chart v-if="data" :id="`${match.id}-item-AreaChart`" :width="120" :pricePrecision="4"
                            :data="data" :isDown="+match.currency_quotation.change < 0" class="area-chat" />
                    </div>
                    <div class="flex items-center justify-center scale-90">
                        <img v-if="+match.currency_quotation.change >= 0" class="w-16 h-16" src="@images/up.png">
                        <img v-else class="w-16 h-16" src="@images/down.png">
                        <span :class="[+match.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
                            {{ +match.currency_quotation.change >= 0 ? '+' : '' }}
                            {{ match.currency_quotation.change }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script lang="ts" setup>
import type { Match } from '@/interface/market'
import { getKLineData } from '@/api/market'
import { useLazyData } from '@/hooks/useLazyData';
import { KLineData } from 'klinecharts';

const props = defineProps<{
    match: Match
}>()

const { match } = toRefs(props)

const QuotaItemRef = ref();

const data = useLazyData<KLineData[]>(QuotaItemRef, () => {
    return new Promise((resolve, reject) => {
        getKLineData({
            currency_match_id: match.value.id
        }).then(({ data }) => {
            const res = data.map((item) => ({
                timestamp: item.time,
                open: item.open,
                high: item.high,
                low: item.low,
                close: item.close,
            }))
            resolve(res)
        }).catch(err => {
            reject(err)
        })
    })
});

</script>

<style lang="scss">
.quota-item {
    width: 100%;
    height: 74px;
    background: rgba(87, 87, 87, 0.40);
    box-shadow: 0.5px 0.5px 0px #6C7166 inset;
    border-radius: 16px;
    backdrop-filter: blur(4px);
    margin-top: 12px;

    .area-chat {
        width: 40px;
        height: 10px;
        text-align: center;
    }
}
</style>