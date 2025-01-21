<template>
     <nav-bar :title="$t('trade.trade_password')" />

     <div class="px-12">
          <van-field v-model="form.password" class="mt-12" type="password" :placeholder="$t('trade.input_trade_password')"
               label-align="top" />
          <van-field v-model="form.secondary_password" class="mt-12" type="password" :placeholder="$t('trade.check_trade_password')"
               label-align="top" />

          <van-button class="mt-40 rounded-22 h-42" color="#2fdab0" block @click="onSubmit">
               {{ $t('func.reset_password') }}
          </van-button>
     </div>
</template>

<script lang="ts" setup>
import { resetTradePassword } from '@/api/user';
import { showSuccessToast } from 'vant';

const form = reactive({
     password: '',
     secondary_password: ''
})

const onSubmit = () => {
     resetTradePassword(form).then(({ msg }) => {
          showSuccessToast(msg!)
          form.password = form.secondary_password = ''
     })
}

</script>