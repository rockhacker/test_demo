<template>
    <nav-bar :title="$t('mining.subscribe_list')" />

    <div class="flex items-center justify-between pt-10 text-center">
        <div class="flex-1">{{ $t('mining.interest') }}</div>
        <div class="flex-1">{{ $t('trade.time') }}</div>
    </div>


    <van-pull-refresh v-model="loading" @refresh="onRefresh">
        <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
            <div v-for="item in profitList" :key="item.id">
                <van-divider class="my-10" />
                <div class="flex items-center justify-between text-center">
                    <div class="flex-1">{{ item.interest }}</div>
                    <div class="flex-1">{{ item.created_at }}</div>
                </div>
            </div>
        </van-list>
    </van-pull-refresh>
</template>

<script lang="ts" setup>
import { getMiningOrderProfit } from '@/api/finance';
import { MiningProfit } from '@/interface/finance';

const route = useRoute()
const id = Number(route.query.id)
const profitList = ref<MiningProfit[]>([])

const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const onLoad = () => {
    page.value++

    setLoading(true)

    getMiningOrderProfit({ sub_id: id, page: page.value }).then(({ data }) => {
        const list = data.data
        profitList.value = page.value === 1 ? list : profitList.value.concat(list);
        setFinish(data.last_page === page.value)
    }).finally(() => {
        setLoading(false)
    })
}

const onRefresh = () => {
    // profitList.value = []
    page.value = 0
    onLoad()
}


</script>