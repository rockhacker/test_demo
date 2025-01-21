<template>
    <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
        <div class="bg-#383838 rounded-16 p-12 text-12 mt-12" v-for="item in list" :key="item.id">
            <div class="text-center text-18">{{ item.title }}</div>

            <van-divider class="mt-10" />

            <div class="flex items-center justify-between px-20 mt-20">
                <div class="flex items-center">
                    <img class="min-w-60 w-60 h-60" :src="item.image">
                    <div class="text-18 mx-10">{{ item.currency_code }}</div>
                </div>
                <div>
                    <div class="text-14">
                        {{ $t('mining.expected_profit') }}: {{ item.dividend_percentage }} %
                    </div>
                    <div class="text-12 break-all">
                        {{ $t('mining.machine_rent') }} {{ item.staring_sub_amount }}
                    </div>
                </div>
            </div>

            <van-button class="mt-20 rounded-12 h-40 text-14" color="#2fdab0" block
                @click="router.push(`/mining/subscribe?id=${item.id}`)">
                {{ $t('mining.subscribe') }}
            </van-button>
        </div>
    </van-list>
</template>

<script lang="ts" setup>
import { getMiningList } from '@/api/finance';
import { Fund } from '@/interface/finance';

const router = useRouter()

const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const page = ref(0)

const list = ref<Fund[]>([])

const onLoad = () => {
    page.value++

    setLoading(true)

    const promise = getMiningList({ page: page.value }).then((({ data }) => {
        const orders = data.data
        list.value = page.value === 1 ? orders : list.value.concat(orders);
        setFinish(data.last_page === page.value)
    })).finally(() => {
        setLoading(false)
    })

    return promise
}
</script>