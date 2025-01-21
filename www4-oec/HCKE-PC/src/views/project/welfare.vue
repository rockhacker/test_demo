<template>
  <div>
    <div class="bdbea2 flex alcenter bold ptb20">
        <div class="pb10 ml40 pointer ft14" :class="{'active2px':index==i}" v-for="(item,i) in list" :key="i" @click='index=i'>{{item}}</div>
    </div>
    <invite v-show="index==0"></invite>
    <signIn v-show="index==1"></signIn>
  </div>
</template>

<script>
 import signIn from '@/views/personal/signIn' 
 import invite from './invite.vue'
export default {
    components:{
        signIn,
        invite
    },
    data(){
        return {
            list:[this.$t('new.tdrw'),this.$t('new.qd')],
            index:0
        }
    }
}
</script>

<style>

</style>