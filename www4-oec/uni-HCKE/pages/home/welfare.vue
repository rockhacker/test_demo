<template>
  <view :class="theme">
    <view
      class="min-h-screen text-black dark:text-white bg-white dark:bg-new-black"
    >
    <!-- 
      style="background:#111520;" -->
      <!-- <img class="h-250 w-full absolute" src="../../static/image/welfare-banner.png" alt="" /> -->
      <view class="h-250 w-full" style="background-size: 100% 100%;background-image: url(/h5/static/image/welfare-banner.png);"></view>
      <view class="bg-white dark:bg-black p-30 flex items-center rounded-t-4xl" style="margin-top: -40rpx;">
        <view
          class="flex flex-col items-center justify-center mr-20"
          :class="{ 'text-primary': active == 0 }"
          @tap="active = 0"
        >
          <view class="text-xl mb-30">{{ $t("new.tdrw") }}</view>
          <view class="h-4 w-60 bg-primary" v-if="active == 0"></view>
        </view>
        <view
          class="flex flex-col items-center justify-center"
          :class="{ 'text-primary': active == 1 }"
          @tap="active = 1"
        >
          <view class="text-xl mb-30">{{ $t("new.qd") }}</view>
          <view class="h-4 w-60 bg-primary" v-if="active == 1"></view>
        </view>
      </view>
      <team ref="team" v-show="active == 0"></team>
      <sign-in v-show="active == 1"></sign-in>
    </view>
  </view>
</template>

<script>
import { mapState } from "vuex";
import signIn from "./signIn.vue";
import team from "./team.vue";

export default {
  components: {
    signIn,
    team,
  },
  data() {
    return {
      active: 0,
    };
  },
  computed: {
    ...mapState(["theme"]),
  },
  onLoad(e) {
    this.$utils.setThemeTop(this.theme);
    uni.setNavigationBarTitle({
      title: this.$t("new.flzx"),
    });
  },
  onReachBottom() {
    this.$refs.team.getMoreData();
  },
};
</script>

<style></style>
