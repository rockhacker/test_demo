<template>
  <view class="text-black">
    <!-- <uni-nav-bar fixed backIcon>
            <view class="absolute -z-20 right-0 left-0 flex-1 p-30 bg-white dark:bg-1C2532 flex justify-center items-center text-3xl">
            {{$t('new.hdjs')}}
        </view>
    </uni-nav-bar> -->
    <image  src="/static/image/suocang.jpg" class="w-750 h-360"></image>
    <view class="px-20 text-xl">
        新幣挖礦，流動性挖礦雙上線，DeFi市場全面開放
    </view>
    <view class="px-20  text-xl mt-40 mb-20">
        活動内容:
    </view>
    <view class="px-20  text-xl">
        即刻鎖倉EHX，每日領取挖礦獎勵！TEST全球站於2023年1月1日00:00（UTC+8）開啟了“鎖倉EHX參與DeFi流動性挖礦”一期活動，一期活動首批提供1.5億USDT等值的區塊鏈資產用於DeFi流動性挖礦。挖礦產生的獎勵將全部回饋給參與活動鎖倉EHX的用戶，WEB端和APP端都可以參與一鍵鎖倉活動。
    </view>

    <image  src="/static/image/suocang_desc.png" class="w-750 h-450"></image>

    <view class="px-20 text-xl">
        獎勵形式：
    </view>
    <view class="px-20  text-xl mt-20">
        獎勵流動性挖礦所得本幣（EHX），獎勵數額視流動性池實際獎勵情況而定，可能會有較大波動。
    </view>
    <view class="px-20  text-xl mt-40">
        獎勵發放：
    </view>
    <view class="px-20  text-xl">
        T日（當日）鎖倉，T+1（次日）開始發放獎勵；
    </view>
    <view class="px-20  text-xl">
        獎勵計算週期為前日12:00（UTC+8）—當日12:00（UTC+8）；
    </view>
    <view class="px-20  text-xl">
        獎勵發放時間為您當日鎖倉時間計算，每日發放至幣幣賬戶；
    </view>
    <view class="px-20  text-xl">
        EHX鎖倉後在幣幣賬戶為鎖倉狀態，EHX會在鎖倉結束當日自動解鎖，無需用戶手動操作。
    </view>
    <view class="px-20  text-xl">
        活動期間，嚴禁出現作弊行為，一經發現將直接取消獎勵。
    </view>
    <view class="px-20  text-xl mt-20">
        以上規則TEST官方保留隨時修訂、暫停、終止本活動任何相關條款之權利及其最終解釋權。
    </view>
    <view class="px-20  text-xl mt-40">
        TEST感謝您的支持與厚愛
    </view>
    <view class="px-20  text-xl">
        TEST 團隊
    </view>
    <view class="px-20 pb-40  text-xl">
        2023年1月1日
    </view>
  </view>
</template>

<script>
import {mapState} from 'vuex'
export default {
    computed:{
	   ...mapState(['theme']),
	},
    onLoad(options) {
		uni.setNavigationBarTitle({
			title: this.$t("new.hdjs")
		})
	},
	onShow() {
		this.$utils.setThemeTop(this.theme);
	},
}
</script>

<style>

</style>