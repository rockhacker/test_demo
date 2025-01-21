<template>
    <nav-bar :title="$t('func.my_assets')" />

    <div class="mt-4">
        <van-tabs v-model:active="accountId" line-width="40px" line-height="3px" swipe-threshold=1 title-active-color="#9fef4e">
            <van-tab v-for="item in accountList" :title="item.name" :name="item.id" />
        </van-tabs>
    </div>

    <div v-if="currentAccount" class="p-10 text-14">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <span class="text-16">{{ currentAccount.name }}</span>
                <span class="text-#888 text-12 pl-10">{{ $t('user.total_assets') }}(USDT)</span>
            </div>
            <van-icon class="p-6" :name="showAssets ? 'eye-o' : 'closed-eye'" size="1.4rem"
                @click="setShowAssets(!showAssets)" />
        </div>
        <div class="mt-2">{{ showAssets ? currentAccount.convert_usd : '******' }}</div>

        <div class="bg-#383838 rounded-16 py-8 px-12 text-12 mt-12" v-for="item in currentAccount.accounts" :key="item.id"
            @click="toDetail(item)">
            <div class="flex items-center justify-between">
                <div class="text-16">{{ item.currency_code }}</div>
                <van-icon name="arrow" size="1.2rem" color="#888" />
            </div>
            <div class="flex items-center mt-4">
                <div class="flex-1">
                    <div class="text-#888">{{ $t('public.available') }}</div>
                    <div>{{ showAssets ? item.balance : '******' }}</div>
                </div>
                <div class="flex-1">
                    <div class="text-#888">{{ $t('user.amount_to') }}(USDT)</div>
                    <div>{{ showAssets ? item.convert_usd : '******' }}</div>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-#888">{{ $t('user.audit') }}</div>
                <div>{{ showAssets ? item.lock_balance : '******' }}</div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { AccountElement } from '@/interface/user';
import { useUserStore } from '@/store';

const router = useRouter()

const { accountList } = storeToRefs(useUserStore())
const { getAccountData } = useUserStore()

const [showAssets, setShowAssets] = useToggle(true)

const accountId = ref<number>()

const currentAccount = computed(() => {
    return accountList.value.find((item) => item.id === accountId.value)
})

const toDetail = (account: AccountElement) => {
    router.push({
        path: '/user/assets-detail',
        query: {
            id: account.id,
            account_type_id: currentAccount.value?.id
        }
    })
}

getAccountData().then(() => {
    accountId.value = accountList.value[0].id
})
</script>