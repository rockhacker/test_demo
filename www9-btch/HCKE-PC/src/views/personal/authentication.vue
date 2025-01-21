<template>
  <div class=" authentication ">
    <ul class="pb20 pt20 plr30 mauto bgwhite radius4" style="width: 600px;">
      <step   v-show="$route.query.isReg == 1" style="margin: 0 auto;" :active="1"></step>
      <li class="flex between alcenter" v-if="status">
        <span class="wt160">{{ $t("collect.rzzt") }}：</span>
        <span class="flex1">{{status}}</span>
      </li>
        <li class="flex between alcenter mt20" v-if="authStatus == 1">
          <span class="wt160">{{ $t("collect.bhly") }}：</span>
          <span class="flex1">{{remark}}</span>
        </li>
      <li class="flex column between alcenter se-input mt20">
        <span class="w100 mb10">{{ $t("add.guoj") }}</span>
         <el-select  :disabled="authStatus ==0 || authStatus == 2" filterable   v-model="country_code"  :placeholder="$t('add.p_guoj')" class="ht30 w100 bdinput lh30 plr10 radius2 flex1 nwhite" @change='changeCountry'>
          <el-option
              v-for="item in countries"
              :key="item.id"
              :label="item.trans_name"
              :value="item.id">
              <span class="fl">{{ item.trans_name }}</span>
              <!-- <span  class="fr ft14">+{{ item.global_code }}</span> -->
          </el-option>
        </el-select>
      </li>
      <li class="flex column column between alcenter mt20">
        <span class="w100 mb10">{{ $t("authentication.name") }}</span>
        <input
         :readonly="authStatus ==0 || authStatus == 2"
          type="text"
          v-model="realName"
          :placeholder="$t('collect.pleaseenteraname')"
          class="w100 ht30 bdinput lh30 plr10 radius2 flex1 nwhite"
        />
      </li>
      <li class="flex column between alcenter mt20">
        <span class="w100 mb10">{{ $t("collect.cardno") }}</span>
        <input
        :readonly="authStatus ==0 || authStatus == 2" 
          type="text"
          v-model="idaccount"
          :placeholder="$t('collect.p_cardno')"
          class="w100 ht30 bdinput lh30 plr10 radius2 flex1 nwhite"
        />
      </li>
	  
	  <li class="flex column between alcenter mt40">
	    <span class="w100 mb10">{{ $t("collect.up_card") }}</span>
		<div class="flex1 flex w100">
			<div class="flex1 flex jscenter">
			  <div class="uploads wt100 ht100  posRelt pointer">
			    <img :src="src1" class="w100 h100" alt />
			    <input
           
           :disabled="authStatus ==0 || authStatus == 2" 
			      type="file"
			      class="w100 h100 abstort lf0 btm0"
			      accept="image/*"
			      name="file"
			      @change="upload(1)"
			    />
          <div class="tc">{{$t('collect.up_cardz')}}</div>
			  </div>
       
			</div>
			<div class="flex1 flex jscenter">
			  <div class="uploads wt100 ht100  posRelt pointer">
			    <img :src="src2" class="w100 h100" alt />
			    <input
          :disabled="authStatus ==0 || authStatus == 2" 
			      type="file"
			      class="w100 h100 abstort lf0 btm0"
			      accept="image/*"
			      name="file"
			      @change="upload(2)"
			    />
          <div class="tc">{{$t('collect.up_cardf')}}</div>
			  </div>
			</div>
      <div class="flex1 flex jscenter">
			  <div class="uploads wt100  ht100 posRelt pointer">
			    <img :src="src3" class="w100 h100" alt />
			    <input
          :disabled="authStatus ==0 || authStatus == 2" 
			      type="file"
			      class="w100 h100 abstort lf0 btm0"
			      accept="image/*"
			      name="file"
			      @change="upload(3)"
			    />
          <div class="tc">{{$t('collect.up_cardhand')}}</div>
			  </div>
			</div>
		</div>
	  </li>
      <li class="flex column between alcenter mt40">
        <span class="w100 mb10">{{ $t("collect.sl") }}</span>
        <img class="flex1 w100" src="../../assets/images/sl.png" alt="">
      </li>
        <!-- <div class="tc ml30">
          <div class="uploads posRelt wt120 ht120 mt10 pointer">
            <img :src="src3" class="wt1201 ht120" alt />
            <input
              type="file"
              class="wt1201 ht120 abstort lf0 btm0"
              accept="image/*"
              name="file"
              @change="upload(3)"
            />
          </div>
        </div> -->
     
	  
	  <li class="flex alcenter jscenter mt20"  v-if="authStatus != 0 && authStatus != 2">
		    <div class="pointer bg-main-liner wt200 ht40 flex alcenter jscenter mt20 white radius6 ft16"
			 @click="submits">
			 {{ $t("collect.submits") }}
		    </div>
	  </li>
	  <li class="flex alcenter jscenter mt20"  v-if="authStatus != 0 && authStatus != 2 && $route.query.isReg == 1">
		    <div class="pointer  wt200 ht40 flex alcenter jscenter  radius6 ft16"
			 @click="tiaog">
			 {{ $t("add.tiaog") }}
		    </div>
	  </li>
    </ul>
	<!-- <div class="flex jscenter alcenter" v-else>
		<div class="pt120 wt200 tc ft20 nwhite">
		{{ $t(authStatus == 1?"authentication.ing":"authentication.has") }}
		</div>
	</div> -->

   
  </div>
