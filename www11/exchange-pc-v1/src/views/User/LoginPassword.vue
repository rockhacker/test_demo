<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/user/info' }"> {{ $t('func.account_setting') }}</el-breadcrumb-item>
                <el-breadcrumb-item>{{ $t('func.reset_password') }}</el-breadcrumb-item>
            </el-breadcrumb>
        </el-card>

        <el-card class="w-full mt-20" shadow="hover">
            <el-form label-width="auto">
                <el-form-item>
                    <el-input v-model="form.old_password" type="password"
                        :placeholder="$t('account.input_old_password')" class="h-32" />
                </el-form-item>
                <el-form-item>
                    <el-input v-model="form.new_password" type="password" :placeholder="$t('account.input_password')" />
                </el-form-item>
                <el-form-item>
                    <el-input v-model="form.secondary_password" type="password"
                        :placeholder="$t('account.input_password_again')" />
                </el-form-item>
                <el-form-item>
                    <el-button class="w-full h-32" type="primary" @click="onSubmit">
                        {{ $t('func.reset_password') }}
                    </el-button>
                </el-form-item>
            </el-form>

        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { resetLoginPassword } from '@/api';
import { ArrowRight } from '@element-plus/icons-vue'

const form = reactive({
    new_password: '',
    old_password: '',
    secondary_password: ''
})

const onSubmit = () => {
    resetLoginPassword(form, { showSuccessMessage: true }).then(() => {
        form.new_password = form.old_password = form.secondary_password = ''
    })
}
</script>