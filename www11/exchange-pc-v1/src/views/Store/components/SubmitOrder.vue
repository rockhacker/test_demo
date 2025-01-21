<template>
    <el-dialog v-model="dialogVisible" :title="$t('store.publish')" width="600">
        <el-form :model="form" label-width="auto" class="w-full">
            <el-form-item :label="$t('public.coin_type')">
                <el-select v-model="form.currency_id" :placeholder="$t('store.please_select_currency')">
                    <el-option v-for="item in otcCurrencyList" :key="item.id" :label="item.currency_code"
                        :value="item.currency_id" />
                </el-select>
            </el-form-item>
            <el-form-item :label="$t('store.currency_unit')">
                <el-select v-model="form.area_id" :placeholder="$t('store.please_select_currency_unit')">
                    <el-option v-for="item in otcCurrencyName" :key="item.id" :label="item.currency" :value="item.id" />
                </el-select>
            </el-form-item>
            <el-form-item :label="$t('legal.pay_method')">
                <el-select v-model="form.payways" multiple :placeholder="$t('legal.please_select_pay_method')">
                    <el-option v-for="item in otcPayMethods" :key="item.payway_id" :label="item.payway.name"
                        :value="item.payway_id" />
                </el-select>
            </el-form-item>
            <el-form-item :label="$t('store.auto_open_deal')">
                <el-switch v-model="form.auto_start" active-value="1" inactive-value="0" />
            </el-form-item>
            <el-form-item :label="$t('legal.unit')">
                <el-input v-model="form.price" :placeholder="$t('store.please_input_unit_price')" />
            </el-form-item>
            <el-form-item :label="$t('trade.quantity')">
                <el-input v-model="form.total_qty" :placeholder="$t('trade.input_num')" />
            </el-form-item>
            <el-form-item :label="$t('store.min_deal_num')">
                <el-input v-model="form.min_number" :placeholder="$t('store.input_min_deal_num')" />
            </el-form-item>
            <el-form-item :label="$t('store.max_deal_num')">
                <el-input v-model="form.max_number" :placeholder="$t('store.input_max_deal_num')" />
            </el-form-item>
        </el-form>
        <template #footer>
            <el-button @click="setDialogVisible(false)">{{ $t('public.cancel') }}</el-button>
            <el-button type="primary" @click="onSubmit">
                {{ $t('public.confirm') }}
            </el-button>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import { getOtcAreaList, getOtcCurrency, getPayMethods, publishOtcOrder } from '@/api';
import { CurrencyUnit, OtcCurrency, OtcOrderParams, PayMethod } from '@/interface/otc';

const emits = defineEmits(['onSubmit'])

const [dialogVisible, setDialogVisible] = useToggle(false)

const form = reactive<OtcOrderParams>({
    way: '',
    currency_id: undefined,
    area_id: undefined,
    payways: [],
    price: '',
    total_qty: '',
    min_number: '',
    max_number: '',
    auto_start: '1'
})

const otcCurrencyList = ref<OtcCurrency[]>([])
const otcCurrencyName = ref<CurrencyUnit[]>([])
const otcPayMethods = ref<PayMethod[]>([])

getOtcCurrency().then(({ data }) => {
    otcCurrencyList.value = data;
    form.currency_id = otcCurrencyList.value[0].currency_id
})

getOtcAreaList().then(({ data }) => {
    otcCurrencyName.value = data
    form.area_id = otcCurrencyName.value[0].id
})

getPayMethods().then(({ data }) => {
    otcPayMethods.value = data
})

const onSubmit = () => {
    publishOtcOrder(form).then(() => {
        emits('onSubmit')
        setDialogVisible(false)
        form.max_number = form.min_number = form.payways = form.total_qty = undefined
    })
}

const show = (way: 'BUY' | 'SELL') => {
    form.way = way
    setDialogVisible(true)
}

defineExpose({
    show
})
</script>
