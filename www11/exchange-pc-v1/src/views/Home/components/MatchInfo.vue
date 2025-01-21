<template>
    <div>
        <el-carousel height="90px" :autoplay="false" indicator-position="none" arrow="always">
            <el-carousel-item v-for="(match, index) in regroupArray(matchList, 3)" :key="index">
                <div class="grid grid-cols-3 gap-20 px-60 m-10">
                    <MatchCard v-for="item in match" :key="item.id" :data="item"
                        :class="{ 'active-shadow': currentMatchId === item.id }" @click="changeMatch(item)" />
                </div>
            </el-carousel-item>
        </el-carousel>

        <div class="h-400 w-full" v-loading="loading">
            <AreaChart v-if="klineData.length" ref="areaChartRef" id="home-area-chart" class="h-400"
                :data="klineData" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Match } from '@/interface';
import MatchCard from './MatchCard.vue';
import { useMarketStore } from '@/store';
import useKLineChat from '@/hooks/useKLine';
import { KLineData } from 'klinecharts';

const { currencyMatches, marketInitPromise } = storeToRefs(useMarketStore())
const klineData = ref<KLineData[]>([])
const { getChartData } = useKLineChat()
const [loading, setLoading] = useToggle(false)

const areaChartRef = ref()

const regroupArray = <T>(array: T[], groupSize: number) => {
    const groups = [];
    for (let i = 0; i < array.length; i += groupSize) {
        groups.push(array.slice(i, i + groupSize));
    }
    return groups;
}

const currentMatchId = ref<number>()

const matchList = computed(() => {
    const match: Match[] = []
    currencyMatches.value.forEach((item) => {
        match.push(...item.matches)
    })
    return match
})

const getData = async (update = false) => {
    try {
        setLoading(true)
        const [success, data = []] = await getChartData({
            currency_match_id: currentMatchId.value || matchList.value[0].id
        })
        klineData.value = data
        if (update) {
            areaChartRef.value?.applyNewData(klineData.value)
        }
    } finally {
        setLoading(false)
    }
}

const changeMatch = (match: Match) => {
    currentMatchId.value = match.id
    getData(true)
}

onMounted(async () => {
    if (marketInitPromise.value) {
        await marketInitPromise.value
    }
    getData()
})
</script>