const { MODE } = import.meta.env;

export const isProd = MODE === "production";

const DEMO_URL = "https://api.coinsultra.com";

export const HTTP_BASE_URL = isProd && false
  ? window.location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, "//api.")
  : DEMO_URL;

// export const HTTP_BASE_URL = DEMO_URL;

export const WS_PATH = `wss://${HTTP_BASE_URL.replace(
  /^https?\:\/\//i,
  ""
)}/ws`;

export const FX_WS_PATH = `wss://${HTTP_BASE_URL.replace(
  /^https?\:\/\//i,
  ""
)}/v1/ws`;

export const isMobile = navigator.userAgent.match(
  /(phone|pad|pod|iPhone|iPod|ios|iPad|Android|Mobile|BlackBerry|IEMobile|MQQBrowser|JUC|Fennec|wOSBrowser|BrowserNG|WebOS|Symbian|Windows Phone)/i
);

const index = location.host.match(/\d+/g) ? location.host.match(/\d+/g)![0] : ''

export const mobileUrl = `${location.origin.replace(
  /\/\/[a-zA-Z0-9]+\./g,
  `//m${index}.`
)}`;

// 获取url上的参数
export function getHashSearchParam(key: string) {
  const url = location.href;
  // 获取 hash 值，不包含 '#' 号
  const hash = url.substring(url.indexOf("#") + 1);
  // 查找 '?' 号所在的索引
  const searchIndex = hash.indexOf("?");
  // '?' 号后面接的是索引参数，如果找到则+1，去除'?' 号
  const search = searchIndex !== -1 ? hash.substring(searchIndex + 1) : "";
  // 把搜索参数字符串提过URLSearchParams转成对象形式
  const usp = new URLSearchParams(search);
  // 通过URLSearchParams自带的get方法，查询键所对应的值
  return usp.get(key);
}

export enum TradeType {
  BUY = 'buy',
  SELL = 'sell'
}

// 时区配置
export const TIMEZONE = 'UTC'

export const appLink = `${location.origin.replace(/\/\/[a-zA-Z0-9]+\./g, "//m.")}/app`

export const downloadApp = () => {
  window.open(appLink)
}
