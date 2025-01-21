<template>
  <img v-if="showLogo" :onerror="setShowLogo(false)" :src="logo" class="w-auto cursor-pointer"
    @click="router.push('/')" />
  <div v-else class="text-18 leading-50 app-title cursor-pointer" @click="router.push('/')">{{ title }}</div>
</template>

<script setup lang="ts">
import { useAppStore } from '@/store';

const logo = '/logo.png'

const { title } = storeToRefs(useAppStore())

const [showLogo, setShowLogo] = useToggle(true)

const router = useRouter()
</script>

<style lang="scss" scoped>
.app-title {
  color: var(--el-menu-text-color);
}
</style>
