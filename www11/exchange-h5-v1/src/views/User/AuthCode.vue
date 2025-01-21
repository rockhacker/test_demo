<template>
    <nav-bar :title="$t('func.auth_code')" />

    <div class="mt-16 p-12">
        <div class="text-16 border-1 border-solid border-#707070 py-16 rounded-4 text-center">
            {{ $t('func.auth_code') }}: {{ code }}
        </div>

        <div class="text-12 text-center mt-12">
            {{ $t('user.auth_code_tip') }}
        </div>
    </div>
</template>

<script lang="ts" setup>
import { getAuthCode } from '@/api/user';

const code = ref<string>()

getAuthCode().then(({ data }) => {
    code.value = data
})
</script>