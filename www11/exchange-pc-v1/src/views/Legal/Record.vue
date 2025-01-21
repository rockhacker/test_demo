<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/legal' }"> {{ $t('legal.market') }}</el-breadcrumb-item>
                <el-breadcrumb-item>{{ $t('legal.order_history') }}</el-breadcrumb-item>
            </el-breadcrumb>
        </el-card>

        <el-card class="w-full mt-20" shadow="hover">
            <el-tabs v-model="way" @tab-change="onRefresh">
                <el-tab-pane v-for="item in typeList" :label="item.label" :name="item.value" />
            </el-tabs>

            <el-tabs v-model="status" title-active-color="#9fef4e" @tab-change="onRefresh">
                <el-tab-pane v-for="item in statusList" :label="item.label" :name="item.value" />
            </el-tabs>

            <ProTable ref="proTableRef" :getData="getData">
                <el-table-column :label="$t('legal.order_no')">
                    <template #default="scope">
                        <div class="flex items-center">
                            <span :class="[scope.row.way === 'BUY' ? 'text-up' : 'text-down']">
                                {{ scope.row.way === 'BUY' ? $t('legal.buy') : $t('legal.sell') }}
                            </span>
                            <span class="pl-6">{{ scope.row.currency_name }}</span>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column :label="$t('legal.unit')">
                    <template #default="scope">
                        {{ scope.row.price }} ({{ scope.row.area_info.currency }})
                    </template>
                </el-table-column>
                <el-table-column :label="$t('legal.amount')">
                    <template #default="scope">
                        {{ scope.row.number }} ({{ scope.row.currency_name }})
                    </template>
                </el-table-column>
                <el-table-column :label="$t('legal.total_amount')">
                    <template #default="scope">
                        {{ scope.row.amount }} ({{ scope.row.area_info.currency }})
                    </template>
                </el-table-column>
                <el-table-column prop="created_at" :label="$t('trade.time')" />
                <el-table-column :label="$t('legal.order_status')">
                    <template #default="scope">
                        <el-button text @click="router.push(`/legal/detail?id=${scope.row.id}&sourceId=${id}`)">
                            <span> {{ getStatusLabel(scope.row.status) }}</span>
                            <el-icon>
                                <ArrowRightBold />
                            </el-icon>
                        </el-button>
                    </template>
                </el-table-column>
            </ProTable>
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { ArrowRight } from '@element-plus/icons-vue'
import { OtcRecord } from '@/interface/otc';
import { getOtcOrderRecord } from '@/api/otc';
import { useOrderStatus } from './hooks';

const route = useRoute()
const router = useRouter()

const id = Number(route.query.id)

const way = ref<'BUY' | 'SELL'>('BUY')
const status = ref<number>()

const proTableRef = ref()

const { getStatusLabel, typeList, statusList } = useOrderStatus()

const getData = async (params: any) => {
    return new Promise((resolve, reject) => {
        getOtcOrderRecord({ ...params, currency_id: id, status: status.value, way: way.value }, { raceKey: 'getOtcOrderRecord' }).then(({ data }) => {
            resolve(data)
        }).catch((error) => {
            reject(error)
        })
    })
}

const onRefresh = () => {
    proTableRef.value?.onRefresh()
}
</script>