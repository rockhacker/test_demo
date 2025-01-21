<template>
    <van-popup v-model:show="value" round class="p-60">
        <van-circle v-model:current-rate="currentRate" :rate="rate" :color="gradientColor" :text="text" :stroke-width="100"
            :size="150" :speed="speed" />
    </van-popup>
</template>

<script setup lang="ts">

const props = defineProps<{
    modelValue: boolean;
    total: number;
    remain: number; // 毫秒级别
}>()

const second = props.remain  //  /1000 // 毫秒 -> 秒

const currentRate = ref(ref(100 - (second / props.total * 100)));
const rate = ref(100 - (second / props.total * 100));
const speed = 100 / props.total

const result = ref(second)

const text = computed(() => {
    return `${result.value}s`
})


if (rate.value < 100) {
    let timer = setInterval(() => {
        rate.value = rate.value + speed
        result.value--

        if (rate.value >= 100 || result.value === 0) {
            rate.value = 100
            clearInterval(timer)
        }
    }, 1000)
}

const emits = defineEmits(["update:modelValue"]);

const value = useVModel(props, "modelValue", emits);

const gradientColor = {
    '100%': '#FDF00C',
    '0%': '#9FEF4E',
};
</script>