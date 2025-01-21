<template>
    <div class="w-full flex flex-col">
        <ProTable :getData="getData">
            <el-table-column prop="currency.code" :label="$t('public.coin_type')" />
            <el-table-column prop="value" :label="$t('legal.amount')" />
            <el-table-column prop="memo" :label="$t('transfer.source')" />
            <el-table-column prop="created_at" :label="$t('trade.time')" />
        </ProTable>
    </div>
</template>

<script lang="ts" setup>
import { getSubAccountLog } from '@/api';

const getData = (params: any) => {
    return new Promise((resolve, reject) => {
        getSubAccountLog({ ...params }).then(({ data }) => {
            resolve(data)
        }).catch((error) => {
            reject(error)
        })
    })
}
</script>