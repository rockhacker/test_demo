<template>
    <div :id="props.id"></div>
</template>
  
<script lang="ts" setup>
import { KLineData } from "klinecharts";
import useAreaChart from "@/hooks/useAreaChart";
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
let AreaChart;

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
                    lineColor: "#f84f4f",
                    backgroundColor: [
                        {
                            offset: 0,
                            color: "rgba(248, 79, 79, 0.01)",
                        },
                        {
                            offset: 1,
                            color: "rgba(248, 79, 79, 0.2)",
                        },
                    ],
                },
            },
        });
    }
    // 为图表添加数据
    AreaChart.applyNewData(data, true);
    if (props.width && data.length > 10) {
        AreaChart.scrollByDistance(props.width / 2 + 10, 100);
    }
});
</script>
  