import { defineStore } from "pinia";
import { langs } from "@/lang";
import { useI18n } from "vue-i18n";
import { getHashSearchParam } from "@/common";
import { Locale } from "vant";

const appStore = defineStore(
  "app",
  () => {
    const title = ref("DEMO");
    
    // 语言
    const lang = ref("en");

    const setLang = (locale: string) => {
      Locale.use(langs[locale].key, langs[locale].locale);
      lang.value = locale;
    };

    /**
     * 应用初始化
     */
    const initApp = () => {
      const { locale } = useI18n();

      // 检查url有无语言标识
      let language = getHashSearchParam("lang");
      // 根据url标识设置参数
      setLang(language && langs[language] ? language : lang.value);

      // 更新i18n显示语言
      if (locale.value !== lang.value) {
        locale.value = lang.value;
      }

    };

    return {
      title,
      lang,
      initApp,

      setLang
    };
  },
  {
    persist: {
      storage: localStorage,
    },
  }
);

export default appStore;
