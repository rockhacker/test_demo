<template>
    <div class="flex justify-between py-10">
        <div v-for="item in Object.keys(Period)" :key="item" class="py-2 w-48 text-center text-12 rounded-16" :class="[
            select === Period[item]
                ? 'bg-[#6C7166] text-main'
                : 'text-[#888]',
        ]" @click="handleClick(item)">
            <div class="scale-90">{{ item }}</div>
        </div>
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
  