<template>
    <view class="charts-box">
      <qiun-data-charts 
        type="gauge"
        :opts="opts"
        :chartData="chartData"
      />
    </view>
  </template>
  
  <script>
  export default {
    props:['remain_milli_seconds','info'],
    watch:{
      remain_milli_seconds(val){
        console.log(val)
        let n = val/this.info.seconds
        this.getServerData(n)
        this.opts.title.name =  val
      },
      info(val){
           console.log(val)
      }
    },
    data() {
      return {
        chartData: {
        },
        //您可以通过修改 config-ucharts.js 文件中下标为 ['gauge'] 的节点来配置全局默认参数，如都是默认参数，此处可以不传 opts 。实际应用过程中 opts 只需传入与全局默认参数中不一致的【某一个属性】即可实现同类型的图表显示不同的样式，达到页面简洁的需求。
        opts: {
          loadingType:0,
          duration:0,
          timing:'linear',
          animation:false,
          update:true,
          color: ["#1890FF","#91CB74","#FAC858","#EE6666","#73C0DE","#3CA272","#FC8452","#9A60B4","#ea7ccc"],
          padding: undefined,
          title: {
            name: '',//this.remain_milli_seconds,//info.seconds,
            fontSize: 25,
            color: "#1890FF",
            offsetY: 0
          },
          subtitle: {
            name: "",
            fontSize: 15,
            color: "#1890ff",
            offsetY: 0
          },
          extra: {
            gauge: {
              type: "progress",
              width: 20,
              labelColor: "#666666",
              startAngle: 0.75,
              endAngle: 0.25,
              startNumber: 1,
              endNumber: 100,
              labelFormat: "",
              splitLine: {
                fixRadius: -10,
                splitNumber: 10,
                width: 15,
                color: "#FFFFFF",
                childNumber: 5,
                childWidth: 12
              },
              pointer: {
                width: 24,
                color: "auto"
              }
            }
          }
        }
      };
    },
    created() {
          let s = this.remain_milli_seconds
          let n  = s / this.info.seconds
          this.getServerData(n);
          this.opts.title.name =  s
    },
    methods: {
      getServerData(n) {
          let res = {
              categories: [],
              series: [
                {
                  name: n,
                  data: n,
                }
              ]
            };
          this.chartData = JSON.parse(JSON.stringify(res));
      },
    }
  };
  </script>
  
  <style scoped>
    /* 请根据实际需求修改父元素尺寸，组件自动识别宽高 */
    .charts-box {
      width: 80%;
      height: 80%;
    }
  </style>