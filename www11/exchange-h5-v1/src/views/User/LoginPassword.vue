<template>
     <nav-bar :title="$t('func.reset_password')" />

     <div class="px-12">
          <van-field v-model="form.old_password" class="mt-12" type="password" :placeholder="$t('account.input_old_password')"
               label-align="top" />
          <van-field v-model="form.new_password" class="mt-12" type="password" :placeholder="$t('account.input_password')"
               label-align="top" />
          <van-field v-model="form.secondary_password" class="mt-12" type="password" :placeholder="$t('account.input_password_again')"
               label-align="top" />

          <van-button class="mt-40 rounded-22 h-42" color="#2fdab0" block @click="onSubmit">
               {{ $t('func.reset_password') }}
          </van-button>
     </div>
</template>

<script lang="ts" setup>
import { resetLoginPassword } from '@/api/user';
import { showSuccessToast } from 'vant';

const form = reactive({
     new_password: '',
     old_password: '',
     secondary_password: ''
})

const onSubmit = () => {
     resetLoginPassword(form).then(({ msg }) => {
          showSuccessToast(msg!)
          form.new_password = form.old_password = form.secondary_password = ''
     })
}

</script>