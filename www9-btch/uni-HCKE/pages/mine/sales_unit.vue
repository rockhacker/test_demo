<template>
	<view :class="theme">
		<view class="flex items-center between p-30 bdbf5 bgPart" v-for="(item,index) in list" :key="index" @click="setItem(item)">
            <view class="ft16">{{ item }}</view>
            <img v-if="currency_unit == item" class="w-40 h-40" src="../../static/image/g.png" alt="">
        </view>
	</view>
</template>

<script>
	import {mapState} from 'vuex'
	export default{
		data(){
			return {
				list:[],
                currency_unit:''
			}
		},
		onLoad() {
			uni.setNavigationBarTitle({
				title:this.$t('add').jjdw
			})
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
		    this.$utils.setThemeTop(this.theme)
            this.getAssets()
            this.getUserInfo()
		},
        methods:{
            getAssets() {
                this.$utils.initDataToken({url:'user/getCurrencyList'},res=>{
                    this.list = res
                })
            },
            getUserInfo() {
				this.$utils.initDataToken({ url: 'user/info', data: {}, type: 'get' }, (res, msg) => {
					this.currency_unit = res.currency_unit
                })
			},
            setItem(currency_unit){
                this.$utils.initDataToken({url:'user/saveCurrencyUnit',type:'POST',data:{currency_unit}},res=>{
                   this.getUserInfo()
                })
            }
        }
	}
</script>

<style>
</style>
