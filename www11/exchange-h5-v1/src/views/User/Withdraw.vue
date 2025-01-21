<template>
    <nav-bar :title="$t('func.mention')" />
    <div v-for="item in coinList" :key="item.id">
        <div class="py-10 px-16 flex items-center justify-between" @click="toMention(item)">
            <div class="flex items-center">
                <img :src="item.currency.logo" class="w-40 h-40">
                <span class="pl-10">{{ item.currency.code }} {{ $t('func.mention') }}</span>
            </div>
            <van-icon name="arrow" color="#888" size="1.3rem" />
        </div>
        <van-divider />
    </div>
    <van-empty v-if="!coinList.length" :description="$t('public.no_more')" />
</template>

<script lang="ts" setup>
// import { accountDetail } from '@/api/user';
import { AccountElement } from '@/interface/user';
import { useUserStore } from '@/store';

const { getAccountData } = useUserStore()
const { accountList } = storeToRefs(useUserStore())

const router = useRouter()

const coinList = computed(() => {
    return accountList.value.find(item => item.account_code === 'change_account')?.accounts.filter((item) => item.currency.open_recharge === 1) || []
})

const toMention = async (account: AccountElement) => {
    // account_type_id: 1  1为币币账户
    // const { data } = await accountDetail({ account_type_id: 1, id: account.id })
    // data.account_type_id 
    router.push({
        path: '/user/mention',
        query: {
            currency_id: account.currency.currency_protocols[0].currency_id,
            id: account.id,
            account_type_id: 1
            // name: data.account_type_id 
        }
    })
}

getAccountData()
</script>