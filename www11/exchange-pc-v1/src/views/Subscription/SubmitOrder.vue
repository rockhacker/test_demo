<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/subscription' }"> {{ $t('nav.ico') }}</el-breadcrumb-item>
                <el-breadcrumb-item>{{ ico?.currency_name }} {{ $t('ico.subscribe') }}</el-breadcrumb-item>
            </el-breadcrumb>
        </el-card>

        <el-card v-if="ico" class="w-full mt-20" shadow="hover">

            <div class="text-16 text-white">
                <div>{{ $t('public.balance') }}</div>
                <div>
                    {{ balance }}{{ currencyCode }}
                </div>
            </div>

            <div class="text-16 mt-10">
                <div class="text-white">{{ $t('ico.issue_price') }}</div>
                <div class="text-up">1{{ ico.currency_name }} = {{ ico.sub_price }}USDT</div>
            </div>

            <el-divider class="mt-12" />
            <div class="flex items-center justify-between mt-12 text-14">
                <div class="text-white">
                    {{ $t('ico.issue_num') }}
                </div>
                <div class="text-up">
                    {{ ico.issue_number }} {{ ico.currency_name }}
                </div>
            </div>
            <div class="flex items-center justify-between mt-12 text-14">
                <div class="text-white">
                    {{ $t('ico.remainder_num') }}
                </div>
                <div class="text-up">
                    {{ remain }} {{ ico.currency_name }}
                </div>
            </div>

            <el-divider class="mt-12" />
            <div class="flex items-center justify-between mt-12 text-14">
                <div class="flex-1">
                    <div class="text-white">
                        {{ $t('ico.subscribe_coin') }}
                    </div>
                    <div>
                        {{ ico.currency_name }}
                    </div>
                </div>
                <div class="flex-1">
                    <div class="text-white">
                        {{ $t('ico.may_online_time') }}
                    </div>
                    <div>
                        {{ ico.market_time }}
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between mt-12 text-14">
                <div class="flex-1">
                    <div class="text-white">
                        {{ $t('ico.start_subscribe_time') }}
                    </div>
                    <div>
                        {{ ico.start_time }}
                    </div>
                </div>
                <div class="flex-1">
                    <div class="text-white">
                        {{ $t('ico.end_subscribe_time') }}
                    </div>
                    <div>
                        {{ ico.finish_time }}
                    </div>
                </div>
            </div>
            <el-divider class="mt-10" />

            <div class="flex items-center">
                <div>
                    <el-select v-model="currencyId" size="large" style="width: 240px">
                        <el-option v-for="item in columns" :key="item.value" :label="item.text" :value="item.value" />
                    </el-select>
                </div>
                <div class="flex-1 ml-10">
                    <el-input class="text-16 w-full" v-model="number" type="number"
                        :placeholder="$t('ico.input_amount')" />
                </div>
            </div>

            <el-divider class="mt-10" />

            <el-button class="mt-12 rounded-12 h-40 text-14 w-full" color="#2fdab0" block @click="onSubmit">
                {{ $t('ico.subscribe_now') }}
            </el-button>

        </el-card>

        <el-card v-if="ico?.currency.desc" class="w-full mt-20" shadow="hover">
            <div class="text-white">
                {{ $t('ico.coin_desc') }}
            </div>
            <div class="text-white mt-6">{{ ico.currency.desc }}</div>
        </el-card>
    </div>
</template>

<script setup lang="ts">
import { ArrowRight } from '@element-plus/icons-vue'
import { getIcoBalance, getIcoInfo, submitIcoOrder } from '@/api/finance';
import { Currency } from '@/interface/user';
import { Ico } from '@/interface/finance';
import { subtract } from 'lodash-es';
const number = ref<number>()

const route = useRoute()

const id = Number(route.query.id)
const ico = ref<Ico>()

const currencyId = ref<number>()
const currencyList = ref<Currency[]>([])

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

// 剩余数量
const remain = computed(() => {
    if (!ico.value) return 0
    return subtract(ico.value.issue_number, ico.value.subscribed)
})

const getIconData = () => {
    getIcoInfo({ id }).then(({ data }) => {
        ico.value = data
    })

    getIcoBalance().then(({ data }) => {
        currencyList.value = data
        if (!currencyId.value) {
            currencyId.value = currencyList.value[0].id
        }
    })
}

const onSubmit = () => {
    submitIcoOrder({
        sub_id: id,
        amount: number.value!,
        pay_currency_id: currencyId.value!
    }, { showSuccessMessage: true, loading: true }).then(() => {
        number.value = undefined
        getIconData()
    })
}

getIconData()
</script>