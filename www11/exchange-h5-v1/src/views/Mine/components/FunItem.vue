<template>
    <div class="flex items-center justify-between py-4">
        <div class="flex items-center">
            <svg-icon class="w-20 h-20" :name="icon" color="white" />
            <div class="ml-10">{{ label }}</div>
        </div>
        <van-icon name="arrow" size="1.2rem" color="#888" />
    </div>
</template>

<script lang="ts" setup>
defineProps<{
    icon: string,
    label: string
}>()

</script>