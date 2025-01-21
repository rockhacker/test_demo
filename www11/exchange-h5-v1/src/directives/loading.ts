import LoadingComponent from '@/components/Loading.vue'
import { createApp } from 'vue'
import { Loading } from 'vant'
import type { Directive } from 'vue'


const className = 'loading-relative' // loading-relative 是我在全局写的样式名 {position:relative}

const removeClass = (el: HTMLElement, className: string) => {
    el.classList.remove(className)
}

function add(el: any) {
    const style = getComputedStyle(el)
    if (['absolute', 'relative', 'fixed'].indexOf(style.position) === -1) {
        el.classList.add(className) // 通过此API可以添加类名
    }
    //向el节点插入动态创建的 div 节点 ， 内容就是我们的 loading 组件
    el.appendChild(el.instance.$el)
}

function remove(el: any) {
    removeClass(el, className);
    //移除动态创建的 div 节点
    el.removeChild(el.instance.$el)
}

const loading: Directive = {
    mounted(el: any, binding) {
        // 创建app对象 根组件为我们写好的 loading 组件
        const loading = createApp(LoadingComponent)
        //引入vant组件
        loading.component(Loading.name, Loading)
        //动态创建一个div节点，将app挂载在div上
        const instance = loading.mount(document.createElement('div'))
        // 因为在updated也需要用到 instance 所以将 instance 添加在el上 ，在updated中通过el.instance 可访问到
        el.instance = instance
        // v-loading传过来的值储存在 binding.value 中
        if (binding.value) {
            // el.instance.setLoading(binding.value) //setLoading是LoadingComponent组件的方法,用回调传参
            add(el)
        }
    },

    updated(el, binding) {
        if (binding.oldValue === binding.value) {
            return
        }
        // 如果value的值有改变，那么我们去判断进行操作
        binding.value ? add(el) : remove(el)
    }
}


export default loading

