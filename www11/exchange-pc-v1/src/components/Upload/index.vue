<template>
    <el-upload ref="uploadRef" class="w-full" drag :show-file-list="false" :http-request="handleUpload" :limit="1"
        :on-exceed="handleExceed">
        <el-icon v-if="!src" class="el-icon--upload mb-0"><upload-filled /></el-icon>
        <img class="max-h-160 w-full h-full" v-else :src="src" />
    </el-upload>
</template>

<script lang="ts" setup>
import { upLoadFile } from '@/api';
import { UploadInstance, UploadProps } from 'element-plus';

const props = defineProps<{
    modelValue: string;
}>()

const uploadRef = ref<UploadInstance>();

const emits = defineEmits(["update:modelValue"]);

const src = useVModel(props, "modelValue", emits);

const handleUpload: any = (target: any) => {
    const params = new FormData();
    params.append("file", target.file);

    upLoadFile(params).then(({ data }) => {
        src.value = data.url;
    });
};

const handleExceed: UploadProps["onExceed"] = (files) => {
    const params = new FormData();
    params.append("file", files[0]);
    upLoadFile(params).then(({ data }) => {
        src.value = data.url;
    });
};

const resetUpload = () => {
    uploadRef.value?.clearFiles();
    src.value = ''
}

defineExpose({
    resetUpload
})
</script>