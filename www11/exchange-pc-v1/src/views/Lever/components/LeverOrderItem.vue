<template>
    <div class="flex items-center justify-between text-12 mt-10">
        <div class="flex-1">
            <!-- 类型 -->
            <span :class="[order.type === 1 ? 'text-up' : 'text-down']">
                {{ order.type === 1 ? $t('trade.buy_in') : $t('trade.sell_out') }}
            </span>
            {{ order.currency_match?.symbol }}
            <span>x{{ order.share }}{{ $t('trade.hand') }}</span>
        </div>
        <div class="flex-1">
            <!-- 委托价 / 开仓价 -->
            {{ orderType === 0 ? order.origin_price : order.price }}
        </div>
        <div class="flex-1">
            <!-- {{ $t('trade.target_profit') }} -->
            {{ order.target_profit_price }}
        </div>
        <div class="flex-1">
            <!-- {{ $t('trade.target_loss') }} -->
            {{ order.stop_loss_price }}
        </div>
        <div class="flex-1">
            <!-- {{ $t('trade.open_time') }} -->
            {{ order.time }}
        </div>
        <!-- 仅全部平仓显示 -->
        <template v-if="orderType === 3">
            <div class="flex-1">
                <!-- {{ $t('trade.close_time') }} -->
                {{ order.complete_time }}
            </div>
            <div class="flex-1">
                <!-- {{ $t('trade.close_price') }} -->
                {{ order.update_price }}
            </div>
        </template>
        <div class="flex-1">
            <!-- {{ $t('trade.handle_fee') }} -->
            {{ order.trade_fee }}
        </div>
        <div class="flex-1">
            <!-- {{ $t('trade.overnight_fee') }} -->
            {{ order.overnight_money }}
        </div>
        <div class="flex-1">
            <!-- {{ $t('trade.bond_fee') }} -->
            {{ order.caution_money }}
        </div>
        <div class="flex-1" :class="[+order.profits >= 0 ? 'text-up' : 'text-down']">
            <!-- {{ $t('trade.profit') }} -->
            {{ order.profits }}
        </div>
        <!-- 当前持仓不显示 -->
        <template v-if="orderType === 1 || orderType === 0 || orderType === 3 || orderType === 4">
            <div class="flex-1">
                <!-- {{ $t('trade.total_num') }} -->
                {{ order.number }}
            </div>
            <div class="flex-1">
                <!-- {{ $t('trade.useful_bond_num') }} -->
                {{ order.origin_caution_money }}
            </div>
        </template>
        <!-- 當前持倉/全部持倉/全部掛單显示 -->
        <div v-if="orderType === -1 || orderType === 0 || orderType === 1" class="flex items-center">
            <!-- {{ $t('public.operate') }} -->
            <el-button v-if="order.status === 0 || order.status === 1" class="text-12 h-30 mr-16" plain
                @click="setShow(true)">
                {{ $t('trade.set_profit_loss') }}
            </el-button>
            <el-button v-if="order.status === 0" class="text-12 h-30" plain @click="onCancel">
                {{ $t('trade.cancel_order') }}
            </el-button>
            <el-button v-if="order.status === 1" class="text-12 h-30" plain @click="onClose">
                {{ $t('trade.close_order') }}
            </el-button>
        </div>
    </div>

    <el-dialog v-model="show" closeable round position="bottom" class="p-30">
        <div>
            <div class="flex items-center mt-20">
                <span>{{ $t('trade.target_profit') }}</span>
                <el-input-number class="flex-1 ml-10" input-width="70%" v-model="target_profit_price" />
            </div>
            <div class="mt-20 text-center">
                {{ $t('trade.expect_profit') }}: {{ expectProfit }}
            </div>
            <div class="flex items-center mt-20">
                <span>{{ $t('trade.target_loss') }}</span>
                <el-input-number class="flex-1 ml-10" input-width="70%" v-model="stop_loss_price" />
            </div>
            <div class="mt-20 text-center">
                {{ $t('trade.expect_loss') }}: {{ expectLoss }}
            </div>

            <el-button class="h-38 mt-12 block w-full" type="primary"  @click="onSave">{{ $t('public.save') }}</el-button>
        </div>
    </el-dialog>
</template>

<script lang="ts" setup>
import { cancelLeverOrder, leverOrderClose, leverOrderSetStop } from '@/api/market';
import { Transaction } from '@/interface/market';
import Big from 'big.js';
import { ElMessageBox } from 'element-plus';
import { useI18n } from 'vue-i18n';


const props = defineProps<{
    order: Transaction,
    orderType: number
}>()

const { order } = toRefs(props)

const [show, setShow] = useToggle(false)

const profitLossRatio = computed(() => {
    return new Big(order.value.profits).div(order.value.caution_money).times(100).toNumber().toFixed(4)
})

const target_profit_price = ref<number>(+order.value.target_profit_price || +order.value.update_price)
const stop_loss_price = ref<number>(+order.value.stop_loss_price || +order.value.update_price)

const { t } = useI18n()

const emits = defineEmits(["onClose", "onChange", "onCancel"]);

const onClose = async () => {
    await ElMessageBox.confirm(
        t('trade.confirm_close_order'),
        t('public.tip'),
        {
            confirmButtonText: t('public.confirm'),
            cancelButtonText: t('public.cancel'),
            type: 'warning',
        }
    )
    leverOrderClose({ id: order.value.id }, { showSuccessMessage: true }).then(({ msg }) => {
        emits('onClose')
    })
}

const onCancel = async () => {
    await ElMessageBox.confirm(
        t('trade.confirm_undo_order'),
        t('public.tip'),
        {
            confirmButtonText: t('public.confirm'),
            cancelButtonText: t('public.cancel'),
            type: 'warning',
        }
    )
    cancelLeverOrder({ id: order.value.id }, { showSuccessMessage: true }).then(({ msg }) => {
        emits('onCancel')
    })
}

const expectProfit = computed(() => {
    if (!target_profit_price.value) {
        return 0
    }
    const targetPrice = +target_profit_price.value
    // 买入
    if (order.value.type === 1) {
        if (targetPrice > +order.value.price) {
            return new Big(targetPrice).minus(order.value.price).times(order.value.share).toNumber()
        }
        return 0
    } else {
        if (+order.value.price > targetPrice) {
            return new Big(order.value.price).minus(targetPrice).times(order.value.share).toNumber()
        }
        return 0
    }
})

const expectLoss = computed(() => {
    if (!stop_loss_price.value) {
        return 0
    }
    const targetPrice = +stop_loss_price.value
    // 买入
    if (order.value.type === 1) {
        if (+order.value.price > targetPrice) {
            return new Big(order.value.price).minus(targetPrice).times(order.value.share).toNumber()
        }
        return 0
    } else {
        if (targetPrice > +order.value.price) {
            return new Big(targetPrice).minus(order.value.price).times(order.value.share).toNumber()
        }
        return 0
    }
})

const onSave = () => {
    leverOrderSetStop({
        id: order.value.id,
        target_profit_price: target_profit_price.value,
        stop_loss_price: stop_loss_price.value
    }, { showSuccessMessage: true }).then(({ msg }) => {
        emits('onChange')
        setShow(false)
    })
}
</script>