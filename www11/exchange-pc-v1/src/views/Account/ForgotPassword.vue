<template>
    <div class="forgot-password-page bg-white flex items-center">
        <div class="flex-1" />
        <div class="flex-1 flex flex-col justify-center items-center">
            <div class="text-40 w-400 text-black">{{ $t('account.reset_password') }}</div>
            <el-form class="min-w-400 mt-40" label-width="auto" label-position="top" :model="params"
                style="max-width: 600px">
                <el-form-item :label="$t('account.email')">
                    <el-input v-model="params.account" :placeholder="$t('account.input_email')" />
                </el-form-item>
                <el-form-item :label="$t('account.password')">
                    <el-input v-model="params.new_password" show-password type="password"
                        :placeholder="$t('account.input_password')" />
                </el-form-item>
                <el-form-item :label="$t('account.confirm_password')">
                    <el-input v-model="params.secondary_password" show-password type="password"
                        :placeholder="$t('account.input_password_again')" />
                </el-form-item>
                <el-form-item :label="$t('account.verify_code')">
                    <el-input v-model="params.auth_code" :placeholder="$t('account.input_verify_code')">
                        <template #append>
                            <el-button size="small" @click="sendCode(params.account)" :loading="loading"
                                :disabled="disable">
                                {{ label }}
                            </el-button>
                        </template>
                    </el-input>
                </el-form-item>
                <el-form-item>
                    <el-button color="#19FC8F" class="w-full h-40" @click="onSubmit">
                        {{ $t('account.reset_password') }}
                    </el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script setup lang="ts">
import { forgotLoginPassword } from '@/api/user';
import useSmsCode from '@/hooks/useSmsCode';
import { useI18n } from 'vue-i18n';


const { t } = useI18n()
const router = useRouter()
const route = useRoute()

const params = reactive({
    account: '',
    new_password: '',
    secondary_password: '',
    auth_code: '',
    type: 'email',
    // area_id: ''
})

const { label, loading, disable, sendCode } = useSmsCode()

const onSubmit = () => {
    forgotLoginPassword(params, { showSuccessMessage: true, loading: true}).then(res => {
        router.push('/login')
    })
}
</script>


<style lang="scss">
.forgot-password-page {
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
