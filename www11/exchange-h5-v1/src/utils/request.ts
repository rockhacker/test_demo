import axios from "axios";
import type { AxiosRequestConfig } from "axios";
declare global {
  // eslint-disable-next-line @tvpescrint-eslint/no-emotv-interface
  interface RequestConfigExt {}
}
// 做一层转换，方便后续维护(如扩展)
export type RequestConfig = AxiosRequestConfig & RequestConfigExt;
// 插件
export interface Plugin {
  ({
    beforeRequest,
    afterRequest,
    onResponse,
    config,
  }: PluginCallbackParams): void;
}

export interface Request {
  <T>(config: RequestConfig): Promise<T>;
  use: (plugin: Plugin) => void;
}
// 请求拦截器
interface RequestInterceptor {
  (next: (value?: any) => void):
    | RequestConfig
    | void
    | Promise<void | RequestConfig>;
}
// 请求监听器
interface RequestListener {
  (promise: Promise<any>): void;
}
// 响应正常处理
interface ResponseResolver {
  (res: any): any;
}
// 响应错误处理
interface ResponseRejecter {
  (err: any): any;
}
// 请求监听参数
export interface PluginCallbackParams {
  beforeRequest: (requestInterceptor: RequestInterceptor) => void;
  afterRequest: (requestListener: RequestListener) => void;
  onResponse: (resolve: ResponseResolver, reject?: ResponseRejecter) => void;
  config: RequestConfig;
}

// 响应错误处理
interface ResponseRejecter {
  (err: any): any;
}
// 请求监听参数
export interface PluginCallbackParams {
  beforeRequest: (requestInterceptor: RequestInterceptor) => void;
  afterRequest: (requestListener: RequestListener) => void;
  onResponse: (resolve: ResponseResolver, reject?: ResponseRejecter) => void;
  config: RequestConfig;
}
export type RequestKey =
  | "url"
  | "urlParams"
  | ((config: RequestConfig) => string);

// 获取请求id，可以配置params、headers是否参与计算，也可以自定义生成id的方法将该方法覆盖
export const getRequestKey = (
  config: RequestConfig,
  key: RequestKey = "url"
) => {
  const { url, params, data } = config;
  if (typeof key == "function") {
    return key(config);
  }
  const createrObj: any = { url };
  if (key === "urlParams") createrObj.params = Object.assign({}, params, data);
  return JSON.stringify(createrObj);
};

export default function createRequest(axiosConfig: RequestConfig) {
  const axiosInstance = axios.create(axiosConfig);
  const plugins: Plugin[] = []; // 请求方法
  const request: Request = <T>(config: RequestConfig): Promise<T> => {
    // 请求拦截器(这个阶段可以终止请求，可以自定义返回请求等)
    const requestInterceptors: RequestInterceptor[] = [];
    const beforeRequest = (requestInterceptor: RequestInterceptor) => {
      requestInterceptors.push(requestInterceptor);
    };

    // 请求监听(这个阶段可以获取请求的promise abort等)
    const requestListeners: RequestListener[] = [];
    const afterRequest = (requestListener: RequestListener) => {
      requestListeners.push(requestListener);
    };
    // 响应拦截(这个阶段可以对最终返回结果进行操作，同axios响应拦截器)
    const responseInterceptors: [
      ResponseResolver,
      ResponseRejecter | undefined
    ][] = [];
    const onResponse = (
      resolve: ResponseResolver,
      reject?: ResponseRejecter
    ) => {
      responseInterceptors.push([resolve, reject]);
    };
    // 遍历插件
    plugins.forEach((callback) => {
      callback({
        beforeRequest,
        afterRequest,
        onResponse,
        config,
      });
    });

    return new Promise<T>(async (resolve) => {
      // 处理请求之前
      const handleBeforeRequest = async () => {
        let needRequest = true;
        let isBail = false;
        for (
          let i = 0, len = requestInterceptors.length;
          i < len && !isBail;
          i++
        ) {
          const interceptor = requestInterceptors[i];
          const _config = await interceptor((value?: any) => {
            if (value !== undefined) {
              isBail = true;
              needRequest = false;
              return resolve(value);
            }
          });
          Object.assign(config, _config);
        }
        return needRequest;
      };
      // 请求被拦截，阻止发送请求
      if (!(await handleBeforeRequest())) {
        console.warn("请求被拦截，阻止发送请求");

        return;
      }
      // 防止缓存
      if (config.method === "delete" || config.method === "get") {
        if (config.params) {
          config.params.t = new Date().getTime();
        } else {
          config.params = { t: new Date().getTime() };
        }
      }

      let promise: Promise<any> = axiosInstance(config);
      // 通过反复赋值promise，实现响应拦截的值处理
      responseInterceptors.forEach((handlers) => {
        promise = promise.then(handlers[0], handlers[1]);
      });
      // 遍历请求监听器
      requestListeners.forEach((listener) => listener(promise));
      return resolve(promise);
    });
  };

  // 插件安装方法
  request.use = (plugin: Plugin) => {
    plugins.push(plugin);
  };

  return {
    request,
    axiosInstance,
  };
}

// 请求方法
export type Methods = "get" | "post" | "delete" | "put" | "patch";

export interface MethodRequest {
  <P extends object = any, T = any>(
    url: string,
    baseParams?: P,
    baseConfig?: RequestConfig
  ): (params?: P, config?: RequestConfig) => Promise<T>;
}
// 方法请求集合
export interface Http {
  get: MethodRequest;
  post: MethodRequest;
  delete: MethodRequest;
  put: MethodRequest;
  patch: MethodRequest;
}

// 创建各类请求方法
export function createMethodRequest(request: Request, method: Methods) {
  return <P = any, T = any>(
    url: string,
    baseParams?: P,
    baseConfig?: RequestConfig
  ) => {
    return (params?: P, config?: RequestConfig): Promise<T> => {
      const paramKey = ["post", "put", "patch"].includes(method)
        ? "data"
        : "params";
      return request({
        ...baseConfig,
        ...config,
        url,
        method,
        [paramKey]: params,
        // [paramKey]: { ...baseParams, ...params },
      });
    };
  };
}

export const createHttp = (config: RequestConfig) => {
  const { request, axiosInstance } = createRequest(config);
  const http: Http = {
    get: createMethodRequest(request, "get"),
    post: createMethodRequest(request, "post"),
    delete: createMethodRequest(request, "delete"),
    put: createMethodRequest(request, "put"),
    patch: createMethodRequest(request, "patch"),
  };
  return {
    http,
    request,
    axiosInstance,
  };
};
