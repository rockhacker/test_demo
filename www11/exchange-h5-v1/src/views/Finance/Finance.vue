<template>
    <div class="flex flex-col h-100vh relative">
        <van-tabs class="px-16" v-model:active="active">
            <van-tab :title="$t('finance.mining')" />
            <van-tab :title="$t('finance.ico')" />
        </van-tabs>
        <div class="px-20 relative">
            <div class="w-230 text-#ffffffbd">
                <div>
                    {{ $t('desc.fast_find') }}
                </div>
                <div>{{ $t('desc.global_best_project') }}</div>
            </div>
            <svg-icon class="absolute -right-90 -top-100 w-208 h-240 rotate-40" name="coins" />
        </div>
        <div class="bg-#282828 flex-1 px-20 mt-20 rounded-t-10 overflow-y-auto relative bottom-0 left-0 pb-120">
            <div class="flex items-center justify-between mt-16">
                <div class="text-16">{{ $t('finance.best_product') }}</div>
                <svg-icon class="w-22 h-22 p-8" color="#888" name="order-record" @click="toOrderList" />
            </div>
            <mining v-if="active === 0" />
            <ico v-else />
        </div>
    </div>
</template>

<script lang="ts" setup name="finance">
import Mining from '@/views/Mining/Mining.vue'
import Ico from '@/views/Ico/Ico.vue'

const active = ref(0);

const router = useRouter()

const page = ['/mining/order-list', '/ico/order-list']

const toOrderList = () => {
    router.push(page[active.value])
}
</script>

<style lang="scss" scoped>
:deep(.van-tab--active) {
    font-weight: 800;
    font-size: 20px !important;
}
</style>
