<template>
    <van-popup v-model:show="showPicker" round position="bottom">
        <van-picker :columns="columns" @cancel="showPicker = false" @confirm="onConfirm" />
    </van-popup>
</template>

<script lang="ts" setup>
import { useI18n } from 'vue-i18n';


const props = defineProps<{
    modelValue: number
    show: boolean
}>()

const emits = defineEmits(["update:modelValue", "update:show"]);

const tradeMode = useVModel(props, "modelValue", emits);
const showPicker = useVModel(props, "show", emits);

const { t } = useI18n()

const columns = [
    { text: t('trade.limit_price'), value: 1 },
    { text: t('trade.market_price'), value: 2 },
];
const fieldValue = ref('');

const onConfirm = ({ selectedOptions }: any) => {
    showPicker.value = false;
    tradeMode.value = selectedOptions[0].value;
};
</script>