<template>
    <nav-bar :title="$t('mining.subscribe')" />

    <div class="p-12" v-if="mining">
        <div class="flex items-center mt-20">
            <img class="w-60 h-60 ml-10" :src="mining.image" alt="" srcset="">
            <div class="ml-20">
                <div class="text-18">{{ mining.title }}</div>
                <div class="text-14 mt-16">
                    <span class="pr-10 text-16">{{ mining.currency_code }}</span>
                    <span class="bg-up rounded-8 px-10">{{ $t('mining.expected_profit') }}:{{ mining.dividend_percentage
                    }}%</span>
                </div>
            </div>
        </div>

        <div class="bg-#383838 rounded-16 p-18 text-16 mt-20">
            <div class="flex items-center justify-between">
                <div class="text-#888">
                    {{ $t('mining.machine_rent') }}
                </div>
                <div>
                    {{ mining.staring_sub_amount }}
                </div>
            </div>
            <van-divider class="mt-12" />
            <div class="flex items-center justify-between mt-12">
                <div class="text-#888">
                    {{ $t('mining.mining_time') }}
                </div>
                <div>
                    {{ mining.lock_dividend_days }}
                </div>
            </div>
            <van-divider class="mt-12" />
            <div class="flex items-center justify-between mt-12">
                <div class="text-#888">
                    {{ $t('mining.max_subscribe') }}
                </div>
                <div>
                    {{ mining.max_sub_amount }}
                </div>
            </div>
            <van-divider class="mt-10" />

            <input class="text-16 mt-12 w-full" v-model="number" type="number" :placeholder="$t('mining.input_lock_num')">

            <van-divider class="mt-10" />

            <van-button class="mt-20 rounded-12 h-40 text-14" color="#2fdab0" block @click="onSubmit">
                {{ $t('mining.subscribe') }}
            </van-button>

            <div class="mt-20">
                {{ $t('mining.product_desc') }}
            </div>

            <div>
                {{ mining.desc }}
            </div>
        </div>

    </div>
</template>

<script lang="ts" setup>
import { getMiningInfo, submitMiningOrder } from '@/api/finance';
import { Fund } from '@/interface/finance';
import { showSuccessToast } from 'vant';

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
    }).then(({ msg }) => {
        number.value = undefined
        showSuccessToast(msg!)
    })
}
</script>