<template>
    <div class="nav-bar flex items-center justify-between h-60 px-20">
        <div class="flex items-center flex-1">
            <Logo class="h-50" />
            <Menu class="mx-20" />
        </div>
        <div class="flex items-center">
            <template v-if="!isLogin">
                <el-button color="#505257" class="min-w-100 rounded-8" @click="router.push('/login')">
                    {{ $t('account.login') }}
                </el-button>
                <el-button color="#19FC8F" class="min-w-100 rounded-8" @click="router.push('/register')">
                    {{ $t('account.register') }}
                </el-button>
            </template>
            <template v-else>
                <el-dropdown class="mr-10" @command="handleCommand">
                    <div class="flex items-center min-w-120 text-right">
                        <span class="text-white">
                            {{ user?.email }}
                        </span>
                        <el-icon class="pl-4 font-bold" size="20px" color="white">
                            <ArrowDown />
                        </el-icon>
                    </div>
                    <template #dropdown>
                        <el-dropdown-menu>
                            <el-dropdown-item>
                                <RouterLink to="/user/info">{{ $t('func.account_setting') }}</RouterLink>
                            </el-dropdown-item>
                            <el-dropdown-item>
                                <RouterLink to="/user/auth">{{ $t('func.auth') }}</RouterLink>
                            </el-dropdown-item>
                            <el-dropdown-item>
                                <RouterLink to="/user/collect-setting">{{ $t('func.collect_setting') }}</RouterLink>
                            </el-dropdown-item>
                            <el-dropdown-item>
                                <RouterLink to="/user/feedback">{{ $t('func.feedback') }}</RouterLink>
                            </el-dropdown-item>
                            <el-dropdown-item command="logout">
                                <span>{{ $t('func.logout') }}</span>
                            </el-dropdown-item>
                        </el-dropdown-menu>
                    </template>
                </el-dropdown>
            </template>
            <Lang class="min-w-100 rounded-8 ml-12" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import Logo from '@/components/Logo/index.vue'
import Menu from './components/Menu.vue';
import Lang from './components/Lang.vue';
import { useRouter } from 'vue-router';
import { useUserStore } from '@/store';

const { isLogin, user } = storeToRefs(useUserStore())
const { resetUserInfo } = useUserStore()

const router = useRouter()

const handleCommand = (command: string | number | object) => {
    if (command === 'logout') {
        resetUserInfo()
        router.push('/')
    }
}
</script>

<style lang="scss">
.nav-bar {
    background: #1D1E1E;

    .el-sub-menu__icon-arrow {
        font-weight: 800;
        font-size: 14px;
    }
}
</style>