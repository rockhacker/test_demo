<template>
  <div class="plr20 ptb20 notice flex column alcenter jscenter">
    <!-- <div class="header flex alcenter wraps bgpart baselight">
                <span v-for='(item,index) in List' :key="index" @click="getNoticeList(item.id)" v-show="item.id!=23" :class="['pointer','ft16',{'select':current==item.id}]">{{item.name}}</span>
        </div> -->
    <div class="content flex baselight  mt10">
      <div class="left flex column plr20" style="width:300px;">
        <h1 class="ft16 bold mt20 pb10">{{ $t("www.noticeCenter") }}</h1>
        <span
          v-for="(item, index) in noticeList"
          :key="index"
          @click="getDetail(item)"
          :class="['pointer', 'ft14', 'ml20' ,'plr10',{ 'text-primary bg-box': detail == item }]"
          >{{ item.title }}</span
        >
      </div>
      <div class="right flex1 bg-box ml20 flex column plr20 ptb20 baselight" style="width: 940px;">
        <template  v-if="detail">
          <div class="ft24 mt20 pb10 border-b-EEEEEE">
            <div class="tc">{{ detail.title }}</div>
            <div class="tr ft12">{{ detail.created_at }}</div>
          </div>
          <div v-html="detail.content" class="mt20 ft16 text-999999 auto"></div>
          <span class="flex jsend ft14 bold mt20">{{ time }}</span>
        </template>
        <div v-else class="tc ptb40">
          <img src="../assets/images/nodata.png" alt class="wt70" />
          <p>{{ $t("lever.noData") }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      List: [],
      noticeList: [],
      news: "",
      time: "",
      title: "",
      id: "",
      current: "",
      detail: null,
    };
  },
  created() {
    this.getAnnouncement();
    // this.id = this.$route.query.id;
    // this.current = this.$route.query.category_id;
    // this.getDetail(this.id);
    // this.getNoticeList()
    // this.getAllList()
  },
  methods: {
    getAnnouncement() {
      try {
        const that = this;
        that.$http
          .initDataToken(
            {
              url: "news/list?category_id=0&limit=100",
            },
            false
          )
          .then((res) => {
            this.noticeList = res.data;
            this.detail = this.noticeList[0] || {};
            console.log(res);
          });
      } catch (e) {
        console.log(e);
        //TODO handle the exception
      }
    },
    //新闻分类
    getAllList() {
      this.$http
        .initDataToken(
          {
            url: "news/categories",
            data: {},
          },
          false
        )
        .then((res) => {
          this.List = res;
        });
    },
    //公告
    getNoticeList() {
      // this.current = id;
      this.$http
        .initDataToken(
          {
            url: "news/list",
            data: { category_id: this.current },
          },
          false
        )
        .then((res) => {
          this.noticeList = res.data;
        });
    },
    getDetail(info) {
        this.detail = info
    //   this.id = id;
    //   this.$http
    //     .initDataToken(
    //       {
    //         url: "news/info",
    //         data: { id: id },
    //       },
    //       false
    //     )
    //     .then((res) => {
    //       console.log(res);
    //       this.news = res.content;
    //       this.time = res.created_at;
    //       this.title = res.title;
    //     });
    },
  },
};
</script>
<style lang="scss" scoped>
.header {
  width: 1200px;
  height: 180px;
  padding: 5px 15px;
  span {
    width: 155px;
    text-align: center;
    border-radius: 5px;
    line-height: 35px;
    border: 1px solid rgba(53, 124, 225, 1);
    margin: 0 20px;
  }
  span:hover {
    color: #fff;
    background-color: rgba(53, 124, 225, 1);
  }
  .select {
    color: #fff;
    background-color: rgba(53, 124, 225, 1);
  }
}
.content {
  width: 1300px;
  max-width: 1300px;
  min-height: 80vh;
  .left {
    width: 20%;
    span {
      width: 100%;
      line-height: 25px;
      border-radius: 4px;
      display: block;
      font-weight: 300;
      margin-top: 10px;
      padding: 10px;
      word-break: break-all;
    }
    /* span:hover {
      color: #fff;
      background-color: E5A013;
    }
    .select {
      color: #fff;
      background-color: #e5a013;
    } */
  }
  .right {
  }
  .right::-webkit-scrollbar {
  }
}
</style>
