<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col">
        <div class="bg-#383838 rounded-16 p-20">
            <div class="text-16">
                {{ $t('recharge.select_recharge_type') }}
            </div>

            <div class="flex items-center justify-between mt-16 cursor-pointer" v-for="item in rechargeList"
                :key="item.id" @click="router.push(`/user/recharge-submit?id=${item.id}&address=${item.address}`)">
                <div class="flex items-center">
                    <img class="w-28 h-28" :src="item.currency.logo" alt="" srcset="">
                    <div class="ml-8 text-18">{{ item.currency_code_protocol }}</div>
                </div>
                <el-icon>
                    <ArrowRightBold />
                </el-icon>
            </div>
        </div>

        <div class="bg-#383838 rounded-16 p-10 mt-10 cursor-pointer flex items-center justify-between" v-for="(item, index) in collaborate" :key="index"
            @click="toCollaborate(item.url)">
            <div>
                <img :src="item.logo" class="h-20 w-auto mb-10" alt="" srcset="">
                <div>{{ $t('recharge.collaborate_recharge') }}</div>
            </div>
            <el-icon>
                <ArrowRightBold />
            </el-icon>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { getQuickChargeList } from '@/api/user';
import { QuickCharge } from '@/interface/user';
import { getImageUrl } from '@/utils/getImage';

const router = useRouter()

const rechargeList = ref<QuickCharge[]>([])

getQuickChargeList().then(({ data }) => {
    rechargeList.value = data
})

const collaborate = [
    {
        logo: getImageUrl('banxa.svg'),
        url: 'https://banxa.com',
    },
    {
        logo: getImageUrl('binance.png'),
        url: 'https://c2c.binance.com/en/?fiat=USD',
    },
    {
        logo: getImageUrl('coinbase.svg'),
        url: 'https://www.coinbase.com',
    },
    {
        logo: getImageUrl('crypto.jpg'),
        url: 'https://crypto.com',
    },
    {
        logo: getImageUrl('kraken.png'),
        url: 'https://kraken.com',
    },
    {
        logo: getImageUrl('bitbank.png'),
        url: 'https://www.bitbank.com',
    },
    {
        logo: getImageUrl('kucoin.png'),
        url: 'https://www.kucoin.com/assets/payments?lang=en_US',
    },
]

const toCollaborate = (url: string) => window.open(url)
</script>
