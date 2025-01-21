<template>
  <el-select class="lang-options" :modelValue="lang" @change="handleChange">
    <el-option v-for="item in langOption" :key="item.value" :label="item.text" :value="item.value">
      <div class="flex items-center">
        <el-image loading="lazy" class="w-40 h-20" :src="item.img" />
        <span class="pl-10">{{ item.text }}</span>
      </div>
    </el-option>
  </el-select>
</template>

<script lang="ts" setup>
import { langOption } from "@/lang";
import { useAppStore } from "@/store";
import { useI18n } from "vue-i18n";

const { lang } = storeToRefs(useAppStore());
const { setLang } = useAppStore();

const { locale } = useI18n();

const emits = defineEmits(["onChange"]);

const handleChange = (val: string) => {
  setLang(val);
  if (locale.value !== lang.value) {
    locale.value = lang.value;
    emits("onChange", locale.value);
    location.reload();
  }
};
</script>

<style lang="scss">
.lang-options {
  --el-text-color-regular: white;

  .el-select__wrapper {
    border-radius: 8px;
    box-shadow: none;
    background-color: #505257;

    .el-select__caret {
      color: white;
    }
  }
}
</style>