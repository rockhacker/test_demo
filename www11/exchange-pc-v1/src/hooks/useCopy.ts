
import { useClipboard } from '@vueuse/core'
import { notification } from "ant-design-vue";
import { useI18n } from 'vue-i18n'

const useCopy = () => {
    //copy是复制的函数  copied 是boolean值 是否已复制完成  isSupported 检查浏览器是否支持
    const { copy, copied, isSupported } = useClipboard()

    const { t } = useI18n()

    const onCopy = (val: string) => {
        // 检查浏览器是否 支持复制 不支持提示用户
        if (!isSupported.value) return notification.warn({ message: t('public.copy_fail') })

        copy(val)
    }
    // 监听copied，成功则提示用户
    watch(copied, () => {
        if (copied.value) notification.success({ message: t('public.copy_success') })
    })

    return {
        onCopy
    }
}

export default useCopy