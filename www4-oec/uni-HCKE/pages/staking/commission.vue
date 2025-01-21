<template>
  <view class="min-h-full bg-floor pt-30">
    <view class="w-full px-20 pb-20 text-white">
      <view class="p-40 rounded-lg bg-new-black">
        <view class="flex justify-between">
          <view class="text-2xl">{{ $t("staking.zc") }}</view>
          <image
            src="/static/image/a.png"
            class="w-40 h-40"
            v-if="active"
            @click="active = false"
          ></image>
          <image
            src="/static/image/b.png"
            class="w-40 h-40"
            v-else
            @click="active = true"
          ></image>
        </view>
        <view class="my-20">{{ $t("staking.syzh") }} (USDT) </view>
        <view class="my-20 text-2xl">{{ active ? total : "******" }} </view>
        <text class="px-20 py-10 bg-deep-green rounded-3xl">
          {{ active ? `${$t("new.keyong")} :${balance}` : "****" }}
        </text>
      </view>
    </view>
    <view class="mt-30">
      <view class="bg-gray-600 flex items-center justify-between py-20 text-xl">
        <view class="flex1 text-center">
          {{ $t("staking.lixi") }}
        </view>
        <view class="flex1 text-center">
          {{ $t("staking.time") }}
        </view>
      </view>
      <view
        class="bg-new-black flex items-center justify-between py-20 text-xl border-0 border-solid border-b-2 border-gray-500"
        v-for="item in list"
        :key="item.id"
      >
        <view class="flex1 text-center">
          {{ parseFloat(item.value) }} {{ item.currency_code }}
        </view>
        <view class="flex1 text-center">
          {{ item.created_at }}
        </view>
      </view>
    </view>
  </view>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      active: false,
      total: "",
      balance: "",
      list: [],
      hasMore: false,
      page: 1,
    };
  },
  computed: {
    ...mapState(["theme"]),
  },
  onLoad(options) {
    uni.setNavigationBarTitle({
      title: this.$t("staking.commission"),
    });
    this.getData();
  },
  onShow() {
    this.$utils.setThemeTop(this.theme);
  },
  onReachBottom() {
    if (!this.hasMore) {
      return;
    }
    this.page++;
    this.getData();
  },
  methods: {
    getData() {
      this.$utils.initDataToken(
        {
          url: "fund/commissionDetail",
          data: {
            limit: 100,
            page: this.page,
          },
        },
        (res) => {
          this.balance = res.balance;
          this.total = res.total;
          this.list =
            this.page == 1 ? res.list.data : this.list.concat(res.list.data);
          this.hasMore =
            res.list.last_page <= res.list.current_page ? false : true;
          console.log(res);
        }
      );
    },
  },
};
</script>

<style></style>
