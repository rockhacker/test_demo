<template>
    <nav-bar :title="$t('func.chat')" />
    <iframe class="w-full h-chat" :src="link" frameborder="0"></iframe>
</template>
  
<script lang="ts" setup>

const link = 'https://baidu.com'

</script>

<style lang="scss" scoped>
.h-chat {
    height: calc(100vh - 46px) !important;
}
</style>