<template xlang="wxml">
	<view :class="theme" class="h-full">
		<view class="dark:bg-floor min-h-full px-40" >
			<!-- <image :src="codeImg" class="wt160 h160"></image> -->
			<view class="p-40 my-bg rounded-xl w-full mt-20 flex flex-col items-center">
				<tki-qrcode
				v-if="code"
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
				<view class="text-center text-white text-lg mt-20">{{$t('bind.tip')}}</view>
			</view>
			<view class="mt-30 rounded-xl" style="background:#282842">
				<view class=" flex flex-col justify-between items-center p-30 box-border text-primary">
					<view class="text-center pt-20 text-white">
						{{val}}
					</view>
					<view style="background: linear-gradient(94deg,#42cbff,#015afe);" class="mt-20  text-white rounded-3xl py-20 w-400 text-center text-lg" @click="copyText(val,$t('assets.copy_success'))">{{$t('feed.copyadd')}}</view>
				</view>
			</view>
			<view class="mt-30 rounded-xl flex px-20 py-40 text-white" style="background:#282842">
			 	<text class="pr-10">{{$t('new.fybl')}}:</text>  {{$t('new.yj')}}/{{set_comm[1]}}%, {{$t('new.ej')}}/{{set_comm[2]}}%, {{$t('new.sj')}}/{{set_comm[3]}}%
			</view>
			<view class="mt-30 rounded-xl flex py-40 text-white" style="background:#282842">
				<view class="flex1">
					<view class="text-center">{{$t('new.yqrssl')}}</view>
					<view class="text-center mt-30 text-xl">{{child_count}}</view>
				</view>
				<view class="flex1">
					<view class="text-center">{{$t('new.zhjlsl')}}(USDT)</view>
					<view class="text-center mt-30 text-xl">{{commission_folded_total}}</view>
				</view>
			</view>
			<view class="mt-30 rounded-xl p-20 text-white" style="background:#282842">
				<view class="flex w-full">
					<view class="flex-1 text-center">{{$t('new.khyx')}}</view>
					<view class="flex-1 text-center">{{$t('new.jl')}}</view>
					<!-- <view class="flex-1 text-right">{{$t('trade.time')}}</view> -->
				</view>
				<view class="flex w-full mt-20" v-for="(item,index) in commission_list" :key="index">
					<view class="flex-1 text-center">{{item.get_user_info.email}}</view>
					<view class="flex-1 text-center">{{item.amount}}</view>
					<!-- <view class="flex-1 text-right">{{item.created_at}}</view> -->
				</view>
			</view>

			<!-- <view class="bg-mask mt-20">
				<view class="py-20 text-center text-lg mt-80">{{$t('bind.codes')}}</view>
				<view class="text-center text-2xl text-warn">{{code}}</view>
				<view class="flex">
					<button class="mt-20  text-white rounded-10 bg-warn py-20 px-40" @click="copyText(val,$t('assets.copy_success'))">{{$t('feed.copyadd')}}</button>
					<button class="mt-20  text-white rounded-10 bg-warn py-20 px-40" @click="copyText(val,$t('assets.copy_success'))">{{$t('feed.copyadd')}}</button>
				</view>
				<view class="text-center text-lg">{{$t('bind.tip')}}</view>

			</view> -->
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
				child_count:null,
				commission_folded_total:null,
				commission_list:[],
				page:1,
				hasMore:true,
				loading:false,
				set_comm:{}
			}
		},
		onLoad(option) {
			this.code = option.code;
				uni.setNavigationBarTitle({
				title:this.$t('new.wdtg')
			})
			if(!this.code){
				this.getUserInfo()
			}else{
				this.val= `${window.location.origin}/h5/#/pages/mine/register?invite_code=${this.code}`;
			}
			this.getInfo()
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
			// var url= `${window.location.origin}/h5/#/pages/mine/register?invite_code=${this.code}`;
			// this.val = url;
		},
		onReachBottom() {
			if (!this.hasMore || this.loading){
				return;
			} 
			this.page++;
			this.getInfo();
		},
		methods: {
			//获取用户信息
			getUserInfo() {
				var that = this;
				this.$utils.initDataToken({ url: 'user/info', data: {}, type: 'get' }, (res, msg) => {
					console.log(res,222);
					this.code  = res.invite_code
					console.log(this.code);
					this.val= `${window.location.origin}/h5/#/pages/mine/register?invite_code=${this.code}`
				});
			},
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
				// 		uni.showToast({
				// 			icon,
				// 			title
				// 		})
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
			getInfo(){
				if(this.loading) return
				this.loading = true
				this.$utils.initDataToken(
				{
					url: 'user/getCommissionList',
					type: 'get',
					data: {
						page:this.page
					}
				},
				res => {
					this.commission_folded_total = res.total_commission
					this.child_count = res.people
					this.set_comm = res.set_comm
					if(this.page==1){
						this.commission_list = res.list.data
					}else{
						this.commission_list =  this.commission_list.concat(res.list.data)
					}
					this.loading = false
					this.hasMore = this.commission_list.length < res.list.total
				}
			);
			}

		},
	}
</script>

<style scoped>
.my-bg{
	/* background-image: url(/static/image/bg-new.png); */
	background-image: linear-gradient(to right ,#ef7f77,#863cf1);
}
</style>
