<template>
  <view class="">
    <!-- <view class="status_bar">
			<view class="top_view"></view>
		</view> -->
    <web-view :src="url"></web-view>
  </view>
</template>
<script>
export default {
  data() {
    return {
      url: "",
    };
  },
  onLoad(e) {
    this.url = `/hybrid/html/second.html?legal_id=${e.legal_id}&currency_id=${e.currency_id}&symbol=${e.symbol}&currency_match_id=${e.currency_match_id}`;
  },
};
</script>

<style></style>
