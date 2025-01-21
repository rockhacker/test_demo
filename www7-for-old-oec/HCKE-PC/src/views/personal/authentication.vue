<template>
  <div class="pb20">
    <ul class="ptb40 plr30 mauto" v-if="authStatus == 0">
      <li class="flex between alcenter">
        <span class="wt160">{{ $t("authentication.name") }}：</span>
        <input
          type="text"
          v-model="realName"
          :placeholder="$t('collect.pleaseenteraname')"
          class="ht30 bdinput lh30 plr10 radius2 flex1 nwhite"
        />
      </li>
      <li class="flex between alcenter mt20">
        <span class="wt160">{{ $t("collect.cardno") }}：</span>
        <input
          type="text"
          v-model="idaccount"
          :placeholder="$t('collect.p_cardno')"
          class="ht30 bdinput lh30 plr10 radius2 flex1 nwhite"
        />
      </li>
	  
	  <li class="flex between alcenter mt40 flexstart">
	    <div>
        <div class="wt160 pr20">{{ $t("collect.upImg") }}</div>
        <div class="wt160 pr20 mt20">{{$t('new.zjsm')}}</div>
      </div>
		<div class="flex1 flex wraps">
			<div class="flex1 mb20">
			  <div class="uploads wt240 ht130 posRelt pointer">
			    <img :src="src1" class="w100 h100" alt />
			    <input
			      type="file"
			      class="w100 h100 abstort lf0 btm0"
			      accept="image/*"
			      name="file"
			      @change="upload(1)"
			    />
			  </div>
			</div>
			<div class="flex1">
			  <div class="uploads wt240 ht130 posRelt pointer">
			    <img :src="src2" class="w100 h100" alt />
			    <input
			      type="file"
			      class="w100 h100 abstort lf0 btm0"
			      accept="image/*"
			      name="file"
			      @change="upload(2)"
			    />
			  </div>
			</div>
      <div class="flex1">
          <div class="uploads wt240 ht130 posRelt pointer">
            <img :src="src3" class="w100 h100" alt />
            <input
              type="file"
              class="w100 h100 abstort lf0 btm0"
              accept="image/*"
              name="file"
              @change="upload(3)"
            />
          </div>
        </div>
		</div>
	  
	  <li class="flex alcenter mt20">
			<span class="wt160"></span>
		    <div class="bgblue wt200 ht40 flex alcenter jscenter mt40 white radius6 ft16"
			 @click="submits" v-if="authStatus == 0">
			 {{ $t("collect.submits") }}
		    </div>
	  </li>
	  
    </ul>
	<div class="flex jscenter alcenter" v-else>
		<div class="pt120 wt200 tc ft20 nwhite">
		{{ $t(authStatus == 1?"authentication.ing":"authentication.has") }}
		</div>
	</div>

   
  </div>
</template>
<script>
export default {
  data() {
    return {
      realName: "",
      idaccount: "",
      src1: require("@/assets/images/1614569942(1).jpg"),
      src2: require("@/assets/images/1614588414(1).jpg"),
      src3: require("@/assets/images/real3.png"),
      authStatus: 0,
      src1Status:false,
      src2Status:false,
      src3Status:false,
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      var that = this;
      that.$http.initDataToken({ url: "user_real/center" }, false).then(res => {
        that.authStatus = res.review_status;
      });
    },
    //   上传图片
    upload(options) {
      let that=this
      this.ossFileUpload(event.target.files[0],res=>{
                  if (options == 1) {
                    that.src1 = res.url;
                    that.src1Status = true;
                  } else if (options == 2) {
                    that.src2 = res.url;
                    that.src2Status = true;
                  } else if (options == 3) {
                    that.src3 = res.url;
                    that.src3Status = true;
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
      //       that.src1 = res.url;
      //       that.src1Status = true;
      //     } else if (options == 2) {
      //       that.src2 = res.url;
      //       that.src2Status = true;
      //     } else if (options == 3) {
      //       that.src3 = res.url;
      //       that.src3Status = true;
      //     }
      //   });
    },
    submits() {
      var that = this;
      if(!that.realName){
        that.$utils.layerMsg(this.$t('collect.p_name'));
        return false;
      }
      if(!that.idaccount){
        that.$utils.layerMsg(this.$t('collect.p_cardno'));
        return false;
      }
      if(!that.src1Status){
        that.$utils.layerMsg(this.$t('collect.up_cardz'));
        return false;
      }
      if(!that.src2Status ){
        that.$utils.layerMsg(this.$t('collect.up_cardf'));
        return false;
      }
      if(!that.src3Status){
        that.$utils.layerMsg(this.$t('collect.up_cardhand'));
        return false;
      }
      console.log(that.src1)
      that.$http
        .initDataToken(
          {
            url: "user_real/real_name",
            data: {
              name: that.realName,
              card_id: that.idaccount,
              front_pic: that.src1,
              reverse_pic: that.src2,
              hand_pic: that.src3
            },
            type:"post"
          },
          true
        )
        .then(res => {});
    }
  }
};
</script>
<style lang="scss" scoped>
.uploads input {
  opacity: 0;
}
</style>