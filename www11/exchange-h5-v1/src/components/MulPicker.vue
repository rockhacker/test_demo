<template>
    <van-popup v-model:show="showPicker" round position="bottom">
        <van-picker :columns="columns" @cancel="showPicker = false" @confirm="onConfirm" />
    </van-popup>
</template>

<script lang="ts" setup generic="T">
import { Picker } from '@/interface';

const props = defineProps<{
    modelValue: T
    show: boolean,
    columns: Picker[]
}>()

const emits = defineEmits(["update:modelValue", "update:show"]);

const selected = useVModel(props, "modelValue", emits);
const showPicker = useVModel(props, "show", emits);

const onConfirm = ({ selectedOptions }: any) => {
    showPicker.value = false;
    selected.value = selectedOptions[0].value;
};
</script>