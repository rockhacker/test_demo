<template>
  <div class="minh100 ft16 bgblack">
    <div class="mauto pt20 wt1200 pb80">
      <el-card class="ft18 mb20" style="border:0;">
        <div>{{ $t('financial.tglj') }}: {{extension_url}}</div>
      </el-card>

      <!-- <el-card class="ft18 mb20" style="border:0;">
        <div>{{ $t('financial.fygz') }}: 
          <span v-if="rule[1]">{{$t('financial.yjfy')+ rule[1]}}% ,{{$t('financial.ejfy')+ rule[2]}}% ,{{$t('financial.sjfy')+ rule[3]}}%</span>
        </div>
      </el-card> -->

      <el-card class="ft18 mb20" style="border:0;">
        <div v-if="false" class="mx-30 p-30 rounded-xl flex mt-50">
          <div class="flex column flex1 alcenter">
            <div class="text-2xl">{{ base.people_all }}</div>
            <div class="mt-20">{{ $t('financial.tgzrs') }}</div>
          </div>
          <div class="flex column flex1 alcenter">
            <div class="text-2xl">{{ base.people_one }}</div>
            <div class="mt-20">{{ $t('financial.ydrs') }}</div>
          </div>
          <div
            class="flex column flex1 alcenter px-30"
            style="border:0 solid rgba(255, 255, 255, .2);border-left-width: 1rpx;border-right-width: 1rpx;"
          >
            <div class="text-2xl">{{ base.people_two }}</div>
            <div class="mt-20">{{ $t('financial.edrs') }}</div>
          </div>
          <div
            class="flex column flex1 alcenter"
            style="border-right: 1rpx solid rgba(255, 255, 255, 0.2)"
          >
            <div class="text-2xl">{{ base.people_three }}</div>
            <div class="mt-20">{{ $t('financial.sdrs') }}</div>
          </div>
          <!-- <div class="flex column flex1 alcenter">
            <div class="text-2xl">{{ base.people_four }}</div>
            <div class="mt-20">{{ $t('financial.sid') }}</div>
          </div> -->
        </div>
        {{$t('new.fyzj')}}: {{base.comm_total}}
      </el-card>

      <el-card class="ft18 mb20" style="border:0;">
        <div class="text-xl mt-30">{{ $t('financial.wdtg') }}</div>

        <div class="w-690 rounded-xl mt-30 wdtg">
          <div v-if="false" class="flex">
            <div
              class="flex1 tc p-20"
              :class="{ type: active == 1 }"
              @click="change(1)"
            >
              {{ $t('financial.yd') }}
            </div>
            <div
              class="flex1 tc p-20"
              :class="{ type: active == 2 }"
              @click="change(2)"
              style="border-left: 1px solid rgba(255, 255, 255, .2);border-right: 1px solid rgba(255, 255, 255, .2)"
            >
              {{ $t('financial.ed') }}
            </div>
            <div
              class="flex1 tc p-20"
              :class="{ type: active == 3 }"
              @click="change(3)"
            >
              {{ $t('financial.sd') }}
            </div>
            <!-- <div
              class="flex1 tc p-20"
              :class="{ type: active == 4 }"
              @click="change(4)"
            >
              {{ $t('financial.sid') }}
            </div> -->
          </div>
          <div>
            <div>
              <div
                class="plr20 ptb20"
                style="border-bottom;: 1px solid rgba(255, 255, 255, .2)"
                v-for="(item, index) in list"
                :key="index"
              >
                <div class="flex between">
                  <div class="flex alcenter">
                    <span class="text-lg" style="color:#8B8B8B"
                      >UID:
                    </span>
                    <div class="flex alcenter">
                      <span class="text-lg pl-10">{{ item.uid }}</span>
                      <div class="wt20 ht20 sign-round ml10" :class="{'is-sign':item.is_sign}"></div>
                    </div>
                  </div>
                  <div class="mt10">
                    <span class="text-lg" style="color:#8B8B8B"
                      >{{ $t('financial.zrs') }}:
                    </span>
                    <span class="text-lg pl-10"
                      >{{ item.lower_num }}{{ $t('financial.ren') }}</span
                    >
                  </div>
                </div>
                <div class="mt-16 flex between">

                  <div >
                    <span style="color:#8B8B8B">{{$t('financial.fyje')}}</span>: {{item.comm_sum}}
                  </div>
                 <div>
                  <span class="text-lg" style="color:#8B8B8B"
                    >{{ $t('financial.rq') }}:
                  </span>
                  <span class="text-lg pl-10">{{ item.created_at }}</span>
                 </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </el-card>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      active: 1,
      base: {},
      list: [],
      rule:{},
      extension_url:''
    }
  },
  created() {
    this.getData()
    this.userInfo()
    // this.getRule()
    this.getList()
  },
  methods: {
    change(index) {
      this.active = index
      this.getList()
    },
    getData() {
      try {
        const that = this
        that.$http
          .initDataToken(
            {
              url: 'user/advert?type=2'
            },
            false
          )
          .then((res) => {
            // console.log(res, 111)
            that.base = res
          })
      } catch (e) {
        console.log(e)
        //TODO handle the exception
      }
    },
    getRule(){
      try {
        const that = this
        that.$http
          .initDataToken(
            {
              url: 'user/comm_rule'
            },
            false
          )
          .then((res) => {
            this.rule = res
            console.log(res, 222)
          })
      } catch (e) {
        console.log(e)
        //TODO handle the exception
      }
    },
    getList() {
      this.$http
        .initDataToken(
          {
            url: 'user/advert',
            data: {
              type: 1,
              // level: this.active,
              limit: 100
            }
          },
          false
        )
        .then((res) => {
          console.log(res)
          this.list = res.data
        })
    },
    userInfo() {
      this.$http.initDataToken({ url: "user/info" }, false).then(res => {
        this.extension_url = `${window.location.origin}/#/register?extension_code=${res.invite_code}`;
      });
    },
    toPathPDF(){
			var lang = localStorage.getItem("lang") || 'en';
			window.open(`${this.$http._DOMAIN}/wp/gonggao_${lang}.pdf`);
		},
  }
}
</script>

<style lang="scss" scoped>
.type {
  color: #ffb115;
  border-bottom: 2px solid #ffb115 !important;
}

.sign-round{
  border: 2px solid gray;
  border-radius: 50%;
}

.is-sign{
  border-color: #ffb115 !important;
}
</style>
