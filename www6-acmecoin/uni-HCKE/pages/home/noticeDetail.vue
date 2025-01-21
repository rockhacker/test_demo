<template>
  <view class="p-30">
    <view class="text-white text-xl font-bold">{{ info.title }}</view>
    <view class="text-gray1 mt-30">{{ info.created_at }}</view>
    <view class="mt-60 text-white" v-html="info.content">

    </view>
  </view>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      info: {},
    };
  },
  computed: {
    ...mapState(["theme"]),
  },
  onLoad(e) {
    this.$utils.setThemeTop(this.theme);
    uni.setNavigationBarTitle({
      title: this.$t("www.gg"),
    });
    this.info = uni.getStorageSync("noticeInfo");
    console.log(this.info);
  },
};
</script>

<style></style>
