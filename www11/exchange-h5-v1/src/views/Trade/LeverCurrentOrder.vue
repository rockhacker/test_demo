<template>
    <van-nav-bar>
        <template #left>
            <div class="flex mt-4">
                <back-icon />
                <div class="ml-10 text-12 text-left">
                    <div>
                        <span>{{ $t('trade.hazard_rate') }}:</span>
                        <span class="pl-4">{{ hazardRate }}%</span>
                    </div>
                    <div>
                        <span>{{ $t('trade.current_profit') }}:</span>
                        <span class="pl-4" :class="[profitsTotal >= 0 ? 'text-up' : 'text-down']">{{ profitsTotal
                            }}</span>
                    </div>
                </div>
            </div>
        </template>
        <template #right>
            <van-button class="rounded-12 text-12 h-38 mt-4" color="#2fdab0" block @click="setActionSheet(true)">
                {{ $t('trade.quick_close_all') }}
            </van-button>
        </template>
    </van-nav-bar>

    <div class="px-12">
        <van-pull-refresh v-model="loading" @refresh="onRefresh">
            <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')"
                @load="onLoad">
                <lever-order-item v-for="item in orderList" :key="item.id" :order="item" @on-cancel="onRefresh"
                    @on-close="onRefresh" />
            </van-list>
        </van-pull-refresh>
    </div>

    <van-action-sheet v-model:show="actionSheet" :actions="actions" :cancel-text="$t('public.cancel')"
        close-on-click-action @cancel="setActionSheet(false)" @select="onAction" />
</template>

<script lang="ts" setup>
import { closeLeverAllOrder, getLeverDealAll } from '@/api/market';
import { Transaction } from '@/interface';
import { useMarketStore, useWebsocketStore } from '@/store';
import LeverOrderItem from './components/LeverOrderItem.vue';
import { LeverClosed, LeverTrade } from '@/interface/socket';
import { useI18n } from 'vue-i18n';
import { ActionSheetAction, showSuccessToast } from 'vant';

const { t } = useI18n()

const hazardRate = ref('0')
const profitsTotal = ref(0)
const orderList = ref<Transaction[]>([])

const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const { currentLeverMatch } = storeToRefs(useMarketStore())
const { addListener } = useWebsocketStore()

const [actionSheet, setActionSheet] = useToggle(false)
const actions = [
    { name: t('trade.close_all') },
    { name: t('trade.close_buy') },
    { name: t('trade.close_sell') },
];

const onAction = (action: ActionSheetAction, index: number) => {
    closeLeverAllOrder({ currency_match_id: currentLeverMatch.value!.id, type: index }, { loading: true }).then(({ msg }) => {
        showSuccessToast(msg!)
    })
}

addListener('LEVER_TRADE', ({ trades_all, currency_match_id, hazard_rate, profits_all }: LeverTrade) => {
    trades_all.forEach((item) => {
        if (currentLeverMatch.value?.id === currency_match_id) {
            hazardRate.value = hazard_rate
            profitsTotal.value = +profits_all
        }

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

const onLoad = async () => {

    page.value++

    setLoading(true)

    getLeverDealAll({ page: page.value, currency_match_id: currentLeverMatch.value!.id })
        .then(({ data }) => {
            hazardRate.value = data.hazard_rate
            profitsTotal.value = +data.profits_total
            const list = data.order.data
            orderList.value = page.value === 1 ? list : orderList.value.concat(list);
            setFinish(data.order.last_page === page.value)
        })
        .catch(() => {
            setFinish(true)
        })
        .finally(() => {
            setLoading(false)
        })
}

const onRefresh = () => {
    page.value = 0
    onLoad()
}

</script>