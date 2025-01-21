<template>
    <div>
        <nav-bar />

        <img src="../../assets/wallet/logo.png" class="w-full" />

        <div v-for="(item, index) in list" :key="index"
            class="flex items-center justify-between mx-30 p-10 bg-gray-100 text-black shadow-lg rounded-10 mt-20">
            <view class="flex items-center">
                <img :src="item.logo" class="rounded-half w-40 h-40" />
                <view class="ml-20 text-14">{{ item.title }}</view>
            </view>
            <view class="text-14" @click="handleClick(item)">{{ $t('wallet.connect') }}</view>
        </div>
    </div>
</template>

<script setup lang="ts">
import { walletLogin } from '@/api/user';
import { useUserStore, useWebsocketStore } from '@/store';

const list = [
    {
        logo: new URL(`../../assets/wallet/Coinbase.png`, import.meta.url).href,
        title: 'Coinbase',
        link: `https://go.cb-w.com/dapp?cb_url=${window.location.href}`
    },
    // {
    //     logo: new URL(`../../assets/wallet/Defi-Wallet.png`, import.meta.url).href,
    //     title: 'Defi Wallet',
    // },
    {
        logo: new URL(`../../assets/wallet/MetaMask.png`, import.meta.url).href,
        title: 'MetaMask',
        link: `https://metamask.app.link/dapp/${window.location.href}`
    },
    // {
    //     logo: new URL(`../../assets/wallet/MEW-Wallet.png`, import.meta.url).href,
    //     title: 'MEW Wallet'
    // },
    {
        logo: new URL(`../../assets/wallet/imToken.png`, import.meta.url).href,
        title: 'imToken',
        link: `imtokenv2://navigate?screen=DappView&url=${window.location.href}`
    },
    {
        logo: new URL(`../../assets/wallet/TrustWallet.png`, import.meta.url).href,
        title: 'TrustWallet',
        link: `https://link.trustwallet.com/open_url?coin_id=60&url=${window.location.href}`
    },
    // {
    //     logo: new URL(`../../assets/wallet/TronLink-Wallet.png`, import.meta.url).href,
    //     title: 'TronLink Wallet',
    //     link: `tronlinkoutside://pull.activity?param=%7B%22url%22:%22${window.location.href}o%22,%22action%22:%22open%22,%22protocol%22:%22tronlink%22,%22version%22:%221.0%22%7D`
    // },
    // {
    //     logo: new URL(`../../assets/wallet/Kraken.png`, import.meta.url).href,
    //     title: 'Kraken'
    // },
    // {
    //     logo: new URL(`../../assets/wallet/Other-wallet-login.png`, import.meta.url).href,
    //     title: 'Other wallet login'
    // },
]

const { setToken, getUserData, setWallet } = useUserStore()
const { login } = useWebsocketStore()

const router = useRouter()

const handleClick = (item: { link: string | URL | undefined; }) => {
    // @ts-ignore
    if (window.ethereum) {
        // @ts-ignore
        window.ethereum.request({ method: 'eth_requestAccounts' }).then((response: any) => {
            const accounts = response
            console.log(`User's address is ${accounts[0]}`)
            if (!accounts[0]) {
                router.push('/wallet')
            } else {
                walletLogin({
                    w_address: accounts[0]
                }).then(({ data }) => {
                    setWallet(true)
                    setToken(data)
                    login(data)
                    getUserData()
                    router.push('/')
                })
            }
        })
    }
    else if (item.link) {
        window.open(item.link)
    }


}
</script>