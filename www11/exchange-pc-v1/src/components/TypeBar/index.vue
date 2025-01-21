<template>
    <div class="flex type-bar">
        <div v-for="(item, index) in list" :key="index"
            class="py-10 mr-20 cursor-pointer border-0 border-solid border-up"
            :class="[currentValue === item.value ? 'text-up border-b-2' : 'text-white']" @click="onClick(item.value)">
            {{ item.label }}
        </div>
    </div>
</template>

<script lang="ts" setup generic="T">
interface IList {
    label: string| any,
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
