import "virtual:svg-icons-register";
import { createApp } from "vue";
import "@unocss/reset/tailwind-compat.css";
import "virtual:uno.css";
import App from "./App.vue";
import store from "@/store";
import router from "@/router";
import i18n from "@/lang";
import '@/style/index.scss'

import 'vant/es/toast/style';
import 'vant/es/dialog/style';
import 'vant/es/notify/style';
import 'vant/es/image-preview/style';

import loadingDirective from "./directives/loading";
import { getHashSearchParam, isPc, isProd, pcUrl } from "@/common";

// if (isProd && isPc) {
//   const invite_code = getHashSearchParam('invite_code')

//   // 跳转pc端
//   window.location.href = invite_code ? `${pcUrl}/#/?invite_code=${invite_code}` : pcUrl;
// }


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
app.directive('loading', loadingDirective)
app.mount("#app");
