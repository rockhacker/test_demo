<template>
  <view>
    <web-view :src="url"></web-view>
  </view>
</template>
<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      url: "",
    };
  },
  computed: {
    ...mapState(["theme"]),
  },
  onLoad(e) {
    this.$utils.setThemeTop(this.theme);
    this.url = `https://direct.lc.chat/14362266/`;
    // this.customerService()
  },
  methods: {
    customerService() {
      let that = this;
      //获取用户信息
      that.$utils.initDataToken({ url: "user/info", type: "get" }, (res) => {
        console.log(res);
        let visiter_name = "";
        if (res && res.uid) visiter_name = res.uid;
        this.url = `https://chat.cointigerex.cc/index/index/home?visiter_id=&visiter_name=${visiter_name}&avatar=&groupid=0&business_id=3`;
      });
    },
  },
};
</script>
