<template>
    <nav-bar :title="$t('auth.real_name')" />
    <div>
        <div v-if="status === 0" class="auth-page p-16 mt-8">
            <div class="text-14">
                {{ $t("auth.input_info") }}
            </div>

            <div class="text-14 text-[#888888]">
                <van-field class="mt-16" v-model="username" :label="$t('auth.name')" :placeholder="$t('auth.input_name')"
                    label-align="top" />

                <van-field class="mt-16" v-model="password" :label="$t('auth.id_number')"
                    :placeholder="$t('auth.input_id_num')" label-align="top" />
            </div>


            <div class="flex flex-col items-center">
                <div class="text-main-black text-center text-14 my-20">
                    {{ $t("auth.upload_idcard") }}
                </div>

                <upload v-model="front" />
                <div class="text-12 my-10 text-[#CBCBCB] text-center">
                    {{ $t("auth.upload_front") }}
                </div>


                <upload v-model="reverse" />
                <div class="text-12 my-10 text-[#CBCBCB]">
                    {{ $t("auth.upload_back") }}
                </div>

                <van-button class="mt-20 rounded-22 h-40" type="primary" block @click="onSubmit">
                    {{ $t("public.confirm") }}
                </van-button>
            </div>
        </div>
        <div class="text-center text-xl mt-40" v-else-if="status === 1">
            <van-icon name="clock-o" size="7.8rem" color="#9FEF4E" />
            <div class="mt-40 text-20">
                {{ $t("auth.waiting") }}
            </div>
        </div>
        <div class="text-center text-xl mt-40" v-else>
            <div class="flex justify-center border-6 border-main rounded-50% w-100 h-100 mx-auto items-center mt-36">
                <van-icon name="success" size="5rem" color="#9FEF4E" />
            </div>
            <div class="mt-40 text-20">{{ $t("auth.finish") }}</div>
        </div>
    </div>
</template>
  
<script lang="ts" setup>
import { queryAuthStatus, realName } from "@/api/user";
import { showSuccessToast } from "vant";

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
    realName(params, { loading: true }).then((res) => {
        showSuccessToast(res.msg);
        status.value = 1;
    });
};
</script>
  
  