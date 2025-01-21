<template>
    <div class="p-12 pb-120">
        <symbol-header :match="currentTradeMatch!" type="trade" @onChange="changeMatch">
            <template #right>
                <div class="flex items-center">
                    <svg-icon class="w-24 h-24 p-8" color="#888" name="kline" @click="router.push('/kline?type=trade')" />
                </div>
            </template>
        </symbol-header>
        <van-pull-refresh v-model="refreshing" @refresh="onRefresh">
            <div class="flex items-center justify-between mt-12">
                <div class="text-20" :class="[isUp ? 'text-up' : 'text-down']">
                    {{ currentTradeMatch?.currency_quotation.close }}
                </div>
                <!-- <div class="text-#888 text-14">
                    {{ $t('trade.new_deal') }}>>
                </div> -->
            </div>
            <!-- 交易深度 -->
            <row-depth :sellList="sellList" :buyList="buyList" />


            <submit-order ref="SubmitOrderRef" v-model:tradeType="tradeType" @refresh="onRefresh" />

            <template v-if="isLogin">
                <div class="flex items-center justify-between mt-12">
                    <div class="text-18">
                        {{ $t('trade.current_delegate') }}
                    </div>
                    <div class="text-#888 text-14" @click="router.push('/coin/entrust')">
                        {{ $t('public.load_more') }}>>
                    </div>
                </div>

                <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')"
                    @load="onLoad">
                    <tx-order-item v-for="item in txOrder" :key="item.id" :order="item" @order-close="onRefresh" />
                </van-list>
            </template>
        </van-pull-refresh>



    </div>
</template>

<script lang="ts" setup name="coin">
import TxOrderItem from './components/TxOrderItem.vue';
import SubmitOrder from './components/SubmitOrder.vue'
import { TxMatched } from '@/interface/socket';
import { useMarketStore, useUserStore, useWebsocketStore } from '@/store';
import useTxOrder from './hooks/useTxOrder'
import useDepth from '@/hooks/useDepth';
const { currentTradeMatch } = storeToRefs(useMarketStore())
const { addListener, removeListener } = useWebsocketStore()
const { isLogin } = storeToRefs(useUserStore())

const SubmitOrderRef = ref()

const router = useRouter()

const isUp = computed(() => {
    if (!currentTradeMatch.value) return true
    return (+currentTradeMatch.value.currency_quotation.change >= 0)
})

const { refreshing, loading, finished, onRefresh, onLoad, tradeType, txOrder, subscribe } = useTxOrder(true)

const { sellList, buyList, startDepth, stopDepth } = useDepth()





const changeMatch = () => {
    stopDepth()
    startDepth(currentTradeMatch.value!.symbol)
    SubmitOrderRef.value.getBalance()
}

onActivated(() => {
    startDepth(currentTradeMatch.value!.symbol)
    if (isLogin.value) {
        subscribe()
    }
})
</script>
