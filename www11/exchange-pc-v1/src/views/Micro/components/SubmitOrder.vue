<template>
    <div class="bg-#1D1E1E p-14" v-if="currentMicroMatch">
        <MicroBalance :balanceLabel="balanceLabel" />

        <!-- 交易模式 -->
        <MicroTradeMode v-model="useCurrency" :payableCurrency="payableCurrency" />

        <!-- 交易时间 -->
        <micro-trade-second v-model="selectTradeSecond" :tradeSecond="tradeSecond" />

        <div class="ml-5 text-14">{{ $t('trade.open_num') }}</div>
        <el-autocomplete class="w-full mt-10" v-model="number" clearable :placeholder="$t('trade.input_open_num')"
            :fetch-suggestions="querySearch" />

        <div v-if="selectTradeSecond" class="flex items-center justify-between p-30 bg-[#3F423A] mt-20 rounded-4">
            <div>
                {{ $t('trade.profit_rate') }}
            </div>
            <div class="text-30 font-600 text-up">{{ multiply(+selectTradeSecond.profit_ratio, 100) }}%</div>
        </div>

        <div v-if="isLogin" class="flex mt-20">
            <el-button class="w-[48%] h-40" color="#2fdab0" @click="onSubmit(TradeType.up)">
                {{ $t('trade.buy_up') }}
            </el-button>
            <el-button class="w-[48%] h-40" color="#f84f4f" @click="onSubmit(TradeType.up)">
                {{ $t('trade.buy_down') }}
            </el-button>
        </div>
        <ToLogin class="mt-10" v-else />
    </div>
</template>

<script lang="ts" setup>
import { useMarketStore, useUserStore } from '@/store';
import useMicro from '../hooks';
import MicroBalance from './MicroBalance.vue'
import MicroTradeMode from './MicroTradeMode.vue'
import MicroTradeSecond from './MicroTradeSecond.vue'
import { submitMicroOrder } from '@/api';
import { multiply } from 'lodash-es'

const emits = defineEmits(['onRefresh'])

const { currentMicroMatch } = storeToRefs(useMarketStore())
const { isLogin } = storeToRefs(useUserStore())

const { tradeSecond, selectTradeSecond, payableCurrency, useCurrency, balanceLabel, numberOptions, getTradeMode } = useMicro()
// 开仓数量
const number = ref<number>()

enum TradeType {
    'up' = 1,
    'down' = 2
}

const querySearch = (queryString: string, cb: any) => {
    cb(numberOptions.value)
}

const onSubmit = (type: TradeType) => {
    submitMicroOrder({
        type: type,
        currency_id: useCurrency.value!.id,  // 币种列表的id -> 交易模式
        match_id: currentMicroMatch.value!.id, // 交易对id
        number: number.value!,
        seconds: selectTradeSecond.value!.seconds
    }, { showSuccessMessage: true, loading: true }).then(() => {
        number.value = undefined
        getTradeMode()
        emits('onRefresh')
        // total.value = remain.value = selectTradeSecond.value!.seconds

        // setShowCountDown(true)

        // // 延长时间获取
        // setTimeout(() => {
        //     MicroOrderRecordRef.value.init()
        // }, 500)
        // showSuccessToast(msg!)
    })
}


onMounted(() => {
    if (isLogin.value) {
        getTradeMode()
    }
})


defineExpose({})

</script>