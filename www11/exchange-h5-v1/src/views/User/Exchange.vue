<template>
    <nav-bar :title="$t('func.exchange')" />

    <div class="flex items-center justify-center text-center mt-20 px-30" :class="{ 'flex-row-reverse': type === 2 }">
        <div class="flex-1 h-40 leading-40 bg-#383838" @click="setPicker(true)">
            {{ source?.currency_code }}
        </div>
        <van-icon name="exchange" size="3rem" color="#9FEF4E" class="mx-20" @click="changeType" />
        <div class="flex-1 h-40 leading-40 bg-#383838" @click="setPicker(false)">
            {{ target?.currency_code }}
        </div>
    </div>


    <div class="p-20">
        <div>
            {{ $t('user.exchange_number') }}
        </div>
        <div class="flex items-center justify-between mt-6">
            <input class="flex-1 py-8" v-model="number" type="number" :placeholder="$t('user.input_exchange_num')" />
            <div class="px-10 py-4">{{ currencyName }}</div>
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
                <div> {{ $t('public.available') }}{{ type === 1 ? source?.currency_code : target?.currency_code }} </div>
                <div class="mt-4"> {{ balance || '--' }} </div>
            </div>
            <div class="flex-1 text-right">
                <div>{{ $t('user.calc_get') }}{{ type === 1 ? target?.currency_code : source?.currency_code }}</div>
                <div class="mt-4">{{ receiveNum }}</div>
            </div>
        </div>

        <van-button class="mt-30 rounded-16 h-42 text-14" color="#2fdab0" block @click="onSubmit">
            {{ $t('func.exchange') }}
        </van-button>

        <van-popup v-model:show="showCurrencyPicker" round position="bottom">
            <van-picker :columns="options" @cancel="setShowCurrencyPicker(false)" @confirm="onPickerConfirm" />
        </van-popup>
    </div>
</template>

<script lang="ts" setup>
import { exchangeCoin, getExchangeRate } from '@/api/market';
import { AccountElement } from '@/interface/user';
import { useUserStore } from '@/store';
import Big from 'big.js';
import { floor } from 'lodash-es';
import { PickerConfirmEventParams, showSuccessToast } from 'vant';


const { accountList } = storeToRefs(useUserStore())
const { getAccountData } = useUserStore()

const [showCurrencyPicker, setShowCurrencyPicker] = useToggle(false)

const [isSource, setIsSource] = useToggle(true)

const source = ref<AccountElement>()
const sourceList = computed(() => {
    return accountList.value[0].accounts.filter((item) => item.currency.is_quote === 1).map((item) => ({
        text: item.currency_code,
        value: item.currency_id
    }))
})

const target = ref<AccountElement>()
const targetList = computed(() => {
    return accountList.value[0].accounts.filter((item) => item.currency.is_quote !== 1).map((item) => ({
        text: item.currency_code,
        value: item.currency_id
    }))
})

const rate = ref<number>()
const getRate = () => {
    getExchangeRate({
        base_id: target.value!.currency_id,
        quote_id: source.value!.currency_id,
    }).then(({ data }) => {
        rate.value = data.last_price
    })
}

const options = computed(() => {
    return isSource.value ? sourceList.value : targetList.value
})

const setPicker = (val: boolean) => {
    setIsSource(val)
    setShowCurrencyPicker(true)
}

const onPickerConfirm = ({ selectedValues }: PickerConfirmEventParams) => {
    if (isSource.value) {
        source.value = accountList.value[0].accounts.find(item => item.currency_id === selectedValues[0])
    } else {
        target.value = accountList.value[0].accounts.find(item => item.currency_id === selectedValues[0])
    }
    getRate()
    setShowCurrencyPicker(false)
}

const number = ref<number>()
const type = ref(1)

const changeType = () => {
    number.value = undefined
    type.value = type.value === 1 ? 2 : 1
}

const currencyName = computed(() => {
    return type.value === 1 ? source.value?.currency_code : target.value?.currency_code
})

const balance = computed(() => {
    return (type.value === 1 ? source.value?.balance : target.value?.balance) || 0
})

const receiveNum = computed(() => {
    if (!rate.value || !source.value || !target.value || !number.value) return 0
    if (type.value === 1) {
        return floor(Big(number.value).div(rate.value).toNumber(), 8)
    } else {
        return floor(Big(number.value).times(rate.value).toNumber(), 8)
    }
})


const setAll = () => {
    number.value = +balance.value
}

const onSubmit = () => {
    exchangeCoin({
        amount: number.value!,
        base_id: target.value!.currency_id,
        quote_id: source.value!.currency_id,
        type: type.value
    }).then(({ msg }) => {
        showSuccessToast(msg!)
        number.value = undefined
        getAccountData()
    })
}

getAccountData().then(() => {
    !source.value && (source.value = accountList.value[0].accounts.find(item => item.currency_id === sourceList.value[0].value))
    !target.value && (target.value = accountList.value[0].accounts.find(item => item.currency_id === targetList.value[0].value))
    getRate()
})

</script>