<template>
    <nav-bar :title="$t('func.submit_feedback')">
        <template #right>
            <div class="p-4" @click="router.push('/user/feedback-record')">
                <svg-icon class="w-24 h-24" color="#888" name="order-record" />
            </div>
        </template>
    </nav-bar>

    <div class="p-12 text-14 mt-12">
        <div>{{ $t('feedback.title') }}</div>
        <input v-model="title" class="bg-#383838 py-8 px-12 rounded-6 w-full mt-6" type="text"
            :placeholder="$t('feedback.input_title')">

        <div class="mt-20">{{ $t('feedback.content') }}</div>
        <textarea v-model="content" rows="10" cols="30" class="bg-#383838 py-8 px-12 rounded-6 w-full mt-6"
            :placeholder="$t('feedback.content_tip')" style="resize:none" />

        <van-button class="mt-20 rounded-16 h-46 text-14" color="#2fdab0" block @click="onSubmit">
            {{ $t('public.confirm') }}
        </van-button>
    </div>
</template>

<script lang="ts" setup>
import { feedback } from '@/api/user';
import { showSuccessToast } from 'vant';

const router = useRouter()

const title = ref('')
const content = ref('')

const onSubmit = () => {
    feedback({
        title: title.value,
        content: content.value
    }, { loading: true }).then(({ msg }) => {
        showSuccessToast(msg!)
        title.value = content.value = ''
    })
}
</script>