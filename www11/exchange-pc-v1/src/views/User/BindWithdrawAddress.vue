<template>
    <div class="my-20 text-20">
        {{ $t('func.bind_withdraw_add') }}
    </div>
    <el-form v-if="currencyList.length" label-width="auto">
        <el-form-item :label="$t('user.current_currency')">
            <el-radio-group v-model="currency_id" @change="onCurrencyChange">
                <el-radio-button v-for="item in currencyList" :label="item.code" :value="item.id" />
            </el-radio-group>
        </el-form-item>
        <el-form-item v-if="currentProtocol.length > 1" :label="$t('user.chain_protocol')">
            <el-radio-group v-model="protocol_id" @change="getBindAddress">
                <el-radio-button v-for="item in currentProtocol" :label="item.chain_protocol.code" :value="item.id" />
            </el-radio-group>
        </el-form-item>
        <el-form-item :label="$t('user.withdraw_address')">
            <el-input v-model="address" :placeholder="$t('user.input_withdraw_address')" />
        </el-form-item>
        <el-form-item label=" ">
            <el-button class="w-full h-32" type="primary" @click="onSubmit">
                {{ $t('user.bind') }}
            </el-button>
        </el-form-item>
    </el-form>
</template>

<script lang="ts" setup>
import md5 from 'md5';
import { bindWithdrawAddress, getCurrencyProtocols, getDrawAddress } from '@/api/user';
import { CurrencyProtocol } from '@/interface/user';
import { useUserStore } from '@/store';

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

getCurrencyProtocols({}, { loading: true }).then(({ data }) => {
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


    bindWithdrawAddress({ data: obj_str, sign }, { showSuccessMessage: true }).then(() => {

    })

}

</script>