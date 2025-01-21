<template>
    <svg class="svg-icon" aria-hidden="true" :style="{color: props.color}">
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
    //   size: {
    //     type: String,
    //     default: "1em",
    //   },
});

const symbolId = computed(() => `#${props.prefix}-${props.name}`);
</script>
  
<style lang="scss">
.svg-icon {
    box-sizing: content-box;
}
</style>
  