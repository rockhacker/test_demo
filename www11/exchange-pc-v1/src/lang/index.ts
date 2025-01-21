import { createI18n } from "vue-i18n";
import { Locale } from "@/enum";
import useImage from "@/hooks/useImage";

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
import id from "./id.json";

import enUS from "element-plus/dist/locale/en.mjs";
import zhHK from "element-plus/dist/locale/zh-tw.mjs";
import jaJP from "element-plus/dist/locale/ja.mjs";
import koKR from "element-plus/dist/locale/ko.mjs";
import thTH from "element-plus/dist/locale/th.mjs";
import viVN from "element-plus/dist/locale/vi.mjs";
import frFR from "element-plus/dist/locale/fr.mjs";
import deDE from "element-plus/dist/locale/de.mjs";
import ruRU from "element-plus/dist/locale/ru.mjs";
import esES from "element-plus/dist/locale/es.mjs";
import ptBR from "element-plus/dist/locale/pt.mjs";
import itIT from "element-plus/dist/locale/it.mjs";
import arAR from "element-plus/dist/locale/ar.mjs";
import trTR from "element-plus/dist/locale/tr.mjs";
import idID from "element-plus/dist/locale/id.mjs";

const { getImageUrl } = useImage();

export const langs: any = {
  [Locale.en]: {
    value: "en",
    message: en,
    key: "en-US",
    locale: enUS,
    text: "English",
    icon: new URL(`../assets/lang/en.png`, import.meta.url).href
  },
  [Locale.jp]: {
    value: "jp",
    message: jp,
    key: "ja-JP",
    locale: jaJP,
    text: "日本語",
    icon: new URL(`../assets/lang/jp.png`, import.meta.url).href,
  },
  [Locale.kr]: {
    value: "kr",
    message: kr,
    key: "ko-KR",
    locale: koKR,
    text: "한국어",
    icon: new URL(`../assets/lang/kr.png`, import.meta.url).href,
  },
  [Locale.hk]: {
    value: "hk",
    message: hk,
    key: "zh-HK",
    locale: zhHK,
    text: "繁体中文",
    icon: new URL(`../assets/lang/hk.png`, import.meta.url).href,
  },
  [Locale.th]: {
    value: "th",
    message: th,
    key: "th-TH",
    locale: thTH,
    text: "ไทย",
    icon: new URL(`../assets/lang/th.png`, import.meta.url).href,
  },
  [Locale.vn]: {
    value: "vn",
    message: vn,
    key: "vi-VN",
    locale: viVN,
    text: "Tiếng Việt",
    icon: new URL(`../assets/lang/vn.png`, import.meta.url).href,
  },
  [Locale.fr]: {
    value: "fr",
    message: fr,
    key: "fr-FR",
    locale: frFR,
    text: "français",
    icon: new URL(`../assets/lang/fr.png`, import.meta.url).href,
  },
  [Locale.de]: {
    value: "de",
    message: de,
    key: "de-DE",
    locale: deDE,
    text: "Deutsche",
    icon: new URL(`../assets/lang/de.png`, import.meta.url).href,
  },
  [Locale.ru]: {
    value: "ru",
    message: ru,
    key: "ru-RU",
    locale: ruRU,
    text: "Русский язык",
    icon: new URL(`../assets/lang/ru.png`, import.meta.url).href,
  },
  [Locale.spa]: {
    value: "spa",
    message: spa,
    key: "es-ES",
    locale: esES,
    text: "Español",
    icon: new URL(`../assets/lang/spa.png`, import.meta.url).href,
  },
  [Locale.pt]: {
    value: "pt",
    message: pt,
    key: "pt-BR",
    locale: ptBR,
    text: "Português",
    icon: new URL(`../assets/lang/pt.png`, import.meta.url).href,
  },
  [Locale.it]: {
    value: "it",
    message: it,
    key: "it-IT",
    locale: itIT,
    text: "Italiano",
    icon: new URL(`../assets/lang/it.png`, import.meta.url).href,
  },
  [Locale.ar]: {
    value: "ar",
    message: ar,
    key: "ar-AR",
    locale: arAR,
    text: "عربي",
    icon: new URL(`../assets/lang/ar.png`, import.meta.url).href,
  },
  [Locale.tr]: {
    value: "tr",
    message: tr,
    key: "tr-TR",
    locale: trTR,
    text: "Türkçe",
    icon: new URL(`../assets/lang/tr.png`, import.meta.url).href,
  },
  [Locale.id]: {
    value: "id",
    message: id,
    key: "id-ID",
    locale: idID,
    text: "Indonesia",
    icon: new URL(`../assets/lang/id.png`, import.meta.url).href,
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
  locale: Locale.en,
  messages,
  legacy: false,
});

export default i18n;
