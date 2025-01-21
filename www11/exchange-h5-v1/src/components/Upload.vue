<template>
    <van-uploader v-model="upload" :after-read="afterRead" :max-count="1" @delete="handleDel" />
</template>

<script lang="ts" setup>
import { upLoadFile } from '@/api/public';
import type { UploaderFileListItem } from 'vant'

const props = defineProps<{
    modelValue: string
}>()

const emits = defineEmits(["update:modelValue"]);

const ImageAddress = useVModel(props, "modelValue", emits);

const upload = ref<UploaderFileListItem[]>([]);

const afterRead = (target: any) => {
    const params = new FormData();
    params.append("file", target.file);

    upLoadFile(params).then(({ data }) => {
        upload.value[0] && (upload.value[0].url = data.url);
        ImageAddress.value = data.url
    }).catch(() => {
        upload.value = [];
        ImageAddress.value = ''
    });
};

const resetUpload = () => {
    upload.value = [];
    ImageAddress.value = ''
}

const handleDel = () => {
    ImageAddress.value = ''
}

defineExpose({
    resetUpload
})

</script>