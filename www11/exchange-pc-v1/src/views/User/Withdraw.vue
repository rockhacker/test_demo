<template>
    <div v-for="item in coinList" :key="item.id">
        <div class="py-10 px-16 flex items-center justify-between cursor-pointer" @click="toMention(item)">
            <div class="flex items-center">
                <img :src="item.currency.logo" class="w-40 h-40">
                <span class="pl-10">{{ item.currency.code }} {{ $t('func.mention') }}</span>
            </div>
            <el-icon color="white" size="24px">
                <ArrowRight />
            </el-icon>
        </div>
        <el-divider class="my-1" />
    </div>
    <Empty v-if="!coinList.length" />
</template>

<script lang="ts" setup>
import { AccountElement } from '@/interface/user';
import useWithdraw from './hooks/useWithdraw';

const router = useRouter()

const { coinList } = useWithdraw()

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

</script>