</template>
<script>
import step from '@/components/step'
export default {
  components:{step},
  data() {
    return {
      realName: "",
      idaccount: "",
      src1: require("@/assets/images/addimg.png"),
      src2: require("@/assets/images/addimg.png"),
      src3: require("@/assets/images/addimg.png"),
      authStatus: 0,
      src1Status:false,
      src2Status:false,
      src3Status:false,
      countries: [],
      country_code: '',
      countryCodeId:'',
      remark:'',
      status:''
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    tiaog(){
      this.$router.push('/google?isReg=1')
    },
    getList(){
      this.$http.initDataToken({url:'default/area_list'},false)
        .then(res=>{
           this.countries=res;
           this.countries.forEach((item,index) => {
							  if(item.id == this.countryCodeId){
								this.country_code = item.name
							  }
						});
           if(res.length>0){
            //    this.country_code='+'+res[0].global_code;
              //  this.country_code = res[0].name;
              //  this.countryCodeId = res[0].id;
           }
        })
    },
    changeCountry(e){
            console.log(e);
            this.countryCodeId = e;
    },
    init() {
      var that = this;
      that.$http.initDataToken({ url: "user_real/center" }, false).then(res => {
        that.authStatus = res.review_status;
        if(that.authStatus != -1){
          that.src1Status = true;
          that.src2Status = true;
          that.src3Status = true;
          that.realName = res.name
          that.remark = res.remark;
          that.idaccount = res.card_id
          that.src1 = res.front_pic
          that.src2 = res.reverse_pic
          that.countryCodeId = res.area_id
          that.src3 = res.hand_pic
					}
          console.log(that.authStatus )
          if(that.authStatus == 0){
						that.status = this.$t('authentication.ing')
					}else if(that.authStatus == 1){
						that.status = this.$t('collect.ff')
					}else if(that.authStatus == 2){
						that.status = this.$t('authentication.has')
					}
          that.getList()
      });
    },
    //   上传图片
    upload(options) {
     // let that=this
      // this.ossFileUpload(event.target.files[0],res=>{
      //             if (options == 1) {
      //               that.src1 = res.url;
      //               that.src1Status = true;
      //             } else if (options == 2) {
      //               that.src2 = res.url;
      //               that.src2Status = true;
      //             } else if (options == 3) {
      //               that.src3 = res.url;
      //               that.src3Status = true;
      //             }
      // })
      var that = this;
      if(that.authStatus == 0 || that.authStatus == 2)return;
      var datas = new FormData();
      datas.append("file", event.target.files[0]);
      that.$http
        .initDataToken(
          {
            url: "common/image_upload",
            data: datas,
            type: "POST"
          },
          false,
          true,
          true
        )
        .then(res => {
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
        });
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
      // if(!that.src3Status){
      //   that.$utils.layerMsg(this.$t('collect.up_cardhand'));
      //   return false;
      // }
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
              area_id: that.countryCodeId,
              hand_pic: that.src3
            },
            type:"post"
          },
          true
        )
        .then(res => {
          if(this.$route.query.isReg == 1){
            this.$router.push('/google?isReg=1')
          }else{
            this.$router.push('/home')
          }
              
        });
    }
  }
};
</script>
<style lang="scss" scoped>
.uploads input {
  opacity: 0;
}
.se-input >>> .el-input__inner{
   border:none;
   line-height: 30px;
   height:30px;
   padding-left: 0;
}
.se-input >>> .el-input.is-disabled .el-input__inner{
  background: transparent;
}
.authentication{
  min-height: calc(100vh - 60px);
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}
</style>