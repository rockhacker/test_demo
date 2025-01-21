<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/subscription' }"> {{ $t('nav.ico') }}</el-breadcrumb-item>
                <el-breadcrumb-item>{{ $t('ico.my_subscribe') }}</el-breadcrumb-item>
            </el-breadcrumb>
        </el-card>

        <el-card class="w-full mt-20" shadow="hover">
            <ProTable :getData="getData">
                <el-table-column prop="created_at" :label="$t('mining.subscribe_time')" />
                <el-table-column prop="subscription.currency_name" :label="$t('public.coin_type')" />
                <el-table-column prop="number" :label="$t('mining.subscribe_num')" />
                <el-table-column prop="winning_lots_number" :label="$t('ico.mean_number')" />
                <el-table-column prop="subscription.market_time" :label="$t('ico.online_time')" />
                <el-table-column :label="$t('public.status')">
                    <template #default="scope">
                        <span>{{ getStatus(scope.row.status) }}</span>
                        <span v-if="scope.row.is_return === 2">({{ $t('ico.refund_part') }})</span>
                    </template>
                </el-table-column>
            </ProTable>
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { ArrowRight } from '@element-plus/icons-vue'
import { getIcoOrderList } from '@/api/finance';
import { IcoOrder } from '@/interface/finance';
import { useI18n } from 'vue-i18n';

const { t } = useI18n()

const getStatus = (status: number) => {
    // 1.待抽签 2.未中签 3.已中签 4.已发币 5.已退款
    switch (status) {
        case 1:
            return t('ico.wait_draw')
        case 2:
            return t('ico.no_draw')
        case 3:
            return t('ico.get_draw')
        case 4:
            return t('ico.sended_coin')
        case 5:
            return t('ico.is_refund')
        default:
            return ''
    }
}

const orderList = ref<IcoOrder[]>([])

const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const getData = (params: any) => {
    return new Promise((resolve, reject) => {
        getIcoOrderList(params, { raceKey: 'getIcoOrderList' }).then(({ data }) => {
            console.log(data);
            resolve(data)
        }).catch((error) => {
            reject(error)
        })
    })
}
</script>
