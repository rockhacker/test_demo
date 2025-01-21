import { createHttp } from "./request";
import { HTTP_BASE_URL } from "@/common";
import { useAppStore, useUserStore } from "@/store";
import { showFailToast, showLoadingToast } from "vant";
import type { ToastWrapperInstance } from "vant/lib/toast/types";
import type { PluginCallbackParams, RequestConfig } from "./request";
import router from "@/router"
interface ExtendRequestConfig {
  flat?: boolean;
  loading?: boolean;
  showErrorMessage?: boolean;
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

request.use(flatResponsePlugin());

let instance: ToastWrapperInstance;

const plugin = () => {
  return ({
    config,
    beforeRequest,
    onResponse,
    afterRequest,
  }: PluginCallbackParams) => {
    const { showErrorMessage, loading, url, isInit } = config;
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
        if (url?.includes("/manifest.json")) {
          return response;
        }

        if (loading && instance) {
          instance.close();
        }
        const { resetUserInfo } = useUserStore();
        const { code, msg, message } = response;
        // 未登陆/会话失效
        if (code === "999") {
          resetUserInfo();
          !isInit && router.push('/login')
          return Promise.reject(response);
        }
        if (code !== 1) {
          showErrorMessage !== false && showFailToast({
            message: msg || message,
            wordBreak: 'break-word'
          });
          return Promise.reject(response);
        }
        return Promise.resolve(response);
      },
      (error) => {
        if (url?.includes("/manifest.json")) {
          return Promise.reject(error);
        }

        if (error.code === "ERR_CANCELED") {
          return Promise.reject(error);
        }

        if (loading && instance) {
          instance.close();
        }
        showFailToast(error?.response?.data?.message || error.code);
        console.warn("http error", error);
        return Promise.reject(error);
      }
    );
    afterRequest(() => {
      if (loading) {
        instance = showLoadingToast({
          duration: 0,
          forbidClick: true,
          loadingType: "spinner",
        });
      }
    });
  };
};

request.use(plugin());

export default http;
