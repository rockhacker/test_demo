<template>
    <div v-loading="loading" class="assets-detail">
        <template v-if="accountList.length">
            <el-radio-group v-model="id">
                <el-radio-button v-for="item in accountList" :label="item.name" :value="item.id" />
            </el-radio-group>
            <Wallet v-if="id" :id="id" />
        </template>
    </div>
</template>

<script lang="ts" setup>
import Wallet from './Wallet.vue';
import { useUserStore } from '@/store';

const { accountList } = storeToRefs(useUserStore())
const { getAccountData } = useUserStore()

const [loading, setLoading] = useToggle(true)

const id = ref<number>()

onMounted(async () => {
    await getAccountData().catch(() => { })
    setLoading(false)
    id.value = accountList.value[0].id
}) 
</script>