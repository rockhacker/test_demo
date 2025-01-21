<template>
    <div v-if="getCurrentTradeItem">
        <forex-header @on-change="tradeChange">
            <template #right>
                <div class="flex items-center">
                    <svg-icon class="w-24 h-24 p-8" color="#888" name="kline" @click="router.push('/forex/kline')" />
                    <svg-icon class="w-24 h-24 p-8" color="#888" name="exchange"
                        @click="router.push('/forex/exchange')" />
                    <svg-icon class="w-24 h-24 p-8" color="#888" name="order-record"
                        @click="router.push('/forex/history')" />
                </div>
            </template>
        </forex-header>

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
                    <span>{{ $t('trade.buy_num') }}</span>
                    <span>(1{{ $t('trade.page') }}={{ getCurrentTradeItem.ForexContNum }}{{ getCurrentTradeItem.Code
                        }})</span>
                </div>

                <div class="bg-#393A38 flex rounded-8 h-38 leading-38 overflow-hidden text-14 px-10 mt-4">
                    <input class="text-14 w-full" v-model="share" type="number"
                        :placeholder="$t('trade.input_buy_num')">
                </div>

                <slider class="mt-16 w-92% mx-auto" v-model="percent" />

                <div class="mt-14 text-12 flex items-center justify-between">
                    <span>{{ $t('public.balance') }}</span>
                    <span>{{ balance }}</span>
                </div>

                <van-button v-if="isLogin" class="mt-8 rounded-8 h-40 text-14" :color="isBuy ? '#2fdab0' : '#f84f4f'"
                    block :disabled="getCurrentTradeItem.MarketStatus !== 1" @click="setShowConfirmPopup(true)">
                    {{ getCurrentTradeItem.MarketStatus === 1 ? isBuy ? `${$t('trade.buy_in')}(${$t('trade.buy_long')})`
                        :
                        `${$t('trade.sell_out')}(${$t('trade.buy_short')})` : $t('trade.closed') }}
                </van-button>

                <to-login class="h-40 mt-12" v-else />
            </div>

            <forex-depth v-if="getCurrentTradeItem" class="w-150" :buy-list="buyDepth" :sell-list="sellDepth"
                :match="getCurrentTradeItem" />



            <trade-mode v-model="tradeMode" v-model:show="tradeModePicker" />
            <mul-picker v-model="multiple" v-model:show="showMulPicker" :columns="multiples" />

            <van-popup v-model:show="showConfirmPopup" round closeable position="bottom">
                <div class="px-30 py-40">
                    <div>{{ getCurrentTradeItem.Code }}</div>
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
                            {{ $t('trade.buy_num') }}
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

                    <van-button class="mt-14 rounded-8 h-40 text-14" :color="isBuy ? '#2fdab0' : '#f84f4f'" block
                        @click="onSubmit">
                        {{ isBuy ? `${$t('trade.buy_in')}(${$t('trade.buy_long')})` :
                            `${$t('trade.sell_out')}(${$t('trade.buy_short')})` }}
                    </van-button>
                </div>
            </van-popup>
        </div>


        <div class="mt-12">
            {{ $t('trade.dealing') }}
        </div>

        <forex-order-item v-for="item in orderList" :key="item.Id" :order="item" @on-change="onLoad" @on-cancel="onLoad"
            @on-close="onLoad" />

        <van-empty v-if="!orderList.length" :description="$t('public.no_more')" />
    </div>
</template>

<script lang="ts" setup>
import ForexHeader from './components/ForexHeader.vue';
import ForexDepth from './components/ForexDepth.vue';
import TradeMode from '@/components/TradeMode.vue';
import { useForexSocketStore, useForexStore, useUserStore } from '@/store';
import { useForex } from './hooks/useForex';
import { getForexDeal, submitForexOrder } from '@/api/forex';
import Big from 'big.js';
import { floor } from 'lodash-es';
import { showSuccessToast } from 'vant';
import { MyTransaction } from '@/interface/forex';
import ForexOrderItem from './components/ForexOrderItem.vue';
import { FOREX_CLOSED_DATA, FOREX_TRADE_DATA } from '@/interface/socket';

const router = useRouter()
const orderList = ref<MyTransaction[]>([])

const { isLogin } = storeToRefs(useUserStore())
const { getCurrentTradeItem, getTradeListPromise } = storeToRefs(useForexStore())
// const { updateTradeListData } = useForexStore()
const { addListener, removeAllListener } = useForexSocketStore()

const { subDepth, unSubDepth, buyDepth, sellDepth, multiple, multiples } = useForex()

const balance = ref(0)

// 下单价格
const price = ref<number>()
// 交易手数
const share = ref<number>()

const isBuy = ref(true)

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

// 滑动进度条 重新计算交易数量
watch(percent, () => {
    if (!balance.value) return
    const bond = getBondFee(1)
    const fee = getHandleFee(bond)
    share.value = Math.floor(balance.value / (bond + fee) * percent.value / 100)
})

const tradeMode = ref(2)
const [tradeModePicker, setTradeModePicker] = useToggle(false)
const [showConfirmPopup, setShowConfirmPopup] = useToggle(false)
const [showMulPicker, setShowMulPicker] = useToggle(false)


// TODO: 处理交易对切换相关业务逻辑
const tradeChange = () => {
    unSubDepth()
    subDepth(getCurrentTradeItem.value!.Code)
}

const onLoad = () => {
    getForexDeal({ forex_id: getCurrentTradeItem.value!.Id })
        .then(({ data }) => {
            balance.value = data.forex_user_balance
            orderList.value = data.my_transaction
        })
}

const onSubmit = () => {
    submitForexOrder({
        cont: share.value!,
        multiple: multiple.value!,
        forex_id: getCurrentTradeItem.value!.Id,
        type: isBuy.value ? 1 : 2,
        status: tradeMode.value === 1 ? 0 : 1,
        target_price: tradeMode.value === 1 ? price.value : undefined,
    }, { loading: true })
        .then(({ msg }) => {
            onLoad()
            showSuccessToast(msg!)
            setShowConfirmPopup(false)
            share.value = price.value = undefined
        })
}

onMounted(async () => {
    if (getTradeListPromise.value) await getTradeListPromise

    multiple.value = getCurrentTradeItem.value!.HasForexMultiple[0].Value

    init()
})

const init = () => {
    subDepth(getCurrentTradeItem.value!.Code)

    if (isLogin.value) {
        onLoad()

        addListener('FOREX_TRADE', (msg: FOREX_TRADE_DATA) => {
            msg.TransOrder.forEach((order) => {
                const target = orderList.value.find((item) => item.Id === order.Id);
                if (target) {
                    target.UpdatePrice = order.UpdatePrice;
                    target.FactProfits = order.FactProfits;
                }
            });
        });

        addListener('FOREX_CLOSED', (msg: FOREX_CLOSED_DATA) => {
            if (msg.id.length) {
                msg.id.forEach((id) => {
                    const index = orderList.value.findIndex((item) => item.Id === id);
                    if (index === -1) {
                        return;
                    }
                    orderList.value.splice(index, 1);
                });
            }
        })
    }
}

defineExpose({
    init
})
</script>