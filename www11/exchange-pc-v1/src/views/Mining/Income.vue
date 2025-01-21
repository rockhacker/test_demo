<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/mining' }"> {{ $t('nav.mining') }}</el-breadcrumb-item>
                <el-breadcrumb-item :to="{ path: '/mining/record' }">{{ $t('ico.my_subscribe') }}</el-breadcrumb-item>
                <el-breadcrumb-item>{{ $t('mining.profit_list') }}</el-breadcrumb-item>
            </el-breadcrumb>
        </el-card>

        <el-card class="w-full mt-20" shadow="hover">
            <ProTable :getData="getData">
                <el-table-column prop="interest" :label="$t('mining.interest')" />
                <el-table-column prop="created_at" :label="$t('trade.time')" />
            </ProTable>
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { getMiningOrderProfit } from '@/api';
import { ArrowRight } from '@element-plus/icons-vue'

const route = useRoute()
const id = Number(route.query.id)

const getData = (params: any) => {
    return new Promise((resolve, reject) => {
        getMiningOrderProfit({ sub_id: id, ...params }).then(({ data }) => {
            resolve(data)
        }).catch((error) => {
            reject(error)
        })
    })
}
</script>