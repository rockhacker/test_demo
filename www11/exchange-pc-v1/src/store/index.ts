import { createPinia } from "pinia";

// https://prazdevs.github.io/pinia-plugin-persistedstate/zh/
import piniaPluginPersistedstate from "pinia-plugin-persistedstate";

export { default as useAppStore } from "./app";
export { default as useUserStore } from "./user";
export { default as useMarketStore } from './market';
export { default as useWebsocketStore } from './websocket';
export { default as useForexStore } from './forex';
export { default as useForexSocketStore } from './forexSocket';


const store = createPinia();
store.use(piniaPluginPersistedstate);

export default store;
