<template>
  <div class=" flex minh80 mt50 mauto baselight" :class="!$route.query.isReg == 1 ? 'w80':'w600'">
    <div class="w20 tc ft16 assets bgwhite dark-bg-1C2532">
      <router-link
        :to="{name:item.page}"
        class="ptb20 block basecolor"
        v-for="(item,i) in listLeft"
        :key="i"
      >{{item.name}}</router-link>
    </div>
    <router-view class="flex1  bgwhite dark-bg-1C2532 ml10"></router-view>
  </div>
</template>
<script>
export default {
  data() {
    return {
      listLeft: [
        {
          name: this.$t('header.account'),
          page: "accountSettings"
        },
        // {
        //   name: "交易日志",
        //   page: "transactionLog"
        // },
        // {
        //   name: this.$t('header.pays'),
        //   page: "collectionSettings"
        // },
        // {
        //   name: this.$t('header.auth'),
        //   page: "authentication"
        // },
        {
          name: this.$t('feed.feed'),
          page: "feedback"
        }
      ]
      
    };
  },
  created() {
    console.log(13123)
  },
  methods: {
    changepage(e) {
      // this.curpage=e;
    }
  }
};
</script>
<style lang="">
.assets {
  min-height: 500px;
}
 .assets .router-link-exact-active{
       background: linear-gradient(175deg, #67E1AB, #28C2C8) !important;
        color: white !important;
    }
    .w600{
      width:600px;
    }
</style>
