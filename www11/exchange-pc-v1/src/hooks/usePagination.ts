import { ref, onMounted, onUnmounted } from 'vue'

export const usePagination = <T = any>(getData: (currentPage: number) => Promise<T>) => {
    const currentPage = ref(0)
    const loading = ref(false)
    // 判断触底
    const scrollBottom = () => {
        if (loading.value) return
        let scrollTop = document.documentElement.scrollTop || document.body.scrollTop

        // 变量 windowHeight 是可视区的高度
        let windowHeight =
            document.documentElement.clientHeight || document.body.clientHeight
        // 变量 scrollHeight 是滚动条的总高度
        let scrollHeight =
            document.documentElement.scrollHeight || document.body.scrollHeight

        if (scrollTop + windowHeight >= scrollHeight) {
            loading.value = true
            currentPage.value++
            getData(currentPage.value).finally(() => {
                loading.value = false
            })
        }
    }


    onMounted(() => {
        window.addEventListener('scroll', scrollBottom)
        currentPage.value++
        getData(currentPage.value).finally(() => {
            loading.value = false
        })
    })

    onUnmounted(() => {
        console.log('事件已移除');
        window.removeEventListener('scroll', scrollBottom)
    })

    return {
        currentPage
    }
}
