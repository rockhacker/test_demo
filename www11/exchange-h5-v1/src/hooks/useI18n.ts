export default () => {
    const { appContext: { config: { globalProperties } } } = getCurrentInstance()!;

    return globalProperties.$t
}