/**
 * 数据懒加载函数
 * @param {target} target 监听的目标元素，必须是DOM对象
 * @param {apiFn}   api函数,需要懒加载的请求
 * @returns
 */
export function useLazyData<T>(target: any, apiFn: any) {
    const result = ref<T>();
    const { stop } = useIntersectionObserver(
        target, // 监听的目标元素
        ([{ isIntersecting }]) => {
            // 是否进入可视区
            if (isIntersecting) {
                stop(); // 停止监听
                // 调用API函数获取数据
                apiFn().then((data: any) => {
                    result.value = data;
                });
            }
        },
        {
            threshold: 0,
        }
    );
    return result;
}
