import "virtual:svg-icons-register";
import { createApp } from "vue";
import "@unocss/reset/tailwind-compat.css";
import "virtual:uno.css";
import App from "./App.vue";
import store from "@/store";
import router from "@/router";
import i18n from "@/lang";
import 'element-plus/theme-chalk/dark/css-vars.css'
import "element-plus/theme-chalk/el-loading.css";
import "element-plus/theme-chalk/el-message.css";
import "element-plus/theme-chalk/el-notification.css";
import "element-plus/theme-chalk/el-message-box.css";
import '@/style/index.scss'
// 引入样式
import "./modules/kline/klinecharts-pro.css";

import * as ElementPlusIconsVue from '@element-plus/icons-vue'
import { getHashSearchParam, isMobile, isProd, mobileUrl } from "./common";

if (isProd && isMobile) {
  const invite_code = getHashSearchParam('invite_code')
  // 跳转移动端
  window.location.href = invite_code ? `${mobileUrl}/#/register?invite_code=${invite_code}` : mobileUrl;
}

// 禁用双指放大
document.documentElement.addEventListener(
  "touchstart",
  function (event) {
    if (event.touches.length > 1) {
      event.preventDefault();
    }
  },
  {
    passive: false,
  }
);

// 禁用双击放大
let lastTouchEnd = 0;
document.documentElement.addEventListener(
  "touchend",
  function (event) {
    const now = Date.now();
    if (now - lastTouchEnd <= 300) {
      event.preventDefault();
    }
    lastTouchEnd = now;
  },
  {
    passive: false,
  }
);

const app = createApp(App);
app.use(router);
app.use(store);
app.use(i18n);

for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
  app.component(key, component)
}

app.mount("#app");