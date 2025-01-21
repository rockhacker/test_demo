<template>
  <div class=" flex column alcenter">
    <div class="wt1000 plr40 ptb20 mauto">
    <div class="mt20 radius2 ptb20 bg-box2">
      <div class=" flex column between alcenter">
        <div class="tc pt20 white">
          {{ extension_url }}
        </div>
        <div
          style="width:250px"
          class="mt20  white radius30  ptb10 tc bg-primary"
          id="copy2"
          @click="copy2"
        >
          {{ $t('feed.copyadd') }}
        </div>
      </div>
    </div>

     <div class="mt20 radius2 flex ptb20 white flex column alcenter bg-box2">
        <span>      {{$t('new.fybl')}}:  {{$t('new.yj')}}/{{set_comm[1]}}%, {{$t('new.ej')}}/{{set_comm[2]}}%, {{$t('new.sj')}}/{{set_comm[3]}}%
</span>
    </div>

    <div class="mt20 radius2 flex ptb10 white bg-box2">
      <div class="flex1">
        <div class="tc">{{ $t('new.yqrssl') }}</div>
        <div class="tc mt10 ft24">{{ child_count }}</div>
      </div>
      <div class="flex1">
        <div class="tc">{{ $t('new.zhjlsl') }}(USDT)</div>
        <div class="tc mt10 ft24">
          {{ commission_folded_total }}
        </div>
      </div>
    </div>

    <div class="ptb20 mt30">
      <div class="flex1 plr20 ptb20 ft14 white">{{ $t('assets.record') }}</div>
     
     <el-table :data="commission_list" :empty-text="$t('staking.noRecords')" style="width: 100%" header-cell-class-name="bg-box2 white"  cell-class-name="bg-box2  white">
					<el-table-column :label="$t('new.khyx')" align="center">
                         <template slot-scope="scope">
								{{commission_list[scope.$index].get_user_info.email}}
					      </template>
                    </el-table-column>
					<el-table-column :label="$t('new.jl')" align="center">
                        <template slot-scope="scope">
                          {{commission_list[scope.$index].amount}}
                        </template>
                    </el-table-column>
                    <!-- <el-table-column prop="created_at" :label="$t('trade.time')" align="center">
                    </el-table-column> -->
    </el-table>

   <div v-if="total >10" class="w100 tc pages mb40 mt20">
        <el-pagination
          :total="total"
          :current-page="page"
          layout="prev, pager, next"
          @current-change="handleCurrentChange"
        ></el-pagination>
      </div>

      </div>
    </div>
  </div>
  </div>
</template>

<script>
import '@/lib/clipboard.min.js'
import vueQr from 'vue-qr'
export default {
  components: { vueQr },
  data() {
    return {
      extension_code: '',
      extension_url: '',
      child_count: null,
      commission_folded_total: null,
      commission_list: [],
      total: 0,
      page: 1,
      set_comm:{}
    }
  },
  created() {
    this.userInfo()
    this.getInfo()
  },
  methods: {
    handleCurrentChange(){
        var that = this;
      that.commission_list = [];
      that.page = val;
      that.getInfo();
    },
    userInfo() {
      this.$http.initDataToken({ url: 'user/info' }, false).then((res) => {
        this.extension_code = res.invite_code
        this.extension_url = `${window.location.origin}/#/register?extension_code=${res.invite_code}`
      })
    },
    getInfo() {
      this.$http
        .initDataToken(
          {
            url: 'user/getCommissionList',
            type: 'get',
            data: {
              page: this.page
            }
          },
          false
        )
        .then((res) => {
          
          this.commission_folded_total = res.total_commission
					this.child_count = res.people
          this.commission_list = res.list.data
					this.set_comm = res.set_comm
          this.total = res.list.total;

        })
    },
    // 复制邀請鏈接
    copy2() {
      var that = this
      var loc = location.origin
      var clipboard = new Clipboard('#copy2', {
        text: function() {
          return that.extension_url
        }
      })
      clipboard.on('success', function(e) {
        that.$utils.layerMsg(that.$t('authentication.copy_success'), 'success')
        clipboard.destroy()
      })
      clipboard.on('error', function(e) {
        that.$utils.layerMsg(that.$t('assets.copy_err'))
        clipboard.destroy()
      })
    }
  }
}
</script>

<style scoped>
.my-bg {
  /* background-image: url(/static/image/bg-new.png); */
  background-image: linear-gradient(to right, #ef7f77, #863cf1);
}
</style>
