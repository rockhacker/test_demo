<template>
    <div class="bg-#383838 rounded-18 p-10 mt-12 text-12">
        <div class="flex justify-between items-center text-14">
            <div>
                <span :class="[order.type === 1 ? 'text-up' : 'text-down']">
                    {{ order.type === 1 ? $t('trade.buy_in') : $t('trade.sell_out') }}
                </span>
                {{ order.currency_match?.symbol }}
                <span>x{{ order.share }}{{ $t('trade.hand') }}</span>
            </div>
            <div :class="[+order.profits >= 0 ? 'text-up' : 'text-down']">
                {{ order.profits }}
            </div>
        </div>
        <div class="flex items-center justify-center mt-12">
            <div class="flex-1">
                <div class="text-#A2A2AB">{{ $t('trade.open_price') }}</div>
                <div>{{ order.price }}</div>
            </div>
            <div class="flex-1 text-center">
                <div class="text-#A2A2AB">{{ $t('trade.target_profit') }}</div>
                <div>{{ order.target_profit_price }}</div>
            </div>
            <div class="flex-1 text-right">
                <div class="text-#A2A2AB">{{ $t('trade.current_price') }}</div>
                <div>{{ order.update_price }}</div>
            </div>
        </div>
        <div class="flex items-center justify-center mt-12">
            <div class="flex-1">
                <div class="text-#A2A2AB">{{ $t('trade.target_loss') }}</div>
                <div>{{ order.stop_loss_price }}</div>
            </div>
            <div class="flex-1 text-center">
                <div class="text-#A2A2AB">{{ $t('trade.bond_fee') }}</div>
                <div>{{ order.caution_money }}</div>
            </div>
            <div class="flex-1 text-right">
                <div class="text-#A2A2AB">{{ $t('trade.handle_fee') }}</div>
                <div>{{ order.trade_fee }}</div>
            </div>
        </div>
        <div class="flex items-center justify-center mt-12">
            <div class="flex-1">
                <div class="text-#A2A2AB">{{ $t('trade.profit_loss_ratio') }}</div>
                <div>{{ profitLossRatio }}%</div>
            </div>
            <div class="flex-1 text-right">
                <div class="text-#A2A2AB">{{ $t('trade.open_time') }}</div>
                <div>{{ order.time }}</div>
            </div>
        </div>
        <div class="flex justify-end mt-12">
            <van-button v-if="order.status === 0 || order.status === 1" class="text-12 h-30 mr-16" plain color="#888"
                @click="setShow(true)">
                {{ $t('trade.set_profit_loss') }}
            </van-button>
            <van-button v-if="order.status === 0" class="text-12 h-30" plain color="#888" @click="onCancel">
                {{ $t('trade.cancel_order') }}
            </van-button>
            <van-button v-if="order.status === 1" class="text-12 h-30" plain color="#888" @click="onClose">
                {{ $t('trade.close_order') }}
            </van-button>
        </div>
    </div>

    <van-popup v-model:show="show" closeable round position="bottom" class="p-30">
        <div class="flex flex-col items-center">
            <div class="flex items-center mt-20">
                <span>{{ $t('trade.target_profit') }}</span>
                <van-stepper class="flex-1 ml-10" input-width="70%" v-model="target_profit_price" />
            </div>
            <div class="mt-20">
                {{ $t('trade.expect_profit') }}: {{ expectProfit }}
            </div>
            <div class="flex items-center mt-20">
                <span>{{ $t('trade.target_loss') }}</span>
                <van-stepper class="flex-1 ml-10" input-width="70%" v-model="stop_loss_price" />
            </div>
            <div class="mt-20">
                {{ $t('trade.expect_loss') }}: {{ expectLoss }}
            </div>

            <van-button class="h-38 mt-12" type="primary" block @click="onSave">{{ $t('public.save') }}</van-button>
        </div>
    </van-popup>
</template>

<script lang="ts" setup>
import { cancelLeverOrder, leverOrderClose, leverOrderSetStop } from '@/api/market';
import { Transaction } from '@/interface/market';
import Big from 'big.js';
import { showConfirmDialog, showSuccessToast } from 'vant';
import { useI18n } from 'vue-i18n';


const props = defineProps<{
    order: Transaction
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

const onClose = () => {
    showConfirmDialog({
        message: t('trade.confirm_close_order'),
    }).then(() => {
        leverOrderClose({ id: order.value.id }).then(({ msg }) => {
            emits('onClose')
            showSuccessToast(msg!)
        })
    });
}

const onCancel = () => {
    showConfirmDialog({
        message: t('trade.confirm_undo_order'),
    }).then(() => {
        cancelLeverOrder({ id: order.value.id }).then(({ msg }) => {
            emits('onCancel')
            showSuccessToast(msg!)
        })
    });
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
    }).then(({ msg }) => {
        emits('onChange')
        showSuccessToast(msg!)
        setShow(false)
    })
}
</script>