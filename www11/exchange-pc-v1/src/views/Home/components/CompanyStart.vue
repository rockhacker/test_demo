<template>
    <div class="text-30 mt-20">{{ $t('company.d3') }}</div>
    <div class="text-20 mt-20 text-dark">{{ $t('company.d4') }}</div>
    <div class="mt-30">
        <el-button color="#19FC8F" class="min-w-200 rounded-4 h-40" @click="router.push('/login')">
            {{ $t('account.login') }}
        </el-button>
        <el-button color="#505257" class="min-w-200 rounded-4 h-40" @click="router.push('/register')">
            {{ $t('account.register') }}
        </el-button>
    </div>
</template>

<script setup lang="ts">
const router = useRouter()
</script>