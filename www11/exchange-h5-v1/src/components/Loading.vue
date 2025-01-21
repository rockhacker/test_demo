<template>
  <div>
    <van-loading vertical></van-loading>
    <div class="mask"></div>
  </div>
</template>
  

  
<style lang="scss" scoped>
.van-loading {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 10;
}

// 遮罩层
.mask {
  position: absolute;
  top: 0;
  width: 100%;
  height: 100%;
  z-index: 999;
}
</style>
  
  