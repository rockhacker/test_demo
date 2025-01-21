<template>
    <div>
        <div class="w70 mauto baselight2 mt20 flex alcenter ft16 gray6 radius4">
            <span class="ptb10 plr20 posRelt pointer" :class="{'bgwhite text-main': active==0,'gray6': active==1}" @click="go(0)">
                {{$t('legal.trade')}}
                <div class="triangle-bottomleft-white abstort" :class="{'transformy180':active==1}" style="top:0;right:-43px;"></div>
            </span>
            <span class="ptb10 pointer posRelt pointer" style="margin-left:42px" :class="{'bgwhite text-main': active==1,'gray6':active==0}" @click="go(1)">
                {{$t('legal.order')}}
                <div class="triangle-bottomleft-white abstort" v-show="active==1" style="top:0;right:-43px;"></div>
            </span>
        </div>

        <!-- <div class="w70 mauto baselight2 mt20 bgpart ptb10 flex alcenter between ft16 plr20 app">
            <router-link :to="{name:'legal'}" class=" ptb10">交易大厅</router-link>
            <router-link :to="{name:'orders'}" class=" ptb10"></router-link>
        </div> -->

        <router-view class="w70 mauto baselight bgwhite minvh80 pb60 posRelt mb20"></router-view>

        <footerComponet></footerComponet>
    </div>
</template>
<script>
import footerComponet from '@/components/footer'
export default {
    components:{footerComponet},
    // name:'login',
    data(){
        return {
            active:0
        }
    },
    mounted(){
        // console.log(34534534);
        this.$getAnnouncement()
    },
    methods:{
        go(index){//查看订单
            if(index==this.active){
                return
            }

            this.active = index
            
            if(index==0){
                this.$router.push({path:'legal'})
            }else{
                this.$router.push({
                path: "orders",
                query: { id: this.$store.state.currency_id}
            });
            }
        },
    }
}
</script>

<style scoped>
.triangle-bottomleft-white {
    width: 0;
    height: 0;
    border-bottom: 43px solid white;
    border-right: 43px solid transparent;
}
.transformy180{
    transform:rotateY(180deg)
}
</style>