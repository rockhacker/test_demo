<template>
    <van-pull-refresh v-model="refreshing" @refresh="onRefresh">
        <nav-bar />

        <div class="p-12">
            <div class="flex items-center justify-between">
                <type-bar v-model="orderType" :list="orderTypeList" @onChange="onChange" />
                <div v-if="!isHistory" class="flex items-center" @click="setShowPicker(true)">
                    <span class="mr-8">{{ label }}</span>
                    <van-icon name="arrow-down" />
                </div>
            </div>

            <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
                <tx-order-item v-for="item in txOrder" :key="item.id" :cancel-btn="false" :order="item"
                    @order-close="onRefresh" />
            </van-list>
        </div>

    </van-pull-refresh>

    <van-popup v-model:show="showPicker" round position="bottom">
        <van-picker :columns="columns" @cancel="setShowPicker(false)" @confirm="onConfirm" />
    </van-popup>
</template>

<script lang="ts" setup>
import { useI18n } from 'vue-i18n';
import useTxOrder from './hooks/useTxOrder';
import TxOrderItem from './components/TxOrderItem.vue';
import { TradeType } from '@/common';
import { useUserStore } from '@/store';

const { t } = useI18n()
const { isLogin } = storeToRefs(useUserStore())
const { refreshing, loading, finished, onRefresh, onLoad, tradeType, txOrder, subscribe, isHistory, setIsHistory } = useTxOrder()

const [showPicker, setShowPicker] = useToggle(false)

const columns = [
    { text: t('trade.buy_in'), value: TradeType.BUY },
    { text: t('trade.sell_out'), value: TradeType.SELL },
]

const label = computed(() => {
    return columns.find(item => item.value === tradeType.value)?.text
})

const orderType = ref(1)

const orderTypeList = [
    {
        label: 'trade.all_entrust',
        value: 1 // 全部委托
    },
    {
        label: 'trade.history_entrust',
        value: 2 // 历史委托
    }
]

if (isLogin.value) {
    subscribe()
}

const onChange = () => {
    setIsHistory(orderType.value === 2)
    onRefresh()
}

const onConfirm = ({ selectedOptions }: any) => {
    tradeType.value = selectedOptions[0].value
    setShowPicker(false)
    onRefresh()
}

</script>