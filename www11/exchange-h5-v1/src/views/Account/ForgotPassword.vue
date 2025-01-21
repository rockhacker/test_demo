<template>
    <nav-bar :title="$t('account.reset_password')" />

    <div class="px-12 mt-10">
        <div class="text-14 text-[#888888]">
            <van-field class="mt-16" v-model="params.account" :label="$t('account.email')"
                :placeholder="$t('account.input_email')" label-align="top" />

            <van-field class="mt-16" v-model="params.new_password" :label="$t('account.password')"
                :placeholder="$t('account.input_password')" :type="showPassword ? 'text' : 'password'"
                :right-icon="showPassword ? 'eye-o' : 'closed-eye'" label-align="top"
                @click-right-icon="setShowPassword(!showPassword)" />

            <van-field class="mt-16" v-model="params.secondary_password" :label="$t('account.confirm_password')"
                :placeholder="$t('account.input_password_again')" :type="showCheckPassword ? 'text' : 'password'"
                :right-icon="showCheckPassword ? 'eye-o' : 'closed-eye'" label-align="top"
                @click-right-icon="setShowCheckPassword(!showCheckPassword)" />

            <van-field class="mt-16" v-model="params.auth_code" :label="$t('account.verify_code')"
                :placeholder="$t('account.input_verify_code')" label-align="top">
                <template #button>
                    <van-button size="small" type="primary" @click="sendCode(params.account)" :loading="loading"
                        :disabled="disable">
                        {{ label }}
                    </van-button>
                </template>
            </van-field>

            <van-button class="mt-20 rounded-22 h-52" type="primary" block @click="onSubmit">
                {{ $t('account.reset_password') }}
            </van-button>

        </div>
    </div>
</template>

<script lang="ts" setup>
import { forgotLoginPassword } from '@/api/user';
import useSmsCode from '@/hooks/useSmsCode';
import { showSuccessToast } from 'vant';

// const { t } = useI18n()
const router = useRouter()
// const route = useRoute()

const params = reactive({
    account: '',
    new_password: '',
    secondary_password: '',
    auth_code: '',
    type: 'email',
    // area_id: ''
})

// account: string, auth_code: string, new_password: string, secondary_password: string, type: string

const [showPassword, setShowPassword] = useToggle(false)
const [showCheckPassword, setShowCheckPassword] = useToggle(false)

const { label, loading, disable, sendCode } = useSmsCode()

const onSubmit = () => {
    forgotLoginPassword(params, { loading: true }).then(res => {
        showSuccessToast(res.msg!)
        router.push('/login')
    })
}
</script>