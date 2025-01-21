<template>
    <div class="bg-#393A38 flex rounded-8 h-38 leading-38 overflow-hidden text-14">
        <div class="flex-1 text-center relative" :class="{ 'bg-up': isBuy }" @click="isBuy = true">
            {{ $t('trade.buy_in') }}
            <div class="top-0 absolute right-0 bottom-0 z-99" :class="{ 'triangle-right': isBuy }" />
        </div>
        <div class="flex-1 text-center relative" :class="{ 'bg-down': !isBuy }" @click="isBuy = false">
            {{ $t('trade.sell_out') }}
            <div class="top-0 absolute left-0 bottom-0 z-99" :class="{ 'triangle-left': !isBuy }" />
        </div>
    </div>
</template>

<script lang="ts" setup>
const props = defineProps<{
    modelValue: boolean;
}>()

const emits = defineEmits(["update:modelValue"]);

const isBuy = useVModel(props, "modelValue", emits);
</script>

<style lang="scss">
.triangle-right {
    border-top: 20px solid #393A38;
    border-left: 20px solid transparent;
    border-bottom: 20px solid #393A38;
}

.triangle-left {
    border-top: 20px solid #393A38;
    border-right: 20px solid transparent;
    border-bottom: 20px solid #393A38;
}
</style>