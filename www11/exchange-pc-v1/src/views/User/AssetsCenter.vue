<template>
    <div class="assets-center-page">
        <div>
            <el-tabs v-model="currentTab" type="border-card" tab-position="left" @tab-change="router.push(currentTab)">
                <el-tab-pane name="/assets/detail">
                    <template #label>
                        <div class="flex items-center">
                            <el-icon size="20px">
                                <Wallet />
                            </el-icon>
                            <span class="pl-10 text-16">{{ $t('nav.assets') }}</span>
                        </div>
                    </template>
                    <RouterView v-if="currentTab === '/assets/detail'" />
                </el-tab-pane>
                <el-tab-pane name="/assets/ico-bill">
                    <template #label>
                        <div class="flex items-center">
                            <el-icon size="20px">
                                <Document />
                            </el-icon>
                            <span class="pl-10 text-16">{{ $t('ico.bill') }}</span>
                        </div>
                    </template>
                    <RouterView v-if="currentTab === '/assets/ico-bill'" />
                </el-tab-pane>
                <el-tab-pane name="/assets/transfer">
                    <template #label>
                        <div class="flex items-center">
                            <el-icon size="20px">
                                <ScaleToOriginal />
                            </el-icon>
                            <span class="pl-10 text-16">{{ $t('func.transfer') }}</span>
                        </div>
                    </template>
                    <RouterView v-if="currentTab === '/assets/transfer'" />
                </el-tab-pane>
                <el-tab-pane name="/assets/exchange">
                    <template #label>
                        <div class="flex items-center">
                            <el-icon size="20px" class="rotate-90">
                                <Sort />
                            </el-icon>
                            <span class="pl-10 text-16">{{ $t('func.exchange') }}</span>
                        </div>
                    </template>
                    <RouterView v-if="currentTab === '/assets/exchange'" />
                </el-tab-pane>
                <el-tab-pane name="/assets/withdraw">
                    <template #label>
                        <div class="flex items-center">
                            <el-icon size="20px">
                                <Money />
                            </el-icon>
                            <span class="pl-10 text-16">{{ $t('func.mention') }}</span>
                        </div>
                    </template>
                    <RouterView v-if="currentTab === '/assets/withdraw'" />
                </el-tab-pane>
                <el-tab-pane name="/assets/withdraw-record">
                    <template #label>
                        <div class="flex items-center">
                            <el-icon size="20px">
                                <TakeawayBox />
                            </el-icon>
                            <span class="pl-10 text-16">{{ $t('user.withdraw_history') }}</span>
                        </div>
                    </template>
                    <RouterView v-if="currentTab === '/assets/withdraw-record'" />
                </el-tab-pane>
                <el-tab-pane name="/assets/bind-withdraw-address">
                    <template #label>
                        <div class="flex items-center">
                            <el-icon size="20px">
                                <Memo />
                            </el-icon>
                            <span class="pl-10 text-16">{{ $t('func.bind_withdraw_add') }}</span>
                        </div>
                    </template>
                    <RouterView v-if="currentTab === '/assets/bind-withdraw-address'" />
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
.assets-center-page {

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
