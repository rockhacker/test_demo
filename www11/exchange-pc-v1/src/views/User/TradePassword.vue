<template>
    <div class="max-w-[1200px] mx-auto py-20 w-full flex flex-col">
        <el-card class="w-full" shadow="hover">
            <el-breadcrumb :separator-icon="ArrowRight">
                <el-breadcrumb-item :to="{ path: '/user/info' }"> {{ $t('func.account_setting') }}</el-breadcrumb-item>
                <el-breadcrumb-item>{{ $t('trade.trade_password') }}</el-breadcrumb-item>
            </el-breadcrumb>
        </el-card>

        <el-card class="w-full mt-20 p-20" shadow="hover">
            <div class="w-70% mx-auto">
                <el-form label-width="auto">
                    <el-form-item>
                        <el-input v-model="form.password" type="password"
                            :placeholder="$t('trade.input_trade_password')" class="h-32" />
                    </el-form-item>
                    <el-form-item>
                        <el-input v-model="form.secondary_password" type="password"
                            :placeholder="$t('trade.check_trade_password')" />
                    </el-form-item>
                    <el-form-item>
                        <el-button class="w-full h-32" type="primary" @click="onSubmit">
                            {{ $t('func.reset_password') }}
                        </el-button>
                    </el-form-item>
                </el-form>
            </div>
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { resetTradePassword } from '@/api';
import { ArrowRight } from '@element-plus/icons-vue'

const form = reactive({
    password: '',
    secondary_password: ''
})

const onSubmit = () => {
    resetTradePassword(form, { showSuccessMessage: true }).then(() => {
        form.password = form.secondary_password = ''
    })
}
</script>