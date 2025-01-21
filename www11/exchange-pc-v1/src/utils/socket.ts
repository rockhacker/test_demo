export default class Socket {
  constructor(url: string, cb: (data: any) => void) {
    this.url = url;
    this.cb = cb;
    this.connect();
  }
  private readonly url: string = "";
  // cb: 存储回调函数
  private cb?: (data: any) => void;
  // 和服务端连接的socket对象
  private ws?: WebSocket;
  private remainPayload: any[] = [];
  private promise?: Promise<any> | null;
  // 心跳定时器实例
  private heartTime: any;
  // 心跳次数
  private socketHeart: number = 0;
  // 错误次数
  private socketError: number = 0;
  // 心跳超时时间
  private HeartTimeOut: number = 5000;

  public connect() {
    if (this.promise) return this.promise;

    let timer: number | null;

    this.promise = new Promise<void>((resolve, reject) => {
      const ws = new WebSocket(this.url);
      ws.onopen = (e) => {
        console.info("ws open 连接成功", e);
        this.remainPayload.forEach((payload) => {
          ws.send(payload);
        });
        // this.resetHeart();
        resolve();
      };

      // 得到服务端发送过来的数据
      ws.onmessage = (e) => {
        try {
          this.cb && this.cb(e.data)
        } catch (error) {
          console.error('ws onmesssage error:', error);
        }
      };

      ws.onerror = (e) => {
        console.error("ws error", e);
        this.reconnect()
      };

      // ws断开 需要重连
      ws.onclose = (e) => {
        console.info("ws close", e);
      };

      timer = setTimeout(() => {
        reject();
      }, 5000);

      this.ws = ws;
    });

    this.promise.finally(() => {
      typeof timer === "number" && clearTimeout(timer);
      this.promise = timer = null;
    });
  }

  private resetHeart = () => {
    this.socketHeart = 0;
    this.socketError = 0;
    clearInterval(this.heartTime);
    this.sendSocketHeart();
  };

  private sendSocketHeart() {
    this.heartTime = setInterval(() => {
      if (this.socketHeart <= 2) {
        this.ws?.send("ping");
        this.socketHeart++;
      } else {
        this.reconnect();
      }
    }, this.HeartTimeOut);
  }

  public async send(payload: any) {
    if (!payload) return;
    this.promise && (await this.promise);
    this.remainPayload.push(JSON.stringify(payload));
    if (this.isConnected) {
      this.ws?.send(JSON.stringify(payload));
    } else {
      this.connect();
    }
  }

  private get isConnected() {
    return this.ws && this.ws.readyState === WebSocket.OPEN;
  }

  public reconnect = () => {
    // if (this.socketError <= 2) {
    console.log("reconnect");

    this.ws?.close() && (this.ws = undefined);
    this.connect();
    this.socketError++;
    console.log("socket重连", this.socketError);
    // } else {
    // console.log("重试次数已用完的逻辑", this.socketError);
    // clearInterval(this.heartTime);
    // }
  };

  public disconnect() {
    clearInterval(this.heartTime);
    this.ws?.close() && (this.ws = undefined);
  }
}
