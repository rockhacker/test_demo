<template>
    <div class="mt-12 flex items-center justify-between text-#E8EDF4 text-12">
        <div>{{ $t('trade.price') }}</div>
        <div>{{ $t('trade.quantity') }}</div>
        <div>{{ $t('trade.price') }}</div>
    </div>
    <div class="depth">
        <van-skeleton class="w-full" :loading="!sellList.length || !buyList.length">
            <template #template>
                <div class="flex justify-between w-full flex-wrap mt-2" v-for="item in new Array(5)">
                    <van-skeleton-paragraph class="h-20" row-width="49.5%" />
                    <van-skeleton-paragraph class="h-20" row-width="49.5%"/>
                </div>
            </template>
            <div class="flex text-12">
                <div class="flex-1 mr-2">
                    <div class="p-2 flex items-center justify-between relative z-99" v-for="item in sellList.slice(0, 5)"
                        :key="item.index">
                        <div class="text-down">{{ item.price }}</div>
                        <div class="text-#888">{{ item.amount }}</div>
                        <div class="absolute top-0 right-0 bottom-0 bg-down opacity-30 z--1" style="transition: 0.9s;"
                            :style="{ 'width': parseInt(((item.amount / sellMax) * 100).toString()) + '%' }" />
                    </div>
                </div>
                <div class="flex-1">
                    <div class="p-2 flex items-center justify-between relative z-99" v-for="item in buyList.slice(0, 5)"
                        :key="item.index">
                        <div class="text-#888">{{ item.amount }}</div>
                        <div class="text-up">{{ item.price }}</div>
                        <div class="absolute top-0 left-0 bottom-0 bg-up opacity-30 z--1" style="transition: 0.9s;"
                            :style="{ 'width': parseInt(((item.amount / buyMax) * 100).toString()) + '%' }" />
                    </div>
                </div>
            </div>
        </van-skeleton>
    </div>
</template>

<script lang="ts" setup>
import { OrderInfo } from '@/interface/socket';


const props = defineProps<{
    buyList: OrderInfo[],
    sellList: OrderInfo[],
}>()

const { buyList, sellList } = toRefs(props)

const buyMax = computed(() => {
    return Math.max(...buyList.value.map((item) => item.amount))
})

const sellMax = computed(() => {
    return Math.max(...sellList.value.map((item) => item.amount))
})
</script>

<style lang="scss">
.depth {
    .van-skeleton {
        padding: 0;
        display: flex;
        flex-wrap: wrap;
    }

    .van-skeleton-paragraph:not(:first-child) {
        margin-top: 0;
    }
}
</style>