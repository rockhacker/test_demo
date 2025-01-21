<template>
    <div class="legal-page">
        <div class="max-w-[1200px] mx-auto mt-20 w-full flex flex-col">
            <el-card class="w-full" shadow="hover">
                <div class="flex items-center justify-between">
                    <span class="text-white text-18">{{ $t('legal.market') }}</span>
                    <el-button link @click="toRecord" v-if="currency_id">
                        {{ $t('legal.order_history') }}
                    </el-button>
                </div>
            </el-card>

            <el-card class="w-full mt-20" shadow="hover">
                <el-tabs v-model="way" @tab-change="onRefresh">
                    <el-tab-pane :label="$t('legal.to_buy')" name="SELL" />
                    <el-tab-pane :label="$t('legal.to_sell')" name="BUY" />
                </el-tabs>

                <el-tabs v-model="currency_id" title-active-color="#9fef4e" @tab-change="onRefresh">
                    <el-tab-pane v-for="item in currencyList" :label="item.code" :name="item.id" />
                </el-tabs>

                <ProTable v-if="currencyList.length" ref="proTableRef" :getData="getData">
                    <el-table-column prop="seller_name" :label="$t('legal.store_manner')" />
                    <el-table-column :label="$t('legal.amount')">
                        <template #default="scope">
                            {{ scope.row.remain_qty }} {{ currency?.code }}
                        </template>
                    </el-table-column>
                    <el-table-column :label="$t('legal.limit')">
                        <template #default="scope">
                            {{ getAmount(scope.row.min_number, scope.row.price) }}{{ scope.row.area_currency }} -
                            {{ getAmount(scope.row.max_number, scope.row.price) }}{{ scope.row.area_currency }}
                        </template></el-table-column>
                    <el-table-column :label="$t('legal.unit')">
                        <template #default="scope">
                            <div class="text-up text-16">{{ floor(+scope.row.price, 2) }}{{ scope.row.area_currency }}
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column :label="$t('legal.pay_method')">
                        <el-icon color="yellow" size="20px">
                            <Postcard />
                        </el-icon>
                    </el-table-column>
                    <el-table-column :label="$t('public.operate')">
                        <template #default="scope">
                            <el-button size="small" :color="way === 'SELL' ? '#f84f4f' : '#2fdab0'"
                                @click="toSubmitOtcOrder(scope.row)">
                                {{ way === 'SELL' ? $t('legal.buy') : $t('legal.sell') }}
                            </el-button>
                        </template>
                    </el-table-column>
                </ProTable>
            </el-card>
        </div>
        <SubmitOtcOrder v-if="showPopup" v-model="showPopup" :way="way" :otc="currentOtc!" :currency="currency!" />
    </div>
</template>

<script lang="ts" setup>
import { getCurrencies, getOtcList } from '@/api/otc';
import { Otc } from '@/interface/otc';
import { Currency } from '@/interface/user';
import { floor } from 'lodash-es';
import SubmitOtcOrder from './components/SubmitOtcOrder.vue';
import { getAmount } from './common'

const router = useRouter()

const way = ref<'BUY' | 'SELL'>('SELL')

const currency_id = ref<number>()
const currencyList = ref<Currency[]>([])
const currency = computed(() => {
    return currencyList.value.find((item) => item.id === currency_id.value)
})

const getData = async (params: any) => {
    return new Promise((resolve, reject) => {
        getOtcList({ ...params, currency_id: currency_id.value!, way: way.value }, { raceKey: 'getOtcList' }).then(({ data }) => {
            resolve(data)
        }).catch((error) => {
            reject(error)
        })
    })
}

const proTableRef = ref()

const onRefresh = () => {
    proTableRef.value?.onRefresh()
}

getCurrencies().then(({ data }) => {
    currencyList.value = data
    if (currencyList.value.length) currency_id.value = currencyList.value[0].id
})

const toRecord = () => {
    router.push(`/legal/record?id=${currency_id.value}`)
}

// 下单相关逻辑
const [showPopup, setShowPopup] = useToggle(false)

const currentOtc = ref<Otc>()

const toSubmitOtcOrder = (item: Otc) => {
    currentOtc.value = item
    setShowPopup(true)
}
</script>

<style lang="scss">
.legal-page {
    .el-tabs {
        --el-tabs-header-height: 52px !important;
    }

    .el-tabs__header {
        padding: 0 24px;
        background-color: #1d1e1e;
    }
}
</style>