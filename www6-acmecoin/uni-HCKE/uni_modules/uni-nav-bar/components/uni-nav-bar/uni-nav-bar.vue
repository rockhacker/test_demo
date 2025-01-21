<template>
	<view class="uni-navbar" :class="bgClass" >
		<view :class="{ 'uni-navbar--fixed': fixed, 'uni-navbar--shadow': shadow, 'uni-navbar--border': border}"
		 class="uni-navbar__content">
			<status-bar v-if="statusBar" />
			<view class="uni-navbar__header uni-navbar__content_view">
				<!-- <image v-if="backIcon" class="w-40 h-40 p-30" src="/static/images/icon/back.png" mode="aspectFit" @click="tapBack" /> -->
				<uni-icons v-if="backIcon" class="py-20 px-30 text-black dark:text-white" type="arrowleft" size="18" @click="tapBack" ></uni-icons>

				<view v-if="leftText" class="text-normal text-2xl whitespace-nowrap font-bold" :class="{'text-3xl': !backIcon,'pl-30': !backIcon}">
					{{leftText}}
				</view>

				<slot name="left" />
			
				<slot />
			
				<slot name="right" />
			</view>
		</view>
		<view class="uni-navbar__content opacity-0" v-if="fixed" ><status-bar v-if="statusBar" /><slot /></view>
	</view>
</template>

<script>
	import statusBar from "./uni-status-bar.vue";
	/**
	 * NavBar 自定义导航栏
	 * @description 导航栏组件，主要用于头部导航
	 * @property {String} backIcon 是否显示返回按钮
	 * @property {String} leftText 左侧按钮文本
	 * @property {Boolean} fixed = [true|false] 是否固定顶部
	 * @property {Boolean} statusBar = [true|false] 是否包含状态栏
	 * @property {Boolean} shadow = [true|false] 导航栏下是否有阴影
	 * @event {Function} tapBack 点击返回按钮时触发
	 */
	export default {
		name: "UniNavBar",
		components: {
			statusBar
		},
		props: {
			bgClass:{
				type:String,
				default: 'bg-white dark:bg-1C2532'
			},
			backIcon:{
				type: Boolean,
				default: false
			},
			leftText: {
				type: String,
				default: ""
			},
			fixed: {
				type: [Boolean, String],
				default: false
			},
			statusBar: {
				type: [Boolean, String],
				default: true
			},
			shadow: {
				type: [Boolean, String],
				default: false
			},
			border: {
				type: [Boolean, String],
				default: false
			},
			tapBack:{
				type: Function,
				default: () => {
					uni.navigateBack();
				}
			}
		}
	};
</script>

<style lang="scss" scoped>
	$nav-height: 50px;

	.uni-navbar__content {
		position: relative;
	}

	.uni-navbar__content_view {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		align-items: center;
		flex-direction: row;
		// background-color: #FFFFFF;
	}

	.uni-navbar__header {
		/* #ifndef APP-NVUE */
		display: flex;
		/* #endif */
		flex-direction: row;
		min-height: $nav-height;
		align-items: center;
	}


	.uni-navbar__placeholder-view {
		min-height: $nav-height;
	}

	.uni-navbar--fixed {
		width: 100%;
		box-sizing: border-box;
		position: fixed;
		z-index: 99;
	}

	.uni-navbar--shadow {
		box-shadow: 0 1px 6px #1A031F;
	}

	.uni-navbar--border {
		border-bottom-width: 1rpx;
		border-bottom-style: solid;
		border-bottom-color: $uni-border-color;
	}
</style>
