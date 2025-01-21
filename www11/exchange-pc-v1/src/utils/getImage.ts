export function getImageUrl(name: string) {
    return new URL(`../assets/images/${name}`, import.meta.url).href;
}

export function getTabBarImage(name: string) {
    return new URL(`../assets/tabbar/${name}`, import.meta.url).href;
}

export default {
    getImageUrl,
    getTabBarImage
}