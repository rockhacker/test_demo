<template>
    <div class="flex items-center justify-between">
        <!-- 时间 -->
        <div class="flex-1">{{ order.updated_at.substring(5) }}</div>
        <!-- 交易对 -->
        <div class="flex-1 text-center">{{ order.currency_match.symbol }}</div>
        <!-- 方向 -->
        <div class="flex-1 text-center" v-if="!cancelBtn" :class="[order.way === 1 ? 'text-up' : 'text-down']">
            {{ order.way === 1 ? $t('trade.buy_in') : $t('trade.sell_out') }}
        </div>
        <!-- 单价 -->
        <div class="flex-1 text-center">{{ order.price }}</div>
        <!-- 数量 -->
        <div class="flex-1 text-center">{{ order.number }}</div>
        <!-- 成交量 -->
        <div class="flex-1 text-center">{{ order.transacted_amount }}</div>
        <!-- 成交总额 历史委托展示 -->
        <div class="flex-1 text-center" v-if="!cancelBtn">{{ order.transacted_volume }}</div>
        <!-- 状态 历史委托展示 -->
        <div class="flex-1 text-right" v-if="!cancelBtn">{{ order.status_name }}</div>
        <!-- 操作 委托订单展示 -->
        <div class="flex-1 flex justify-center" v-if="cancelBtn">
            <el-button type="primary" text @click="cancelOrder">
                {{ $t('public.undo') }}
            </el-button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { cancelTxInOrder, cancelTxOutOrder } from '@/api/market';
import { TradeType } from '@/common';
import { TxOrder } from '@/interface';
import { getImageUrl } from '@/utils/getImage';
import { ElMessageBox } from 'element-plus';
import { useI18n } from 'vue-i18n';

const props = withDefaults(defineProps<{
    order: TxOrder,
    cancelBtn?: boolean
}>(), {
    cancelBtn: true
})

const { order } = toRefs(props)

const { t } = useI18n()

const emits = defineEmits(["orderClose"]);

const buyIcon = getImageUrl('buy-in.png')
const sellIcon = getImageUrl('sell-out.png')


const cancelOrder = async () => {
    await ElMessageBox.confirm(
        t('trade.confirm_undo_order'),
        'Warning',
        {
            type: 'warning',
        }
    )
    const promise = props.order.way === 1 ? cancelTxInOrder : cancelTxOutOrder
    promise({ id: props.order.id }, { showSuccessMessage: true }).then(() => {
        emits("orderClose")
    })
}
</script>