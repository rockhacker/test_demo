import { sendEmail } from "@/api/public"
import useI18n from "./useI18n"
import { showFailToast, showSuccessToast } from "vant"

export default () => {
    const [loading, setLoading] = useToggle(false) // 短信是否发送中
    const [disable, setDisable] = useToggle(false) // 是否禁止点击

    let timer: string | number | NodeJS.Timeout | undefined
    let count = ref(60)

    const t = useI18n()

    const label = computed(() => {
        if (disable.value) {
            return `${count.value}s`
        }
        const instance = getCurrentInstance();
        return t('public.send')
    })

    const sendCode = (to: string) => {
        if (!to) {
            return showFailToast(t('account.input_email'));
        }

        if (loading.value || disable.value) return
        setLoading(true)

        sendEmail({ to, type: 1 }).then(res => {
            showSuccessToast(res.msg!)

            setDisable(true)
            // 倒计时初始化
            count.value = 60
            timer = setInterval(() => {

                if (count.value - 1 === 0) {
                    setDisable(false)
                    clearInterval(timer)
                    return
                }

                count.value = count.value - 1
            }, 1000)

        }).finally(() => {
            setLoading(false)
        })

    }

    return {
        loading,
        setLoading,
        sendCode,
        disable,
        label
    }
}

