import { RouteRecordRaw } from "vue-router";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "home",
    component: () => import("@/views/Home/Home.vue"),
    meta: {
      // keepAlive: true,
      showFooter: true,
    },
  },
  {
    path: "/coin",
    name: "coin",
    component: () => import("@/views/Coin/Coin.vue"),
    meta: {
      keepAlive: true,
      showFooter: true,
    },
  },
  {
    path: "/trade",
    name: "trade",
    component: () => import("@/views/Trade/Trade.vue"),
    meta: {
      keepAlive: true,
      showFooter: true,
    },
  },
  {
    path: "/finance",
    name: "finance",
    component: () => import("@/views/Finance/Finance.vue"),
    meta: {
      // keepAlive: true,
      showFooter: true,
    },
  },
  {
    path: "/mine",
    name: "mine",
    component: () => import("@/views/Mine/Mine.vue"),
    meta: {
      // keepAlive: true,
      showFooter: true,
    },
  },
  {
    path: "/login",
    name: "login",
    component: () => import("@/views/Account/Login.vue"),
  },
  {
    path: "/wallet",
    name: "Wallet",
    component: () => import("@/views/Account/Wallet.vue"),
  },
  {
    path: "/register",
    name: "register",
    component: () => import("@/views/Account/Register.vue"),
  },
  {
    path: "/forgot-password",
    name: "forgot-password",
    component: () => import("@/views/Account/ForgotPassword.vue"),
  },
  {
    path: "/kline",
    name: "kline",
    component: () => import("@/views/Kline/Kline.vue"),
  },
  {
    path: "/coin/entrust",
    name: "entrust",
    component: () => import("@/views/Coin/Entrust.vue"),
  },
  {
    path: "/mining/subscribe",
    name: "mining-subscribe",
    component: () => import("@/views/Mining/Subscribe.vue"),
  },
  {
    path: "/mining/order-list",
    name: "mining-order-list",
    component: () => import("@/views/Mining/OrderList.vue"),
  },
  {
    path: "/mining/order-profit",
    name: "mining-order-profit",
    component: () => import("@/views/Mining/OrderProfit.vue"),
  },
  {
    path: "/ico/submit-order",
    name: "ico-submit-order",
    component: () => import("@/views/Ico/SubmitOrder.vue"),
  },
  {
    path: "/ico/order-list",
    name: "ico-order-list",
    component: () => import("@/views/Ico/OrderList.vue"),
  },
  {
    path: "/otc/list",
    name: "otc-list",
    component: () => import("@/views/Otc/List.vue"),
  },
  {
    path: "/otc/record",
    name: "otc-record",
    component: () => import("@/views/Otc/Record.vue"),
  },
  {
    path: "/otc/detail",
    name: "otc-detail",
    component: () => import("@/views/Otc/Detail.vue"),
  },
  {
    path: "/user/recharge",
    name: "recharge",
    component: () => import("@/views/User/Recharge.vue"),
  },
  {
    path: "/user/recharge-submit",
    name: "recharge-submit",
    component: () => import("@/views/User/RechargeSubmit.vue"),
  },
  {
    path: "/user/auth",
    name: "user-auth",
    component: () => import("@/views/User/Auth.vue"),
  },
  {
    path: "/user/invite",
    name: "user-invite",
    component: () => import("@/views/User/Invite.vue"),
  },
  {
    path: "/user/bind-mention-address",
    name: "user-bind-mention-address",
    component: () => import("@/views/User/BindMentionAddress.vue"),
  },
  {
    path: "/user/withdraw",
    name: "user-withdraw",
    component: () => import("@/views/User/Withdraw.vue"),
  },
  {
    path: "/user/mention",
    name: "user-mention",
    component: () => import("@/views/User/Mention.vue"),
  },
  {
    path: "/user/transfer",
    name: "user-transfer",
    component: () => import("@/views/User/Transfer.vue"),
  },
  {
    path: "/user/exchange",
    name: "user-exchange",
    component: () => import("@/views/User/Exchange.vue"),
  },
  {
    path: "/user/collection-method",
    name: "user-collection-method",
    component: () => import("@/views/User/FlatCollectionMethod.vue"),
  },
  {
    path: "/user/bind-collection-method",
    name: "user-bind-collection-method",
    component: () => import("@/views/User/BindCollectionMethod.vue"),
  },
  {
    path: "/user/auth-code",
    name: "user-auth-code",
    component: () => import("@/views/User/AuthCode.vue"),
  },
  {
    path: "/user/safe-center",
    name: "user-safe-center",
    component: () => import("@/views/User/SafeCenter.vue"),
  },
  {
    path: "/user/reset-login",
    name: "user-reset-login",
    component: () => import("@/views/User/LoginPassword.vue"),
  },
  {
    path: "/user/reset-trade",
    name: "user-reset-trade",
    component: () => import("@/views/User/TradePassword.vue"),
  },
  {
    path: "/user/feedback",
    name: "user-feedback",
    component: () => import("@/views/User/Feedback.vue"),
  },
  {
    path: "/user/assets",
    name: "user-assets",
    component: () => import("@/views/User/Assets.vue"),
  },
  {
    path: "/user/assets-detail",
    name: "user-assets-detail",
    component: () => import("@/views/User/AssetsDetail.vue"),
  },
  {
    path: "/user/feedback-record",
    name: "user-feedback-record",
    component: () => import("@/views/User/FeedbackRecord.vue"),
  },
  {
    path: "/user/language",
    name: "language",
    component: () => import("@/views/User/Language.vue"),
  },
  {
    path: "/user/setting",
    name: "setting",
    component: () => import("@/views/User/Setting.vue"),
  },
  {
    path: "/user/chat",
    name: "chat",
    component: () => import("@/views/User/Chat.vue"),
  },
  {
    path: "/micro/history",
    name: "micro-history",
    component: () => import("@/views/Trade/MicroHistory.vue"),
  },
  {
    path: "/lever/history",
    name: "lever-history",
    component: () => import("@/views/Trade/LeverHistory.vue"),
  },
  {
    path: "/lever/current-order",
    name: "lever-current-order",
    component: () => import("@/views/Trade/LeverCurrentOrder.vue"),
  },
  {
    path: "/forex/history",
    name: "forex-history",
    component: () => import("@/views/Trade/ForexHistory.vue"),
  },
  {
    path: "/forex/exchange",
    name: "forex-exchange",
    component: () => import("@/views/User/ForexExchange.vue"),
  },
  {
    path: "/forex/kline",
    name: "forex-kline",
    component: () => import("@/views/Trade/ForexKline.vue"),
  },
  {
    path: "/:pathMatch(.*)",
    redirect: "/",
  }
];

export default routes;
