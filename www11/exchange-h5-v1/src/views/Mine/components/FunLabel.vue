<template>
    <div class="flex flex-col items-center justify-center">
        <svg-icon class="p-6 w-30 h-30 rounded-16 bg-#6C7166" :name="icon" color="white" />
        <div class="mt-4">{{ label }}</div>
    </div>
</template>

<script lang="ts" setup>
defineProps<{
    icon: string,
    label: string
}>()
</script>