<template>
    <el-form label-width="auto">
        <el-form-item :label="$t('trade.lever_mul')">
            <el-select v-model="multiple" class="w-full">
                <el-option v-for="item in multiples" :key="item.value" :label="item.text" :value="item.value" />
            </el-select>
        </el-form-item>
        <el-form-item v-if="tradeMode === 1" :label="isBuy ? $t('trade.buy_price') : $t('legal.sell_price')">
            <el-input v-model="price" :placeholder="$t('trade.input_price')" class="h-32" />
        </el-form-item>
        <el-form-item :label="isBuy ? $t('trade.buy_num') : $t('legal.sell_amount')">
            <el-input v-model="share" :placeholder="$t('trade.input_num')" class="h-32">
                <template #suffix>
                    <span>
                        (1{{ $t('trade.page') }}={{ getCurrentTradeItem.ForexContNum }}{{ getCurrentTradeItem.Code }})
                    </span>
                </template>
            </el-input>
        </el-form-item>
        <el-form-item>
            <el-slider v-model="percent" @change="onSliderChange" />
        </el-form-item>
        <el-form-item>
            <el-button v-if="isLogin" class="w-full h-32" :disabled="getCurrentTradeItem.MarketStatus !== 1"
                :color="isBuy ? '#2fdab0' : '#f84f4f'" @click="onSubmit">
                {{ isBuy ? $t('trade.buy_in') : $t('trade.sell_out') }}
            </el-button>
            <ToLogin v-else />
        </el-form-item>
    </el-form>
</template>

<script lang="ts" setup>
import { submitForexOrder } from '@/api';
import { useForexStore, useUserStore } from '@/store';
import Big from 'big.js';
import { floor } from 'lodash-es';

const props = defineProps<{
    tradeMode: number,
    isBuy?: boolean
    balance: number
}>()

const emits = defineEmits(['onSubmit'])

const { isLogin } = storeToRefs(useUserStore())
const { getCurrentTradeItem } = storeToRefs(useForexStore())

const multiples = computed(() => {
    return getCurrentTradeItem.value?.HasForexMultiple.map((item) => {
        return {
            text: item.Value.toString(),
            value: item.Value,
        }
    }) || []
})

const multiple = ref(multiples.value[0].value)
// 下单价格
const price = ref<number>()
// 交易手数
const share = ref<number>()

const { tradeMode, isBuy, balance } = toRefs(props)

const getBondFee = (val: number) => {
    const submitPrice = tradeMode.value === 1 ? price.value : getCurrentTradeItem.value?.ForexQuotations.Close
    if (!getCurrentTradeItem.value || !multiple.value || !submitPrice) return 0
    return floor(Big(val).times(getCurrentTradeItem.value.ForexContNum).times(submitPrice).div(multiple.value).toNumber(), 6)
}

// 每张所需保证金
const bondFee = computed(() => {
    if (!share.value) return 0
    return getBondFee(share.value)
})

const getHandleFee = (val: number) => {
    if (!getCurrentTradeItem.value) return 0
    return floor(Big(val).times(getCurrentTradeItem.value.ForexFeeRate).toNumber(), 6)
}

// 每张所需手续费
const handleFee = computed(() => {
    if (!getCurrentTradeItem.value) return 0
    return getHandleFee(bondFee.value)
})

const percent = ref(0)

const onSliderChange = () => {
    if (!balance.value) return
    const submitPrice = tradeMode.value === 1 ? price.value : getCurrentTradeItem.value?.ForexQuotations.Close
    if (!submitPrice) return
    const bond = getBondFee(1)
    const fee = getHandleFee(bond)
    share.value = Math.floor(balance.value / (bond + fee) * percent.value / 100)
}

const onSubmit = () => {
    submitForexOrder({
        cont: share.value!,
        multiple: multiple.value!,
        forex_id: getCurrentTradeItem.value!.Id,
        type: isBuy.value ? 1 : 2,
        status: tradeMode.value === 1 ? 0 : 1,
        target_price: tradeMode.value === 1 ? price.value : undefined,
    }, { loading: true, showSuccessMessage: true })
        .then(() => {
            share.value = price.value = undefined
            emits('onSubmit')
        })
}
</script>