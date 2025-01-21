import { defineStore } from "pinia";
import Socket from "@/utils/socket";
import { WS_PATH } from "@/common";
import { useUserStore } from "@/store";

export enum Topic {
  DAY_MARKET = "DAY_MARKET",
  // FOREX_TRADE = "FOREX_TRADE",
  // FOREX_CLOSED = "FOREX_CLOSED",
}

interface WebSocketLister {
  params: Topic | string;
  callback: Array<(data: any) => void>;
}

const websocketStore = defineStore("websocket", () => {
  let socket: Socket;
  const listeners: WebSocketLister[] = [];

  let login_result = false;

  const initSocket = () => {
    if (socket) {
      removeAllListener();
      return;
    }
    socket = new Socket(WS_PATH, (data) => {
      try {
        const res = JSON.parse(data);
        mitts(res);
      } catch (error) {
        console.error("ws 数据序列化错误", error);
      }
    });
  };

  const login = (value?: string) => {
    if (login_result) {
      console.log("ws已登录");
      return;
    }
    const { isLogin, token } = useUserStore();
    if (!isLogin && !value) {
      console.warn("未登录");
      return;
    }
    socket.send({ params: value || token, type: "login" });
  };

  const logout = () => {
    if (!login_result) {
      console.log("ws未登录");
      return;
    }
    socket.send({ params: "", type: "logout" });
    login_result = false;
  };

  const mitts = (msg: any) => {
    const { type, code } = msg;
    if (!type) {
      console.warn("消息结果缺少类型", msg);
    }
    if (type === "login_result" && code === 1) {
      login_result = true;
      return;
    }
    const listener = listeners.find((listener) =>
      listener.params.startsWith(type)
    );
    listener && listener.callback.forEach((func) => func(msg));
  };

  const addListener = (params: string, cb: ((data: any) => void) | null) => {
    const listener = listeners.find((item) => item.params === params);
    if (listener && cb) {
      listener.callback.push(cb);
    } else {
      listeners.push({
        params,
        callback: cb ? [cb] : [],
      });
      socket.send({ params, type: "sub" });
    }
  };

  const removeListener = (params: string, cb: ((data: any) => void) | null) => {
    const index = listeners.findIndex((item) => item.params === params);
    if (index === -1) {
      console.warn("当前没有订阅该Topic", params);
      return;
    }
    const listener = listeners[index];
    const funcIndex = listener.callback.findIndex((item) => item === cb);
    if (funcIndex === -1) {
      console.warn("该Topic没有此回调", params);
      return;
    }
    socket.send({ params, type: "unsub" });
    listener.callback.splice(funcIndex, 1);
    if (listener.callback.length === 0) {
      listeners.splice(index, 1);
    }
  };

  const removeAllListener = () => {
    if (listeners.length) {
      listeners.forEach((item) => {
        socket.send({ params: item.params, type: "unsub" });
      });
      listeners.length = 0;
    }
  };

  const reconnect = () => {
    login_result = false;
    socket.reconnect();
  };

  const disconnect = () => {
    socket.disconnect();
  };

  return {
    login,
    logout,
    initSocket,
    addListener,
    removeListener,
    removeAllListener,
    reconnect,
    disconnect,
  };
});

export default websocketStore;
