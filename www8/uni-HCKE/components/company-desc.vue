<template>
    <view class="text-white" :class="theme">
        <view class="text-center text-3xl font-bold mt-60 px-40">
            {{ $t('company.shijie') }}
        </view>
        <view class="text-12 mt-40 px-60 text-center">
            {{ $t('company.all') }}
        </view>

        <view class="flex items-center px-100 justify-between mt-60">
            <image class="min-w-122 w-122 h-122" src="/static/image/safe-icon.png"></image>
            <view class="ml-60">
                <view class="text-xl font-bold">{{ $t('company.an') }}</view>
                <view class="text-12 mt-10">{{ $t('company.zai') }}</view>
            </view>
        </view>

        <view class="flex items-center px-100 justify-between mt-60">
            <view class="mr-60">
                <view class="text-xl font-bold">{{ $t('company.shis') }}</view>
                <view class="text-12 mt-10">{{ $t('company.wo') }}</view>
                <view class="text-12 mt-10">{{ $t('company.zuo') }}</view>
            </view>
            <image class="min-w-122 w-122 h-122" src="/static/image/global-icon.png"></image>
        </view>

        <view class="flex items-center px-100 justify-between mt-60">
            <image class="min-w-122 w-122 h-122" src="/static/image/user-first-icon.png"></image>
            <view class="ml-60">
                <view class="text-xl font-bold">{{ $t('company.hu') }}</view>
                <view class="text-12 mt-10">{{ $t('company.jian') }}</view>
                <view class="text-12 mt-10">{{ $t('company.li') }}</view>
            </view>
        </view>

        <view class="text-center text-3xl font-bold mt-60 px-40">
            {{ $t('company.kai') }}
        </view>

        <view class="flex items-center px-80 justify-between mt-60">
            <image class="min-w-200 w-200 h-200" src="/static/image/fee-icon.png"></image>
            <view class="ml-60">
                <view class="text-xl font-bold">{{ $t('company.shou') }}</view>
                <view class="text-12 mt-10">{{ $t('company.shi') }}</view>
            </view>
        </view>

        <view class="flex items-center px-80 justify-between mt-60">
            <view class="mr-60">
                <view class="text-xl font-bold">{{ $t('company.fe') }}</view>
                <view class="text-12 mt-10">{{ $t('company.you') }}</view>
                <view class="text-12 mt-10">{{ $t('company.hui') }}</view>
            </view>

            <image class="min-w-200 w-200 h-200" src="/static/image/fast-icon.png"></image>
        </view>

        <view class="flex items-center px-80 justify-between mt-60">
            <image class="min-w-200 w-200 h-200" src="/static/image/server-icon.png"></image>
            <view class="ml-60">
                <view class="text-xl font-bold">{{ $t('company.ke') }}</view>
                <view class="text-12 mt-10">{{ $t('company.quan') }}</view>
                <view class="text-12 mt-10">{{ $t('company.di') }}</view>
            </view>
        </view>

        <view class="text-12 px-40 mt-60 text-12 text-center">{{ $t('company.jiec') }}</view>
    </view>
</template>
<script>
import { mapState } from 'vuex';
export default {
    data() {
        return {
            url: ''
        }
    },
    computed: {
        ...mapState(['theme'])
    },
    onLoad(e) {
    },
    methods: {

    }
}
</script>
