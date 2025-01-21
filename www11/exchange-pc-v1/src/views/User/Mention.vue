<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/assets/withdraw' }"> {{ $t('func.mention') }}</el-breadcrumb-item>
                <el-breadcrumb-item>{{ account?.currency.code }} {{ $t('func.mention') }}</el-breadcrumb-item>
            </el-breadcrumb>
        </el-card>

        <el-card v-if="account" class="w-full mt-20 text-white" shadow="hover">
            <div class="py-10">
                <div class="text-18">{{ account.currency.code }} {{ $t('func.mention') }}</div>
                <div class="text-12">{{ $t('public.available') }} {{ account.balance }}{{ account.currency.code }}
                </div>

                <div v-if="account.currency.currency_protocols && account.currency.currency_protocols.length > 1">
                    <div>
                        {{ $t('user.chain_protocol') }}
                    </div>
                    <el-tabs v-model="protocol_id" @tab-change="getBindAddress">
                        <el-tab-pane v-for="item in account.currency.currency_protocols"
                            :label="item.chain_protocol.code" :name="item.id">
                        </el-tab-pane>
                    </el-tabs>
                </div>
            </div>

            <div>
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

            <div class="py-12">
                <div class="text-14">
                    {{ $t('trade.quantity') }}
                </div>
                <div class="flex items-center justify-between mt-10">
                    <el-input class="flex-1" v-model="number"
                        :placeholder="$t('user.min_withdraw_num') + account.currency.draw_min">
                        <template #suffix>
                            <div class="mx-10">{{ account.currency.code }}</div>
                            <div class="border-0 border-l-1 border-solid border-#888 pl-10 cursor-pointer"
                                @click="number = account!.balance">
                                {{ $t('public.all') }}
                            </div>
                        </template>
                    </el-input>
                </div>
            </div>

            <div class="py-10">
                <div class="text-14">
                    {{ $t('trade.trade_password') }}
                </div>
                <el-input class="w-full mt-10" v-model="password" type="password"
                    :placeholder="$t('trade.input_trade_password')" />
            </div>

            <div>
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

            <el-button class="mt-10 rounded-4 h-36 text-14 w-full" color="#2fdab0" block @click="onSubmit">
                {{ $t('func.mention') }}
            </el-button>
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { ArrowRight } from '@element-plus/icons-vue'
import { accountDetail, getDrawAddress, withdrawCoin } from '@/api/user';
import { AccountDetail } from '@/interface/user';
import { useUserStore } from '@/store';
import Big from 'big.js';
import { floor } from 'lodash-es';

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
    }, { showSuccessMessage: true }).then(() => {
        number.value = undefined
        password.value = ''
        mentionRef.value.onRefresh()
    })
}
</script>