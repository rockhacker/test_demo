<template>
  <el-config-provider :locale="locale">
    <nav-bar />
    <router-view v-slot="{ Component, route }">
      <!-- <transition name="fade" mode="out-in"> -->
      <!-- <keep-alive :include="keepAliveList"> -->
      <component :is="Component" class="flex-1"  />
      <!-- </keep-alive> -->
      <!-- </transition> -->
    </router-view>

  </el-config-provider>
</template>

<script lang="ts" setup>
import NavBar from '@/components/NavBar/index.vue'
import { langs } from "@/lang";
import { useAppStore, useForexSocketStore, useForexStore, useMarketStore, useUserStore, useWebsocketStore } from '@/store';

const { lang } = storeToRefs(useAppStore());
const { initApp } = useAppStore()
const { initMarket } = useMarketStore()
const { initMarket: initForex } = useForexStore()
const { getUserData } = useUserStore()

const { disconnect, reconnect, login } = useWebsocketStore();
const { login: forexSocketLogin } = useForexSocketStore()

const { isLogin } = storeToRefs(useUserStore())

const locale = computed(() => langs[lang.value].locale);

initApp()
initMarket()
initForex()

getUserData(true).then(() => {
  if (isLogin.value) {
    login()
    forexSocketLogin()
  }
})
</script>
