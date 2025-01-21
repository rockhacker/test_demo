<template>
    <view :class="theme">
        <view class="bg-my-grey dark:bg-1C2532 text-black dark:text-white pb-30" style="min-height: 100vh;">
            <view class="flex items-center justify-center">
                <image src="/static/wallet/logo.png" class="w-full"></image>
            </view>
            <view v-for="(item, index) in list" :key="index"
                class="flex items-center justify-between mx-30 p-20 bg-gray-100 shadow-lg rounded-10 mt-20">
                <view class="flex items-center">
                    <image :src="item.logo" class="rounded-half w-80 h-80"></image>
                    <view class="ml-20 text-lg">{{ item.title }}</view>
                </view>
                <view class="text-lg" @click="handleClick(item)">{{ $t('wallet.connect') }}</view>
            </view>
        </view>
    </view>
</template>
<script>
import { mapState } from 'vuex';
export default {
    data() {
        return {
            list: [
                {
                    logo: '/static/wallet/Coinbase.png',
                    title: 'Coinbase',
                    link: `https://go.cb-w.com/dapp?cb_url=${window.location.href}`
                },
                // {
                //     logo: '/static/wallet/Defi-Wallet.png',
                //     title: 'Defi Wallet',
                // },
                {
                    logo: '/static/wallet/MetaMask.png',
                    title: 'MetaMask',
                    link: `https://metamask.app.link/dapp/${window.location.href}`
                },
                // {
                //     logo: '/static/wallet/MEW-Wallet.png',
                //     title: 'MEW Wallet'
                // },
                {
                    logo: '/static/wallet/imToken.png',
                    title: 'imToken',
                    link: `imtokenv2://navigate?screen=DappView&url=${window.location.href}`
                },
                {
                    logo: '/static/wallet/TrustWallet.png',
                    title: 'TrustWallet',
                    link: `https://link.trustwallet.com/open_url?coin_id=60&url=${window.location.href}`
                },
                // {
                //     logo: '/static/wallet/TronLink-Wallet.png',
                //     title: 'TronLink Wallet',
                //     link: `tronlinkoutside://pull.activity?param=%7B%22url%22:%22${window.location.href}o%22,%22action%22:%22open%22,%22protocol%22:%22tronlink%22,%22version%22:%221.0%22%7D`
                // },
                // {
                //     logo: '/static/wallet/Kraken.png',
                //     title: 'Kraken'
                // },
                // {
                //     logo: '/static/wallet/Other-wallet-login.png',
                //     title: 'Other wallet login'
                // },
            ],
            address:''
        }
    },
    computed: {
        ...mapState(['theme'])
    },
    onLoad(e) {
        this.$utils.setThemeTop(this.theme)
    },
    methods: {
        handleClick(item) {
            if (window.ethereum) {
                ethereum.request({ method: 'eth_requestAccounts' }).then(response => {
                    const accounts = response
                    console.log(`User's address is ${accounts[0]}`)
                    this.address = accounts[0]

                    this.$utils.initData({url:'user/login_for_wallet',data:{
							w_address:accounts[0]
                    },type:'POST'},(res,msg)=>{
                        uni.setStorageSync('token',res);
                        uni.setStorageSync('walletAddress',accounts[0]);
                        uni.setStorageSync('walletLogin',true);
                        uni.reLaunch({
                            url:'/pages/home/home'
                        })
                    })

                    // Optionally, have the default account set for web3.js
                    // web3.eth.defaultAccount = accounts[0]
                })
            }
            else if (item.link) {
                window.open(item.link)
            }


        }
    }
}
</script>
