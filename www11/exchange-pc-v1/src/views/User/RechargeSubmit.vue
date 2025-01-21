<template>
    <div class="max-w-[1200px] mx-auto w-full">
        <div class="mx-20 bg-#383838 rounded-16 p-20 mt-20 flex flex-col items-center">
            <qr-code v-model="address" :size="160" />
            <div class="mt-12">{{ $t('recharge.coin_address') }}</div>
            <div class="mt-12 px-12 text-center text-wrap w-88% break-all">{{ address }}</div>
            <el-button class="mt-20 rounded-12 h-40 text-14" color="#2fdab0" block @click="onCopy(address)">
                {{ $t('public.copy_address') }}
            </el-button>
        </div>

        <div class="px-20 pb-40">
            <!-- <el-input class="mt-16" :label="$t('recharge.to_address')" :placeholder="$t('recharge.to_address')" /> -->

            <el-input class="mt-16" v-model="amount" :label="$t('recharge.recharge_num')"
                :placeholder="$t('recharge.recharge_num')" />

            <div class="text-14 ml-6 mt-20">
                {{ $t("recharge.upload_receipt") }}
            </div>
            <div class="flex flex-col items-center mt-20">
                <upload ref="UploaderRef" v-model="proofImg" />
            </div>
            <el-button class="mt-20 rounded-12 h-40 text-14 w-full" color="#2fdab0" block @click="onSubmit">
                {{ $t('recharge.submit_recharge_data') }}
            </el-button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Upload from '@/components/Upload/index.vue'
import { chargeDataSubmit } from '@/api/user';
import useCopy from '@/hooks/useCopy';
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
    }, { showSuccessMessage: true, loading: true }).then((res) => {
        amount.value = undefined;
        proofImg.value = ''
        UploaderRef.value.resetUpload()
    });
}
</script>