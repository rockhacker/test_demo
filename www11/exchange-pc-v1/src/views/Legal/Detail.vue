<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col legal-detail-page">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/legal' }"> {{ $t('legal.market') }}</el-breadcrumb-item>
                <el-breadcrumb-item :to="`/legal/record?id=${route.query.sourceId}`">
                    {{ $t('legal.order_history') }}
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

<style lang="scss">
.legal-detail-page {
    .el-collapse-item__header {
        color: white;
        font-size: 14px;
    }
}
</style>