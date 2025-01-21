import { createHttp } from "./request";
import { HTTP_BASE_URL } from "@/common";
import { useAppStore, useUserStore } from "@/store";
import type { PluginCallbackParams, RequestConfig } from "./request";
import { ElLoading } from "element-plus";
import { notification } from "ant-design-vue";
import emitter from "./emitter";
import cancelPlugin from './cancelPlugin'
import router from "@/router"
interface ExtendRequestConfig {
  flat?: boolean;
  loading?: boolean;
  showErrorMessage?: boolean;
  showSuccessMessage?: boolean;
  isInit?: boolean
}

declare global {
  // eslint-disable-next-line @tvpescrint-eslint/no-emotv-interface
  interface RequestConfigExt extends ExtendRequestConfig { }
}

function flatResponsePlugin() {
  return ({ config, onResponse }: PluginCallbackParams) => {
    const { flat } = config;
    if (flat !== false) {
      onResponse((response) => {
        return response?.data || response;
      });
    }
  };
}

const { request, http } = createHttp({
  baseURL: HTTP_BASE_URL,
});

request.use(cancelPlugin())

request.use(flatResponsePlugin());

let instance: any;

const plugin = () => {
  return ({
    config,
    beforeRequest,
    onResponse,
    afterRequest,
  }: PluginCallbackParams) => {
    const { showSuccessMessage, showErrorMessage, loading, isInit } = config;

    beforeRequest(() => {
      const { lang } = useAppStore();
      const { token } = useUserStore();
      if (config.headers) {
        config.headers.lang = lang;
        config.headers.authorization = token;
      } else {
        config.headers = {
          lang: lang,
          authorization: token,
        };
      }
    });
    onResponse(
      (response) => {
        if (loading && instance) {
          instance.close();
        }
        const { resetUserInfo } = useUserStore();
        const { code, msg } = response;
        // 未登陆/会话失效
        if (code === "999") {
          resetUserInfo();
          // @ts-ignore
          !isInit && router.push('/login')
          return Promise.reject(response);
        }
        if (code !== 1) {
          !isInit && showErrorMessage !== false && notification.error({ message: msg });
          return Promise.reject(response);
        }
        if (showSuccessMessage === true) {
          notification.success({ message: msg });
        }
        return Promise.resolve(response);
      },
      (error) => {
        if (error.code === "ERR_CANCELED") {
          return Promise.reject(error);
        }

        if (loading && instance) {
          instance.close();
        }
        notification.error({ message: error?.response?.data?.message || error.code });
        console.warn("http error", error);
        return Promise.reject(error);
      }
    );
    afterRequest(() => {
      if (loading) {
        instance = ElLoading.service({ fullscreen: true });
      }
    });
  };
};

request.use(plugin());

export default http;
