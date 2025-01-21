<template>
    <div class="w80  flex minh350 mt50 mauto baselight  ">
        <div class="w20  tc ft16 assets bdr bgwhite dark-bg-1C2532">
            <router-link  :to="{name:item.page}" class=" ptb20  block basecolor"  v-for="(item,i) in listLeft" :key="i">{{item.name}}</router-link>
        </div>
        <router-view class="flex1 bgwhite dark-bg-1C2532 ml10 minvh70"></router-view>
    </div>
</template>
<script>
export default {
    data(){
        return{
            listLeft:[
                {
                    name:this.$t('assets.tradeacc'),
                    page:'tradeAccount'
                },
                // {
                //     name:this.$t('assets.legalcurrencyacc'),
                //     page:'legalAccount'
                // },
                {
                    name:this.$t('assets.leveracc'),
                    page:'leverAccount'
                },
                // {
                //     name:this.$t('assets.isoacc'),
                //     page:'isoleverAccount'
                // },
                {
                    name:this.$t('assets.jiaoacc'),
                    page:'secondAccount'
                }, 
				// {
                //     name:this.$t('assets.subscriptionRunning'),
                //     page:'subscriptionRunning'
                // },
                // {
                //     name:this.$t('assets.optionacc'),
                //     page:'optionAccount'
                // },
                {
                    name:this.$t('assets.transfer'),
                    page:'transfer'
                },
			    {
					name:this.$t('new.duih'),
					page:'exchange'
				},
                {
                    name:this.$t('bind.bindAddr'),
                    page:'bindAddr'
                },
                {
                    name:this.$t('header.mentionRecord'),
                    page:'mentionRecords'
                },
            
            ],
            curpage:'tradeAccount'
        }
    },
   created(){

   },
    methods:{
        changepage(e){
            // this.curpage=e;
             
        }
    }
}
</script>
<style lang="">
    .assets .router-link-exact-active{
       background: #0066FC !important;
        color: white !important;
    }
</style>
