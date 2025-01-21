import helper from "@/common/helper";

// 心跳间隔、重连websocket间隔，5秒
const interval = 5000;
// 重连最大次数
const maxReconnectMaxTime = 5;

export default class WS {
  constructor() {
    // WS实例
    this.socketTask = null;

    // 正常关闭
    this.normalCloseFlag = false;
    // 重新连接次数
    this.reconnectTime = 1;
    // 重新连接Timer
    this.reconnectTimer = null;
    // 心跳Timer
    this.heartTimer = null;
    // 是否连接成功
    this.connected = false;

    this.callBackList = [];

    this.reSubTopic = [];

    this.subTopic = [];

    // 发起连接
    this.initWS();

    // 关闭WS
    this.close = () => {
      // 正常关闭状态
      this.normalCloseFlag = true;
      // 关闭websocket
      this.socketTask.close();
      // 关闭心跳定时器
      clearInterval(this.heartTimer);
      // 关闭重连定时器
      clearTimeout(this.reconnectTimer);
    };
  }

  initWS() {
    // this.options.data 连接websocket所需参数
    const url = `wss://${helper._DOMAIN.replace(/^https?\:\/\//i, "")}/ws`;
    this.socketTask = uni.connectSocket({ url, success() {} });

    // 监听WS
    this.watchWS();
  }

  watchWS() {
    // 监听 WebSocket 连接打开事件
    this.socketTask.onOpen(() => {
      console.log("websocket连接成功！");

      this.connected = true;
      // 连接成功
      //   this.options.onConnected();
      // 重置连接次数
      this.reconnectTime = 1;
      // 发送心跳
      this.onHeartBeat();
      // 监听消息
      this.onMessage();

      if (this.reSubTopic.length) {
        this.Sub(this.reSubTopic);
        this.reSubTopic = [];
      }

      // 关闭Toast
      //   uni.hideLoading();
    });

    // 监听websocket 错误
    this.socketTask.onError(() => {
      this.connected = false;
      // 关闭并重连
      this.socketTask.close();
    });

    // 监听 WebSocket 连接关闭事件
    this.socketTask.onClose((res) => {
      this.connected = false;
      // 连接错误，发起重连接
      if (!this.normalCloseFlag) {
        this.onDisconnected(res);
      }
    });
  }

  Sub(params) {
    if (!this.connected) {
      this.reSubTopic = params;
      return;
    }

    if (Array.isArray(params)) {
      params.forEach((item) => {
        if (!this.subTopic.includes(item)) {
          this.subTopic.push(item);
          this.sendMessage({
            type: "sub",
            params: item,
          });
        }
      });
    } else {
      if (!this.subTopic.includes(params)) {
        this.subTopic.push(params);
        this.sendMessage({
          type: "sub",
          params,
        });
      }
    }
  }

  unSub(params) {
    if (Array.isArray(params)) {
      params.forEach((item) => {
        const index = this.subTopic.indexOf(item);
        if (index !== -1) {
          this.subTopic.splice(index, 1);
        }
        this.sendMessage({
          type: "unsub",
          params: item,
        });
      });
    } else {
      const index = this.subTopic.indexOf(params);
      if (index !== -1) {
        this.subTopic.splice(index, 1);
      }
      this.sendMessage({
        type: "unsub",
        params,
      });
    }
  }

  //   // 订阅topic
  sendMessage(msg) {
    this.socketTask.send({
      data: JSON.stringify(msg),
    });
  }

  // 回调函数的注册
  registerCallBack(callBack) {
    if(this.callBackList.includes(callBack)){
      return
    }
    this.callBackList.push(callBack)
  }

  // 取消某一个回调函数
  unRegisterCallBack(callBack) {
    const index = this.callBackList.indexOf(callBack)
    if(index!==-1){
      console.log('取消某一个回调函数');
      this.callBackList.splice(index, 1);
    }
  }

  // 监听消息
  onMessage() {
    // 监听websocket 收到消息
    this.socketTask.onMessage((res) => {
      //收到消息
      if (res.data) {
        this.callBackList.forEach((item)=>{
          item.call(this, JSON.parse(res.data))
        })
        // if (this.callBackMapping) {
        //   this.callBackMapping.call(this, JSON.parse(res.data));
        // }
      } else {
        console.log("未监听到消息：原因：", JSON.stringify(res));
      }
    });
  }

  // 断开连接
  onDisconnected(res) {
    console.log("websocket断开连接，原因：", JSON.stringify(res));
    // 关闭心跳
    clearInterval(this.heartTimer);
    // 全局Toast提示，防止用户继续发送
    // uni.showLoading({ title: "消息收取中…" });
    // 尝试重新连接
    this.onReconnect();
  }

  // 断线重连
  onReconnect() {
    clearTimeout(this.reconnectTimer);
    if (this.reconnectTime < maxReconnectMaxTime) {
      this.reconnectTimer = setTimeout(() => {
        console.log(`第【${this.reconnectTime}】次重新连接中……`);
        this.initWS();
        this.reconnectTime++;
      }, interval);
    } else {
      console.log("尝试连接失败");
    }
  }

  /** @心跳 **/
  onHeartBeat() {
    this.heartTimer = setInterval(() => {
      this.socketTask.send({
        data: "ping",
        success() {
          // console.log("心跳发送成功！");
        },
      });
    }, interval);
  }
}
