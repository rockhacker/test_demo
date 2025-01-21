<template>
    <nav-bar :title="$t('trade.order_history')" />

    <van-tabs v-model:active="status" line-width="40px" line-height="3px" title-active-color="#9fef4e" @change="onRefresh">
        <van-tab v-for="item in typeList" class="flex-1" :key="item.status" :title="item.title" :name="item.status">
        </van-tab>
    </van-tabs>

    <div class="px-12">
        <van-pull-refresh v-model="loading" @refresh="onRefresh">
            <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
                <lever-order-item v-for="item in orderList" :key="item.id" :order="item" @on-cancel="onRefresh"
                    @on-close="onRefresh" />
            </van-list>
        </van-pull-refresh>
    </div>
</template>

<script lang="ts" setup>
import { getLeverOrder } from '@/api/market';
import { Transaction } from '@/interface';
import { useI18n } from 'vue-i18n';
import LeverOrderItem from './components/LeverOrderItem.vue';
import { useWebsocketStore } from '@/store';
import { LeverClosed, LeverTrade } from '@/interface/socket';

const { t } = useI18n()
const { addListener } = useWebsocketStore()

const status = ref(0)

const typeList = [
    {
        title: t('trade.pending_order'),
        status: 0
    },
    {
        title: t('trade.dealing_order'),
        status: 1
    },
    {
        title: t('trade.closed_order'),
        status: 3
    },
    {
        title: t('trade.canceled_order'),
        status: 4
    },
]

const orderList = ref<Transaction[]>([])

const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

addListener('LEVER_TRADE', ({ trades_all }: LeverTrade) => {
    trades_all.forEach((item) => {
        const target = orderList.value.find((order) => order.id === item.id)
        if (target) {
            target.profits = item.profits
            target.update_price = item.update_price
        }
    })
})

addListener('LEVER_CLOSED', ({ id }: LeverClosed) => {
    id.forEach(value => {
        const index = orderList.value.findIndex((order) => order.id === value)
        if (index != -1) {
            orderList.value.splice(index, 1)
        }
    });
})

let controller: AbortController | null;
let promise: Promise<any> | null;

const onLoad = async () => {

    if (controller) {
        controller.abort();
        controller = null;
    }

    if (promise) {
        await promise.catch(() => { });
    }

    page.value++

    setLoading(true)

    controller = new AbortController();

    getLeverOrder({ page: page.value, status: status.value }, { signal: controller.signal })
        .then(({ data }) => {
            const list = data.data
            orderList.value = page.value === 1 ? list : orderList.value.concat(list);
            setFinish(data.last_page === page.value)
        })
        .catch(() => {
            setFinish(true)
        })
        .finally(() => {
            setLoading(false)
            promise = null
        })
}

const onRefresh = () => {
    setTimeout(() => {
        page.value = 0
        onLoad()
    })
}
</script>

<style lang="scss" scoped>
:deep(.van-tab) {
    flex: 1 !important;
}
</style>