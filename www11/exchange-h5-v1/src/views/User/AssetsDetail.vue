<template>
    <div v-if="account">
        <nav-bar :title="account.account_type.name" />

        <div class="px-12 mt-12">
            <div class="text-18">
                {{ account.currency.code }}
            </div>
            <div class="flex text-12 mt-4">
                <div class="flex-1">
                    <div>{{ $t('public.available') }}</div>
                    <div>{{ account.balance }}</div>
                </div>
                <div class="flex-1">
                    <div>{{ $t('user.lock') }}</div>
                    <div>{{ account.lock_balance }}</div>
                </div>
                <div class="flex-1 text-right">
                    <div>{{ $t('user.amount_to') }}(USDT)</div>
                    <div>{{ account.convert_usd }}</div>
                </div>
            </div>

            <div class="my-12">
                {{ $t('user.account_history') }}
            </div>

            <!-- <div class="flex items-center text-12 py-10">
                <div class="flex-1">{{ $t('trade.quantity') }}</div>
                <div class="flex-1">{{ $t('transfer.source') }}</div>
                <div class="flex-1 text-right">{{ $t('trade.time') }}</div>
            </div> -->

            <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
                <template v-for="item in logs" :key="item.id">
                    <van-divider />
                    <div class="flex items-center justify-between text-12 py-10">
                        <div>
                            <div class="text-14">{{ item.memo }}</div>
                            <div class="text-12 mt-4 text-12">{{ item.created_at }}</div>
                        </div>

                        <div class="text-14" :class="[+item.value >= 0 ? 'text-up' : 'text-down']">{{ item.value }}</div>
                    </div>
                </template>
            </van-list>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { IAccountLog, accountDetail, changeAccountLog, forexAccountLog, legalAccountLog, leverAccountLog, microAccountLog, optionAccountLog } from '@/api/user';
import { Page, Res } from '@/interface';
import { AccontLogItem, AccountDetail } from '@/interface/user';
import { RequestConfig } from '@/utils/request';

const route = useRoute()

const account = ref<AccountDetail>()

const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const logs = ref<AccontLogItem[]>([])

const typeList = [
    {
        account_code: 'change_account',
        api: changeAccountLog
    },
    {
        account_code: 'lever_account',
        api: leverAccountLog
    },
    {
        account_code: 'micro_account',
        api: microAccountLog
    },
    {
        account_code: 'legal_account',
        api: legalAccountLog
    },
    {
        account_code: 'option_account',
        api: optionAccountLog
    },
    {
        account_code: 'forex_account',
        api: forexAccountLog
    },
]

type Api = (params?: IAccountLog | undefined, config?: RequestConfig | undefined) => Promise<Res<Page<AccontLogItem[]>>>

let api: Api

const onLoad = async () => {
    page.value++

    api({ currency_id: account.value!.currency_id, page: page.value })
        .then(({ data }) => {
            const list = data.data
            logs.value = page.value === 1 ? list : logs.value.concat(list);
            setFinish(data.last_page === page.value)
        })
        .catch((error) => {
            console.error(error);
            setFinish(true)
        })
        .finally(() => {
            setLoading(false)
        })
}

accountDetail({
    id: +route.query.id!,
    account_type_id: +route.query.account_type_id!
}).then(({ data }) => {
    account.value = data;
    api = typeList.find(item => item.account_code === data.account_type.account_code)!.api
})


</script>