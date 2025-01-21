<template>
    <div class="coin-submit-order">
        <el-tabs v-model="tradeMode">
            <el-tab-pane :label="$t('trade.market_trade')" :name="2" />
            <el-tab-pane :label="$t('trade.limit_trade')" :name="1" />
        </el-tabs>

        <div class="px-20">
            <div class="flex">
                <el-button class="flex-1" :color="isBuy ? '#2fdab0' : '#1D1E1E'" @click="setTradeType(TradeType.BUY)">
                    {{ $t('trade.buy_in') }}
                </el-button>
                <el-button class="flex-1" :color="!isBuy ? '#f84f4f' : '#1D1E1E'" @click="setTradeType(TradeType.SELL)">
                    {{ $t('trade.sell_out') }}
                </el-button>
            </div>

            <div class="flex mt-20 text-#888888">
                <span>{{ $t('public.available') }}: </span>
                <span class="px-8">{{ balance }}</span>
                <span>{{ balanceLabel }}</span>
            </div>

            <div class="mt-20">
                {{ isBuy ? $t('trade.buy_price') : $t('legal.sell_price') }}
            </div>
            <el-input v-if="tradeMode === 1" class="mt-10" v-model="price" :placeholder="$t('trade.input_price')" />
            <el-input v-else class="mt-10" :disabled="true" :placeholder="$t('trade.best_price_deal')" />

            <div class="mt-20">
                {{ isBuy ? $t('trade.buy_num') : $t('legal.sell_amount') }}
            </div>
            <el-input class="mt-10" v-model="number" :placeholder="$t('trade.input_num')" />

            <el-slider class="mt-14" v-model="percent" :step="25" show-stops @change="onSliderChange" />

            <div class="text-14 mt-10 flex items-center justify-between">
                <span class="text-#888888">{{ $t('trade.handle_fee') }}:</span>
                <span class="text-down">{{ handleFee }}%</span>
            </div>

            <div class="text-14 mt-10 flex items-center justify-between">
                <span class="text-#888888">{{ $t('trade.trade_amount') }}:</span>
                <span>{{ tradeNum }}{{ currentTradeMatch?.quote_currency_code }}</span>
            </div>

            <el-button v-if="isLogin" class="w-full mt-20 h-40" :color="isBuy ? '#2fdab0' : '#f84f4f'" @click="onSubmit">
                {{ isBuy ? $t('trade.buy_in') : $t('trade.sell_out') }}
            </el-button>
            <ToLogin v-else />
        </div>
    </div>
</template>
<script lang="ts" setup>
import type { TabsPaneContext } from 'element-plus'
import { Match } from '@/interface';
import { useMarketStore, useUserStore } from '@/store';
import { accountDetail, buyCoin, sellCoin } from '@/api';
import { TradeType } from '@/common';
import Big from 'big.js';
import { notification } from 'ant-design-vue';
import { useI18n } from 'vue-i18n';

const props = defineProps<{
    match: Match
}>()

const emits = defineEmits(["refresh"]);

const { t } = useI18n()

const tradeMode = ref(2)

const { currentTradeMatch } = storeToRefs(useMarketStore())
const { isLogin } = storeToRefs(useUserStore())

const tradeType = ref(TradeType.BUY)

const balance = ref<number>(0)
const balanceLabel = computed(() => {
    return isBuy.value ? currentTradeMatch.value?.quote_currency_code : currentTradeMatch.value?.base_currency_code
})

const setTradeType = (val: TradeType) => {
    if (tradeType.value === val) return
    tradeType.value = val
    getBalance() // 交易方向改变 -> 重新获取价格
}

const isBuy = computed(() => {
    return tradeType.value === TradeType.BUY
})

const price = ref<number>()
const number = ref<number>()

const percent = ref(0)

const onSliderChange = () => {
    if (tradeMode.value === 1 && !price.value) {
        notification.warn({ message: t('trade.input_price') })
        percent.value = 0
        return
    }

    const percentNum = new Big(percent.value).div(100).toNumber()
    const priceNum = tradeMode.value === 1 ? price.value! : currentTradeMatch.value!.currency_quotation.close

    if (isBuy.value) {
        // 数量等于可用余额除以价格*百分比
        number.value = new Big(balance.value).div(priceNum).mul(percentNum).toNumber()
    } else {
        // 数量等于可用余额*百分比
        number.value = new Big(balance.value).mul(percentNum).toNumber()
    }
}

const handleFee = computed(() => {
    if (!currentTradeMatch.value) return 0
    return parseFloat(currentTradeMatch.value.change_fee_rate)
})

const tradeNum = computed(() => {
    if ((tradeMode.value === 1 && !price.value) || !number.value) {
        return 0
    }
    const currentPrice = tradeMode.value === 1 ? price.value : currentTradeMatch.value?.currency_quotation.close
    //交易额 单价*数量
    return new Big(currentPrice!).mul(number.value)
})



const getBalance = () => {
    if (!isLogin.value) return
    const currency_id = isBuy.value ? currentTradeMatch.value!.quote_currency_id : currentTradeMatch.value!.base_currency_id
    accountDetail({ account_type_id: 1, currency_id }).then(({ data }) => {
        balance.value = data.balance
    })
}

// 提交订单
const onSubmit = () => {
    const params = {
        currency_match_id: currentTradeMatch.value?.id,
        number: number.value,
        price: tradeMode.value === 1 ? price.value : currentTradeMatch.value?.currency_quotation.close
    }

    const config = { showSuccessMessage: true, loading: true }

    const promise = isBuy.value ? buyCoin(params, config) : sellCoin(params, config)

    promise.then(() => {
        emits("refresh")
        price.value = number.value = undefined
    })
}

onMounted(() => {
    getBalance()
})

defineExpose({
    getBalance
})
</script>


<style lang="scss">
.coin-submit-order {
    .el-tabs {
        --el-tabs-header-height: 52px !important;
    }

    .el-tabs__header {
        padding: 0 24px;
        background-color: #1d1e1e;
    }
}
</style>