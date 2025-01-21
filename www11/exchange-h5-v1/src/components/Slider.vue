<template>
    <van-slider v-model="value" :barHeight="barHeight">
        <template #button>
            <div class="van-slider__button text-black text-center text-12 flex items-center justify-center">
                <div class="scale-85">
                    {{ value }}%
                </div>
            </div>
        </template>
    </van-slider>
</template>

<script lang="ts" setup>
const props = withDefaults(defineProps<{
    modelValue: number;
    barHeight?: number | string
}>(), {
    barHeight: '0.6rem'
})

const emits = defineEmits(["update:modelValue"]);

const value = useVModel(props, "modelValue", emits);
</script>