<template>
    <nav-bar :title="$t('mining.subscribe')" />

    <div class="p-12" v-if="ico">
        <div class="bg-#383838 rounded-16 p-18 mt-20">
            <div class="text-16">
                <div class="text-#888">{{ $t('public.balance') }}</div>
                <div>
                    {{ balance }}{{ currencyCode }}
                </div>
            </div>

            <div class="text-16 mt-10">
                <div class="text-#888">{{ $t('ico.issue_price') }}</div>
                <div class="text-up">1{{ ico.currency_name }} = {{ ico.sub_price }}USDT</div>
            </div>

            <van-divider class="mt-12" />
            <div class="flex items-center justify-between mt-12 text-14">
                <div class="text-#888">
                    {{ $t('ico.issue_num') }}
                </div>
                <div class="text-up">
                    {{ ico.issue_number }} {{ ico.currency_name }}
                </div>
            </div>
            <div class="flex items-center justify-between mt-12 text-14">
                <div class="text-#888">
                    {{ $t('ico.remainder_num') }}
                </div>
                <div class="text-up">
                    {{ remain }} {{ ico.currency_name }}
                </div>
            </div>

            <van-divider class="mt-12" />
            <div class="flex items-center justify-between mt-12 text-14">
                <div class="flex-1">
                    <div class="text-#888">
                        {{ $t('ico.subscribe_coin') }}
                    </div>
                    <div>
                        {{ ico.currency_name }}
                    </div>
                </div>
                <div class="flex-1">
                    <div class="text-#888">
                        {{ $t('ico.may_online_time') }}
                    </div>
                    <div>
                        {{ ico.market_time }}
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-12 text-14">
                <div class="flex-1">
                    <div class="text-#888">
                        {{ $t('ico.start_subscribe_time') }}
                    </div>
                    <div>
                        {{ ico.start_time }}
                    </div>
                </div>
                <div class="flex-1">
                    <div class="text-#888">
                        {{ $t('ico.end_subscribe_time') }}
                    </div>
                    <div>
                        {{ ico.finish_time }}
                    </div>
                </div>
            </div>
            <van-divider class="mt-10" />

            <div class="flex items-center">
                <div class="mr-10" @click="setShowPicker(true)">
                    <div class="mt-12 px-10 h-24">{{ currencyCode }}</div>
                    <van-divider class="mt-10" />
                </div>
                <div class="flex-1">
                    <input class="text-16 mt-12 w-full" v-model="number" type="number"
                        :placeholder="$t('ico.input_amount')">
                    <van-divider class="mt-10" />
                </div>
            </div>

            <van-button class="mt-20 rounded-12 h-40 text-14" color="#2fdab0" block @click="onSubmit">
                {{ $t('ico.subscribe_now') }}
            </van-button>

            <div class="mt-20" v-if="ico.currency.desc">
                {{ $t('ico.coin_desc') }}
            </div>
            <div>{{ ico.currency.desc }}</div>
        </div>

    </div>

    <van-popup v-model:show="showPicker" round position="bottom">
        <van-picker :columns="columns" @cancel="showPicker = false" @confirm="onConfirm" />
    </van-popup>
</template>

<script lang="ts" setup>
import { getIcoBalance, getIcoInfo, submitIcoOrder } from '@/api/finance';
import { Currency } from '@/interface/user';
import { Ico } from '@/interface/finance';
import { subtract } from 'lodash-es';
import { showSuccessToast } from 'vant';

const number = ref<number>()

const route = useRoute()

const id = Number(route.query.id)
const ico = ref<Ico>()

const [showPicker, setShowPicker] = useToggle(false)
const currencyId = ref<number>()
const currencyList = ref<Currency[]>([])

getIcoBalance().then(({ data }) => {
    currencyList.value = data
    currencyId.value = currencyList.value[0].id
})

const balance = computed(() => {
    if (!currencyId.value) return 0
    return currencyList.value.find(item => item.id === currencyId.value)?.change_account.balance
})

const columns = computed(() => {
    return currencyList.value.map((item) => ({ text: item.code, value: item.id }))
})

const currencyCode = computed(() => {
    if (!currencyId.value) return ''
    return currencyList.value.find(item => item.id === currencyId.value)?.code
})

const onConfirm = ({ selectedOptions }: any) => {
    currencyId.value = selectedOptions[0].value
    setShowPicker(false)
}

getIcoInfo({ id }).then(({ data }) => {
    ico.value = data
})

// 剩余数量
const remain = computed(() => {
    if (!ico.value) return 0
    return subtract(ico.value.issue_number, ico.value.subscribed)
})

const onSubmit = () => {
    submitIcoOrder({
        sub_id: id,
        amount: number.value!,
        pay_currency_id: currencyId.value!
    }).then(({ msg }) => {
        number.value = undefined
        showSuccessToast(msg!)
    })
}
</script>