<template>
    <svg class="svg-icon" aria-hidden="true" :style="{ color: props.color, height: props.height, width: props.width }">
        <use :xlink:href="symbolId" :fill="props.color" />
    </svg>
</template>

<script lang="ts" setup>
const props = defineProps({
    prefix: {
        type: String,
        default: "icon",
    },
    name: {
        type: String,
        required: true,
    },
    color: {
        type: String,
        default: "#888",
    },
    height: {
        type: String,
        default: "10px",
    },
    width: {
        type: String,
        default: "10px",
    },
});

const symbolId = computed(() => `#${props.prefix}-${props.name}`);
</script>

<style lang="scss">
.svg-icon {
    box-sizing: content-box;
}
</style>