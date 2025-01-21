<template>
    <el-form v-if="currentLeverMatch" label-width="auto">
        <el-form-item :label="$t('trade.multiple')">
            <el-select v-model="multiple" class="w-full">
                <el-option v-for="item in multiples" :key="item.value" :label="item.text" :value="item.value" />
            </el-select>
        </el-form-item>
        <el-form-item :label="$t('trade.hands')">
            <el-input v-model="share" :placeholder="$t('trade.input_lever_number')" class="h-32">
                <template #suffix>
                    <span>
                        <span>({{ currentLeverMatch.lever_share_num }}{{ currentLeverMatch.base_currency_code }})</span>
                    </span>
                </template>
            </el-input>
        </el-form-item>
        <el-form-item v-if="tradeMode === 1" :label="$t('trade.price')">
            <el-input v-model="price" :placeholder="$t('trade.input_price')" class="h-32" />
        </el-form-item>
        <el-form-item :label="$t('trade.trade_password')">
            <el-input type="password" v-model="password" autocomplete="false"
                :placeholder="$t('trade.input_trade_password')" class="h-32" />
        </el-form-item>
        <el-form-item>
            <el-slider v-model="percent" @change="onSliderChange" />
        </el-form-item>
        <el-form-item>
            <el-button v-if="isLogin" class="w-full h-32" :color="isBuy ? '#2fdab0' : '#f84f4f'" @click="onSubmit">
                {{ isBuy ? $t('trade.buy_in') : $t('trade.sell_out') }}
            </el-button>
            <ToLogin v-else />
        </el-form-item>
    </el-form>
</template>

<script lang="ts" setup>
import { submitLeverOrder } from '@/api';
import { Picker } from '@/interface';
import { useMarketStore, useUserStore } from '@/store';
import Big from 'big.js';

const props = defineProps<{
    multiples: Picker[],
    tradeMode: number,
    isBuy?: boolean
    balance: number
}>()

const emits = defineEmits(['onSubmit'])

const { isLogin } = storeToRefs(useUserStore())
const { currentLeverMatch } = storeToRefs(useMarketStore())

const multiple = ref(props.multiples[0]?.value)
// 下单价格
const price = ref<number>()
// 交易手数
const share = ref<number>()
const password = ref('')

const { tradeMode, isBuy, balance } = toRefs(props)

const totalPrice = computed(() => {
    if (!currentLeverMatch.value) return 0

    if (tradeMode.value === 1 && !price.value) return 0

    // 当前下单的价格
    const currentPrice = tradeMode.value === 1 ? price.value! : currentLeverMatch.value.currency_quotation.close
    // 每手数量
    const shareNum = currentLeverMatch.value.lever_share_num
    // 点差价
    const leverPointRate = currentLeverMatch.value.lever_point_rate

    const spreadPrices = new Big(currentPrice).times(leverPointRate).div(100).toNumber()

    const temp = isBuy.value ? new Big(currentPrice).plus(spreadPrices) : new Big(currentPrice).minus(spreadPrices)

    return temp.times(shareNum).toNumber()
})

// 手续费
const handleFee = computed(() => {
    if (!currentLeverMatch.value) return 0

    const handleFeeRate = currentLeverMatch.value.lever_fee_rate

    return new Big(totalPrice.value).times(+handleFeeRate).toNumber()
})

// 保证金
const bondFee = computed(() => {
    if (!multiple.value) {
        return 0
    }

    return new Big(totalPrice.value).div(multiple.value).toNumber()
})

const percent = ref(0)

const onSliderChange = () => {
    if (!balance.value) return

    const allFee = new Big(bondFee.value).plus(handleFee.value).toNumber()

    const maxMult = new Big(balance.value).div(allFee)

    share.value = parseInt(maxMult.times(percent.value).div(100).toNumber().toString())
}

const onSubmit = () => {
    submitLeverOrder({
        currency_match_id: currentLeverMatch.value!.id,
        multiple: multiple.value!,
        password: password.value,
        share: share.value!,
        status: tradeMode.value === 1 ? 0 : 1,
        target_price: tradeMode.value === 1 ? price.value : undefined,
        type: isBuy.value ? 1 : 2
    }, { showSuccessMessage: true }).then(() => {
        emits('onSubmit')
        password.value = ''
        share.value = price.value = undefined
    })
}
</script>