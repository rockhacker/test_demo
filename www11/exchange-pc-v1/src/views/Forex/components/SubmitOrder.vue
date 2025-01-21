<template>
    <div v-if="getCurrentTradeItem" class="forex-submit-order pb-10">
        <el-tabs v-model="tradeMode">
            <el-tab-pane :label="$t('trade.market_trade')" :name="2" />
            <el-tab-pane :label="$t('trade.limit_trade')" :name="1" />
        </el-tabs>

        <div class="text-14">
            <span>{{ $t('public.balance') }}:</span>
            <span>{{ balance }} USD</span>
        </div>

        <div class="flex mt-10">
            <ForexForm class="flex-1 mr-10" :tradeMode="tradeMode" :balance="balance" is-buy @on-submit="onSubmit" />
            <ForexForm class="flex-1 ml-10" :tradeMode="tradeMode" :balance="balance" @on-submit="onSubmit" />
        </div>
    </div>
</template>
<script lang="ts" setup>
import { getForexDeal } from '@/api/forex';
import { useForexStore, useUserStore } from '@/store';
import ForexForm from './ForexForm.vue'

const { getCurrentTradeItem } = storeToRefs(useForexStore())
const { isLogin } = storeToRefs(useUserStore())

const balance = ref(0)

const tradeMode = ref(2)

const emits = defineEmits(['onRefresh'])

const getBaseData = () => {
    getForexDeal({ forex_id: getCurrentTradeItem.value!.Id })
        .then(({ data }) => {
            balance.value = data.forex_user_balance
        })
}

const onSubmit = () => {
    getBaseData()
    emits('onRefresh')
}

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
.forex-submit-order {
    background-color: #1d1e1e;
    padding: 0 20px;

    .el-tabs {
        --el-tabs-header-height: 52px !important;
    }
}
</style>