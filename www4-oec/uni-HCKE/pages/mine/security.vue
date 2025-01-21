<template>
  <view :class="theme">
    <view class="bg-white dark:bg-floor min-h-screen">
      <navigator
       v-if="!isWallet"
        url="/pages/mine/modifyPwdNext"
        class="py-40 px-20 text-lg flex items-center justify-between border-0 border-solid border-b-2 border-gray-200 dark:border-gray-700"
      >
        <span>{{ $t("login.s_loginpwd") }}</span>
        <span class="flex items-center"
          >{{ $t("login.s_edit")
          }}<image
            src="../../static/image/mores.png"
            class="w-30 h-30 ml-20"
          ></image
        ></span>
      </navigator>
      <navigator
        url="/pages/mine/resetLegalPwd"
        class="py-40 px-20 text-lg flex items-center justify-between border-0 border-solid border-b-2 border-gray-200 dark:border-gray-700"
      >
        <span>{{ $t("new.zij") }}</span>
        <span class="flex items-center"
          >{{ $t("login.s_edit")
          }}<image
            src="../../static/image/mores.png"
            class="w-30 h-30 ml-20"
          ></image
        ></span>
      </navigator>
    </view>
  </view>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      isWallet:false
    };
  },
  onLoad() {
    uni.setNavigationBarTitle({
      title: this.$t("login").security,
    });
    this.isWallet = uni.getStorageSync('walletLogin')
  },
  computed: {
    ...mapState(["theme"]),
  },
  onShow() {
    this.$utils.setThemeTop(this.theme);
  },
};
</script>

<style></style>
