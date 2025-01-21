<template>
    <div class="max-w-[1200px] mx-auto mt-20">
        <el-form label-width="auto">
            <el-form-item :label="$t('func.collection_method')">
                <el-select v-model="payMethodId" class="w-full" @change="getBindData">
                    <el-option v-for="item in payMethodList" :key="item.id" :label="item.name" :value="item.id" />
                </el-select>
            </el-form-item>
            <template v-if="payMethodId">
                <el-form-item :label="$t('bank.real_name')">
                    <el-input v-model="payData.real_name" :placeholder="$t('bank.input_real_name')" class="h-32" />
                </el-form-item>
                <el-form-item :label="$t('bank.bank_name')">
                    <el-input v-model="payData.bank_name" :placeholder="$t('bank.input_bank_name')" class="h-32" />
                </el-form-item>
                <el-form-item :label="$t('bank.bank_no')">
                    <el-input v-model="payData.card_no" :placeholder="$t('bank.input_bank_no')" class="h-32" />
                </el-form-item>
                <el-form-item :label="$t('bank.bank_address')">
                    <el-input v-model="payData.bank_address" :placeholder="$t('bank.input_bank_address')"
                        class="h-32" />
                </el-form-item>
                <el-form-item :label="$t('bank.bank_code')">
                    <el-input v-model="payData.bank_code" :placeholder="$t('bank.input_bank_code')" class="h-32" />
                </el-form-item>
                <el-form-item label=" ">
                    <el-button class="w-full h-32" type="primary" @click="onSubmit">
                        {{ $t('public.confirm') }}
                    </el-button>
                </el-form-item>
            </template>
        </el-form>
    </div>
</template>

<script lang="ts" setup>
import { getFlatBindData, getPayMethod, saveFlatBindData } from '@/api/user';
import { CollectMethodItem } from '@/interface/user';

const payMethodList = ref<CollectMethodItem[]>([])
const payMethodId = ref<number>()

const payData = reactive({
    bank_address: '',
    bank_code: '',
    bank_name: "",
    card_no: '',
    real_name: ''
})

const getBindData = () => {
    getFlatBindData({ type: payMethodId.value! }).then(({ data }) => {
        payData.bank_address = data.raw_data.bank_address
        payData.bank_code = data.raw_data.bank_code
        payData.bank_name = data.raw_data.bank_name
        payData.card_no = data.raw_data.card_no
        payData.real_name = data.raw_data.real_name
    })
}

const onSubmit = () => {
    saveFlatBindData({ type: payMethodId.value, raw_data: payData }, { loading: true, showSuccessMessage: true })
}

onMounted(() => {
    getPayMethod().then(({ data }) => {
        payMethodList.value = data
        payMethodId.value = payMethodList.value[0]?.id
        if (payMethodId.value) {
            getBindData()
        }
    })
})
</script>