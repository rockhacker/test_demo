
import type { PluginCallbackParams, RequestConfig } from "./request";
export type RequestKey =
    | 'url'
    | 'urlParams'
    | ((config: RequestConfig) => string);



// 获取请求id，可以配置params、headers是否参与计算，也可以自定义生成id的方法将该方法覆盖
export const getRequestKey = (
    config: RequestConfig,
    key: RequestKey = 'url'
) => {
    const { url, params, data } = config;
    if (typeof key === 'function') {
        return key(config);
    }
    const createrObj: any = { url };
    if (key === 'urlParams') createrObj.params = Object.assign({}, params, data);
    return JSON.stringify(createrObj);
};



interface PluginConfig {
    onIntercept?: (msg: string) => any;
}

export interface ExtendRequestConfig {
    uuid?: string;
    raceKey?: string;
    raceCancelMsg?: string;
}

declare global {
    // eslint-disable-next-line @typescript-eslint/no-empty-interface
    interface RequestConfigExt extends ExtendRequestConfig { }
}

interface RequestItem {
    uuid: string;
    controller: AbortController;
    raceKey?: string;
}

const requestList: RequestItem[] = [];

const getRequestIndex = (key: string, raceKey?: string) => {
    return requestList?.findIndex((item) => {
        return raceKey
            ? item.uuid === key && item.raceKey === raceKey
            : item.uuid === key;
    });
};

/**
 * @description: 取消指定的接口请求
 * @param {string | string[]} url
 */
export const cancelRequest = (target: string | string[]) => {
    if (typeof target === 'string') {
        // 取消单个请求
        const sourceIndex = getRequestIndex(target);
        sourceIndex >= 0 && requestList[sourceIndex].controller.abort();
    } else {
        // 存在多个需要取消请求的地址
        target.forEach((uuid) => {
            const sourceIndex = getRequestIndex(uuid);
            sourceIndex >= 0 && requestList[sourceIndex].controller.abort();
        });
    }
};

/**
 * @description: 取消所有请求
 */
export const cancelAllRequest = () => {
    requestList.map((request) => {
        request.controller.abort();
    });
};

// 取消接口请求插件
export default function cancelPlugin(pluginConfig?: PluginConfig) {
    const { onIntercept } = pluginConfig || {};
    return ({ config, beforeRequest, afterRequest }: PluginCallbackParams) => {
        const { signal, raceKey, raceCancelMsg, uuid } = config;

        if (signal) {
            console.warn(
                `当前请求接口${config.url} --- 竞态取消/全局统一取消功能失效`
            );
            return;
        }

        const requestKey = uuid || getRequestKey(config);

        const controller = new AbortController();

        const requestItem: RequestItem = {
            uuid: requestKey,
            raceKey: raceKey,
            controller: controller
        };

        // // 请求之前，添加取消的配置
        beforeRequest(() => {
            return {
                ...config,
                // 增加取消的配置
                signal: controller.signal
            };
        });

        afterRequest((promise) => {
            // 需要竞态取消
            if (raceKey) {
                const sourceIndex = getRequestIndex(requestKey, raceKey);
                // 如果前面有未取消的请求则执行取消
                if (sourceIndex >= 0) {
                    const msg = raceCancelMsg || '竞态取消';
                    onIntercept && onIntercept(msg);
                    requestList[sourceIndex].controller.abort();
                }
            }

            // 将当前请求存入，让下一次请求能执行取消当前请求
            requestList.push(requestItem);

            // 当前请求响应后，清除对应的requestItem
            promise.finally(() => {
                const sourceIndex = requestList.findIndex(
                    (item) => item === requestItem
                );
                sourceIndex >= 0 && requestList?.splice(sourceIndex, 1);
            });
        });
    };
}