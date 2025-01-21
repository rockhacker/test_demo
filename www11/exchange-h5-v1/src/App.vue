<template>
  <van-config-provider class="min-h-100vh" :theme="theme" :theme-vars="themeVars">
    <router-view v-slot="{ Component }">
      <transition name="van-slide-right">
        <keep-alive :include="keepAliveList">
          <component :is="Component" />
        </keep-alive>
      </transition>
    </router-view>
    <TabBar v-if="$route.meta.showFooter" />
  </van-config-provider>
</template>

<script lang="ts" setup>
import type { ConfigProviderTheme, ConfigProviderThemeVars } from "vant"
import { useAppStore, useForexSocketStore, useForexStore, useMarketStore, useUserStore, useWebsocketStore } from "@/store";
import { usePageVisibility } from '@vant/use';

const theme = ref<ConfigProviderTheme>('dark');

const themeVars = reactive<ConfigProviderThemeVars>({
  navBarBackground: '#232323',
  cellBackground: 'transparent',
  cellVerticalPadding: '0',
  cellHorizontalPadding: '0',
  fieldPlaceholderTextColor: '#888',
  fieldRightIconColor: '#888',
  checkboxBorderColor: '#888',
  checkboxLabelColor: '#888',
  checkboxCheckedIconColor: '#9fef4e',
  buttonPrimaryBackground: '#9fef4e',
  buttonPrimaryBorderColor: '#9fef4e',
  buttonPrimaryColor: '#232323',
  pickerConfirmActionColor: '#9fef4e',
  sliderActiveBackground: '#9fef4e',
  dialogConfirmButtonTextColor: '#9fef4e',
  popupBackground: '#3A3A3A',
  stepperBackground: '#888',
  stepperButtonDisabledColor: '#515151',
  navBarTitleFontSize: '1.2rem',
  tabsNavBackground: '#232323',
  tabsBottomBarColor: '#9fef4e',
  tabActiveTextColor: '#fff',
  tabTextColor: '#888',
  dividerBorderColor: '#88',
  dividerMargin: '0',
  tabsBottomBarWidth: '0',
  tabsBottomBarHeight: '0',
  uploaderUploadBackground: '#383838',
  uploaderIconSize: '2.5rem',
  uploaderSize: '6rem',
  collapseItemContentBackground: 'none',
  stepsBackground: 'none',
  collapseItemContentPadding: '0',
  dialogHasTitleMessageTextColor: '#fff',
  circleTextFontSize: '2.6rem'
});

const router = useRouter();

const keepAliveList = (router.options.routes
  .filter((item) => item.meta?.keepAlive)
  .map((item) => item.name) || []) as string[];

const { initApp } = useAppStore();
const { initMarket } = useMarketStore()
const { initMarket: initForex } = useForexStore()
const { title } = storeToRefs(useAppStore());
const { disconnect, reconnect, login } = useWebsocketStore();
const { login: forexSocketLogin } = useForexSocketStore()
const { getUserData } = useUserStore()

const { isLogin } = storeToRefs(useUserStore())

initApp();
initMarket()
initForex()
getUserData(true).then(() => {
  if (isLogin.value) {
    login()
    forexSocketLogin()
  }
})

const pageVisibility = usePageVisibility();

watch(pageVisibility, (value) => {
  // value === 'visible' ? reconnect() : disconnect()
});
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.1s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>