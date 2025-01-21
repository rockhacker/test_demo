<template>
    <nav-bar :title="$t('func.transfer')" />

    <div class="p-12 text-14">
        <div class="text-12 flex items-center  border-1 border-solid border-#707070 rounded-6">
            <div class="flex flex-col items-center px-16">
                <div class="w-6 h-6 rounded-50% bg-#37C8C8"></div>
                <div class="w-1 h-20 my-10 bg-#888" />
                <div class="w-6 h-6 rounded-50% bg-#F94A5D"></div>
            </div>
            <div class="flex-1">
                <div class="h-50 flex items-center">
                    <div class="text-gray-400 mr-10">{{ $t('transfer.from') }}</div>
                    <div class="flex-1 py-8" @click="setAccountPicker('from')">
                        {{ from?.name }}
                    </div>
                </div>
                <van-divider />
                <div class="h-50 flex items-center">
                    <div class="text-gray-400 mr-10">{{ $t('transfer.to') }}</div>
                    <div class="flex-1 py-8" @click="setAccountPicker('to')">
                        {{ to?.name }}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20">
            <div>
                {{ $t('transfer.transfer_num') }}
            </div>
            <div class="flex items-center justify-between mt-6">
                <input class="flex-1 py-8" v-model="number" type="number"
                    :placeholder="$t('transfer.input_transfer_num')" />
                <div class="px-10 py-4" @click="setCurrencyPick">{{ currentCurrency?.text }}</div>
                <div class="border-0 border-l-1 border-solid border-#888 pl-10" @click="number = +balance!">
                    {{ $t('public.all') }}
                </div>
            </div>
            <van-divider />

            <div class="text-12 text-#888 mt-8">
                {{ $t('public.available') }}: {{ balance }}{{ currentCurrency?.text }}
            </div>

            <van-button class="mt-20 rounded-16 h-46 text-14" color="#2fdab0" block @click="onSubmit">
                {{ $t('func.transfer') }}
            </van-button>

            <transfer-history v-if="from && currency_id" ref="transferHistoryRef" class="mt-20" :currency_id="currency_id" :account="from" />
        </div>
    </div>

    <van-popup v-model:show="showAccountPicker" round position="bottom">
        <van-picker v-model="id" :columns="options" @cancel="setShowAccountPicker(false)"
            @confirm="onAccountPickerConfirm" />
    </van-popup>

    <van-popup v-model:show="showCurrencyPicker" round position="bottom">
        <van-picker v-model="tempCurrencyId" :columns="currencyList" @cancel="setShowCurrencyPicker(false)"
            @confirm="onCurrencyPickerConfirm" />
    </van-popup>
</template>

<script lang="ts" setup>
import { useUserStore } from '@/store';
import TransferHistory from './components/TransferHistory.vue';
import { Account } from '@/interface/user';
import { PickerConfirmEventParams, showSuccessToast } from 'vant';
import { transferCoin } from '@/api/user';

const { accountList } = storeToRefs(useUserStore())
const { getAccountData } = useUserStore()

const from = ref<Account>()
const to = ref<Account>()
const number = ref<number>()
const [showAccountPicker, setShowAccountPicker] = useToggle(false)
const [showCurrencyPicker, setShowCurrencyPicker] = useToggle(false)

const transferHistoryRef = ref()

const id = ref<Array<number>>([])
let direction: string

const options = computed(() => {
    return accountList.value.map((item) => {
        return { text: item.name, value: item.id }
    })
})

const currency_id = ref<number>()

const tempCurrencyId = ref<number[]>([])

const balance = computed(() => {
    return from.value?.accounts.find((item) => item.currency_id === currency_id.value)?.balance
})

const currencyList = computed(() => {
    if (!from.value) return []
    return from.value.accounts.map((item) => ({ text: item.currency_code, value: item.currency_id }))
})

const currentCurrency = computed(() => {
    return currencyList.value.find((item) => item.value === currency_id.value)
})

const setAccountPicker = (value: 'from' | 'to') => {
    direction = value
    id.value[0] = value === 'from' ? from.value!.id : to.value!.id
    setShowAccountPicker(true)
}

const onAccountPickerConfirm = ({ selectedValues }: PickerConfirmEventParams) => {
    const target = accountList.value.find((item) => item.id === selectedValues[0])!
    if (direction === 'from') {
        if (from.value !== target) {
            from.value = target
            currency_id.value = from.value.accounts[0].currency_id
            if (to.value === target) to.value = accountList.value.find((item) => item.id !== selectedValues[0])
        }

    } else {
        to.value = target
        if (from.value === target) from.value = accountList.value.find((item) => item.id !== selectedValues[0])
    }
    transferHistoryRef.value.onRefresh()
    setShowAccountPicker(false)
}

const setCurrencyPick = () => {
    tempCurrencyId.value[0] = currency_id.value!
    setShowCurrencyPicker(true)
}

const onCurrencyPickerConfirm = ({ selectedValues }: PickerConfirmEventParams) => {
    currency_id.value = selectedValues[0] as number
    transferHistoryRef.value.onRefresh()
    setShowCurrencyPicker(false)
}

const onSubmit = () => {
    transferCoin({
        balance: number.value!,
        currency_id: currency_id.value!,
        from: from.value!.account_code,
        to: to.value!.account_code
    }).then(({ msg }) => {
        showSuccessToast(msg!)
        getAccountData()
        number.value = undefined
        transferHistoryRef.value.onRefresh()
    })
}

getAccountData().then(() => {
    from.value = accountList.value[0]
    currency_id.value = from.value.accounts[0].currency_id
    to.value = accountList.value[1]
})
</script>