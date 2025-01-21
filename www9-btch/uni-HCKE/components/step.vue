<template>
    <view class="page-main">
        <view class="step">
            <liu-step-bar :step="status" :stepList="stepList" @clickStep="clickStep"></liu-step-bar>
        </view>
    </view>
</template>

<script>
    export default {
        data() {
            return {
                stepList: [{
                    name: this.$t('add.zhzc'),
                    id: 1
                }, {
                    name: this.$t('add.smrz'),
                    id: 2
                }, {
                    name: this.$t('add.aqbd'),
                    id: 3
                }, {
                    name: this.$t('add.qjy'),
                    id: 4
                }], //步骤列表
            }
        },
        props:['status'],
        methods: {
            //点击步骤
            clickStep(e) {
                console.log('所点击步骤信息:', e)
            }
        }
    }
</script>

<style lang="scss">
    .page-main {
        height: auto;

        .step {
            margin-top: 30rpx;
            padding: 0 30rpx;
        }
    }
</style>