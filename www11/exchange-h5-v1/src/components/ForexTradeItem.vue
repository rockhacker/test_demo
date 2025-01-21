<template>
    <div ref="ForexTradeItemRef" class="quota-item flex items-center justify-between px-16">
        <div>
            <div> {{ match.Code }}</div>
            <div>{{ match.ForexQuotations.Close }}</div>
        </div>
        <div class="flex justify-between text-12">
            <div class="flex items-center">
                <div class="w-40 h-10">
                    <area-chart v-if="data" :id="`${match.Id}-Forex-item-AreaChart`" :width="120" :pricePrecision="4"
                        :data="data" :isDown="+match.ForexQuotations.Change < 0" class="area-chat" />
                </div>
                <div class="flex items-center justify-center">
                    <img v-if="+match.ForexQuotations.Change >= 0" class="w-16 h-16" src="@images/up.png">
                    <img v-else class="w-16 h-16" src="@images/down.png">
                    <span :class="[+match.ForexQuotations.Change >= 0 ? 'text-up' : 'text-down']">
                        {{ +match.ForexQuotations.Change >= 0 ? '+' : '' }}
                        {{ match.ForexQuotations.Change }}%
                    </span>
                </div>
            </div>
        </div>

    </div>
</template>

<script lang="ts" setup>
import { useLazyData } from '@/hooks/useLazyData';
import { KLineData } from 'klinecharts';
import { TradeItem } from '@/interface/forex';
import { getFxKLineData } from '@/api/forex';

const props = defineProps<{
    match: TradeItem
}>()

const { match } = toRefs(props)

const ForexTradeItemRef = ref();

const data = useLazyData<KLineData[]>(ForexTradeItemRef, () => {
    return new Promise((resolve, reject) => {
        getFxKLineData({
            forex_id: match.value.Id
        }).then(({ data }) => {
            const res = data.map((item) => ({
                timestamp: item.Time,
                open: item.Open,
                high: item.High,
                low: item.Low,
                close: item.Close,
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