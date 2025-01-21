<template>
    <div class="register-page pb-80">
        <nav-bar />

        <div class="px-12 mt-10">
            <div class="text-24 font-bold">{{ $t('account.email_create') }}</div>

            <div class="text-14 text-[#888888]">
                <van-field class="mt-16" v-model="params.account" :label="$t('account.email')"
                    :placeholder="$t('account.input_email')" label-align="top" />

                <van-field class="mt-16" v-model="params.password" :label="$t('account.password')"
                    :placeholder="$t('account.input_password')" :type="showPassword ? 'text' : 'password'"
                    :right-icon="showPassword ? 'eye-o' : 'closed-eye'" label-align="top"
                    @click-right-icon="setShowPassword(!showPassword)" />

                <van-field class="mt-16" v-model="params.re_password" :label="$t('account.confirm_password')"
                    :placeholder="$t('account.input_password_again')" :type="showCheckPassword ? 'text' : 'password'"
                    :right-icon="showCheckPassword ? 'eye-o' : 'closed-eye'" label-align="top"
                    @click-right-icon="setShowCheckPassword(!showCheckPassword)" />

                <van-field class="mt-16" v-model="params.sms_code" :label="$t('account.verify_code')"
                    :placeholder="$t('account.input_verify_code')" label-align="top">
                    <template #button>
                        <van-button size="small" type="primary" @click="sendCode(params.account)" :loading="loading"
                            :disabled="disable">
                            {{ label }}
                        </van-button>
                    </template>
                </van-field>

                <van-field class="mt-16" v-model="params.invite_code" :label="$t('account.invite_code')"
                    :placeholder="$t('account.input_invite_code')" label-align="top" />

                <van-checkbox class="mt-16 ml-6" v-model="agreement">
                    {{ $t('account.agreement') }}
                    <span class="text-main px-4">
                        &lt;&lt;{{ $t('account.private_policy') }}&gt;&gt;
                    </span>
                </van-checkbox>

                <van-button class="mt-20 rounded-22 h-52" type="primary" block @click="onSubmit">
                    {{ $t('account.register') }}
                </van-button>

            </div>
        </div>

    </div>
</template>

<script lang="ts" setup>
import { submitRegister } from '@/api/user';
import useSmsCode from '@/hooks/useSmsCode';
import { showFailToast, showSuccessToast } from 'vant';
import { useI18n } from 'vue-i18n';

const { t } = useI18n()
const router = useRouter()
const route = useRoute()

const params = reactive({
    account: '',
    password: '',
    re_password: '',
    sms_code: '',
    invite_code: route.query.invite_code as string,
    type: 'email',
    area_id: ''
})

const agreement = ref(false) // 是否同意协议


const [showPassword, setShowPassword] = useToggle(false)
const [showCheckPassword, setShowCheckPassword] = useToggle(false)

const { label, loading, disable, sendCode } = useSmsCode()

const onSubmit = () => {
    if (!agreement.value) {
        return showFailToast(t('account.agreement_private_policy'))
    }
    submitRegister(params).then(res => {
        showSuccessToast(res.msg!)
        router.push('/login')
    })
}
</script>