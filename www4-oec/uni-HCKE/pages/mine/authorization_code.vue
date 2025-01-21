<template>
  <view :class="theme">
    <view class="bg-white dark:bg-floor p-40">
      <view class="p-40 flex items-center justify-center">
        <text>{{ $t("bind.codeauth") }}：</text>
        <text class="text-xl font-bold ml-20">{{ code || "-- --" }}</text>
      </view>
      <view class="p-40 text-sm text-center">{{ $t("bind.codetip") }}</view>
    </view>
  </view>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      code: "",
    };
  },
  onLoad() {
    uni.setNavigationBarTitle({
      title: this.$t("bind.codeauth"),
    });
  },
  onShow() {
    this.$utils.setThemeTop(this.theme);
    this.getInfo();
  },
  methods: {
    getInfo() {
      this.$utils.initDataToken({ url: "user/authorization_code" }, (res) => {
        this.code = res;
      });
    },
  },
  computed: {
    ...mapState(["theme"]),
  },
};
</script>
