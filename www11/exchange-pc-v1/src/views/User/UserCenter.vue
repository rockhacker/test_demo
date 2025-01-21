<template>
    <div class="user-center-page">
        <div>
            <el-tabs v-model="currentTab" type="border-card" tab-position="left" @tab-change="router.push(currentTab)">
                <el-tab-pane name="/user/info">
                    <template #label>
                        <div class="flex items-center">
                            <el-icon size="20px">
                                <Setting />
                            </el-icon>
                            <span class="pl-10 text-16">{{ $t('func.account_setting') }}</span>
                        </div>
                    </template>
                    <RouterView v-if="currentTab === '/user/info'" />
                </el-tab-pane>
                <el-tab-pane name="/user/auth">
                    <template #label>
                        <div class="flex items-center">
                            <el-icon size="20px">
                                <Finished />
                            </el-icon>
                            <span class="pl-10 text-16">{{ $t('func.auth') }}</span>
                        </div>
                    </template>
                    <RouterView v-if="currentTab === '/user/auth'" />
                </el-tab-pane>
                <el-tab-pane name="/user/collect-setting">
                    <template #label>
                        <div class="flex items-center">
                            <el-icon size="20px">
                                <SetUp />
                            </el-icon>
                            <span class="pl-10 text-16">{{ $t('func.collect_setting') }}</span>
                        </div>
                    </template>
                    <RouterView v-if="currentTab === '/user/collect-setting'" />
                </el-tab-pane>
                <el-tab-pane name="/user/feedback">
                    <template #label>
                        <div class="flex items-center">
                            <el-icon size="20px">
                                <Reading />
                            </el-icon>
                            <span class="pl-10 text-16">{{ $t('func.feedback') }}</span>
                        </div>
                    </template>
                    <RouterView v-if="currentTab === '/user/feedback'" />
                </el-tab-pane>
            </el-tabs>
        </div>
    </div>
</template>

<script lang="ts" setup>
const route = useRoute()
const currentTab = ref(route.path)

const router = useRouter()

watch(() => route.path, (newRoute) => {
    currentTab.value = newRoute
})
</script>

<style lang="scss">
.user-center-page {

    .el-tabs__item {
        min-width: 200px;
        height: 63px;
        text-align: center !important;
        justify-content: center !important;
    }

    .is-active {
        border-top-color: var(--el-border-color) !important;
        border-bottom-color: var(--el-border-color) !important;
    }

    .el-tabs__header {
        width: 20%;
    }

    .el-tabs__nav {
        width: 100%;
    }

    .el-tabs__nav-scroll,
    .el-tabs__content {
        min-height: calc(100vh - 64px);
        max-height: calc(100vh - 64px);
        overflow: auto;
    }
}
</style>
