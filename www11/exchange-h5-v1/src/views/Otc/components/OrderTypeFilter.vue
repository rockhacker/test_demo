<template>
    <van-popup v-model:show="show" round position="bottom">
        <div class="p-20 text-14">
            <div>
                {{ $t('legal.trade_type') }}
            </div>
            <div class="grid grid-cols-3 gap-8 mt-6">
                <div v-for="item in typeList" class="text-center py-4 rounded-6"
                    :class="[activeWay === item.value ? 'bg-up' : 'bg-#888']" @click="setWay(item.value)">
                    {{ item.label }}
                </div>
            </div>

            <div class="mt-12">
                {{ $t('legal.order_status') }}
            </div>
            <div class="grid grid-cols-3 gap-8 mt-6">
                <div v-for="item in statusList" class="text-center py-4 rounded-6"
                    :class="[activeStatus === item.value ? 'bg-up' : 'bg-#888']" @click="setStatus(item.value)">
                    {{ item.label }}
                </div>
            </div>

            <van-divider class="my-16" />

            <div class="flex justify-between items-center">
                <van-button class="w-[48%] rounded-8" color="#999" @click="onReset">
                    {{ $t('public.reset') }}
                </van-button>
                <van-button class="w-[48%] rounded-8" color="#2fdab0" @click="onConfirm">
                    {{ $t('public.confirm') }}
                </van-button>
            </div>
        </div>
    </van-popup>
</template>

<script lang="ts" setup>
import { useOrderStatus } from '../hooks';

const props = defineProps<{
    modelValue: boolean
    way?: string
    status?: number
}>();

const emits = defineEmits(["update:modelValue", "update:way", "update:status", "onChange"]);

const show = useVModel(props, "modelValue", emits);
const way = useVModel(props, "way", emits);
const status = useVModel(props, "status", emits);

const activeWay = ref(props.way)
const activeStatus = ref(props.status)

const { typeList, statusList } = useOrderStatus()

const setWay = (value: string) => {
    if (value === activeWay.value) return activeWay.value = undefined
    activeWay.value = value
}

const setStatus = (value: number) => {
    if (value === activeStatus.value) return activeStatus.value = undefined
    activeStatus.value = value
}

const onReset = () => {
    status.value = way.value = activeWay.value = activeStatus.value = undefined
    emits('onChange')
    show.value = false
}

const onConfirm = () => {
    status.value = activeStatus.value
    way.value = activeWay.value
    emits('onChange')
    show.value = false
}

</script>