<template>
    <div v-if="currentLeverMatch" class="lever-submit-order pb-10">
        <el-tabs v-model="tradeMode">
            <el-tab-pane :label="$t('trade.market_trade')" :name="2" />
            <el-tab-pane :label="$t('trade.limit_trade')" :name="1" />
        </el-tabs>

        <div class="text-14">
            <span>{{ $t('public.balance') }}:</span>
            <span>{{ balance }}{{ currentLeverMatch.quote_currency_code }}</span>
        </div>

        <div class="flex mt-10" v-if="load">
            <LeverForm class="flex-1 mr-10" :multiples="multiples" :tradeMode="tradeMode" :balance="balance" is-buy
                @on-submit="emits('onRefresh')" />
            <LeverForm class="flex-1 ml-10" :multiples="multiples" :tradeMode="tradeMode" :balance="balance"
                @on-submit="emits('onRefresh')" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useMarketStore, useUserStore } from '@/store';
import useLever from '../hooks/useLever';
import LeverForm from './LeverForm.vue'

const { isLogin } = storeToRefs(useUserStore())
const { currentLeverMatch } = storeToRefs(useMarketStore())

const emits = defineEmits(['onRefresh'])

const tradeMode = ref(2)
const { multiple, multiples, balance, getBaseData, myTransaction, load } = useLever()

onMounted(() => {
    if (isLogin.value) {
        getBaseData()
    }
})

defineExpose({
    getBaseData
})
</script>

<style lang="scss">
.lever-submit-order {
    background-color: #1d1e1e;
    padding: 0 20px;

    .el-tabs {
        --el-tabs-header-height: 52px !important;
    }
}
</style>