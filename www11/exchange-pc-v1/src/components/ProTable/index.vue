<template>
    <div class="pro-table">
        <el-table class="w-full" v-loading="loading" :data="list">
            <slot />

            <template #empty>
                <slot name="empty">
                    <el-empty :image-size="200" :description="$t('public.no_more')" />
                </slot>
            </template>

        </el-table>

        <div class="flex justify-center mt-20">
            <el-pagination v-model:current-page="page" hide-on-single-page background @change="request"
                layout="prev, pager, next" :total="total" />
        </div>
    </div>
</template>

<script lang="ts" setup>
const props = defineProps<{
    getData: (params: any) => Promise<any>
}>()

const page = ref(1)
const total = ref(0)
const list = ref([])
const [loading, setLoading] = useToggle(false)

const request = () => {
    setLoading(true)
    props.getData({ page: page.value }).then((res) => {
        list.value = res.data
        total.value = res.total
    }).finally(() => {
        setLoading(false)
    })
}

const onRefresh = () => {
    request()
}

onMounted(() => {
    request()
})

defineExpose({
    onRefresh
})
</script>

<style lang="scss">
.pro-table {
    .el-scrollbar__wrap {
        display: flex;
        justify-content: center;
    }
}
</style>