<template>
    <div v-if="seller">
        <div class="max-w-[1200px] text-13 mx-auto mt-20 w-full flex flex-col text-white">
            <el-card class="w-full text-white" shadow="hover">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div
                            class="w-50 h-50 flex flex-col text-18 justify-center items-center rounded-50% bg-main-liner">
                            {{ seller.name.substr(0, 1) }}
                        </div>
                        <div class="pl-10">
                            <span>{{ seller.name }}</span>
                            <div>
                                <span>{{ $t('store.register_time') }}</span>
                                <span class="mt5">{{ seller.created_at }}</span>
                            </div>
                        </div>
                    </div>
                    <el-button @click="SubmitOrderRef.show(type)">
                        {{ $t('store.publish') }}
                    </el-button>
                </div>
            </el-card>

            <el-card class="w-full mt-20" shadow="hover">
                <el-tabs v-model="type">
                    <el-tab-pane :label="$t('store.my_buy')" name="BUY">
                        <OrderList ref="BuyOrderListRef" way="BUY" />
                    </el-tab-pane>
                    <el-tab-pane :label="$t('store.my_sell')" name="SELL">
                        <OrderList ref="SellOrderListRef" way="SELL" />
                    </el-tab-pane>
                </el-tabs>
            </el-card>
        </div>
    </div>

    <SubmitOrder ref="SubmitOrderRef" @on-submit="onRefresh" />
</template>

<script lang="ts" setup>
import { useUserStore } from '@/store';
import OrderList from './components/OrderList.vue';
import SubmitOrder from './components/SubmitOrder.vue';

const { user } = storeToRefs(useUserStore())

const BuyOrderListRef = ref()
const SellOrderListRef = ref()
const SubmitOrderRef = ref()

const seller = computed(() => {
    return user.value?.seller
})

const type = ref('BUY')

const onRefresh = () => {
    type.value === 'BUY' ? BuyOrderListRef.value.onRefresh() : SellOrderListRef.value.onRefresh()
}

// const handleOrderType = () => {
//     onRefresh()
// }
</script>
