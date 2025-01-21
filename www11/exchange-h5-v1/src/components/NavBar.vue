<template>
    <van-nav-bar :title="title">
        <template #left>
            <back-icon />
        </template>
        <template #right>
            <slot name="right" />
        </template>
    </van-nav-bar>
</template>

<script lang="ts" setup>
defineProps<{
    title?: string
}>()
</script>