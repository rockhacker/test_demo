<template>
    <div class="bg-#373737 rounded-8 p-12 mt-12">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <img class="w-40 h-40" :src="order.way === 1 ? buyIcon : sellIcon">
                <div class="ml-12">
                    <!-- <div class="text-14 text-up">BUY</div> -->
                    <div class="text-12 text-#A2A2AB">{{ order.currency_match.symbol }} </div>
                </div>
            </div>
            <div v-if="cancelBtn" class="rounded-8 px-10 py-2 border-1 border-solid border-#888 text-#888 text-14" @click="cancelOrder">
                {{ $t('public.undo') }}
            </div>
        </div>
        <div class="flex text-12 mt-4">
            <div class="flex-1">
                <div class="text-#A2A2AB scale-85">
                    {{ $t('trade.single_price') }}
                    ({{ order.currency_match.quote_currency_code }})
                </div>
                <div class="pl-8">{{ order.price }}</div>
            </div>
            <div class="flex-1 text-center">
                <div class="text-#A2A2AB scale-85">{{ $t('trade.quantity') }}({{ order.currency_match.base_currency_code }})
                </div>
                <div>{{ order.number }}</div>
            </div>
            <div class="flex-1 text-right">
                <div class="text-#A2A2AB scale-85">
                    {{ $t('trade.actually_deal') }}
                    ({{ order.currency_match.base_currency_code }})
                </div>
                <div class="pr-8">{{ order.transacted_amount }}</div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { cancelTxInOrder, cancelTxOutOrder } from '@/api/market';
import { TradeType } from '@/common';
import { TxOrder } from '@/interface';
import { getImageUrl } from '@/utils/getImage';
import { showConfirmDialog, showSuccessToast, } from 'vant';
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

const beforeClose: (action: string) => Promise<boolean> = (action: string) => {
    return new Promise((resolve) => {
        if (action === 'confirm') {
            const promise = props.order.way === 1 ? cancelTxInOrder : cancelTxOutOrder
            promise({ id: props.order.id }).then(({ msg }) => {
                showSuccessToast(msg!)
                emits("orderClose")
                resolve(true);
            }).catch(() => {
                resolve(false);
            })
        } else {
            // 拦截取消操作
            resolve(true);
        }
    });
}


const cancelOrder = () => {
    showConfirmDialog({
        message: t('trade.confirm_undo_order'),
        beforeClose,
    });
}
</script>