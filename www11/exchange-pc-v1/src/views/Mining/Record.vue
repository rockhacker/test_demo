<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/mining' }"> {{ $t('nav.mining') }}</el-breadcrumb-item>
                <el-breadcrumb-item>{{ $t('ico.my_subscribe') }}</el-breadcrumb-item>
            </el-breadcrumb>
        </el-card>

        <el-card class="w-full mt-20" shadow="hover">
            <ProTable ref="proTableRef" :getData="getData">
                <el-table-column prop="get_fund.title" :label="$t('mining.name')" />
                <el-table-column prop="get_fund.currency_code" :label="$t('public.coin_type')" />
                <el-table-column prop="share_amount" :label="$t('mining.subscribe_num')" />
                <el-table-column :label="$t('public.status')">
                    <template #default="scope">
                        <span>{{ getStatus(scope.row.status) }}</span>
                    </template>
                </el-table-column>
                <el-table-column prop="sub_time" :label="$t('mining.subscribe_time')" />
                <el-table-column :label="$t('public.operate')" width="300">
                    <template #default="scope">
                        <el-button class="rounded-4 h-40 text-14" color="#2fdab0" block
                            @click="router.push(`/mining/income?id=${scope.row.id}`)">
                            {{ $t('mining.watch_profit_list') }}
                        </el-button>
                        <el-button class="rounded-4 h-40 text-14" :disabled="scope.row.status !== 1"
                            :color="scope.row.status !== 1 ? '#f84f4f' : '#2fdab0'" block @click="onRefund(scope.row)">
                            {{ $t('mining.redemption') }}
                        </el-button>
                    </template>
                </el-table-column>
            </ProTable>
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { ArrowRight } from '@element-plus/icons-vue'
import { getMiningOrderList, refundMiningOrder } from '@/api/finance';
import { useI18n } from 'vue-i18n';
import { FundOrder } from '@/interface';
import Big from 'big.js';
import { ElMessageBox } from 'element-plus';

const { t } = useI18n()
const router = useRouter()

const proTableRef = ref()

const getStatus = (status: number) => {
    // 1.进行中 2.申请退款中,3.已退款 4已结束
    switch (status) {
        case 1:
            return t('public.doing')
        case 2:
            return t('public.refunding')
        case 3:
            return t('public.refunded')
        case 4:
            return t('public.finished')
        default:
            return ''
    }
}

const getData = (params: any) => {
    return new Promise((resolve, reject) => {
        getMiningOrderList(params, { raceKey: 'getMiningOrderList' }).then(({ data }) => {
            resolve(data)
        }).catch((error) => {
            reject(error)
        })
    })
}

const onRefund = (order: FundOrder) => {
    const num = new Big(order.share_amount).times(order.get_fund.liquidated_damages).div(100).toNumber()
    ElMessageBox.confirm(
        `${t('public.pay')} ${num}${order.get_fund.currency_code} ${t('mining.pay_penal_sum_redemption')}`,
        t('public.tip'),
        {
            confirmButtonText: t('public.confirm'),
            cancelButtonText: t('public.cancel'),
            type: 'warning',
        }
    )
        .then(() => {
            refundMiningOrder({
                sub_id: order.id
            }, { loading: true, showSuccessMessage: true }).then(() => {
                proTableRef.value?.onRefresh()
            })
        })
}
</script>
