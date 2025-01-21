<template>
    <el-dialog v-model="show" closeable class="p-30">
        <div class="p-20">
            <div class="text-18">
                {{ way === 'SELL' ? $t('legal.buy') : $t('legal.sell') }} {{ currency.code }}
            </div>
            <div class="mt-4">
                <span class="pr-10">{{ $t('legal.unit') }}</span>
                <span class="text-up text-16">{{ floor(+otc.price, 2) }}{{ otc.area_currency }}</span>
            </div>

            <div class="mt-4">{{ way === 'SELL' ? $t('legal.buy_with_amount') : $t('legal.sell_with_amount') }}</div>
            <div class="mt-4 py-4 px-10 flex items-center justify-between border-1 border-solid border-#888 rounded-4">
                <input class="text-14 flex-1 mr-10" v-model="number" type="number"
                    :placeholder="way === 'SELL' ? $t('legal.buy_amount') : $t('legal.sell_amount')">

                <el-button size="small" color="#9fef4e" @click="number = maxNumber">
                    {{ way === 'SELL' ? $t('legal.buy_all') : $t('legal.sell_all') }}
                </el-button>
            </div>

            <div class="mt-10">
                {{ $t('legal.limit') }} {{ getAmount(otc.min_number, otc.price) }}{{ otc.area_currency }} -
                {{ maxNumber }}{{ otc.area_currency }}
            </div>

            <div class="mt-10 flex items-center justify-between">
                <div>
                    {{ $t('legal.total_amount') }}
                </div>
                <div>
                    {{ tradeAmount }} {{ otc.area_currency }}
                </div>
            </div>

            <div class="flex justify-between items-center mt-10">
                <el-button class="w-[48%] rounded-4" color="#999" :disabled="true">
                    {{ current.seconds + 1 }}s{{ $t('legal.auto_cancel') }}
                </el-button>
                <el-button class="w-[48%] rounded-4" color="#2fdab0" @click="onSubmit">
                    {{ $t('legal.submit') }}
                </el-button>
            </div>
        </div>
    </el-dialog>
</template>

<script lang="ts" setup>
import { Otc } from '@/interface/otc';
import { Currency } from '@/interface/user';
import { floor } from 'lodash-es';
import { getAmount } from '../common'
import { useCountDown } from '@vant/use';
import Big from 'big.js';
import { submitOtcOrder } from '@/api/otc';

const props = defineProps<{
    modelValue: boolean,
    way: 'BUY' | 'SELL',
    otc: Otc,
    currency: Currency
}>();

const emits = defineEmits(["update:modelValue"]);

const show = useVModel(props, "modelValue", emits);

const number = ref<number>()

const maxNumber = getAmount(props.otc.max_number, props.otc.price)

const tradeAmount = computed(() => {
    if (!number.value) return 0
    return floor(new Big(number.value).times(props.otc.price).toNumber(), 2)
})

const { current, start, pause } = useCountDown({
    // 倒计时 60s
    time: 60 * 1000,
    onFinish: () => {
        show.value = false
    }
});

const onSubmit = () => {
    submitOtcOrder({
        master_id: props.otc.id,
        number: number.value!,
        price: +props.otc.price
    }, { showSuccessMessage: true }).then(({ msg }) => {
        show.value = false
    })
}

// 开始倒计时
start();

onUnmounted(() => {
    pause()
})
</script>