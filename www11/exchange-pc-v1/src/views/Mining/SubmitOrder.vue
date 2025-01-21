<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col mining-submit-order-page">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/mining' }"> {{ $t('nav.mining') }}</el-breadcrumb-item>
                <el-breadcrumb-item>{{ $t('mining.subscribe') }}</el-breadcrumb-item>
            </el-breadcrumb>
        </el-card>

        <el-card class="w-full mt-20 text-white" shadow="hover">
            <div class="p-12" v-if="mining">
                <div class="flex items-center mt-20">
                    <img class="w-60 h-60 ml-10" :src="mining.image" alt="" srcset="">
                    <div class="ml-20">
                        <div class="text-18">{{ mining.title }}</div>
                        <div class="text-14 mt-16">
                            <span class="pr-10 text-16">{{ mining.currency_code }}</span>
                            <span class="bg-up rounded-8 px-10 text-white">
                                {{ $t('mining.expected_profit') }}:{{ mining.dividend_percentage }}%
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-#383838 rounded-16 p-18 text-16 mt-20">
                    <div class="flex items-center justify-between">
                        <div>
                            {{ $t('mining.machine_rent') }}
                        </div>
                        <div>
                            {{ mining.staring_sub_amount }}
                        </div>
                    </div>
                    <el-divider class="mt-12" />
                    <div class="flex items-center justify-between mt-12">
                        <div>
                            {{ $t('mining.mining_time') }}
                        </div>
                        <div>
                            {{ mining.lock_dividend_days }}
                        </div>
                    </div>
                    <el-divider class="mt-12" />
                    <div class="flex items-center justify-between mt-12">
                        <div>
                            {{ $t('mining.max_subscribe') }}
                        </div>
                        <div>
                            {{ mining.max_sub_amount }}
                        </div>
                    </div>
                    <el-divider class="my-10" />

                    <el-input class="text-16 mt-12 w-full" v-model="number" type="number"
                        :placeholder="$t('mining.input_lock_num')" />

                    <el-divider class="my-20" />

                    <el-button class="rounded-4 h-40 text-14 w-full" color="#2fdab0" block @click="onSubmit">
                        {{ $t('mining.subscribe') }}
                    </el-button>

                    <div class="mt-20">
                        {{ $t('mining.product_desc') }}
                    </div>

                    <div>
                        {{ mining.desc }}
                    </div>
                </div>

            </div>
        </el-card>
    </div>
</template>

<script setup lang="ts">
import { ArrowRight } from '@element-plus/icons-vue'
import { getMiningInfo, submitMiningOrder } from '@/api/finance';
import { Fund } from '@/interface/finance';

const number = ref<number>()

const route = useRoute()

const id = Number(route.query.id)

const mining = ref<Fund>()

getMiningInfo({ id }).then(({ data }) => {
    mining.value = data
})

const onSubmit = () => {
    submitMiningOrder({
        id,
        amount: number.value!
    }, { showSuccessMessage: true, loading: true }).then(() => {
        number.value = undefined
    })
}
</script>

<style lang="scss">
.mining-submit-order-page {

    .el-input__wrapper {
        box-shadow: 0 0 0 1px var(--el-input-hover-border-color) inset;
    }

    .el-input__wrapper,
    input {
        background-color: #383838 !important;
        color: white !important;
    }
}
</style>