<template>
    <el-carousel height="620px">
        <el-carousel-item v-for="item in bannerList">
            <el-image class="w-full h-full" :src="item.banner" fit="fill" />
        </el-carousel-item>
    </el-carousel>
</template>

<script lang="ts" setup>
import { getBanner } from '@/api'
import { Banner } from '@/interface/app';

const bannerList = ref<Banner[]>([])

getBanner().then(({ data }) => {
    bannerList.value = data.data
    console.log(bannerList.value);

})
</script>