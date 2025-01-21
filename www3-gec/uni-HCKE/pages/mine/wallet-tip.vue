<template>
    <view :class="theme">
        <view class="bg-white dark:bg-1C2532 text-black dark:text-white pb-30" style="min-height: 100vh;">
            <view class="flex items-center justify-center">
                <image src="/static/wallet/is-browser.png" class="w-660"></image>
            </view>

            <view class="text-center mt-100 text-3xl">{{ $t('wallet.please_connect') }}</view>

            <view class="text-center w-500 text-gray-400 mt-100 text-lg mx-auto">{{ $t('wallet.dapp') }}</view>

            <view class="bg-black text-white rounded-8 mx-20 py-20 text-center text-lg mt-100">{{ $t('wallet.login') }}</view>
        </view>
    </view>
</template>
<script>
import { mapState } from 'vuex';
export default {
    data() {
        return {
        }
    },
    computed: {
        ...mapState(['theme'])
    },
    onLoad(e) {
        this.$utils.setThemeTop(this.theme)
    },
    methods: {
    }
}
</script>
