<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/store' }">{{ $t('nav.store') }}</el-breadcrumb-item>
                <el-breadcrumb-item>{{ $t('store.to_order_detail') }}</el-breadcrumb-item>
            </el-breadcrumb>
        </el-card>
        <el-card class="w-full mt-20" shadow="hover">
            <el-radio-group v-model="status" @change="onRefresh">
                <el-radio-button v-for="item in statusList" :label="item.label" :value="item.value" />
            </el-radio-group>
            <ProTable ref="proTableRef" class="mt-20" :getData="getData">
                <el-table-column :label="$t('legal.order_no')">
                    <template #default="scope">
                        <span :class="[scope.row.way == 'BUY' ? 'text-up' : 'text-down']">
                            {{ scope.row.way == 'SELL' ? $t('legal.buy') : $t('legal.sell') }}
                        </span>
                        <span>{{ scope.row.currency_name }}</span>
                    </template>
                </el-table-column>
                <el-table-column prop="price" :label="$t('legal.unit')" />
                <el-table-column prop="number" :label="$t('trade.quantity')" />
                <el-table-column prop="amount" :label="$t('legal.total_amount')" />
                <el-table-column prop="created_at" :label="$t('trade.time')" />
                <el-table-column :label="$t('legal.order_status')">
                    <template #default="scope">
                        <div class="flex items-center cursor-pointer"
                            @click="router.push(`/store/detail?id=${scope.row.id}&sourceId=${id}`)">
                            <span class="pr-4">{{ getStatusLabel(scope.row.status) }}</span>
                            <el-icon size="14">
                                <ArrowRight />
                            </el-icon>
                        </div>
                    </template>
                </el-table-column>
            </ProTable>
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { getMasterDetail } from '@/api';
import { ArrowRight } from '@element-plus/icons-vue'
import { useOrderStatus } from '../Legal/hooks';

const route = useRoute()
const router = useRouter()

const id = Number(route.query.id)

const { statusList } = useOrderStatus()

const getStatusLabel = (id: number) => {
    return statusList.find((item) => item.value === id)?.label
}

const status = ref(undefined)

const proTableRef = ref()

const onRefresh = () => {
    proTableRef.value?.onRefresh()
}

const getData = (params: any) => {
    return new Promise((resolve, reject) => {
        getMasterDetail({ ...params, master_id: id, status: status.value ?? -1 }, { raceKey: 'getMasterDetail' }).then(({ data }) => {
            resolve(data)
        }).catch((error) => {
            reject(error)
        })
    })
}
</script>
