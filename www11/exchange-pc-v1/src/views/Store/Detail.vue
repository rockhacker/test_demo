<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/store' }">{{ $t('nav.store') }}</el-breadcrumb-item>
                <el-breadcrumb-item :to="`/store/record?id=${route.query.sourceId}`">
                    {{ $t('store.to_order_detail') }}
                </el-breadcrumb-item>
                <el-breadcrumb-item>{{ $t('legal.order_status') }}</el-breadcrumb-item>
            </el-breadcrumb>
        </el-card>

        <OtcOrderDetail />
    </div>
</template>

<script lang="ts" setup>
import { ArrowRight } from '@element-plus/icons-vue'

const route = useRoute()
</script>