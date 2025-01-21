<template>
  <div class="w80 flex minh80 mt50 mauto baselight">
    <div class="w20 tc ft16 assets bdr bgwhite">
      <router-link :to="{name:item.page}" class="ptb20 block black" v-for="(item,i) in listLeft" :key="i">{{item.name}}</router-link>
    </div>
    <router-view class="flex1  ml10"></router-view>
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
        {
          name: this.$t('header.pays'),
          page: "collectionSettings"
        },
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
  created() {},
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
.assets .router-link-exact-active {
  background: #057967;
  color: #fff;
}
</style>
