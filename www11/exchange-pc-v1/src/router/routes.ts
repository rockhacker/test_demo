import { RouteRecordRaw } from "vue-router";

const routes: Array<RouteRecordRaw> = [
    {
        path: "/",
        name: "home",
        component: () => import("@/views/Home/Home.vue"),
    },
    {
        path: "/coin",
        name: "Coin",
        component: () => import("@/views/Coin/Coin.vue"),
    },
    {
        path: "/micro",
        name: "micro",
        component: () => import("@/views/Micro/Micro.vue"),
    },
    {
        path: "/lever",
        name: "lever",
        component: () => import("@/views/Lever/Lever.vue"),
    },
    {
        path: "/forex",
        name: "forex",
        component: () => import("@/views/Forex/Forex.vue"),
    },
    {
        path: "/mining",
        name: "mining",
        component: () => import("@/views/Mining/Mining.vue"),
    },
    {
        path: "/mining/submit-order",
        name: "mining-submit-order",
        component: () => import("@/views/Mining/SubmitOrder.vue"),
    },
    {
        path: "/mining/record",
        name: "mining-record",
        component: () => import("@/views/Mining/Record.vue"),
    },
    {
        path: "/mining/income",
        name: "mining-income",
        component: () => import("@/views/Mining/Income.vue"),
    },
    {
        path: "/subscription",
        name: "subscription-list",
        component: () => import("@/views/Subscription/List.vue"),
    },
    {
        path: "/subscription/submit-order",
        name: "subscription-submit-order",
        component: () => import("@/views/Subscription/SubmitOrder.vue"),
    },
    {
        path: "/subscription/record",
        name: "subscription-record",
        component: () => import("@/views/Subscription/Record.vue"),
    },
    {
        path: "/legal",
        name: "Legal",
        component: () => import("@/views/Legal/Legal.vue"),
    },
    {
        path: "/legal/record",
        name: "legal-record",
        component: () => import("@/views/Legal/Record.vue"),
    },
    {
        path: "/legal/detail",
        name: "legal-detail",
        component: () => import("@/views/Legal/Detail.vue"),
    },
    {
        path: "/store",
        name: "Store",
        component: () => import("@/views/Store/Store.vue"),
    },
    {
        path: "/store/record",
        name: "StoreRecord",
        component: () => import("@/views/Store/Record.vue"),
    },
    {
        path: "/store/detail",
        name: "StoreDetail",
        component: () => import("@/views/Store/Detail.vue"),
    },
    {
        path: "/login",
        name: "Login",
        component: () => import("@/views/Account/Login.vue"),
    },
    {
        path: "/register",
        name: "Register",
        component: () => import("@/views/Account/Register.vue"),
    },
    {
        path: "/forgot-password",
        name: "ForgotPassword",
        component: () => import("@/views/Account/ForgotPassword.vue"),
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
        path: "/user/",
        name: "UserCenter",
        component: () => import("@/views/User/UserCenter.vue"),
        children: [
            {
                path: "info",
                name: "UserInfo",
                component: () => import("@/views/User/Info.vue"),
            },
            {
                path: "auth",
                name: "Auth",
                component: () => import("@/views/User/Auth.vue"),
            },
            {
                path: "collect-setting",
                name: "CollectSetting",
                component: () => import("@/views/User/CollectSetting.vue"),
            },
            {
                path: "feedback",
                name: "Feedback",
                component: () => import("@/views/User/Feedback.vue"),
            }
        ]
    },
    {
        path: '/user/login-password',
        name: 'LoginPassword',
        component: () => import("@/views/User/LoginPassword.vue"),
    },
    {
        path: '/user/trade-password',
        name: 'TradePassword',
        component: () => import("@/views/User/TradePassword.vue"),
    },
    {
        path: "/user/mention",
        name: "UserMention",
        component: () => import("@/views/User/Mention.vue"),
    },
    {
        path: "/assets/",
        name: "AssetsCenter",
        component: () => import("@/views/User/AssetsCenter.vue"),
        children: [
            {
                path: "detail",
                name: "AssetsDetail",
                component: () => import("@/views/User/AssetsDetail.vue"),
            },
            {
                path: "ico-bill",
                name: "IcoBill",
                component: () => import("@/views/User/IcoBill.vue"),
            },
            {
                path: "transfer",
                name: "Transfer",
                component: () => import("@/views/User/Transfer.vue"),
            },
            {
                path: "exchange",
                name: "Exchange",
                component: () => import("@/views/User/Exchange.vue"),
            },
            {
                path: "bind-withdraw-address",
                name: "BindWithdrawAddress",
                component: () => import("@/views/User/BindWithdrawAddress.vue"),
            },
            {
                path: "withdraw",
                name: "Withdraw",
                component: () => import("@/views/User/Withdraw.vue"),
            },
            {
                path: "withdraw-record",
                name: "WithdrawRecord",
                component: () => import("@/views/User/WithdrawRecord.vue"),
            }
        ]
    },
    {
        path: "/assets/record",
        name: "AssetsRecord",
        component: () => import("@/views/User/AssetsRecord.vue"),
    },
    {
        path: "/:pathMatch(.*)",
        redirect: "/",
    },
];

export default routes;
