<template>
    <div class="bottom-navigation flex">
        <div class="flex-1 flex flex-col justify-center items-center relative" v-for="item in navigation"
            @click.stop="toPage(item.path)">
            <img class="w-26 h-26" :src="route.path === item.path ? item.active : item.default">
            <span class="text-12 mt-2" :class="route.path === item.path ? 'text-main' : 'text-[#919195]'">
                {{ $t(item.text) }}
            </span>
        </div>
    </div>
</template>

<script setup lang="ts">
import { getTabBarImage } from "@/utils/getImage"

const navigation = [
    {
        default: getTabBarImage('home.png'),
        active: getTabBarImage('home-active.png'),
        text: 'tabbar.home',
        path: '/'
    },
    {
        default: getTabBarImage('coins.png'),
        active: getTabBarImage('coins-active.png'),
        text: 'tabbar.coins',
        path: '/coin'
    },
    {
        default: getTabBarImage('trading.png'),
        active: getTabBarImage('trading-active.png'),
        text: 'tabbar.trade',
        path: '/trade'
    },
    {
        default: getTabBarImage('finance.png'),
        active: getTabBarImage('finance-active.png'),
        text: 'tabbar.finance',
        path: '/finance'
    },
    {
        default: getTabBarImage('mine.png'),
        active: getTabBarImage('mine-active.png'),
        text: 'tabbar.mine',
        path: '/mine'
    }
]

const router = useRouter()
const route = useRoute()

const toPage = (path: string) => {
    router.push(path)
}

</script>

<style lang="scss">
.bottom-navigation {
    z-index: 999;
    position: fixed;
    left: 10px;
    right: 10px;
    bottom: 12px;
    height: 69px;
    background: rgba(87, 87, 87, 0.86);
    box-shadow: 0px 1.5px 0px #444448 inset;
    border-radius: 64px;
    backdrop-filter: blur(16px);
}
</style>
