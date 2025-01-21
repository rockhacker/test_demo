<template>
    <van-button class="rounded-12 text-16" color="#2fdab0" block @click="onClick">
        {{ $t('public.to_login') }}
    </van-button>
</template>

<script lang="ts" setup>
const router = useRouter()

const onClick = () => {
    router.push('/login')
}
</script>