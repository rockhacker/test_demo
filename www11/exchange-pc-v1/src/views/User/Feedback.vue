<template>
    <div class="max-w-[1200px] mx-auto mt-20">
        <el-form label-width="auto">
            <el-form-item :label="$t('feedback.title')">
                <el-input v-model="title" :placeholder="$t('feedback.input_title')" class="h-32" />
            </el-form-item>
            <el-form-item :label="$t('feedback.content')">
                <el-input v-model="content" :autosize="{ minRows: 2, maxRows: 10 }" type="textarea"
                    :placeholder="$t('feedback.content_tip')" />
            </el-form-item>
            <el-form-item label=" ">
                <el-button class="w-full h-32" type="primary" @click="onSubmit">
                    {{ $t('public.confirm') }}
                </el-button>
            </el-form-item>
        </el-form>

        <FeedbackHistory />
    </div>
</template>

<script setup lang="ts">
import { feedback } from '@/api';
import FeedbackHistory from './components/FeedbackHistory.vue';

const title = ref('')
const content = ref('')

const onSubmit = () => {
    feedback({
        title: title.value,
        content: content.value
    }, { loading: true, showSuccessMessage: true }).then(() => {
        title.value = content.value = ''
    })
}
</script>