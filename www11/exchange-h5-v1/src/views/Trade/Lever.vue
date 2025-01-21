<template>
    <div v-if="currentLeverMatch">
        <symbol-header :match="currentLeverMatch" type="lever" @onChange="changeMatch">
            <template #right>
                <div class="flex items-center">
                    <svg-icon class="w-24 h-24 p-8" color="#888" name="kline"
                        @click="router.push('/kline?type=lever')" />
                    <svg-icon class="w-24 h-24 p-8" color="#888" name="order-record"
                        @click="router.push('/lever/history')" />
                </div>
            </template>
        </symbol-header>

        <div class="flex">
            <div class="flex-1 mr-6">
                <trade-direct-bar v-model="isBuy" />

                <div class="flex items-center justify-between mt-8">
                    <van-button class="rounded-8 h-38 flex-1 mr-10 flex items-center justify-center px-0 text-nowrap"
                        color="#3F423A" @click="setTradeModePicker(true)">
                        <span class="px-10">
                            {{ tradeMode === 1 ? $t('trade.limit_price') : $t('trade.market_price') }}
                        </span>
                        <van-icon class="rotate-90 ml-6" name="play" color="#888" size="1.1rem" />
                    </van-button>
                    <van-button class="rounded-8 h-38 flex items-center justify-center" color="#3F423A"
                        @click="setShowMulPicker(true)">
                        <span>{{ multiple }}</span>
                        <van-icon class="rotate-90 ml-6" name="play" color="#888" size="1.1rem" />
                    </van-button>
                </div>

                <div class="bg-#393A38 flex rounded-8 h-38 leading-38 overflow-hidden text-14 px-10 mt-8">
                    <input v-if="tradeMode === 1" class="text-14 w-full" v-model="price" type="number"
                        :placeholder="$t('trade.input_price')">
                    <div class="text-14 text-#888" v-else>{{ $t('trade.best_price_deal') }}</div>
                </div>

                <div class="mt-8 text-12">
                    <span>{{ $t('trade.trade_unit') }}</span>
                    <span>({{ currentLeverMatch.lever_share_num }}{{ currentLeverMatch.base_currency_code }})</span>
                </div>

                <div class="bg-#393A38 flex rounded-8 h-38 leading-38 overflow-hidden text-14 px-10 mt-4">
                    <input class="text-14 w-full" v-model="share" type="number"
                        :placeholder="$t('trade.input_lever_number')">
                </div>

                <slider class="mt-16 w-92% mx-auto" v-model="percent" />

                <div class="mt-14 text-12 flex items-center justify-between">
                    <span>{{ $t('public.balance') }}</span>
                    <span>{{ balance }}{{ currentLeverMatch.quote_currency_code }}</span>
                </div>

                <van-button v-if="isLogin" class="mt-8 rounded-8 h-40 text-14" :color="isBuy ? '#2fdab0' : '#f84f4f'"
                    block @click="setShowConfirmPopup(true)">
                    {{ isBuy ? `${$t('trade.buy_in')}(${$t('trade.buy_long')})` :
                        `${$t('trade.sell_out')}(${$t('trade.buy_short')})` }}
                </van-button>

                <to-login class="h-40 mt-12" v-else />

            </div>

            <col-depth class="w-150" :match="currentLeverMatch" :sellList="sellList" :buyList="buyList" />



            <trade-mode v-model="tradeMode" v-model:show="tradeModePicker" />
            <mul-picker v-model="multiple" v-model:show="showMulPicker" :columns="multiples" />

            <van-popup v-model:show="showConfirmPopup" round closeable position="bottom">
                <div class="px-30 py-40">
                    <div>{{ currentLeverMatch.symbol }}</div>
                    <div class="flex items-center justify-between mt-8">
                        <div>
                            {{ $t('public.type') }}
                        </div>
                        <div>
                            {{ isBuy ? $t('trade.buy_long') : $t('trade.buy_short') }}
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-8">
                        <div>
                            {{ $t('trade.hands') }}
                        </div>
                        <div>
                            {{ share }}
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-8">
                        <div>
                            {{ $t('trade.multiple') }}
                        </div>
                        <div>
                            {{ multiple }}
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-8">
                        <div>
                            {{ $t('trade.handle_fee') }}
                        </div>
                        <div>
                            {{ handleFee }}
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-8">
                        <div>
                            {{ $t('trade.bond_fee') }}
                        </div>
                        <div>
                            {{ bondFee }}
                        </div>
                    </div>
                    <div
                        class="border-solid border-1 border-white flex rounded-8 h-38 leading-38 overflow-hidden text-14 px-10 mt-12">
                        <input class="text-14 w-full" v-model="password" type="password"
                            :placeholder="$t('trade.input_trade_password')">
                    </div>
                    <van-button class="mt-14 rounded-8 h-40 text-14" :color="isBuy ? '#2fdab0' : '#f84f4f'" block
                        @click="onSubmit">
                        {{ isBuy ? `${$t('trade.buy_in')}(${$t('trade.buy_long')})` :
                            `${$t('trade.sell_out')}(${$t('trade.buy_short')})` }}
                    </van-button>
                </div>
            </van-popup>

        </div>

        <div class="flex items-center justify-between text-center mt-12 bg-#393A38 p-6 rounded-18">
            <div class="flex-1 bg-black rounded-16 py-4">
                {{ $t('trade.dealing') }}
            </div>
            <div class="flex-1 py-4 text-#888" @click="router.push('/lever/current-order')">
                {{ $t('trade.orders') }}
            </div>
        </div>

        <lever-order-item v-for="item in myTransaction" :key="item.id" :order="item" @on-close="getBaseData"
            @on-change="getBaseData" />

        <van-empty v-if="!myTransaction.length" :description="$t('public.no_more')" />
    </div>
