<template>
    <div>
        <div v-if="status === 0 " class="auth-page p-16 mt-8">
            <div class="text-14 font-bold mb-20">
                {{ $t("auth.input_info") }}
            </div>

            <el-form label-width="auto">
                <el-form-item :label="$t('auth.name')">
                    <el-input v-model="username" :placeholder="$t('auth.input_name')" />
                </el-form-item>
                <el-form-item :label="$t('auth.id_number')">
                    <el-input v-model="password" :placeholder="$t('auth.input_id_num')" />
                </el-form-item>
            </el-form>

            <div class="flex flex-col items-center">
                <div class="text-main-black text-center text-14 my-20">
                    {{ $t("auth.upload_idcard") }}
                </div>

                <div class="flex items-center justify-between w-full">
                    <div class="flex flex-col items-center justify-center flex-1 mr-20">
                        <upload v-model="front" />
                        <div class="text-12 my-10 text-[#CBCBCB] text-center">
                            {{ $t("auth.upload_front") }}
                        </div>
                    </div>

                    <div class="flex flex-col items-center justify-center flex-1 ml-20">
                        <upload v-model="reverse" />
                        <div class="text-12 my-10 text-[#CBCBCB]">
                            {{ $t("auth.upload_back") }}
                        </div>
                    </div>
                </div>

                <el-button class="mt-20 w-full h-40" type="primary" block @click="onSubmit">
                    {{ $t("public.confirm") }}
                </el-button>
            </div>
        </div>
        <div class="text-center text-xl mt-40" v-else-if="status === 1">
            <el-icon size="100px" color="#9FEF4E">
                <Clock />
            </el-icon>
            <div class="mt-40 text-20">
                {{ $t("auth.waiting") }}
            </div>
        </div>
        <div class="text-center text-xl mt-40" v-else>
            <el-icon size="100px" color="#9FEF4E">
                <CircleCheck />
            </el-icon>
            <div class="mt-40 text-20">{{ $t("auth.finish") }}</div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { queryAuthStatus, realName } from "@/api/user";

const username = ref("");
const password = ref("");

const front = ref('');
const reverse = ref('');

const status = ref(0);

queryAuthStatus({}, { loading: true }).then((res) => {
    status.value = res.data.review_status;
});

const onSubmit = () => {
    const params = {
        name: username.value,
        card_id: password.value,
        front_pic: front.value,
        reverse_pic: reverse.value,
    };
    realName(params, { loading: true, showSuccessMessage: true }).then((res) => {
        status.value = 1;
    });
};
</script>