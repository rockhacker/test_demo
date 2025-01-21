<template>
  <div class="minh100 ft16">
    <div class="mauto wt1200 ptb20">
      <el-card class="box-card mb20 f-item" style="border:0;">
        <el-breadcrumb separator="/">
          <el-breadcrumb-item :to="{ path: '/financial' }">{{
            $t('financial.financial')
          }}</el-breadcrumb-item>
          <el-breadcrumb-item>{{ $t('financial.rule') }}</el-breadcrumb-item>
        </el-breadcrumb>
      </el-card>

      <el-card class="box-card mb20 f-item white" style="border:0;">
        <div class="px-30">
          <div class="text-center mt-20"></div>
          <div class="mt-60 text-lg">
            {{ $t('financial.bz') }}
          </div>
          <div class="mt60 text-lg">
            {{ $t('financial.syjs') }}
          </div>
          <div class="mt30">
            <div class="text-lg">{{ $t('financial.sygz') }}</div>
            <div>
              <div class="text-lg">
                10000U x 0.5% = 50U
              </div>
              <!-- <div class="text-lg">
                {{ $t('financial.zd') }}: 10000U×0.3%=30U
              </div>
              <div class="text-lg">
                {{ $t('financial.zg') }}: 10000U×0.5%=50U
              </div> -->
              <div class="text-lg">
                {{ $t('financial.sysm') }}
              </div>
            </div>
          </div>
          <div class="mt60">
            <div class="text-lg">{{ $t('financial.gywyj') }}</div>
            <div class="mt30 text-lg">
              {{ $t('financial.wyjjs') }}
            </div>
            <div class="text-lg mt-30">{{ $t('financial.wyjjl') }}</div>
          </div>
        </div>
      </el-card>
    </div>
  </div>
</template>

<script>
export default {}
</script>

<style lang="scss" scope>
.el-breadcrumb__inner {
  color: white !important;
}
.el-breadcrumb__inner a:hover,
.el-breadcrumb__inner.is-link:hover {
  color: #fcd435e5;
}

.el-table__empty-block {
  background: #181a20;
}
</style>
