<template>
    <el-card class="w-full mt-20 text-white min-h-300" v-loading="!orderDetail" shadow="hover">
        <div class="px-12 mt-12 pb-140" v-if="orderDetail">
            <div class="flex items-center">
                <el-icon color="yellow" size="24px">
                    <Document />
                </el-icon>
                <span class="pl-8 text-20">{{ getStatusLabel(orderDetail.status, orderDetail.way) }}</span>
            </div>
            <div class="text-14 mt-4">{{ statusTip }}</div>

            <div class="mt-10 text-20 text-yellow">
                {{ orderDetail.amount }} {{ orderDetail.area_info.currency }}
            </div>

            <div class="text-14 mt-10">
                <div>
                    <span>{{ $t('legal.unit') }}</span>
                    <span class="pl-10">{{ orderDetail.price }} {{ orderDetail.area_info.currency }}</span>
                </div>
                <div class="mt-4">
                    <span>{{ $t('legal.amount') }}</span>
                    <span class="pl-10">{{ orderDetail.number }} {{ orderDetail.currency_name }}</span>
                </div>
            </div>

            <div class="mt-10 text-16" v-if="bankData">
                <div class="text-14 flex items-center">
                    <el-icon color="yellow" size="24px">
                        <Postcard />
                    </el-icon>
                    <span class="pl-4">{{ $t('collection.bank_card') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-14">{{ bankData.card_no }}</span>
                    <el-icon class="p-6 cursor-pointer" color="red" size="30px" @click="onCopy(bankData!.card_no)">
                        <CopyDocument />
                    </el-icon>
                </div>

                <div class="flex items-center justify-between">
                    <span>{{ $t('collection.collection_name') }}:{{ bankData.real_name }}</span>
                    <span>{{ bankData.bank_name }}({{ bankData.bank_address }})</span>
                </div>

                <div class="mt-4"> {{ bankData.bank_code }} </div>
                <el-divider class="my-12" />

                <div class="flex items-center justify-between">
                    <div> {{ $t('collection.pay_reference_code') }} </div>
                    <div>{{ orderDetail.id }}</div>
                </div>
                <el-divider class="my-12" />

                <div class="flex items-center justify-between">
                    <div> {{ $t('collection.submit_time') }} </div>
                    <div>{{ orderDetail.created_at }}</div>
                </div>
                <el-divider class="my-12" />

                <template v-if="orderDetail.status !== 4">
                    <div class="flex items-center justify-between">
                        <div> {{ $t('collection.pay_order') }} </div>
                        <div class="w-300">
                            <upload v-if="(orderDetail.way == 'BUY' && !pay_voucher)" ref="UploaderRef"
                                v-model="pay_voucher" />
                        </div>
                        <el-image v-if="pay_voucher" :src="pay_voucher" class="w-100 h-100"
                            :preview-src-list="[pay_voucher]"></el-image>
                        <span v-if="orderDetail.way == 'SELL' && !pay_voucher">{{ $t('legal.no_credit') }}</span>
                    </div>
                    <el-divider class="my-12" />
                </template>

                <el-collapse v-model="activeNames">
                    <el-collapse-item :title="$t('collection.status_follow')">
                        <el-steps direction="vertical" :active="orderActions.length">
                            <el-step v-for="item in orderActions" :title="item.memo" :description="item.created_at" />
                        </el-steps>
                    </el-collapse-item>

                </el-collapse>

                <el-divider class="my-12" />

                <div v-if="orderDetail.status === 0 && orderDetail.way === 'BUY'">{{ $t('legal.please_transform') }}
                </div>

            </div>

            <div v-if="([0, 2, 3].includes(orderDetail.status) && orderDetail.way == 'BUY')">
                <div class="text-14">{{ $t('legal.not_add_coin_info') }}</div>
                <div class="flex justify-end items-center mt-10">
                    <el-button class="rounded-4" color="#999" @click="cancelOrder">
                        {{ $t('legal.cancel_order') }}
                    </el-button>
                    <el-button v-if="orderDetail.status == 0" class="rounded-4 ml-10" color="#2fdab0" @click="payOrder">
                        {{ $t('legal.i_finish_pay') }}
                    </el-button>
                </div>
            </div>

            <div v-if="([1, 2, 3].includes(orderDetail.status) && orderDetail.way == 'SELL')">
                <div class="text-14">{{ $t('legal.check_pay_info') }}</div>
                <div class="flex justify-end items-center mt-10">
                    <el-button v-if="orderDetail.status === 1" class="rounded-4" color="#facc15" @click="delayOrder">
                        {{ $t('legal.delay_confirm') }}
                    </el-button>
                    <el-button v-if="orderDetail.status === 2" class="rounded-4" color="#facc15"
                        @click="arbitrateOrder">
                        {{ $t('legal.apply_protection') }}
                    </el-button>
                    <el-button class="rounded-4 ml-10" color="#2fdab0" @click="confirmOrder">
                        {{ $t('legal.confirm_pay') }}
                    </el-button>
                </div>
            </div>
        </div>
    </el-card>
</template>

<script lang="ts" setup>
import { useOrderStatus, useOtcOrder } from '../../views/Legal/hooks';
import useCopy from '@/hooks/useCopy';

const route = useRoute()

const { orderDetail, pay_voucher, statusTip, bankData, orderActions,
    cancelOrder, payOrder, delayOrder, confirmOrder, arbitrateOrder } = useOtcOrder()

const { onCopy } = useCopy()

const { getStatusLabel } = useOrderStatus()

const UploaderRef = ref()

const activeNames = ref([]);
</script>