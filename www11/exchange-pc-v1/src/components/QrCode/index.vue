<template>
    <QrcodeVue :value="props.modelValue" :size="props.size" level="H" />
</template>

<script lang="ts" setup>
import QrcodeVue from "qrcode.vue";

const props = withDefaults(defineProps<{
    modelValue: string,
    size?: number
}>(), {
    size: 200
})
</script>