<template>
    <div class="flex type-bar">
        <div class="mr-10 flex flex-col items-center" v-for="(item, index) in list" :key="index"
            :class="[currentValue === item.value ? 'text-#9FEF4E' : 'text-#888888']" @click="onClick(item.value)">
            <div>{{ $t(item.label) }}</div>
            <div class="w-30 h-4 rounded-8 mt-2" :class="[currentValue === item.value ? 'bg-#9FEF4E' : '']" />
        </div>
    </div>
</template>

<script lang="ts" setup generic="T">
interface IList {
    label: string,
    value: T
}
const props = defineProps<{
    modelValue: T,
    list: IList[]
}>()

const emits = defineEmits(["update:modelValue", "onChange"]);

const { modelValue: currentValue } = toRefs(props)

const onClick = (val: T) => {
    if (currentValue.value === val) {
        console.warn('value no change');
        return
    }

    emits('update:modelValue', val)
    emits("onChange");
};
</script>
