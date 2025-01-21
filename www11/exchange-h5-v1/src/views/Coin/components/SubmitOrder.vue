<template>
    <div class="flex mt-20">
        <van-button class="rounded-22 h-48 text-14" :color="isBuy ? '#2fdab0' : '#3F423A'" block
            @click="setTradeType(TradeType.BUY)">
            {{ $t('trade.buy') }}
        </van-button>
        <van-button class="rounded-22 h-48 mx-10 text-14" :color="isBuy ? '#3F423A' : '#f84f4f'" block
            @click="setTradeType(TradeType.SELL)">
            {{ $t('trade.sell') }}
        </van-button>
        <van-button class="rounded-22 h-48 w-620 flex items-center justify-center flex-nowrap" color="#3F423A"
            @click="setTradeModePicker(true)">
            <van-icon name="warning" color="#888" size="1rem" />
            <span class="px-10">{{ tradeMode === 1 ? $t('trade.limit_price') : $t('trade.market_price') }}</span>
            <van-icon class="rotate-90" name="play" color="#888" size="0.8rem" />
        </van-button>
    </div>

    <trade-mode v-model="tradeMode" v-model:show="tradeModePicker" />

    <div class="bg-#3F423A p-12 rounded-12 mt-12 text-12">
        <div class="pb-12 mb-12 border-0 border-b-1 border-solid border-#888">
            <div class="text-#888 mb-10"> {{ $t('trade.price') }}</div>
            <input v-if="tradeMode === 1" class="text-16" v-model="price" type="text"
                :placeholder="$t('trade.input_price')">
            <div class="text-16 text-#888" v-else>{{ $t('trade.best_price_deal') }}</div>
        </div>
        <div>
            <div class="flex items-center justify-between mb-10">
                <div class="text-#888">{{ $t('trade.quantity') }}</div>
                <div class="text-down text-14">{{ $t('trade.handle_fee') }}:{{ handleFee }}%</div>
            </div>
            <input class="text-16" v-model="number" type="text" :placeholder="$t('trade.input_num')">
        </div>
    </div>

    <slider class="mt-16 w-94% mx-auto" v-model="percent" />

    <div class="mt-18 text-12 px-6">
        <div class="flex items-center justify-between">
            <div class="text-#888">{{ $t('public.available') }}</div>
            <div>{{ balance }}{{ balanceLabel }}</div>
        </div>
        <div class="flex items-center justify-between mt-8">
            <div class="text-#888">
                {{ $t('trade.trade_amount') }}
            </div>
            <div>{{ tradeNum }}{{ currentTradeMatch?.quote_currency_code }}</div>
        </div>
    </div>

    <van-button v-if="isLogin" class="mt-12 rounded-12 h-48 text-16" :color="isBuy ? '#2fdab0' : '#f84f4f'" block
        @click="onSubmit">
        {{ isBuy ? $t('trade.buy_in') : $t('trade.sell_out') }}
    </van-button>

    <to-login class="h-48 mt-12" v-else />
</template>

<script lang="ts" setup>
import { useMarketStore, useUserStore } from '@/store';
import { accountDetail } from '@/api/user'
import Big from 'big.js';
import { showFailToast, showSuccessToast } from 'vant';
import { useI18n } from 'vue-i18n';
import { buyCoin } from '@/api/market';
import { sellCoin } from '@/api/market';
import { TradeType } from '@/common';
import TradeMode from '@/components/TradeMode.vue';

const props = defineProps<{
    tradeType: TradeType
}>()

const { currentTradeMatch } = storeToRefs(useMarketStore())
const { isLogin } = storeToRefs(useUserStore())

const emits = defineEmits(["update:tradeType", "refresh"]);

const tradeType = ref(props.tradeType)

const { t } = useI18n()

const tradeMode = ref(2)
const [tradeModePicker, setTradeModePicker] = useToggle(false)

const isBuy = computed(() => {
    return tradeType.value === TradeType.BUY
})

const balance = ref<number>(0)
const balanceLabel = computed(() => {
    return isBuy.value ? currentTradeMatch.value?.quote_currency_code : currentTradeMatch.value?.base_currency_code
})

const price = ref<number>()
const number = ref<number>()

const percent = ref(0)

// 滑动进度条 重新计算交易数量
watch(percent, () => {
    if (tradeMode.value === 1 && !price.value) {
        showFailToast(t('trade.input_price'))
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
})

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

const setTradeType = (val: TradeType) => {
    if (tradeType.value === val) return
    tradeType.value = val
    emits("update:tradeType", tradeType.value)
    emits("refresh")
    getBalance() // 交易方向改变 -> 重新获取价格
}

// 提交订单
const onSubmit = () => {
    const params = {
        currency_match_id: currentTradeMatch.value?.id,
        number: number.value,
        price: tradeMode.value === 1 ? price.value : currentTradeMatch.value?.currency_quotation.close
    }

    const promise = isBuy.value ? buyCoin(params) : sellCoin(params)

    promise.then(({ msg }) => {
        showSuccessToast(msg)
        emits("refresh")
    })
}

defineExpose({
    getBalance
})

onActivated(() => {
    getBalance()
})
</script>