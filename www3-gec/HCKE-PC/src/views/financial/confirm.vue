<template>
  <div class="minh100 ft16 bgblack">
    <div class="mauto wt1200 ptb20">
      <el-card class="ft18 mb20 f-item white" style="border:0;">
        <div class="p-30 rounded-xl flex between">
          <div class="text-lg" style="color:#CACACA">
            {{ $t('financial.sdje') }}(USDT):
          </div>
          <div class="text-lg ml-20">800</div>
        </div>

        <div class="p-30 rounded-xl mt10">
          <div class="flex between">
            <div class="text-lg" style="color:#CACACA">
              {{ $t('financial.yqsy') }}
            </div>
            <div class="text-lg ml-20">12.0~12.0</div>
          </div>
          <div class="flex mt-10 between">
            <div class="text-lg" style="color:#CACACA">
              {{ $t('financial.tgsj') }}
            </div>
            <div class="text-lg ml-20">5天</div>
          </div>
          <div class="flex mt-10 between">
            <div class="text-lg" style="color:#CACACA">
              {{ $t('financial.rsy') }}
            </div>
            <div class="text-lg ml-20">0.3~0.3%</div>
          </div>
        </div>

        <div class="p-30 rounded-xl mt10">
          <div
            class="flex between pb-20"
            style="border:0 solid rgba(255, 255, 255, 0.2);border-bottom-width: 1rpx;"
          >
            <div class="text-lg" style="color:#CACACA">
              {{ $t('financial.qxsj') }}
            </div>
            <div class="text-lg ml-20">2022-04-10</div>
          </div>
          <div class="flex between mt-20">
            <div class="text-lg" style="color:#CACACA">
              {{ $t('financial.dqsj') }}
            </div>
            <div class="text-lg ml-20">2022-04-15</div>
          </div>
        </div>

        <div class="p-30 rounded-xl mt10">
          <div
            class="flex between pb-20"
            style="border:0 solid rgba(255, 255, 255, 0.2);border-bottom-width: 1rpx;"
          >
            <div class="text-lg" style="color:#CACACA">
              {{ $t('financial.ddbh') }}
            </div>
            <div class="text-lg ml-20">22042542021520125896</div>
          </div>
          <div class="flex between mt-20">
            <div class="text-lg" style="color:#CACACA">
              {{ $t('financial.ddsj') }}
            </div>
            <div class="text-lg ml-20">2022-04-10 14:45:20</div>
          </div>
        </div>

        <div
          class="tc mx-auto mt60"
          style="height: 40px;line-height: 40px;border-radius: 40px;background: linear-gradient(90deg, #FFB216, #FF9D12);"
        >
          {{ $t('financial.qrgm') }}
        </div>

        <div class="tc mt10" style="color:#CACACA">
          {{ $t('trade.cancel') }}
        </div>
      </el-card>
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style></style>
