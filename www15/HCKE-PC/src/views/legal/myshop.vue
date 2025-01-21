<template>
    <div>
        <div class="w80 mauto mt20 baselight">
        <router-view class="minvh80 mt5 posRelt"></router-view>
    </div>

        <footerComponet class="mt20"></footerComponet>
    </div>
</template>
<script>
import footerComponet from '@/components/footer'
export default {
    components:{footerComponet},
    data(){
        return {
           
        }
    }
}
</script>