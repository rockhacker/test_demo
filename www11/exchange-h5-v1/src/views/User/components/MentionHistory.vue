<template>
    <div class="mt-10">
        <div class="text-14">
            {{ $t('user.withdraw_history') }}
        </div>

        <van-list v-model:loading="loading" :finished="finished" :finished-text="$t('public.no_more')" @load="onLoad">
            <div v-for="item in withdrawList" :key="item.id" class="text-12 bg-#383838 p-8 mt-6 rounded-10">
                <div class="flex">
                    <div class="flex-1">
                        <div>{{ $t('trade.quantity') }}</div>
                        <div>{{ item.number }}</div>
                    </div>
                    <div class="flex-1 text-center">
                        <div>{{ $t('trade.handle_fee') }}</div>
                        <div>{{ item.fee }}</div>
                    </div>
                    <div class="flex-1 text-right">
                        <div>{{ $t('trade.receive_num') }}</div>
                        <div>{{ item.real_number }}</div>
                    </div>
                </div>
                <div class="flex mt-4 justify-between">
                    <div>
                        <div>
                            {{ $t('public.status') }}
                        </div>
                        <div>{{ item.status_name }}</div>
                    </div>
                    <div class="text-right">
                        <div>{{ $t('trade.time') }}</div>
                        <div>{{ item.created_at }}</div>
                    </div>
                </div>
                <div class="mt-4">
                    <div>{{ $t('user.withdraw_address') }}</div>
                    <div>{{ item.address }}</div>
                </div>
                <div v-if="item.notes" class="mt-4">
                    <div>{{ $t('public.remark') }}</div>
                    <div>{{ item.notes }}</div>
                </div>
            </div>
        </van-list>
    </div>
</template>

<script lang="ts" setup>
import { getWithdrawList } from '@/api/user';
import { WithdrawItem } from '@/interface/user';

const props = defineProps<{
    currency_id: number
}>()

const withdrawList = ref<WithdrawItem[]>([])
const page = ref(0)
const [loading, setLoading] = useToggle(false)
const [finished, setFinish] = useToggle(false)

const onLoad = async () => {
    page.value++

    getWithdrawList({ currency_id: props.currency_id, page: page.value })
        .then(({ data }) => {
            const list = data.data
            withdrawList.value = page.value === 1 ? list : withdrawList.value.concat(list);
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
    withdrawList.value = []
    page.value = 0
    onLoad()
}

defineExpose({
    onRefresh
})

</script>