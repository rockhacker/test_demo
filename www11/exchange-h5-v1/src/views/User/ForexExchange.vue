<template>
    <nav-bar :title="$t('func.exchange')" />

    <div class="flex items-center justify-center text-center mt-20 px-30" :class="{ 'flex-row-reverse': type === 2 }">
        <div class="flex-1 h-40 leading-40 bg-#383838">
            {{ exchangeData?.recharge_name }}
        </div>
        <van-icon name="exchange" size="3rem" color="#9FEF4E" class="mx-20" @click="changeType" />
        <div class="flex-1 h-40 leading-40 bg-#383838">
            {{ exchangeData?.settle_name }}
        </div>
    </div>

    <div class="p-20">
        <div>
            {{ $t('user.exchange_number') }}
        </div>
        <div class="flex items-center justify-between mt-6">
            <input class="flex-1 py-8" v-model="number" type="number" :placeholder="$t('user.input_exchange_num')" />
            <div class="px-10 py-4">{{ fromCurrency }}</div>
            <div class="border-0 border-l-1 border-solid border-#888 pl-10" @click="setAll">
                {{ $t('public.all') }}
            </div>
        </div>
        <van-divider />
        <div class="flex items-center justify-between text-12 mt-20">
            <div class="flex-1">
                <div>{{ $t('user.current_rate') }}</div>
                <div class="mt-4">{{ rate || '--' }}</div>
            </div>
            <div class="flex-1 text-center">
                <div> {{ $t('public.available') }}
                </div>
                <div class="mt-4 text-nowrap"> {{ balance || '--' }}{{ fromCurrency }} </div>
            </div>
            <div class="flex-1 text-right">
                <div>{{ $t('user.calc_get') }}</div>
                <div class="mt-4">{{ receiveNum }} {{ toCurrency }}</div>
            </div>
        </div>

        <van-button class="mt-30 rounded-16 h-42 text-14" color="#2fdab0" block @click="onSubmit">
            {{ $t('func.exchange') }}
        </van-button>
    </div>
</template>

<script lang="ts" setup>
import { getForexExchange, submitForexExchange } from '@/api/forex';
import { ForexExchange } from '@/interface/forex';
import Big from 'big.js';
import { divide, floor } from 'lodash-es';
import { showSuccessToast } from 'vant';

const exchangeData = ref<ForexExchange>()

const type = ref(1)

const rate = computed(() => {
    if (!exchangeData.value) return
    if (type.value === 1) return exchangeData.value.recharge_bili
    return floor(divide(1, exchangeData.value.recharge_bili), 2)
})

const balance = computed(() => {
    if (!exchangeData.value) return 0
    return type.value === 1 ? exchangeData.value.recharge_account_balance : exchangeData.value.settle_account_balance
})

const fromCurrency = computed(() => {
    if (!exchangeData.value) return '--'
    return type.value === 1 ? exchangeData.value.recharge_account.Code : exchangeData.value.settle_account.CurrencyName
})

const toCurrency = computed(() => {
    if (!exchangeData.value) return '--'
    return type.value === 2 ? exchangeData.value.recharge_account.Code : exchangeData.value.settle_account.CurrencyName
})

const receiveNum = computed(() => {
    if (!exchangeData.value || !number.value) return 0
    return floor(Big(number.value).times(rate.value!).toNumber(), 2)
})

const onLoad = () => {
    getForexExchange({}).then(({ data }) => {
        exchangeData.value = data
    })
}

const changeType = () => {
    type.value = type.value === 1 ? 2 : 1
}

const number = ref<number>()

const setAll = () => {
    number.value = balance.value
}

const onSubmit = () => {
    submitForexExchange({
        type: type.value,
        number: number.value!,
        settle_id: exchangeData.value!.settle_account.Id,
        currency_id: exchangeData.value!.recharge_account.Id
    }).then(({ msg }) => {
        showSuccessToast(msg!)
        number.value = undefined
        onLoad()
    })
}

onLoad()
</script>