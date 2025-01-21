<template>
    <nav-bar :title="$t('func.safe_center')" />

    <div class="text-14">
        <template v-if="!isWallet">
            <div class="py-10 px-16 flex items-center justify-between mt-10" @click="router.push('/user/reset-login')">
                <div>{{ $t('user.login_password') }}</div>
                <div class="flex items-center">
                    <span class="pr-4">{{ $t('public.modify') }}</span>
                    <van-icon name="arrow" color="#888" size="1.3rem" />
                </div>
            </div>
            <van-divider />
        </template>

        <div class="py-10 px-16 flex items-center justify-between" @click="router.push('/user/reset-trade')">
            <div>{{ $t('trade.trade_password') }}</div>
            <div class="flex items-center">
                <span class="pr-4">{{ $t('public.modify') }}</span>
                <van-icon name="arrow" color="#888" size="1.3rem" />
            </div>
        </div>
        <van-divider />
    </div>
</template>

<script lang="ts" setup>
import { useUserStore } from '@/store';
import { template } from 'lodash-es';

const router = useRouter()

const { isWallet } = storeToRefs(useUserStore())
</script>