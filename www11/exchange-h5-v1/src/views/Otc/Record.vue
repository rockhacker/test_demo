<template>
    <nav-bar :title="$t('legal.trade_history')">
        <template #right>
            <van-icon name="label" size="1.3rem" color="#9FEF4E" @click="setShowFilterPopup(true)" />
        </template>
    </nav-bar>

    <van-pull-refresh v-model="loading" @refresh="onRefresh">
        <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
            <div v-for="item in orderList" :key="item.id" class="px-12 pt-12"
                @click="router.push(`/otc/detail?id=${item.id}`)">
                <div class="flex items-center justify-between text-14">
                    <div class="flex items-center">
                        <span :class="[item.way === 'BUY' ? 'text-up' : 'text-down']">
                            {{ item.way === 'BUY' ? $t('legal.buy') : $t('legal.sell') }}
                        </span>
                        <span class="pl-6">{{ item.currency_name }}</span>
                    </div>
                    <div>
                        <span>{{ getStatusLabel(item.status) }}</span>
                        <van-icon name="arrow" />
                    </div>
                </div>
                <div class="flex items-center justify-between text-12 mt-12">
                    <div class="flex-1">
                        <div>{{ $t('trade.time') }}</div>
                        <div>{{ item.created_at }}</div>
                    </div>
                    <div class="flex-1 text-center">
                        <div>{{ $t('trade.quantity') }}({{ item.currency_name }})</div>
                        <div>{{ item.number }}</div>
                    </div>
                    <div class="flex-1 text-right">
                        <div>{{ $t('legal.total_amount') }}({{ item.area_info.currency }})</div>
                        <div>{{ item.amount }}</div>
                    </div>
                </div>
                <van-divider class="mt-10" />
            </div>
        </van-list>
    </van-pull-refresh>


    <order-type-filter v-model="showFilterPopup" v-model:way="way" v-model:status="status" @on-change="onRefresh" />
</template>

<script lang="ts" setup>
import { OtcRecord } from '@/interface/otc';
import OrderTypeFilter from './components/OrderTypeFilter.vue';
import { getOtcOrderRecord } from '@/api/otc';
import { useOrderStatus } from './hooks';

const route = useRoute()
const router = useRouter()

const id = Number(route.query.id)

const way = ref<'BUY' | 'SELL'>()
const status = ref()

const { getStatusLabel } = useOrderStatus()

const [showFilterPopup, setShowFilterPopup] = useToggle(false)

const orderList = ref<OtcRecord[]>([])

const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const onLoad = () => {
    page.value++

    setLoading(true)

    getOtcOrderRecord({ page: page.value, currency_id: id, status: status.value, way: way.value }).then(({ data }) => {
        const list = data.data
        orderList.value = page.value === 1 ? list : orderList.value.concat(list);
        setFinish(data.last_page === page.value)
    }).finally(() => {
        setLoading(false)
    })
}

const onRefresh = () => {
    console.log(status.value, way.value);

    orderList.value = []
    page.value = 0
    onLoad()
}
</script>