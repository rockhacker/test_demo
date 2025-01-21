<template>
  <view>
    <web-view :src="url"></web-view>
  </view>
</template>

<script>
import { mapState } from 'vuex';
export default {
    data(){
        return{
            url:""
        }
    },
    computed: {
			...mapState(['theme'])
		},
        onLoad(options){
        this.$utils.setThemeTop(this.theme)
        console.log(options.url);
        this.url = options.url
    }
}
</script>

<style>

</style>