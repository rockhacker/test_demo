<template>
    <div class="flex flex-col text-white rounded-4 items-center justify-center py-24 bg-#2fdab0">
        <div class="text-22 mb-10">{{ $t('user.micro_account') }}</div>
        <div>{{ balanceLabel }}</div>
    </div>
</template>

<script lang="ts" setup>
const props = defineProps<{
    balanceLabel: string
}>()

const { balanceLabel } = toRefs(props)
</script>