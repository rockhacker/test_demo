<template>
    <nav-bar>
        <template #right>
            <van-icon name="chat" size="1.8rem" color="#fff" />
        </template>
    </nav-bar>

    <div class="px-12 mt-12 pb-140" v-if="orderDetail">
        <div class="flex items-center">
            <van-icon name="todo-list-o" size="1.8rem" color="#9FEF4E" />
            <span class="pl-8 text-20">{{ getStatusLabel(orderDetail.status, orderDetail.way) }}</span>
        </div>
        <div class="text-12 mt-4">{{ statusTip }}</div>

        <div class="mt-10 text-20 text-yellow">
            {{ orderDetail.amount }} {{ orderDetail.area_info.currency }}
        </div>

        <div class="text-12 mt-10">
            <div>
                <span>{{ $t('legal.unit') }}</span>
                <span class="pl-10">{{ orderDetail.price }} {{ orderDetail.area_info.currency }}</span>
            </div>
            <div class="mt-4">
                <span>{{ $t('legal.amount') }}</span>
                <span class="pl-10">{{ orderDetail.number }} {{ orderDetail.currency_name }}</span>
            </div>
        </div>

        <div class="mt-10 text-12" v-if="bankData">
            <div class="text-12 flex items-center">
                <van-icon name="card" size="1.8rem" color="#9FEF4E" />
                <span class="pl-4">{{ $t('collection.bank_card') }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-14">{{ bankData.card_no }}</span>
                <van-icon class="p-6" name="description" size="1.4rem" @click="onCopy(bankData.card_no)" />
            </div>

            <div class="flex items-center justify-between">
                <span>{{ $t('collection.collection_name') }}:{{ bankData.real_name }}</span>
                <span>{{ bankData.bank_name }}({{ bankData.bank_address }})</span>
            </div>

            <div class="mt-4"> {{ bankData.bank_code }} </div>
            <van-divider class="my-12" />

            <div class="flex items-center justify-between">
                <div> {{ $t('collection.pay_reference_code') }} </div>
                <div>{{ orderDetail.id }}</div>
            </div>
            <van-divider class="my-12" />

            <div class="flex items-center justify-between">
                <div> {{ $t('collection.submit_time') }} </div>
                <div>{{ orderDetail.created_at }}</div>
            </div>
            <van-divider class="my-12" />

            <template v-if="orderDetail.status !== 4">
                <div class="flex items-center justify-between">
                    <div> {{ $t('collection.pay_order') }} </div>
                    <upload v-if="orderDetail.way == 'BUY' && !pay_voucher" ref="UploaderRef" v-model="pay_voucher" />
                    <van-image v-if="pay_voucher" :src="pay_voucher" class="w-100 h-100"
                        @click="showImagePreview([pay_voucher])">
                        <template v-slot:loading>
                            <van-loading type="spinner" size="20" />
                        </template>
                    </van-image>
                    <span v-if="orderDetail.way == 'SELL' && !pay_voucher">{{ $t('legal.no_credit') }}</span>
                </div>
                <van-divider class="my-12" />
            </template>

            <van-collapse v-model="activeNames">
                <van-collapse-item :title="$t('collection.status_follow')">
                    <van-steps direction="vertical" :active="orderActions.length - 1">
                        <van-step v-for="item in orderActions">
                            <h3>{{ item.memo }}</h3>
                            <p>{{ item.created_at }}</p>
                        </van-step>
                    </van-steps>
                </van-collapse-item>
            </van-collapse>

            <van-divider class="my-12" />

            <div v-if="orderDetail.status === 0 && orderDetail.way === 'BUY'">{{ $t('legal.please_transform') }}</div>

        </div>

        <div v-if="[0, 2, 3].includes(orderDetail.status) && orderDetail.way == 'BUY'"
            class="fixed bottom-0 left-0 right-0 bg-#3e423a p-10">
            <div class="text-12">{{ $t('legal.not_add_coin_info') }}</div>
            <div class="flex justify-between items-center mt-10">
                <van-button class="flex-1 rounded-8" color="#999" @click="cancelOrder">
                    {{ $t('legal.cancel_order') }}
                </van-button>
                <van-button v-if="orderDetail.status == 0" class="flex-1 rounded-8 ml-10" color="#2fdab0" @click="payOrder">
                    {{ $t('legal.i_finish_pay') }}
                </van-button>
            </div>
        </div>

        <div v-if="[1, 2, 3].includes(orderDetail.status) && orderDetail.way == 'SELL'"
            class="fixed bottom-0 left-0 right-0 bg-#3e423a p-10">
            <div class="text-12">{{ $t('legal.check_pay_info') }}</div>
            <div class="flex justify-between items-center mt-10">
                <van-button v-if="orderDetail.status === 1" class="flex-1 rounded-8" color="#facc15" @click="delayOrder">
                    {{ $t('legal.delay_confirm') }}
                </van-button>
                <van-button v-if="orderDetail.status === 2" class="flex-1 rounded-8" color="#facc15" @click="arbitrateOrder">
                    {{ $t('legal.apply_protection') }}
                </van-button>
                <van-button class="rounded-8 flex-1 ml-10" color="#2fdab0" @click="confirmOrder">
                    {{ $t('legal.confirm_pay') }}
                </van-button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { showImagePreview } from 'vant';
import { useOrderStatus, useOtcOrder } from './hooks';
import useCopy from '@/hooks/useCopy';

const { orderDetail, pay_voucher, statusTip, bankData, orderActions,
    cancelOrder, payOrder, delayOrder, confirmOrder, arbitrateOrder } = useOtcOrder()

const { onCopy } = useCopy()

const { getStatusLabel } = useOrderStatus()

const UploaderRef = ref()
// const uploadImgUrl = ref('')

const activeNames = ref([]);



</script>

<style lang="scss" scoped>
.van-hairline--top-bottom:after,
.van-hairline-unset--top-bottom:after {
    border-width: 0;
}

:deep(.van-collapse-item__title:after) {
    border-width: 0 !important;
}
</style>