</template>

<script lang="ts" setup>
import useDepth from '@/hooks/useDepth';
import { useMarketStore, useUserStore, useWebsocketStore } from '@/store';
import TradeMode from '@/components/TradeMode.vue';
import LeverOrderItem from './components/LeverOrderItem.vue';
import useLever from './hooks/useLever';
import Big from 'big.js';
import { submitLeverOrder } from '@/api/market';
import { showSuccessToast } from 'vant';
import { LeverClosed, LeverTrade } from '@/interface/socket';

const { currentLeverMatch } = storeToRefs(useMarketStore())
const { isLogin } = storeToRefs(useUserStore())
const { sellList, buyList, startDepth, stopDepth } = useDepth()
const { addListener, removeListener } = useWebsocketStore()

const router = useRouter()

const [showMulPicker, setShowMulPicker] = useToggle(false)
const { multiple, multiples, balance, getBaseData, myTransaction } = useLever()

const password = ref('')

const isBuy = ref(true)

const tradeMode = ref(2)
const [tradeModePicker, setTradeModePicker] = useToggle(false)

const [showConfirmPopup, setShowConfirmPopup] = useToggle(false)

// 下单价格
const price = ref<number>()
// 交易手数
const share = ref<number>()

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

// 滑动进度条 重新计算交易数量
watch(percent, () => {
    if (!balance.value) return

    const allFee = new Big(bondFee.value).plus(handleFee.value).toNumber()

    const maxMult = new Big(balance.value).div(allFee)

    share.value = maxMult.times(percent.value).div(100).toNumber()
})

// 提交订单
const onSubmit = () => {
    submitLeverOrder({
        currency_match_id: currentLeverMatch.value!.id,
        multiple: multiple.value!,
        password: password.value,
        share: share.value!,
        status: tradeMode.value === 1 ? 0 : 1,
        target_price: tradeMode.value === 1 ? price.value : undefined,
        type: isBuy.value ? 1 : 2
    }).then(({ msg }) => {
        getBaseData()
        showSuccessToast(msg!)
        setShowConfirmPopup(false)
        password.value = ''
        share.value = price.value = undefined
    })
}

const changeMatch = () => {
    isLogin.value && getBaseData()
    stopDepth()
    startDepth(currentLeverMatch.value!.symbol)
}

const init = () => {
    startDepth(currentLeverMatch.value!.symbol)

    if (isLogin.value) {

        getBaseData()

        addListener('LEVER_TRADE', ({ trades_all }: LeverTrade) => {
            trades_all.forEach((item) => {
                const target = myTransaction.value.find((order) => order.id === item.id)
                if (target) {
                    target.profits = item.profits
                    target.update_price = item.update_price
                }
            })
        })

        addListener('LEVER_CLOSED', ({ id }: LeverClosed) => {
            id.forEach(value => {
                const index = myTransaction.value.findIndex((order) => order.id === value)
                if (index != -1) {
                    myTransaction.value.splice(index, 1)
                }
            });
        })
    }
}

onMounted(() => {
    init()
})

defineExpose({
    init
})
</script>