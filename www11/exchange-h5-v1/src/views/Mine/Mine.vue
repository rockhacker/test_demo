<template>
  <div class="mine-page text-14">
    <div class="flex items-center justify-between">
      <div v-if="user">
        <div class="flex items-center">
          <div class="text-16">{{ user.email || user.mobile }}</div>
          <span class="ml-8 vip-tag">
            {{ user.level }}
          </span>
        </div>
        <div class="text-#888">
          <span> UID:{{ user.uid }} </span>
          <span class="ml-10">{{ $t('user.credit') }}:{{ user.credit_score }}</span>
        </div>
      </div>
      <to-login v-else class="w-auto" />
      <svg-icon class="p-6 w-30 h-30" name="global" @click="router.push('/user/language')" />
    </div>

    <div class="assets-card mt-20">
      <div class="flex items-center justify-between">
        <div>{{ $t('func.my_assets') }}(USDT)</div>
        <van-icon class="p-6" :name="showAssets ? 'eye-o' : 'closed-eye'" size="1.4rem"
          @click="setShowAssets(!showAssets)" />
      </div>
      <div class="py-10 text-center text-#E8EDF4 text-20">
        {{ showAssets ? totalBalance : '******' }}
      </div>

      <div class="text-#888 flex items-center justify-between" @click="router.push('/user/assets')">
        <div>{{ $t('public.available') }}:</div>
        <div class="flex items-center">
          <span>{{ showAssets ? availableBalance : '******' }}</span>
          <van-icon class="p-6" name="arrow" />
        </div>
      </div>
    </div>

    <div class="mt-20 flex items-center justify-around">
      <fun-label icon="deposit" :label="$t('recharge.fast_recharge')" @click="router.push('/user/recharge')" />
      <fun-label icon="mention" :label="$t('func.mention')" @click="router.push('/user/withdraw')" />
      <fun-label icon="transter" :label="$t('func.transfer')" @click="router.push('/user/transfer')" />
      <fun-label icon="exchange" :label="$t('func.exchange')" @click="router.push('/user/exchange')" />
    </div>

    <div class="mt-20">
      <div>{{ $t('user.account') }}</div>
    </div>

    <div class="func-card mt-12">
      <fun-item icon="share-link" :label="$t('func.share_link')" @click="router.push('/user/invite')" />
      <fun-item class="mt-10" icon="auth-code" :label="$t('func.auth_code')" @click="router.push('/user/auth-code')" />
      <fun-item class="mt-10" icon="security-center" :label="$t('func.safe_center')"
        @click="router.push('/user/safe-center')" />
      <fun-item class="mt-10" icon="withdraw-address" :label="$t('func.bind_withdraw_add')"
        @click="router.push('/user/bind-mention-address')" />
      <fun-item class="mt-10" icon="collection-method" :label="$t('func.flat_collection_method')"
        @click="router.push('/user/collection-method')" />
    </div>

    <div class="mt-20">
      <div>{{ $t('user.universal') }}</div>
    </div>

    <div class="func-card mt-12">
      <fun-item class="mt-10" icon="chat" :label="$t('func.chat')" @click="router.push('/user/chat')" />
      <fun-item class="mt-10" icon="white-paper" :label="$t('func.white_paper')" @click="toWhitePaper" />
      <fun-item class="mt-10" icon="feedback" :label="$t('func.submit_feedback')"
        @click="router.push('/user/feedback')" />
      <fun-item class="mt-10" icon="download" :label="$t('func.download_app')" @click="downloadApp" />
      <fun-item class="mt-10" icon="setting" :label="$t('func.other')" @click="router.push('/user/setting')" />
    </div>
  </div>
</template>

<script lang="ts" setup name="mine">
import FunLabel from './components/FunLabel.vue'
import FunItem from './components/FunItem.vue'
import { useUserStore } from '@/store';
import { downloadApp, HTTP_BASE_URL } from '@/common'

const router = useRouter()

const { user, isLogin, totalBalance, availableBalance } = storeToRefs(useUserStore())

const [showAssets, setShowAssets] = useToggle(true)

const { getAccountData } = useUserStore()

const toWhitePaper = () => {
  window.open(`${HTTP_BASE_URL}/wp/TEST-en.pdf`)
}

getAccountData()


</script>

<style lang="scss" scoped>
.mine-page {
  padding: 12px 12px 120px;

  .vip-tag {
    position: relative;
    font-size: 12px;
    color: #232323;
    padding: 2px 6px;
    border-radius: 4px;
    background: linear-gradient(180deg, #FDF00C 0%, #9FEF4E 100%);
    transform: skew(-20deg);

  }

  .assets-card {
    border-radius: 18px;
    padding: 10px;
    background: linear-gradient(180deg, rgb(158 239 78 / 41%), #312e2e);
  }

  .func-card {
    background-color: #3E423A;
    padding: 10px 16px;
    border-radius: 16px;
  }
}
</style>
