<template>
    <div>
        <div class="text-14 my-10">
            {{ $t('transfer.source') }}
        </div>

        <div v-loading="loading">
            <div class="h-350 overflow-auto" v-infinite-scroll="onLoad" :infinite-scroll-disabled="finished">
                <div v-for="item in feedbackList" :key="item.id" class="text-14">
                    <div class="mt-12">{{ item.title }}</div>
                    <div v-if="item.reply === null" class="text-red mt-10">
                        {{ $t('feedback.no_reply') }}
                    </div>
                    <div class="mt-10" v-else>{{ $t('feedback.reply') }}: {{ item.reply }}</div>
                    <div class="text-right my-10">
                        {{ item.created_at }}
                    </div>
                    <van-divider />
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { getFeedbackList } from '@/api/user';
import { FeedbackItem } from '@/interface/user';

const feedbackList = ref<FeedbackItem[]>([])
const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const onLoad = () => {
    if (loading.value) return
    page.value++

    setLoading(true)

    getFeedbackList({ page: page.value })
        .then(({ data }) => {
            const list = data.data
            feedbackList.value = page.value === 1 ? list : feedbackList.value.concat(list);
            setFinish(data.last_page === page.value)
        })
        .catch(() => {
            setFinish(true)
        })
        .finally(() => {
            setLoading(false)
        })
}
</script>