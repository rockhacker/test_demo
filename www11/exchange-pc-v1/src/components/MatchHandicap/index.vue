<template>
    <div class="match-handicap">
        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane :label="$t('match.handicap')" name="first">
                <div class="flex items-center text-14 text-#888888 mb-2">
                    <div class="flex-1">{{ $t('match.direction') }}</div>
                    <div class="flex-1 text-center">{{ $t('trade.single_price') }}</div>
                    <div class="flex-1 text-right">{{ $t('trade.quantity') }}</div>
                </div>
                <div class="p-2 flex items-center justify-between relative z-99 text-14 mb-2"
                    v-for="(item, index) in sellList" :key="item.index">
                    <div class="flex-1">{{ $t('trade.sell') }}{{ sellList.length - index }}</div>
                    <div class="flex-1 text-center text-down">{{ item.price }}</div>
                    <div class="flex-1 text-right">{{ item.amount }}</div>
                    <div class="absolute top-0 right-0 bottom-0 bg-down opacity-30 z--1" style="transition: 0.9s;"
                        :style="{ 'width': parseInt(((item.amount / sellMax) * 100).toString()) + '%' }" />
                </div>
                <div class="text-24 my-6 flex items-center"
                    :class="[+match!.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
                    <span>{{ match.currency_quotation.close }}</span>
                    <img v-if="+match.currency_quotation.change >= 0" class="w-20 h-20" src="@images/up.png">
                    <img v-else class="w-20 h-20" src="@images/down.png">
                </div>
                <div class="p-2 flex items-center justify-between relative z-99 text-14 mb-2"
                    v-for="(item, index) in buyList" :key="item.index">
                    <div class="flex-1">{{ $t('trade.buy') }}{{ index + 1 }}</div>
                    <div class="flex-1 text-center text-up">{{ item.price }}</div>
                    <div class="flex-1 text-right">{{ item.amount }}</div>
                    <div class="absolute top-0 left-0 bottom-0 bg-up opacity-30 z--1" style="transition: 0.9s;"
                        :style="{ 'width': parseInt(((item.amount / buyMax) * 100).toString()) + '%' }" />
                </div>
            </el-tab-pane>
            <el-tab-pane :label="$t('match.all_transaction')" name="second">
                <div class="flex text-14 text-#888888 mb-2">
                    <div class="flex-1">{{ $t('trade.time') }}</div>
                    <div class="flex-1 text-center">{{ $t('trade.single_price') }}({{ match.quote_currency_code }})
                    </div>
                    <div class="flex-1 text-right">{{ $t('legal.amount') }}({{ match.base_currency_code }})</div>
                </div>

                <div class="flex text-14 text-white mb-2" v-for="item in globalList">
                    <div class="flex-1">{{ item.time }}</div>
                    <div class="flex-1 text-center" :class="[item.way === 2 ? 'text-up' : 'text-down']">{{ item.price }}
                    </div>
                    <div class="flex-1 text-right">{{ item.amount }}</div>
                </div>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>
<script lang="ts" setup>
import type { TabsPaneContext } from 'element-plus'
import { OrderInfo, TxComplete } from '@/interface/socket';
import { Match } from '@/interface';

const props = defineProps<{
    buyList: OrderInfo[],
    sellList: OrderInfo[],
    globalList: TxComplete[]
    match: Match
}>()

const { buyList, sellList } = toRefs(props)

const buyMax = computed(() => {
    return Math.max(...buyList.value.map((item) => item.amount))
})

const sellMax = computed(() => {
    return Math.max(...sellList.value.map((item) => item.amount))
})

const activeName = ref('first')

const handleClick = (tab: TabsPaneContext, event: Event) => {
    console.log(tab, event)
}
</script>
<style lang="scss">
.match-handicap {
    .el-tabs {
        --el-tabs-header-height: 52px !important;
    }

    .el-tabs__header {
        padding: 0 24px;
        background-color: #1d1e1e;
    }
}
</style>