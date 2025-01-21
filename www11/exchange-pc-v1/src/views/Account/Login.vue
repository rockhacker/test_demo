<template>
    <div class="login-page bg-white flex items-center">
        <div class="flex-1" />
        <div class="flex-1 flex flex-col justify-center items-center">
            <div class="text-40 w-400 text-black">{{ $t('account.login') }}</div>
            <el-form class="min-w-400 mt-40" label-width="auto" label-position="top" :model="params"
                style="max-width: 600px">
                <el-form-item :label="$t('account.email')">
                    <el-input v-model="params.account" :placeholder="$t('account.input_email')" />
                </el-form-item>
                <el-form-item :label="$t('account.password')">
                    <el-input v-model="params.password" show-password type="password"
                        :placeholder="$t('account.input_password')" />
                </el-form-item>
                <el-form-item>
                    <el-button color="#19FC8F" class="w-400 h-40" @click="onSubmit">{{ $t('account.login')
                        }}</el-button>
                </el-form-item>
                <el-form-item>
                    <div class="flex items-center justify-between w-full">
                        <el-checkbox v-model="rememberMe" :label="$t('account.remember_me')" size="large" />
                        <div class="cursor-pointer text-black" @click="router.push('/forgot-password')">{{ $t('account.forgot_password') }}</div>
                    </div>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { submitLogin } from '@/api/user';
import { useUserStore, useWebsocketStore } from '@/store';
import { notification } from 'ant-design-vue';
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
const { setToken, getUserData } = useUserStore()
// 用户缓冲登录数据 -- 记住我功能
if (userInputData.value) {
    params.account = userInputData.value.account
    params.password = userInputData.value.password
    rememberMe.value = true
}

const router = useRouter()
const { t } = useI18n()

const onSubmit = () => {
    if (!params.account) {
        return notification.warn({ message: t('account.input_account') })
    }
    if (!params.password) {
        return notification.warn({ message: t('account.input_password') })
    }
    submitLogin(params, { loading: true }).then(({ data }) => {
        userInputData.value = rememberMe.value ?
            {
                account: params.account,
                password: params.password
            } : undefined
        setToken(data)
        login(data)
        getUserData()
        router.push('/')
    })
}
</script>


<style lang="scss">
.login-page {
    background-image: url('./assets/images/account-img.png');
    background-size: 50% 100%;
    background-repeat: no-repeat;

    .el-input__wrapper,
    input {
        background-color: white !important;
        color: #1a1a1a !important;
    }

    .el-input__wrapper {
        box-shadow: 0 0 0 1px #D6D6D6 inset;
    }

    .el-checkbox__label {
        color: #000;
    }

    .el-form-item__label {
        color: #161616 !important;
    }
}
</style>
