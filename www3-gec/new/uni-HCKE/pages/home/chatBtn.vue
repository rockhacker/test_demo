<template>
	<view>
			<view style="margin:0 auto;" class="mt-100 w80 h-80 flex justify-center items-center text-center bg-my-orange text-white text-xl rounded-10" @tap="confirm(1)">{{ $t("new.ywkf") }}</view>
		    <view style="margin:0 auto;" class="mt-50 w80 h-80 flex justify-center items-center text-center bg-my-orange text-white text-xl rounded-10" @tap="confirm(2)">{{ $t("new.ynykf") }}</view>
	</view>
</template>
<script>
	import { mapState } from 'vuex';
	export default{
		data(){
			return {
			}
		},
		computed: {
			...mapState(['theme'])
		},
		onLoad(e) {
			this.$utils.setThemeTop(this.theme)
		},
		methods:{
			confirm(n){
                uni.navigateTo({
				    url: '/pages/home/chat?n='+n,
				});
			},
		}
	}
</script>
