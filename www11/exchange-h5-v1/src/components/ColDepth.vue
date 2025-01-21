<template>
    <div class="z-99">
        <div class="flex items-center justify-between text-#E8EDF4 text-12">
            <div>{{ $t('trade.price') }}</div>
            <div>{{ $t('trade.quantity') }}</div>
        </div>
        <div class="depth">
            <van-skeleton class="w-full" :loading="!sellList.length || !buyList.length">
                <template #template>
                    <van-skeleton-paragraph class="h-20 mt-2" v-for="item in new Array(10)" />
                </template>
                <div class="text-12">
                    <div class="p-2 flex items-center justify-between relative z-99 mt-1" v-for="item in sell"
                        :key="item.index">
                        <div class="text-down">{{ item.price }}</div>
                        <div class="text-#888">{{ item.amount }}</div>
                        <div class="absolute top-0 right-0 bottom-0 bg-down opacity-30 z--1" style="transition: 0.9s;"
                            :style="{ 'width': parseInt(((item.amount / sellMax) * 100).toString()) + '%' }" />
                    </div>
                </div>
                <div class="my-2 text-16 font-bold"
                    :class="[+match.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
                    {{ match.currency_quotation.close }}
                </div>
                <div class="text-12">
                    <div class="p-2 flex items-center justify-between relative z-99 mt-1" v-for="item in buy"
                        :key="item.index">
                        <div class="text-up">{{ item.price }}</div>
                        <div class="text-#888">{{ item.amount }}</div>
                        <div class="absolute top-0 right-0 bottom-0 bg-up opacity-30 z--1" style="transition: 0.9s;"
                            :style="{ 'width': parseInt(((item.amount / buyMax) * 100).toString()) + '%' }" />
                    </div>
                </div>
                <div class="flex justify-around mt-4">
                    <svg-icon class="w-14 h-14 bg-black px-12 py-5 rounded-6" name="default-depth" @click="onClick(0)" />
                    <svg-icon class="w-14 h-14 bg-black px-12 py-5 rounded-6 mx-6" name="sell-depth" @click="onClick(1)" />
                    <svg-icon class="w-14 h-14 bg-black px-12 py-5 rounded-6" name="buy-depth" @click="onClick(2)" />
                </div>
            </van-skeleton>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Match } from '@/interface/market';
import { OrderInfo } from '@/interface/socket';


const props = defineProps<{
    match: Match,
    buyList: OrderInfo[],
    sellList: OrderInfo[],
}>()

const { match, buyList, sellList } = toRefs(props)

const buyMax = computed(() => {
    return Math.max(...buyList.value.map((item) => item.amount))
})

const sellMax = computed(() => {
    return Math.max(...sellList.value.map((item) => item.amount))
})

const type = ref(0) // 0 -> 默认 1 -> sell 2-> buy 

const onClick = (val: number) => {
    type.value = val;
}

const sell = computed(() => {
    if (type.value === 0) {
        return sellList.value.slice(0, 5)
    }
    else if (type.value === 1) {
        return sellList.value.slice(0, 10)
    }
    return []
})


const buy = computed(() => {
    if (type.value === 0) {
        return buyList.value.slice(0, 5)
    }
    else if (type.value === 1) {
        return []
    }
    return buyList.value.slice(0, 10)
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