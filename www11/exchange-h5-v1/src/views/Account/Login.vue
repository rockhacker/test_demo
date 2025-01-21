<template>
    <div class="login-page">
        <nav-bar />

        <img class="w-full h-186" src="@images/login-banner.png">

        <div class="px-12 py-20 text-14 text-[#888888]">
            <van-field v-model="params.account" :label="$t('account.account')"
                :placeholder="$t('account.input_account')" label-align="top" />

            <van-field class="mt-16" v-model="params.password" :label="$t('account.password')"
                :placeholder="$t('account.input_password')" :type="showPassword ? 'text' : 'password'"
                :right-icon="showPassword ? 'eye-o' : 'closed-eye'" label-align="top"
                @click-right-icon="setShowPassword(!showPassword)" />

            <div class="flex items-center justify-between mx-6 mt-20">
                <van-checkbox v-model="rememberMe">
                    {{ $t('account.remember_me') }}
                </van-checkbox>
                <div @click="router.push('/forgot-password')">{{ $t('account.forgot_password') }}</div>
            </div>

            <van-button class="mt-20 rounded-22 h-52" type="primary" block @click="onSubmit">
                {{ $t('account.login') }}
            </van-button>

            <van-divider>{{ $t('public.or') }}</van-divider>

            <van-button class="mt-20 rounded-22 h-52" type="primary" block @click="toWallet">
                {{ $t('wallet.login') }}
            </van-button>

            <van-divider>{{ $t('public.or') }}</van-divider>

            <van-button class="rounded-22 h-52" color="#585858" block @click="router.push('/register')">
                {{ $t('account.create_account') }}
            </van-button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { submitLogin, walletLogin } from '@/api/user';
import { useUserStore, useWebsocketStore } from '@/store';
import { showFailToast } from 'vant';
import { useI18n } from 'vue-i18n';


const params = reactive({
    account: '',
    password: '',
    login_type: 'email',
    // country_code: '',
    // sms_code: '',
})

const rememberMe = ref(false)

const { login } = useWebsocketStore()

const { userInputData } = storeToRefs(useUserStore())
const { setToken, getUserData, setWallet } = useUserStore()
// 用户缓冲登录数据 -- 记住我功能
if (userInputData.value) {
    params.account = userInputData.value.account
    params.password = userInputData.value.password
    rememberMe.value = true
}

const [showPassword, setShowPassword] = useToggle(false)


const router = useRouter()
const { t } = useI18n()

const toWallet = () => {
    // @ts-ignore
    if (!window.ethereum) {
        router.push('/wallet')
    } else {
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
}

const onSubmit = () => {
    if (!params.account) {
        return showFailToast(t('account.input_account'))
    }
    if (!params.password) {
        return showFailToast(t('account.input_password'))
    }
    submitLogin(params).then(({ data }) => {
        userInputData.value = rememberMe.value ?
            {
                account: params.account,
                password: params.password
            } : undefined
        setToken(data)
        setWallet(false)
        login(data)
        getUserData()
        router.push('/')
    })
}
</script>

<style lang="scss" scoped>
.login-page {
    padding-bottom: 40px;
}
</style>