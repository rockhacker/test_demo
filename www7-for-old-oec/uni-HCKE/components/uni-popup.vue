<template>
	<view v-if="show">
		<view class="uni-mask" @click="hide"></view>
		<view :class="type == 'middle' ? 'flex justify-center items-center contents' : ''">
			<view :class="['uni-popup', { 'bg-white': bgColor, 'bg-floor': !bgColor }, 'uni-popup-' + type]">
				<view class="w-full text-center relative text-xl text-black h-100 flex justify-center items-center border-0 border-b-2 border-gray-200 border-solid">
					{{ msg }}
					<view class="absolute right-0 p-10" @tap="hide">
						<uni-icons type="closeempty" size="30" ></uni-icons>
					</view>
				</view>
				<slot></slot>
				<view v-if="btnShow" class="uni-popup-bottoms">
					<view class="uni-popup-bottom1 flex justify-center items-center">
						<view class="cannel flex-1" @tap="hide">{{transwords[lang].cancel}}</view>
						<view class="comfirms flex-1" @tap="comfirms">{{transwords[lang].confrim}}</view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
export default {
	props: {
		show: {
			type: Boolean,
			default: false
		},
		type: {
			type: String,
			//top - 顶部， middle - 居中, bottom - 底部
			default: 'middle'
		},
		msg: {
			type: String,
			default: ''
		},
		btnShow: {
			type: Boolean,
			default: true
		},
		bgColor: {
			type: Boolean,
			default: true
		},
		lang:{
			type: String,
			default: 'hk'
		}
	},
	data() {
		return {
			transwords: {
				zh: {
					cancel: '取消',
					confrim: '确定',
				},
				en: {
					cancel: 'Cancel',
					confrim: 'Confirm',
				},
				hk: {
					cancel: '取消',
					confrim: '確定',
				},
				jp: {
					cancel: 'キャンセル',
					confrim: 'を選択します',
				},
				it: {
					cancel: 'Annulla',
					confrim: 'determinare',
				},
				de: {
					cancel: 'stornieren',
					confrim: 'bestimmen',
				},
				fr: {
					cancel: 'Annuler',
					confrim: 'déterminer',
				},
				vn: {
					cancel: 'hủy bỏ',
					confrim: 'mục đích',
				},
				th: {
					cancel: 'ยกเลิก',
					confrim: 'กำหนด',
				},
				ar: {
					cancel: 'إلغاء',
					confrim: 'تحديد',
				},
			},
			translatedInfo: {
				cancel: 'Cancel',
				confrim: 'Confirm',
			},
		};
	},
	created() {
		var that=this;
		//#ifdef APP-PLUS
		that.lang = plus.storage.getItem('lang') ||'hk' ;
		//#endif
		// #ifdef H5
		that.lang= uni.getStorageSync('lang')||'hk'
		// #endif
		// that.lang = localStorage.getItem('lang') || 'zh';
		console.log(that.lang);
		
	},
	mounted() {
		console.log(uni.getStorageSync('lang'));
		//#ifdef APP-PLUS
		this.lang = plus.storage.getItem('lang') ||'hk' ;
		//#endif
		// #ifdef H5
		this.lang= uni.getStorageSync('lang')||'hk';
		// #endif
		this.translatedInfo = this.transwords[this.lang];
	},
	methods: {
		hide: function() {
			this.$emit('hidePopup');
		},
		comfirms: function() {
			this.$emit('comfirmPopup');
		},
		moveHandle() {}
	}
};
</script>
<style>
	.contents{
		width: 100.0vw;
		height: 100.0vh;
		overflow: hidden;
		position: fixed;
		left: 0;
		top: 0;
		bottom: 0;
		z-index: 997;
	}
.uni-mask {
	position: fixed;
	z-index: 996;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background-color: rgba(0, 0, 0, 0.6);
	height: 100vh;
	overflow: hidden;
}

.uni-popup {
	position: absolute;
	z-index:997;
	color: #333;
	box-shadow: 0 0 30upx rgba(0, 0, 0, 0.1);
}

.uni-popup-middle {
	display: flex;
	flex-direction: column;
	align-items: center;
	width: 86%;
	border-radius: 10upx;
	/* justify-content: center; */
	top: 50vh;
	left: 50vw;
	transform: translate(-50%, -50%);
}

.uni-popup-top {
	top: 0;
	left: 0;
	width: 100%;
	height: 100upx;
	line-height: 100upx;
	text-align: center;
}
.uni-popup-bottom {
	left: 0;
	bottom: -50px;
	width: 100%;
	min-height: 100upx;
	line-height: 100upx;
	text-align: center;
}
.uni-popup-bottoms {
	left: 0;
	bottom: 0;
	width: 100%;
	height: 80upx;
	line-height: 80upx;
	
}
.uni-popup-bottom1 {
	left: 0;
	bottom: 0;
	width: 100%;
	height: 80upx;
	line-height: 80upx;
	text-align: center;
	/* margin-top:30upx; */
	border-top: 1px solid #d0d0d0;
}
.cannel {
	background-color: #f2f2f2;
	font-size: 28upx;
	height: 80upx;
	line-height: 80upx;
	color: #333;
	border-bottom-left-radius: 10upx;
	border-right: 1px solid #d0d0d0;
}
.comfirms {
	background-color: #f2f2f2;
	color: #40affe;
	font-size: 28upx;
	height: 80upx;
	line-height: 80upx;
	border-bottom-right-radius: 10upx;
}
.title {
	color: #333;
	line-height: 100upx;
	font-size: 16px;
}
</style>
