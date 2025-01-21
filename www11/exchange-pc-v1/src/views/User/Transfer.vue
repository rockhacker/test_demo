<template>
    <div class="mt-20">
        <div class="flex items-center justify-between">
            <el-select v-model="fromCode" size="large" @change="handleChange('from')">
                <el-option v-for="item in accountList" :key="item.id" :label="item.name" :value="item.account_code" />
            </el-select>
            <el-icon class="px-10" color="white" size="50px">
                <Right />
            </el-icon>
            <el-select v-model="toCode" size="large" @change="handleChange('to')">
                <el-option v-for="item in accountList" :key="item.id" :label="item.name" :value="item.account_code" />
            </el-select>
        </div>

        <div class="mt-20">
            <div>
                {{ $t('transfer.transfer_num') }}
            </div>
            <div class="flex items-center justify-between mt-6">
                <input class="flex-1 py-8 bg-transparent" v-model="number" type="number"
                    :placeholder="$t('transfer.input_transfer_num')" />
                <el-select class="w-200 mx-10" v-model="currency_id" @change="transferHistoryRef.onRefresh()">
                    <el-option v-for="item in currencyList" :key="item.value" :label="item.text"
                        :value="item.value" />
                </el-select>
                <div class="border-0 border-l-1 border-solid border-#888 pl-10 cursor-pointer" @click="number = +balance!">
                    {{ $t('public.all') }}
                </div>
            </div>
            <el-divider class="my-10" />

            <div class="text-12 text-#888 mt-16">
                {{ $t('public.available') }}: {{ balance }}{{ currentCurrency?.text }}
            </div>

            <el-button class="mt-20 rounded-4 h-40 w-full text-14" color="#2fdab0" @click="onSubmit">
                {{ $t('func.transfer') }}
            </el-button>

            <transfer-history v-if="from && currency_id" ref="transferHistoryRef" class="mt-20"
                :currency_id="currency_id" :account="from" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useUserStore } from '@/store';
import TransferHistory from './components/TransferHistory.vue';
import { transferCoin } from '@/api/user';

const { accountList } = storeToRefs(useUserStore())
const { getAccountData } = useUserStore()

const fromCode = ref<string>()
const toCode = ref<string>()

const from = computed(() => accountList.value.find((item) => item.account_code === fromCode.value))
const to = computed(() => accountList.value.find((item) => item.account_code === toCode.value))
const number = ref<number>()

const transferHistoryRef = ref()

const currency_id = ref<number>()

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

const handleChange = (direction: 'from' | 'to') => {
    if (fromCode.value === toCode.value) {
        if (direction === 'from') toCode.value = accountList.value.find((item) => item.account_code !== fromCode.value)?.account_code
        else fromCode.value = accountList.value.find((item) => item.account_code !== toCode.value)?.account_code
    }
    if (direction === 'from') {
        currency_id.value = from.value!.accounts[0].currency_id
    }
    transferHistoryRef.value.onRefresh()
}

const onSubmit = () => {
    transferCoin({
        balance: number.value!,
        currency_id: currency_id.value!,
        from: from.value!.account_code,
        to: to.value!.account_code
    }, { showSuccessMessage: true }).then(() => {
        getAccountData()
        number.value = undefined
        transferHistoryRef.value.onRefresh()
    })
}

getAccountData().then(() => {
    fromCode.value = accountList.value[0].account_code
    currency_id.value = accountList.value[0].accounts[0].currency_id
    toCode.value = accountList.value[1].account_code
})
</script>