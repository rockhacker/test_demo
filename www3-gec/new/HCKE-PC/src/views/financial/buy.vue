<template>
  <div class="minh100 ft16 bgblack">
    <div class="mauto wt1200 ptb20">
      <el-card class="ft18 mb20 f-item white" style="border:0;">
        <div class="bg-cover p-30">
          <div class="flex alcenter between">
            <!-- <span class="span-2xl mr-24"
              >{{ $t('financial.financial') }} {{ info.lock_dividend_days }}
              {{ $t('new.day') }}</span
            > -->
             <span class="span-2xl mr-24"
              >{{info.title}}</span
            >
            <div
              class="plr10 py-6 text-my-orange"
              style="background: rgba(255, 178, 22, .1);border-radius: 20px;"
            >
              {{ $t('financial.rsyl') }}{{ info.dividend_percentage }}%
            </div>
          </div>
          <div class="mt-50" style="color:#979797">
            <div>
              {{ $t('financial.dbxe') }}(USDT):
              <span class="pl-10 white"
                >{{ info.staring_sub_amount }}-{{ info.max_sub_amount }}</span
              >
            </div>
            <!-- <div class="mt-16">
              {{ $t('financial.gq') }}:
              <span class="pl-10 white">5</span>
            </div> -->
          </div>
        </div>
      </el-card>

      <el-card class="ft18 mb20 f-item white" style="border:0;">
        <div>
          <span class="text-lg" style="color:#CACACA"
            >{{ $t('financial.pxsj') }}:
          </span>
          <span class="pl-10 text-lg">{{ $t('financial.meitian') }}</span>
        </div>
        <div class="mt20">
          <span class="text-lg" style="color:#CACACA"
            >{{ $t('financial.tgje') }}:
          </span>
          <span class="pl-10 text-lg">{{ $t('financial.dqfh') }}</span>
        </div>
        <div class="mt20">
          <span class="text-lg" style="color:#CACACA"
            >{{ $t('financial.tqsh') }}:
          </span>
          <span class="pl-10 text-lg">{{ info.liquidated_damages }}%</span>
        </div>
        <div class="mt20">
          <span class="text-lg" style="color:#CACACA"
            >{{ $t('financial.yjsy') }}:
          </span>
          <span class="pl-10 text-lg"
            >{{ info.min_profit }}~{{ info.max_profit }}</span
          >
        </div>
      </el-card>

      <el-card class="ft18 mb20 f-item white" style="border:0;">
        <div class="text-2xl">{{ $t('financial.tgje') }}</div>
        <div
          class="flex ptb20"
          style="border:0 solid rgba(255, 255, 255, 0.2);border-bottom-width: 1rpx;"
        >
          <input
            class="flex1 text-lg pr10 white"
            v-model="amount"
            type="number"
            :placeholder="$t('financial.qsrtgje')"
          />
          <div class="text-lg">USDT</div>
        </div>
        <div class="flex between mt20">
          <div class="flex between flex1 pr16">
            <div style="color: #FEFEFE;">{{ $t('financial.kyzc') }}(USDT)</div>
            <div style="color: #FEFEFE;">{{ balance }} USDT</div>
          </div>
          <div
            class="text-my-orange pl10"
            style="border:0 solid rgba(255, 255, 255, 0.2);border-left-width:1rpx;"
            @click="amount = balance"
          >
            {{ $t('trade.all') }}
          </div>
        </div>

        <div
          @click="buy"
          class="tc mx-auto mt60 bg-my-orange"
          style="height: 40px;line-height: 40px;border-radius: 40px;"
        >
          {{ $t('legal.buy') }}
        </div>
      </el-card>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      amount: '',
      info: {},
      balance: '',
      id: ''
    }
  },
  created() {
    this.id = this.$route.query.id
    this.getData()
    this.getBalance()
  },
  methods: {
    getData() {
      this.$http
        .initDataToken({ url: 'matter/info', data: { id: this.id } }, false)
        .then((res) => {
          this.info = res
          console.log(res, 33)
        })
    },
    getBalance() {
      this.$http.initDataToken({ url: 'account/list' }, false).then((res) => {
        console.log(res, 44)
        this.balance = res[0].accounts[0].balance
      })
    },
    buy() {
      let that = this
      if (!that.amount) {
        this.$message(that.$t('financial.qsrtgje'))
        return false
      }
      this.$http
        .initDataToken(
          {
            url: 'matter/buy',
            data: {
              id: this.id,
              amount: this.amount
            }
          },
          false
        )
        .then((res, msg) => {
          // that.$utils.showLayer(msg)
        this.$message.success(this.$t('feed.ok'))
        this.$router.push('/financialWdtg')
          this.amount = ''
          console.log(res, 55)
        })
    }
  }
}
</script>

<style></style>
