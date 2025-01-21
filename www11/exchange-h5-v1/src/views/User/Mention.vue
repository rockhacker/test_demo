<template>
    <nav-bar :title="$t('func.mention')" />

    <div class="p-12" v-if="account">
        <div class="p-10">
            <div class="text-18">{{ account.currency.code }} {{ $t('func.mention') }}</div>
            <div class="text-12">{{ $t('public.available') }} {{ account.balance }}{{ account.currency.code }}</div>

            <div v-if="account.currency.currency_protocols && account.currency.currency_protocols.length > 1" class="mt-10">
                <div>
                    {{ $t('user.chain_protocol') }}
                </div>
                <van-tabs v-model:active="protocol_id" line-width="40px" line-height="3px" title-active-color="#9fef4e"
                    @change="getBindAddress">
                    <van-tab v-for="item in account.currency.currency_protocols" :title="item.chain_protocol.code"
                        :name="item.id">
                    </van-tab>
                </van-tabs>
            </div>
        </div>
        <van-divider />

        <div class="p-12">
            <div class="text-14">{{ $t('user.withdraw_address') }}</div>
            <div class="flex items-center justify-between mt-10">
                <template v-if="!address">
                    <div class="text-#888">
                        {{ $t('user.please_set_withdraw_address') }}
                    </div>
                    <div class="p-4" @click="toBindAddress">{{ $t('public.setting') }}</div>
                </template>
                <template v-else>{{ address }}</template>
            </div>
        </div>
        <van-divider />

        <div class="p-12">
            <div class="text-14">
                {{ $t('trade.quantity') }}
            </div>
            <div class="flex items-center justify-between mt-10">
                <input class="flex-1" v-model="number"
                    :placeholder="$t('user.min_withdraw_num') + account.currency.draw_min" />
                <div class="mx-10">{{ account.currency.code }}</div>
                <div class="border-0 border-l-1 border-solid border-#888 pl-10" @click="number = account.balance">
                    {{ $t('public.all') }}
                </div>
            </div>
        </div>
        <van-divider />

        <div class="p-12">
            <div class="text-14">
                {{ $t('trade.trade_password') }}
            </div>
            <input class="w-full mt-10" v-model="password" type="password"
                :placeholder="$t('trade.input_trade_password')" />
        </div>
        <van-divider />

        <div class="px-12">
            <div class="flex items-center justify-between mt-12 text-12">
                <div>
                    {{ $t('trade.receive_num') }}
                </div>
                <div>{{ receiveNumber }} {{ account.currency.code }}</div>
            </div>
            <div class="flex items-center justify-between mt-6 text-12">
                <div>
                    {{ $t('trade.handle_fee') }}
                </div>
                <div>{{ handleFee }}% {{ account.currency.code }}</div>
            </div>
        </div>

        <van-button class="mt-20 rounded-16 h-46 text-14" color="#2fdab0" block @click="onSubmit">
            {{ $t('func.mention') }}
        </van-button>

        <mention-history ref="mentionRef" :currency_id="+currency_id!" />
    </div>
</template>

<script lang="ts" setup>
import { accountDetail, getDrawAddress, withdrawCoin } from '@/api/user';
import MentionHistory from './components/MentionHistory.vue'
import { AccountDetail } from '@/interface/user';
import { useUserStore } from '@/store';
import Big from 'big.js';
import { floor } from 'lodash-es';
import { showSuccessToast } from 'vant';

const route = useRoute()
const router = useRouter()

const { user } = storeToRefs(useUserStore())

const { currency_id, id, account_type_id } = route.query

const mentionRef = ref()

const account = ref<AccountDetail>()
const protocol_id = ref<number>()
const address = ref('')
const number = ref<number>()
const password = ref('')

const receiveNumber = computed(() => {
    if (!account.value || !number.value) {
        return 0
    }
    return floor(Big(number.value).minus(Big(number.value).times(account.value.currency.draw_rate).toNumber()).toNumber(), 2)
})

const handleFee = computed(() => {
    if (!account.value) return 0
    return Big(+account.value.currency.draw_rate).times(100).toNumber()
})

accountDetail({ currency_id: Number(currency_id), id: Number(id), account_type_id: Number(account_type_id) }).then(({ data }) => {
    account.value = data
    if (data.currency.currency_protocols.length > 0) {
        protocol_id.value = data.currency.currency_protocols[0].id;
    }
    getBindAddress()
})

const getBindAddress = () => {
    getDrawAddress({
        user_id: user.value!.id,
        currency_id: Number(currency_id),
        currency_protocol_id: protocol_id.value
    }, { loading: true }).then(({ data }) => {
        address.value = data.address
    })
}

const toBindAddress = () => {
    router.push({
        path: '/user/bind-mention-address',
        query: {
            currency_id,
            protocol_id: protocol_id.value
        }
    })
}

const onSubmit = () => {
    withdrawCoin({
        address: address.value,
        currency_id: +currency_id!,
        currency_protocol_id: +protocol_id.value!,
        memo: '',
        number: number.value!,
        pay_password: password.value
    }).then(({ msg }) => {
        showSuccessToast(msg!)
        number.value = undefined
        password.value = ''
        mentionRef.value.onRefresh()
    })
}
</script>