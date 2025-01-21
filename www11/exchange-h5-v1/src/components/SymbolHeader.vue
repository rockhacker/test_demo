<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center" @click="setShowMatchPopup(true)">
            <svg-icon class="w-24 h-24" name="menu"></svg-icon>
            <span class="px-4 text-20 ml-4">{{ match.symbol }}</span>
            <img v-if="+match.currency_quotation.change >= 0" class="w-16 h-16" src="@images/up.png">
            <img v-else class="w-16 h-16" src="@images/down.png">
            <span class="whitespace-nowrap" :class="[+match.currency_quotation.change >= 0 ? 'text-up' : 'text-down']">
                {{ +match.currency_quotation.change >= 0 ? '+' : '' }}
                {{ match.currency_quotation.change }}%
            </span>
        </div>
        <slot name="right"></slot>
    </div>

    <!-- 切换交易对 -->
    <match-popup v-model="showMatchPopup" :type="type" @onChange="onChange" />
</template>

<script lang="ts" setup>
import { Match } from '@/interface';

const props = defineProps<{
    match: Match,
    type: 'micro' | 'lever' | 'trade'
}>()

const { match } = toRefs(props)

const [showMatchPopup, setShowMatchPopup] = useToggle(false)

const emits = defineEmits(["onChange"]);

const onChange = (oldValue: string) => {
    emits('onChange', oldValue)
}

</script>