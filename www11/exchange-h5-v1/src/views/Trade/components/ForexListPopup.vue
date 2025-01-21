<template>
    <van-popup v-model:show="show" position="left" class="h-full w-70%">
        <div v-for="item in tradeList" :key="item.Id">
            <div class="flex items-center justify-between px-12 py-16"
                :class="{ 'bg-#4a4a4a': item === getCurrentTradeItem }" @click="handleClick(item.Id)">
                <div>{{ item.Code }}</div>
                <div class="flex items-center justify-center scale-90">
                    <span :class="[item.ForexQuotations.Change >= 0 ? 'text-up' : 'text-down']">
                        {{ item.ForexQuotations.Close }}
                    </span>
                    <!-- <img v-if="item.ForexQuotations.Change >= 0" class="w-16 h-16" src="@images/up.png">
                    <img v-else class="w-16 h-16" src="@images/down.png"> -->
                </div>
            </div>
            <van-divider />
        </div>
    </van-popup>
</template>
  
<script lang="ts" setup>
import { useForexStore } from "@/store";
const props = defineProps({
    modelValue: Boolean,
});

const { tradeList, getCurrentTradeItem } = storeToRefs(useForexStore());
const { setCurrentTradeItem } = useForexStore();

const emits = defineEmits(["update:modelValue", "onChange"]);

const show = useVModel(props, "modelValue", emits);

const handleClick = (Id: number) => {
    setCurrentTradeItem(Id);
    show.value = false;
    emits("onChange", Id);
};
</script>
  