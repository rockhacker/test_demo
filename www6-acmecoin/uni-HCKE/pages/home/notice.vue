<template>
  <view :class="theme">
    <view
      class="dark:bg-box mt-26 p-30 flex items-center justify-between"
      v-for="(item, index) in list"
      :key="index"
      @click="toDetail(item)"

    >
      <view>
        <view class="text-white text-xl font-bold">{{ item.title }}</view>
        <view class="text-gray1 mt-6">{{ item.created_at }}</view>
      </view>
      <image src="/static/image/mores.png" class="w-40 h-40"></image>
    </view>
    <view class="mt-100 text-center p-100" v-if="list.length == 0">
      <image src="/static/image/nodata.png" class="w-100 h-100"></image>
      <view class="text-gray-500 mt-20">{{ $t("home.norecord") }}</view>
    </view>
  </view>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      list: [],
    };
  },
  computed: {
    ...mapState(["theme"]),
  },
  onLoad(e) {
    this.$utils.setThemeTop(this.theme);
    uni.setNavigationBarTitle({
      title: this.$t("www.gdgg"),
    });
    this.getList();
  },
  methods: {
    getList() {
      try {
        this.$utils.initDataToken(
          {
            url: "news/list?category_id=0&limit=100",
          },
          (res) => {
            this.list = res.data;
            console.log(res);
          }
        );
      } catch (e) {
        console.log(e);
        //TODO handle the exception
      }
    },
    toDetail(item) {
      uni.setStorageSync('noticeInfo',item)
      uni.navigateTo({ url: "/pages/home/noticeDetail" });
    },
  },
};
</script>

<style></style>
