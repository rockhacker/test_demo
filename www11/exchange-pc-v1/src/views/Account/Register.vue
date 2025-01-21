<template>
    <div class="register-page bg-white flex items-center">
        <div class="flex-1" />
        <div class="flex-1 flex flex-col justify-center items-center">
            <div class="text-40 w-400 text-black">{{ $t('account.email_create') }}</div>
            <el-form class="min-w-400 mt-40" label-width="auto" label-position="top" :model="params"
                style="max-width: 600px">
                <el-form-item :label="$t('account.email')">
                    <el-input v-model="params.account" :placeholder="$t('account.input_email')" />
                </el-form-item>
                <el-form-item :label="$t('account.password')">
                    <el-input v-model="params.password" show-password type="password"
                        :placeholder="$t('account.input_password')" />
                </el-form-item>
                <el-form-item :label="$t('account.confirm_password')">
                    <el-input v-model="params.re_password" show-password type="password"
                        :placeholder="$t('account.input_password_again')" />
                </el-form-item>
                <el-form-item :label="$t('account.verify_code')">
                    <el-input v-model="params.sms_code" :placeholder="$t('account.input_verify_code')">
                        <template #append>
                            <el-button size="small" @click="sendCode(params.account)" :loading="loading"
                                :disabled="disable">
                                {{ label }}
                            </el-button>
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item :label="$t('account.invite_code')">
                    <el-input v-model="params.invite_code" :placeholder="$t('account.input_invite_code')" />
                </el-form-item>
                <el-form-item>
                    <div>
                        <el-checkbox class="ml-6" v-model="agreement">
                            <span class="text-#161616">{{ $t('account.agreement') }}</span>
                            <span class="text-#161616 px-4">
                                &lt;&lt;{{ $t('account.private_policy') }}&gt;&gt;
                            </span>
                        </el-checkbox>
                    </div>
                </el-form-item>
                <el-form-item>
                    <el-button color="#19FC8F" class="w-full h-40" @click="onSubmit">
                        {{ $t('account.register') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { submitLogin, submitRegister } from '@/api/user';
import useSmsCode from '@/hooks/useSmsCode';
import { useUserStore, useWebsocketStore } from '@/store';
import { notification } from 'ant-design-vue';
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

const { label, loading, disable, sendCode } = useSmsCode()

const onSubmit = () => {
    if (!agreement.value) {
        return notification.warn({ message: t('account.agreement_private_policy') })
    }
    submitRegister(params, { showSuccessMessage: true, loading: true }).then(res => {
        router.push('/login')
    })
}
</script>


<style lang="scss">
.register-page {
    background-image: url('./assets/images/account-img.png');
    background-size: 50% 100%;
    background-repeat: no-repeat;

    .el-input-group__append {
        background-color: var(--el-color-primary) !important;
        color: #1a1a1a;
        box-shadow: 0 1px 0 0 #D6D6D6 inset, 0 -1px 0 0 #D6D6D6 inset, -1px 0 0 0 #D6D6D6 inset;
    }

    .el-input__wrapper,
    input {
        background-color: white !important;
        color: #1a1a1a !important;
    }

    .el-input__wrapper {
        box-shadow: 0 0 0 1px #D6D6D6 inset;
    }

    .el-checkbox__label {
        color: #888;
    }

    .el-form-item__label {
        color: #161616 !important;
    }
}
</style>
