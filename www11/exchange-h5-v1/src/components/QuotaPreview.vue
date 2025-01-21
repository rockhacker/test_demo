<template>
    <div ref="QuotaPreviewRef" class="quota-preview">
        <div class="text-12">{{ match.symbol }}</div>
        <div class="w-90 h-30">
            <area-chart v-if="data" :id="`${match.id}-AreaChart`" :width="120" :pricePrecision="4" :data="data"
                :isDown="+match.currency_quotation.change < 0" class="area-chat" />
        </div>
        <div class="text-16 font-700" :class="[+match.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
            {{ match.currency_quotation.close }}
        </div>
        <div class="flex items-center justify-center scale-80">
            <img v-if="+match.currency_quotation.change >= 0" class="w-16 h-16" src="@images/up.png">
            <img v-else class="w-16 h-16" src="@images/down.png">
            <span class="whitespace-nowrap" :class="[+match.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
                {{ +match.currency_quotation.change >= 0 ? '+' : '' }}
                {{ match.currency_quotation.change }}%
            </span>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { getKLineData } from '@/api/market';
import { useLazyData } from '@/hooks/useLazyData';
import type { Match } from '@/interface/market'
import type { KLineData } from "klinecharts";

const props = defineProps<{
    match: Match
}>()

const { match } = toRefs(props)

const QuotaPreviewRef = ref();

const data = useLazyData<KLineData[]>(QuotaPreviewRef, () => {
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

<style lang="scss" scoped>
.quota-preview {
    width: 107px;
    min-width: 107px;
    height: 140px;
    padding: 10px;
    background: linear-gradient(180deg, rgba(159, 239, 78, 0.40) 0%, rgba(87, 87, 87, 0) 100%);
    box-shadow: 0px 0.5px 0px rgba(159, 239, 78, 0.60) inset;
    border-radius: 16px;
    backdrop-filter: blur(24px);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
    margin-left: 12px;

    .area-chat {
        width: 90px;
        height: 24px;
        text-align: center;
    }
}
</style>