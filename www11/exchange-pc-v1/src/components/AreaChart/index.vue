<template>
  <div class="w-full" :id="props.id"></div>
</template>

<script lang="ts" setup>
import { KLineData, Chart } from "klinecharts";
import useAreaChart from "./hook/AreaChart";
import { TIMEZONE } from "@/common";
const props = defineProps({
  id: {
    type: String,
    require: true,
    default: "chart",
  },
  pricePrecision: {
    type: Number,
    default: 2,
  },
  volumePrecision: {
    type: Number,
    default: 2,
  },
  data: {
    type: Object as PropType<KLineData[]>,
    require: true,
    default: [],
  },
  width: {
    type: Number,
  },
  isDown: {
    type: Boolean,
  },
});

const { data, pricePrecision, volumePrecision } = props;
let AreaChart: Chart;

const updateData = (klineData: KLineData) => {
  AreaChart?.updateData(klineData);
};

const applyNewData = (data: KLineData[]) => {
  // 为图表添加数据
  AreaChart.applyNewData(data);
}

const setPriceVolumePrecision = (
  pricePrecision: number,
  volumePrecision: number = 2
) => {
  // 设置精度
  AreaChart.setPriceVolumePrecision(pricePrecision, volumePrecision);
};

onMounted(() => {
  const length = props.data.length;
  if (!length) {
    return;
  }
  AreaChart = useAreaChart(props.id);
  // 设置精度
  AreaChart?.setPriceVolumePrecision(pricePrecision, volumePrecision);
  if (props.isDown) {
    AreaChart.setStyles({
      candle: {
        area: {
          lineColor: "#F23C48",
          backgroundColor: [
            {
              offset: 0,
              color: "rgba(242, 60, 72, 0.01)",
            },
            {
              offset: 1,
              color: "rgba(242, 60, 72, 0.2)",
            },
          ],
        },
      },
    });
  }
  // 为图表添加数据
  AreaChart.applyNewData(data, true);
  AreaChart?.setTimezone(TIMEZONE);
  // if (props.width && data.length > 10) {
  //   AreaChart.scrollByDistance(props.width / 2 + 10, 100);
  // }
});

const resize = () => {
  nextTick(() => {
    AreaChart.resize();
  })
};

defineExpose({
  resize,
  applyNewData,
  setPriceVolumePrecision,
  updateData
});
</script>
