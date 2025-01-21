<template>
    <el-button class="w-full mt-20 h-40" color="#2fdab0" @click="onClick">
        {{ $t('public.to_login') }}
    </el-button>
</template>

<script lang="ts" setup>
const router = useRouter()

const onClick = () => {
    router.push('/login')
}
</script>