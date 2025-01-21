<template>
    <nav-bar :title="$t('func.flat_collection_method')" />

    <div class="mt-6">
        <div v-for="item in payMethodList" :key="item.id" @click="toBind(item)">
            <div class="py-10 px-16 flex items-center justify-between">
                <div class="flex items-center">
                    <van-icon name="card" size="1.8rem" color="#9FEF4E" />
                    <span class="pl-10">{{ item.name }}</span>
                </div>
                <van-icon name="arrow" color="#888" size="1.3rem" />
            </div>
            <van-divider />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { getPayMethod } from '@/api/user';
import { CollectMethodItem } from '@/interface/user';

const router = useRouter()

const payMethodList = ref<CollectMethodItem[]>([])

const toBind = (item: CollectMethodItem) => {
    router.push({
        path: '/user/bind-collection-method',
        query: {
            id: item.id,
            code: item.code
        }
    })
}

getPayMethod().then(({ data }) => {
    payMethodList.value = data
})
</script>