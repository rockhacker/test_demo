import { createRouter, createWebHashHistory } from "vue-router";
import routes from "./routes";
import { useWebsocketStore, useMarketStore, useForexSocketStore, useForexStore } from "@/store";

const router = createRouter({
  history: createWebHashHistory(),
  routes,
  scrollBehavior: (to, from, savedPosition) => {
    return { top: 0 };
  },
});

const subMatchDataPage = ['/', '/coin', '/trade', '/kline']

const subForexDataPage = ['/', '/trade']

router.beforeEach((to, from, next) => {
  //   if (to.meta.login) {
  //     const { isLogin } = useUserStore();
  //     if (!isLogin) {
  //       next(`/login?from=${to.path}`);
  //       return;
  //     }
  //   }
  const { initSocket } = useWebsocketStore();
  const { updateMatchListData } = useMarketStore();
  const { initSocket: initForexSocket } = useForexSocketStore()
  const { updateTradeListData } = useForexStore()

  initSocket();
  initForexSocket();

  if (subMatchDataPage.includes(to.path)) {
    updateMatchListData();
  }

  if (subForexDataPage.includes(to.path)) {
    updateTradeListData()
  }

  next();
});

export default router;
