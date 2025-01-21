<template>
    <div class="flex items-center justify-between text-14 mt-12 px-4">
        <div class="text-[#888]">{{ $t('user.micro_account') }}</div>
        <div>{{ balanceLabel }}</div>
    </div>
</template>

<script lang="ts" setup>
const props = defineProps<{
    balanceLabel: string
}>()

const { balanceLabel } = toRefs(props)
</script>