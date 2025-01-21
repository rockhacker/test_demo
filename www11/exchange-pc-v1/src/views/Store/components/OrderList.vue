<template>
    <el-radio-group v-model="status" @change="onRefresh">
        <el-radio-button :label="$t('store.is_open')" :value="1" />
        <el-radio-button :label="$t('store.is_stop')" :value="0" />
        <el-radio-button :label="$t('store.is_cancel')" :value="4" />
        <el-radio-button :label="$t('store.is_down')" :value="2" />
        <el-radio-button :label="$t('store.is_finish')" :value="3" />
    </el-radio-group>

    <ProTable class="mt-20" ref="proTableRef" :getData="getData">
        <el-table-column width="100px" prop="currency_name" :label="$t('public.coin_type')" />
        <el-table-column :label="$t('legal.amount')">
            <template #default="scope">
                <div class="flex items-center">
                    <span>{{ scope.row.total_qty }}</span>
                    <span class="pl-5">{{ scope.row.currency_name }}</span>
                </div>
            </template>
        </el-table-column>
        <el-table-column :label="$t('legal.limit')">
            <template #default="scope">
                {{ getAmount(scope.row.min_number, scope.row.price) }}{{ scope.row.area_currency }} -
                {{ getAmount(scope.row.max_number, scope.row.price) }}{{ scope.row.area_currency }}
            </template>
        </el-table-column>
        <el-table-column width="100px" :label="$t('legal.unit')">
            <template #default="scope">
                <div class="text-up text-16">{{ floor(+scope.row.price, 2) }}{{ scope.row.area_currency }}
                </div>
            </template>
        </el-table-column>
        <el-table-column width="100px" :label="$t('legal.pay_method')">
            <template #default="scope">
                <div>
                    <el-tag v-for="item in scope.row.payways" type="info">{{ item.name }}</el-tag>
                </div>
            </template>
            <!-- <el-icon color="yellow" size="20px">
                <Postcard />
            </el-icon> -->
        </el-table-column>
        <el-table-column :label="$t('public.operate')">
            <template #default="scope">
                <div class="flex items-center">
                    <el-button v-if="scope.row.status === 1" size="small" @click="pauseOrder(scope.row.id)">
                        {{ $t('store.stop') }}
                    </el-button>
                    <el-button v-if="scope.row.status === 0" size="small" @click="startOrder(scope.row.id)">
                        {{ $t('store.open') }}
                    </el-button>
                    <el-button v-if="scope.row.status !== 3" size="small" @click="cancelOrder(scope.row.id)">
                        {{ $t('public.undo') }}
                    </el-button>
                    <el-button size="small" @click="router.push(`/store/record?id=${scope.row.id}`)">
                        {{ $t('store.to_order_detail') }}
                    </el-button>
                </div>
            </template>
        </el-table-column>
    </ProTable>
</template>

<script lang="ts" setup>
import { getAmount } from '../../Legal/common'
import { cancelMasterOtcOrder, getStoreOrder, openOtcOrder, pauseOtcOrder } from '@/api';
import { floor } from 'lodash-es';

const props = defineProps<{
    way: 'BUY' | 'SELL'
}>()

const router = useRouter()

const status = ref(1)

const proTableRef = ref()

const onRefresh = () => {
    proTableRef.value?.onRefresh()
}

const getData = async (params: any) => {
    return new Promise((resolve, reject) => {
        getStoreOrder({ ...params, way: props.way, status: status.value }, { raceKey: `getStoreOrder-${props.way}` }).then(({ data }) => {
            resolve(data)
        }).catch((error) => {
            reject(error)
        })
    })
}

const pauseOrder = async (master_id: number) => {
    await pauseOtcOrder({ master_id })
    onRefresh()
}

const startOrder = async (master_id: number) => {
    await openOtcOrder({ master_id })
    onRefresh()
}

const cancelOrder = async (master_id: number) => {
    await cancelMasterOtcOrder({ master_id })
    onRefresh()
}

defineExpose({
    onRefresh
})
</script>