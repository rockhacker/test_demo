<template>
    <van-popup v-model:show="showPicker" closeable round position="bottom">
        <div class="py-40 px-20">
            <van-radio-group v-model="mode" shape="square" @change="showPicker = false">
                <van-radio label-position="left" class="flex items-center justify-between mt-10" :name="1">
                    <div class="flex items-center">
                        <svg-icon class="bg-#232323 p-10 rounded-12 w-32 h30" name="micro" />
                        <div class="ml-16 text-white">
                            <div class="font-700">{{ $t('trade.delivery_contract') }}</div>
                            <div class="text-14 mt-6 text-#888">{{ $t('desc.use_coin_trade') }}</div>
                        </div>
                    </div>
                    <template #icon="props">
                        <svg-icon color="#2fdab0" :name="props.checked ? 'selected' : ''" class="w-34 h-34" />
                    </template>
                </van-radio>

                <van-radio label-position="left" class="flex items-center justify-between mt-20" :name="2">
                    <div class="flex items-center">
                        <svg-icon class="bg-#232323 p-10 rounded-12 w-32 h30" name="lever" />
                        <div class="ml-16 text-white">
                            <div class="font-700">{{ $t('trade.lever_contract') }}</div>
                            <div class="text-14 mt-6 text-#888">{{ $t('desc.use_usdt') }}</div>
                        </div>
                    </div>
                    <template #icon="props">
                        <svg-icon color="#2fdab0" :name="props.checked ? 'selected' : ''" class="w-34 h-34" />
                    </template>
                </van-radio>

                <van-radio label-position="left" class="flex items-center justify-between mt-20" :name="3">
                    <div class="flex items-center">
                        <svg-icon class="bg-#232323 p-10 rounded-12 w-32 h30" name="fx" />
                        <div class="ml-16 text-white">
                            <div class="font-700">
                                {{ $t('trade.block_trading') }}
                            </div>
                            <div class="text-14 mt-6 text-#888">Forex, Crude Oil, Indices</div>
                        </div>
                    </div>
                    <template #icon="props">
                        <svg-icon color="#2fdab0" :name="props.checked ? 'selected' : ''" class="w-34 h-34" />
                    </template>
                </van-radio>

            </van-radio-group>
        </div>
    </van-popup>
</template>

<script lang="ts" setup>
const props = defineProps<{
    show: boolean;
    modelValue: number;
}>()

const emits = defineEmits(["update:modelValue", "update:show"]);

const mode = useVModel(props, "modelValue", emits);

const showPicker = useVModel(props, "show", emits);
</script>