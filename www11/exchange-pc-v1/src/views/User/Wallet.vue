<template>
    <div v-if="currentAccount" class="p-10 text-14">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <span class="text-16">{{ currentAccount.name }}</span>
                <span class="text-#888 text-12 pl-10">{{ $t('user.total_assets') }}(USDT)</span>
            </div>
            <el-icon class="cursor-pointer" @click="setShowAssets(!showAssets)">
                <View v-show="showAssets" />
                <Hide v-show="!showAssets" />
            </el-icon>
        </div>
        <div class="mt-2">{{ showAssets ? currentAccount.convert_usd : '******' }}</div>

        <div class="bg-#383838 rounded-16 py-8 px-12 text-12 mt-12 cursor-pointer"
            v-for="item in currentAccount.accounts" :key="item.id" @click="toDetail(item)">
            <div class="flex items-center justify-between">
                <div class="text-16">{{ item.currency_code }}</div>
                <el-icon color="white" size="16px">
                    <ArrowRight />
                </el-icon>
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

<script setup lang="ts">
import { AccountElement } from '@/interface/user';
import { useUserStore } from '@/store';

const props = defineProps<{
    id: number
}>()

const { accountList } = storeToRefs(useUserStore())

const [showAssets, setShowAssets] = useToggle(true)

const currentAccount = computed(() => {
    return accountList.value.find((item) => item.id === props.id)
})

const router = useRouter()

const toDetail = (account: AccountElement) => {
    router.push({
        path: '/assets/record',
        query: {
            id: account.id,
            account_type_id: currentAccount.value?.id
        }
    })
}
</script>