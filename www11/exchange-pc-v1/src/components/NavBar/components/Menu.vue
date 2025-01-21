<template>
    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" :ellipsis="false"
        @select="handleSelect">
        <template v-for="item in showMenu">
            <el-sub-menu v-if="item.children" :index="item.path || item.title">
                <template #title>{{ item.title }}</template>
                <el-menu-item v-for="child in item.children" :index="child.path">
                    <div class="flex items-center">
                        <svg-icon v-if="child.icon" :name="child.icon" :width="child.width" :height="child.height" />
                        <div class="text-white flex items-center pl-6">
                            <span class="font-700">{{ child.title }}</span>
                            <span v-if="child.desc" class="text-12 pl-4 text-#888">({{ child?.desc }})</span>
                        </div>
                    </div>
                </el-menu-item>
            </el-sub-menu>
            <el-menu-item v-else :index="item.path">
                {{ item.title }}
            </el-menu-item>
        </template>
    </el-menu>
</template>

<script setup lang="ts">
import { useUserStore } from '@/store';
import { ref } from 'vue'
import { useI18n } from 'vue-i18n';

const { t } = useI18n()
const { user } = storeToRefs(useUserStore())

const menu = [
    {
        title: t('nav.trade'),
        path: '',
        children: [
            {
                icon: 'p2p',
                title: t('legal.legal_trade'),
                path: '/legal',
                desc: '',
                height: '24px',
                width: '24px'
            },
            {
                icon: 'coin',
                title: t('nav.coin_trade'),
                path: '/coin',
                desc: '',
                height: '24px',
                width: '24px'
            }
        ]
    },
    {
        title: t('nav.contract'),
        path: '',
        children: [
            {
                icon: 'micro',
                title: t('trade.delivery_contract'),
                path: '/micro',
                desc: t('describe.coin_trade'),
                height: '24px',
                width: '24px'
            },
            {
                icon: 'lever',
                title: t('trade.lever_contract'),
                path: '/lever',
                desc: t('describe.use_usdt'),
                height: '24px',
                width: '24px'
            }
        ]
    },
    {
        title: t('nav.forex'),
        path: '/forex',
    },
    {
        title: t('nav.mining'),
        path: '/mining',
    },
    {
        title: t('nav.assets'),
        path: '/assets/detail',
    },
    {
        title: t('nav.ico'),
        path: '/subscription',
    },
    {
        title: t('nav.charge'),
        path: '/user/recharge',
    }
]

const showMenu = computed(() => {
    if (user.value?.is_seller) {
        return [...menu,
        {
            title: t('nav.store'),
            path: '/store',
        },]
    } else {
        return menu
    }
})

const router = useRouter()
const route = useRoute()

const activeIndex = ref()
const handleSelect = (key: string, keyPath: string[]) => {
    router.push(key)
}



watch(() => route.path, (newValue, oldValue) => {
    activeIndex.value = newValue
})
</script>

<style lang="scss">
.el-menu--horizontal.el-menu {
    border-bottom: none;
}
</style>