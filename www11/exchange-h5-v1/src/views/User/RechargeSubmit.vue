<template>
    <nav-bar :title="$t('recharge.recharge_coin')" />
    <div class="mx-20 bg-#383838 rounded-16 p-20 mt-20 flex flex-col items-center">
        <qr-code v-model="address" :size="160" />
        <div class="mt-12">{{ $t('recharge.coin_address') }}</div>
        <div class="mt-12 px-12 text-center text-wrap w-88% break-all">{{ address }}</div>
        <van-button class="mt-20 rounded-12 h-40 text-14" color="#2fdab0" block @click="onCopy(address)">
            {{ $t('public.copy_address') }}
        </van-button>
    </div>

    <div class="px-20 pb-40">
        <van-field class="mt-16" :label="$t('recharge.to_address')" :placeholder="$t('recharge.to_address')"
            label-align="top" />

        <van-field class="mt-16" v-model="amount" :label="$t('recharge.recharge_num')"
            :placeholder="$t('recharge.recharge_num')" label-align="top" />

        <div class="text-14 ml-6 mt-20">
            {{ $t("recharge.upload_receipt") }}
        </div>
        <div class="flex flex-col items-center">
            <upload ref="UploaderRef" v-model="proofImg" />
        </div>
        <van-button class="mt-20 rounded-12 h-40 text-14 w-88% mx-auto" color="#2fdab0" block @click="onSubmit">
            {{ $t('recharge.submit_recharge_data') }}
        </van-button>
    </div>
</template>

<script lang="ts" setup>
import { chargeDataSubmit } from '@/api/user';
import useCopy from '@/hooks/useCopy';
import { showSuccessToast } from 'vant';

const { onCopy } = useCopy()

const UploaderRef = ref()

const route = useRoute()
const id = route.query.id!.toString()
const address = route.query.address!.toString()
const proofImg = ref('')

const amount = ref<number>()

const onSubmit = () => {
    chargeDataSubmit({
        number: amount.value,
        proofImg: proofImg.value,
        address: address,
        charge_id: id,
    }).then((res) => {
        amount.value = undefined;
        proofImg.value = ''
        showSuccessToast(res.msg);
        UploaderRef.value.resetUpload()
    });
}
</script>