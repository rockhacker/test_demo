<template xlang="wxml">
	<view :class="theme" class="h-full">
		<view class="bg-white dark:bg-1C2532 flex flex-col items-center justify-center h-full" >
			<!-- <image :src="codeImg" class="wt160 h160"></image> -->
			<view class="p-10 bg-white">
				<tki-qrcode
				ref="qrcode"
				:val="val"
				:size="size"
				:unit="unit"
				:background="background"
				:foreground="foreground"
				:pdground="pdground"
				:icon="icon"
				:iconSize="iconsize"
				:lv="lv" 
				:onval="onval"
				:loadMake="loadMake"
				@result="qrR" />
			</view>
			<view class="w-full p-40">
				<view class="bg-gray-100 dark:bg-333F4A rounded-xl flex justify-between items-center p-30 box-border">
					<input type="text" :value="val" class="flex-1 text-black dark:text-white" disabled/>
					<view class="text-clip-green px-20" @click="copyText(val,$t('assets.copy_success'))">{{$t('feed.copyadd')}}</view>
				</view>
			</view>
			<view class="p-20 mb-40 text-center text-lg mt-80 border-2 border-solid border-E5E5E5"><text class="dark:text-999FAA">{{$t('bind.codes')}}：</text>{{code}}</view>
			<view class="text-center text-lg text-838B99 dark:text-999FAA">{{$t('bind.tip')}}</view>
		</view>
	</view>
	
</template>

<script>
	import QR from '../../common/wxqrcode.js'
	import {domain} from '@/common/domain.js'
	import tkiQrcode from "@/components/tki-qrcode.vue"
	import {mapState} from 'vuex'
	export default{
		components: {tkiQrcode},
		data() {
			return {
				code:'',
				codeImg:'',
				val:'',
				size: 300, // 二维码大小
				unit: 'upx', // 单位
				background: '#000000', // 背景色
				foreground: '#ffffff', // 前景色
				pdground: '#ffffff', // 角标色
				icon: '', // 二维码图标
				iconsize: 40, // 二维码图标大小
				lv: 3, // 二维码容错级别 ， 一般不用设置，默认就行
				onval: false, // val值变化时自动重新生成二维码
				loadMake: true, // 组件加载完成后自动生成二维码
			}
		},
		onLoad(option) {
			this.code = option.code;
				uni.setNavigationBarTitle({
				title:this.$t('bind').tuiguang
			})
		},
		computed:{
		   ...mapState(['theme']),
		},
		onShow() {
			this.$utils.setThemeTop(this.theme)
			// this.code = option.code;
			// var url=domain+'/mobile/register.html?code=' + this.code;
			// this.codeImg = QR.createQrCodeImg(url)
			// console.log(domain);
			var url= `${window.location.origin}/h5/#/pages/mine/register?invite_code=${this.code}`;
			this.val = url;
		},
		methods: {
			qrR(res) {
				// console.log(res)
			},
			/**
			 * copyText
			 * @param value 
			 * @param title 
			 * @param icon 
			 */
			copyText(value, title, icon = 'none') {
				// uni.setClipboardData({
				// 	data: value,
				// 	success: () => {
				
				// 	}
				// });
				 let textarea = document.createElement("textarea")
				 textarea.value = value
				 textarea.readOnly = "readOnly"
				 document.body.appendChild(textarea)
				 textarea.select() // 选择对象
				 textarea.setSelectionRange(0, value.length) //核心
				 let result = document.execCommand("copy") // 执行浏览器复制命令
				 textarea.remove()
				 		uni.showToast({
							icon,
							title
						})
			},
		},
	}
</script>
