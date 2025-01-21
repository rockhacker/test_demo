<template>
    <div class="flex items-center justify-between text-12 mt-10">
        <div class="flex-1">
            <!-- {{ $t('public.type') }} -->
            <span :class="[order.OrderType === 1 ? 'text-up' : 'text-down']">
                {{ order.OrderType === 1 ? $t('trade.buy_in') : $t('trade.sell_out') }}
            </span>
            {{ order.ForexTradeLists.Code }}
            <span>x{{ order.Quantity }}{{ $t('trade.page') }}</span>
        </div>
        <div class="flex-1">
            <!-- {{ orderType === 0 ? $t('trade.entrust_price') : $t('trade.open_price') }} -->
            {{ order.Status === 0 ? order.OriginPrice : order.Price }}
        </div>
        <div class="flex-1">
            <!-- {{ $t('trade.target_profit') }} -->
            {{ order.TargetProfitPrice }}
        </div>
        <div class="flex-1">
            <!-- {{ $t('trade.target_loss') }} -->
            {{ order.TargetLossPrice }}
        </div>
        <div class="flex-1">
            <!-- {{ $t('trade.open_time') }} -->
            {{ order.CreateTimeHandler }}
        </div>
        <!-- 仅全部平仓显示 -->
        <template v-if="orderType === 3">
            <div class="flex-1">
                <!-- {{ $t('trade.close_time') }} -->
                {{ order.CompleteTimeHandler }}
            </div>
            <div class="flex-1">
                <!-- {{ $t('trade.close_price') }} -->
                {{ order.UpdatePrice }}
            </div>
        </template>
        <div class="flex-1">
            <!-- {{ $t('trade.handle_fee') }} -->
            {{ order.TradeFee }}
        </div>
        <div class="flex-1">
            <!-- {{ $t('trade.bond_fee') }} -->
            {{ order.CautionMoney }}
        </div>
        <!-- 当前持仓不显示 -->
        <template v-if="orderType === 1 || orderType === 0 || orderType === 3 || orderType === 4">
            <div class="flex-1">
                <!-- {{ $t('trade.multiple') }} -->
                {{ order.Multiple }}
            </div>
            <div class="flex-1">
                <!-- {{ $t('trade.useful_bond_num') }} -->
                {{ order.OriginCautionMoney }}
            </div>
        </template>
        <div class="flex-1" :class="[+order.FactProfits >= 0 ? 'text-up' : 'text-down']">
            <!-- {{ $t('trade.profit') }} -->
            {{ order.FactProfits }}
        </div>
        <div class="flex-1">
            <!-- {{ $t('trade.profit_rate') }} -->
            {{ profitLossRatio }}%
        </div>
        <!-- 當前持倉/全部持倉/全部掛單显示 -->
        <div v-if="orderType === -1 || orderType === 0 || orderType === 1" class="flex-1 flex items-center">
            <el-button v-if="order.Status === 0 || order.Status === 1" class="text-12 h-30 mr-16" plain
                @click="setShow(true)">
                {{ $t('trade.set_profit_loss') }}
            </el-button>
            <el-button v-if="order.Status === 0" class="text-12 h-30" plain @click="onCancel">
                {{ $t('trade.cancel_order') }}
            </el-button>
            <el-button v-if="order.Status === 1" class="text-12 h-30" plain @click="onClose">
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

            <el-button class="h-38 mt-12 block w-full" type="primary" @click="onSave">{{ $t('public.save')
                }}</el-button>
        </div>
    </el-dialog>
</template>

<script lang="ts" setup>
import { cancelForexOrder, closeForexOrder, setOrderStopPrice } from '@/api/forex';
import { MyTransaction } from '@/interface/forex';
import Big from 'big.js';
import { ElMessageBox } from 'element-plus';
import { useI18n } from 'vue-i18n';


const props = defineProps<{
    order: MyTransaction,
    orderType: number
}>()

const { order } = toRefs(props)

const [show, setShow] = useToggle(false)

const profitLossRatio = computed(() => {
    return new Big(order.value.FactProfits).div(order.value.CautionMoney).times(100).toNumber().toFixed(4)
})

const target_profit_price = ref<number>(+order.value.TargetProfitPrice || +order.value.UpdatePrice)
const stop_loss_price = ref<number>(+order.value.TargetLossPrice || +order.value.UpdatePrice)

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
    closeForexOrder({ id: order.value.Id }, { showSuccessMessage: true }).then(({ msg }) => {
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
    cancelForexOrder({ id: order.value.Id }, { showSuccessMessage: true }).then(({ msg }) => {
        emits('onCancel')
    })
}

const expectProfit = computed(() => {
    if (!target_profit_price.value) {
        return 0
    }
    const targetPrice = +target_profit_price.value
    // 买入
    if (order.value.OrderType === 1) {
        if (targetPrice > +order.value.OriginPrice) {
            return new Big(targetPrice).minus(order.value.OriginPrice).times(order.value.Quantity).toNumber()
        }
        return 0
    } else {
        if (+order.value.OriginPrice > targetPrice) {
            return new Big(order.value.OriginPrice).minus(targetPrice).times(order.value.Quantity).toNumber()
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
    if (order.value.OrderType === 1) {
        if (+order.value.OriginPrice > targetPrice) {
            return new Big(order.value.OriginPrice).minus(targetPrice).times(order.value.Quantity).toNumber()
        }
        return 0
    } else {
        if (targetPrice > +order.value.OriginPrice) {
            return new Big(targetPrice).minus(order.value.OriginPrice).times(order.value.Quantity).toNumber()
        }
        return 0
    }
})

const onSave = () => {
    setOrderStopPrice({
        id: order.value.Id,
        target_profit_price: target_profit_price.value,
        stop_loss_price: stop_loss_price.value
    }, { showSuccessMessage: true, loading: true }).then(({ msg }) => {
        emits('onChange')
        setShow(false)
    })
}
</script>