import { createI18n } from "vue-i18n";

import zh from "./zh-CN.json";
import hk from "./zh-TW.json";
import en from "./en.json";
import jp from "./ja.json";
import kr from "./ko.json";
import th from "./th.json";
import vn from "./vi.json";
import fr from "./fr.json";
import de from "./de.json";
import ru from "./ru.json";
import spa from "./es.json";
import pt from "./pt.json";
import ar from "./ar.json";
import it from "./it.json";
import tr from "./tr.json";

import enUS from "vant/es/locale/lang/en-US";
import zhHK from "vant/es/locale/lang/zh-HK";
import jaJP from "vant/es/locale/lang/ja-JP";
import koKR from "vant/es/locale/lang/ko-KR";
import thTH from "vant/es/locale/lang/th-TH";
import viVN from "vant/es/locale/lang/vi-VN";
import frFR from "vant/es/locale/lang/fr-FR";
import deDE from "vant/es/locale/lang/de-DE";
import ruRU from "vant/es/locale/lang/ru-RU";
import esES from "vant/es/locale/lang/es-ES";
import ptBR from "vant/es/locale/lang/pt-BR";
import itIT from "vant/es/locale/lang/it-IT";
import trTR from "vant/es/locale/lang/tr-TR";
import zhCN from "vant/es/locale/lang/zh-CN";

export enum Locale {
  hk = "hk",
  en = "en",
  jp = "jp",
  kr = "kr",
  th = "th",
  vn = "vn",
  fr = "fr",
  de = "de",
  ru = "ru",
  spa = "spa",
  pt = "pt",
  ar = "ar",
  it = "it",
  tr = "tr",
  zh = "zh"
}

function getLangIcon(name: string, suffix = 'png') {
  return new URL(`../assets/lang/${name}.${suffix}`, import.meta.url).href;
}

export const langs: any = {
  [Locale.en]: {
    value: "en",
    message: en,
    key: "en-US",
    locale: enUS,
    text: "English",
    icon: getLangIcon("en"),
  },
  [Locale.jp]: {
    value: "jp",
    message: jp,
    key: "ja-JP",
    locale: jaJP,
    text: "日本語",
    icon: getLangIcon("jp"),
  },
  [Locale.kr]: {
    value: "kr",
    message: kr,
    key: "ko-KR",
    locale: koKR,
    text: "한국어",
    icon: getLangIcon("kr"),
  },
  [Locale.hk]: {
    value: "hk",
    message: hk,
    key: "zh-HK",
    locale: zhHK,
    text: "繁体中文",
    icon: getLangIcon("hk"),
  },
  [Locale.th]: {
    value: "th",
    message: th,
    key: "th-TH",
    locale: thTH,
    text: "ไทย",
    icon: getLangIcon("th"),
  },
  [Locale.vn]: {
    value: "vn",
    message: vn,
    key: "vi-VN",
    locale: viVN,
    text: "Tiếng Việt",
    icon: getLangIcon("vn"),
  },
  [Locale.fr]: {
    value: "fr",
    message: fr,
    key: "fr-FR",
    locale: frFR,
    text: "français",
    icon: getLangIcon("fr"),
  },
  [Locale.de]: {
    value: "de",
    message: de,
    key: "de-DE",
    locale: deDE,
    text: "Deutsche",
    icon: getLangIcon("de"),
  },
  [Locale.ru]: {
    value: "ru",
    message: ru,
    key: "ru-RU",
    locale: ruRU,
    text: "Русский язык",
    icon: getLangIcon("ru"),
  },
  [Locale.spa]: {
    value: "spa",
    message: spa,
    key: "es-ES",
    locale: esES,
    text: "Español",
    icon: getLangIcon("spa"),
  },
  [Locale.pt]: {
    value: "pt",
    message: pt,
    key: "pt-BR",
    locale: ptBR,
    text: "Português",
    icon: getLangIcon("pt"),
  },
  [Locale.it]: {
    value: "it",
    message: it,
    key: "it-IT",
    locale: itIT,
    text: "Italiano",
    icon: getLangIcon("it"),
  },
  [Locale.ar]: {
    value: "ar",
    message: ar,
    key: "en-US",
    locale: enUS,
    text: "عربي",
    icon: getLangIcon("ar"),
  },
  [Locale.tr]: {
    value: "tr",
    message: tr,
    key: "tr-TR",
    locale: trTR,
    text: "Türkçe",
    icon: getLangIcon("tr"),
  },
  [Locale.zh]: {
    value: "zh",
    message: zh,
    key: "zh-CN",
    locale: zhCN,
    text: "中文",
    icon: getLangIcon("zh"),
  },
};

export const langOption = Object.keys(langs).map((key) => {
  return {
    text: langs[key].text,
    value: langs[key].value,
    img: langs[key].icon,
  };
});


const messages: any = {};
Object.keys(langs).map((key) => {
  messages[key] = langs[key].message;
});

const i18n = createI18n({
  globalInjection: true,
  locale: Locale.zh,
  messages,
  legacy: false,
});


export default i18n;
