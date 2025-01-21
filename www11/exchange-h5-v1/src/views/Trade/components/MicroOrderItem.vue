<template>
    <div class="bg-#383838 rounded-16 p-12 text-12 mt-12" @click="setShowDetail(true)">
        <div class="flex justify-between">
            <div class="text-16">{{ microOrder.symbol_name }}</div>
            <div class="text-#A2A2AB text-14">{{ microOrder.status === 1 ? microOrder.remain_milli_seconds :
                microOrder.seconds }}s
            </div>
        </div>

        <div class="flex mt-12">
            <div>
                <div class="scale-90 text-#A2A2AB">{{ $t('trade.quantity') }}</div>
                <div class="text-#E8EDF4">{{ microOrder.number }}</div>
            </div>
            <div class="flex-1 text-center">
                <div class="scale-90 text-#A2A2AB">{{ $t('trade.buy_price') }}</div>
                <div class="text-#E8EDF4">{{ microOrder.open_price }}</div>
            </div>
            <div class="flex-1 text-center">
                <div class="scale-90 text-#A2A2AB">{{ $t('trade.deal_price') }}</div>
                <div class="text-#E8EDF4">{{ microOrder.end_price }}</div>
            </div>
            <div class="text-right">
                <div class="scale-90 text-#A2A2AB">{{ $t('trade.profit') }}</div>
                <div class="text-#E8EDF4">{{ profit }}</div>
            </div>
        </div>
    </div>

    <van-popup v-model:show="showDetail" class="w-full p-20 pt-30 rounded-4 text-14" closeable>
        <div class="text-18 text-center font-800">
            <span>{{ microOrder.symbol_name }}</span>
            <span v-if="microOrder.status !== 1">({{ microOrder.seconds }}s)</span>
        </div>
        <div v-if="microOrder.status === 1" class="flex-col flex items-center justify-center my-10">
            <van-circle :current-rate="currentRate" :rate="rate" :color="gradientColor" :text="text" :stroke-width="100"
                :size="150" :speed="speed" />
        </div>
        <div class="flex items-center justify-between">
            <div>{{ $t('trade.quantity') }}</div>
            <div>{{ microOrder.number }}</div>
        </div>
        <div class="flex items-center justify-between">
            <div>{{ $t('trade.buy_price') }}</div>
            <div>{{ microOrder.open_price }}</div>
        </div>
        <div class="flex items-center justify-between">
            <div>{{ $t('trade.deal_price') }}</div>
            <div>{{ microOrder.end_price }}</div>
        </div>
        <div class="flex items-center justify-between">
            <div>{{ $t('trade.profit') }}</div>
            <div>{{ profit }}</div>
        </div>
    </van-popup>
</template>

<script lang="ts" setup>
import { MicroOrder } from '@/interface'
import { useMarketStore } from '@/store';
const props = defineProps<
    { order: MicroOrder }
>()

const { order: microOrder } = toRefs(props)

const { currentMicroMatch } = storeToRefs(useMarketStore())

const [showDetail, setShowDetail] = useToggle(false)

const profit = computed(() => {
    if (microOrder.value.status !== 1) {
        return +microOrder.value.fact_profits;
    }
    if (!currentMicroMatch.value) return 0

    const buy = parseFloat(microOrder.value.open_price);
    const current = +currentMicroMatch.value.currency_quotation.close
    const number = parseFloat(microOrder.value.number);
    // 买涨
    if (microOrder.value.type === 1) {
        if (current > buy) {
            return number * (+microOrder.value.profit_ratio);
        } else if (current < buy) {
            return number * (+microOrder.value.profit_ratio) * -1;
        } else {
            return 0;
        }
    } else {
        if (current < buy) {
            return number * (+microOrder.value.profit_ratio);
        } else if (current > buy) {
            return number * (+microOrder.value.profit_ratio) * -1;
        } else {
            return 0;
        }
    }
})

const gradientColor = {
    '100%': '#FDF00C',
    '0%': '#9FEF4E',
};



const rate = computed(() => {
    if (microOrder.value.remain_milli_seconds <= 0) return 0
    return 1 - (microOrder.value.remain_milli_seconds / microOrder.value.seconds)
})

const currentRate = computed(() => {
    return 100 * rate.value
})

const speed = 100 / microOrder.value.seconds

const text = computed(() => {
    return `${microOrder.value.remain_milli_seconds}s`
})
</script>