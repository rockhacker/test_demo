<template>
    <nav-bar :title="$t('mining.subscribe_list')" />

    <van-pull-refresh v-model="loading" @refresh="onRefresh">
        <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
            <div class="bg-#383838 rounded-16 p-12 text-12 mt-12 mx-20" v-for="item in orderList" :key="item.id">
                <div class="text-center text-18">{{ item.get_fund.title }}</div>

                <van-divider class="mt-10" />


                <div class="flex items-center justify-between mt-10 text-16 px-20">
                    <div>{{ item.get_fund.currency_code }}</div>
                    <div>{{ getStatus(item.status) }}</div>
                </div>

                <div class="flex items-center justify-between text-center mt-20 text-14">
                    <div class="flex-1 items-center">
                        <div>{{ item.share_amount }}</div>
                        <div>{{ $t('mining.subscribe_num') }}</div>
                    </div>
                    <div class="flex-1 items-center">
                        <div>{{ item.sub_time }}</div>
                        <div>{{ $t('mining.subscribe_time') }}</div>
                    </div>
                </div>


                <van-button class="mt-20 rounded-12 h-40 text-14" :disabled="item.status !== 1" color="#2fdab0" block
                    @click="onRefund(item)">
                    {{ $t('mining.redemption') }}
                </van-button>

                <van-button class="mt-10 rounded-12 h-40 text-14" color="#2fdab0" block
                    @click="router.push(`/mining/order-profit?id=${item.id}`)">
                    {{ $t('mining.watch_profit_list') }}
                </van-button>
            </div>
        </van-list>
    </van-pull-refresh>
</template>

<script lang="ts" setup>
import { getMiningOrderList, refundMiningOrder } from '@/api/finance';
import { FundOrder } from '@/interface/finance';
import Big from 'big.js';
import { showConfirmDialog, showSuccessToast } from 'vant';
import { useI18n } from 'vue-i18n';

const router = useRouter()
const { t } = useI18n()

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

const orderList = ref<FundOrder[]>([])

const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const onLoad = () => {
    page.value++

    setLoading(true)

    getMiningOrderList({ page: page.value }).then(({ data }) => {
        const list = data.data
        orderList.value = page.value === 1 ? list : orderList.value.concat(list);
        setFinish(data.last_page === page.value)
    }).finally(() => {
        setLoading(false)
    })
}

const onRefresh = () => {
    // orderList.value = []
    page.value = 0
    onLoad()
}

const onRefund = (order: FundOrder) => {
    const num = new Big(order.share_amount).times(order.get_fund.liquidated_damages).div(100).toNumber()
    showConfirmDialog({
        message: `${t('public.pay')} ${num}${order.get_fund.currency_code} ${t('mining.pay_penal_sum_redemption')}`,
    })
        .then(() => {
            refundMiningOrder({
                sub_id: order.id
            }).then(({ msg }) => {
                showSuccessToast(msg!)
                onRefresh()
            })
        })
        .catch(() => {
            // on cancel
        });
}
</script>