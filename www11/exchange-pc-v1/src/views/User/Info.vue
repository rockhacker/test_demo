<template>
    <div v-if="user">
        <div class="flex items-center">
            <el-icon color="white" size="80px">
                <UserFilled />
            </el-icon>
            <div class="ml-10 flex-1">
                <div class="flex items-center justify-between w-45%">
                    <div>
                        <span>{{ $t('user.account_safe_level') }}</span>
                        <span class="pl-6">{{ level }}</span>
                    </div>
                    <div>
                        <div>{{ user.level }}</div>
                        <div>{{ $t('user.credit') }}: {{ user.credit_score }}</div>
                    </div>
                </div>
                <el-progress class="mt-10" :percentage="percentage" :format="() => ''" />
            </div>
        </div>
        <div>
            <el-divider />
            <div class="flex items-center justify-between">
                <div>{{ $t('user.my_invite_code') }}</div>
                <div>{{ user.invite_code }}</div>
                <el-icon class="cursor-pointer" size="24px" color="white" @click="onCopy(user!.invite_code)">
                    <CopyDocument />
                </el-icon>
            </div>
            <el-divider />
            <div class="flex items-center justify-between">
                <div>{{ $t('user.my_invite_link') }}</div>
                <div>{{ inviteLink }}</div>
                <el-icon class="cursor-pointer" size="24px" color="white" @click="onCopy(inviteLink)">
                    <CopyDocument />
                </el-icon>
            </div>
            <el-divider />
            <div class="flex items-center justify-between">
                <div>{{ $t('user.bind_email') }}</div>
                <div>{{ user.email }}</div>
                <el-icon class="cursor-pointer" size="24px" color="white" @click="onCopy(user!.email)">
                    <CopyDocument />
                </el-icon>
            </div>
            <el-divider />
            <div class="flex items-center justify-between">
                <div>{{ $t('func.auth_code') }}</div>
                <div>{{ authCode }}</div>
                <el-icon class="cursor-pointer" size="24px" color="white" @click="onCopy(authCode)">
                    <CopyDocument />
                </el-icon>
            </div>
            <el-divider />
            <div class="flex items-center justify-between">
                <div>{{ $t('user.login_password') }}</div>
                <div>{{ $t('user.modify_password') }}</div>
                <el-icon color="white" size="24px" class="cursor-pointer" @click="router.push('/user/login-password')">
                    <ArrowRight />
                </el-icon>
            </div>
            <el-divider />
            <div class="flex items-center justify-between">
                <div>{{ $t('trade.trade_password') }}</div>
                <div>{{ $t('user.set_trade_password') }}</div>
                <el-icon color="white" size="24px" class="cursor-pointer" @click="router.push('/user/trade-password')">
                    <ArrowRight />
                </el-icon>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { getAuthCode } from '@/api';
import useCopy from '@/hooks/useCopy';
import { useUserStore } from '@/store';
import { useI18n } from 'vue-i18n';

const { user } = storeToRefs(useUserStore())
const router = useRouter()

const authCode = ref('')

const { onCopy } = useCopy()

const { t } = useI18n()

const percentage = ref(25)

if (user.value?.mobile) percentage.value += 25
if (user.value?.email) percentage.value += 25
// if (user.value.review_status) progress.value += 25

const level = computed(() => {
    if (percentage.value === 25) {
        return t('public.low')
    }
    if (percentage.value === 50) {
        return t('public.middle')
    }
    if (percentage.value === 75) {
        return t('public.high')
    }
    return t('public.strong')
})

const inviteLink = computed(() => {
    return `${window.location.origin}/#/register?extension_code=${user.value?.invite_code}`;
})

getAuthCode().then(({ data }) => {
    authCode.value = data
})
</script>