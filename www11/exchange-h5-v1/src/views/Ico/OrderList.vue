<template>
    <nav-bar :title="$t('ico.my_subscribe')" />

    <van-pull-refresh v-model="loading" @refresh="onRefresh">
        <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
            <div class="text-12">
                <div class="flex items-center justify-between pt-10 text-center">
                    <div class="flex-1">{{ $t('mining.subscribe_time') }}</div>
                    <div class="flex-1">{{ $t('public.coin_type') }}</div>
                    <div class="flex-1">{{ $t('mining.subscribe_num') }}</div>
                    <div class="flex-1">{{ $t('ico.ent_num') }}</div>
                    <div class="flex-1">{{ $t('ico.online_time') }}</div>
                    <div class="flex-1">{{ $t('public.status') }}</div>
                </div>

                <div v-for="item in orderList" :key="item.id">
                    <van-divider class="my-10" />
                    <div class="flex items-center justify-between text-center">
                        <div class="flex-1">{{ item.created_at }}</div>
                        <div class="flex-1">{{ item.subscription.currency_name }}</div>
                        <div class="flex-1">{{ item.number }}</div>
                        <div class="flex-1">{{ item.winning_lots_number }}</div>
                        <div class="flex-1">{{ item.subscription.market_time }}</div>
                        <div class="flex-1">
                            <span>{{ getStatus(item.status) }}</span>
                            <span v-if="item.is_return === 2">({{ $t('ico.refund_part') }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </van-list>
    </van-pull-refresh>
</template>

<script lang="ts" setup>
import { getIcoOrderList } from '@/api/finance';
import { IcoOrder } from '@/interface/finance';
import { useI18n } from 'vue-i18n';

const { t } = useI18n()

const getStatus = (status: number) => {
    // 1.待抽签 2.未中签 3.已中签 4.已发币 5.已退款
    switch (status) {
        case 1:
            return t('ico.wait_draw')
        case 2:
            return t('ico.no_draw')
        case 3:
            return t('ico.get_draw')
        case 4:
            return t('ico.sended_coin')
        case 5:
            return t('ico.is_refund')
        default:
            return ''
    }
}

const orderList = ref<IcoOrder[]>([])

const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const onLoad = () => {
    page.value++

    setLoading(true)

    getIcoOrderList({ page: page.value }).then(({ data }) => {
        const list = data.data
        orderList.value = page.value === 1 ? list : orderList.value.concat(list);
        setFinish(data.last_page === page.value)
    }).finally(() => {
        setLoading(false)
    })
}

const onRefresh = () => {
    // orderList.value = []
    page.value = 0
    onLoad()
}

</script>