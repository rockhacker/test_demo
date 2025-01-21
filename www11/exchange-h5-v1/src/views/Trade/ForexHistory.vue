<template>
    <nav-bar :title="$t('trade.order_history')" />

    <van-tabs v-model:active="status" line-width="40px" line-height="3px" title-active-color="#9fef4e" @change="onRefresh">
        <van-tab v-for="item in typeList" class="flex-1" :key="item.status" :title="item.title" :name="item.status">
        </van-tab>
    </van-tabs>

    <div class="px-12">
        <van-pull-refresh v-model="loading" @refresh="onRefresh">
            <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
                <forex-order-item v-for="item in orderList" :key="item.Id" :order="item" @on-change="onLoad"
                    @on-cancel="onLoad" @on-close="onLoad" />
            </van-list>
        </van-pull-refresh>
    </div>
</template>

<script lang="ts" setup>
import { getForexOrder } from '@/api/forex';
import { MyTransaction } from '@/interface/forex';
import { FOREX_CLOSED_DATA, FOREX_TRADE_DATA } from '@/interface/socket';
import { useForexSocketStore } from '@/store';
import { useI18n } from 'vue-i18n';
import ForexOrderItem from './components/ForexOrderItem.vue';

const { t } = useI18n()
const { addListener, removeAllListener } = useForexSocketStore()

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

const orderList = ref<MyTransaction[]>([])

const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

addListener('FOREX_TRADE', (msg: FOREX_TRADE_DATA) => {
    msg.TransOrder.forEach((order) => {
        const target = orderList.value.find((item) => item.Id === order.Id);
        if (target) {
            target.UpdatePrice = order.UpdatePrice;
            target.FactProfits = order.FactProfits;
        }
    });
});

addListener('FOREX_CLOSED', (msg: FOREX_CLOSED_DATA) => {
    if (msg.id.length) {
        msg.id.forEach((id) => {
            const index = orderList.value.findIndex((item) => item.Id === id);
            if (index === -1) {
                return;
            }
            orderList.value.splice(index, 1);
        });
    }
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

    getForexOrder({ page: page.value, status: status.value }, { signal: controller.signal })
        .then(({ data }) => {
            const list = data.data
            orderList.value = page.value === 1 ? list : orderList.value.concat(list);
            setFinish(data.total === page.value)
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