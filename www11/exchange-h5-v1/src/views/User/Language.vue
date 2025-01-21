<template>
    <nav-bar :title="$t('func.lang')" />

    <div class="px-10 pb-20">
        <div class="flex items-center h-60 rounded-[24px] mt-10 px-20 bg-#383838" v-for="(item, index) in langOption"
            :key="item.value" :class="[
                item.value === lang ? 'text-up' : 'text-white',
            ]" @click="handleClick(item.value)">
            <img class="w-26 h-18 mr-20" :src="item.img" />
            <span>{{ item.text }}</span>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { langOption } from "@/lang";
import { useAppStore } from "@/store";
import { useI18n } from "vue-i18n";

const { lang } = storeToRefs(useAppStore());
const { setLang } = useAppStore();
const { locale } = useI18n();
const router = useRouter();

const handleClick = (val: string) => {
    if (lang.value === val) {
        return;
    }
    setLang(val);
    locale.value = val;
    router.go(-1);
};
</script>
