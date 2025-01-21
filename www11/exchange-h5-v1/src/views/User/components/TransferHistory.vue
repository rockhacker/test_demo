<template>
    <div class="mt-10">
        <div class="text-14">
            {{ $t('transfer.transfer_history') }}
        </div>

        <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
            <div v-for="item in transferList" :key="item.id" class="text-12 bg-#383838 py-12 px-6 mt-6 rounded-10">
                <div class="flex">
                    <div class="flex-1">
                        <div>{{ $t('trade.quantity') }}</div>
                        <div class="mt-4">{{ item.balance }}</div>
                    </div>
                    <div class="flex-1 text-center">
                        <div>{{ $t('transfer.source') }}</div>
                        <div class="mt-4">{{ item.from_name + '-' + item.to_name }}</div>
                    </div>
                    <div class="flex-1 text-right">
                        <div>{{ $t('trade.time') }}</div>
                        <div class="mt-4">{{ item.created_at }}</div>
                    </div>
                </div>
            </div>
        </van-list>
    </div>
</template>

<script lang="ts" setup>
import { getTransferList } from '@/api/user';
import { Account, TransferItem } from '@/interface/user';

const props = defineProps<{
    currency_id: number
    account: Account
}>()

const { currency_id, account } = toRefs(props)

const transferList = ref<TransferItem[]>([])
const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const onLoad = async () => {
    page.value++

    getTransferList({ currency_id: currency_id.value!, page: page.value, type: account.value.account_code })
        .then(({ data }) => {
            const list = data.data
            transferList.value = page.value === 1 ? list : transferList.value.concat(list);
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

const onRefresh = () => {
    setTimeout(() => {
        transferList.value = []
        page.value = 0
        onLoad()
    })
}

defineExpose({
    onRefresh
})

</script>