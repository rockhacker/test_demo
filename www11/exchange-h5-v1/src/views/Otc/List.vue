<template>
    <nav-bar :title="$t('legal.legal_trade')">
        <template #right>
            <svg-icon class="w-24 h-24" color="#888" name="order-record" @click="toRecord" />
        </template>
    </nav-bar>

    <van-tabs class="px-16 mt-10" v-model:active="way" @change="onRefresh">
        <van-tab :title="$t('legal.to_buy')" name="SELL" />
        <van-tab :title="$t('legal.to_sell')" name="BUY" />
    </van-tabs>



    <van-tabs v-model:active="currency_id" line-width="40px" swipe-threshold=1 line-height="3px" title-active-color="#9fef4e"
        @change="onRefresh">
        <van-tab v-for="item in currencyList" :title="item.code" :name="item.id">
        </van-tab>
    </van-tabs>

    <van-pull-refresh v-if="currencyList.length" class="px-12" v-model="loading" @refresh="onRefresh">
        <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
            <div class="bg-#383838 rounded-16 p-12 text-14 mt-12" v-for="item in otcList" :key="item.id">
                <div class="text-16">
                    {{ item.seller_name }}
                </div>
                <div class="flex items-center justify-between mt-6">
                    <div>
                        <div>{{ $t('legal.amount') }} {{ item.remain_qty }} {{ currency?.code }}</div>
                        <div>{{ $t('legal.limit') }} {{ getAmount(item.min_number, item.price) }}{{ item.area_currency }} -
                            {{ getAmount(item.max_number, item.price) }}{{ item.area_currency }}</div>
                    </div>
                    <div class="text-right">
                        <div>{{ $t('legal.unit') }}</div>
                        <div class="text-up text-16">{{ floor(+item.price, 2) }}{{ item.area_currency }}</div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-10">
                    <van-icon name="card" size="1.8rem" color="#9FEF4E" />
                    <van-button size="small" type="primary" @click="toSubmitOtcOrder(item)">
                        {{ way === 'SELL' ? $t('legal.buy') : $t('legal.sell') }}
                    </van-button>
                </div>
            </div>
        </van-list>
    </van-pull-refresh>

    <submit-otc-order v-if="showPopup" v-model="showPopup" :way="way" :otc="currentOtc!" :currency="currency!" />
</template>

<script lang="ts" setup>
import { getCurrencies, getOtcList } from '@/api/otc';
import { Otc } from '@/interface/otc';
import { Currency } from '@/interface/user';
import { floor } from 'lodash-es';
import SubmitOtcOrder from './components/SubmitOtcOrder.vue';
import { getAmount } from './common'

let controller: AbortController | null;
let promise: Promise<any> | null;

const router = useRouter()

const way = ref<'BUY' | 'SELL'>('SELL')

const currency_id = ref<number>()
const currencyList = ref<Currency[]>([])
const currency = computed(() => {
    return currencyList.value.find((item) => item.id === currency_id.value)
})

const otcList = ref<Otc[]>([])
const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const onLoad = async () => {
    page.value++

    if (controller) {
        controller.abort();
        controller = null;
    }

    if (promise) {
        await promise.catch(() => { });
    }

    setLoading(true)

    controller = new AbortController();

    promise = getOtcList({ page: page.value, currency_id: currency_id.value!, way: way.value }, { signal: controller.signal }).then(({ data }) => {
        const list = data.data
        otcList.value = page.value === 1 ? list : otcList.value.concat(list);
        setFinish(data.last_page === page.value)
    }).catch((error) => {
        console.error(error);
        setFinish(true)
    })
        .finally(() => {
            setLoading(false)
            promise = null;
        })
}

const onRefresh = () => {
    otcList.value = []
    page.value = 0
    onLoad()
}

getCurrencies().then(({ data }) => {
    currencyList.value = data
    if (currencyList.value.length) currency_id.value = currencyList.value[0].id
})

const toRecord = () => {
    router.push(`/otc/record?id=${currency_id.value}`)
}

// 下单相关逻辑
const [showPopup, setShowPopup] = useToggle(false)

const currentOtc = ref<Otc>()

const toSubmitOtcOrder = (item: Otc) => {
    currentOtc.value = item
    setShowPopup(true)
}
</script>
