<template>
    <div class="flex items-center justify-around text-#161616">
        <div>
            <div class="text-40">App Download</div>
            <div class="text-#888888 text-14 mt-32">Multi podium terminal transaction anytime, anywhere</div>

            <div class="flex mt-80 justify-between">
                <div>

                    <div>
                        <div class="text-#888888 text-14">Android & iOS Download</div>
                    </div>

                    <div class="flex items-center justify-between">
                        <el-popover :width="230" trigger="hover">
                            <div>
                                <QrCode v-bind:model-value="appLink" />
                            </div>
                            <template #reference>
                                <div class="bg-white w-200 flex justify-center items-center py-12 mt-20 cursor-pointer">
                                    <img src="@/assets/images/Andriod.png" class="w-24 h-24">
                                    <span class="text-14 pl-24">Andriod</span>
                                </div>
                            </template>
                        </el-popover>
                        <el-popover :width="230">
                            <div>
                                <QrCode v-bind:model-value="appLink" />
                            </div>
                            <template #reference>
                                <div
                                    class="bg-white w-200 flex justify-center items-center py-12 mt-16 ml-20 cursor-pointer">
                                    <img src="@/assets/images/IOS.png" class="w-24 h-24">
                                    <span class="text-14 pl-24">IOS</span>
                                </div>
                            </template>
                        </el-popover>
                    </div>
                </div>
            </div>

            <div class="mt-20 text-12 text-#888888">
                Covers IOS, Android and windows cheap tables, and supports all
                business functions
            </div>
        </div>
        <div class="relative">
            <img src="@/assets/images/phone-bg.png" class="w-280 h-509">
            <div class="bg-#161616 absolute top-10 h-490 w-93% left-10 rounded-12"></div>
            <img src="@/assets/images/home/h5.png" class="absolute top-24 left-10 rounded-12 w-93%">
        </div>
    </div>
</template>

<script lang="ts" setup>
import { appLink } from '@/common'
</script>