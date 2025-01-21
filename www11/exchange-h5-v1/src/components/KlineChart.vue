<template>
    <div v-loading="loading">
        <PeriodBar v-model="period" @onChange="initKLineData()"></PeriodBar>
        <div id="klineChart" :style="{ width, height }" />
    </div>
</template>

<script setup lang="ts">
import useKLineChat, { useForexKLineChat } from "@/hooks/useKLine";

const props = defineProps<{
    width: string,
    height: string,
    id: number,
    symbol: string
    forex?: boolean
}>()
const [loading, setLoading] = useToggle(false)

const period = ref("1min");

const { initChart, getChartData, setPriceVolumePrecision, applyNewData, updateData, setTimezone, setLocale, subscribe, unSubscribe } = props.forex ? useForexKLineChat() : useKLineChat()

let id = props.id
let symbol = props.symbol

const initKLineData = async () => {
    setLoading(true)
    loading.value
    const [success, klineData] = await getChartData(props.forex ? { forex_id: id, period: period.value } : { currency_match_id: id, period: period.value })
    if (!success) {
        return
    }
    setLoading(false)
    applyNewData(klineData)
    subscribe(symbol)
}

const changeSymbol = (newId: number, newSymbol: string) => {
    unSubscribe(symbol)
    id = newId
    symbol = newSymbol
    initKLineData()
}

const init = () => {
    initChart('klineChart')
    initKLineData()
    // kLineChart = useKLineChat("chart");
    // if (!kLineChart) {
    //     return;
    // }
    // // 设置精度
    // kLineChart.setPriceVolumePrecision(pricePrecision, volumePrecision);
    // // 为图表添加数据
    // kLineChart.applyNewData(data, true);
}

defineExpose({
    changeSymbol,
    init
})

</script>