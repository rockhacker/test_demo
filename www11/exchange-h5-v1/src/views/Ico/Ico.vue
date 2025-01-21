<template>
    <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
        <div class="bg-#383838 rounded-16 p-12 text-12 mt-12" v-for="item in list" :key="item.id">

            <div class="flex items-center justify-between mb-6">
                <div class="text-16 font-800">
                    {{ item.currency_name }} ICO
                </div>
                <van-button class="rounded-8 px-8 h-30 text-12" color="#2fdab0"
                    @click="router.push(`/ico/submit-order?id=${item.id}`)">
                    {{ $t('ico.take_park_in') }}
                </van-button>
            </div>

            <span class="px-10 py-2 rounded-6 border-1 border-solid border-emerald text-emerald">
                {{ getStatus(item.start_time, item.finish_time, item.market_time) }}
            </span>

            <div class="mt-12 text-14 flex items-center justify-between">
                <div>
                    <span>{{ item.subscribed }} {{ item.currency_name }} /</span>
                    <span class="text-#888">{{ item.issue_number }} {{ item.currency_name }}</span>
                </div>
                <div>
                    {{ $t('ico.remainder') }}: {{ getRemainRatio(item.subscribed, item.issue_number) }}%
                </div>
            </div>

            <van-progress class="mt-20 mb-10" :percentage="getRemainRatio(item.subscribed, item.issue_number)"
                stroke-width="8" color="#2fdab0" />
        </div>
    </van-list>
</template>

<script lang="ts" setup>
import { getIcoList } from '@/api/finance';
import { Ico } from '@/interface/finance';
import { useI18n } from 'vue-i18n';

const router = useRouter()
const { t } = useI18n()

const status = [t('ico.no_start'), t('public.doing'), t('ico.drawing'), t('ico.issued')]

const getStatus = (start: Date, end: Date, market: Date) => {
    const startTime = new Date(start).getTime()
    const endTime = new Date(end).getTime()
    const marketTime = new Date(market).getTime()
    const currentTime = new Date().getTime() - 28800000;

    if (currentTime < startTime) return status[0]
    if (currentTime >= startTime && currentTime < endTime) return status[1]
    if (currentTime >= endTime && currentTime < marketTime) return status[2]
    if (currentTime >= marketTime) return status[3]
}

const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const page = ref(0)

const list = ref<Ico[]>([])

const getRemainRatio = (amount: number, sum: number) => {
    return ((((sum - amount) / sum) * 100) || 0).toFixed(2);
}

const onLoad = () => {
    page.value++

    setLoading(true)

    const promise = getIcoList({ page: page.value }).then((({ data }) => {
        const orders = data.data
        list.value = page.value === 1 ? orders : list.value.concat(orders);
        setFinish(data.last_page === page.value)
    })).finally(() => {
        setLoading(false)
    })

    return promise
}
</script>