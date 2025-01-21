<template>
    <nav-bar :title="$t('func.other')" />

    <div class="text-14">
        <div class="py-10 px-16 flex items-center justify-between mt-10" @click="handleLogout">
            <div class="flex items-center">
                <van-icon name="share" size="1.4rem" color="#9FEF4E" />
                <span class="pl-10">{{ $t('func.logout') }}</span>
            </div>
            <div class="flex items-center">
                <van-icon name="arrow" color="#888" size="1.3rem" />
            </div>
        </div>
        <van-divider />
    </div>
</template>

<script lang="ts" setup>
import { showConfirmDialog, showSuccessToast } from "vant";
import { useI18n } from "vue-i18n";
import { useUserStore } from "@/store";

const { t } = useI18n();
const router = useRouter();
const { resetUserInfo } = useUserStore();
// const { logout } = useWebsocketStore();

const handleLogout = () => {
  showConfirmDialog({
    title: t("public.tip"),
    message: t("user.confirm_logout"),
  }).then(() => {
    resetUserInfo();
    router.replace("/");
    // logout(); 
    showSuccessToast(t("user.logout_success"));
    // on confirm
  });
};
</script>

