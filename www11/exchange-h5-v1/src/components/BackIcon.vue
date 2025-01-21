<template>
    <div class="bg-[#383838] rounded-13 p-6 mt-4" @click="router.go(-1)">
        <van-icon class="rotate-90 font-bold" name="down" size="1.4rem" color="#888888" />
    </div>
</template>

<script setup lang="ts">
const router = useRouter()
</script>