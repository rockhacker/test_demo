<template>
	<view class="swiper-container">
		<swiper @change="swiperChange" :current="currentIndex" previous-margin="45rpx"
			next-margin="45rpx" :style="[swiperHeight]" :autoplay="autoplay" :interval="interval"
			:duration="duration" :circular="true">
			<swiper-item style="border-radius: 20rpx;display: flex;justify-content: center;align-items: center;" v-for="(item, index) in imgList" :key="index"
				@click="swiperHandle(item,index)">
				<image :class="['swiper-image', currentIndex == index? 'active-image':'']" :src="item"
					mode="aspectFill"></image>
			</swiper-item>
		</swiper>
		<view v-if="isDots" class="dot-box">
			<view class="dot-list flex items-center">
				<view :class="['dot-item', index - 1 == currentIndex ? 'active-dot':'']"
					v-for="index in imgList.length" :key="index" @click="changeHandle(index - 1)">
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		name: "xlbsh-swiper",
		data() {
			return {
				currentIndex: 0
			};
		},
		props: {
			// 轮播图
			imgList: {
				type: Array,
				required: true
			},
			// 是否自动切换
			autoplay: {
				type: Boolean,
				default: true
			},
			// 滑动动画时长
			duration: {
				type: Number,
				default: 1000
			},
			// 自动切换时间间隔
			interval: {
				type: Number,
				default: 5000
			},
			// 是否显示指示点
			isDots: {
				type: Boolean,
				default: true
			},
			// 指示点颜色
			dotsColor: {
				type: String,
				default: 'rgba(73, 89, 117, 0.5)'
			},
			// 选中指示点颜色
			dotsActiveColor: {
				type: String,
				default: 'rgba(79, 230, 255, 1)'
			},
			// swiper高度
			height: {
				type: String,
				default: '344rpx'
			}
		},
		computed: {
			dotStyle() {
				return {
					backgroundColor: this.dotsColor,
					borderColor: this.dotsActiveColor
				}
			},
			currentDotStyle() {
				return {
					backgroundColor: this.dotsActiveColor
				}
			},
			swiperHeight() {
				return {
					height: this.height
				}
			}
		},
		methods: {
			swiperChange(e) {
				this.currentIndex = e.detail.current
			},
			changeHandle(i) {
				this.currentIndex = i;
			},
			swiperHandle(item, index) {
				this.$emit('select', {
					item,
					index
				})
			}
		}
	}
</script>

<style lang="scss" scoped>
	.swiper-container {
		padding: 20rpx 0;
	}
	.swiper-image {
		width: 100%;
		height: 90%;
		border-radius: 20rpx;
		transition: height 0.5s;
	}

	.active-image {
		width: 90%;
		height: 100%;
	}

	.dot-box {
		width: 100%;
		.dot-list {
			padding: 20rpx 0;
			display: flex;
			justify-content: center;

			.dot-item {
				background-color: rgba(73, 89, 117, .5);
				width: 16rpx;
				height: 16rpx;
				border-radius: 50%;
				margin-left: 20rpx;
			}

			.active-dot {
				width: 20rpx;
				height: 20rpx;
				background-color: rgba(79, 230, 255, 1);
			}

			.current-dot {
				width: 10rpx;
				height: 10rpx;
				border-radius: 50%;
			}
		}
	}
</style>
