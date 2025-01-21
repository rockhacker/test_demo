<template>
    <div class="flex items-center justify-between">
        <div>
            {{ $t('user.withdraw_history') }}
        </div>
        <el-select v-model="currency_id" class="w-240" @change="proTableRef.onRefresh()">
            <el-option v-for="item in options" :key="item.id" :label="item.currency_code" :value="item.currency_id" />
        </el-select>
    </div>

    <ProTable ref=proTableRef class="mt-10" :getData="getData">
        <el-table-column prop="number" :label="$t('trade.quantity')" />
        <el-table-column prop="fee" :label="$t('trade.handle_fee')" />
        <el-table-column prop="real_number" :label="$t('trade.receive_num')" />
        <el-table-column prop="status_name" :label="$t('public.status')" />
        <el-table-column prop="created_at" :label="$t('trade.time')" />
        <el-table-column prop="address" :label="$t('user.withdraw_address')" />
        <el-table-column prop="notes" :label="$t('public.remark')" />
    </ProTable>
</template>

<script lang="ts" setup>
import { useI18n } from 'vue-i18n';
import useWithdraw from './hooks/useWithdraw';
import { getWithdrawList } from '@/api';

const { coinList } = useWithdraw()

const { t } = useI18n()

const proTableRef = ref()

const options = computed(() => {
    return [
        {
            id: 0,
            currency_code: t('public.all'),
            currency_id: ''
        },
        ...coinList.value
    ]
})

const currency_id = ref<number | string>('')

const getData = (params: any) => {
    return new Promise((resolve, reject) => {
        getWithdrawList({ currency_id: currency_id.value, ...params }).then(({ data }) => {
            resolve(data)
        }).catch((error) => {
            reject(error)
        })
    })
}
</script>