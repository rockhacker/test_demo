<template>
  <div class="pb20 feedback">
    <div class="pt20 ml20 w60 flex between alcenter">
      <span>{{$t('feed.type')}}</span>
      <el-select v-model="typeName" class="ht40 lh40 radius2 ml10 w80 nwhite bdinput" @change="changePay" placeholder=""> 
        <el-option v-for="item in typeList" :key="item.name" :label="item.name" :value="item">
          <span>{{ item.name }}</span>
        </el-option>
      </el-select>
    </div>
    <ul class="pt20 ml20 w60">
      <li class="flex between alcenter">
        <span>{{$t('feed.titel')}}：</span>
        <input
          type="text"
          v-model="title"
          :placeholder="$t('feed.p_title')"
          class="ht40 bdinput lh40 plr10 radius2 ml10 w80 nwhite"
        />
      </li>

      <li class="flex between alcenter mt20">
        <span>{{$t('feed.content')}}：</span>
        <textarea class="bdinput w80 ht180 nwhite plr10 ptb10" :placeholder="$t('feed.min_content')" style="background:transparent"  v-model="user_content"></textarea>
      </li>
      <li class="flex between alcenter mt20">
        <span></span>
        <div
        class="bgblue w80 ht40 flex alcenter jscenter  white radius6 ft16 pointer"
        style="margin-left:90px"
        @click="payMethodSave"
      >{{$t('collect.submits')}}</div>
      </li>
    </ul>
    <!-- <div class="flex jsend" style="width:63%">
      <div
        class="bgblue w100 ht40 flex alcenter jscenter mt40 white radius6 ft16 pointer"
        style="margin-left:110px"
        @click="payMethodSave"
      >{{$t('collect.submits')}}</div>
    </div> -->

    <div class="ptb20 mt30">
      <p class="flex1 plr20 ptb20 ft18 bdbheader">{{$t('assets.record')}}</p>
      <ul>
       
        <li class="flex column ptb10 bdbheader" v-for="item in logList" :key="item.id">
          <p class="w100 ptb5 ft14">{{item.title}}</p>
          <p class="w100 ptb5 ft14 red" v-if="item.reply==null">{{$t('feed.noreply')}}</p>
          <p class="w100 ptb5 ft14" v-else>{{$t('feed.reply')}}: {{item.reply}}</p>
          <p class="w100 ptb5 tr">{{item.created_at}}</p>
        </li>
      </ul>
      <!-- 分页 -->
      <div v-if="total >15" class="w100 tc pages mb40 mt20">
        <el-pagination
          :total="total"
          layout="prev, pager, next"
          @current-change="handleCurrentChange"
        ></el-pagination>
      </div>
      <div>
        <div class="tc ptb40" v-if="total==0">
          <img src="../../assets/images/nodata.png" alt class="wt70" />
          <p>{{$t('assets.noData')}}</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Axios from "axios";
export default {
  data() {
    return {
      title:'',
      user_content:'',
      user_image:'',
      index:0,
      listItem:[],
      typeList:[],
      typeName:'',
      type_id:'',
      logList: [],
      total: 0,
      page: 1,
    };
  },
  created() {
    this.init();
    this.getlist();
  },
  methods: {
    handleCurrentChange(val) {
      var that = this;
      that.logList = [];
      that.page = val;
      that.getlist();
    },
    getlist() {
      var that = this;
      that.$http
        .initDataToken(
          {
            url: 'feedback/list',
            data: {
              page: that.page
            }
          },
          false
        )
        .then(res => {
          console.log(res);
          that.total = res.total;
          that.logList = res.data;
        });
    },
    init() {
      var that = this;
      this.$http.initDataToken({ url: "feedback/type" }, false).then(res => {
        this.typeList = res;
        this.type_id = res[0].id;
        this.typeName = res[0].name;
      });
    },
    changePay(e) {
      this.type_id = e.id;
      this.typeName = e.name;
    },
    //   上传图片
    upload(options) {
      let that=this
      this.ossFileUpload(event.target.files[0],res=>{
                       if (options == 1) {
                        that.wechatCode = res.url;
                        that.wechatStatus = true;
                      } else if (options == 2) {
                        that.alipyCode = res.url;
                        that.alipyStatus = true;
                      }
      })
      // var that = this;
      // var datas = new FormData();
      // datas.append("file", event.target.files[0]);
      // that.$http
      //   .initDataToken(
      //     {
      //       url: "common/image_upload",
      //       data: datas,
      //       type: "POST"
      //     },
      //     false,
      //     true,
      //     true
      //   )
      //   .then(res => {
      //     if (options == 1) {
      //       that.wechatCode = res.url;
      //       that.wechatStatus = true;
      //     } else if (options == 2) {
      //       that.alipyCode = res.url;
      //       that.alipyStatus = true;
      //     }
      //   });
    },
    // 保存收款方式
    payMethodSave() {
      var that = this;
      if(!that.title){
        return that.$utils.layerMsg(that.$t('feed.p_title'));
      }
      if(!that.user_content){
        return that.$utils.layerMsg(that.$t('feed.p_content'));
      }
      that.$http
        .initDataToken(
          {
            url: "feedback/feedback",
            data: {
              title:that.title,
              content:that.user_content,
              type_id:that.type_id
            },
            type: "POST",
          },
          false
        )
        .then(res => {
          that.$utils.layerMsg(that.$t('feed.ok'),'success');
          that.title = '';
          that.user_content = '';
          that.logList = [];
          that.page = 1;
          that.getlist();
        });
    }
  }
};
</script>
<style lang="scss">
.feedback{

  .uploads input {
  opacity: 0;
}
.el-input__inner {
  height: 30px;
  line-height: 30px;
  border:none !important;
}
.pages .el-dialog,
.el-pager li {
  background: transparent;
}

.pages .el-pagination button {
  background: transparent !important;
  color: #b0b8db !important;
}

.pages .el-pagination button:disabled {
  color: #5a5a5a !important;
}

.pages .el-pagination {
  color: #b0b8db;
}
}

</style>