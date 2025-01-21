<template>
    <div class="pb-120">
        <van-nav-bar>
            <template #title>
                <div class="flex items-center" @click="setShowPicker(true)">
                    <span class="text-main text-18">{{ title }}</span>
                    <svg-icon class="w-20 h-20 p-4 ml-4" name="switch" color="#888"></svg-icon>
                </div>
            </template>
        </van-nav-bar>

        <trade-type-option v-model="currentMarket" v-model:show="showPicker" />

        <div class="px-12">
            <Micro v-if="currentMarket === 1" ref="MicroRef" />
            <Lever v-else-if="currentMarket === 2" ref="LeverRef" />
            <Forex v-else-if="currentMarket === 3" ref="ForexRef" />
        </div>
    </div>
</template>

<script lang="ts" setup name="trade">
import { useI18n } from "vue-i18n";
import TradeTypeOption from "./components/TradeTypeOption.vue";
import Micro from "./Micro.vue";
import Lever from "./Lever.vue"
import Forex from "./Forex.vue";
import { useMarketStore } from "@/store";

const [showPicker, setShowPicker] = useToggle(false)

const { currentMarket } = storeToRefs(useMarketStore())

const { t } = useI18n()

const title = computed(() => {
    switch (currentMarket.value) {
        case 1:
            return t('trade.delivery_contract')
        case 2:
            return t('trade.lever_contract')
        case 3:
            return t('trade.block_trading')
    }
})

const MicroRef = ref<InstanceType<typeof Micro>>()
const LeverRef = ref<InstanceType<typeof Lever>>()
const ForexRef = ref<InstanceType<typeof Forex>>()

const [isMounted, setMounted] = useToggle()

onMounted(() => {
    nextTick(() => {
        setMounted(true)
    })
})

onActivated(() => {
    if (!isMounted.value) return
    nextTick(() => {
        if (currentMarket.value === 1) {
            MicroRef.value?.init()
            return
        }
        if (currentMarket.value === 2) {
            LeverRef.value?.init()
            return
        }
        if (currentMarket.value === 3) {
            ForexRef.value?.init()
            return
        }
    })
})
</script>