<template>
    <div class="micro-page" v-if="currentMicroMatch">
        <symbol-header :match="currentMicroMatch" type="micro" @onChange="changeMatch">
            <template #right>
                <svg-icon class="w-24 h-24" color="#888" name="order-record" @click="router.push('/micro/history')" />
            </template>
        </symbol-header>

        <match-base-data :match="currentMicroMatch" />

        <KlineChart ref="KLineChartRef" height="280px" width="100%" :id="currentMicroMatch.id"
            :symbol="currentMicroMatch.symbol" />

        <micro-balance :balanceLabel="balanceLabel" />

        <div v-if="isLogin" class="flex justify-between items-center mt-10">
            <van-button class="w-[48%] rounded-8" color="#2fdab0" @click="showConfirmPopup(TradeType.up)">
                {{ $t('trade.buy_up') }}
            </van-button>
            <van-button class="w-[48%] rounded-8" color="#f84f4f" @click="showConfirmPopup(TradeType.down)">
                {{ $t('trade.buy_down') }}
            </van-button>
        </div>

        <to-login class="h-48 mt-12" v-else />

        <micro-order-record v-if="isLogin" ref="MicroOrderRecordRef" class="mt-12" />

        <!-- <count-down v-if="showCountDown" :total="total" :remain="remain" v-model="showCountDown" /> -->

        <!-- 确认下单 -->
        <van-popup v-model:show="confirmPopup" round closeable position="bottom">
            <div class="p-12 mt-16">
                <div class="flex items-center justify-between mt-12">
                    <div>{{ currentMicroMatch.symbol }}</div>
                    <div :class="[type === 1 ? 'text-up' : 'text-down']">
                        {{ type === 1 ? $t('trade.buy_up') : $t('trade.buy_down') }}
                    </div>
                </div>
                <div class="flex items-center justify-between mt-12">
                    <div>{{ $t('trade.buy_price') }} </div>
                    <div>{{ currentMicroMatch.currency_quotation.close }}</div>
                </div>
                <!-- 交易时间 -->
                <micro-trade-second v-model="selectTradeSecond" :tradeSecond="tradeSecond" />

                <!-- 交易模式 -->
                <micro-trade-mode v-model="useCurrency" :payableCurrency="payableCurrency" />

                <van-field class="mt-10" v-model="number" :label="$t('trade.open_num')"
                    :placeholder="$t('trade.input_open_num')" label-align="top">
                    <template v-if="numberOptions.length" #button>
                        <van-icon class="rotate-90 p-4" name="play" size="1.3rem" @click="setShowPicker(true)" />
                    </template>
                </van-field>

                <micro-balance :balanceLabel="balanceLabel" />

                <van-button class="w-full rounded-8 mt-12" :color="type === 1 ? '#2fdab0' : '#f84f4f'"
                    @click="onSubmit">
                    {{ $t('public.confirm') }}
                </van-button>
            </div>
        </van-popup>

        <!--开仓数量选择 -->
        <van-popup v-model:show="showPicker" round position="bottom">
            <van-picker :columns="numberOptions" @cancel="setShowPicker(false)" @confirm="onConfirm" />
        </van-popup>
    </div>
</template>

<script setup lang="ts">
import { submitMicroOrder } from '@/api/market';
import { useMarketStore, useUserStore } from '@/store';
import { showSuccessToast } from 'vant';
import useMicro from './hooks/useMicro'
import MicroTradeMode from './components/MicroTradeMode.vue';
import MicroTradeSecond from './components/MicroTradeSecond.vue';
import MicroOrderRecord from './components/MicroOrderRecord.vue';
import MicroBalance from './components/MicroBalance.vue';

const router = useRouter()

const { currentMicroMatch } = storeToRefs(useMarketStore())
const { isLogin } = storeToRefs(useUserStore())
const { tradeSecond, selectTradeSecond, payableCurrency, useCurrency, balanceLabel, numberOptions, getTradeMode } = useMicro()

enum TradeType {
    'up' = 1,
    'down' = 2
}

// const [showCountDown, setShowCountDown] = useToggle(false)
const total = ref() // 倒计时总秒数量
const remain = ref() // 剩余时间

// 开仓数量
const number = ref<number>()

const [showPicker, setShowPicker] = useToggle(false)
// @ts-ignore
const onConfirm = ({ selectedValues }) => {
    number.value = selectedValues[0]
    setShowPicker(false)
}

// 确认下单弹窗
const [confirmPopup, setConfirmPopup] = useToggle(false)

const KLineChartRef = ref()
const MicroOrderRecordRef = ref()

const type = ref<number>()

const showConfirmPopup = (val: number) => {
    type.value = val
    setConfirmPopup(true)
}

// 下单接口 type=1 买涨 type=2 买跌 
const onSubmit = () => {
    setConfirmPopup(false)
    submitMicroOrder({
        type: type.value!,
        currency_id: useCurrency.value!.id,  // 币种列表的id -> 交易模式
        match_id: currentMicroMatch.value!.id, // 交易对id
        number: number.value!,
        seconds: selectTradeSecond.value!.seconds
    }).then(({ msg }) => {
        number.value = undefined

        total.value = remain.value = selectTradeSecond.value!.seconds

        // setShowCountDown(true)

        // 延长时间获取
        setTimeout(() => {
            MicroOrderRecordRef.value.init()
        }, 500)
        showSuccessToast(msg!)
    })
}


const changeMatch = () => {
    MicroOrderRecordRef.value.init()
    KLineChartRef.value.changeSymbol(currentMicroMatch.value!.id, currentMicroMatch.value!.symbol)
}

const init = () => {
    KLineChartRef.value.init()
    if (isLogin.value) {
        getTradeMode()
    }
}

onMounted(() => {
    init()
})

defineExpose({
    init
})
</script>

<style lang="scss">
.micro-page {
    .van-field__label {
        color: white;
    }

    .selected-badge {
        background-image: url(../../assets/images/selected.png);
        background-repeat: no-repeat;
        background-size: contain;
        background-position: top right;
        background-size: 20px 20px;
    }
}
</style>