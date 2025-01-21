<template>
    <div>
        <div class="bg-#1D1E1E">
            <div class="max-w-[1200px] mx-auto py-10 flex justify-between">
                <div class="pt-20">
                    <div class="text-30">{{ $t('nav.mining') }}</div>
                    <div class="mt-10">{{ $t('mining.product_content') }}</div>
                    <div class="mt-50 text-20">{{ $t('mining.product_better') }}</div>
                    <div class="flex justify-between mt-10 text-up">
                        <div>{{ $t('mining.better1') }}</div>
                        <div>{{ $t('mining.better2') }}</div>
                        <div>{{ $t('mining.better3') }}</div>
                        <div>{{ $t('mining.better4') }}</div>
                    </div>
                </div>
                <img src="@/assets/images/mining.png" alt="" srcset="">
            </div>
        </div>

        <div class="max-w-[1200px] mx-auto mt-20 w-full flex flex-col">
            <el-card class="w-full" shadow="hover">
                <div class="flex items-center justify-between">
                    <span class="text-white text-18">{{ $t('mining.machine_list') }}</span>
                    <el-button link @click="router.push('/mining/record')">
                        {{ $t('mining.subscribe_list') }}
                    </el-button>
                </div>
            </el-card>

            <el-card v-infinite-scroll="onLoad" :infinite-scroll-disabled="finished" class="w-full mt-20"
                shadow="hover">
                <div class="bg-#383838 rounded-16 p-12 text-12 mb-18" v-for="item in list" :key="item.id">
                    <div class="text-center text-18 text-white">{{ item.title }}</div>

                    <el-divider class="mt-10" />

                    <div class="flex items-center justify-between p-20 pt-0">
                        <img class="w-60 h-60" :src="item.image">

                        <div class="flex-1 ml-10">
                            <div class="text-18">{{ item.currency_code }}</div>
                            <div>
                                <div class="text-14">
                                    {{ $t('mining.expected_profit') }}: {{ item.dividend_percentage }} %
                                </div>
                                <div class="text-12">
                                    {{ $t('mining.machine_rent') }} {{ item.staring_sub_amount }}
                                </div>
                            </div>
                        </div>

                        <el-button class="rounded-4 h-40 text-14 px-20" color="#2fdab0" block
                            @click="router.push(`/mining/submit-order?id=${item.id}`)">
                            {{ $t('mining.subscribe') }}
                        </el-button>
                    </div>


                </div>
            </el-card>
        </div>
    </div>
</template>

<script setup lang="ts">
import { getMiningList } from '@/api';
import { Fund } from '@/interface';

const router = useRouter()
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const page = ref(0)

const list = ref<Fund[]>([])

const onLoad = () => {
    if (loading.value) return

    page.value++

    setLoading(true)

    const promise = getMiningList({ page: page.value }).then((({ data }) => {
        const orders = data.data
        list.value = page.value === 1 ? orders : list.value.concat(orders);
        setFinish(data.last_page === page.value)
    })).catch(() => {
        setFinish(true)
    }).finally(() => {
        setLoading(false)
    })

    return promise
}
</script>
