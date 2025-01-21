<template>
    <nav-bar :title="$t('func.collection_method')" />

    <div class="p-12 text-14 mt-12">
        <div class="px-10 flex items-center">
            <span>{{ $t('bank.real_name') }}</span>
            <input v-model="payData.real_name" type="text" class="flex-1 text-right px-4 py-10"
                :placeholder="$t('bank.input_real_name')">
        </div>
        <van-divider />

        <div class="px-10 flex items-center">
            <span>{{ $t('bank.bank_name') }}</span>
            <input v-model="payData.bank_name" type="text" class="flex-1 text-right px-4 py-10"
                :placeholder="$t('bank.input_bank_name')">
        </div>
        <van-divider />

        <div class="px-10 flex items-center">
            <span>{{ $t('bank.bank_no') }}</span>
            <input v-model="payData.card_no" type="text" class="flex-1 text-right px-4 py-10"
                :placeholder="$t('bank.input_bank_no')">
        </div>
        <van-divider />

        <div class="px-10 flex items-center">
            <span>{{ $t('bank.bank_address') }}</span>
            <input v-model="payData.bank_address" type="text" class="flex-1 text-right px-4 py-10"
                :placeholder="$t('bank.input_bank_address')">
        </div>
        <van-divider />

        <div class="px-10 flex items-center">
            <span>{{ $t('bank.bank_code') }}</span>
            <input v-model="payData.bank_code" type="text" class="flex-1 text-right px-4 py-10"
                :placeholder="$t('bank.input_bank_code')">
        </div>
        <van-divider />

        <van-button class="mt-40 rounded-22 h-42 text-14" color="#2fdab0" block @click="onSubmit">
            {{ $t('public.confirm') }}
        </van-button>
    </div>
</template>

<script lang="ts" setup>
import { getFlatBindData, saveFlatBindData } from '@/api/user';
import { showSuccessToast } from 'vant';

const route = useRoute()

const id = +route.query.id!

const payData = reactive({
    bank_address: '',
    bank_code: '',
    bank_name: "",
    card_no: '',
    real_name: ''
})

const onSubmit = async () => {
    const { msg } = await saveFlatBindData({ type: id, raw_data: payData }, { loading: true })
    showSuccessToast(msg!)
}

getFlatBindData({ type: id }).then(({ data }) => {
    payData.bank_address = data.raw_data.bank_address
    payData.bank_code = data.raw_data.bank_code
    payData.bank_name = data.raw_data.bank_name
    payData.card_no = data.raw_data.card_no
    payData.real_name = data.raw_data.real_name
})
</script>