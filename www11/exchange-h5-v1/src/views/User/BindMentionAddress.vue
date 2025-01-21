<template>
    <nav-bar :title="$t('func.bind_withdraw_add')" />

    <div class="text-14">
        <div class="px-12 mt-20">
            {{ $t('user.current_currency') }}
        </div>
        <van-tabs v-model:active="currency_id" line-width="40px" line-height="3px" title-active-color="#9fef4e"
            @change="onCurrencyChange">
            <van-tab v-for="item in currencyList" :title="item.code" :name="item.id">
            </van-tab>
        </van-tabs>

        <div v-if="currentProtocol.length > 1" class="px-12 mt-20">
            <div>
                {{ $t('user.chain_protocol') }}
            </div>
            <van-tabs v-model:active="protocol_id" line-width="40px" line-height="3px" title-active-color="#9fef4e"
                @change="getBindAddress">
                <van-tab v-for="item in currentProtocol" :title="item.chain_protocol.code" :name="item.id">
                </van-tab>
            </van-tabs>
        </div>

        <div class="p-8 mt-10">
            <van-field v-model="address" :label="$t('user.withdraw_address')"
                :placeholder="$t('user.input_withdraw_address')" label-align="top" />

            <van-button class="mt-20 rounded-22 h-50 text-14" color="#2fdab0" block @click="onSubmit">
                {{ $t('user.bind') }}
            </van-button>
        </div>


    </div>
</template>

<script lang="ts" setup>
import md5 from 'md5';
import { bindWithdrawAddress, getCurrencyProtocols, getDrawAddress } from '@/api/user';
import { CurrencyProtocol } from '@/interface/user';
import { useUserStore } from '@/store';
import { showSuccessToast } from 'vant';

const { user } = storeToRefs(useUserStore())

const route = useRoute()

const currencyList = ref<CurrencyProtocol[]>([])

const currency_id = ref()
const protocol_id = ref()
const address = ref('')

const getBindAddress = () => {
    getDrawAddress({
        user_id: user.value!.id,
        currency_id: currency_id.value,
        currency_protocol_id: protocol_id.value
    }, { loading: true }).then(({ data }) => {
        address.value = data.address
    })
}

getCurrencyProtocols().then(({ data }) => {
    currencyList.value = data

    currency_id.value = route.query.currency_id ? +route.query.currency_id : data[0].id
    protocol_id.value = route.query.protocol_id ? +route.query.protocol_id : data[0].currency_protocols[0]?.id

    getBindAddress()
})

const currentCurrency = computed(() => {
    return currencyList.value.find((item) => item.id === currency_id.value)
})

const currentProtocol = computed(() => {
    return currentCurrency.value?.currency_protocols || []
})

const selectProtocol = computed(() => {
    return currentProtocol.value.find(item => item.id === protocol_id.value)
})

const onCurrencyChange = () => {
    protocol_id.value = currentCurrency.value?.currency_protocols[0]?.id
    getBindAddress()
}

const onSubmit = () => {
    const obj = {
        user_id: user.value!.id,
        address: address.value,
        coin_name: selectProtocol.value?.chain_protocol.code,
        contract_address: selectProtocol.value?.token_address,
        verificationcode: '',
        t: new Date().getTime(),
        currency_id: currency_id.value,
        currency_protocol_id: protocol_id.value
    }

    const obj_str = JSON.stringify(obj);

    const sign = md5(obj_str + 'abcd4321');


    bindWithdrawAddress({ data: obj_str, sign }).then(({ msg }) => {
        showSuccessToast(msg!)
    })

}

</script>