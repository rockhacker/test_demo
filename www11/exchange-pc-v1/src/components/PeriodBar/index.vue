<template>
    <div class="flex py-10">
        <span v-for="item in Object.keys(Period)" :key="item" class="cursor-pointer py-6 w-80 text-center text-12 rounded-4 text-black"
            :class="{ 'bg-[#E8F1FA]': select === Period[item] }" @click="handleClick(item)">
            {{ item }}
        </span>
    </div>
</template>
  
<script lang="ts" setup>
import { Period } from "@/hooks/useKLine";

const props = defineProps({
    modelValue: {
        type: String,
        default: Period["1M"],
    },
});

const select = ref(props.modelValue);

const emits = defineEmits(["update:modelValue", "onChange"]);

const handleClick = (key: string) => {
    select.value = Period[key];
    emits("update:modelValue", select.value);
    emits("onChange", select.value);
};
</script>
  