<template>
    <div>
        <Logo />

        <div class="text-center text-white mt-80">©Copyright 2017 {{ title }}. All rights reserved.</div>
    </div>
</template>

<script lang="ts" setup>
import Logo from '@/components/Logo/index.vue'
import { useAppStore } from '@/store';

const { title } = storeToRefs(useAppStore())
</script>