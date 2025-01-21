<template>
    <nav-bar :title="$t('func.invite')" />
    <div class="p-30">
        <div class="bg-#383838 m-10 rounded-10 text-center py-10"
            style="box-shadow: 0px 0px 24px 0px rgba(161, 161, 161, 0.09)">
            <div class="text-main-gray text-16 text-center">
                {{ $t("account.invite_code") }}
            </div>
            <div class="my-10 text-kline-up text-16">
                {{ user?.invite_code }}
            </div>
            <qr-code class="mx-auto" v-model="inviteLink" />

            <div class="text-center text-12 my-10 px-20">
                {{ inviteLink }}
            </div>
            <van-button class="h-36 flex-1 rounded-xl mr-8 border-0" type="primary" @click="onCopy(inviteLink)">
                {{ $t("public.copy_address") }}
            </van-button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import useCopy from '@/hooks/useCopy';
import { useUserStore } from '@/store';

const { user } = useUserStore();

const { onCopy } = useCopy()

const inviteLink = computed(() => {
    return `${window.location.origin}/#/register?invite_code=${user?.invite_code}`;
});
</script>