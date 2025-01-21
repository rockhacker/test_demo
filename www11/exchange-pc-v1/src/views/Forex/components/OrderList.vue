<template>
    <div>
        <div class="min-h-300" v-loading="loading">
            <type-bar v-model="orderType" :list="orderTypeList" @onChange="onRefresh" />
            <div v-if="orderType === -1" class="mt-10 flex items-center justify-between">
                <div>
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
                <el-button class="rounded-4 text-12 h-38 mt-4" color="#2fdab0" @click="setActionSheet(true)">
                    {{ $t('trade.quick_close_all') }}
                </el-button>
            </div>

            <div class="text-12 mb-10 pt-10" v-infinite-scroll="onLoad" :infinite-scroll-disabled="finished">
                <div class="flex items-center justify-between text-12">
                    <div class="flex-1">{{ $t('public.type') }}</div>
                    <div class="flex-1">
                        {{ orderType === 0 ? $t('trade.entrust_price') : $t('trade.open_price') }}
                    </div>
                    <div class="flex-1">{{ $t('trade.target_profit') }}</div>
                    <div class="flex-1">{{ $t('trade.target_loss') }}</div>
                    <div class="flex-1">{{ $t('trade.open_time') }}</div>
                    <!-- 仅全部平仓显示 -->
                    <template v-if="orderType === 3">
                        <div class="flex-1">{{ $t('trade.close_time') }}</div>
                        <div class="flex-1">{{ $t('trade.close_price') }}</div>
                    </template>
                    <div class="flex-1">{{ $t('trade.handle_fee') }}</div>
                    <div class="flex-1">{{ $t('trade.bond_fee') }}</div>
                    <!-- 当前持仓不显示 -->
                    <template v-if="orderType === 1 || orderType === 0 || orderType === 3 || orderType === 4">
                        <div class="flex-1">{{ $t('trade.multiple') }}</div>
                        <div class="flex-1">{{ $t('trade.useful_bond_num') }}</div>
                    </template>
                    <div class="flex-1">{{ $t('trade.profit') }}</div>
                    <div class="flex-1">{{ $t('trade.profit_rate') }}</div>
                    <!-- 當前持倉/全部持倉/全部掛單显示 -->
                    <div v-if="orderType === -1 || orderType === 0 || orderType === 1" class="flex-1 text-center">
                        {{ $t('public.operate') }}
                    </div>
                </div>
            </div>

            <forex-order-item v-for="item in orderList" :key="item.Id" :order="item" :orderType="orderType"
                @on-cancel="onRefresh" @on-close="onRefresh" @on-change="onRefresh" />

            <Empty v-if="orderList.length === 0" />

        </div>

        <el-dialog v-model="actionSheet" closeable round position="bottom" class="p-30">
            <div class="flex justify-center">
                <el-radio-group v-model="currentType" size="large">
                    <el-radio-button v-for="(item, index) in actions" :label="item.name" :value="index" />
                </el-radio-group>
            </div>
            <template #footer>
                <div class="dialog-footer">
                    <el-button @click="setActionSheet(false)">{{ $t('public.cancel') }}</el-button>
                    <el-button type="primary" @click="onAction(1)">
                        {{ $t('public.confirm') }}
                    </el-button>
                </div>
            </template>
        </el-dialog>
    </div>
</template>

<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import { useForexOrder } from '../hooks';
import { closeForexOAllOrder } from '@/api';
import ForexOrderItem from './ForexOrderItem.vue';

const { t } = useI18n()

const { orderType, orderTypeList, loading, onRefresh,
    hazardRate, profitsTotal, unSubscribe, subscribe, orderList,
    onLoad, finished
} = useForexOrder()

const [actionSheet, setActionSheet] = useToggle(false)
const actions = [
    { name: t('trade.close_all') },
    { name: t('trade.close_buy') },
    { name: t('trade.close_sell') },
];
const currentType = ref<number>(0)

const onAction = (index: number) => {
    closeForexOAllOrder({ type: currentType.value! }, { loading: true, showSuccessMessage: true }).then(({ msg }) => {
        setActionSheet(false)
        onRefresh()
    })
}

const init = () => {
    orderType.value = -1
    onRefresh()
}

onMounted(() => {
    subscribe()
})

onUnmounted(() => {
    unSubscribe()
})

defineExpose({
    init
})
</script>